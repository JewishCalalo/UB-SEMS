<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRecord;
use App\Models\EquipmentCategory;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\Traits\ManagementTrait;

class MaintenanceManagementController extends Controller
{
    use ManagementTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        // Removed redundant middleware since route group already handles authorization
    }

    public function index(Request $request)
    {
        $query = Equipment::with(['category', 'equipmentType', 'maintenanceRecords', 'instances']);

        // Only show equipment that has instances (quantities > 0)
        $query->whereHas('instances', function($q) {
            $q->where('is_active', true);
        });

        // Apply common maintenance filters
        $query = $this->applyMaintenanceFilters($query, $request);

        // Apply common sorting
        $query = $this->applySorting($query, $request, 'created_at');

        // Apply common pagination
        $equipment = $this->applyPagination($query, $request);

        // Get common filter data
        $filterData = $this->getCommonFilterData();
        $categories = $filterData['categories'];
        $equipmentTypes = $filterData['equipmentTypes'];

        // Get maintenance statistics for Equipment Maintenance Overview
        $totalEquipment = Equipment::count();
        $totalInstances = \App\Models\EquipmentInstance::count();
        $availableInstances = \App\Models\EquipmentInstance::where('is_available', true)->where('is_active', true)->count();
        $instancesNeedingMaintenance = \App\Models\EquipmentInstance::where('condition', 'needs_repair')->where('is_active', true)->count();
        
        // Maintenance statistics
        $instancesWithMaintenanceHistory = \App\Models\EquipmentInstance::whereHas('maintenanceRecords')->where('is_active', true)->count();
        $instancesWithoutMaintenanceHistory = $totalInstances - $instancesWithMaintenanceHistory;
        
        // Calculate completion rate (available instances / total instances)
        $completionRate = $totalInstances > 0 ? round(($availableInstances / $totalInstances) * 100) : 0;
        
        $overdueCount = 0;
        $dueThisWeek = 0;
        $completedThisMonth = MaintenanceRecord::whereMonth('maintenance_date', now()->month)
                               ->whereYear('maintenance_date', now()->year)->count();

        $viewPath = 'admin-manager.maintenance-management.index';
        
        // Debug: Check if variables are being passed correctly
        \Log::info('Maintenance Management Debug', [
            'equipment_count' => $equipment->count(),
            'categories_count' => $categories->count(),
            'overdueCount' => $overdueCount,
            'dueThisWeek' => $dueThisWeek,
            'completedThisMonth' => $completedThisMonth,
            'totalEquipment' => $totalEquipment,
            'viewPath' => $viewPath
        ]);
        
        // Get maintenance enforcement statistics
        $maintenanceStats = $this->getMaintenanceEnforcementStats();
        
        return view($viewPath, compact(
            'equipment', 
            'categories', 
            'equipmentTypes',
            'overdueCount', 
            'dueThisWeek', 
            'completedThisMonth', 
            'totalEquipment',
            'totalInstances',
            'availableInstances',
            'instancesNeedingMaintenance',
            'instancesWithMaintenanceHistory',
            'instancesWithoutMaintenanceHistory',
            'completionRate',
            'maintenanceStats'
        ));
    }

    public function show(Equipment $equipment, Request $request)
    {
        $equipment->load(['category', 'maintenanceRecords']);

        // Sorting for maintenance records (default latest by maintenance_date; allow asc/desc)
        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        $recordsQuery = $equipment->maintenanceRecords();
        if ($sort === 'maintenance_date') {
            $recordsQuery->orderBy('maintenance_date', $direction);
        } else {
            $recordsQuery->latest('maintenance_date');
        }

        $perPage = max(5, min((int) $request->get('per_page', 15), 100));
        $maintenanceRecords = $recordsQuery->paginate($perPage)->appends($request->query());
        
        $viewPath = 'admin-manager.maintenance-management.show';
        
        // Debug: Log the view path being used
        \Log::info('Maintenance Management Show Debug', [
            'user_role' => auth()->user()->role,
            'is_admin' => auth()->user()->isAdmin(),
            'view_path' => $viewPath,
            'equipment_id' => $equipment->id,
            'maintenance_records_count' => $maintenanceRecords->count()
        ]);
        
        return view($viewPath, compact('equipment', 'maintenanceRecords'));
    }

    public function createRecord(Equipment $equipment)
    {
        // Only load active instances (not retired/discarded) and exclude those already marked as lost
        $equipment->load(['instances' => function($query) {
            $query->where('is_active', true)
                  ->where('condition', '!=', 'lost');
        }]);
        
        $viewPath = 'admin-manager.maintenance-management.create-record';
        return view($viewPath, compact('equipment'));
    }

    public function storeRecord(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'maintenance_type' => 'required|in:routine,repair,upgrade,inspection,calibration,other',
            'maintenance_type_other' => 'required_if:maintenance_type,other|nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'performed_date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string|max:1000',
            'instances' => 'required|array|min:1',
            'instances.*.id' => 'required|exists:equipment_instances,id,is_active,1',
                            'instances.*.condition' => 'required|in:excellent,good,fair,needs_repair,damaged,lost,retired,under_maintenance',
            'instances.*.notes' => 'nullable|string|max:500',
        ], [
            'maintenance_type.required' => 'Maintenance type is required.',
            'maintenance_type.in' => 'Maintenance type must be routine, repair, upgrade, inspection, calibration, or other.',
            'maintenance_type_other.required_if' => 'Please specify the maintenance type when Other is selected.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'performed_date.required' => 'Performed date is required.',
            'performed_date.date' => 'Performed date must be a valid date.',
            'performed_date.before_or_equal' => 'Performed date cannot be in the future.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
            'instances.required' => 'Select at least one instance to update.',
        ]);

        DB::beginTransaction();
        try {
            // Prepare affected instances data for JSON storage
            $affectedInstances = [];
            
            // Map form fields to database fields
            foreach ($validated['instances'] as $instData) {
                $instance = \App\Models\EquipmentInstance::find($instData['id']);
                
                // Store instance data for JSON field
                $affectedInstances[] = [
                    'instance_id' => $instance->id,
                    'instance_code' => $instance->instance_code,
                    'old_condition' => $instance->condition,
                    'new_condition' => $instData['condition'],
                    'location' => $instance->location ?? 'Not specified',
                    'notes' => $instData['notes'] ?? null,
                ];
                
                // Update instance condition according to maintenance result
                $instance->update([
                    'condition' => $instData['condition'],
                    'is_available' => in_array($instData['condition'], ['excellent','good','fair']) ? true : false,
                    'is_active' => !in_array($instData['condition'], ['lost', 'retired']) ? true : false,
                    'last_maintenance_date' => now('Asia/Manila'),
                ]);
                
                // Only create discard/retirement for lost or retired
                if (in_array($instData['condition'], ['lost', 'retired'])) {
                    $reason = match($instData['condition']) {
                        'lost' => 'lost',
                        'retired' => 'end_of_life',
                        default => 'other'
                    };
                    
                    $notes = $instData['notes'] ?? ($instData['condition'] === 'lost'
                        ? 'Equipment instance reported as lost'
                        : 'Equipment instance reached end of life');
                    
                    // Create retirement record
                    \App\Models\InstanceRetirement::create([
                        'equipment_instance_id' => $instance->id,
                        'reason' => $reason,
                        'notes' => $notes,
                        'acted_by' => auth()->id(),
                        'acted_at' => now('Asia/Manila'),
                    ]);
                    
                    // If equipment is marked as lost, also create Missing Equipment record
                    if ($instData['condition'] === 'lost') {
                        \App\Models\MissingEquipment::create([
                            'equipment_instance_id' => $instance->id,
                            'reservation_id' => null, // No specific reservation for maintenance-related loss
                            'borrower_name' => 'Maintenance Staff',
                            'borrower_email' => auth()->user()->email ?? 'maintenance@system.local',
                            'borrower_contact_number' => null,
                            'borrower_department' => 'Maintenance Department',
                            'incident_date' => now('Asia/Manila')->toDateString(),
                            'incident_type' => 'lost',
                            'incident_description' => $notes . ' - Equipment reported as lost during maintenance process',
                            'replacement_status' => 'pending',
                            'acted_by' => auth()->id(),
                            'acted_at' => now('Asia/Manila'),
                        ]);
                    }
                    
                    // Deactivate the instance
                    $instance->update([
                        'is_active' => false,
                        'is_available' => false,
                    ]);
                }
            }
            
            // Determine values compatible with DB enum while preserving custom label
            $customOther = $validated['maintenance_type'] === 'other' ? trim((string)($validated['maintenance_type_other'] ?? '')) : null;
            $maintenanceTypeToStore = $validated['maintenance_type'] === 'other' ? 'inspection' : $validated['maintenance_type'];
            $descriptionToStore = $validated['description'] ?? null;
            if ($customOther !== null && $customOther !== '') {
                $descriptionToStore = ($descriptionToStore ? ($descriptionToStore . "\n") : '') . 'Other maintenance type: ' . $customOther;
            }

            // Create single maintenance record for the equipment
            $equipment->maintenanceRecords()->create([
                'equipment_id' => $equipment->id,
                'maintenance_type' => $maintenanceTypeToStore,
                'description' => $descriptionToStore,
                'maintenance_date' => \Carbon\Carbon::parse($validated['performed_date'], 'Asia/Manila')->toDateString(),
                'performed_by' => auth()->user()->name,
                'notes' => $validated['notes'] ?? null,
                'affected_instances' => $affectedInstances,
            ]);

            // Recalculate equipment counts after maintenance
            $equipment->recalculateCounts();

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Maintenance record created successfully',
                    'redirect' => route('maintenance-management.show', $equipment)
                ]);
            }

            return redirect()->route('maintenance-management.show', $equipment)
                ->with('success', 'Maintenance record created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create maintenance record: ' . $e->getMessage()
                ], 422);
            }
            
            return back()->withErrors(['error' => 'Failed to create maintenance record: ' . $e->getMessage()]);
        }
    }

    public function editRecord(MaintenanceRecord $maintenanceRecord)
    {
        $equipment = $maintenanceRecord->equipment;
        $viewPath = 'admin-manager.maintenance-management.edit-record';
        return view($viewPath, compact('maintenanceRecord', 'equipment'));
    }

    public function updateRecord(Request $request, MaintenanceRecord $maintenanceRecord)
    {
        $validated = $request->validate([
            'maintenance_type' => 'required|in:routine,repair,upgrade,inspection,calibration',
            'description' => 'required|string|max:1000',
            'performed_by' => 'required|string|max:255',
            'performed_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'parts_used' => 'nullable|string|max:500',
        ]);

        // Map form fields to database fields
        $maintenanceData = [
            'maintenance_type' => $validated['maintenance_type'],
            'description' => $validated['description'],
            'maintenance_date' => $validated['performed_date'], // Map performed_date to maintenance_date
            'performed_by' => $validated['performed_by'],
            'notes' => $validated['notes'] ?? null,
            'parts_used' => $validated['parts_used'] ?? null,
        ];

        $maintenanceRecord->update($maintenanceData);

        // No schedule updating here anymore

        return redirect()->route('maintenance-management.show', $equipment)
            ->with('success', 'Maintenance record updated successfully');
    }

    public function deleteRecord(MaintenanceRecord $maintenanceRecord)
    {
        $equipment = $maintenanceRecord->equipment;
        $maintenanceRecord->delete();

        return redirect()->route('maintenance-management.show', $equipment)
            ->with('success', 'Maintenance record deleted successfully');
    }



    public function reports()
    {
        try {
            // Simple test first
            $totalRecords = MaintenanceRecord::count();
            $totalEquipment = Equipment::count();
            
            // Monthly maintenance costs - simplified
            $monthlyCosts = collect(); // Empty collection for now
            try {
                $monthlyCosts = MaintenanceRecord::selectRaw('YEAR(maintenance_date) as year, MONTH(maintenance_date) as month, SUM(cost) as total_cost')
                    ->whereNotNull('cost')
                    ->whereYear('maintenance_date', date('Y'))
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Monthly costs query error: ' . $e->getMessage());
            }

            // Maintenance by type - simplified
            $maintenanceByType = collect(); // Empty collection for now
            try {
                $maintenanceByType = MaintenanceRecord::selectRaw('maintenance_type, COUNT(*) as count')
                    ->groupBy('maintenance_type')
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Maintenance by type query error: ' . $e->getMessage());
            }

            // Equipment with most maintenance - simplified
            $equipmentMaintenance = collect(); // Empty collection for now
            try {
                $equipmentMaintenance = Equipment::with('category')
                    ->withCount('maintenanceRecords')
                    ->orderBy('maintenance_records_count', 'desc')
                    ->limit(10)
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Equipment maintenance query error: ' . $e->getMessage());
            }



            $viewPath = 'admin-manager.maintenance-management.reports';
            return view($viewPath, compact(
                'monthlyCosts', 
                'maintenanceByType', 
                'equipmentMaintenance', 
                'totalRecords',
                'totalEquipment'
            ));
        } catch (\Exception $e) {
            \Log::error('Maintenance reports error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to load maintenance reports: ' . $e->getMessage()]);
        }
    }



    public function generatePDF(Request $request)
    {
        try {
            // Get filters from request and normalize labels for display
            $filters = $request->only(['report_type', 'start_date', 'end_date', 'category', 'equipment_type', 'format']);
            if (!empty($filters['category'])) {
                $cat = \App\Models\EquipmentCategory::find($filters['category']);
                if ($cat) { $filters['category_name'] = $cat->name; }
            }
            if (!empty($filters['equipment_type'])) {
                $type = \App\Models\EquipmentType::find($filters['equipment_type']);
                if ($type) { $filters['equipment_type_name'] = $type->name; }
            }
            // Build query for equipment instances with their maintenance records
            $query = \App\Models\EquipmentInstance::with([
                'equipment.category', 
                'equipment.equipmentType', 
                'maintenanceRecords' => function($q) {
                    $q->orderBy('maintenance_date', 'desc');
                }
            ])->where('is_active', true);

            // Apply category and equipment type filters to instances
            if ($request->filled('category')) {
                $query->whereHas('equipment.category', function($q) use ($request){
                    $q->where('id', $request->category);
                });
            }
            if ($request->filled('equipment_type')) {
                $query->whereHas('equipment.equipmentType', function($q) use ($request){
                    $q->where('id', $request->equipment_type);
                });
            }
            
            // Handle report_type filtering for instances
            if ($request->filled('report_type') && $request->report_type !== 'all') {
                switch ($request->report_type) {
                    case 'recent':
                        // Filter instances that have recent maintenance records
                        $recentMaintenanceInstanceIds = \App\Models\MaintenanceRecord::where('maintenance_date', '>=', now()->subDays(30))
                            ->pluck('affected_instances')
                            ->flatten()
                            ->pluck('instance_id')
                            ->unique();
                        $query->whereIn('id', $recentMaintenanceInstanceIds);
                        break;
                    case 'routine':
                        // Filter instances that have routine maintenance records
                        $routineMaintenanceInstanceIds = \App\Models\MaintenanceRecord::where('maintenance_type', 'routine')
                            ->pluck('affected_instances')
                            ->flatten()
                            ->pluck('instance_id')
                            ->unique();
                        $query->whereIn('id', $routineMaintenanceInstanceIds);
                        break;
                    case 'repair':
                        // Filter instances that have repair maintenance records
                        $repairMaintenanceInstanceIds = \App\Models\MaintenanceRecord::where('maintenance_type', 'repair')
                            ->pluck('affected_instances')
                            ->flatten()
                            ->pluck('instance_id')
                            ->unique();
                        $query->whereIn('id', $repairMaintenanceInstanceIds);
                        break;
                    case 'inspection':
                        // Filter instances that have inspection maintenance records
                        $inspectionMaintenanceInstanceIds = \App\Models\MaintenanceRecord::where('maintenance_type', 'inspection')
                            ->pluck('affected_instances')
                            ->flatten()
                            ->pluck('instance_id')
                            ->unique();
                        $query->whereIn('id', $inspectionMaintenanceInstanceIds);
                        break;
                    case 'replacement':
                        // Filter instances that have replacement maintenance records
                        $replacementMaintenanceInstanceIds = \App\Models\MaintenanceRecord::where('maintenance_type', 'replacement')
                            ->pluck('affected_instances')
                            ->flatten()
                            ->pluck('instance_id')
                            ->unique();
                        $query->whereIn('id', $replacementMaintenanceInstanceIds);
                        break;
                }
            }
            
            // Handle date range filtering for instances with maintenance
            if ($request->filled('start_date') || $request->filled('end_date')) {
                $dateFilteredInstanceIds = \App\Models\MaintenanceRecord::when($request->filled('start_date'), function($q) use ($request) {
                        $q->where('maintenance_date', '>=', $request->start_date);
                    })
                    ->when($request->filled('end_date'), function($q) use ($request) {
                        $q->where('maintenance_date', '<=', $request->end_date);
                    })
                    ->pluck('affected_instances')
                    ->flatten()
                    ->pluck('instance_id')
                    ->unique();
                $query->whereIn('id', $dateFilteredInstanceIds);
            }
            
            // Handle category filtering (ensure we filter by id, not name)
            if ($request->filled('category')) {
                $query->whereHas('equipment.category', function($q) use ($request) {
                    $q->where('id', $request->category);
                });
            }
            
            // Handle equipment type filtering
            if ($request->filled('equipment_type')) {
                $query->whereHas('equipment.equipmentType', function($q) use ($request) {
                    $q->where('id', $request->equipment_type);
                });
            }
            
            $equipmentInstances = $query->get();
            
            // Get maintenance records for summary (apply same filters)
            $maintenanceRecords = \App\Models\MaintenanceRecord::with(['equipment.category','equipment.equipmentType'])
                ->when($request->filled('start_date'), function($q) use ($request) {
                    $q->where('maintenance_date', '>=', $request->start_date);
                })
                ->when($request->filled('end_date'), function($q) use ($request) {
                    $q->where('maintenance_date', '<=', $request->end_date);
                })
                ->when($request->filled('category'), function($q) use ($request) {
                    $q->whereHas('equipment.category', function($cq) use ($request){
                        $cq->where('id', $request->category);
                    });
                })
                ->when($request->filled('equipment_type'), function($q) use ($request) {
                    $q->whereHas('equipment.equipmentType', function($tq) use ($request){
                        $tq->where('id', $request->equipment_type);
                    });
                })
                ->get();
            
            // Check if format is PDF (currently only PDF is supported)
            if ($request->filled('format') && $request->format !== 'pdf') {
                return back()->withErrors(['error' => 'Currently only PDF format is supported.']);
            }
            
            // Generate PDF with equipment instances
            $pdf = \App\Services\PDFService::generateMaintenanceReport($equipmentInstances, $maintenanceRecords, $filters);
            
            $filename = 'maintenance_report_' . now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            \Log::error('Maintenance PDF Generation Error: ' . $e->getMessage());
            \Log::error('Maintenance PDF Generation Error Stack: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
        }
    }

    public function exportExcel(Request $request)
    {
        if (!class_exists(\Shuchkin\SimpleXLSXGen::class)) {
            $path = base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');
            if (file_exists($path)) { require_once $path; }
        }

        $records = \App\Models\EquipmentInstance::with(['equipment.category','equipment.equipmentType'])
            ->where('is_active', true)
            ->get();

        $rows = [];
        $rows[] = ['Instance Code', 'Equipment', 'Category', 'Type', 'Condition', 'Available', 'Location'];
        foreach ($records as $inst) {
            $rows[] = [
                $inst->instance_code,
                optional($inst->equipment)->name,
                optional($inst->equipment->category)->name ?? '',
                optional($inst->equipment->equipmentType)->name ?? '',
                $inst->condition,
                $inst->is_available ? 'Yes' : 'No',
                $inst->location,
            ];
        }

        $filename = 'maintenance-export-' . date('Y-m-d-His') . '.xlsx';
        \Shuchkin\SimpleXLSXGen::fromArray($rows)->downloadAs($filename);
        return response()->noContent();
    }
    
    public function exportDiscardedExcel(Request $request)
    {
        if (!class_exists(\Shuchkin\SimpleXLSXGen::class)) {
            $path = base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');
            if (file_exists($path)) { require_once $path; }
        }

        // Build query with filters
        $query = \App\Models\InstanceRetirement::with([
            'equipmentInstance.equipment.category',
            'equipmentInstance.equipment.equipmentType',
            'actedBy'
        ]);

        // Apply filters from request
        if ($request->filled('report_type') && $request->report_type !== 'all') {
            $query->where('reason', $request->report_type);
        }
        if ($request->filled('category')) {
            $query->whereHas('equipmentInstance.equipment', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }
        if ($request->filled('start_date')) {
            $query->where('acted_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('acted_at', '<=', $request->end_date . ' 23:59:59');
        }

        $discardedItems = $query->latest('acted_at')->get();

        $rows = [];
        $rows[] = ['Instance Code', 'Equipment', 'Category', 'Reason', 'Discarded By', 'Discarded At', 'Notes'];
        foreach ($discardedItems as $item) {
            $rows[] = [
                optional($item->equipmentInstance)->instance_code,
                optional(optional($item->equipmentInstance)->equipment)->display_name,
                optional(optional(optional($item->equipmentInstance)->equipment)->category)->name,
                ucwords(str_replace('_', ' ', $item->reason)),
                optional($item->actedBy)->name,
                $item->acted_at->format('Y-m-d H:i'),
                $item->notes,
            ];
        }

        $filename = 'discarded-equipment-export-' . date('Y-m-d-His') . '.xlsx';
        \Shuchkin\SimpleXLSXGen::fromArray($rows)->downloadAs($filename);
        return response()->noContent();
    }

    /**
     * Get simplified maintenance statistics
     */
    private function getMaintenanceEnforcementStats(): array
    {
        $totalInstances = \App\Models\EquipmentInstance::where('is_active', true)->count();
        
        // Equipment needing maintenance (based on condition)
        $needingMaintenance = \App\Models\EquipmentInstance::where('is_active', true)
            ->whereIn('condition', ['needs_repair', 'maintenance', 'damaged', 'under_maintenance'])
            ->count();
        
        // For now, simplify the logic - just count total maintenance records
        // This avoids complex JSON queries that might not work in all databases
        $totalMaintenanceRecords = \App\Models\MaintenanceRecord::count();
        
        // Maintenance completion percentage
        $maintenanceCompletionPercentage = $totalInstances > 0 ? 
            round((($totalInstances - $needingMaintenance) / $totalInstances) * 100, 2) : 0;

        return [
            'total_instances' => $totalInstances,
            'needing_maintenance' => $needingMaintenance,
            'instances_with_maintenance' => $totalMaintenanceRecords, // Simplified for now
            'maintenance_completion_percentage' => $maintenanceCompletionPercentage,
            'available_instances' => $totalInstances - $needingMaintenance
        ];
    }

    /**
     * Discard damaged equipment instances
     */
    public function discardDamaged(Request $request)
    {
        try {
            $validated = $request->validate([
                'equipment_id' => 'required|exists:equipment,id',
                'password' => 'required|string',
            ]);

            // Verify password
            if (!Hash::check($validated['password'], auth()->user()->password)) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Incorrect password. Please try again.'
                    ], 422);
                }
                return back()->withErrors(['password' => 'Incorrect password. Please try again.']);
            }

            $equipment = Equipment::findOrFail($validated['equipment_id']);
            
            // Get all damaged and needs_repair instances for this equipment
            $discardableInstances = $equipment->instances()
                ->whereIn('condition', ['damaged', 'needs_repair', 'under_maintenance'])
                ->where('is_active', true)
                ->get();

            if ($discardableInstances->isEmpty()) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No damaged or repair instances found for this equipment.'
                    ], 422);
                }
                return back()->withErrors(['error' => 'No damaged or repair instances found for this equipment.']);
            }

            DB::beginTransaction();

            $discardedCount = 0;
            foreach ($discardableInstances as $instance) {
                // Create retirement record
                \App\Models\InstanceRetirement::create([
                    'equipment_instance_id' => $instance->id,
                    'reason' => 'beyond_repair',
                    'notes' => 'Discarded due to damage beyond repair',
                    'acted_by' => auth()->id(),
                    'acted_at' => now(),
                ]);

                // Deactivate the instance
                $instance->update([
                    'is_active' => false,
                    'is_available' => false,
                    'condition' => 'retired'
                ]);

                $discardedCount++;
            }

            // Recalculate equipment counts
            $equipment->recalculateCounts();

            DB::commit();

            // Log the action
            \Log::info('Damaged equipment discarded', [
                'user' => auth()->user()->name,
                'equipment' => $equipment->display_name,
                'instances_discarded' => $discardedCount,
                'timestamp' => now()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully discarded {$discardedCount} damaged/repair instance(s) of {$equipment->display_name}.",
                    'discarded_count' => $discardedCount
                ]);
            }
            return back()->with('success', "Successfully discarded {$discardedCount} damaged/repair instance(s) of {$equipment->display_name}.");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to discard damaged equipment', [
                'error' => $e->getMessage(),
                'equipment_id' => $validated['equipment_id'] ?? null,
                'user' => auth()->user()->name
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to discard damaged equipment: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Failed to discard damaged equipment: ' . $e->getMessage()]);
        }
    }

    /**
     * View discarded equipment instances
     */
    public function discarded(Request $request)
    {
        $query = \App\Models\InstanceRetirement::with([
            'equipmentInstance.equipment.category',
            'equipmentInstance.equipment.equipmentType',
            'actedBy'
        ]);

        // Filter by reason
        if ($request->filled('reason')) {
            $query->where('reason', $request->reason);
        }

        // Filter by equipment
        if ($request->filled('equipment')) {
            $query->whereHas('equipmentInstance.equipment', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->equipment . '%');
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('acted_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('acted_at', '<=', $request->date_to . ' 23:59:59');
        }

        $perPage = max(5, min((int) $request->get('per_page', 15), 100));
        $discardedItems = $query->latest('acted_at')->paginate($perPage)->appends($request->query());

        // Get statistics
        $totalDiscarded = \App\Models\InstanceRetirement::count();
        $discardedThisMonth = \App\Models\InstanceRetirement::whereMonth('acted_at', now()->month)
            ->whereYear('acted_at', now()->year)
            ->count();
        $discardedThisYear = \App\Models\InstanceRetirement::whereYear('acted_at', now()->year)->count();

        // Get categories and equipment types for filters
        $categories = \App\Models\EquipmentCategory::orderBy('name')->get();
        $equipmentTypes = \App\Models\EquipmentType::orderBy('name')->get();

        $viewPath = 'admin-manager.maintenance-management.discarded';
        
        return view($viewPath, compact(
            'discardedItems', 
            'totalDiscarded', 
            'discardedThisMonth', 
            'discardedThisYear',
            'categories',
            'equipmentTypes'
        ));
    }

    /**
     * Routine maintenance enforcement - put all equipment instances on maintenance mode
     */
    public function routineMaintenance(Request $request)
    {
        try {
            // Validate password
            $validated = $request->validate([
                'password' => 'required|string',
            ]);

            // Verify password
            if (!Hash::check($validated['password'], auth()->user()->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect password. Please try again.'
                ], 400);
            }

            // Check if user is admin or manager
            if (!auth()->user()->isAdmin() && !auth()->user()->isManager()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only administrators and managers can perform routine maintenance enforcement'
                ], 403);
            }

            DB::beginTransaction();

            // Get all active equipment instances WITHOUT an active reservation link
            $instances = \App\Models\EquipmentInstance::where('is_active', true)
                ->whereDoesntHave('reservationItemInstances', function($q) {
                    $q->whereNull('returned_at')
                      ->whereHas('reservationItem.reservation', function($r) {
                          $r->whereIn('status', ['pending', 'approved', 'picked_up', 'returned']);
                      });
                })
                ->get();
            $updatedCount = 0;
            $skippedWithActiveReservation = \App\Models\EquipmentInstance::where('is_active', true)
                ->whereHas('reservationItemInstances', function($q) {
                    $q->whereNull('returned_at')
                      ->whereHas('reservationItem.reservation', function($r) {
                          $r->whereIn('status', ['pending', 'approved', 'picked_up', 'returned']);
                      });
                })->count();

            foreach ($instances as $instance) {
                // Update instance to maintenance mode (use under_maintenance condition)
                $instance->update([
                    'is_available' => false,
                    'condition' => 'under_maintenance'
                ]);

                // Create maintenance record for this enforcement action
                \App\Models\MaintenanceRecord::create([
                    'equipment_id' => $instance->equipment_id,
                    'maintenance_type' => 'routine_maintenance_mode',
                    'maintenance_date' => now(),
                    'description' => 'Routine maintenance mode activated by administrator',
                    'performed_by' => auth()->user()->name,
                    'affected_instances' => [
                        [
                            'instance_id' => $instance->id,
                            'instance_code' => $instance->instance_code,
                            'old_condition' => $instance->getOriginal('condition'),
                            'new_condition' => 'under_maintenance',
                            'location' => $instance->location ?? 'Not specified',
                            'notes' => 'Routine maintenance mode activated'
                        ]
                    ]
                ]);

                $updatedCount++;
            }

            // Recalculate counts for all equipment
            \App\Models\Equipment::chunk(100, function($equipment) {
                foreach ($equipment as $eq) {
                    $eq->recalculateCounts();
                }
            });

            DB::commit();

            // Log the action
            \Log::info('Routine maintenance enforcement activated', [
                'admin_user' => auth()->user()->name,
                'instances_updated' => $updatedCount,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Routine maintenance mode activated successfully',
                'instances_updated' => $updatedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Routine maintenance enforcement failed', [
                'error' => $e->getMessage(),
                'admin_user' => auth()->user()->name,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to activate routine maintenance mode: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate PDF report for discarded equipment
     */
    public function generateDiscardedReport(Request $request)
    {
        try {
            // Build query with filters
            $query = \App\Models\InstanceRetirement::with([
                'equipmentInstance.equipment.category',
                'equipmentInstance.equipment.equipmentType',
                'actedBy'
            ]);

            // Filter by reason
            if ($request->filled('report_type') && $request->report_type !== 'all') {
                $query->where('reason', $request->report_type);
            }

            // Filter by category
            if ($request->filled('category')) {
                $query->whereHas('equipmentInstance.equipment', function($q) use ($request) {
                    $q->where('category_id', $request->category);
                });
            }

            // Filter by equipment type
            if ($request->filled('equipment_type')) {
                $query->whereHas('equipmentInstance.equipment', function($q) use ($request) {
                    $q->where('type_id', $request->equipment_type);
                });
            }

            // Filter by equipment
            if ($request->filled('equipment')) {
                $query->whereHas('equipmentInstance.equipment', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->equipment . '%');
                });
            }

            // Filter by date range
            if ($request->filled('start_date')) {
                $query->where('acted_at', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->where('acted_at', '<=', $request->end_date . ' 23:59:59');
            }

            $discardedItems = $query->latest('acted_at')->get();

            // Prepare filters for the report
            $filters = [];
            if ($request->filled('report_type') && $request->report_type !== 'all') {
                $filters['report_type'] = ucwords(str_replace('_', ' ', $request->report_type));
            }
            if ($request->filled('category')) {
                $category = \App\Models\EquipmentCategory::find($request->category);
                $filters['category'] = $category ? $category->name : 'Unknown Category';
            }
            if ($request->filled('equipment_type')) {
                $type = \App\Models\EquipmentType::find($request->equipment_type);
                $filters['equipment_type'] = $type ? $type->name : 'Unknown Type';
            }
            if ($request->filled('start_date')) {
                $filters['start_date'] = $request->start_date;
            }
            if ($request->filled('end_date')) {
                $filters['end_date'] = $request->end_date;
            }
            if ($request->filled('equipment')) {
                $filters['equipment'] = $request->equipment;
            }

            // Generate PDF using the PDFService
            $pdf = \App\Services\PDFService::generateDiscardedReport($discardedItems, $filters);
            
            $filename = 'discarded_equipment_report_' . now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            \Log::error('Discarded Equipment PDF Generation Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
        }
    }

    /**
     * Set routine maintenance for all equipment instances
     */
    public function setRoutineMaintenance(Request $request)
    {
        $validated = $request->validate([
            'duration' => 'required|integer|min:1|max:30',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Get all available equipment instances
            $instances = \App\Models\EquipmentInstance::where('status', 'available')->get();
            
            $updatedCount = 0;
            foreach ($instances as $instance) {
                $instance->update([
                    'status' => 'under_maintenance',
                    'condition' => 'under_maintenance',
                ]);
                $updatedCount++;
            }

            // Create maintenance records for all equipment
            $equipment = Equipment::all();
            foreach ($equipment as $item) {
                MaintenanceRecord::create([
                    'equipment_id' => $item->id,
                    'maintenance_type' => 'routine',
                    'maintenance_date' => now(),
                    'description' => $validated['notes'] ?? 'Routine maintenance mode activated',
                    'performed_by' => auth()->user()->name,
                    'cost' => 0,
                    'next_maintenance_date' => now()->addDays($validated['duration']),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Routine maintenance mode activated for {$updatedCount} equipment instances. Duration: {$validated['duration']} days.",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Routine maintenance activation failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to activate routine maintenance mode. Please try again.'
            ], 500);
        }
    }

    public function emergencyEnforcement(Request $request)
    {
        try {
            // Check if user is admin
            if (!auth()->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only administrators can perform routine maintenance enforcement'
                ], 403);
            }

            DB::beginTransaction();

            // Get all active equipment instances WITHOUT an active reservation link
            $instances = \App\Models\EquipmentInstance::where('is_active', true)
                ->whereDoesntHave('reservationItemInstances', function($q) {
                    $q->whereNull('returned_at')
                      ->whereHas('reservationItem.reservation', function($r) {
                          $r->whereIn('status', ['pending', 'approved', 'picked_up', 'returned']);
                      });
                })
                ->get();
            $updatedCount = 0;
            $skippedWithActiveReservation = \App\Models\EquipmentInstance::where('is_active', true)
                ->whereHas('reservationItemInstances', function($q) {
                    $q->whereNull('returned_at')
                      ->whereHas('reservationItem.reservation', function($r) {
                          $r->whereIn('status', ['pending', 'approved', 'picked_up', 'returned']);
                      });
                })
                ->count();

            foreach ($instances as $instance) {
                $instance->update([
                    'is_available' => false,
                    'condition' => 'under_maintenance'
                ]);

                // Create maintenance record for this enforcement action
                \App\Models\MaintenanceRecord::create([
                    'equipment_id' => $instance->equipment_id,
                    'maintenance_type' => 'routine_maintenance_mode',
                    'maintenance_date' => now(),
                    'description' => 'Routine maintenance mode activated by administrator',
                    'performed_by' => auth()->user()->name,
                    'affected_instances' => [
                        [
                            'instance_id' => $instance->id,
                            'instance_code' => $instance->instance_code,
                            'old_condition' => $instance->getOriginal('condition'),
                            'new_condition' => 'under_maintenance',
                            'location' => $instance->location ?? 'Not specified',
                            'notes' => 'Routine maintenance mode activated'
                        ]
                    ]
                ]);

                $updatedCount++;
            }

            // Recalculate counts for all equipment
            \App\Models\Equipment::chunk(100, function($equipment) {
                foreach ($equipment as $eq) {
                    $eq->recalculateCounts();
                }
            });

            DB::commit();

            // Log the action
            \Log::info('Routine maintenance enforcement activated', [
                'admin_user' => auth()->user()->name,
                'instances_updated' => $updatedCount,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'instances_updated' => $updatedCount,
                'instances_skipped_active_reservation' => $skippedWithActiveReservation,
                'message' => 'Routine maintenance enforcement completed successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Routine maintenance enforcement failed', [
                'error' => $e->getMessage(),
                'admin_user' => auth()->user()->name,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to enforce routine maintenance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Complete maintenance for equipment instances
     */
    public function completeMaintenance(Request $request)
    {
        try {
            $validated = $request->validate([
                'equipment_id' => 'required|exists:equipment,id',
            ]);

            $equipment = Equipment::findOrFail($validated['equipment_id']);

            DB::beginTransaction();

            // Get all instances of this equipment that are under maintenance
            $instances = $equipment->instances()->where('condition', 'under_maintenance')->get();
            $updatedCount = 0;

            foreach ($instances as $instance) {
                $instance->update([
                    'is_available' => true,
                    'condition' => 'good'
                ]);

                // Create maintenance record for completion
                \App\Models\MaintenanceRecord::create([
                    'equipment_id' => $equipment->id,
                    'maintenance_type' => 'routine',
                    'maintenance_date' => now(),
                    'description' => 'Maintenance completed - equipment restored to available status',
                    'performed_by' => auth()->user()->name,
                    'affected_instances' => [
                        [
                            'instance_id' => $instance->id,
                            'instance_code' => $instance->instance_code,
                            'old_condition' => 'under_maintenance',
                            'new_condition' => 'good',
                            'location' => $instance->location ?? 'Not specified',
                            'notes' => 'Maintenance completed successfully'
                        ]
                    ]
                ]);

                $updatedCount++;
            }

            // Recalculate counts for the equipment
            $equipment->recalculateCounts();

            DB::commit();

            // Log the action
            \Log::info('Maintenance completed', [
                'admin_user' => auth()->user()->name,
                'equipment_id' => $equipment->id,
                'equipment_name' => $equipment->display_name,
                'instances_updated' => $updatedCount,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'instances_updated' => $updatedCount,
                'message' => 'Maintenance completed successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Maintenance completion failed', [
                'error' => $e->getMessage(),
                'equipment_id' => $request->equipment_id ?? 'unknown',
                'admin_user' => auth()->user()->name,
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to complete maintenance: ' . $e->getMessage()
            ], 500);
        }
    }




}
