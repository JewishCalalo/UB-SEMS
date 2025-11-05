<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Equipment;
use App\Models\ReservationItem;
use App\Models\ReservationItemInstance;
use App\Models\EquipmentInstance;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Reservations\ReservationStoreRequest;
use App\Http\Requests\Reservations\ReservationUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;
use App\Rules\UbaguioEmail;
use App\Services\NotificationService;
use App\Services\ReservationStatusService;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware only to protected methods
        $this->middleware('auth')->only([
            'index', 'create', 'show', 'edit', 'update', 'destroy'
        ]);
        // Note: 'store' and 'confirmation' methods are intentionally excluded to allow guest reservations
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isManager() || $user->isAdmin()) {
            // Managers and admins see all reservations
            $query = Reservation::with('user', 'items.equipment', 'approvedBy');
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            $reservations = $query->latest()->paginate(10);
        } else {
            // Regular users see only their own reservations
            $query = $user->reservations()->with('items.equipment', 'approvedBy');
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            $reservations = $query->latest()->paginate(10);
        }

        return view('user.reservations.index', compact('reservations'));
    }



    public function create()
    {
        $equipment = Equipment::where('is_active', true)
            ->with(['category', 'equipmentType', 'instances'])
            ->get()
            ->filter(function($equipment) {
                return $equipment->quantity_available > 0;
            });

        $categories = \App\Models\EquipmentCategory::orderBy('name')->get();
        $equipmentTypes = \App\Models\EquipmentType::orderBy('name')->get();

        return view('user.reservations.create', compact('equipment', 'categories', 'equipmentTypes'));
    }

    public function checkDuplicate(Request $request)
    {
        $email = $request->input('email');
        $borrowDate = $request->input('borrow_date');
        $returnDate = $request->input('return_date');
        $borrowTime = $request->input('borrow_time');
        $returnTime = $request->input('return_time');
        $reason = $request->input('reason');
        $cartData = $request->input('cart_data');

        // Parse cart data
        $cartItems = json_decode($cartData, true);
        if (!is_array($cartItems)) { 
            $cartItems = []; 
        }

        // If critical fields are missing, treat as non-duplicate but do not error
        if (empty($email) || empty($borrowDate) || empty($returnDate) || empty($borrowTime) || empty($returnTime) || empty($reason)) {
            return response()->json([
                'is_duplicate' => false,
                'message' => 'Insufficient data provided to determine duplicates.'
            ]);
        }

        // Prefer signature-based detection for exact parity with store() flow
        $useSignature = \Schema::hasColumn('reservations', 'signature');
        if ($useSignature) {
            $pairs = collect($cartItems)
                ->map(fn($i) => ($i['equipment_id'] ?? $i['id']).':'.($i['quantity'] ?? 1))
                ->sort()->values()->toArray();
            $department = $request->input('department');
            $departmentOther = $request->input('department_other');
            $finalDepartment = ($department === 'Other' && $departmentOther) ? $departmentOther : $department;
            
            $payload = implode('|', [
                strtolower($email),
                $borrowDate,
                $borrowTime,
                $returnDate,
                $returnTime,
                mb_strtolower($reason),
                mb_strtolower($finalDepartment),
                implode(';', $pairs)
            ]);
            $signature = hash('sha256', $payload);

            $exists = \App\Models\Reservation::where('signature', $signature)
                ->whereIn('status', ['pending','approved','picked_up','completed'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'is_duplicate' => true,
                    'message' => 'You already have a similar reservation with the same equipment, dates, times, and reason.'
                ]);
            }
            // Fall through to normalized comparison below in case older reservations were created without signature
        }

        // Fallback normalized comparison (including items and quantities) when signature is missing
        $candidates = \App\Models\Reservation::whereRaw('LOWER(email) = ?', [mb_strtolower($email)])
            ->whereDate('borrow_date', $borrowDate)
            ->whereDate('return_date', $returnDate)
            // Do not filter by times here to tolerate missing times on older entries
            ->whereIn('status', ['pending', 'approved', 'picked_up', 'completed'])
            ->with('items')
            ->get();

        foreach ($candidates as $candidate) {
            // Case-insensitive reason compare (match instructor parity)
            $reasonMatches = mb_strtolower((string) $candidate->reason) === mb_strtolower((string) $reason);
            if (!$reasonMatches) { continue; }

            // Compare equipment+quantity pairs
            $existingPairs = collect($candidate->items)
                ->map(fn($i) => $i['equipment_id'].':'.($i['quantity_requested'] ?? $i['quantity'] ?? 1))
                ->sort()->values()->toArray();
            $newPairs = collect($cartItems)
                ->map(fn($i) => ($i['equipment_id'] ?? $i['id']).':'.($i['quantity'] ?? 1))
                ->sort()->values()->toArray();

            if ($existingPairs === $newPairs) {
                return response()->json([
                    'is_duplicate' => true,
                    'message' => 'You already have a similar reservation with the same equipment (and quantities), dates, and reason.'
                ]);
            }
        }

        return response()->json([
            'is_duplicate' => false,
            'message' => 'No duplicate reservation found.'
        ]);
    }

    public function store(ReservationStoreRequest $request)
    {
        // Log the incoming request for debugging
        Log::info('Reservation request received', [
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
            'user' => Auth::user(),
            'session_id' => session()->getId(),
            'is_authenticated' => Auth::check()
        ]);

        try {
            // Check for missing equipment before validation
            $email = $request->input('email');
            if ($email) {
                $hasOutstanding = \App\Models\MissingEquipment::where('borrower_email', $email)
                    ->whereIn('replacement_status', ['pending', 'not_replaced'])
                    ->exists();
                
                if ($hasOutstanding) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You have unresolved missing/lost equipment. Please settle the replacement before making a new reservation.',
                            'error_type' => 'missing_equipment'
                        ], 422);
                    }
                    return back()->withErrors(['email' => 'You have unresolved missing/lost equipment. Please settle the replacement before making a new reservation.'])->withInput();
                }
            }

            // Use signature-based duplicate detection if available
            $useSignature = \Schema::hasColumn('reservations', 'signature');
            if ($useSignature && !$request->has('proceed_with_duplicate')) {
                $cartItems = json_decode($request->input('cart_data'), true);
                if (is_array($cartItems)) {
                    $pairs = collect($cartItems)
                        ->map(fn($i) => ($i['equipment_id'] ?? $i['id']).':'.($i['quantity'] ?? 1))
                        ->sort()->values()->toArray();
                    $department = $request->input('department');
                    $departmentOther = $request->input('department_other');
                    $finalDepartment = ($department === 'Other' && $departmentOther) ? $departmentOther : $department;
                    
                    $payload = implode('|', [
                        strtolower($email),
                        $request->input('borrow_date'),
                        $request->input('borrow_time'),
                        $request->input('return_date'),
                        $request->input('return_time'),
                        mb_strtolower($request->input('reason')),
                        mb_strtolower($finalDepartment),
                        implode(';', $pairs)
                    ]);
                    $signature = hash('sha256', $payload);

                    $existingSignatureReservation = \App\Models\Reservation::where('signature', $signature)
                        ->whereIn('status', ['pending', 'approved', 'picked_up', 'completed'])
                        ->first();
                    
                    if ($existingSignatureReservation) {
                        if ($request->ajax()) {
                            return response()->json([
                                'success' => false,
                                'error_type' => 'duplicate_detected',
                                'message' => 'You already have a similar reservation with the same equipment, dates, times, and reason.'
                            ]);
                        }
                        return redirect()->back()->with('error', 'Duplicate reservation detected.');
                    }
                }
            }
            
            // Legacy duplicate check (fallback when signature not available)
            if (!$useSignature && $email && !$request->has('proceed_with_duplicate')) {
                $existingReservation = \App\Models\Reservation::where('email', $email)
                    ->where('borrow_date', $request->input('borrow_date'))
                    ->where('return_date', $request->input('return_date'))
                    ->where('reason', $request->input('reason'))
                    ->whereIn('status', ['pending', 'approved', 'picked_up'])
                    ->first();
                
                if ($existingReservation) {
                    // Check if it's the same equipment
                    $cartItems = json_decode($request->input('cart_data'), true);
                    if (is_array($cartItems)) {
                        $existingEquipmentIds = $existingReservation->items->pluck('equipment_id')->sort()->toArray();
                        $newEquipmentIds = collect($cartItems)->pluck('equipment_id')->sort()->toArray();
                        
                        // Debug logging
                        \Log::info('Duplicate reservation check', [
                            'email' => $email,
                            'existing_equipment_ids' => $existingEquipmentIds,
                            'new_equipment_ids' => $newEquipmentIds,
                            'is_duplicate' => $existingEquipmentIds === $newEquipmentIds
                        ]);
                        
                        if ($existingEquipmentIds === $newEquipmentIds) {
                            if ($request->expectsJson()) {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'You already have a similar reservation with the same equipment, dates, and reason.',
                                    'error_type' => 'duplicate_reservation',
                                    'existing_reservation' => $existingReservation
                                ], 422);
                            }
                            return back()->withErrors(['email' => 'You already have a similar reservation with the same equipment, dates, and reason.'])->withInput();
                        }
                    }
                }
            }
            
            $validated = $request->validated();


            // Parse cart data (be tolerant to double-encoded or malformed inputs)
            $cartItems = json_decode($validated['cart_data'], true);
            if (!is_array($cartItems)) {
                // Try to strip slashes (common when JSON got escaped by the client)
                $cartItems = json_decode(stripslashes($validated['cart_data']), true);
            }
            if (!is_array($cartItems)) {
                // As a last resort, wrap single item shape to array if it looks like an object
                $maybeObject = json_decode($validated['cart_data'], true);
                if (is_array($maybeObject) && isset($maybeObject['equipment_id'])) {
                    $cartItems = [$maybeObject];
                }
            }
            
            // Normalize items (handle elements that are JSON strings)
            if (is_array($cartItems)) {
                $normalized = [];
                foreach ($cartItems as $item) {
                    if (is_string($item)) {
                        $decodedItem = json_decode($item, true);
                        if (is_array($decodedItem)) {
                            $item = $decodedItem;
                        }
                    }
                    if (is_array($item) && isset($item['equipment_id']) && isset($item['quantity'])) {
                        $normalized[] = $item;
                    }
                }
                $cartItems = $normalized;
            }

            if (empty($cartItems) || !is_array($cartItems)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No valid items found in cart',
                        'errors' => ['cart' => ['No valid items found in cart']]
                    ], 422);
                }
                return back()->withErrors(['cart' => 'No valid items found in cart'])->withInput();
            }

            DB::beginTransaction();
            try {
                // Log the data being created
                Log::info('Creating reservation with data', [
                    'validated_data' => $validated,
                    'user_id' => Auth::id()
                ]);

                // Handle department field - use department_other if "Other" is selected
                $finalDepartment = $validated['department'];
                if ($validated['department'] === 'Other' && !empty($validated['department_other'])) {
                    $finalDepartment = $validated['department_other'];
                }

                // Create reservation data array
                $reservationData = [
                    'user_id' => Auth::id() ?? null,
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'contact_number' => $validated['contact_number'],
                    'department' => $finalDepartment,
                    'borrow_date' => $validated['borrow_date'],
                    'return_date' => $validated['return_date'],
                    'borrow_time' => $validated['borrow_time'] ?? null,
                    'return_time' => $validated['return_time'] ?? null,
                    'reason' => $validated['reason'],
                    'additional_details' => $validated['additional_details'],
                    'status' => 'pending',
                    'reservation_code' => 'RES-' . strtoupper(str()->random(8)),
                ];

                // Add signature if column exists and not proceeding with duplicate
                if (\Schema::hasColumn('reservations', 'signature') && !$request->has('proceed_with_duplicate')) {
                    $pairs = collect($cartItems)
                        ->map(fn($i) => ($i['equipment_id'] ?? $i['id']).':'.($i['quantity'] ?? 1))
                        ->sort()->values()->toArray();
                    
                    $payload = implode('|', [
                        strtolower($validated['email']),
                        $validated['borrow_date'],
                        $validated['borrow_time'],
                        $validated['return_date'],
                        $validated['return_time'],
                        mb_strtolower($validated['reason']),
                        mb_strtolower($finalDepartment),
                        implode(';', $pairs)
                    ]);
                    $reservationData['signature'] = hash('sha256', $payload);
                }

                // Create reservation
                $reservation = Reservation::create($reservationData);


                Log::info('Reservation created successfully', [
                    'reservation_id' => $reservation->id,
                    'reservation_code' => $reservation->reservation_code
                ]);

                // Create reservation items and assign equipment instances
                foreach ($cartItems as $item) {
                    if (!is_array($item)) {
                        throw new \RuntimeException('Cart item is not a valid object');
                    }
                    $equipment = Equipment::find($item['equipment_id']);
                    $quantityRequested = $item['quantity'];
                    
                    // Check if enough instances are available for the specific dates
                    $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                        $quantityRequested,
                        $validated['borrow_date'],
                        $validated['return_date']
                    );
                    
                    if (!$availabilityCheck['available']) {
                        DB::rollBack();
                        if ($request->expectsJson()) {
                            return response()->json([
                                'success' => false,
                                'message' => "Cannot create reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available for the selected dates, but {$quantityRequested} requested.",
                                'errors' => ['cart' => ["Cannot create reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available for the selected dates, but {$quantityRequested} requested."]]
                            ], 422);
                        }
                        return back()->withErrors([
                            'cart' => "Cannot create reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available for the selected dates, but {$quantityRequested} requested."
                        ])->withInput();
                    }
                    
                    // Create reservation item
                    $reservationItem = ReservationItem::create([
                        'reservation_id' => $reservation->id,
                        'equipment_id' => $item['equipment_id'],
                        'quantity_requested' => $quantityRequested,
                        'quantity_approved' => 0,
                    ]);
                    
                    // Note: We don't assign instances yet for pending reservations
                    // Instances will be assigned when the reservation is approved
                    // This prevents the "0 instances" issue and ensures proper availability tracking
                    
                    Log::info('Reservation item created (pending)', [
                        'reservation_item_id' => $reservationItem->id,
                        'equipment_id' => $equipment->id,
                        'equipment_name' => $equipment->display_name,
                        'quantity_requested' => $quantityRequested,
                        'current_quantity_available' => $equipment->quantity_available
                    ]);
                }

                // Clear cart session
                if (session()->has('reservation_cart')) {
                    session()->forget('reservation_cart');
                }

                DB::commit();

                // Create notification for reservation creation (after commit)
                NotificationService::createReservationCreatedNotification($reservation);

                Log::info('Reservation completed successfully', [
                    'reservation_id' => $reservation->id,
                    'redirecting_to' => 'reservations.confirmation',
                    'is_authenticated' => Auth::check(),
                    'user_id' => Auth::id()
                ]);

                // Generate and send 6-digit email verification code for guests
                if (!$reservation->user_id && $reservation->email) {
                    try {
                        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                        // Persist to temporary cache keyed by reservation id
                        cache()->put('reservation_otp_'.$reservation->id, [
                            'hash' => hash('sha256', $code),
                            'expires_at' => now()->addMinutes(15)
                        ], 900);
                        \Mail::send('emails.guest-otp', [
                            'code' => $code,
                            'name' => $reservation->name,
                            'expiresIn' => 15,
                        ], function($m) use ($reservation) {
                            $m->to($reservation->email)->subject('SEMS Reservation Verification Code');
                        });
                    } catch (\Exception $e) {
                        \Log::error('Failed to send verification code', ['error' => $e->getMessage()]);
                    }
                }

                // Check if this is an AJAX request
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Reservation submitted successfully! Your reservation code is: ' . $reservation->reservation_code,
                        'reservation_code' => $reservation->reservation_code,
                        'redirect_url' => route('reservations.verify', $reservation)
                    ]);
                }

                // For guest users, redirect to a guest confirmation page
                if (!Auth::check()) {
                    Log::info('Redirecting guest user to guest confirmation', [
                        'reservation_id' => $reservation->id
                    ]);
                    return redirect()->route('reservations.verify', $reservation)
                        ->with('success', 'Reservation submitted successfully! Your reservation code is: ' . $reservation->reservation_code . '. Please save this code for tracking your reservation.');
                }

                Log::info('Redirecting authenticated user to confirmation', [
                    'reservation_id' => $reservation->id,
                    'user_id' => Auth::id()
                ]);
                return redirect()->route('reservations.verify', $reservation)
                    ->with('success', 'Reservation submitted successfully! Your reservation code is: ' . $reservation->reservation_code . '. You will receive an email confirmation shortly.');

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Reservation creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'request_data' => $request->all()
                ]);
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create reservation: ' . $e->getMessage()
                    ], 500);
                }
                
                return back()->withErrors(['error' => 'Failed to create reservation: ' . $e->getMessage()])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Reservation validation failed', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Unexpected error in reservation creation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred. Please try again.'
                ], 500);
            }
            
            return back()->withErrors(['error' => 'An unexpected error occurred. Please try again.'])->withInput();
        }
    }

    public function show(Reservation $reservation)
    {
        // Allow viewing if user owns the reservation or is staff
        if (!Auth::check() || (!Auth::user()->hasAnyRole(['manager', 'admin']) && Auth::id() !== $reservation->user_id)) {
            abort(403);
        }

        $reservation->load([
            'user', 
            'createdBy',
            'items.equipment.category', 
            'items.equipment.equipmentType',
            'items.reservationItemInstances.equipmentInstance', 
            'approvedBy'
        ]);

        return view('user.reservations.show', compact('reservation'));
    }

    public function confirmation(Reservation $reservation)
    {
        // Allow viewing if user owns the reservation or is staff
        // For authenticated users, check ownership
        if (Auth::check()) {
            if (!Auth::user()->hasAnyRole(['manager', 'admin']) && Auth::id() !== $reservation->user_id) {
                abort(403);
            }
        } else {
            // For guest users, we need to verify they have access to this reservation
            // This could be done via session or reservation code verification
            // For now, we'll allow access but this should be enhanced for security
        }

        return view('user.reservations.confirmation', compact('reservation'));
    }

    public function guestConfirmation($reservationId)
    {
        // Find the reservation by ID
        $reservation = Reservation::findOrFail($reservationId);
        
        // For guest confirmations, we don't need to verify ownership since they don't have accounts
        return view('user.reservations.guest-confirmation', compact('reservation'));
    }

    public function verifyForm(\App\Models\Reservation $reservation)
    {
        return view('user.reservations.verify', compact('reservation'));
    }

    public function verifySubmit(\Illuminate\Http\Request $request, \App\Models\Reservation $reservation)
    {
        $request->validate(['code' => 'required|string|size:6']);
        $entry = cache()->get('reservation_otp_'.$reservation->id);
        if (!$entry || ($entry['expires_at'] ?? now()->subMinute())->lt(now()) ) {
            return back()->withErrors(['code' => 'Verification code expired. Please request a new code.']);
        }
        $isValid = hash_equals($entry['hash'] ?? '', hash('sha256', $request->input('code')));
        if (!$isValid) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }
        // Mark verified (store timestamp if column exists)
        if (\Schema::hasColumn('reservations', 'email_verified_at')) {
            $reservation->email_verified_at = now();
            $reservation->save();
        }
        cache()->forget('reservation_otp_'.$reservation->id);
        return redirect()->route('reservations.guest-confirmation', $reservation->id)
            ->with('success', 'Email verified successfully. Your reservation is pending approval.');
    }

    // New guest-first verification flow (no reservation created until OTP verified)
    public function initiate(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact_number' => 'required|string|max:20',
            'department' => 'required|string|max:255',
            'department_other' => 'nullable|string|max:255',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'borrow_time' => 'nullable|string',
            'return_time' => 'nullable|string',
            'reason_type' => 'nullable|string',
            'reason' => 'required|string',
            'additional_details' => 'nullable|string',
            'cart_data' => 'required|string',
        ]);

        $token = bin2hex(random_bytes(16));
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        cache()->put('pending_res_'.$token, [
            'payload' => $data,
            'hash' => hash('sha256', $code),
            'expires_at' => now()->addMinutes(15)
        ], 900);

        try {
            \Mail::send('emails.guest-otp', [
                'code' => $code,
                'name' => $data['name'] ?? null,
                'expiresIn' => 15,
            ], function($m) use ($data) {
                $m->to($data['email'])->subject('SEMS Reservation Verification Code');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send verification code', ['error' => $e->getMessage()]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('reservations.verify-guest', ['token' => $token])
            ]);
        }
        return redirect()->route('reservations.verify-guest', ['token' => $token]);
    }

    public function verifyGuestForm(\Illuminate\Http\Request $request)
    {
        $token = $request->query('token');
        $entry = $token ? cache()->get('pending_res_'.$token) : null;
        if (!$entry) {
            return redirect()->route('welcome')->with('error', 'Verification session expired. Please start again.');
        }
        $email = $entry['payload']['email'] ?? null;
        return view('user.reservations.verify-guest', compact('token', 'email'));
    }

    public function verifyGuestSubmit(\Illuminate\Http\Request $request)
    {
        $request->validate(['token' => 'required', 'code' => 'required|string|size:6']);
        $token = $request->input('token');
        $entry = cache()->get('pending_res_'.$token);
        if (!$entry || ($entry['expires_at'] ?? now()->subMinute())->lt(now())) {
            return back()->withErrors(['code' => 'Verification code expired. Please request a new code.']);
        }
        if (!hash_equals($entry['hash'] ?? '', hash('sha256', $request->input('code')))) {
            return back()->withErrors(['code' => 'Invalid verification code.']);
        }

        // Create reservation now using existing logic (similar to store)
        $payload = $entry['payload'];
        $finalDepartment = ($payload['department'] === 'Other' && !empty($payload['department_other'])) ? $payload['department_other'] : $payload['department'];

        DB::beginTransaction();
        try {
            $reservation = \App\Models\Reservation::create([
                'user_id' => null,
                'name' => $payload['name'],
                'email' => $payload['email'],
                'contact_number' => $payload['contact_number'],
                'department' => $finalDepartment,
                'borrow_date' => $payload['borrow_date'],
                'return_date' => $payload['return_date'],
                'borrow_time' => $payload['borrow_time'] ?? null,
                'return_time' => $payload['return_time'] ?? null,
                'reason' => $payload['reason'],
                'additional_details' => $payload['additional_details'] ?? null,
                'status' => 'pending',
                'reservation_code' => 'RES-' . strtoupper(str()->random(8)),
            ]);

            // Create items
            $cartItems = json_decode($payload['cart_data'], true) ?: [];
            foreach ($cartItems as $item) {
                if (!is_array($item)) continue;
                \App\Models\ReservationItem::create([
                    'reservation_id' => $reservation->id,
                    'equipment_id' => $item['equipment_id'],
                    'quantity_requested' => $item['quantity'],
                    'quantity_approved' => 0,
                    'status' => 'pending'
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['code' => 'Failed to complete reservation. '.$e->getMessage()]);
        }

        cache()->forget('pending_res_'.$token);
        return redirect()->route('reservations.guest-confirmation', $reservation->id)
            ->with('success', 'Reservation submitted successfully.');
    }

    public function edit(Reservation $reservation)
    {
        // Check if user can edit (manager/admin or owner)
        if (!Auth::user()->hasAnyRole(['manager', 'admin']) && Auth::id() !== $reservation->user_id) {
            abort(403);
        }
        
        $equipment = Equipment::where('is_active', true)->get();
        return view('user.reservations.edit', compact('reservation', 'equipment'));
    }

    public function update(ReservationUpdateRequest $request, Reservation $reservation)
    {
        // Check if user can update (manager/admin or owner)
        if (!Auth::user()->hasAnyRole(['manager', 'admin']) && Auth::id() !== $reservation->user_id) {
            abort(403);
        }

        // Log the request for debugging
        Log::info('Reservation update request', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role,
            'reservation_id' => $reservation->id,
            'current_status' => $reservation->status,
            'requested_status' => $request->status,
            'request_data' => $request->all()
        ]);

        $validated = $request->validated();

        // Only managers/admins can change status
        if (in_array($validated['status'], ['approved', 'denied', 'picked_up', 'returned', 'completed'])) {
            if (!Auth::user()->hasAnyRole(['manager', 'admin'])) {
                abort(403);
            }
            
            // Use centralized status update service for managers/admins
            try {
                $result = ReservationStatusService::updateStatus(
                    $reservation,
                    $validated['status'],
                    [
                        'remarks' => $validated['remarks'] ?? null,
                        'pickup_date' => $validated['pickup_date'] ?? null
                    ],
                    Auth::id()
                );
                
                return redirect()->route('reservations.index')
                    ->with('success', $result['message']);
                    
            } catch (\InvalidArgumentException $e) {
                return redirect()->back()->withErrors(['status' => $e->getMessage()]);
            } catch (\Exception $e) {
                Log::error('Failed to update reservation status', [
                    'reservation_id' => $reservation->id,
                    'error' => $e->getMessage()
                ]);
                return redirect()->back()->withErrors(['error' => 'Failed to update reservation status. Please try again.']);
            }
        }

        // Log before update
        Log::info('Updating reservation', [
            'reservation_id' => $reservation->id,
            'validated_data' => $validated
        ]);

        $oldStatus = $reservation->status;
        $reservation->update($validated);

        // Update equipment availability and assign instances based on status (only for managers/admins)
        if (Auth::user()->hasAnyRole(['manager', 'admin'])) {
            if ($validated['status'] === 'approved') {
                foreach ($reservation->items as $item) {
                    $equipment = $item->equipment;
                    // No need to decrement quantity_available since it's computed from instances
                }
            } elseif ($validated['status'] === 'picked_up') {
                // Assign concrete equipment instances for each requested quantity with double booking prevention
                foreach ($reservation->items as $item) {
                    // Prevent double assignment
                    if ($item->instances()->exists()) {
                        continue;
                    }
                    
                    $quantityToAssign = $item->quantity_requested;
                    
                    // Use helper method for atomic instance reservation
                    $reservationResult = $item->equipment->reserveInstances($quantityToAssign);
                    
                    if (!$reservationResult['success']) {
                        DB::rollBack();
                        return back()->withErrors(['error' => $reservationResult['message']]);
                    }
                    
                    // Assign the reserved instances
                    foreach ($reservationResult['instances'] as $instance) {
                        // Double-check availability before assignment (in case of concurrent updates)
                        if (!$instance->is_available || !$instance->is_active) {
                            DB::rollBack();
                            return back()->withErrors(['error' => 'Equipment instance became unavailable during assignment. Please try again.']);
                        }
                        
                        // Create the reservation-instance link
                        ReservationItemInstance::create([
                            'reservation_item_id' => $item->id,
                            'equipment_instance_id' => $instance->id,
                            'status' => 'picked_up',
                            'picked_up_at' => now(),
                        ]);
                        
                        // Lock the instance from others
                        $instance->update(['is_available' => false]);
                    }
                    
                    // No need to recalculate since quantities are computed from instances
                }
            } elseif ($validated['status'] === 'returned') {
                // Mark as returned but keep equipment instances reserved until completion
                $reservation->update(['returned_at' => now()]);
                
            } elseif ($validated['status'] === 'completed') {
                // Restore equipment availability for completed reservations
                foreach ($reservation->items as $item) {
                    foreach ($item->instances as $instance) {
                        // Only restore availability if the instance is not damaged/needs repair
                        if (!in_array($instance->condition, ['damaged', 'needs_repair'])) {
                            $instance->update(['is_available' => true]);
                        }
                    }
                }
                $reservation->update(['completed_at' => now()]);
            } elseif ($validated['status'] === 'denied') {
                // If denying an approved or picked_up reservation, restore any reserved instances
                if (in_array($oldStatus, ['approved', 'picked_up'])) {
                    foreach ($reservation->items as $item) {
                        // Get all reservation item instances for this item
                        $reservationItemInstances = $item->instances;
                        
                        if ($reservationItemInstances->count() > 0) {
                            foreach ($reservationItemInstances as $reservationItemInstance) {
                                // Get the actual equipment instance
                                $equipmentInstance = $reservationItemInstance->equipmentInstance;
                                
                                if ($equipmentInstance) {
                                    // Mark equipment instance as available again
                                    $equipmentInstance->update(['is_available' => true]);
                                    
                                    Log::info('Equipment instance restored to available after deny', [
                                        'instance_id' => $equipmentInstance->id,
                                        'instance_code' => $equipmentInstance->instance_code,
                                        'reservation_id' => $reservation->id
                                    ]);
                                }
                            }
                            
                            // Remove the reservation-instance links
                            $item->instances()->delete();
                        }
                    }
                    
                    Log::info('Equipment instances restored to available status after deny', [
                        'reservation_id' => $reservation->id,
                        'items_count' => $reservation->items->count()
                    ]);
                }
            }
        }

        // Create notification if status changed and user is authenticated or guest has email
        if ($oldStatus !== $validated['status'] && ($reservation->user_id || $reservation->email)) {
            NotificationService::createReservationStatusNotification(
                $reservation, 
                $validated['status'], 
                $validated['remarks'] ?? null
            );
        }

        $statusMessage = 'Reservation ' . $validated['status'] . ' successfully';
        if (Auth::user()->hasAnyRole(['manager', 'admin'])) {
            if ($validated['status'] === 'approved') {
                $statusMessage .= '. Equipment availability has been updated.';
            } elseif ($validated['status'] === 'denied') {
                $statusMessage .= '. Equipment availability has been restored.';
            }
        }

        // Log success
        Log::info('Reservation updated successfully', [
            'reservation_id' => $reservation->id,
            'new_status' => $validated['status']
        ]);

        return redirect()->route('reservations.index')
            ->with('success', $statusMessage);
    }

    /**
     * Instructor updates dates/times for their own pending reservation
     */
    public function updateDates(\Illuminate\Http\Request $request, Reservation $reservation)
    {
        if (!\Auth::check() || (\Auth::id() !== $reservation->user_id)) {
            abort(403);
        }
        if ($reservation->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending reservations can be edited.'], 422);
        }

        $validated = $request->validate([
            'borrow_date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
            'return_date' => ['required', 'date', 'after_or_equal:borrow_date', function($attr,$val,$fail) use ($request){
                try { $max = \Carbon\Carbon::parse($request->input('borrow_date'))->addDays(7)->toDateString(); }
                catch(\Exception $e){ $max = null; }
                if ($max && $val > $max) { $fail('Return date must be within 7 days of borrow date.'); }
            }],
            'borrow_time' => ['nullable','date_format:H:i'],
            'return_time' => ['nullable','date_format:H:i'],
        ]);

        // Optional time window validation 08:00–17:00 and 30-min same-day rule
        $toMinutes = function($t){ if(!$t) return null; [$h,$m] = explode(':',$t); return ((int)$h)*60 + ((int)$m); };
        $bm = $toMinutes($validated['borrow_time'] ?? null);
        $rm = $toMinutes($validated['return_time'] ?? null);
        $MIN = 8*60; $MAX = 17*60;
        if ($bm !== null && ($bm < $MIN || $bm > $MAX)) {
            return response()->json(['success'=>false,'message'=>'Borrow time must be between 8:00 and 17:00.'], 422);
        }
        if ($rm !== null && ($rm < $MIN || $rm > $MAX)) {
            return response()->json(['success'=>false,'message'=>'Return time must be between 8:00 and 17:00.'], 422);
        }
        if ($bm !== null && $rm !== null && $validated['borrow_date'] === $validated['return_date'] && $rm - $bm < 30) {
            return response()->json(['success'=>false,'message'=>'Same-day returns must be at least 30 minutes after borrow time.'], 422);
        }

        $reservation->update([
            'borrow_date' => $validated['borrow_date'],
            'return_date' => $validated['return_date'],
            'borrow_time' => $validated['borrow_time'] ?? null,
            'return_time' => $validated['return_time'] ?? null,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Data for instructor edit modal: items, availability, and current dates/times
     */
    public function instructorEditData(Reservation $reservation)
    {
        if (!\Auth::check() || (\Auth::id() !== $reservation->user_id)) {
            abort(403);
        }
        if ($reservation->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending reservations can be edited.'], 422);
        }

        $reservation->load(['items.equipment']);

        $items = $reservation->items->map(function($i){
            $label = trim(($i->equipment->brand ?? '') . ' ' . ($i->equipment->model ?? ''));
            if ($label === '') { $label = $i->equipment->name ?? 'Equipment'; }
            return [
                'id' => $i->id,
                'equipment_id' => $i->equipment_id,
                'equipment' => $label,
                'qty' => $i->quantity_requested,
            ];
        })->values()->all();

        // Build availability list for all active equipment
        $equipments = \App\Models\Equipment::with(['category'])->where('is_active', true)->get();
        $equipmentList = [];
        foreach ($equipments as $eq) {
            if (method_exists($eq, 'hasAvailableInstancesForDates')) {
                $check = $eq->hasAvailableInstancesForDates(1, $reservation->borrow_date, $reservation->return_date, $reservation->id);
                $availableCount = $check['available_count'] ?? 0;
            } else {
                $availableCount = 0;
            }
            $label = trim(($eq->brand ?? '') . ' ' . ($eq->model ?? ''));
            if ($label === '') { $label = $eq->display_name ?? ($eq->name ?? ('Equipment #'.$eq->id)); }
            $equipmentList[] = [
                'id' => $eq->id,
                'label' => $label,
                'category' => optional($eq->category)->name,
                'available' => $availableCount,
            ];
        }

        return response()->json([
            'success' => true,
            'reservation' => [
                'id' => $reservation->id,
                'code' => $reservation->reservation_code,
                'borrow_date' => optional($reservation->borrow_date)->format('Y-m-d'),
                'return_date' => optional($reservation->return_date)->format('Y-m-d'),
                'borrow_time' => $reservation->borrow_time,
                'return_time' => $reservation->return_time,
            ],
            'items' => $items,
            'equipmentList' => $equipmentList,
        ]);
    }

    public function destroy(Reservation $reservation)
    {
        // Only allow deletion if user owns the reservation or is staff
        if (!Auth::user()->hasAnyRole(['manager', 'admin']) && Auth::id() !== $reservation->user_id) {
            abort(403);
        }
        
        $reservation->delete();
        return redirect()->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully');
    }

    // Guest reservation tracking
    public function track(Request $request)
    {
        $reservation = null;
        $error = null;

        if ($request->filled('reservation_code')) {
            $reservation = Reservation::where('reservation_code', $request->reservation_code)
                ->with(['user', 'items.equipment', 'approvedBy'])
                ->first();

            if (!$reservation) {
                $error = 'Reservation not found with the provided code.';
            }
        }

        $equipmentList = null;
        if ($reservation) {
            $equipmentList = \App\Models\Equipment::where('is_active', true)
                ->with('category')
                ->get(['id','brand','model','description','category_id','is_active'])
                ->map(function($e) use ($reservation) {
                    $label = trim(($e->brand ?? '').' '.($e->model ?? '')); 
                    $available = method_exists($e, 'getBookableCount')
                        ? $e->getBookableCount($reservation->borrow_date->toDateString(), $reservation->return_date->toDateString(), $reservation->id)
                        : max(0, (int) ($e->quantity_available ?? 0));
                    return [
                        'id' => $e->id,
                        'label' => $label ?: ($e->description ? substr($e->description,0,40) : ('Equipment #'.$e->id)),
                        'available' => $available,
                        'category' => optional($e->category)->name,
                    ];
                });
        }
        return view('user.reservations.track', compact('reservation', 'error', 'equipmentList'));
    }

    // Cancel reservation
    public function cancel(Request $request, $reservationId)
    {
        try {
            // Find the reservation manually
            $reservation = Reservation::find($reservationId);
            
            if (!$reservation) {
                Log::error('Reservation not found', [
                    'reservation_id' => $reservationId,
                    'request_data' => $request->all()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Reservation not found.'
                ], 404);
            }

            // Log the incoming request for debugging
            Log::info('Cancel reservation request received', [
                'reservation_id' => $reservation->id,
                'reservation_status' => $reservation->status,
                'request_data' => $request->all()
            ]);

            // Check if reservation can be cancelled (pending, approved, or picked_up reservations)
            if (!in_array($reservation->status, ['pending', 'approved', 'picked_up'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'This reservation cannot be cancelled in its current status.'
                ], 400);
            }

            // Start transaction
            DB::beginTransaction();

            // Store the original status before updating
            $originalStatus = $reservation->status;

            // Update reservation status
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now()
            ]);

            // Restore equipment instances to available status if they were assigned
            if (in_array($originalStatus, ['approved', 'picked_up'])) {
                foreach ($reservation->items as $item) {
                    // Get all reservation item instances for this item
                    $reservationItemInstances = $item->instances;
                    
                    if ($reservationItemInstances->count() > 0) {
                        foreach ($reservationItemInstances as $reservationItemInstance) {
                            // Get the actual equipment instance
                            $equipmentInstance = $reservationItemInstance->equipmentInstance;
                            
                            if ($equipmentInstance) {
                                // Mark equipment instance as available again
                                $equipmentInstance->update(['is_available' => true]);
                                
                                Log::info('Equipment instance restored to available', [
                                    'instance_id' => $equipmentInstance->id,
                                    'instance_code' => $equipmentInstance->instance_code,
                                    'reservation_id' => $reservation->id
                                ]);
                            }
                        }
                        
                        // Remove the reservation-instance links
                        $item->instances()->delete();
                    }
                }
                
                Log::info('Equipment instances restored to available status', [
                    'reservation_id' => $reservation->id,
                    'items_count' => $reservation->items->count()
                ]);
            }
            
            // For pending reservations, no instances were assigned, so nothing to restore
            if ($originalStatus === 'pending') {
                Log::info('Pending reservation cancelled - no instances to restore', [
                    'reservation_id' => $reservation->id,
                    'status' => 'cancelled'
                ]);
            }

            // Send cancellation notification
            if ($reservation->user_id || $reservation->email) {
                NotificationService::createReservationStatusNotification(
                    $reservation, 
                    'cancelled', 
                    'Reservation cancelled by user'
                );
            }

            DB::commit();

            Log::info('Reservation cancelled successfully', [
                'reservation_id' => $reservation->id,
                'previous_status' => $originalStatus,
                'instances_restored' => $reservation->items->sum(function($item) {
                    return $item->instances->count();
                })
            ]);

            $message = 'Reservation cancelled successfully';
            if (in_array($originalStatus, ['approved', 'picked_up'])) {
                $message .= '. Equipment instances have been restored to available status.';
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to cancel reservation', [
                'reservation_id' => $reservation->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel reservation. Please try again.'
            ], 500);
        }
    }

    // Add equipment item while reservation is pending (track page inline)
    public function addItem(Request $request, Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending reservations can be modified.'], 422);
        }
        $data = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'quantity' => 'required|integer|min:1'
        ]);
        // Availability check against reservation window
        $equipment = \App\Models\Equipment::find($data['equipment_id']);
        $existing = $reservation->items()->where('equipment_id', $data['equipment_id'])->first();
        $targetQty = ($existing ? $existing->quantity_requested : 0) + $data['quantity'];
        if (method_exists($equipment, 'hasAvailableInstancesForDates')) {
            $availability = $equipment->hasAvailableInstancesForDates(
                $targetQty,
                $reservation->borrow_date->toDateString(),
                $reservation->return_date->toDateString()
            );
            if (!$availability['available']) {
                return response()->json(['success' => false, 'message' => "Only {$availability['available_count']} instances are available for the selected dates."], 422);
            }
        }
        // If reservation was cancelled (e.g., last item removed), re-open
        if ($reservation->status === 'cancelled') {
            $reservation->update(['status' => 'pending', 'cancelled_at' => null]);
        }
        // Create or increment existing item
        if ($existing) {
            $existing->update(['quantity_requested' => $existing->quantity_requested + $data['quantity']]);
        } else {
            \App\Models\ReservationItem::create([
                'reservation_id' => $reservation->id,
                'equipment_id' => $data['equipment_id'],
                'quantity_requested' => $data['quantity'],
                'quantity_approved' => 0,
            ]);
        }
        return response()->json(['success' => true]);
    }

    // Remove equipment item while pending
    public function removeItem(Request $request, Reservation $reservation, \App\Models\ReservationItem $item)
    {
        if ($reservation->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending reservations can be modified.'], 422);
        }
        if ($item->reservation_id !== $reservation->id) {
            return response()->json(['success' => false, 'message' => 'Item not found in this reservation.'], 404);
        }
        $item->delete();
        // Auto-cancel reservation if no items left
        if ($reservation->items()->count() === 0) {
            $reservation->update(['status' => 'cancelled', 'cancelled_at' => now()]);
            return response()->json(['success' => true, 'cancelled' => true]);
        }
        return response()->json(['success' => true, 'cancelled' => false]);
    }

    // Update item quantity (with availability check)
    public function updateItemQuantity(Request $request, Reservation $reservation, \App\Models\ReservationItem $item)
    {
        if ($reservation->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Only pending reservations can be modified.'], 422);
        }
        if ($item->reservation_id !== $reservation->id) {
            return response()->json(['success' => false, 'message' => 'Item not found in this reservation.'], 404);
        }
        $data = $request->validate(['quantity' => 'required|integer|min:1']);
        $equipment = $item->equipment;
        if (method_exists($equipment, 'hasAvailableInstancesForDates')) {
            $availability = $equipment->hasAvailableInstancesForDates(
                (int) $data['quantity'],
                $reservation->borrow_date->toDateString(),
                $reservation->return_date->toDateString()
            );
            if (!$availability['available']) {
                return response()->json(['success' => false, 'message' => "Only {$availability['available_count']} instances are available for the selected dates."], 422);
            }
        }
        $item->update(['quantity_requested' => (int) $data['quantity']]);
        return response()->json(['success' => true]);
    }

    public function resendGuestCode(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'token' => 'required|string',
        ]);
        $token = $data['token'];
        $entry = cache()->get('pending_res_' . $token);
        if (!$entry) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please start again.'], 410);
        }

        // Basic throttle: allow once every 60 seconds per token
        $throttleKey = 'pending_res_throttle_' . $token;
        if (cache()->has($throttleKey)) {
            return response()->json(['success' => false, 'message' => 'Please wait a minute before requesting a new code.'], 429);
        }
        cache()->put($throttleKey, true, 60);

        // Generate a new code but keep the same reservation payload
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $entry['hash'] = hash('sha256', $code);
        $entry['expires_at'] = now()->addMinutes(15);
        cache()->put('pending_res_' . $token, $entry, 900);

        try {
            $email = $entry['payload']['email'] ?? null;
            if ($email) {
                \Mail::send('emails.guest-otp', [
                    'code' => $code,
                    'expiresIn' => 15,
                ], function($m) use ($email) {
                    $m->to($email)->subject('SEMS Reservation Verification Code');
                });
            }
        } catch (\Exception $e) {
            \Log::error('Failed to resend verification code', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to send code. Try again later.'], 500);
        }

        return response()->json(['success' => true, 'message' => 'A new verification code has been sent.']);
    }
}
