<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Show all equipment; availability is derived from instances, not an "is_active" flag
            $query = Equipment::with('category', 'equipmentType', 'images');

            // Search functionality
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                      ->orWhere('model', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                          $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('equipmentType', function($typeQuery) use ($searchTerm) {
                          $typeQuery->where('name', 'like', '%' . $searchTerm . '%');
                      });
                });
            }

            // Category filter
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            // Equipment Type filter
            if ($request->filled('equipment_type')) {
                $query->where('equipment_type_id', $request->equipment_type);
            }

            // Availability filter (optional)
            if ($request->filled('availability')) {
                if ($request->availability === 'available') {
                    $query->whereHas('instances', function($q) {
                        $q->where('is_available', true)->where('is_active', true);
                    });
                } elseif ($request->availability === 'unavailable') {
                    $query->whereDoesntHave('instances', function($q) {
                        $q->where('is_available', true)->where('is_active', true);
                    });
                }
            }

            $equipment = $query->paginate(12);
            
            // Calculate available count for each equipment item
            $equipment->getCollection()->transform(function($item) {
                $item->availableCount = $item->instances()
                    ->where('is_active', true)
                    ->where('is_available', true)
                    ->count();
                return $item;
            });
            
            $categories = EquipmentCategory::orderBy('name')->get();
            $equipmentTypes = EquipmentType::orderBy('name')->get();

            return view('welcome', compact('equipment', 'categories', 'equipmentTypes'));
        } catch (\Exception $e) {
            return view('welcome', [
                'equipment' => collect(),
                'categories' => collect(),
                'equipmentTypes' => collect(),
                'error' => 'Error loading equipment: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Dynamic search and filter endpoint for AJAX requests
     */
    public function search(Request $request)
    {
        try {
            // Optimized query with eager loading and withCount
            $query = Equipment::with(['category', 'equipmentType', 'images'])
                ->withCount([
                    'instances as total_instances' => function($q) {
                        $q->where('is_active', true);
                    },
                    'instances as available_instances' => function($q) {
                        $q->where('is_active', true)->where('is_available', true);
                    }
                ]);

            // Search functionality with optimized queries
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                      ->orWhere('model', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                          $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                      })
                      ->orWhereHas('equipmentType', function($typeQuery) use ($searchTerm) {
                          $typeQuery->where('name', 'like', '%' . $searchTerm . '%');
                      });
                });
            }

            // Category filter
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            // Equipment Type filter
            if ($request->filled('equipment_type')) {
                $query->where('equipment_type_id', $request->equipment_type);
            }

            // Availability filter
            if ($request->filled('availability')) {
                if ($request->availability === 'available') {
                    $query->whereHas('instances', function($q) {
                        $q->where('is_available', true)->where('is_active', true);
                    });
                } elseif ($request->availability === 'unavailable') {
                    $query->whereDoesntHave('instances', function($q) {
                        $q->where('is_available', true)->where('is_active', true);
                    });
                }
            }

            // Get paginated results
            $page = $request->get('page', 1);
            $perPage = 12;
            $equipment = $query->paginate($perPage, ['*'], 'page', $page);
            
            // Transform collection to add computed properties
            $equipment->getCollection()->transform(function($item) {
                $item->availableCount = $item->available_instances;
                $item->totalCount = $item->total_instances;
                return $item;
            });

            // Return JSON response with HTML for the equipment grid
            $html = view('components.equipment-grid', compact('equipment'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => [
                    'current_page' => $equipment->currentPage(),
                    'last_page' => $equipment->lastPage(),
                    'per_page' => $equipment->perPage(),
                    'total' => $equipment->total(),
                    'from' => $equipment->firstItem(),
                    'to' => $equipment->lastItem(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error loading equipment: ' . $e->getMessage()
            ], 500);
        }
    }
}
