<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\EquipmentCategory;
use App\Models\EquipmentType;
use App\Models\Equipment;

abstract class BaseManagementController extends Controller
{
    /**
     * Common filtering logic for equipment-related queries
     */
    protected function applyCommonFilters(Builder $query, Request $request): Builder
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
     * Common filtering logic for reservation-related queries
     */
    protected function applyReservationFilters(Builder $query, Request $request): Builder
    {
        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // User filter
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%')
                  ->orWhere('email', 'like', '%' . $request->user . '%');
            });
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
     * Common sorting logic
     */
    protected function applySorting(Builder $query, Request $request, string $defaultSort = 'created_at'): Builder
    {
        $sort = $request->get('sort', $defaultSort);
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        if ($sort === 'created_at') {
            $query->orderBy('created_at', $direction);
        } elseif ($sort === 'name') {
            $query->orderBy('name', $direction);
        } elseif ($sort === 'updated_at') {
            $query->orderBy('updated_at', $direction);
        } else {
            $query->orderBy($defaultSort, $direction);
        }

        return $query;
    }

    /**
     * Common pagination logic
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
            return EquipmentCategory::orderBy('name')->get();
        });
        
        $equipmentTypes = cache()->remember('management_equipment_types', 1800, function() {
            return EquipmentType::orderBy('name')->get();
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
        $user = auth()->user();
        $prefix = $user->isAdmin() ? 'admin' : 'manager';
        return "{$prefix}.{$module}.{$view}";
    }

    /**
     * Common PDF generation logic
     */
    protected function generatePDF(string $serviceMethod, $data, array $filters, string $filename): \Illuminate\Http\Response
    {
        try {
            $pdf = \App\Services\PDFService::$serviceMethod($data, $filters);
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->Message());
            return back()->withErrors(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
        }
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
     * Common redirect helper with success/error messages
     */
    protected function redirectWithMessage(string $route, string $message, string $type = 'success'): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route($route)->with($type, $message);
    }

    /**
     * Common validation error handler
     */
    protected function handleValidationErrors(\Illuminate\Validation\ValidationException $e, Request $request): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        return back()->withErrors($e->errors())->withInput();
    }

    /**
     * Common exception handler
     */
    protected function handleException(\Exception $e, Request $request, string $context = 'Operation'): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        \Log::error("{$context} failed: " . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => "{$context} failed. Please try again."
            ], 500);
        }

        return back()->withErrors(['error' => "{$context} failed. Please try again."]);
    }
}
