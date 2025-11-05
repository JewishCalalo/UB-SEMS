<?php

namespace App\Http\Controllers;

use App\Models\MissingEquipment;
use App\Models\EquipmentInstance;
use App\Models\Equipment;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Traits\ManagementTrait;

class MissingEquipmentController extends Controller
{
    use ManagementTrait;
    
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:manager,admin');
    }

    public function index(Request $request)
    {
        $query = MissingEquipment::with([
            'equipmentInstance.equipment.category',
            'equipmentInstance.equipment.equipmentType',
            'reservation',
            'actedBy'
        ]);

        // Apply common missing equipment filters
        $query = $this->applyMissingEquipmentFilters($query, $request);

        // Apply common sorting
        $query = $this->applySorting($query, $request, 'incident_date');

        // Apply common pagination
        $stolenLostItems = $this->applyPagination($query, $request);

        // Get statistics
        $totalItems = MissingEquipment::count();
        $pendingItems = MissingEquipment::pending()->count();
        $replacedItems = MissingEquipment::replaced()->count();
        $notReplacedItems = MissingEquipment::notReplaced()->count();
        
        $lostCount = MissingEquipment::byIncidentType('lost')->count();
        $notReturnedCount = MissingEquipment::byIncidentType('not_returned')->count();

        // Get common filter data
        $filterData = $this->getCommonFilterData();
        $categories = $filterData['categories'];
        $equipmentTypes = $filterData['equipmentTypes'];

        $viewPath = 'admin-manager.missing-equipment.index';
        
        return view($viewPath, compact(
            'stolenLostItems',
            'totalItems',
            'pendingItems',
            'replacedItems',
            'notReplacedItems',
            'lostCount',
            'notReturnedCount',
            'categories',
            'equipmentTypes'
        ));
    }

    public function create()
    {
        $equipmentInstances = EquipmentInstance::with(['equipment.category'])
            ->whereIn('condition', ['lost','damaged'])
            ->where('is_active', true)
            ->get();

        $categories = EquipmentCategory::orderBy('name')->get();

        $viewPath = 'admin-manager.missing-equipment.create';
        return view($viewPath, compact('equipmentInstances', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_instance_id' => 'required|exists:equipment_instances,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'borrower_name' => 'required|string|max:255',
            'borrower_email' => 'required|email|max:255',
            'borrower_contact_number' => 'nullable|string|max:20',
            'borrower_department' => 'nullable|string|max:255',
            'incident_date' => 'required|date',
            'incident_type' => 'required|in:lost,not_returned',
            'incident_description' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $stolenLostEquipment = MissingEquipment::create([
                ...$validated,
                'acted_by' => Auth::id(),
                'acted_at' => now(),
            ]);

            // Update the equipment instance condition if not already set
            $instance = EquipmentInstance::find($validated['equipment_instance_id']);
            if ($instance && !in_array($instance->condition, ['lost'])) {
                $instance->update([
                    'condition' => $validated['incident_type'],
                    'is_available' => false,
                    'condition_notes' => 'Marked as ' . $validated['incident_type'] . ' - ' . ($validated['incident_description'] ?? 'No description provided'),
                ]);
            }

            DB::commit();

            return redirect()->route('missing-equipment.index')
                ->with('success', 'Missing equipment record created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create record: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(MissingEquipment $stolenLostEquipment)
    {
        $stolenLostEquipment->load([
            'equipmentInstance.equipment.category',
            'reservation',
            'actedBy'
        ]);

        $viewPath = 'admin-manager.missing-equipment.show';
        return view($viewPath, compact('stolenLostEquipment'));
    }

    public function edit(MissingEquipment $stolenLostEquipment)
    {
        $stolenLostEquipment->load(['equipmentInstance.equipment.category', 'reservation']);
        
        $categories = EquipmentCategory::orderBy('name')->get();

        $viewPath = 'admin-manager.missing-equipment.edit';
        return view($viewPath, compact('stolenLostEquipment', 'categories'));
    }

    public function update(Request $request, MissingEquipment $stolenLostEquipment)
    {
        $validated = $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrower_email' => 'required|email|max:255',
            'borrower_contact_number' => 'nullable|string|max:20',
            'borrower_department' => 'nullable|string|max:255',
            'incident_date' => 'required|date',
            'incident_type' => 'required|in:lost,not_returned',
            'incident_description' => 'nullable|string|max:1000',
            'replacement_status' => 'required|in:pending,replaced,not_replaced',
            'replacement_date' => 'nullable|date',
        ]);

        try {
            DB::beginTransaction();

            $stolenLostEquipment->update($validated);

            // Update equipment instance condition if incident type changed
            $instance = $stolenLostEquipment->equipmentInstance;
            if ($instance && $instance->condition !== $validated['incident_type']) {
                $instance->update([
                    'condition' => $validated['incident_type'],
                    'condition_notes' => 'Updated to ' . $validated['incident_type'] . ' - ' . ($validated['incident_description'] ?? 'No description provided'),
                ]);
            }

            DB::commit();

            return redirect()->route('missing-equipment.show', $stolenLostEquipment)
                ->with('success', 'Record updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update record: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(MissingEquipment $stolenLostEquipment)
    {
        try {
            $stolenLostEquipment->delete();
            return redirect()->route('missing-equipment.index')
                ->with('success', 'Record deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete record: ' . $e->getMessage()]);
        }
    }

    public function markAsReplaced(Request $request, MissingEquipment $stolenLostEquipment)
    {
        $validated = $request->validate([
            'replacement_date' => 'nullable|date',
        ]);

        try {
            $stolenLostEquipment->markAsReplaced($validated['replacement_date'] ?? now());
            
            return back()->with('success', 'Equipment marked as replaced successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to mark as replaced: ' . $e->getMessage()]);
        }
    }

    public function markAsNotReplaced(MissingEquipment $stolenLostEquipment)
    {
        try {
            $stolenLostEquipment->markAsNotReplaced();
            
            // Add borrower email to blacklist unless privileged role
            $email = strtolower(trim($stolenLostEquipment->borrower_email));
            $user = \App\Models\User::where('email', $email)->first();
            $role = $user?->role;
            if (!in_array($role, ['admin','manager','instructor'], true)) {
                \App\Models\BlacklistedEmail::firstOrCreate(
                    ['email' => $email],
                    [
                        'missing_equipment_id' => $stolenLostEquipment->id,
                        'reason' => 'Failed to replace lost/damaged equipment',
                        'added_by' => auth()->id(),
                        'added_at' => now(),
                    ]
                );
            }

            return back()->with('success', 'Equipment marked as not replaced.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to mark as not replaced: ' . $e->getMessage()]);
        }
    }

    public function generatePDF(Request $request)
    {
        $query = MissingEquipment::with([
            'equipmentInstance.equipment.category',
            'reservation',
            'actedBy'
        ]);

        // Apply filters
        if ($request->filled('incident_type')) {
            $query->where('incident_type', $request->incident_type);
        }

        if ($request->filled('replacement_status')) {
            $query->where('replacement_status', $request->replacement_status);
        }

        if ($request->filled('category')) {
            $query->whereHas('equipmentInstance.equipment.category', function($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        if ($request->filled('equipment_type')) {
            $query->whereHas('equipmentInstance.equipment.equipmentType', function($q) use ($request) {
                $q->where('id', $request->equipment_type);
            });
        }

        if ($request->filled('date_from')) {
            $query->where('incident_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('incident_date', '<=', $request->date_to);
        }

        $stolenLostItems = $query->orderBy('incident_date', 'desc')->get();
        
        // Get filters for PDF display
        $filters = $request->only(['incident_type', 'replacement_status', 'category', 'equipment_type', 'date_from', 'date_to']);

        try {
            $pdf = \PDF::loadView('pdf.missing-equipment', compact('stolenLostItems', 'filters'));
            
            return $pdf->stream('missing-equipment-report-' . now()->format('Y-d') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
        }
    }

    public function exportExcel(Request $request)
    {
        if (!class_exists(\Shuchkin\SimpleXLSXGen::class)) {
            $path = base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');
            if (file_exists($path)) { require_once $path; }
        }

        $query = MissingEquipment::with(['equipmentInstance.equipment.category','reservation']);
        if ($request->filled('incident_type')) { $query->where('incident_type', $request->incident_type); }
        if ($request->filled('replacement_status')) { $query->where('replacement_status', $request->replacement_status); }
        $items = $query->orderBy('incident_date','desc')->get();

        $rows = [];
        $rows[] = ['Incident Date', 'Type', 'Instance', 'Equipment', 'Category', 'Status', 'Location', 'Replacement'];
        foreach ($items as $item) {
            $rows[] = [
                (string) $item->incident_date,
                ucfirst($item->incident_type),
                optional($item->equipmentInstance)->instance_code,
                optional(optional($item->equipmentInstance)->equipment)->name,
                optional(optional($item->equipmentInstance)->equipment->category)->name ?? '',
                $item->status,
                optional($item->equipmentInstance)->location,
                $item->replacement_status,
            ];
        }

        $filename = 'missing-equipment-export-' . date('Y-m-d-His') . '.xlsx';
        \Shuchkin\SimpleXLSXGen::fromArray($rows)->downloadAs($filename);
        return response()->noContent();
    }


}
