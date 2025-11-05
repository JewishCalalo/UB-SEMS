<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\EquipmentInstance;
use App\Models\User;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use App\Rules\NotBlacklistedEmail;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationService;
use App\Services\ReservationStatusService;
use App\Services\ReservationExpirationService;
use App\Http\Controllers\Traits\ManagementTrait;
use Shuchkin\SimpleXLSXGen;
// use Illuminate\Validation\Rules\Regex; // Not available in this framework version

class ReservationManagementController extends Controller
{
    use ManagementTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        // Allow both manager and admin access
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->hasAnyRole(['manager', 'admin'])) {
                abort(403, 'Access denied. Manager or Admin role required.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // Check and mark expired reservations in real-time
        $expirationResult = ReservationExpirationService::checkAndMarkExpired();
        if ($expirationResult['expired_count'] > 0) {
            \Log::info("Marked {$expirationResult['expired_count']} expired reservations: " . implode(', ', $expirationResult['expired_reservations']));
        }

        // Optimized query with proper eager loading
        $query = Reservation::with([
            'user:id,name,email,role',
            'items.equipment:id,brand,model,category_id,equipment_type_id',
            'items.equipment.category:id,name',
            'items.equipment.equipmentType:id,name',
            'items.instances:id,instance_code,condition',
            'approvedBy:id,name,email'
        ]);

        // Apply common reservation filters
        $query = $this->applyReservationFilters($query, $request);

        // Apply common sorting
        $query = $this->applySorting($query, $request, 'created_at');

        // Apply common pagination
        $reservations = $this->applyPagination($query, $request);
        
        // Get common filter data
        $filterData = $this->getCommonFilterData();
        $categories = $filterData['categories'];
        $equipmentTypes = $filterData['equipmentTypes'];
        
        // Get equipment for filter dropdown
        $equipment = cache()->remember('reservation_equipment', 1800, function() {
            return Equipment::orderBy('brand')->get();
        });

        // Get statistics with caching
        $totalReservations = cache()->remember('total_reservations', 300, function() {
            return Reservation::count();
        });
        $pendingReservations = Reservation::where('status', 'pending')->count();
        $approvedReservations = Reservation::where('status', 'approved')->count();
        $deniedReservations = Reservation::where('status', 'denied')->count();
        $pickedUpReservations = Reservation::where('status', 'picked_up')->count();
        $returnedReservations = Reservation::where('status', 'returned')->count();
        $completedReservations = Reservation::where('status', 'completed')->count();
        $cancelledReservations = Reservation::where('status', 'cancelled')->count();
        // Real-time overdue calculation
        $overdueReservations = Reservation::where('status', 'picked_up')
            ->get()
            ->filter(function ($reservation) {
                return $reservation->isOverdue();
            })
            ->count();
        $cancelledReservations = Reservation::where('status', 'cancelled')->count();

        // Compute conflicts: all active reservations competing for limited instances (overlapping dates)
        $activeWithItems = Reservation::with([
            'items.equipment.category',
            'items.equipment.equipmentType'
        ])->whereIn('status', ['pending', 'approved', 'picked_up'])->get();
        

        $equipmentIdToRequests = [];
        foreach ($activeWithItems as $res) {
            foreach ($res->items as $item) {
                $equipment = $item->equipment;
                if (!$equipment) { continue; }
                $equipmentIdToRequests[$equipment->id] = $equipmentIdToRequests[$equipment->id] ?? [
                    'equipment' => $equipment,
                    'requests' => []
                ];
                
                // For approved/picked_up reservations, use actual assigned instances count
                // For pending reservations, use quantity_requested
                $quantity = $res->status === 'pending' 
                    ? (int)($item->quantity_requested ?? 0)
                    : $item->reservationItemInstances->count();
                
                $equipmentIdToRequests[$equipment->id]['requests'][] = [
                    'reservation' => $res,
                    'quantity' => $quantity,
                    'borrow_date' => $res->borrow_date,
                    'return_date' => $res->return_date,
                    'borrow_time' => $res->borrow_time,
                    'return_time' => $res->return_time,
                ];
            }
        }

        $conflicts = [];
        $conflictingReservationIds = []; // Track IDs of conflicting reservations
        foreach ($equipmentIdToRequests as $equipmentId => $data) {
            /** @var \App\Models\Equipment $eq */
            $eq = $data['equipment'];
            $requests = $data['requests'];
            $conflictingReservations = [];

            // Check all possible overlapping groups
            $count = count($requests);
            
            // For each reservation, find all others that overlap with it
            for ($i = 0; $i < $count; $i++) {
                $r1 = $requests[$i];
                $overlapSum = $r1['quantity'];
                $group = [$r1['reservation']->id => $r1];
                
                // Find all reservations that overlap with this one
                for ($j = 0; $j < $count; $j++) {
                    if ($i === $j) continue;
                    $r2 = $requests[$j];
                    
                    // Time-aware overlap check:
                    // Use Carbon datetimes when both have times; otherwise fall back to date-only overlap
                    $r1Start = $r1['borrow_date'];
                    $r1End = $r1['return_date'];
                    $r2Start = $r2['borrow_date'];
                    $r2End = $r2['return_date'];

                    $parseDateTime = function($date, $time) {
                        if (empty($time)) {
                            return \Carbon\Carbon::parse($date.' 00:00:00');
                        }
                        // If time already contains a date portion, parse it directly
                        if (strpos($time, ' ') !== false) {
                            return \Carbon\Carbon::parse($time);
                        }
                        return \Carbon\Carbon::parse($date.' '.$time);
                    };

                    if (!empty($r1['borrow_date'])) {
                        $r1Start = $parseDateTime($r1['borrow_date'], $r1['borrow_time'] ?? null);
                    }
                    if (!empty($r1['return_date'])) {
                        $r1End = $parseDateTime($r1['return_date'], $r1['return_time'] ?? null);
                    }
                    if (!empty($r2['borrow_date'])) {
                        $r2Start = $parseDateTime($r2['borrow_date'], $r2['borrow_time'] ?? null);
                    }
                    if (!empty($r2['return_date'])) {
                        $r2End = $parseDateTime($r2['return_date'], $r2['return_time'] ?? null);
                    }

                    // Overlap if not (start >= other end OR end <= other start)
                    $overlaps = !($r1Start >= $r2End || $r1End <= $r2Start);
                    
                    if ($overlaps) {
                        $overlapSum += $r2['quantity'];
                        $group[$r2['reservation']->id] = $r2;
                    }
                }
                
                // Check if this group exceeds availability
                // A conflict requires at least 2 overlapping reservations
                if ($overlapSum > 0 && count($group) >= 2) {
                    // Use the date range that covers all overlapping reservations
                    $minBorrowDate = min(array_column($group, 'borrow_date'));
                    $maxReturnDate = max(array_column($group, 'return_date'));
                    $available = $eq->getBookableCount($minBorrowDate, $maxReturnDate);
                    
                    if ($overlapSum > $available) {
                        
                        // Record this conflict group
                        foreach ($group as $rid => $entry) {
                            $conflictingReservations[$rid] = $entry;
                            $conflictingReservationIds[] = $rid; // Add to conflicting IDs
                        }
                    }
                }
            }

            if (!empty($conflictingReservations) && count($conflictingReservations) >= 2) {
                // Determine overall window using dates only for capacity since availability is date-scoped
                $minBorrowDate = min(array_column($conflictingReservations, 'borrow_date'));
                $maxReturnDate = max(array_column($conflictingReservations, 'return_date'));
                $available = $eq->getBookableCount($minBorrowDate, $maxReturnDate);

                // Filter reservations that truly overlap in time (same-day window considers times)
                $filterOverlap = function($reservations) use ($parseDateTime) {
                    $result = [];
                    foreach ($reservations as $entry) {
                        $overlapsAny = false;
                        $s1 = $parseDateTime($entry['borrow_date'], $entry['borrow_time'] ?? null);
                        $e1 = $parseDateTime($entry['return_date'], $entry['return_time'] ?? null);
                        foreach ($reservations as $other) {
                            if ($other === $entry) continue;
                            $s2 = $parseDateTime($other['borrow_date'], $other['borrow_time'] ?? null);
                            $e2 = $parseDateTime($other['return_date'], $other['return_time'] ?? null);
                            if (!($s1 >= $e2 || $e1 <= $s2)) { $overlapsAny = true; break; }
                        }
                        if ($overlapsAny) { $result[] = $entry; }
                    }
                    return $result;
                };
                $conflictingReservations = $filterOverlap($conflictingReservations);
                
                $conflicts[] = [
                    'equipment' => $eq,
                    'available' => $available,
                    'reservations' => array_values($conflictingReservations),
                ];
            }
        }

        return view('admin-manager.reservation-management.index', compact(
            'reservations', 
            'categories', 
            'equipment', 
            'equipmentTypes',
            'totalReservations',
            'pendingReservations',
            'approvedReservations',
            'deniedReservations',
            'pickedUpReservations',
            'returnedReservations',
            'completedReservations',
            'overdueReservations',
            'cancelledReservations',
            'conflicts',
            'conflictingReservationIds'
        ));
    }

    public function create()
    {
        // Only show equipment that has available instances
        $equipment = Equipment::where('is_active', true)
            ->whereHas('instances', function($q) {
                $q->where('is_active', true)
                  ->where('is_available', true);
            })
            ->with(['category', 'equipmentType'])
            ->get();
            
        $categories = EquipmentCategory::orderBy('name')->get();
        $equipmentTypes = EquipmentType::orderBy('name')->get();
        
        return view('admin-manager.reservation-management.create', compact('equipment', 'categories', 'equipmentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',
            // Allow only University of Baguio student/teacher domains
            'teacher_email' => [
                'required',
                'email',
                'max:255',
                new NotBlacklistedEmail,
                function ($attribute, $value, $fail) {
                    // Accept only University of Baguio student/PE staff/teacher domains
                    // Students: s.ubaguio.edu, Teachers/Staff: e.ubaguio.edu
                    $pattern = '/^[A-Za-z0-9._%+-]+@(s\\.ubaguio\\.edu|e\\.ubaguio\\.edu)$/i';
                    if (!preg_match($pattern, $value)) {
                        $fail('Please use a valid University of Baguio email address (e.g., 12345678@s.ubaguio.edu or 12345678@e.ubaguio.edu).');
                    }
                },
            ],
            'department' => 'required|string|max:255',
            'other_department' => 'nullable|required_if:department,Other|string|max:255',
            'borrow_date' => 'required|date|after_or_equal:today',
            // allow same day
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'borrow_time' => ['required','date_format:H:i'],
            'return_time' => ['required','date_format:H:i'],
            'reason' => 'required|string|max:1000',
            'equipment_items' => 'required|array|min:1',
            'equipment_items.*.equipment_id' => 'required|exists:equipment,id',
            'equipment_items.*.quantity_requested' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // Enforce time window and 30-min rule for same-day
        try {
            $bDate = \Carbon\Carbon::parse($validated['borrow_date']);
            $rDate = \Carbon\Carbon::parse($validated['return_date']);
            [$bh,$bm] = array_map('intval', explode(':', $validated['borrow_time']));
            [$rh,$rm] = array_map('intval', explode(':', $validated['return_time']));
            $bMin = $bh*60 + $bm; $rMin = $rh*60 + $rm;
            if ($bMin < 480 || $bMin > 1020) {
                return back()->withErrors(['borrow_time' => 'Borrow time must be between 8:00 AM and 5:00 PM.'])->withInput();
            }
            if ($rMin < 480 || $rMin > 1020) {
                return back()->withErrors(['return_time' => 'Return time must be between 8:00 AM and 5:00 PM.'])->withInput();
            }
            if ($bDate->isSameDay($rDate)) {
                if ($rMin - $bMin < 30) {
                    return back()->withErrors(['return_time' => 'For same-day reservations, return time must be at least 30 minutes after borrow time.'])->withInput();
                }
            }
        } catch (\Exception $e) { /* ignore parsing errors, already validated */ }

        // Check for missing equipment before creating reservation
        $email = $validated['teacher_email'];
        if ($email) {
            $hasOutstanding = \App\Models\MissingEquipment::where('borrower_email', $email)
                ->whereIn('replacement_status', ['pending', 'not_replaced'])
                ->exists();
            
            if ($hasOutstanding) {
                return redirect()->back()->withErrors([
                    'teacher_email' => 'This email has unresolved missing/lost equipment. Please settle the replacement before making a new reservation.'
                ])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            // Generate unique reservation code
            $reservationCode = 'RES-' . strtoupper(substr(md5(uniqid()), 0, 8));
            
        // Create reservation for staff/teachers
            $reservation = Reservation::create([
                'reservation_code' => $reservationCode,
                'name' => $validated['teacher_name'], // Store the teacher/staff name
                'email' => $validated['teacher_email'], // Store the teacher/staff email
            'department' => ($validated['department'] === 'Other' ? ($validated['other_department'] ?? 'Other') : $validated['department']),
                'borrow_date' => $validated['borrow_date'],
                'return_date' => $validated['return_date'],
                'borrow_time' => $validated['borrow_time'] ?? null,
                'return_time' => $validated['return_time'] ?? null,
                'status' => 'pending',
                'reason' => $validated['reason'],
                'remarks' => $validated['remarks'],
                'created_by' => auth()->id(),
            ]);

            // Create reservation items and assign equipment instances
            foreach ($validated['equipment_items'] as $item) {
                $equipment = Equipment::find($item['equipment_id']);
                $quantityRequested = $item['quantity_requested'];
                
                // Check if enough instances are available
                $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                    $quantityRequested,
                    $validated['borrow_date'],
                    $validated['return_date']
                );
                if (!$availabilityCheck['available']) {
                    DB::rollBack();
                    return redirect()->back()->withErrors([
                        'error' => "Cannot create reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$quantityRequested} requested."
                    ])->withInput();
                }
                
                // Create reservation item
                $reservationItem = $reservation->items()->create([
                    'equipment_id' => $item['equipment_id'],
                    'quantity_requested' => $quantityRequested,
                    'quantity_approved' => $quantityRequested, // Auto-approve quantity
                ]);
                
                // Reserve and assign specific equipment instances
                $reservationResult = $equipment->reserveInstances($quantityRequested);
                
                if (!$reservationResult['success']) {
                    DB::rollBack();
                    return redirect()->back()->withErrors([
                        'error' => $reservationResult['message']
                    ])->withInput();
                }
                
                // Create the reservation-instance links
                foreach ($reservationResult['instances'] as $instance) {
                    \App\Models\ReservationItemInstance::create([
                        'reservation_item_id' => $reservationItem->id,
                        'equipment_instance_id' => $instance->id,
                        'status' => 'reserved',
                        'reserved_at' => now(),
                    ]);
                    
                    // Note: We don't mark instance as unavailable here since the reservation might be for a future date
                    // The availability will be calculated dynamically based on the reservation dates
                }
            }

            // Auto-approve the reservation
            $reservation->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('reservation-management.index')
                ->with('success', 'Reservation created, approved, and equipment instances assigned successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create reservation: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Reservation $reservation)
    {
        $reservation->load([
            'user', 
            'createdBy',
            'items.equipment.category', 
            'items.equipment.equipmentType',
            'items.reservationItemInstances.equipmentInstance', 
            'approvedBy'
        ]);
        
        return view('admin-manager.reservation-management.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $reservation->load(['user', 'items.equipment']);
        $equipment = Equipment::where('is_active', true)->get();
        
        // Get statistics for the view
        $cancelledReservations = Reservation::where('status', 'cancelled')->count();
        
        return view('admin-manager.reservation-management.edit', compact('reservation', 'equipment', 'cancelledReservations'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,denied,picked_up,returned,completed,overdue,cancelled',
            'remarks' => 'nullable|string|max:1000',
            'pickup_date' => 'nullable|date',
            'approved_quantity' => 'nullable|array',
            'approved_quantity.*' => 'integer|min:0',
        ]);

        // Additional validation for pickup_date when status is approved or picked_up
        if (in_array($validated['status'], ['approved', 'picked_up']) && $validated['pickup_date']) {
            $request->validate([
                'pickup_date' => 'date|after_or_equal:today'
            ]);
        }

        // Validate logical status transitions
        $currentStatus = $reservation->status;
        $newStatus = $validated['status'];
        
        $allowedTransitions = [
            'pending' => ['approved', 'denied', 'cancelled'],
            'approved' => ['picked_up', 'denied', 'cancelled'],
            'picked_up' => ['returned', 'overdue'],
            'returned' => ['completed'],
            'overdue' => ['returned'], // Allow overdue to go back to returned
            'denied' => [], // No further transitions allowed
            'completed' => [], // No further transitions allowed
            'cancelled' => [], // No further transitions allowed
        ];
        
        // Prevent reverting from terminal states
        if (in_array($currentStatus, ['denied', 'completed', 'cancelled'])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot change status of a {$currentStatus} reservation. This is a terminal state."
                ], 400);
            }
            return redirect()->back()->withErrors([
                'status' => "Cannot change status of a {$currentStatus} reservation. This is a terminal state."
            ]);
        }
        
        if (!in_array($newStatus, $allowedTransitions[$currentStatus])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid status transition from '{$currentStatus}' to '{$newStatus}'. Allowed transitions: " . implode(', ', $allowedTransitions[$currentStatus])
                ], 400);
            }
            return redirect()->back()->withErrors([
                'status' => "Invalid status transition from '{$currentStatus}' to '{$newStatus}'. Allowed transitions: " . implode(', ', $allowedTransitions[$currentStatus])
            ]);
        }

        DB::beginTransaction();
        try {
            $oldStatus = $reservation->status;
            
            // Update reservation with status-specific timestamps
            $updateData = [
                'status' => $validated['status'],
                'remarks' => $validated['remarks'] ?? null,
                'pickup_date' => $validated['pickup_date'] ?? null,
                'approved_by' => auth()->id(),
            ];

            // Set appropriate timestamp based on status (only the correct fields)
            if ($validated['status'] === 'approved') {
                $updateData['approved_at'] = now();
            } elseif ($validated['status'] === 'cancelled') {
                $updateData['cancelled_at'] = now();
            } elseif ($validated['status'] === 'completed') {
                $updateData['completed_at'] = now();
            }

            $reservation->update($updateData);

            // Update approved quantities if provided
            if ($request->filled('approved_quantity')) {
                foreach ($request->approved_quantity as $itemId => $quantity) {
                    $item = $reservation->items()->find($itemId);
                    if ($item) {
                        $item->update(['quantity_approved' => $quantity]);
                    }
                }
            }

            // Handle status-specific logic
            if ($validated['status'] === 'approved') {
                foreach ($reservation->items as $item) {
                    $equipment = $item->equipment;
                    $approvedQuantity = $item->quantity_approved ?? $item->quantity_requested;
                    
                    // Check if enough instances are actually available before approval
                    $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                        $approvedQuantity,
                        $reservation->borrow_date,
                        $reservation->return_date,
                        $reservation->id
                    );
                    if (!$availabilityCheck['available']) {
                        DB::rollBack();
                        if ($request->ajax()) {
                            return response()->json([
                                'success' => false,
                                'message' => "Cannot approve reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$approvedQuantity} requested."
                            ], 400);
                        }
                        return redirect()->back()->withErrors([
                            'error' => "Cannot approve reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$approvedQuantity} requested."
                        ]);
                    }
                    
                    // Reserve and assign specific equipment instances
                    $reservationResult = $equipment->reserveInstances($approvedQuantity);
                    
                    if (!$reservationResult['success']) {
                        DB::rollBack();
                        if ($request->ajax()) {
                            return response()->json([
                                'success' => false,
                                'message' => $reservationResult['message']
                            ], 400);
                        }
                        return redirect()->back()->withErrors([
                            'error' => $reservationResult['message']
                        ]);
                    }
                    
                    // Create ReservationItemInstance records for the assigned instances
                    foreach ($reservationResult['instances'] as $instance) {
                        \App\Models\ReservationItemInstance::create([
                            'reservation_item_id' => $item->id,
                            'equipment_instance_id' => $instance->id,
                            'status' => 'reserved',
                        ]);
                        
                        // Mark instance as borrowed
                        $instance->update(['status' => 'borrowed', 'is_available' => false]);
                    }
                }
                
                // Clear equipment instances cache for all affected equipment
                foreach ($reservation->items as $item) {
                    $cacheKey = "equipment_instances_{$item->equipment_id}";
                    cache()->forget($cacheKey);
                }
            } elseif ($validated['status'] === 'picked_up') {
                // Assign instances and mark them as picked up
                foreach ($reservation->items as $item) {
                    $quantityToAssign = $item->quantity_approved ?? $item->quantity_requested;
                    
                    // Use helper method for atomic instance reservation
                    $reservationResult = $item->equipment->reserveInstances($quantityToAssign);
                    
                    if (!$reservationResult['success']) {
                        DB::rollBack();
                        if ($request->ajax()) {
                            return response()->json([
                                'success' => false,
                                'message' => $reservationResult['message']
                            ], 400);
                        }
                        return redirect()->back()->withErrors(['error' => $reservationResult['message']]);
                    }
                    
                    // Create the reservation-instance links
                    foreach ($reservationResult['instances'] as $instance) {
                        \App\Models\ReservationItemInstance::create([
                            'reservation_item_id' => $item->id,
                            'equipment_instance_id' => $instance->id,
                            'status' => 'picked_up',
                            'picked_up_at' => now(),
                        ]);
                        
                        // Mark instance as unavailable
                        $instance->update(['is_available' => false]);
                    }
                }
                
                $reservation->update(['picked_up_at' => now()]);
                
            } elseif ($validated['status'] === 'returned') {
                // Mark as returned but keep equipment instances reserved until completion
                $reservation->update(['returned_at' => now()]);
                
            } elseif ($validated['status'] === 'completed') {
                // Mark completion timestamp
                $reservation->update(['completed_at' => now()]);
                
                // Restore equipment availability for completed reservations
                foreach ($reservation->items as $item) {
                    foreach ($item->reservationItemInstances as $reservationItemInstance) {
                        $equipmentInstance = $reservationItemInstance->equipmentInstance;
                        if ($equipmentInstance) {
                            // Only restore availability if the instance is not damaged/needs repair/lost
                            if (!in_array($equipmentInstance->condition, ['damaged', 'needs_repair', 'lost'])) {
                                $equipmentInstance->update(['is_available' => true]);
                            }
                        }
                    }
                }
                
            } elseif ($validated['status'] === 'denied') {
                // If denying an approved or picked_up reservation, restore any reserved instances
                if (in_array($oldStatus, ['approved', 'picked_up'])) {
                    foreach ($reservation->items as $item) {
                        // Get all reservation item instances for this item
                        $reservationItemInstances = $item->reservationItemInstances;
                        
                        if ($reservationItemInstances->count() > 0) {
                            foreach ($reservationItemInstances as $reservationItemInstance) {
                                // Get the actual equipment instance
                                $equipmentInstance = $reservationItemInstance->equipmentInstance;
                                
                                if ($equipmentInstance) {
                                    // Mark equipment instance as available again
                                    $equipmentInstance->update(['is_available' => true]);
                                }
                            }
                            
                            // Remove the reservation-instance links
                            $item->reservationItemInstances()->delete();
                        }
                    }
                }
                
                // For pending reservations, we need to ensure quantity_available is implicitly restored
                if ($oldStatus === 'pending') {
                    foreach ($reservation->items as $item) {
                        $equipment = $item->equipment;
                        $quantityRequested = $item->quantity_requested;
                        
                        // Since quantity_available is a computed property, we don't explicitly increment a column.
                        // The availability is managed by the ReservationItemInstances and EquipmentInstances directly.
                        
                        \Log::info('Equipment quantity_available would be restored by instance changes after pending reservation denial in update (computed property)', [
                            'equipment_id' => $equipment->id,
                            'equipment_name' => $equipment->display_name,
                            'quantity_that_was_requested' => $quantityRequested,
                            'reservation_id' => $reservation->id
                        ]);
                    }
                }
                
            } elseif ($validated['status'] === 'cancelled') {
                // If cancelling an approved or picked_up reservation, restore any reserved instances
                if (in_array($oldStatus, ['approved', 'picked_up'])) {
                    foreach ($reservation->items as $item) {
                        // Get all reservation item instances for this item
                        $reservationItemInstances = $item->reservationItemInstances;
                        
                        if ($reservationItemInstances->count() > 0) {
                            foreach ($reservationItemInstances as $reservationItemInstance) {
                                // Get the actual equipment instance
                                $equipmentInstance = $reservationItemInstance->equipmentInstance;
                                
                                if ($equipmentInstance) {
                                    // Mark equipment instance as available again
                                    $equipmentInstance->update(['is_available' => true]);
                                }
                            }
                            
                            // Remove the reservation-instance links
                            $item->reservationItemInstances()->delete();
                        }
                    }
                }
                
                // For pending reservations, no instances were assigned, so nothing to restore
                if ($oldStatus === 'pending') {
                    \Log::info('Pending reservation cancelled - no instances to restore', [
                        'reservation_id' => $reservation->id,
                        'status' => 'cancelled'
                    ]);
                }
            }

            // Create notification if status changed and user is authenticated
            if ($oldStatus !== $validated['status'] && $reservation->user_id) {
                \Log::info("Status changed from {$oldStatus} to {$validated['status']} for reservation {$reservation->reservation_code}");
                NotificationService::createReservationStatusNotification(
                    $reservation, 
                    $validated['status'], 
                    $validated['remarks'] ?? null
                );
            } elseif ($oldStatus !== $validated['status']) {
                // For guest reservations
                \Log::info("Status changed from {$oldStatus} to {$validated['status']} for guest reservation {$reservation->reservation_code} (Email: {$reservation->email})");
                NotificationService::createReservationStatusNotification(
                    $reservation, 
                    $validated['status'], 
                    $validated['remarks'] ?? null
                );
            }

            DB::commit();

            $statusMessage = 'Reservation ' . $validated['status'] . ' successfully';
            if (in_array($validated['status'], ['approved', 'denied', 'returned', 'completed', 'cancelled'])) {
                $statusMessage .= '. Equipment availability has been updated.';
            }

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $statusMessage,
                    'reservation_id' => $reservation->id,
                    'new_status' => $validated['status']
                ]);
            }

            // Redirect to reservation details page after update
            if (str_contains($request->path(), 'admin')) {
                return redirect()->route('admin.reservations.show', $reservation)->with('success', $statusMessage);
            } else {
                return redirect()->route('reservation-management.show', $reservation)->with('success', $statusMessage);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update reservation: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to update reservation: ' . $e->getMessage()]);
        }
    }

    /**
     * Mark reservation as completed using centralized service
     */
    public function markCompleted(Request $request, Reservation $reservation)
    {
        try {
            $result = ReservationStatusService::updateStatus(
                $reservation,
                'completed',
                [
                    'remarks' => $request->remarks ?? null
                ],
                auth()->id()
            );

            if ($request->ajax()) {
                return response()->json($result);
            }

            return redirect()->route('reservation-management.show', $reservation)
                ->with('success', $result['message']);

        } catch (\InvalidArgumentException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to mark reservation as completed. Please try again.'
                ], 500);
            }
            return redirect()->back()->withErrors(['error' => 'Failed to mark reservation as completed. Please try again.']);
        }
    }

    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'reservation_ids' => 'required|array',
            'reservation_ids.*' => 'exists:reservations,id',
            'status' => 'required|in:approved,denied,picked_up,returned,completed,overdue,cancelled',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $reservationIds = $validated['reservation_ids'];
        $status = $validated['status'];
        $remarks = $validated['remarks'];

        DB::beginTransaction();
        try {
            $reservations = Reservation::whereIn('id', $reservationIds)->get();

            foreach ($reservations as $reservation) {
                $oldStatus = $reservation->status;
                
                // Validate logical status transitions for bulk update
                $allowedTransitions = [
                    'pending' => ['approved', 'denied', 'cancelled'],
                    'approved' => ['picked_up', 'denied', 'cancelled'],
                    'picked_up' => ['returned', 'overdue'],
                    'returned' => ['completed'],
                    'overdue' => ['returned'],
                    'denied' => [], // No further transitions allowed
                    'completed' => [], // No further transitions allowed
                    'cancelled' => [], // No further transitions allowed
                ];
                
                // Prevent reverting from terminal states
                if (in_array($oldStatus, ['denied', 'completed', 'cancelled'])) {
                    DB::rollBack();
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => "Cannot update reservation {$reservation->reservation_code} from '{$oldStatus}' to '{$status}'. This is a terminal state."
                        ], 400);
                    }
                    return redirect()->back()->withErrors([
                        'error' => "Cannot update reservation {$reservation->reservation_code} from '{$oldStatus}' to '{$status}'. This is a terminal state."
                    ]);
                }
                
                if (!in_array($status, $allowedTransitions[$oldStatus])) {
                    DB::rollBack();
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => "Cannot update reservation {$reservation->reservation_code} from '{$oldStatus}' to '{$status}'. Allowed transitions: " . implode(', ', $allowedTransitions[$oldStatus])
                        ], 400);
                    }
                    return redirect()->back()->withErrors([
                        'error' => "Cannot update reservation {$reservation->reservation_code} from '{$oldStatus}' to '{$status}'. Allowed transitions: " . implode(', ', $allowedTransitions[$oldStatus])
                    ]);
                }
                
                // Update reservation with status-specific timestamps
                $updateData = [
                    'status' => $status,
                    'remarks' => $remarks,
                    'approved_by' => auth()->id(),
                ];

                // Set appropriate timestamp based on status (only correct fields)
                if ($status === 'approved') {
                    $updateData['approved_at'] = now();
                } elseif ($status === 'cancelled') {
                    $updateData['cancelled_at'] = now();
                } elseif ($status === 'completed') {
                    $updateData['completed_at'] = now();
                }

                $reservation->update($updateData);

                // Handle status-specific logic
                if ($status === 'approved') {
                    foreach ($reservation->items as $item) {
                        $equipment = $item->equipment;
                        $approvedQuantity = $item->quantity_approved ?? $item->quantity_requested;
                        
                        // Check if enough instances are actually available before bulk approval
                        $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                            $approvedQuantity,
                            $reservation->borrow_date,
                            $reservation->return_date,
                            $reservation->id
                        );
                        if (!$availabilityCheck['available']) {
                            DB::rollBack();
                            if ($request->ajax()) {
                                return response()->json([
                                    'success' => false,
                                    'message' => "Cannot approve reservation {$reservation->reservation_code} for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$approvedQuantity} requested."
                                ], 400);
                            }
                            return redirect()->back()->withErrors([
                                'error' => "Cannot approve reservation {$reservation->reservation_code} for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$approvedQuantity} requested."
                            ]);
                        }
                        
                        // Reserve and assign specific equipment instances
                        $reservationResult = $equipment->reserveInstances($approvedQuantity);
                        
                        if (!$reservationResult['success']) {
                            DB::rollBack();
                            if ($request->ajax()) {
                                return response()->json([
                                    'success' => false,
                                    'message' => $reservationResult['message']
                                ], 400);
                            }
                            return redirect()->back()->withErrors([
                                'error' => $reservationResult['message']
                            ]);
                        }
                        
                        // Create ReservationItemInstance records for the assigned instances
                        foreach ($reservationResult['instances'] as $instance) {
                            \App\Models\ReservationItemInstance::create([
                                'reservation_item_id' => $item->id,
                                'equipment_instance_id' => $instance->id,
                                'status' => 'reserved',
                            ]);
                            
                            // Mark instance as borrowed
                            $instance->update(['status' => 'borrowed', 'is_available' => false]);
                        }
                    }
                    
                    // Clear equipment instances cache for all affected equipment
                    foreach ($reservation->items as $item) {
                        $cacheKey = "equipment_instances_{$item->equipment_id}";
                        cache()->forget($cacheKey);
                    }
                } elseif ($status === 'picked_up') {
                    // Assign instances and mark them as picked up
                    foreach ($reservation->items as $item) {
                        $quantityToAssign = $item->quantity_approved ?? $item->quantity_requested;
                        
                        // Use helper method for atomic instance reservation
                        $reservationResult = $item->equipment->reserveInstances($quantityToAssign);
                        
                        if (!$reservationResult['success']) {
                            DB::rollBack();
                            if ($request->ajax()) {
                                return response()->json([
                                    'success' => false,
                                    'message' => $reservationResult['message']
                                ], 400);
                            }
                            return redirect()->back()->withErrors(['error' => $reservationResult['message']]);
                        }
                        
                        // Create the reservation-instance links
                        foreach ($reservationResult['instances'] as $instance) {
                            \App\Models\ReservationItemInstance::create([
                                'reservation_item_id' => $item->id,
                                'equipment_instance_id' => $instance->id,
                                'status' => 'picked_up',
                                'picked_up_at' => now(),
                            ]);
                            
                            // Mark instance as unavailable
                            $instance->update(['is_available' => false]);
                        }
                    }
                    
                    $reservation->update(['picked_up_at' => now()]);
                    
                } elseif ($status === 'returned') {
                    // Mark as returned but keep equipment instances reserved until completion
                    $reservation->update(['returned_at' => now()]);
                    
                } elseif ($status === 'completed') {
                    // Restore equipment availability for completed reservations
                    foreach ($reservation->items as $item) {
                        foreach ($item->reservationItemInstances as $reservationItemInstance) {
                            $equipmentInstance = $reservationItemInstance->equipmentInstance;
                            if ($equipmentInstance) {
                                // Only restore availability if the instance is not damaged/needs repair/lost
                                if (!in_array($equipmentInstance->condition, ['damaged', 'needs_repair', 'lost'])) {
                                    $equipmentInstance->update(['is_available' => true]);
                                }
                            }
                        }
                    }
                    
                    $reservation->update(['completed_at' => now()]);
                    
                } elseif ($status === 'denied') {
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
                                    }
                                }
                                
                                // Remove the reservation-instance links
                                $item->instances()->delete();
                            }
                        }
                    }
                    
                    // For pending reservations, we need to ensure quantity_available is implicitly restored
                    if ($oldStatus === 'pending') {
                        foreach ($reservation->items as $item) {
                            $equipment = $item->equipment;
                            $quantityRequested = $item->quantity_requested;
                            
                            // Since quantity_available is a computed property, we don't explicitly increment a column.
                            // The availability is managed by the ReservationItemInstances and EquipmentInstances directly.
                            
                            \Log::info('Bulk update: Equipment quantity_available would be restored by instance changes after pending reservation denial (computed property)', [
                                'equipment_id' => $equipment->id,
                                'equipment_name' => $equipment->display_name,
                                'quantity_that_was_requested' => $quantityRequested,
                                'reservation_id' => $reservation->id
                            ]);
                        }
                    }
                } elseif ($status === 'cancelled') {
                    // If cancelling an approved or picked_up reservation, restore any reserved instances
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
                                    }
                                }
                                
                                // Remove the reservation-instance links
                                $item->instances()->delete();
                            }
                        }
                    }
                    
                    // For pending reservations, no instances were assigned, so nothing to restore
                    if ($oldStatus === 'pending') {
                        \Log::info('Bulk update: Pending reservation cancelled - no instances to restore', [
                            'reservation_id' => $reservation->id,
                            'status' => 'cancelled'
                        ]);
                    }
                }

                // Create notification if status changed
                if ($oldStatus !== $status && $reservation->user_id) {
                    \Log::info("Bulk update: Status changed from {$oldStatus} to {$status} for reservation {$reservation->reservation_code}");
                    NotificationService::createReservationStatusNotification(
                        $reservation, 
                        $status, 
                        $remarks
                    );
                } elseif ($oldStatus !== $status) {
                    // For guest reservations
                    \Log::info("Bulk update: Status changed from {$oldStatus} to {$status} for guest reservation {$reservation->reservation_code} (Email: {$reservation->email})");
                    NotificationService::createReservationStatusNotification(
                        $reservation, 
                        $status, 
                        $remarks
                    );
                }
            }

            DB::commit();

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Updated ' . count($reservationIds) . ' reservations successfully',
                    'updated_count' => count($reservationIds)
                ]);
            }

            return redirect()->route('reservation-management.index')
                ->with('success', 'Updated ' . count($reservationIds) . ' reservations successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update reservations: ' . $e->getMessage()]);
        }
    }

    public function destroy(Reservation $reservation)
    {
        // Check if reservation can be deleted
        if (in_array($reservation->status, ['approved', 'picked_up'])) {
            return back()->withErrors(['error' => 'Cannot delete approved or active reservations']);
        }

        $reservation->delete();

        return redirect()->route('reservation-management.index')
            ->with('success', 'Reservation deleted successfully');
    }

    public function calendar()
    {
        $reservations = Reservation::with(['user', 'items.equipment'])
            ->whereIn('status', ['approved', 'picked_up'])
            ->get()
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'title' => $reservation->user ? $reservation->user->name : $reservation->name,
                    'start' => $reservation->borrow_date,
                    'end' => $reservation->return_date,
                    'status' => $reservation->status,
                    'url' => route('reservation-management.show', $reservation),
                ];
            });

        return view('admin-manager.reservation-management.calendar', compact('reservations'));
    }

    public function reports(Request $request)
    {
        $year = $request->filled('year') ? $request->year : date('Y');
        $month = $request->filled('month') ? $request->month : null;

        $query = Reservation::query();

        if ($month) {
            $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } else {
            $query->whereYear('created_at', $year);
        }

        // Monthly trends
        $monthlyTrends = Reservation::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Status distribution
        $statusDistribution = $query->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Equipment popularity
        $equipmentPopularity = Equipment::with('category')
            ->withCount(['reservationItems' => function ($q) use ($year, $month) {
                if ($month) {
                    $q->whereHas('reservation', function ($r) use ($year, $month) {
                        $r->whereYear('created_at', $year)->whereMonth('created_at', $month);
                    });
                } else {
                    $q->whereHas('reservation', function ($r) use ($year) {
                        $r->whereYear('created_at', $year);
                    });
                }
            }])
            ->orderBy('reservation_items_count', 'desc')
            ->limit(15)
            ->get();

        // User activity
        $userActivity = User::withCount(['reservations' => function ($q) use ($year, $month) {
            if ($month) {
                $q->whereYear('created_at', $year)->whereMonth('created_at', $month);
            } else {
                $q->whereYear('created_at', $year);
            }
        }])
        ->orderBy('reservations_count', 'desc')
        ->limit(10)
        ->get();

        return view('admin-manager.reservation-management.reports', compact(
            'monthlyTrends', 'statusDistribution', 'equipmentPopularity', 'userActivity', 'year', 'month'
        ));
    }

    public function generatePDF(Request $request)
    {
        try {
            // Get filters from request
            $filters = $request->only(['status', 'user', 'equipment', 'category', 'equipment_type', 'date_from', 'date_to', 'borrow_date_from', 'borrow_date_to', 'report_type']);
            
            // Build query with filters
            $query = Reservation::with(['user', 'items.equipment.category']);
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('report_type') && $request->report_type !== 'all') {
                $status = $request->report_type;
                $valid = ['pending','approved','picked_up','cancelled','declined','overdue','completed'];
                if (in_array($status, $valid, true)) {
                    if ($status === 'overdue') {
                        $query->where('status', 'picked_up')->whereDate('return_date', '<', now()->toDateString());
                    } else {
                        $query->where('status', $status);
                    }
                }
            }
            
            if ($request->filled('user')) {
                $query->where(function($q) use ($request) {
                    $q->whereHas('user', function($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->user . '%')
                                  ->orWhere('email', 'like', '%' . $request->user . '%');
                    })->orWhere('name', 'like', '%' . $request->user . '%')
                      ->orWhere('email', 'like', '%' . $request->email . '%');
                });
            }
            
            if ($request->filled('equipment')) {
                $query->whereHas('items.equipment', function($equipmentQuery) use ($request) {
                    $equipmentQuery->where('brand', 'like', '%' . $request->equipment . '%')
                                  ->orWhere('model', 'like', '%' . $request->equipment . '%');
                });
            }
            
            if ($request->filled('category')) {
                $query->whereHas('items.equipment.category', function($categoryQuery) use ($request) {
                    $categoryQuery->where('id', $request->category);
                });
            }
            
            if ($request->filled('equipment_type')) {
                $query->whereHas('items.equipment.equipmentType', function($typeQuery) use ($request) {
                    $typeQuery->where('id', $request->equipment_type);
                });
            }
            
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            if ($request->filled('borrow_date_from')) {
                $query->whereDate('borrow_date', '>=', $request->borrow_date_from);
            }
            if ($request->filled('borrow_date_to')) {
                $query->whereDate('borrow_date', '<=', $request->borrow_date_to);
            }
            
            $reservations = $query->latest()->get();
            
            // Generate PDF
            $pdf = \App\Services\PDFService::generateReservationReport($reservations, $filters);
            
            $filename = 'reservation_report_' . now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
        }
    }

    public function exportReservations(Request $request)
    {
        // Safety: ensure the XLSX generator class is available even if autoload cache lags
        if (!class_exists(\Shuchkin\SimpleXLSXGen::class)) {
            $possiblePath = base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');
            if (file_exists($possiblePath)) {
                require_once $possiblePath;
            }
        }

        $reservations = Reservation::with(['user', 'items.equipment'])
            ->when($request->filled('status'), function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('date_from'), function($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->date_to);
            })
            ->get();

        // Build Excel rows
        $rows = [];
        $rows[] = ['ID', 'Code', 'User', 'Email', 'Status', 'Borrow Date', 'Return Date', 'Reason', 'Equipment', 'Quantity', 'Created At'];
        foreach ($reservations as $reservation) {
            foreach ($reservation->items as $item) {
                $rows[] = [
                    $reservation->id,
                    $reservation->reservation_code,
                    $reservation->user ? $reservation->user->name : $reservation->name,
                    $reservation->user ? $reservation->user->email : $reservation->email,
                    $reservation->status,
                    (string) $reservation->borrow_date,
                    (string) $reservation->return_date,
                    $reservation->reason,
                    $item->equipment->display_name,
                    $item->quantity_requested,
                    (string) $reservation->created_at,
                ];
            }
        }

        $filename = 'reservations-export-' . date('Y-m-d-His') . '.xlsx';
        SimpleXLSXGen::fromArray($rows)->downloadAs($filename);
        return response()->noContent();
    }

    public function pendingApprovals()
    {
        $pendingReservations = Reservation::with(['user', 'items.equipment.category'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin-manager.reservation-management.pending-approvals', compact('pendingReservations'));
    }

    public function overdueReservations()
    {
        // Get all picked_up reservations and filter for real-time overdue status
        $overdueReservations = Reservation::with(['user', 'items.equipment.category'])
            ->where('status', 'picked_up')
            ->get()
            ->filter(function ($reservation) {
                return $reservation->isOverdue();
            })
            ->sortByDesc('created_at')
            ->values();

        // Convert to paginated collection
        $perPage = 15;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $items = $overdueReservations->slice($offset, $perPage)->values();
        
        $overdueReservations = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $overdueReservations->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'pageName' => 'page']
        );

        return view('admin-manager.reservation-management.overdue', compact('overdueReservations'));
    }

    /**
     * Check overdue status for specific reservations (AJAX)
     */
    public function checkOverdueStatus(Request $request)
    {
        $reservationIds = $request->input('reservation_ids', []);
        
        if (empty($reservationIds)) {
            return response()->json(['overdue_reservations' => []]);
        }

        $overdueReservations = Reservation::whereIn('id', $reservationIds)
            ->where('status', 'picked_up')
            ->get()
            ->filter(function ($reservation) {
                return $reservation->isOverdue();
            })
            ->map(function ($reservation) {
                return [
                    'id' => $reservation->id,
                    'is_overdue' => true,
                    'days_overdue' => $reservation->days_overdue,
                    'return_datetime' => $reservation->return_datetime
                ];
            });

        return response()->json([
            'overdue_reservations' => $overdueReservations->values()->toArray()
        ]);
    }



    /**
     * Fix reservations that are in picked_up status but don't have assigned instances
     */
    public function fixPickedUpReservation(Reservation $reservation)
    {
        // Check if reservation is in picked_up status
        if ($reservation->status !== 'picked_up') {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservation must be in picked_up status to assign instances.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Reservation must be in picked_up status to assign instances.']);
        }

        // Check if reservation already has assigned instances
        $assignedCount = $reservation->items->sum(function ($item) { 
            return $item->instances->count(); 
        });
        
        if ($assignedCount > 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservation already has assigned equipment instances.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Reservation already has assigned equipment instances.']);
        }

        DB::beginTransaction();
        try {
            foreach ($reservation->items as $item) {
                $quantityToAssign = $item->quantity_requested;
                
                // Use helper method for atomic instance reservation
                $reservationResult = $item->equipment->reserveInstances($quantityToAssign);
                
                if (!$reservationResult['success']) {
                    DB::rollBack();
                    if (request()->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => $reservationResult['message']
                        ], 400);
                    }
                    return back()->withErrors(['error' => $reservationResult['message']]);
                }
                
                // Assign the reserved instances
                foreach ($reservationResult['instances'] as $instance) {
                    // Double-check availability before assignment
                    if (!$instance->is_available || !$instance->is_active) {
                        DB::rollBack();
                        if (request()->ajax()) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Equipment instance became unavailable during assignment. Please try again.'
                            ], 400);
                        }
                        return back()->withErrors(['error' => 'Equipment instance became unavailable during assignment. Please try again.']);
                    }
                    
                    // Create the reservation-instance link
                    \App\Models\ReservationItemInstance::create([
                        'reservation_item_id' => $item->id,
                        'equipment_instance_id' => $instance->id,
                        'status' => 'picked_up',
                        'picked_up_at' => now(),
                    ]);
                    
                    // Lock the instance from others
                    $instance->update(['is_available' => false]);
                }
            }

            DB::commit();

            return redirect()->route('reservation-management.index')
                ->with('success', 'Equipment instances successfully assigned to reservation ' . $reservation->reservation_code);

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Check if this is an AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to assign equipment instances: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to assign equipment instances: ' . $e->getMessage()]);
        }
    }

    /**
     * Quick action to mark a reservation as picked up
     */
    public function markAsPickedUp(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'pickup_condition' => 'required|string|in:excellent,good,fair,needs_repair,damaged',
            'pickup_notes' => 'nullable|string|max:1000',
        ]);

        // Check if reservation can be marked as picked up
        if ($reservation->status !== 'approved') {
            if ($reservation->status === 'picked_up') {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Reservation is already marked as picked up.'
                    ], 400);
                }
                return back()->withErrors(['error' => 'Reservation is already marked as picked up.']);
            }
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reservation must be approved to mark as picked up.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Reservation must be approved to mark as picked up.']);
        }

        // Check if reservation already has assigned instances
        $assignedCount = $reservation->items->sum(function ($item) { 
            return $item->instances->count(); 
        });
        
        if ($assignedCount > 0) {
            // If there are already instances, this means they were reserved during creation
            // We just need to update the status to picked_up and update the instance status
            DB::beginTransaction();
            try {
                // Update reservation status to picked_up
                $reservation->update([
                    'status' => 'picked_up',
                    'approved_by' => auth()->id(),
                    'picked_up_at' => now(),
                    'pickup_condition' => $validated['pickup_condition'],
                    'pickup_notes' => $validated['pickup_notes'],
                ]);

                // Update existing reserved instances to picked_up status
                foreach ($reservation->items as $item) {
                    foreach ($item->reservationItemInstances as $reservationItemInstance) {
                        $equipmentInstance = $reservationItemInstance->equipmentInstance;
                        if ($equipmentInstance) {
                            // Update the reservation item instance status
                            $reservationItemInstance->update([
                                'status' => 'picked_up',
                                'picked_up_at' => now(),
                            ]);
                            
                            // Ensure instance is marked as unavailable
                            $equipmentInstance->update(['is_available' => false]);
                        }
                    }
                }

                DB::commit();

                // Create notification for both authenticated and guest users AFTER successful commit
                NotificationService::createReservationStatusNotification(
                    $reservation, 
                    'picked_up', 
                    'Equipment has been picked up successfully.'
                );

                // Check if this is an AJAX request
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Reservation marked as picked up successfully. Equipment instances were already reserved and are now marked as picked up.',
                        'reservation_id' => $reservation->id,
                        'new_status' => 'picked_up'
                    ]);
                }

                // Redirect to reservation details page after update
                if (request()->is('admin/*')) {
                    return redirect()->route('admin.reservations.show', $reservation)
                        ->with('success', 'Reservation marked as picked up successfully. Equipment instances were already reserved and are now marked as picked up.');
                } else {
                    return redirect()->route('reservation-management.show', $reservation)
                        ->with('success', 'Reservation marked as picked up successfully. Equipment instances were already reserved and are now marked as picked up.');
                }

            } catch (\Exception $e) {
                DB::rollBack();
                
                // Check if this is an AJAX request
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to mark reservation as picked up: ' . $e->getMessage()
                    ], 500);
                }
                
                return back()->withErrors(['error' => 'Failed to mark reservation as picked up: ' . $e->getMessage()]);
            }
        }

        // If no instances are assigned, this is a regular approved reservation that needs instances assigned
        DB::beginTransaction();
        try {
            // Update status to picked_up
            $reservation->update([
                'status' => 'picked_up',
                'approved_by' => auth()->id(),
                'picked_up_at' => now(),
                'pickup_condition' => $validated['pickup_condition'],
                'pickup_notes' => $validated['pickup_notes'],
            ]);

            // Assign instances
            foreach ($reservation->items as $item) {
                $quantityToAssign = $item->quantity_approved ?? $item->quantity_requested;
                
                // Use helper method for atomic instance reservation
                $reservationResult = $item->equipment->reserveInstances($quantityToAssign);
                
                if (!$reservationResult['success']) {
                    DB::rollBack();
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => $reservationResult['message']
                        ], 400);
                    }
                    return back()->withErrors(['error' => $reservationResult['message']]);
                }
                
                // Create the reservation-instance links
                foreach ($reservationResult['instances'] as $instance) {
                    \App\Models\ReservationItemInstance::create([
                        'reservation_item_id' => $item->id,
                        'equipment_instance_id' => $instance->id,
                        'status' => 'picked_up',
                        'picked_up_at' => now(),
                    ]);
                    
                    // Mark instance as unavailable
                    $instance->update(['is_available' => false]);
                }
            }

            DB::commit();

            // Create notification for both authenticated and guest users AFTER successful commit
            NotificationService::createReservationStatusNotification(
                $reservation, 
                'picked_up', 
                'Equipment has been picked up successfully.'
            );

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reservation marked as picked up successfully. Equipment instances assigned.',
                    'reservation_id' => $reservation->id,
                    'new_status' => 'picked_up'
                ]);
            }

            // Redirect to reservation details page after update
            if (request()->is('admin/*')) {
                return redirect()->route('admin.reservations.show', $reservation)
                    ->with('success', 'Reservation marked as picked up successfully. Equipment instances assigned.');
            } else {
                return redirect()->route('reservation-management.show', $reservation)
                    ->with('success', 'Reservation marked as picked up successfully. Equipment instances assigned.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to mark reservation as picked up: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to mark reservation as picked up: ' . $e->getMessage()]);
        }
    }

    /**
     * Quick action to approve a reservation
     */
    public function approveReservation(Request $request, Reservation $reservation)
    {
        // Check if reservation can be approved
        if ($reservation->status !== 'pending') {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending reservations can be approved.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Only pending reservations can be approved.']);
        }

        // Check if reservation dates have already passed
        $now = now();
        $borrowDateTime = \Carbon\Carbon::parse($reservation->borrow_date->format('Y-m-d') . ' ' . $reservation->borrow_time->format('H:i:s'));
        $returnDateTime = \Carbon\Carbon::parse($reservation->return_date->format('Y-m-d') . ' ' . $reservation->return_time->format('H:i:s'));
        
        // If return date has passed, block approval completely
        if ($now->gt($returnDateTime)) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot approve reservation: The return date and time have already passed. Please deny this reservation or contact the user to reschedule.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Cannot approve reservation: The return date and time have already passed. Please deny this reservation or contact the user to reschedule.']);
        }
        
        // If borrow date has passed but return date hasn't, allow approval with warning
        if ($now->gt($borrowDateTime)) {
            \Log::warning("Approving reservation with passed borrow date", [
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'borrow_date' => $borrowDateTime->format('Y-m-d H:i:s'),
                'current_time' => $now->format('Y-m-d H:i:s')
            ]);
        }

        try {
            $validated = $request->validate([
                'pickup_date' => 'required|date|after_or_equal:today',
                'remarks' => 'nullable|string|max:1000',
                'equipment_quantities' => 'nullable|array',
                'equipment_quantities.*' => 'integer|min:0',
                'approved_equipment' => 'nullable|array',
                'approved_equipment.*.item_id' => 'required|integer',
                'approved_equipment.*.quantity' => 'required|integer|min:1',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed for approval', [
                'reservation_id' => $reservation->id,
                'errors' => $e->validator->errors()->all(),
                'request_data' => $request->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
                ], 422);
            }
            throw $e;
        }

        DB::beginTransaction();
        try {
            // Log the incoming data for debugging
            \Log::info('Approving reservation', [
                'reservation_id' => $reservation->id,
                'pickup_date' => $validated['pickup_date'],
                'approved_equipment' => $validated['approved_equipment'] ?? [],
                'equipment_quantities' => $validated['equipment_quantities'] ?? []
            ]);
            
            // Process equipment quantities - handle both old and new data structures
            $equipmentQuantities = $validated['equipment_quantities'] ?? [];
            $approvedEquipment = $validated['approved_equipment'] ?? [];
            $itemsToProcess = [];
            
            // If we have the new approved_equipment structure, use it
            if (!empty($approvedEquipment)) {
                foreach ($approvedEquipment as $approvedItem) {
                    $itemId = $approvedItem['item_id'];
                    $approvedQuantity = $approvedItem['quantity'];
                    
                    // Find the reservation item
                    $item = $reservation->items->firstWhere('id', $itemId);
                    if (!$item) {
                        continue;
                    }
                    
                    $equipment = $item->equipment;
                    $itemsToProcess[] = [
                        'item' => $item,
                        'equipment' => $equipment,
                        'approved_quantity' => $approvedQuantity
                    ];
                }
            } else {
                // Fall back to old structure
                foreach ($reservation->items as $item) {
                    $equipment = $item->equipment;
                    $itemId = $item->id;
                    
                    // Get approved quantity (from form or fall back to requested)
                    $approvedQuantity = isset($equipmentQuantities[$itemId]) 
                        ? (int)$equipmentQuantities[$itemId] 
                        : $item->quantity_requested;
                    
                    // Skip items with 0 quantity (removed by admin)
                    if ($approvedQuantity <= 0) {
                        continue;
                    }
                    
                    $itemsToProcess[] = [
                        'item' => $item,
                        'equipment' => $equipment,
                        'approved_quantity' => $approvedQuantity
                    ];
                }
            }
            
            // Check availability for all items to process
            foreach ($itemsToProcess as $itemData) {
                $equipment = $itemData['equipment'];
                $approvedQuantity = $itemData['approved_quantity'];
                
                $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                    $approvedQuantity,
                    $reservation->borrow_date,
                    $reservation->return_date,
                    $reservation->id
                );
                
                if (!$availabilityCheck['available']) {
                    DB::rollBack();
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => false,
                            'message' => "Cannot approve reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$approvedQuantity} requested."
                        ], 400);
                    }
                    return back()->withErrors([
                        'error' => "Cannot approve reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$approvedQuantity} requested."
                    ]);
                }
            }
            
            // Check if at least one item is being approved
            if (empty($itemsToProcess)) {
                DB::rollBack();
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'At least one equipment item must be approved.'
                    ], 400);
                }
                return back()->withErrors([
                    'error' => 'At least one equipment item must be approved.'
                ]);
            }

            // Update reservation status
            $reservation->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'pickup_date' => $validated['pickup_date'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // First, set quantity_approved to 0 for ALL items (unapproved by default)
            foreach ($reservation->items as $item) {
                $item->update(['quantity_approved' => 0]);
            }

            // Now assign equipment instances to this reservation and update approved quantities
            foreach ($itemsToProcess as $itemData) {
                $item = $itemData['item'];
                $equipment = $itemData['equipment'];
                $approvedQuantity = $itemData['approved_quantity'];
                
                // Update the item's approved quantity
                $item->update(['quantity_approved' => $approvedQuantity]);
                
                // Get available instances and assign them
                $availableInstances = $equipment->availableInstances()->take($approvedQuantity)->get();
                
                foreach ($availableInstances as $instance) {
                    // Create the reservation-instance link
                    \App\Models\ReservationItemInstance::create([
                        'reservation_item_id' => $item->id,
                        'equipment_instance_id' => $instance->id,
                        'status' => 'reserved',
                        'reserved_at' => now(),
                    ]);
                    
                    // Note: We don't mark instance as unavailable here since the reservation might be for a future date
                    // The availability will be calculated dynamically based on the reservation dates
                }
                
                \Log::info('Equipment instances assigned to approved reservation', [
                    'reservation_id' => $reservation->id,
                    'equipment_id' => $equipment->id,
                    'equipment_name' => $equipment->display_name,
                    'quantity_requested' => $item->quantity_requested,
                    'quantity_approved' => $approvedQuantity,
                    'instances_assigned' => $availableInstances->count(),
                    'new_quantity_available' => $equipment->fresh()->quantity_available
                ]);
            }

            DB::commit();

            // Create notification for both authenticated and guest users AFTER successful commit
            NotificationService::createReservationStatusNotification(
                $reservation, 
                'approved', 
                $validated['remarks'] ?? 'Your reservation has been approved!'
            );

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reservation approved successfully. Pickup date set to ' . $validated['pickup_date'],
                    'reservation_id' => $reservation->id,
                    'new_status' => 'approved'
                ]);
            }

            // Redirect to reservation details page after update
            if (request()->is('admin/*')) {
                return redirect()->route('admin.reservations.show', $reservation)
                    ->with('success', 'Reservation approved successfully. Pickup date set to ' . $validated['pickup_date']);
            } else {
                return redirect()->route('reservation-management.show', $reservation)
                    ->with('success', 'Reservation approved successfully. Pickup date set to ' . $validated['pickup_date']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to approve reservation: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to approve reservation: ' . $e->getMessage()]);
        }
    }

    /**
     * Get approval data for a reservation (for the approval modal)
     */
    public function getApprovalData(Reservation $reservation)
    {
        try {
            // Load reservation with relationships
            $reservation->load([
                'user:id,name,email',
                'items.equipment:id,brand,model,category_id,equipment_type_id',
                'items.equipment.category:id,name',
                'items.equipment.equipmentType:id,name'
            ]);

            // Format reservation data
            $reservationData = [
                'id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                // Support guest reservations without a related user
                'user_name' => $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest'),
                'borrow_date' => $reservation->borrow_date->format('M d, Y'),
                'return_date' => $reservation->return_date->format('M d, Y'),
                'borrow_time' => $reservation->borrow_time ? \Carbon\Carbon::parse($reservation->borrow_time)->format('g:i A') : null,
                'return_time' => $reservation->return_time ? \Carbon\Carbon::parse($reservation->return_time)->format('g:i A') : null,
                'borrow_date_iso' => $reservation->borrow_date->format('Y-m-d'),
                'return_date_iso' => $reservation->return_date->format('Y-m-d'),
            ];

            // Get equipment data with availability
            $equipmentData = [];
            foreach ($reservation->items as $item) {
                $equipment = $item->equipment;
                
                // Check availability for the requested quantity
                $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                    $item->quantity_requested,
                    $reservation->borrow_date,
                    $reservation->return_date,
                    $reservation->id
                );

                $equipmentData[] = [
                    'item_id' => $item->id,
                    'equipment_name' => $equipment->display_name,
                    // Use null-safe access to avoid 500s when relations are missing
                    'category' => $equipment->category->name ?? 'Uncategorized',
                    'equipment_type' => $equipment->equipmentType->name ?? 'N/A',
                    'requested_quantity' => $item->quantity_requested,
                    'available_quantity' => $availabilityCheck['available_count'],
                    'is_available' => $availabilityCheck['available']
                ];
            }

            return response()->json([
                'success' => true,
                'reservation' => $reservationData,
                'equipment' => $equipmentData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load reservation data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Quick action to decline a reservation
     */
    public function declineReservation(Request $request, Reservation $reservation)
    {
        // Check if reservation can be declined
        if (!in_array($reservation->status, ['pending', 'approved'])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending or approved reservations can be declined.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Only pending or approved reservations can be declined.']);
        }

        $validated = $request->validate([
            'reason' => 'required|string|in:equipment_unavailable,insufficient_quantity,maintenance_required,invalid_reservation,policy_violation,duplicate_reservation,schedule_conflict,other',
            'remarks' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $reservation->status;
            
            // Update reservation status
            $reservation->update([
                'status' => 'denied',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'reason' => $validated['reason'],
                'remarks' => $validated['remarks'],
            ]);

            // If declining an approved reservation, restore any reserved instances
            if ($oldStatus === 'approved') {
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
                                
                                \Log::info('Equipment instance restored to available after decline', [
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
                
                \Log::info('Equipment instances restored to available status after decline', [
                    'reservation_id' => $reservation->id,
                    'items_count' => $reservation->items->count()
                ]);
            }
            
            // For pending reservations, no instances were assigned, so nothing to restore
            if ($oldStatus === 'pending') {
                \Log::info('Pending reservation declined - no instances to restore', [
                    'reservation_id' => $reservation->id,
                    'status' => 'denied'
                ]);
            }

            DB::commit();

            // Create notification for both authenticated and guest users AFTER successful commit
            NotificationService::createReservationStatusNotification(
                $reservation, 
                'denied', 
                $validated['remarks']
            );

            $message = 'Reservation declined successfully';
            if ($oldStatus === 'approved') {
                $message .= '. Equipment instances have been restored to available status.';
            }

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'reservation_id' => $reservation->id,
                    'new_status' => 'denied'
                ]);
            }

            // Redirect to reservation details page after update
            if (request()->is('admin/*')) {
                return redirect()->route('admin.reservations.show', $reservation)
                    ->with('success', $message);
            } else {
                return redirect()->route('reservation-management.show', $reservation)
                    ->with('success', $message);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to decline reservation: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to decline reservation: ' . $e->getMessage()]);
        }
    }

    /**
     * Quick action to cancel a reservation
     */
    public function cancelReservation(Request $request, Reservation $reservation)
    {
        // Check if reservation can be cancelled
        if (!in_array($reservation->status, ['pending', 'approved'])) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending or approved reservations can be cancelled.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Only pending or approved reservations can be cancelled.']);
        }

        $validated = $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $oldStatus = $reservation->status;
            
            // Update reservation status
            $reservation->update([
                'status' => 'cancelled',
                'approved_by' => auth()->id(),
                'cancelled_at' => now(),
                'remarks' => $validated['remarks'],
            ]);

            // If cancelling an approved reservation, restore any reserved instances
            if ($oldStatus === 'approved') {
                foreach ($reservation->items as $item) {
                    // Get all reservation item instances for this item
                    $reservationItemInstances = $item->reservationItemInstances;
                    
                    if ($reservationItemInstances->count() > 0) {
                        foreach ($reservationItemInstances as $reservationItemInstance) {
                            // Get the actual equipment instance
                            $equipmentInstance = $reservationItemInstance->equipmentInstance;
                            
                            if ($equipmentInstance) {
                                // Mark equipment instance as available again
                                $equipmentInstance->update(['is_available' => true]);
                                
                                \Log::info('Equipment instance restored to available after cancellation', [
                                    'instance_id' => $equipmentInstance->id,
                                    'instance_code' => $equipmentInstance->instance_code,
                                    'reservation_id' => $reservation->id
                                ]);
                            }
                        }
                        
                        // Remove the reservation-instance links
                        $item->reservationItemInstances()->delete();
                    }
                }
                
                \Log::info('Equipment instances restored to available status after cancellation', [
                    'reservation_id' => $reservation->id,
                    'items_count' => $reservation->items->count()
                ]);
            }
            
            // For pending reservations, no instances were assigned, so nothing to restore
            if ($oldStatus === 'pending') {
                \Log::info('Pending reservation cancelled - no instances to restore', [
                    'reservation_id' => $reservation->id,
                    'status' => 'cancelled'
                ]);
            }

            DB::commit();

            // Create notification for both authenticated and guest users AFTER successful commit
            NotificationService::createReservationStatusNotification(
                $reservation, 
                'cancelled', 
                $validated['remarks']
            );

            $message = 'Reservation cancelled successfully';
            if ($oldStatus === 'approved') {
                $message .= '. Equipment instances have been restored to available status.';
            }

            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'reservation_id' => $reservation->id,
                    'new_status' => 'cancelled'
                ]);
            }

            // Redirect to reservation details page after update
            if (request()->is('admin/*')) {
                return redirect()->route('admin.reservations.show', $reservation)
                    ->with('success', $message);
            } else {
                return redirect()->route('reservation-management.show', $reservation)
                    ->with('success', $message);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Check if this is an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel reservation: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to cancel reservation: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the pickup form for a reservation
     */
    public function showPickupForm(Reservation $reservation)
    {
        // Check if reservation can be picked up
        if ($reservation->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved reservations can be picked up.');
        }

        // Load the reservation with its items and equipment instances
        $reservation->load([
            'items.equipment.equipmentType', 
            'items.equipment.instances',
            'items.reservationItemInstances.equipmentInstance'
        ]);

        // Filter items to only show approved equipment (quantity_approved > 0)
        $reservation->items = $reservation->items->filter(function($item) {
            return $item->quantity_approved > 0;
        });

        return view('equipment-pickup.pickup-form', compact('reservation'));
    }

    /**
     * Get reservation equipment data for approval modal
     */
    public function getReservationEquipmentData(Reservation $reservation)
    {
        try {
            // Load reservation with equipment data
            $reservation->load([
                'items.equipment.category',
                'items.equipment.equipmentType',
                'items.equipment.instances' => function($query) {
                    $query->where('is_active', true)
                          ->where('is_available', true);
                }
            ]);

            $equipmentData = [];
            foreach ($reservation->items as $item) {
                $equipment = $item->equipment;
                
                // Calculate availability for the reservation dates
                $availabilityCheck = $equipment->hasAvailableInstancesForDates(
                    $item->quantity_requested,
                    $reservation->borrow_date,
                    $reservation->return_date
                );

                $equipmentData[] = [
                    'item_id' => $item->id,
                    'equipment_id' => $equipment->id,
                    'equipment_name' => $equipment->display_name,
                    'category' => $equipment->category->name ?? 'Uncategorized',
                    'equipment_type' => $equipment->equipmentType->name ?? 'N/A',
                    'quantity_requested' => $item->quantity_requested,
                    'quantity_approved' => $item->quantity_approved ?? 0,
                    'quantity_available' => $availabilityCheck['available_count'],
                    'is_available' => $availabilityCheck['available'],
                    'max_available' => $equipment->quantity_available,
                    'total_instances' => $equipment->quantity_total
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $equipmentData,
                'reservation' => [
                    'id' => $reservation->id,
                    'reservation_code' => $reservation->reservation_code,
                    'user_name' => $reservation->user ? $reservation->user->name : $reservation->name,
                    'borrow_date' => $reservation->borrow_date->format('M d, Y'),
                    'return_date' => $reservation->return_date->format('M d, Y')
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to get reservation equipment data', [
                'reservation_id' => $reservation->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to load equipment data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process the pickup form submission
     */
    public function processPickup(Request $request, Reservation $reservation)
    {
        // Debug: Log the incoming request data
        \Log::info('Pickup form data received - SIMPLIFIED', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user() ? auth()->user()->email : 'NO USER',
            'session_id' => session()->getId(),
            'reservation_id' => $reservation->id,
            'reservation_status' => $reservation->status,
            'equipment_instances' => $request->input('equipment_instances'),
            'pickup_conditions' => $request->input('pickup_conditions'),
            'pickup_notes' => $request->input('pickup_notes'),
            'all_data' => $request->all(),
            'timestamp' => now()->toDateTimeString()
        ]);

        try {
            $validated = $request->validate([
                'equipment_instances' => 'required|array',
                'equipment_instances.*' => 'required|array',
                'equipment_instances.*.*' => 'required|exists:equipment_instances,id',
                'pickup_conditions' => 'nullable|array',
                'pickup_conditions.*' => 'nullable|array',
                'pickup_conditions.*.*' => 'nullable|string|in:excellent,good,fair',
                'pickup_notes' => 'nullable|array',
                'pickup_notes.*' => 'nullable|array',
                'pickup_notes.*.*' => 'nullable|string|max:1000',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Pickup validation failed - DETAILED DEBUG INFO', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user() ? auth()->user()->email : 'NO USER',
                'session_id' => session()->getId(),
                'reservation_id' => $reservation->id,
                'reservation_status' => $reservation->status,
                'validation_errors' => $e->errors(),
                'request_data' => $request->all(),
                'timestamp' => now()->toDateTimeString()
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('debug_info', [
                    'user_id' => auth()->id(),
                    'session_id' => session()->getId(),
                    'validation_errors' => $e->errors(),
                    'timestamp' => now()->toDateTimeString()
                ]);
        }

        // Simple business logic validation
        $errors = [];
        
        // Check for duplicate instance selections
        $allSelectedInstances = [];
        foreach ($validated['equipment_instances'] as $instances) {
            foreach ($instances as $instanceId) {
                $allSelectedInstances[] = $instanceId;
            }
        }
        $uniqueInstances = array_unique($allSelectedInstances);
        if (count($allSelectedInstances) !== count($uniqueInstances)) {
            $errors[] = "You cannot select the same equipment instance multiple times.";
        }
        
        // Validate that instances exist and are available
        foreach ($validated['equipment_instances'] as $itemId => $instances) {
            foreach ($instances as $index => $instanceId) {
                $instance = \App\Models\EquipmentInstance::find($instanceId);
                if (!$instance) {
                    $errors[] = "Selected equipment instance does not exist.";
                    continue;
                }
                
                if (!$instance->is_active) {
                    $errors[] = "Selected equipment instance is not active and cannot be picked up.";
                    continue;
                }
                
                // Check if this instance is already assigned to this reservation item
                $existingAssignment = \App\Models\ReservationItemInstance::where([
                    'reservation_item_id' => $itemId,
                    'equipment_instance_id' => $instanceId
                ])->first();
                
                // Only check availability if the instance is not already assigned to this reservation
                if (!$existingAssignment && !$instance->is_available) {
                    $errors[] = "Selected equipment instance is not available and cannot be picked up.";
                    continue;
                }
                
                if (in_array($instance->condition, ['damaged', 'needs_repair', 'lost', 'under_maintenance'])) {
                    $errors[] = "Selected equipment instance is in '{$instance->condition}' condition and cannot be picked up.";
                    continue;
                }
                
                // Check if this instance has already been picked up for this reservation
                if ($existingAssignment && $existingAssignment->status === 'picked_up') {
                    $errors[] = "This equipment instance has already been picked up for this reservation.";
                }
            }
        }
        
        if (!empty($errors)) {
            \Log::error('Pickup business logic validation failed - SIMPLIFIED', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user() ? auth()->user()->email : 'NO USER',
                'session_id' => session()->getId(),
                'reservation_id' => $reservation->id,
                'business_logic_errors' => $errors,
                'timestamp' => now()->toDateTimeString()
            ]);
            
            return redirect()->back()
                ->withErrors($errors)
                ->withInput()
                ->with('debug_info', [
                    'user_id' => auth()->id(),
                    'session_id' => session()->getId(),
                    'business_logic_errors' => $errors,
                    'timestamp' => now()->toDateTimeString()
                ]);
        }

        try {
            DB::beginTransaction();

            \Log::info('Starting pickup processing - SIMPLIFIED', [
                'user_id' => auth()->id(),
                'reservation_id' => $reservation->id,
                'timestamp' => now()->toDateTimeString()
            ]);

            // Update reservation status
            $reservation->update([
                'status' => 'picked_up',
                'picked_up_at' => now(),
            ]);

            // Process each equipment item
            foreach ($validated['equipment_instances'] as $itemId => $instances) {
                $item = $reservation->items()->findOrFail($itemId);
                
                // First, clean up any existing instances that are not in the new selection
                $existingInstances = \App\Models\ReservationItemInstance::where('reservation_item_id', $item->id)->get();
                $selectedInstanceIds = collect($instances)->flatten()->toArray();
                
                foreach ($existingInstances as $existingInstance) {
                    if (!in_array($existingInstance->equipment_instance_id, $selectedInstanceIds)) {
                        $oldInstance = EquipmentInstance::find($existingInstance->equipment_instance_id);
                        if ($oldInstance) {
                            $oldInstance->update(['is_available' => true]);
                        }
                        $existingInstance->delete();
                    }
                }
                
                foreach ($instances as $index => $instanceId) {
                    $instance = EquipmentInstance::findOrFail($instanceId);
                    
                    // Get pickup condition and notes - use current equipment condition as default
                    $pickupCondition = $validated['pickup_conditions'][$itemId][$index] ?? $instance->condition;
                    $pickupNotes = $validated['pickup_notes'][$itemId][$index] ?? null;
                
                // Note: We don't delete existing instances here anymore since we want to keep all selected instances
                
                // Check if reservation item instance already exists for the selected instance
                $existingRecord = \App\Models\ReservationItemInstance::where([
                    'reservation_item_id' => $item->id,
                    'equipment_instance_id' => $instanceId
                ])->first();
                
                if ($existingRecord) {
                    // Update existing record
                    $existingRecord->update([
                        'status' => 'picked_up',
                        'picked_up_at' => now(),
                        'pickup_condition' => $pickupCondition,
                        'pickup_notes' => $pickupNotes,
                    ]);
                    
                    \Log::info('Updated existing reservation item instance', [
                        'reservation_item_id' => $item->id,
                        'equipment_instance_id' => $instanceId,
                        'existing_record_id' => $existingRecord->id
                    ]);
                } else {
                    // Create new record
                    \App\Models\ReservationItemInstance::create([
                        'reservation_item_id' => $item->id,
                        'equipment_instance_id' => $instanceId,
                        'status' => 'picked_up',
                        'picked_up_at' => now(),
                        'pickup_condition' => $pickupCondition,
                        'pickup_notes' => $pickupNotes,
                    ]);
                    
                    \Log::info('Created new reservation item instance', [
                        'reservation_item_id' => $item->id,
                        'equipment_instance_id' => $instanceId
                    ]);
                }
                
                    // Mark selected instance as unavailable
                    $instance->update(['is_available' => false]);
                }
            }

            DB::commit();

            // Clear equipment instances cache for all affected equipment to ensure real-time updates
            foreach ($reservation->items as $item) {
                $cacheKey = "equipment_instances_{$item->equipment_id}";
                cache()->forget($cacheKey);
            }

            \Log::info('Pickup processing completed successfully - SIMPLIFIED', [
                'user_id' => auth()->id(),
                'reservation_id' => $reservation->id,
                'timestamp' => now()->toDateTimeString()
            ]);

            // Create notification
            NotificationService::createReservationStatusNotification(
                $reservation, 
                'picked_up', 
                'Equipment has been successfully picked up.'
            );

            // Redirect with success message
            return redirect()->route('reservation-management.index')
                ->with('success', 'Equipment has been successfully marked as picked up for reservation ' . $reservation->reservation_code);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Pickup processing failed - SIMPLIFIED', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user() ? auth()->user()->email : 'NO USER',
                'session_id' => session()->getId(),
                'reservation_id' => $reservation->id,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'timestamp' => now()->toDateTimeString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to process pickup: ' . $e->getMessage())
                ->withInput()
                ->with('debug_info', [
                    'user_id' => auth()->id(),
                    'session_id' => session()->getId(),
                    'error_message' => $e->getMessage(),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'timestamp' => now()->toDateTimeString()
                ]);
        }
    }

    /**
     * Update instance status in real-time during pickup form
     */
    public function updateInstanceStatus(Request $request)
    {
        $validated = $request->validate([
            'instance_id' => 'required|exists:equipment_instances,id',
            'is_selected' => 'required|boolean',
            'reservation_id' => 'required|exists:reservations,id'
        ]);

        try {
            $instance = EquipmentInstance::findOrFail($validated['instance_id']);
            
            if ($validated['is_selected']) {
                // Mark as borrowed/unavailable
                $instance->update([
                    'status' => 'borrowed',
                    'is_available' => false
                ]);
            } else {
                // Mark as available
                $instance->update([
                    'status' => 'available',
                    'is_available' => true
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Instance status updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update instance status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available instances for equipment during pickup
     */
    public function getAvailableInstances(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'reservation_id' => 'required|exists:reservations,id'
        ]);

        try {
            $equipment = Equipment::findOrFail($validated['equipment_id']);
            
            // Get available instances (active, available, and not borrowed)
            $instances = $equipment->instances()
                ->where('is_active', true)
                ->where('is_available', true)
                ->where('status', 'available')
                ->select('id', 'instance_code', 'condition')
                ->get();

            return response()->json([
                'success' => true,
                'instances' => $instances
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get available instances: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if email already has an active reservation
     */
    public function checkEmailReservation(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $existingReservation = Reservation::where('email', $request->email)
            ->whereIn('status', ['pending', 'approved', 'picked_up'])
            ->first();

        return response()->json([
            'has_reservation' => $existingReservation ? true : false
        ]);
    }


}
