<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservations\ReservationStoreRequest;
use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:instructor');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        // Get recent reservations
        $reservations = $user->reservations()->latest()->limit(10)->get();
        
        // Calculate comprehensive statistics
        $totalReservations = $user->reservations()->count();
        $pendingReservations = $user->reservations()->where('status', 'pending')->count();
        $approvedReservations = $user->reservations()->where('status', 'approved')->count();
        $completedReservations = $user->reservations()->where('status', 'completed')->count();
        $rejectedReservations = $user->reservations()->where('status', 'denied')->count();
        
        // Get this month's reservations
        $thisMonthReservations = $user->reservations()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Get most used equipment
        $mostUsedEquipment = $user->reservations()
            ->with('items.equipment')
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('equipment')
            ->groupBy('id')
            ->map(function($equipment) {
                return [
                    'equipment' => $equipment->first(),
                    'count' => $equipment->count()
                ];
            })
            ->sortByDesc('count')
            ->take(5);
        
        // Get recent incidents reported by this instructor
        $recentIncidents = collect();
        try {
            $recentIncidents = \App\Models\IncidentReport::where('reported_by', $user->id)
                ->latest()
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Table doesn't exist yet, return empty collection
            $recentIncidents = collect();
        }
        
        // Get equipment availability summary
        $equipmentStats = \App\Models\Equipment::where('is_active', true)
            ->with('instances')
            ->get()
            ->map(function($equipment) {
                return [
                    'total' => $equipment->quantity_total,
                    'available' => $equipment->quantity_available,
                    'utilization' => $equipment->quantity_total > 0 ? 
                        (($equipment->quantity_total - $equipment->quantity_available) / $equipment->quantity_total) * 100 : 0
                ];
            });
        
        $totalEquipment = $equipmentStats->sum('total');
        $availableEquipment = $equipmentStats->sum('available');
        $utilizationRate = $totalEquipment > 0 ? 
            (($totalEquipment - $availableEquipment) / $totalEquipment) * 100 : 0;
        
        // Get monthly reservation trends (last 6 months)
        $monthlyTrends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = $user->reservations()
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            $monthlyTrends[] = [
                'month' => $date->format('M Y'),
                'count' => $count
            ];
        }
        
        return view('instructor.dashboard', compact(
            'reservations',
            'totalReservations',
            'pendingReservations',
            'approvedReservations',
            'completedReservations',
            'rejectedReservations',
            'thisMonthReservations',
            'mostUsedEquipment',
            'recentIncidents',
            'totalEquipment',
            'availableEquipment',
            'utilizationRate',
            'monthlyTrends'
        ));
    }

    public function equipment(Request $request)
    {
        $query = Equipment::where('is_active', true)
            ->with(['category', 'instances']);
            
        if ($search = $request->get('q')) {
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', "%$search%")
                  ->orWhere('model', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
        
        if ($category = $request->get('category')) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('name', $category);
            });
        }
        
        $equipment = $query->get()
            ->map(function($item) {
                // Use the same availability calculation as admin/manager
                $item->quantity_available = $item->quantity_available;
                $item->quantity_total = $item->quantity_total;
                return $item;
            })
            ->filter(function($item) {
                // Only show equipment that has instances
                return $item->quantity_total > 0;
            });
        
        // Convert to paginated collection for consistency
        $perPage = 12;
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $items = $equipment->slice($offset, $perPage)->values();
        
        $equipment = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $equipment->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'pageName' => 'page']
        );
        
        $equipment->appends($request->query());
        
        return view('instructor.equipment', compact('equipment'));
    }

    public function reservations(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $reservations = auth()->user()->reservations()->with('items.equipment')->latest()->paginate($perPage);
        return view('instructor.reservations.index', compact('reservations'));
    }

    public function createReservation()
    {
        $equipment = Equipment::where('is_active', true)
            ->with(['category', 'instances', 'images'])
            ->get()
            ->map(function($item) {
                // Use the same availability calculation as admin/manager
                $item->quantity_available = $item->quantity_available;
                $item->quantity_total = $item->quantity_total;
                return $item;
            });
        
        return view('instructor.reservations.create', compact('equipment'));
    }

    public function storeReservation(Request $request)
    {
        try {
            // Log the incoming request for debugging
            \Log::info('Instructor reservation request received', [
                'request_data' => $request->all(),
                'user_id' => auth()->id(),
                'user' => auth()->user(),
            ]);

            // Set user information from authenticated user first
            $validated = $request->all();
            $validated['name'] = auth()->user()->name;
            $validated['email'] = auth()->user()->email;
            $validated['contact_number'] = auth()->user()->contact_number ?? '09123456789'; // Default if not set
            $validated['department'] = auth()->user()->department ?? 'PE Office'; // Default for instructors

            \Log::info('Validated data after user info', [
                'validated_data' => $validated,
                'available_keys' => array_keys($validated)
            ]);

            // Validate the request using instructor-specific rules
            $instructorRequest = new \App\Http\Requests\Reservations\InstructorReservationStoreRequest();
            $validator = \Validator::make($validated, $instructorRequest->rules());
            
            if ($validator->fails()) {
                \Log::error('Instructor reservation validation failed', [
                    'errors' => $validator->errors()->toArray(),
                    'validated_data' => $validated
                ]);
                
                // Handle AJAX requests
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()->toArray()
                    ], 422);
                }
                
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Parse cart data
            $cartItems = json_decode($validated['cart_data'], true);
            
            \Log::info('Cart data parsed', [
                'cart_data' => $validated['cart_data'],
                'cart_items' => $cartItems
            ]);
            
            if (empty($cartItems)) {
                return redirect()->back()
                    ->withErrors(['cart' => 'No items in cart'])
                    ->withInput();
            }

            // Determine the final reason value first
            $finalReason = $validated['reason_type'];
            if ($validated['reason_type'] === 'Other' && !empty($validated['custom_reason'])) {
                $finalReason = $validated['custom_reason'];
            }
            
            // Debug logging for reason
            \Log::info('Instructor reservation reason processing', [
                'reason_type' => $validated['reason_type'],
                'custom_reason' => $validated['custom_reason'] ?? null,
                'final_reason' => $finalReason
            ]);

            // Check for duplicate reservation (same email, same equipment, same dates, same reason)
            // Skip this check if user is proceeding with duplicate
            $email = $validated['email'];
            if ($email && !$request->has('proceed_with_duplicate')) {
                $existingReservation = \App\Models\Reservation::where('email', $email)
                    ->where('borrow_date', $validated['borrow_date'])
                    ->where('return_date', $validated['return_date'])
                    ->where('reason', $finalReason)
                    ->whereIn('status', ['pending', 'approved', 'picked_up'])
                    ->first();
                
                // Debug logging
                \Log::info('Instructor duplicate reservation check', [
                    'email' => $email,
                    'borrow_date' => $validated['borrow_date'],
                    'return_date' => $validated['return_date'],
                    'reason' => $finalReason,
                    'existing_reservation_found' => $existingReservation ? true : false,
                    'existing_reservation_id' => $existingReservation ? $existingReservation->id : null
                ]);
                
                if ($existingReservation) {
                    // Check if it's the same equipment
                    $cartItems = json_decode($validated['cart_data'], true);
                    if (is_array($cartItems)) {
                        $existingEquipmentIds = $existingReservation->items->pluck('equipment_id')->sort()->toArray();
                        $newEquipmentIds = collect($cartItems)->pluck('equipment_id')->sort()->toArray();
                        
                        // Debug logging
                        \Log::info('Equipment comparison', [
                            'existing_equipment_ids' => $existingEquipmentIds,
                            'new_equipment_ids' => $newEquipmentIds,
                            'is_duplicate' => $existingEquipmentIds === $newEquipmentIds
                        ]);
                        
                        if ($existingEquipmentIds === $newEquipmentIds) {
                            \Log::info('Duplicate reservation detected for instructor', [
                                'email' => $email,
                                'reservation_id' => $existingReservation->id
                            ]);
                            
                            return redirect()->back()
                                ->with('error', 'You already have a similar reservation with the same equipment, dates, and reason.')
                                ->withInput();
                        }
                    }
                }
            }

            // Build deterministic signature for duplicate detection (only if column exists)
            $equipmentPairs = collect($cartItems)
                ->map(fn($i) => ($i['equipment_id'] ?? $i['id']).':'.($i['quantity'] ?? 1))
                ->sort()->values()->toArray();
            $signaturePayload = implode('|', [
                strtolower($validated['email']),
                $validated['borrow_date'],
                $validated['borrow_time'],
                $validated['return_date'],
                $validated['return_time'],
                mb_strtolower($finalReason),
                $validated['additional_details'] ?? '',
                implode(';', $equipmentPairs)
            ]);
            $signature = hash('sha256', $signaturePayload);

            $shouldUseSignature = Schema::hasColumn('reservations', 'signature');
            $proceedDuplicate = (bool) $request->input('proceed_with_duplicate');
            if ($shouldUseSignature) {
                if (!$proceedDuplicate) {
                    $existingBySignature = \App\Models\Reservation::where('signature', $signature)
                        ->whereIn('status', ['pending', 'approved', 'picked_up', 'completed'])
                        ->first();
                    if ($existingBySignature) {
                        \Log::info('Duplicate signature detected at storeReservation, stopping create and asking client to confirm', [
                            'signature' => $signature,
                            'existing_id' => $existingBySignature->id,
                        ]);
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

            // Create reservation directly (instructor-specific logic)
            \DB::beginTransaction();
            try {
                \Log::info('Creating reservation with data', [
                    'validated_data' => $validated
                ]);

                // Create single reservation
                $reservationData = [
                    'user_id' => auth()->id(),
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'contact_number' => $validated['contact_number'],
                    'department' => $validated['department'],
                    'borrow_date' => $validated['borrow_date'],
                    'return_date' => $validated['return_date'],
                    'borrow_time' => $validated['borrow_time'],
                    'return_time' => $validated['return_time'],
                    'reason' => $finalReason,
                    'additional_details' => $validated['additional_details'] ?? null,
                    'status' => 'pending',
                    'reservation_code' => 'RES-' . strtoupper(str()->random(8)),
                ];
                if ($shouldUseSignature && !$proceedDuplicate) {
                    // Ensure DB uniqueness even if an old cancelled/denied reservation used the same signature
                    $finalSignature = $signature;
                    if (\App\Models\Reservation::where('signature', $finalSignature)->exists()) {
                        $finalSignature = $finalSignature . '-' . \Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(6));
                    }
                    $reservationData['signature'] = $finalSignature;
                }
                $reservation = \App\Models\Reservation::create($reservationData);

                // Create reservation items
                foreach ($cartItems as $item) {
                    $equipment = \App\Models\Equipment::find($item['equipment_id']);
                    $quantityRequested = $item['quantity'];
                    
                    // Check availability
                    $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                        $quantityRequested,
                        $validated['borrow_date'],
                        $validated['return_date']
                    );
                    
                    if (!$availabilityCheck['available']) {
                        \DB::rollBack();
                        return redirect()->back()
                            ->withErrors([
                                'cart' => "Cannot create reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available for the selected dates, but {$quantityRequested} requested."
                            ])
                            ->withInput();
                    }
                    
                    // Create reservation item
                    \App\Models\ReservationItem::create([
                        'reservation_id' => $reservation->id,
                        'equipment_id' => $item['equipment_id'],
                        'quantity_requested' => $quantityRequested,
                        'quantity_approved' => 0,
                    ]);
                }

                \DB::commit();
                
                // Create notification for reservation creation
                \App\Services\NotificationService::createReservationCreatedNotification($reservation);
                
                // Handle AJAX requests
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Reservation submitted successfully! Your reservation is pending approval.',
                        'redirect' => route('instructor.reservations')
                    ]);
                }
                
                return redirect()->route('instructor.reservations')
                    ->with('success', 'Reservation submitted successfully! Your reservation is pending approval.');
                    
            } catch (\Exception $e) {
                \DB::rollBack();
                \Log::error('Instructor reservation creation failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Handle AJAX requests
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to create reservation: ' . $e->getMessage()
                    ], 500);
                }
                
                return redirect()->back()
                    ->with('error', 'Failed to create reservation: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Instructor reservation creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to create reservation: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function checkDuplicate(Request $request)
    {
        try {
            // SAFELY extract inputs without throwing validation errors
            $email = (string) $request->input('email');
            $borrowDate = (string) $request->input('borrow_date');
            $returnDate = (string) $request->input('return_date');
            $borrowTime = (string) $request->input('borrow_time');
            $returnTime = (string) $request->input('return_time');
            $reasonType = (string) $request->input('reason_type');
            $customReason = (string) $request->input('custom_reason');
            $cartJson = (string) $request->input('cart_data', '[]');

            // Determine the final reason value
            $finalReason = $reasonType === 'Other' && !empty($customReason)
                ? $customReason
                : $reasonType;

            // Parse cart items safely
            $cartItems = json_decode($cartJson, true);
            if (!is_array($cartItems)) { $cartItems = []; }

            // If critical fields are missing, treat as non-duplicate but do not error
            if (empty($email) || empty($borrowDate) || empty($returnDate) || empty($borrowTime) || empty($returnTime) || empty($finalReason)) {
                return response()->json([
                    'is_duplicate' => false,
                    'message' => 'Insufficient data provided to determine duplicates.'
                ]);
            }

            // Prefer signature-based detection for exact parity with create() flow
            $useSignature = \Schema::hasColumn('reservations', 'signature');
            if ($useSignature) {
                $pairs = collect($cartItems)
                    ->map(fn($i) => ($i['equipment_id'] ?? $i['id']).':'.($i['quantity'] ?? 1))
                    ->sort()->values()->toArray();
            $payload = implode('|', [
                strtolower($email),
                $borrowDate,
                $borrowTime,
                $returnDate,
                $returnTime,
                mb_strtolower($finalReason),
                $request->input('additional_details', ''),
                implode(';', $pairs)
            ]);
                $sig = hash('sha256', $payload);

                $exists = \App\Models\Reservation::where('signature', $sig)
                    ->whereIn('status', ['pending','approved','picked_up','completed'])
                    ->exists();

                return response()->json([
                    'is_duplicate' => $exists,
                    'message' => $exists ? 'You already have a similar reservation with the same equipment, dates, times, and reason.' : 'No duplicate reservation found.'
                ]);
            }

            // Fallback normalized comparison when signature column is unavailable
            $existingReservation = \App\Models\Reservation::where('email', $email)
                ->where('borrow_date', $borrowDate)
                ->where('return_date', $returnDate)
                ->where('borrow_time', $borrowTime)
                ->where('return_time', $returnTime)
                ->where('reason', $finalReason)
                ->whereIn('status', ['pending','approved','picked_up','completed'])
                ->with('items')
                ->first();

            if ($existingReservation) {
                $existingPairs = collect($existingReservation->items)
                    ->map(fn($i) => $i['equipment_id'].':'.($i['quantity_requested'] ?? $i['quantity'] ?? 1))
                    ->sort()->values()->toArray();
                $newPairs = collect($cartItems)
                    ->map(fn($i) => ($i['equipment_id'] ?? $i['id']).':'.($i['quantity'] ?? 1))
                    ->sort()->values()->toArray();

                if ($existingPairs === $newPairs) {
                    return response()->json([
                        'is_duplicate' => true,
                        'message' => 'You already have a similar reservation with the same equipment (and quantities), dates, times, and reason.'
                    ]);
                }
            }

            return response()->json([
                'is_duplicate' => false,
                'message' => 'No duplicate reservation found.'
            ]);
        } catch (\Throwable $e) {
            \Log::error('Duplicate check unexpected error', ['error' => $e->getMessage()]);
            return response()->json([
                'is_duplicate' => false,
                'message' => 'No duplicate reservation found.'
            ]);
        }
    }

    public function showReservation(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        
        // Load all necessary relationships for the detailed view
        $reservation->load([
            'user',
            'approvedBy',
            'createdBy',
            'items.equipment.category',
            'items.equipment.equipmentType',
            'items.reservationItemInstances.equipmentInstance'
        ]);
        
        return view('instructor.reservations.show', compact('reservation'));
    }

    public function reportIncident(Request $request)
    {
        $data = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'reservation_item_instance_id' => 'nullable|exists:reservation_item_instances,id',
            'incident_type' => 'required|in:stolen,lost,damaged,not_returned',
            'student_name' => 'nullable|string|max:255',
            'student_email' => 'nullable|email',
            'incident_description' => 'nullable|string',
        ]);

        $reservation = \App\Models\Reservation::with('items')->findOrFail($data['reservation_id']);
        $equipmentInstanceId = null;
        if (!empty($data['reservation_item_instance_id'])) {
            $rii = \App\Models\ReservationItemInstance::find($data['reservation_item_instance_id']);
            $equipmentInstanceId = $rii?->equipment_instance_id;
        }

        \App\Models\MissingEquipment::create([
            'equipment_instance_id' => $equipmentInstanceId,
            'reservation_id' => $reservation->id,
            'borrower_name' => $reservation->name,
            'borrower_email' => $reservation->email,
            'borrower_contact_number' => $reservation->contact_number,
            'borrower_department' => $reservation->department,
            'incident_date' => now()->toDateString(),
            'incident_type' => $data['incident_type'],
            'incident_description' => $data['incident_description'] ?? null,
            'acted_by' => auth()->id(),
            'acted_at' => now(),
        ]);

        return back()->with('success', 'Incident submitted for review.');
    }

    public function incidents()
    {
        $incidents = \App\Models\IncidentReport::where('reported_by', auth()->id())
            ->with(['reservation', 'equipment', 'equipmentInstance'])
            ->latest()
            ->paginate(10);
        
        return view('instructor.incidents.index', compact('incidents'));
    }

    public function createIncident()
    {
        $reservations = auth()->user()->reservations()
            ->where('status', 'picked_up')
            ->with([
                'items' => function($query) {
                    $query->where('quantity_approved', '>', 0);
                },
                'items.equipment.instances',
                'items.reservationItemInstances.equipmentInstance'
            ])
            ->get();
        
        return view('instructor.incidents.create', compact('reservations'));
    }

    public function storeIncident(Request $request)
    {
        try {
            try {
                $validated = $request->validate([
                    'reservation_id' => 'required|exists:reservations,id',
                    'equipment_instances' => 'required|array|min:1',
                    'equipment_instances.*' => 'exists:equipment_instances,id',
                    'description' => 'required|string|max:1000',
                    'student_involvement' => 'nullable|string|max:1000',
                    'students' => 'nullable|array',
                    'students.*.name' => 'nullable|string|max:255',
                    'students.*.email' => 'nullable|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@s\.ubaguio\.edu$/',
                    'action_taken' => 'nullable|string|max:1000',
                    'attachments' => 'nullable|array',
                    'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB max per file
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $e->errors()
                    ], 422);
                }
                throw $e;
            }

            // Verify the reservation belongs to the current user
            $reservation = \App\Models\Reservation::where('id', $validated['reservation_id'])
                ->where('user_id', auth()->id())
                ->with(['items.reservationItemInstances.equipmentInstance'])
                ->firstOrFail();

            // Verify that the selected equipment instances are approved instances for this reservation
            $instanceIds = $validated['equipment_instances'];
            $validInstances = $reservation->items
                ->where('quantity_approved', '>', 0)
                ->pluck('reservationItemInstances')
                ->flatten()
                ->pluck('equipmentInstance.id')
                ->toArray();
            
            // Check if all selected instances are valid approved instances
            $invalidInstances = array_diff($instanceIds, $validInstances);
            if (!empty($invalidInstances)) {
                if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'One or more selected equipment instances are not approved for this reservation.'
                    ], 422);
                }
                return back()->withErrors(['equipment_instances' => 'One or more selected equipment instances are not approved for this reservation.']);
            }

            // Handle file uploads
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('incident-attachments', 'public');
                    $attachments[] = [
                        'filename' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ];
                }
            }

            // Create a single incident report with multiple equipment instances
            $equipmentInstances = [];
            $severities = [];
            $equipmentIds = [];
            
            foreach ($instanceIds as $instanceId) {
                $severity = $request->input("severity_{$instanceId}");
                if (!$severity) {
                    if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Please select severity for all equipment instances.'
                        ], 422);
                    }
                    return back()->withErrors(['equipment_instances' => 'Please select severity for all equipment instances.']);
                }
                
                // Get the equipment ID from the equipment instance; fall back to reservation item
                $equipmentInstance = \App\Models\EquipmentInstance::find($instanceId);
                $equipmentId = $equipmentInstance ? $equipmentInstance->equipment_id : null;
                if (!$equipmentId) {
                    // Fallbacks from reservation items relationship
                    $firstItem = $reservation->items->first();
                    $equipmentId = $firstItem?->equipment_id ?? $firstItem?->equipment?->id;
                }
                
                $equipmentInstances[] = $instanceId;
                $severities[$instanceId] = $severity;
                $equipmentIds[$instanceId] = $equipmentId;
            }
            
            // Map severity to appropriate incident type (use the most severe one)
            $incidentTypeMap = [
                'lost' => 'lost',
                'damaged' => 'damaged',
                'needs_repair' => 'damaged', // Map needs_repair to damaged
                'malfunction' => 'malfunction',
                'stolen' => 'stolen',
                'other' => 'other'
            ];
            
            // Use the first severity for incident type (or could implement priority logic)
            $primarySeverity = $severities[array_key_first($severities)];
            $incidentType = $incidentTypeMap[$primarySeverity] ?? 'other';
            
            // Determine a primary equipment id in case any instance lookup failed
            $primaryEquipmentId = $equipmentIds[array_key_first($equipmentIds)]
                ?? ($reservation->items->first()?->equipment_id)
                ?? (isset($equipmentInstances[0]) ? (\App\Models\EquipmentInstance::find($equipmentInstances[0])?->equipment_id) : null);

            if (!$primaryEquipmentId) {
                // As a last resort, return a clear validation-like error
                if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unable to determine equipment for this incident. Please reselect equipment and try again.'
                    ], 422);
                }
                return back()->withErrors(['equipment_id' => 'Unable to determine equipment for this incident. Please reselect equipment and try again.']);
            }

            $incidentData = [
                'reservation_id' => $validated['reservation_id'],
                'equipment_id' => $primaryEquipmentId, // Primary equipment ID
                'equipment_instance_id' => null, // No single instance - multiple instances
                'equipment_instances' => $equipmentInstances, // Store all instances (cast to json)
                'equipment_severities' => $severities, // Store severity for each instance (cast to json)
                'incident_type' => $incidentType,
                'severity' => $primarySeverity,
                'description' => $validated['description'],
                'student_involvement' => $validated['student_involvement'] ?? null,
                'students' => $validated['students'] ?? [], // Store multiple students (cast to json)
                'action_taken' => $validated['action_taken'] ?? null,
                'attachments' => $attachments, // Cast to json
                'reported_by' => auth()->id(),
                'status' => 'reported',
            ];
            
            try {
                $incident = \App\Models\IncidentReport::create($incidentData);
                $incidents = [$incident]; // Single incident with multiple equipment instances
            } catch (\Exception $e) {
                \Log::error('Failed to create incident report: ' . $e->getMessage(), [
                    'incident_data' => $incidentData,
                    'user_id' => auth()->id()
                ]);
                
                if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => (bool) config('app.debug') ? ('Failed to create incident report: ' . $e->getMessage()) : 'Failed to create incident report.'
                    ], 500);
                }
                throw $e;
            }

            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Incident reports submitted successfully! ' . count($incidents) . ' incident(s) have been reported for review.'
                ]);
            }
            
            return redirect()->route('instructor.incidents.index')
                ->with('success', 'Incident reports submitted successfully! ' . count($incidents) . ' incident(s) have been reported for review.');
        } catch (\Exception $e) {
            \Log::error('storeIncident failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => (bool) config('app.debug') ? ('Failed to submit incident report: ' . $e->getMessage()) : 'Failed to submit incident report. Please try again.'
                ], 500);
            }
            
            return redirect()->back()
                ->withErrors(['error' => (bool) config('app.debug') ? ('Failed to submit incident report: ' . $e->getMessage()) : 'Failed to submit incident report. Please try again.'])
                ->withInput();
        }
    }

    public function showIncident(\App\Models\IncidentReport $incident)
    {
        // Verify the incident belongs to the current user
        if ($incident->reported_by !== auth()->id()) {
            abort(403, 'Unauthorized access to incident report.');
        }

        $incident->load(['reservation', 'equipment', 'equipmentInstance', 'reporter', 'resolver']);

        return view('instructor.incidents.show', compact('incident'));
    }

    public function exportIncidentPdf(\App\Models\IncidentReport $incident)
    {
        if ($incident->reported_by !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        // Load related data to match the view details
        $incident->load(['reservation', 'equipment', 'equipmentInstance', 'reporter', 'resolver']);
        $html = view('pdf.incidents-report', [
            'incidents' => collect([$incident]),
            'generated_at' => now()->format('F d, Y \\a\\t g:i A'),
            'title' => 'Incident Report',
            'filters' => ['owner' => auth()->user()->name]
        ])->render();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream('incident-' . $incident->incident_code . '.pdf');
    }

    public function destroyIncident(\App\Models\IncidentReport $incident, \Illuminate\Http\Request $request)
    {
        if ($incident->reported_by !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        try {
            $incident->delete();
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Incident report deleted']);
            }
            return redirect()->route('instructor.incidents.index')->with('success', 'Incident report deleted successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Failed to delete incident report.');
        }
    }

    /**
     * Generate instructor reports
     */
    public function reports(Request $request)
    {
        $user = auth()->user();
        
        // Get filter parameters
        $startDate = $request->get('start_date', now()->subMonths(6)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $reportType = $request->get('type', 'reservations');
        
        $data = [];
        
        switch ($reportType) {
            case 'reservations':
                $data = $this->generateReservationReport($user, $startDate, $endDate);
                break;
            case 'incidents':
                $data = $this->generateIncidentReport($user, $startDate, $endDate);
                break;
        }
        
        return view('instructor.reports.index', compact('data', 'startDate', 'endDate', 'reportType'));
    }
    
    /**
     * Generate reservation report data
     */
    private function generateReservationReport($user, $startDate, $endDate)
    {
        $reservations = $user->reservations()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['items.equipment'])
            ->get();
            
        $statusCounts = $reservations->groupBy('status')->map->count();
        $monthlyData = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m');
        })->map->count();
        
        return [
            'total' => $reservations->count(),
            'status_counts' => $statusCounts,
            'monthly_data' => $monthlyData,
            'reservations' => $reservations
        ];
    }
    
    /**
     * Generate equipment usage report data
     */
    private function generateEquipmentUsageReport($user, $startDate, $endDate)
    {
        $reservations = $user->reservations()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['items.equipment'])
            ->get();
            
        $equipmentUsage = $reservations->pluck('items')
            ->flatten()
            ->pluck('equipment')
            ->groupBy('id')
            ->map(function($equipment) {
                return [
                    'equipment' => $equipment->first(),
                    'count' => $equipment->count(),
                    'total_quantity' => $equipment->sum('quantity_requested')
                ];
            })
            ->sortByDesc('count');
            
        return [
            'equipment_usage' => $equipmentUsage,
            'total_equipment_types' => $equipmentUsage->count(),
            'most_used' => $equipmentUsage->first()
        ];
    }
    
    /**
     * Generate incident report data
     */
    private function generateIncidentReport($user, $startDate, $endDate)
    {
        try {
            $incidents = \App\Models\IncidentReport::where('reported_by', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with(['equipment', 'reservation'])
                ->get();
        } catch (\Exception $e) {
            // Table doesn't exist yet, return empty data
            $incidents = collect();
        }
            
        $incidentTypes = $incidents->groupBy('incident_type')->map->count();
        $severityCounts = $incidents->groupBy('severity')->map->count();
        $statusCounts = $incidents->groupBy('status')->map->count();
        
        return [
            'total' => $incidents->count(),
            'incident_types' => $incidentTypes,
            'severity_counts' => $severityCounts,
            'status_counts' => $statusCounts,
            'incidents' => $incidents
        ];
    }
    

    /**
     * Get instructor notifications
     */
    public function notifications(Request $request)
    {
        $user = auth()->user();
        
        try {
            $notifications = \App\Models\InstructorNotification::getRecentNotifications($user->id, 20);
            $unreadCount = \App\Models\InstructorNotification::getUnreadCount($user->id);
        } catch (\Exception $e) {
            // Tables don't exist yet, return empty data
            $notifications = collect();
            $unreadCount = 0;
        }
        
        return view('instructor.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark notification as read
     */
    public function markNotificationAsRead(\App\Models\InstructorNotification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to notification.');
        }

        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead()
    {
        $user = auth()->user();
        
        try {
            \App\Models\InstructorNotification::where('user_id', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);
        } catch (\Exception $e) {
            // Table doesn't exist yet, just return success
        }
        
        return response()->json(['success' => true]);
    }

    /**
     * Get unread notification count (AJAX endpoint)
     */
    public function getUnreadCount()
    {
        $user = auth()->user();
        
        try {
            $count = \App\Models\InstructorNotification::getUnreadCount($user->id);
        } catch (\Exception $e) {
            // Table doesn't exist yet, return 0
            $count = 0;
        }
        
        return response()->json(['count' => $count]);
    }

    public function checkConflicts(Request $request)
    {
        $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'borrow_time' => 'required',
            'return_time' => 'required',
            'equipment' => 'required|array',
            'equipment.*.equipment_id' => 'required|exists:equipment,id',
            'equipment.*.quantity' => 'required|integer|min:1'
        ]);

        $borrowDate = $request->borrow_date;
        $returnDate = $request->return_date;
        $borrowTime = $request->borrow_time;
        $returnTime = $request->return_time;
        $requestedEquipment = $request->equipment;

        $conflicts = [];
        $hasConflicts = false;

        foreach ($requestedEquipment as $item) {
            $equipment = Equipment::find($item['equipment_id']);
            $requestedQuantity = $item['quantity'];
            
            // Check for overlapping reservations (considering time fields)
            $overlappingReservations = Reservation::where('status', '!=', 'cancelled')
                ->where('status', '!=', 'denied')
                ->where(function($query) use ($borrowDate, $returnDate, $borrowTime, $returnTime) {
                    $query->where(function($q) use ($borrowDate, $returnDate) {
                        // Check if reservation overlaps with requested period
                        $q->whereBetween('borrow_date', [$borrowDate, $returnDate])
                          ->orWhereBetween('return_date', [$borrowDate, $returnDate])
                          ->orWhere(function($subQ) use ($borrowDate, $returnDate) {
                              $subQ->where('borrow_date', '<=', $borrowDate)
                                   ->where('return_date', '>=', $returnDate);
                          });
                    });
                    
                    // If both reservations are on the same day, check time overlap
                    if ($borrowDate === $returnDate) {
                        $query->where(function($timeQuery) use ($borrowDate, $borrowTime, $returnTime) {
                            $timeQuery->where('borrow_date', $borrowDate)
                                ->where(function($tq) use ($borrowTime, $returnTime) {
                                    // Check if times overlap
                                    $tq->where(function($inner) use ($borrowTime, $returnTime) {
                                        // New reservation starts before existing ends AND new reservation ends after existing starts
                                        $inner->where('borrow_time', '<', $returnTime)
                                              ->where('return_time', '>', $borrowTime);
                                    });
                                });
                        });
                    }
                })
                ->whereHas('items', function($query) use ($equipment) {
                    $query->where('equipment_id', $equipment->id);
                })
                ->with(['items' => function($query) use ($equipment) {
                    $query->where('equipment_id', $equipment->id);
                }])
                ->get();

            // Calculate reserved quantity during the requested period
            $reservedQuantity = 0;
            foreach ($overlappingReservations as $reservation) {
                foreach ($reservation->items as $reservationItem) {
                    if ($reservationItem->equipment_id == $equipment->id) {
                        $reservedQuantity += $reservationItem->quantity_requested;
                    }
                }
            }

            // Get current availability for this equipment
            $currentlyAvailable = $equipment->quantity_available ?? 0;
            
            // Check if there's enough availability
            $availableDuringPeriod = $currentlyAvailable - $reservedQuantity;
            
            if ($requestedQuantity > $availableDuringPeriod) {
                $hasConflicts = true;
                $conflicts[] = [
                    'equipment_id' => $equipment->id,
                    'equipment_name' => $equipment->brand . ' ' . $equipment->model,
                    'requested_quantity' => $requestedQuantity,
                    'available_quantity' => max(0, $availableDuringPeriod),
                    'conflict_details' => $availableDuringPeriod > 0 
                        ? "Only {$availableDuringPeriod} available during this period"
                        : "No availability during this period"
                ];
            }
        }

        return response()->json([
            'hasConflicts' => $hasConflicts,
            'conflicts' => $conflicts
        ]);
    }

    public function cancelReservation(Request $request, Reservation $reservation)
    {
        try {
            // Check if the reservation belongs to the authenticated user
            if ($reservation->user_id !== auth()->id()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are not authorized to cancel this reservation.'
                    ], 403);
                }
                return back()->with('error', 'You are not authorized to cancel this reservation.');
            }

            // Check if the reservation can be cancelled (only pending reservations)
            if ($reservation->status !== 'pending') {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only pending reservations can be cancelled.'
                    ], 400);
                }
                return back()->with('error', 'Only pending reservations can be cancelled.');
            }

            // Update reservation status to cancelled
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $request->input('remarks', 'Instructor cancelled their own reservation')
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reservation cancelled successfully.'
                ]);
            }

            return back()->with('success', 'Reservation cancelled successfully.');

        } catch (\Exception $e) {
            \Log::error('Error cancelling reservation: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while cancelling the reservation. Please try again.'
                ], 500);
            }

            return back()->with('error', 'An error occurred while cancelling the reservation. Please try again.');
        }
    }
}


