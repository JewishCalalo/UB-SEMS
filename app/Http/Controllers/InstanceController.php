<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentInstance;
use App\Models\InstanceRetirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:manager');
    }

    public function restore($instanceId)
    {
        $instance = EquipmentInstance::findOrFail($instanceId);
        $instance->update(['is_active' => true, 'is_available' => true, 'condition' => 'good']);
        InstanceRetirement::create([
            'equipment_instance_id' => $instance->id,
            'reason' => 'restored',
            'notes' => 'Restored to fleet',
            'acted_by' => Auth::id(),
            'acted_at' => now(),
        ]);
        optional($instance->equipment)->recalculateCounts();
        return back()->with('success', 'Instance restored and made available.');
    }

    public function add(Request $request, Equipment $equipment)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:50',
            'condition' => 'required|in:excellent,good,fair,needs_repair,damaged,lost,stolen,end_of_life,under_maintenance',
            'location' => 'required|string|max:255',
        ]);

        $quantity = $request->input('quantity', 1);
        $condition = $request->input('condition', 'good');
        $location = $request->input('location', 'Storage Room A');

        $createdInstances = [];
        
        for ($i = 0; $i < $quantity; $i++) {
            $instance = EquipmentInstance::create([
                'equipment_id' => $equipment->id,
                'instance_code' => EquipmentInstance::generateInstanceCode($equipment),
                'condition' => $condition,
                'is_available' => true,
                'is_active' => true,
                'location' => $location,
            ]);
            $createdInstances[] = $instance->instance_code;
        }

        optional($equipment)->recalculateCounts();
        
        $message = $quantity === 1 
            ? 'New instance added: ' . $createdInstances[0]
            : $quantity . ' new instances added successfully.';

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }
            
        return back()->with('success', $message);
    }

    public function retire($instanceId)
    {
        $instance = EquipmentInstance::findOrFail($instanceId);
        // Block retirement if instance is part of an ongoing reservation
        $hasOngoing = \App\Models\ReservationItemInstance::where('equipment_instance_id', $instance->id)
            ->whereNull('returned_at')
            ->whereHas('reservationItem.reservation', function($q){
                $q->whereIn('status', ['pending','approved','picked_up']);
            })
            ->exists();
        if ($hasOngoing) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Retirement blocked: this instance has an ongoing reservation (pending/approved/picked up). Please wait until it is returned.'
                ], 422);
            }
            return back()->withErrors(['error' => 'Retirement blocked: instance has an ongoing reservation (pending/approved/picked up).']);
        }
        // Proceed with retirement when no ongoing reservation
        $instance->is_active = false;
        $instance->is_available = false;
        $instance->save();

        InstanceRetirement::create([
            'equipment_instance_id' => $instance->id,
            'reason' => 'retired',
            'notes' => 'Retired via bulk action',
            'acted_by' => Auth::id(),
            'acted_at' => now(),
        ]);

        // Log instance retirement activity
        \App\Services\ActivityLogService::logInstanceRetired($instance, request());

        optional($instance->equipment)->recalculateCounts();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Instance retired successfully.');
    }
    public function destroy($instanceId)
    {
        $instance = EquipmentInstance::findOrFail($instanceId);
        // Safety: do not delete if assigned to an active reservation
        $assigned = \App\Models\ReservationItemInstance::where('equipment_instance_id', $instance->id)
            ->whereNull('returned_at')
            ->whereHas('reservationItem.reservation', function($q){
                $q->whereIn('status', ['approved','picked_up','pending']);
            })
            ->exists();
        if ($assigned) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'error' => 'This instance is tied to a reservation (pending/approved/picked up). Deletion is blocked to avoid breaking active requests.'], 422);
            }
            return back()->withErrors(['error' => 'Cannot delete an instance that has a pending/approved/picked-up reservation.']);
        }
        
        // Log instance deletion activity before deleting
        \App\Services\ActivityLogService::logInstanceDeleted($instance->instance_code, $instance->toArray(), request());
        
        $equipment = $instance->equipment;
        $instance->delete();
        optional($equipment)->recalculateCounts();
        return back()->with('success', 'Instance deleted successfully.');
    }
}


