<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:manager');
    }

    public function index(Request $request)
    {
        $query = EquipmentCategory::withCount('equipment');

        // Sorting (default by name; allow created_at asc/desc)
        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        if ($sort === 'created_at') {
            $query->orderBy('created_at', $direction);
        } else {
            $query->orderBy('name');
        }

        $perPage = max(5, min((int) $request->get('per_page', 15), 100));
        $categories = $query->paginate($perPage)->appends($request->query());

        return view('admin-manager.equipment-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin-manager.equipment-categories.create');
    }

    public function show(EquipmentCategory $category)
    {
        $category->load(['equipment' => function ($query) {
            $query->orderBy('name');
        }]);
        
        return view('admin-manager.equipment-categories.show', compact('category'));
    }

    public function store(Request $request)
    {
        try {
            // Custom validation for case-insensitive duplicate checking
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            // Check for case-insensitive duplicate
            $existingCategory = EquipmentCategory::whereRaw('LOWER(name) = LOWER(?)', [$request->name])->first();
            
            if ($existingCategory) {
                $errorMessage = "A category with the name '{$request->name}' already exists. Please choose a different name.";
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                        'errors' => ['name' => [$errorMessage]]
                    ], 422);
                }
                
                return back()
                    ->withInput()
                    ->withErrors(['name' => $errorMessage]);
            }

            $validated = $request->only(['name', 'description']);
            EquipmentCategory::create($validated);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Equipment category created successfully'
                ]);
            }

            return redirect()->route('equipment-categories.index')
                ->with('success', 'Equipment category created successfully');
                
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
                    'message' => 'An error occurred while creating the category'
                ], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while creating the category']);
        }
    }

    public function edit(EquipmentCategory $category)
    {
        return view('admin-manager.equipment-categories.edit', compact('category'));
    }

    public function update(Request $request, EquipmentCategory $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
            ]);

            // Check for case-insensitive duplicate (excluding current category)
            $existingCategory = EquipmentCategory::whereRaw('LOWER(name) = LOWER(?)', [$request->name])
                ->where('id', '!=', $category->id)
                ->first();
            
            if ($existingCategory) {
                $errorMessage = "A category with the name '{$request->name}' already exists. Please choose a different name.";
                
                return back()
                    ->withInput()
                    ->withErrors(['name' => $errorMessage]);
            }

            $validated = $request->only(['name', 'description']);
            $category->update($validated);

            return redirect()->route('equipment-categories.index')
                ->with('success', 'Equipment category updated successfully');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // For non-AJAX requests, redirect back with validation errors (no flash message)
            return back()->withInput()->withErrors($e->errors());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $category = EquipmentCategory::findOrFail($id);
            
            // Check if category has equipment
            if ($category->equipment()->count() > 0) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete category with existing equipment'
                    ], 422);
                }
                return back()->withErrors(['error' => 'Cannot delete category with existing equipment']);
            }

            $category->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Equipment category deleted successfully'
                ]);
            }

            return redirect()->route('equipment-categories.index')
                ->with('success', 'Equipment category deleted successfully');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Equipment category not found'
                ], 404);
            }
            return back()->withErrors(['error' => 'Equipment category not found']);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while deleting the category'
                ], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while deleting the category']);
        }
    }

    /**
     * Check if a category name already exists (case-insensitive)
     */
    public function checkDuplicate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $exists = EquipmentCategory::whereRaw('LOWER(name) = LOWER(?)', [$request->name])->exists();

        return response()->json(['exists' => $exists]);
    }
}
