<?php

namespace App\Http\Controllers;

use App\Models\EquipmentType;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EquipmentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipmentTypes = EquipmentType::with('category')
            ->orderBy('category_id')
            ->orderBy('name')
            ->paginate(15);

        $categories = EquipmentCategory::where('is_active', true)->get();

        // Use shared admin-manager view
        return view('admin-manager.equipment-types.index', compact('equipmentTypes', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = EquipmentCategory::where('is_active', true)->get();
        
        return view('admin-manager.equipment-types.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:equipment_categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            // Check if equipment type already exists in this category (case-insensitive)
            $existingType = EquipmentType::where('category_id', $request->category_id)
                ->whereRaw('LOWER(name) = LOWER(?)', [$request->name])
                ->first();

            if ($existingType) {
                $errorMessage = "An equipment type with the name '{$request->name}' already exists in the selected category. Please choose a different name.";
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                        'errors' => ['name' => [$errorMessage]]
                    ], 422);
                }
                return back()->withInput()->withErrors(['name' => $errorMessage]);
            }

            EquipmentType::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Equipment type created successfully.'
                ]);
            }

            return redirect()->route('equipment-types.index')
                ->with('success', 'Equipment type created successfully.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            // For non-AJAX requests, redirect back with validation errors (no flash message)
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating the equipment type'
                ], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while creating the equipment type']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipmentType $equipmentType)
    {
        $equipmentType->load(['category', 'equipment.instances']);
        
        return view('admin-manager.equipment-types.show', compact('equipmentType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentType $equipmentType)
    {
        $categories = EquipmentCategory::where('is_active', true)->get();
        
        return view('admin-manager.equipment-types.edit', compact('equipmentType', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EquipmentType $equipmentType)
    {
        try {
            $request->validate([
                'category_id' => 'required|exists:equipment_categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            // Check if equipment type already exists in this category (excluding current, case-insensitive)
            $existingType = EquipmentType::where('category_id', $request->category_id)
                ->whereRaw('LOWER(name) = LOWER(?)', [$request->name])
                ->where('id', '!=', $equipmentType->id)
                ->first();

            if ($existingType) {
                $errorMessage = "An equipment type with the name '{$request->name}' already exists in the selected category. Please choose a different name.";
                return back()->withInput()->withErrors(['name' => $errorMessage]);
            }

            $equipmentType->update($request->all());

            return redirect()->route('equipment-types.index')
                ->with('success', 'Equipment type updated successfully.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // For non-AJAX requests, redirect back with validation errors (no flash message)
            return back()->withInput()->withErrors($e->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $equipmentType = EquipmentType::findOrFail($id);
            
            // Check if equipment type is being used
            if ($equipmentType->equipment()->count() > 0) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete equipment type that has associated equipment.'
                    ], 422);
                }
                return back()->withErrors(['delete' => 'Cannot delete equipment type that has associated equipment.']);
            }

            $equipmentType->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Equipment type deleted successfully.'
                ]);
            }

            return redirect()->route('equipment-types.index')
                ->with('success', 'Equipment type deleted successfully.');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipment type not found'
                ], 404);
            }
            return back()->withErrors(['error' => 'Equipment type not found']);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while deleting the equipment type'
                ], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while deleting the equipment type']);
        }
    }

    /**
     * Get equipment types by category (AJAX)
     */
    public function getByCategory($category)
    {
        $equipmentTypes = EquipmentType::where('category_id', $category)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($equipmentTypes);
    }

    /**
     * Check if an equipment type name already exists for a category
     */
    public function checkDuplicate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:equipment_categories,id'
        ]);

        $exists = EquipmentType::whereRaw('LOWER(name) = LOWER(?)', [$request->name])
            ->where('category_id', $request->category_id)
            ->exists();

        return response()->json(['exists' => $exists]);
    }
}
