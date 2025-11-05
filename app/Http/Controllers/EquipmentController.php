<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\EquipmentInstance;

class EquipmentController extends Controller
{
    public function index()
    {
        // Redirect to welcome page for equipment listing
        return redirect()->route('welcome');
    }

    public function show(Equipment $equipment)
    {
        return view('user.equipment.show', compact('equipment'));
    }

    public function create()
    {
        $this->authorize('create', Equipment::class);
        
        $categories = EquipmentCategory::where('is_active', true)->get();
        return view('user.equipment.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Equipment::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:equipment_categories,id',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            // serial_number removed from system
            'quantity_total' => 'required|integer|min:1', // Keep for initial instance creation
            'condition' => 'required|in:excellent,good,fair,needs_repair,damaged,lost',
            'location' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $validated['created_by'] = Auth::id();

        $equipment = Equipment::create($validated);

        // Auto-generate instance records per quantity_total
        $quantityTotal = $validated['quantity_total'];
        if ($quantityTotal > 0) {
            for ($i = 0; $i < $quantityTotal; $i++) {
                EquipmentInstance::create([
                    'equipment_id' => $equipment->id,
                    'instance_code' => EquipmentInstance::generateInstanceCode($equipment),
                    'condition' => $equipment->condition,
                    'is_available' => true,
                    'is_active' => true,
                    'location' => $equipment->location,
                ]);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('equipment', 'public');
                $equipment->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment added successfully!');
    }

    public function edit(Equipment $equipment)
    {
        $this->authorize('update', $equipment);
        
        $categories = EquipmentCategory::where('is_active', true)->get();
        return view('user.equipment.edit', compact('equipment', 'categories'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $this->authorize('update', $equipment);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:equipment_categories,id',
            'description' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            // serial_number removed from system
            'condition' => 'required|in:excellent,good,fair,needs_repair,damaged,lost',
            'location' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $equipment->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('equipment', 'public');
                $equipment->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment updated successfully!');
    }

    public function destroy(Equipment $equipment)
    {
        $this->authorize('delete', $equipment);
        // Prevent deleting if there are any instances at all OR any active/pending reservations
        $hasInstances = $equipment->instances()->where('is_active', true)->exists();
        $hasActive = \App\Models\ReservationItemInstance::whereIn('equipment_instance_id', $equipment->instances()->pluck('id'))
            ->whereNull('returned_at')
            ->whereHas('reservationItem.reservation', function($q){ $q->whereIn('status',["pending","approved","picked_up"]); })
            ->exists();
        if ($hasInstances || $hasActive) {
            return back()->withErrors(['error' => 'Delete blocked: Remove/retire all instances and complete any ongoing reservations before deleting the equipment.']);
        }

        $equipment->delete();
        return redirect()->route('equipment-management.index')->with('success', 'Equipment deleted successfully!');
    }

    public function search(Request $request)
    {
        // Redirect unavailable equipment searches to welcome page with filtering
        if ($request->filled('availability') && $request->availability === 'unavailable') {
            return redirect()->route('welcome', ['availability' => 'unavailable']);
        }
        
        // For other searches, redirect to welcome page with search parameters
        $params = $request->only(['search', 'category', 'availability']);
        return redirect()->route('welcome', $params);
    }

    public function getDetails(Equipment $equipment)
    {
        $equipment->load(['category', 'equipmentType', 'images']);

        // Build a browser-friendly payload (e.g., image URLs)
        $equipmentArray = [
            'id' => $equipment->id,
            'name' => $equipment->display_name,
            'description' => $equipment->description,
            'condition' => $equipment->condition,
            'category' => [
                'id' => optional($equipment->category)->id,
                'name' => optional($equipment->category)->name,
            ],
            'equipment_type' => [
                'id' => optional($equipment->equipmentType)->id,
                'name' => optional($equipment->equipmentType)->name,
            ],
            'images' => $equipment->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image_path' => $image->image_path,
                    'url' => $image->url,
                ];
            })->values(),
        ];
        
        return response()->json([
            'success' => true,
            'equipment' => $equipmentArray,
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    }

    public function getInstances(Equipment $equipment)
    {
        // Get fresh instances data without caching for real-time updates
        $instances = $equipment->instances()
            ->where('is_active', true)
            ->select('id', 'instance_code', 'condition', 'is_available', 'location')
            ->orderBy('instance_code', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'instances' => $instances
        ])->header('Cache-Control', 'no-cache, no-store, must-revalidate')
          ->header('Pragma', 'no-cache')
          ->header('Expires', '0');
    }

}

