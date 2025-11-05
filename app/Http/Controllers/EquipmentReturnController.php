<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\EquipmentInstance;
use App\Models\ReturnLog;
use App\Models\ReservationItemInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EquipmentReturnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:manager');
    }

    public function showReturnForm(Reservation $reservation)
    {
        // Load the reservation with assigned instances and pickup conditions
        $reservation->load([
            'user',
            'items.instances.equipmentInstance',
            'items.equipment',
            'items.reservationItemInstances' // Load the pickup conditions
        ]);
        
        // Map any incident reports for this reservation to equipment instance severities
        $incidentInstanceSeverities = [];
        try {
            $incidents = \App\Models\IncidentReport::where('reservation_id', $reservation->id)
                ->orderByDesc('created_at')
                ->get();
            foreach ($incidents as $incident) {
                $rawInstances = $incident->equipment_instances;
                $rawSeverities = $incident->equipment_severities;
                $instances = is_array($rawInstances) ? $rawInstances : (is_string($rawInstances) ? (json_decode($rawInstances, true) ?: []) : []);
                $sevMap = is_array($rawSeverities) ? $rawSeverities : (is_string($rawSeverities) ? (json_decode($rawSeverities, true) ?: []) : []);
                foreach ($instances as $instanceId) {
                    if (!isset($incidentInstanceSeverities[$instanceId]) && isset($sevMap[$instanceId])) {
                        $incidentInstanceSeverities[$instanceId] = [
                            'severity' => $sevMap[$instanceId],
                            'incident_code' => $incident->incident_code,
                            'incident_id' => $incident->id,
                        ];
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to map incident severities for return form', [
                'reservation_id' => $reservation->id,
                'error' => $e->getMessage(),
            ]);
        }
        
        // Check if reservation has items
        if ($reservation->items->isEmpty()) {
            return back()->withErrors(['error' => 'This reservation has no equipment items to return.']);
        }
        
        // Ensure there are assigned instances to be returned
        $assignedCount = $reservation->items->sum(function ($item) { return $item->instances->count(); });
        if ($assignedCount === 0) {
            return back()->withErrors(['error' => 'No assigned equipment instances for this reservation. Mark as picked up first.']);
        }
        
        return view('equipment-returns.return-form', compact('reservation', 'incidentInstanceSeverities'));
    }

    public function processReturn(Request $request, Reservation $reservation)
    {
        // Debug: Log the incoming request data
        \Log::info('Return form data received - SIMPLIFIED', [
            'user_id' => auth()->id(),
            'user_email' => auth()->user() ? auth()->user()->email : 'NO USER',
            'session_id' => session()->getId(),
            'reservation_id' => $reservation->id,
            'reservation_code' => $reservation->reservation_code,
            'reservation_status' => $reservation->status,
            'request_data' => $request->all(),
            'timestamp' => now()->toDateTimeString()
        ]);

        try {
            $validated = $request->validate([
                'returns' => 'required|array|min:1',
                'returns.*.equipment_instance_id' => [
                    'required',
                    Rule::exists('equipment_instances', 'id'),
                ],
                'returns.*.returned_condition' => 'required|in:excellent,good,fair,needs_repair,damaged,lost',
                'returns.*.condition_notes' => 'nullable|string|max:500',
                'returns.*.damage_description' => 'nullable|string|max:1000',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Return validation failed - SIMPLIFIED', [
                'user_id' => auth()->id(),
                'user_email' => auth()->user() ? auth()->user()->email : 'NO USER',
                'session_id' => session()->getId(),
                'reservation_id' => $reservation->id,
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
        
        // Validate that all submitted instances are actually assigned to this reservation
        $submittedInstanceIds = collect($validated['returns'])->pluck('equipment_instance_id')->toArray();
        $assignedInstanceIds = \App\Models\ReservationItemInstance::whereIn('reservation_item_id', $reservation->items->pluck('id'))
            ->pluck('equipment_instance_id')
            ->toArray();
        
        $invalidInstances = array_diff($submittedInstanceIds, $assignedInstanceIds);
        if (!empty($invalidInstances)) {
            $errors[] = 'The following instances are not assigned to this reservation: ' . implode(', ', $invalidInstances);
        }
        
        if (!empty($errors)) {
            \Log::error('Return business logic validation failed - SIMPLIFIED', [
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

            \Log::info('Starting return processing - SIMPLIFIED', [
                'user_id' => auth()->id(),
                'reservation_id' => $reservation->id,
                'timestamp' => now()->toDateTimeString()
            ]);

            foreach ($validated['returns'] as $returnData) {
                $instance = EquipmentInstance::find($returnData['equipment_instance_id']);
                
                // Create return log
                ReturnLog::create([
                    'reservation_id' => $reservation->id,
                    'equipment_instance_id' => $instance->id,
                    'returned_condition' => $returnData['returned_condition'],
                    'condition_notes' => $returnData['condition_notes'] ?? null,
                    'quantity_returned' => 1,
                    'quantity_damaged' => $returnData['returned_condition'] === 'damaged' ? 1 : 0,
                    'quantity_lost' => $returnData['returned_condition'] === 'lost' ? 1 : 0,
                    'damage_description' => $returnData['damage_description'] ?? null,
                    'processed_by' => Auth::id(),
                    'returned_at' => now(),
                ]);

                // Update instance condition (but don't mark as available yet - only when reservation is completed)
                $instance->update([
                    'condition' => $returnData['returned_condition'],
                    'condition_notes' => $returnData['condition_notes'] ?? null,
                    'is_available' => false, // Keep as unavailable until reservation is marked as completed
                ]);

                // Mark the reservation item instance as returned
                $reservationItemIds = $reservation->items->pluck('id');
                ReservationItemInstance::whereIn('reservation_item_id', $reservationItemIds)
                    ->where('equipment_instance_id', $instance->id)
                    ->update([
                        'status' => 'returned',
                        'returned_at' => now(),
                        'returned_condition' => $returnData['returned_condition'],
                        'returned_notes' => $returnData['condition_notes'] ?? null,
                    ]);

                // Handle lost or damaged equipment → Missing Equipment module
                if (in_array($returnData['returned_condition'], ['lost','damaged'])) {
                    // Try to find linked incident for this reservation and instance
                    $incidentId = null;
                    try {
                        $incident = \App\Models\IncidentReport::where('reservation_id', $reservation->id)->latest()->get()->first();
                        if ($incident) {
                            $rawInstances = $incident->equipment_instances;
                            $instances = is_array($rawInstances) ? $rawInstances : (is_string($rawInstances) ? (json_decode($rawInstances, true) ?: []) : []);
                            if (in_array($instance->id, $instances)) {
                                $incidentId = $incident->id;
                            }
                        }
                    } catch (\Throwable $e) {}
                    \App\Models\MissingEquipment::create([
                        'equipment_instance_id' => $instance->id,
                        'reservation_id' => $reservation->id,
                        'incident_id' => $incidentId,
                        'borrower_name' => $reservation->name ?? ($reservation->user->name ?? null),
                        'borrower_email' => $reservation->email ?? ($reservation->user->email ?? null),
                        'borrower_contact_number' => $reservation->contact_number ?? ($reservation->user->contact_number ?? null),
                        'borrower_department' => $reservation->department ?? ($reservation->user->department ?? null),
                        'incident_date' => now(),
                        'incident_type' => $returnData['returned_condition'] === 'damaged' ? 'damaged' : 'lost',
                        'incident_description' => $returnData['condition_notes'] ?? (
                            $returnData['returned_condition'] === 'damaged'
                                ? 'Equipment marked as damaged during return process'
                                : 'Equipment marked as lost during return process'
                        ),
                        'replacement_status' => 'pending',
                        'acted_by' => Auth::id(),
                        'acted_at' => now(),
                    ]);
                }
            }

            // Mark reservation as returned
            $reservation->update([
                'status' => 'returned',
                'returned_at' => now(),
            ]);

            DB::commit();

            \Log::info('Return processing completed successfully - SIMPLIFIED', [
                'user_id' => auth()->id(),
                'reservation_id' => $reservation->id,
                'timestamp' => now()->toDateTimeString()
            ]);

            // Create notification
            \App\Services\NotificationService::createReservationStatusNotification(
                $reservation, 
                'returned', 
                'Equipment has been successfully returned and processed.'
            );

            // Redirect with success message
            return redirect()->route('reservation-management.index')
                ->with('success', 'Equipment has been successfully returned for reservation ' . $reservation->reservation_code);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Return processing failed - SIMPLIFIED', [
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
                ->with('error', 'Failed to process return: ' . $e->getMessage())
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

    public function showReturnHistory(Request $request)
    {
        $query = ReturnLog::with(['reservation.user', 'equipmentInstance.equipment', 'processedBy']);

        // Sorting (default latest returned_at; allow asc/desc)
        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        if ($sort === 'returned_at') {
            $query->orderBy('returned_at', $direction);
        } else {
            $query->latest('returned_at');
        }

        $returnLogs = $query->paginate(20)->appends($request->query());

        return view('equipment-returns.history', compact('returnLogs'));
    }

    public function showInstanceHistory(EquipmentInstance $instance, Request $request)
    {
        $logsQuery = $instance->returnLogs()->with(['reservation.user', 'processedBy']);

        // Sorting (default latest returned_at; allow asc/desc)
        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        if ($sort === 'returned_at') {
            $logsQuery->orderBy('returned_at', $direction);
        } else {
            $logsQuery->latest('returned_at');
        }

        $returnLogs = $logsQuery->paginate(15)->appends($request->query());

        return view('equipment-returns.instance-history', compact('instance', 'returnLogs'));
    }
}
