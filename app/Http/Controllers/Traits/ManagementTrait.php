<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait ManagementTrait
{
    /**
     * Apply common equipment filters
     */
    protected function applyEquipmentFilters(Builder $query, Request $request): Builder
    {
        // Search filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Equipment type filter
        if ($request->filled('equipment_type')) {
            $query->where('equipment_type_id', $request->equipment_type);
        }

        // Status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'available':
                    $query->whereHas('instances', function ($q) {
                        $q->where('is_available', true);
                    });
                    break;
                case 'unavailable':
                    $query->whereDoesntHave('instances', function ($q) {
                        $q->where('is_available', true);
                    });
                    break;
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }

        // Date range filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }

    /**
     * Apply common reservation filters
     */
    protected function applyReservationFilters(Builder $query, Request $request): Builder
    {
        // Status filter (supports virtual "overdue")
        if ($request->filled('status')) {
            if ($request->status === 'overdue') {
                $nowDate = now()->toDateString();
                $nowTime = now()->format('H:i:s');
                $query->where('status', 'picked_up')
                    ->where(function ($q) use ($nowDate, $nowTime) {
                        $q->whereDate('return_date', '<', $nowDate)
                          ->orWhere(function ($q2) use ($nowDate, $nowTime) {
                              $q2->whereDate('return_date', '=', $nowDate)
                                  ->where('return_time', '<', $nowTime);
                          });
                    });
            } else {
                $query->where('status', $request->status);
            }
        }

        // User filter
        if ($request->filled('user')) {
            $term = trim($request->user);
            $query->where(function ($outer) use ($term) {
                $outer->whereHas('user', function ($q) use ($term) {
                        $q->where('name', 'like', "%{$term}%")
                          ->orWhere('email', 'like', "%{$term}%");
                    })
                    // Also match guest/typed-in name stored directly on reservation
                    ->orWhere('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        }

        // Reservation code filter
        if ($request->filled('reservation_code')) {
            $query->where('reservation_code', 'like', '%' . $request->reservation_code . '%');
        }

        // Equipment filter
        if ($request->filled('equipment')) {
            $query->whereHas('items.equipment', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->equipment . '%')
                  ->orWhere('model', 'like', '%' . $request->equipment . '%')
                  ->orWhereHas('equipmentType', function($typeQuery) use ($request) {
                      $typeQuery->where('name', 'like', '%' . $request->equipment . '%');
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('items.equipment.category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Equipment type filter
        if ($request->filled('equipment_type')) {
            $query->whereHas('items.equipment.equipmentType', function ($q) use ($request) {
                $q->where('id', $request->equipment_type);
            });
        }

        // Date range filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Borrow date filters
        if ($request->filled('borrow_date_from')) {
            $query->whereDate('borrow_date', '>=', $request->borrow_date_from);
        }

        if ($request->filled('borrow_date_to')) {
            $query->whereDate('borrow_date', '<=', $request->borrow_date_to);
        }

        return $query;
    }

    /**
     * Apply common maintenance filters
     */
    protected function applyMaintenanceFilters(Builder $query, Request $request): Builder
    {
        // Search filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%')
                  ->orWhereHas('equipmentType', function($typeQuery) use ($request) {
                      $typeQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Equipment type filter
        if ($request->filled('equipment_type')) {
            $query->where('equipment_type_id', $request->equipment_type);
        }

        // Maintenance status filter
        if ($request->filled('maintenance_status')) {
            switch ($request->maintenance_status) {
                case 'under_maintenance':
                    $query->whereHas('instances', function($q) {
                        $q->where('condition', 'under_maintenance')
                          ->where('is_active', true);
                    });
                    break;
                case 'needs_repair':
                    $query->whereHas('instances', function($q) {
                        $q->where('condition', 'needs_repair')
                          ->where('is_active', true);
                    });
                    break;
                case 'damaged':
                    $query->whereHas('instances', function($q) {
                        $q->where('condition', 'damaged')
                          ->where('is_active', true);
                    });
                    break;
                case 'has-maintenance-history':
                    $query->whereHas('maintenanceRecords');
                    break;
                case 'no-maintenance-history':
                    $query->whereDoesntHave('maintenanceRecords');
                    break;
            }
        }

        return $query;
    }

    /**
     * Apply common missing equipment filters
     */
    protected function applyMissingEquipmentFilters(Builder $query, Request $request): Builder
    {
        // Search filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('borrower_name', 'like', '%' . $request->search . '%')
                  ->orWhere('borrower_email', 'like', '%' . $request->search . '%')
                  ->orWhereHas('equipmentInstance.equipment', function($equipmentQuery) use ($request) {
                      $equipmentQuery->where('brand', 'like', '%' . $request->search . '%')
                                    ->orWhere('model', 'like', '%' . $request->search . '%')
                                    ->orWhere('description', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Incident type filter
        if ($request->filled('incident_type')) {
            $query->where('incident_type', $request->incident_type);
        }

        // Replacement status filter
        if ($request->filled('replacement_status')) {
            $query->where('replacement_status', $request->replacement_status);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('equipmentInstance.equipment.category', function($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        // Equipment type filter
        if ($request->filled('equipment_type')) {
            $query->whereHas('equipmentInstance.equipment', function($q) use ($request) {
                $q->where('equipment_type_id', $request->equipment_type);
            });
        }

        // Date range filters
        if ($request->filled('date_from')) {
            $query->where('incident_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('incident_date', '<=', $request->date_to);
        }

        return $query;
    }

    /**
     * Apply common sorting
     */
    protected function applySorting(Builder $query, Request $request, string $defaultSort = 'created_at'): Builder
    {
        $sort = $request->get('sort', $defaultSort);
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        switch ($sort) {
            case 'created_at':
                $query->orderBy('created_at', $direction);
                break;
            case 'name':
                $query->orderBy('brand', $direction);
                break;
            case 'updated_at':
                $query->orderBy('updated_at', $direction);
                break;
            case 'maintenance_date':
                $query->orderBy('maintenance_date', $direction);
                break;
            case 'wishlist_count':
                $query->orderBy('wishlist_count', $direction);
                break;
            default:
                $query->orderBy($defaultSort, $direction);
        }

        return $query;
    }

    /**
     * Apply common pagination
     */
    protected function applyPagination(Builder $query, Request $request, int $defaultPerPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $perPage = max(5, min((int) $request->get('per_page', $defaultPerPage), 100));
        return $query->paginate($perPage)->appends($request->query());
    }

    /**
     * Get common filter data with caching
     */
    protected function getCommonFilterData(): array
    {
        $categories = cache()->remember('management_categories', 1800, function() {
            return \App\Models\EquipmentCategory::orderBy('name')->get();
        });
        
        $equipmentTypes = cache()->remember('management_equipment_types', 1800, function() {
            return \App\Models\EquipmentType::orderBy('name')->get();
        });

        return [
            'categories' => $categories,
            'equipmentTypes' => $equipmentTypes,
        ];
    }

    /**
     * Get view path based on user role
     */
    protected function getViewPath(string $module, string $view): string
    {
        // Shared modules use consolidated admin-manager views
        $sharedModules = [
            'equipment-management',
            'maintenance-management',
            'missing-equipment',
        ];

        if (in_array($module, $sharedModules, true)) {
            return "admin-manager.{$module}.{$view}";
        }

        $user = auth()->user();
        $prefix = $user && $user->isAdmin() ? 'admin' : 'manager';
        return "{$prefix}.{$module}.{$view}";
    }

    /**
     * Common AJAX response helper
     */
    protected function ajaxResponse(bool $success, string $message, array $data = [], int $status = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (!empty($data)) {
            $response = array_merge($response, $data);
        }

        return response()->json($response, $status);
    }

    /**
     * Common redirect helper
     */
    protected function redirectWithMessage(string $route, string $message, string $type = 'success'): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route($route)->with($type, $message);
    }

    /**
     * Common exception handler
     */
    protected function handleException(\Exception $e, Request $request, string $context = 'Operation'): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        Log::error("{$context} failed: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return $this->ajaxResponse(false, "{$context} failed. Please try again.", [], 500);
        }

        return back()->withErrors(['error' => "{$context} failed. Please try again."]);
    }

    /**
     * Common database transaction wrapper
     */
    protected function executeInTransaction(callable $callback, Request $request, string $context = 'Operation')
    {
        DB::beginTransaction();
        try {
            $result = $callback();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->handleException($e, $request, $context);
        }
    }
}
