<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentType;
use App\Models\EquipmentInstance;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;
use App\Http\Requests\Equipment\EquipmentStoreRequest;
use App\Http\Requests\Equipment\EquipmentUpdateRequest;
use App\Http\Requests\Maintenance\MaintenanceRecordStoreRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Traits\ManagementTrait;
use App\Models\Wishlist;

class EquipmentManagementController extends Controller
{
    use ManagementTrait;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:manager,admin');
    }

    public function index(Request $request)
    {
        $query = Equipment::with(['category', 'equipmentType', 'images', 'instances']);

        // Apply common equipment filters
        $query = $this->applyEquipmentFilters($query, $request);

        // Apply common sorting
        $query = $this->applySorting($query, $request, 'name');

        // Apply common pagination
        $equipment = $this->applyPagination($query, $request);
        
        // Ensure all relationships are loaded for each equipment item
        $equipment->load(['images', 'category', 'equipmentType', 'instances']);

        // Get common filter data
        $filterData = $this->getCommonFilterData();
        $categories = $filterData['categories'];
        $equipmentTypes = $filterData['equipmentTypes'];

        // Get equipment alerts and warnings
        $alerts = $this->getEquipmentAlerts();

        $viewPath = 'admin-manager.equipment-management.index';
        return view($viewPath, compact('equipment', 'categories', 'equipmentTypes', 'alerts'));
    }

    public function create(Request $request)
    {
        $categories = EquipmentCategory::orderBy('name')->get();
        $selectedCategory = $request->get('category');
        
        // Get all equipment types grouped by category for the dropdown
        $equipmentTypesByCategory = EquipmentType::orderBy('name')
            ->get()
            ->groupBy('category_id');
            
        $viewPath = 'admin-manager.equipment-management.create';
        return view($viewPath, compact('categories', 'selectedCategory', 'equipmentTypesByCategory'));
    }

    public function store(EquipmentStoreRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Explicitly drop deprecated fields that may still be posted by cached views
            unset($validated['purchase_price']);

            // Prevent duplicate equipment by brand+model+category+type (case and whitespace insensitive)
            $duplicate = Equipment::where('category_id', $validated['category_id'])
                ->where('equipment_type_id', $validated['equipment_type_id'])
                ->whereRaw('LOWER(TRIM(brand)) = LOWER(TRIM(?))', [$validated['brand']])
                ->whereRaw('LOWER(TRIM(model)) = LOWER(TRIM(?))', [$validated['model']])
                ->first();

            if ($duplicate) {
                DB::rollBack();
                return back()
                    ->withInput()
                    ->withErrors(['duplicate' => 'An equipment with the same Brand, Model, Category and Type already exists.']);
            }

            $validated['created_by'] = auth()->id();
            $validated['quantity_available'] = $validated['quantity_total']; // Initially all items are available
            $equipment = Equipment::create($validated);

            // Auto-create instance records to match quantity_total
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

            // Log equipment creation activity
            \App\Services\ActivityLogService::logEquipmentCreated($equipment, $request);
            
            // Log bulk instance creation
            if ($quantityTotal > 0) {
                \App\Services\ActivityLogService::logBulkInstancesCreated($quantityTotal, $equipment->display_name, $request);
            }

        // Handle image uploads with comprehensive debugging
        if ($request->hasFile('images')) {
            Log::info('=== IMAGE UPLOAD PROCESS STARTED ===');
            Log::info('Equipment ID: ' . $equipment->id);
            
            $uploadedImages = [];
            $failedImages = [];
            
            // Handle both single file and multiple files
            $files = $request->file('images');
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $index => $image) {
                if (!$image) continue;
                
                Log::info("Processing image {$index}:");
                Log::info("- Original name: " . $image->getClientOriginalName());
                Log::info("- Size: " . $image->getSize() . " bytes");
                Log::info("- MIME type: " . $image->getMimeType());
                Log::info("- Is valid: " . ($image->isValid() ? 'YES' : 'NO'));
                Log::info("- Error code: " . $image->getError());
                
                if (!$image->isValid()) {
                    Log::error("Image {$index} is not valid, skipping");
                    $failedImages[] = $image->getClientOriginalName();
                    continue;
                }
                
                try {
                    // Convert image to base64 data URL (like reservation system)
                    $base64 = base64_encode(file_get_contents($image));
                    $mimeType = $image->getMimeType();
                    $dataUrl = "data:{$mimeType};base64,{$base64}";
                    
                    // Create database record with base64 data
                    $imageRecord = $equipment->images()->create([
                        'image_path' => $dataUrl,
                        'is_primary' => $index === 0,
                    ]);
                    
                    Log::info("✓ Image {$index} uploaded successfully as base64 data URL");
                    Log::info("- Database record ID: " . $imageRecord->id);
                    $uploadedImages[] = $image->getClientOriginalName();
                    
                } catch (\Exception $e) {
                    Log::error("Exception during image {$index} upload: " . $e->getMessage());
                    Log::error("Stack trace: " . $e->getTraceAsString());
                    $failedImages[] = $image->getClientOriginalName();
                }
            }
            
            Log::info("=== UPLOAD SUMMARY ===");
            Log::info("Successfully uploaded: " . count($uploadedImages));
            Log::info("Failed uploads: " . count($failedImages));
            if (!empty($uploadedImages)) {
                Log::info("Uploaded files: " . implode(', ', $uploadedImages));
            }
            if (!empty($failedImages)) {
                Log::info("Failed files: " . implode(', ', $failedImages));
            }
            Log::info("=== IMAGE UPLOAD PROCESS ENDED ===");
            
        } else {
            Log::info('No images in request - hasFile(images) returned false');
            Log::info('$_FILES contents: ' . json_encode($_FILES));
        }

            DB::commit();

            return redirect()->route('equipment-management.index')
                ->with('success', 'Equipment created successfully')
                ->with('success_title', 'Equipment Created')
                ->with('success_variant', 'banner');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create equipment: ' . $e->getMessage()]);
        }
    }

    public function show(Equipment $equipment)
    {
        // Only load active instances (not retired/discarded)
        $equipment->load(['category', 'equipmentType', 'images', 'maintenanceRecords', 'instances' => function($query) {
            $query->where('is_active', true);
        }]);
        $maintenanceRecords = $equipment->maintenanceRecords()->latest()->paginate(10);
        
        $viewPath = 'admin-manager.equipment-management.show';
        return view($viewPath, compact('equipment', 'maintenanceRecords'));
    }

    public function edit(Equipment $equipment)
    {
        $categories = EquipmentCategory::orderBy('name')->get();
        // Provide equipment types grouped by category for dependent dropdown
        $equipmentTypesByCategory = EquipmentType::orderBy('name')
            ->get()
            ->groupBy('category_id');

        $viewPath = 'admin-manager.equipment-management.edit';
        return view($viewPath, compact('equipment', 'categories', 'equipmentTypesByCategory'));
    }

    public function update(EquipmentUpdateRequest $request, Equipment $equipment)
    {
        // Debug: Log the request data
        Log::info('Equipment update request', [
            'equipment_id' => $equipment->id,
            'request_data' => $request->all()
        ]);
        
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            // Explicitly drop deprecated fields that may still be posted by cached views
            unset($validated['purchase_price']);

            // Handle checkbox fields
            $validated['is_active'] = $request->has('is_active');
            
            $equipment->update($validated);

            // Adjust instances only if quantity_total was explicitly provided
            if (array_key_exists('quantity_total', $validated) && $validated['quantity_total']) {
                $currentCount = $equipment->instances()->count();
                $newQuantityTotal = $validated['quantity_total'];
                if ($newQuantityTotal > $currentCount) {
                    $toCreate = $newQuantityTotal - $currentCount;
                    for ($i = 0; $i < $toCreate; $i++) {
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
            }

            // Handle image uploads - only allow one image per equipment
            if ($request->hasFile('images')) {
                Log::info('Processing image uploads for equipment ID: ' . $equipment->id);
                
                // Check if equipment already has images
                if ($equipment->images()->count() > 0) {
                    Log::info('Equipment already has images, skipping upload');
                    
                    // Handle AJAX requests
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Equipment already has images. Please delete existing images before uploading new ones.',
                            'errors' => ['images' => ['Equipment already has images. Please delete existing images before uploading new ones.']]
                        ], 422);
                    }
                    
                    return redirect()->route('equipment-management.show', $equipment)
                        ->with('warning', 'Equipment already has images. Please delete existing images before uploading new ones.');
                }
                
                // Handle both single file and multiple files
                $files = $request->file('images');
                if (!is_array($files)) {
                    $files = [$files];
                }
                
                $image = $files[0]; // Only take the first image
                if (!$image) {
                    Log::info('No valid image file found');
                    return redirect()->route('equipment-management.show', $equipment)
                        ->with('warning', 'No valid image file provided.');
                }
                
                if ($image->isValid()) {
                    try {
                        // Convert image to base64 data URL (like reservation system)
                        $base64 = base64_encode(file_get_contents($image));
                        $mimeType = $image->getMimeType();
                        $dataUrl = "data:{$mimeType};base64,{$base64}";
                        
                        // Create database record with base64 data
                        $equipment->images()->create([
                            'image_path' => $dataUrl,
                            'is_primary' => true,
                        ]);
                        
                        Log::info("Successfully uploaded image as base64 data URL");
                    } catch (\Exception $e) {
                        Log::error("Error uploading image: " . $e->getMessage());
                    }
                } else {
                    Log::error("Invalid image file: " . $image->getClientOriginalName() . " - Error: " . $image->getError());
                }
            }

            DB::commit();

            Log::info('Equipment updated successfully', ['equipment_id' => $equipment->id]);
            
            // Handle AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Equipment updated successfully',
                    'redirect' => route('equipment-management.show', $equipment)
                ]);
            }
            
            return redirect()->route('equipment-management.show', $equipment)
                ->with('success', 'Equipment updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Equipment update failed', [
                'equipment_id' => $equipment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Handle AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update equipment: ' . $e->getMessage(),
                    'errors' => ['error' => ['Failed to update equipment: ' . $e->getMessage()]]
                ], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to update equipment: ' . $e->getMessage()]);
        }
    }

    public function destroy(Equipment $equipment)
    {
        // Validate password if provided
        if (request()->has('password')) {
            $validated = request()->validate([
                'password' => 'required|string',
            ]);

            // Verify password
            if (!Hash::check($validated['password'], auth()->user()->password)) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Incorrect password. Please try again.'
                    ], 400);
                }
                return back()->withErrors(['password' => 'Incorrect password. Please try again.']);
            }
        }

        // 1) Block deletion if any active reservations exist for this equipment
        if ($equipment->reservationItems()->whereHas('reservation', function ($q) {
            $q->whereIn('status', ['pending', 'approved', 'picked_up']);
        })->exists()) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete equipment while there are active reservations (pending/approved/picked up). Complete or cancel them first.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Cannot delete equipment while there are active reservations (pending/approved/picked up). Complete or cancel them first.']);
        }

        // 2) Block deletion if it still has active instances (not retired/deleted)
        $hasActiveInstances = $equipment->instances()
            ->where('is_active', true)
            ->count();
        if ($hasActiveInstances > 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete equipment while it still has active instances. Retire or delete all instances first.'
                ], 400);
            }
            return back()->withErrors(['error' => 'Cannot delete equipment while it still has active instances. Retire or delete all instances first.']);
        }

        // Delete associated images
        foreach ($equipment->images as $image) {
            // Check if the image is a base64 data URL or file path
            if (str_starts_with($image->image_path, 'data:')) {
                // Base64 data URL - just delete the database record
                Log::info("Deleting base64 image record: {$image->id}");
            } else {
                // File-based image - delete from storage
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Log equipment deletion activity before deleting
        \App\Services\ActivityLogService::logEquipmentDeleted($equipment->display_name, $equipment->toArray(), request());

        $equipment->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Equipment deleted successfully',
                'redirect' => route('equipment-management.index')
            ]);
        }

        return redirect()->route('equipment-management.index')
            ->with('success', 'Equipment deleted successfully');
    }

    public function maintenance(Equipment $equipment)
    {
        $maintenanceRecords = $equipment->maintenanceRecords()->latest()->paginate(15);
        $viewPath = 'admin-manager.equipment-management.maintenance';
        return view($viewPath, compact('equipment', 'maintenanceRecords'));
    }

    public function addMaintenanceRecord(MaintenanceRecordStoreRequest $request, Equipment $equipment)
    {
        $validated = $request->validated();

        $maintenanceRecord = $equipment->maintenanceRecords()->create($validated);

        // Update equipment's next maintenance date if provided
        

        return redirect()->route('equipment-management.maintenance', $equipment)
            ->with('success', 'Maintenance record added successfully');
    }

    public function deleteImage($equipmentId, $imageId)
    {
        try {
            $equipment = Equipment::findOrFail($equipmentId);
            $image = $equipment->images()->findOrFail($imageId);

            // Check if the image is a base64 data URL or file path
            if (str_starts_with($image->image_path, 'data:')) {
                // Base64 data URL - just delete the database record
                Log::info("Deleting base64 image record: {$imageId}");
            } else {
                // File-based image - delete from storage
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                    Log::info("Deleted image file from storage: {$image->image_path}");
                } else {
                    Log::warning("Image file not found in storage: {$image->image_path}");
                }
            }

            $image->delete();

            // Check if this is an AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            }

            return back()->with('success', 'Image deleted successfully');
        } catch (\Exception $e) {
            Log::error("Failed to delete image: " . $e->getMessage());
            
            // Check if this is an AJAX request
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete image: ' . $e->getMessage()], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to delete image: ' . $e->getMessage()]);
        }
    }

    public function reports()
    {
        // Equipment by category
        $equipmentByCategory = Equipment::with('category')
            ->selectRaw('category_id, COUNT(*) as count')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        // Equipment by condition
        $equipmentByCondition = Equipment::selectRaw('condition, COUNT(*) as count')
            ->groupBy('condition')
            ->get();

        // Equipment by availability
        $equipmentByAvailability = [
            'available' => Equipment::with('instances')->get()->filter(function($equipment) {
                return $equipment->quantity_available > 0;
            })->count(),
            'unavailable' => Equipment::with('instances')->get()->filter(function($equipment) {
                return $equipment->quantity_available <= 0;
            })->count(),
            'needs_maintenance' => \App\Models\EquipmentInstance::where('condition', 'needs_repair')
                ->where('is_active', true)
                ->count(),
        ];

        // Most borrowed equipment
        $mostBorrowed = DB::table('reservation_items')
            ->join('equipment', 'reservation_items.equipment_id', '=', 'equipment.id')
            ->join('equipment_categories', 'equipment.category_id', '=', 'equipment_categories.id')
            ->select('equipment.brand', 'equipment.model', 'equipment_categories.name as category_name', 'equipment.category_id', DB::raw('SUM(reservation_items.quantity_requested) as total_borrowed'))
            ->groupBy('equipment.id', 'equipment.brand', 'equipment.model', 'equipment_categories.name', 'equipment.category_id')
            ->orderBy('total_borrowed', 'desc')
            ->limit(10)
            ->get();

        // Equipment value by category removed due to purchase price removal
        $equipmentValueByCategory = collect();

        $viewPath = 'admin-manager.equipment-management.reports';
        return view($viewPath, compact(
            'equipmentByCategory',
            'equipmentByCondition',
            'equipmentByAvailability',
            'mostBorrowed'
        ));
    }

    public function generatePDF(Request $request)
    {
        try {
                // Get filters from request
                $filters = $request->only(['category', 'report_type', 'equipment_type']);
                
                // Build query with filters
                $query = Equipment::with(['category', 'equipmentType', 'instances']);
                
                if ($request->filled('category')) {
                    $query->where('category_id', $request->category);
                }
                
                if ($request->filled('equipment_type')) {
                    $query->where('equipment_type_id', $request->equipment_type);
                }
                
                // Handle report_type filtering
                if ($request->filled('report_type') && $request->report_type !== 'all') {
                    switch ($request->report_type) {
                        case 'available':
                            $query->whereHas('instances', function($q) {
                                $q->where('is_active', true)
                                  ->whereNotIn('condition', ['damaged', 'needs_repair']);
                            });
                            break;
                        case 'unavailable':
                            $query->whereDoesntHave('instances', function($q) {
                                $q->where('is_active', true)
                                  ->whereNotIn('condition', ['damaged', 'needs_repair']);
                            });
                            break;
                        case 'damaged':
                            $query->whereHas('instances', function($q) {
                                $q->where('condition', 'damaged');
                            });
                            break;
                    }
                }
                
                $equipment = $query->latest()->get();
                
                // Generate PDF
                $pdf = \App\Services\PDFService::generateEquipmentReport($equipment, $filters);
                
                $filename = 'equipment_report_' . now()->format('Y-m-d_H-i-s') . '.pdf';
                
                return $pdf->stream($filename);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            \Log::error('PDF Generation Error Stack: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
        }
    }

    public function exportExcel(Request $request)
    {
        if (!class_exists(\Shuchkin\SimpleXLSXGen::class)) {
            $path = base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');
            if (file_exists($path)) { require_once $path; }
        }

        $query = Equipment::with(['category', 'equipmentType']);
        if ($request->filled('category')) { $query->where('category_id', $request->category); }
        $equipment = $query->orderBy('name')->get();

        $rows = [];
        $rows[] = ['Brand', 'Model', 'Category', 'Type', 'Available', 'Total'];
        foreach ($equipment as $eq) {
            $rows[] = [
                $eq->brand,
                $eq->model,
                optional($eq->category)->name,
                optional($eq->equipmentType)->name,
                $eq->quantity_available,
                $eq->instances()->count(),
            ];
        }
        $filename = 'equipment-export-' . date('Y-m-d-His') . '.xlsx';
        \Shuchkin\SimpleXLSXGen::fromArray($rows)->downloadAs($filename);
        return response()->noContent();
    }

    public function exportCSV(Request $request)
    {
        try {
            // Get filters from request
            $filters = $request->only(['category', 'report_type', 'equipment_type']);
            
            // Build query with filters (same logic as PDF)
            $query = Equipment::with(['category', 'equipmentType', 'instances']);
            
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }
            
            if ($request->filled('equipment_type')) {
                $query->where('equipment_type_id', $request->equipment_type);
            }
            
            // Handle report_type filtering
            if ($request->filled('report_type') && $request->report_type !== 'all') {
                switch ($request->report_type) {
                    case 'available':
                        $query->whereHas('instances', function($q) {
                            $q->where('is_active', true)
                              ->whereNotIn('condition', ['damaged', 'needs_repair']);
                        });
                        break;
                    case 'unavailable':
                        $query->whereDoesntHave('instances', function($q) {
                            $q->where('is_active', true)
                              ->whereNotIn('condition', ['damaged', 'needs_repair']);
                        });
                        break;
                    case 'damaged':
                        $query->whereHas('instances', function($q) {
                            $q->where('condition', 'damaged');
                        });
                        break;
                }
            }
            
            $equipment = $query->latest()->get();

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="equipment_report_' . now()->format('Y-m-d_H-i-s') . '.csv"',
            ];

            $callback = function() use ($equipment, $filters) {
                $file = fopen('php://output', 'w');

                // Add CSV headers
                fputcsv($file, ['Brand', 'Model', 'Category', 'Equipment Type', 'Status', 'Total Quantity', 'Available Quantity', 'Location', 'Last Updated']);

                // Add filter information as metadata
                if (!empty($filters)) {
                    fputcsv($file, []); // Empty row
                    fputcsv($file, ['Applied Filters:']);
                    
                    if (!empty($filters['category'])) {
                        $category = \App\Models\EquipmentCategory::find($filters['category']);
                        $categoryName = $category ? $category->name : 'Unknown';
                        fputcsv($file, ['Category', $categoryName]);
                    }
                    
                    if (!empty($filters['report_type'])) {
                        fputcsv($file, ['Report Type', ucfirst($filters['report_type'])]);
                    }
                    
                    if (!empty($filters['equipment_type'])) {
                        $equipmentType = \App\Models\EquipmentType::find($filters['equipment_type']);
                        $equipmentTypeName = $equipmentType ? $equipmentType->name : 'Unknown';
                        fputcsv($file, ['Equipment Type', $equipmentTypeName]);
                    }
                    
                    fputcsv($file, []); // Empty row
                    fputcsv($file, ['Equipment Data:']);
                    fputcsv($file, []); // Empty row
                }

                // Add equipment data
                foreach ($equipment as $item) {
                    fputcsv($file, [
                        $item->brand ?? 'N/A',
                        $item->model ?? 'N/A',
                        $item->category ? $item->category->name : 'N/A',
                        $item->equipmentType ? $item->equipmentType->name : 'N/A',
                        $item->quantity_available > 0 ? 'Available' : 'Unavailable',
                        $item->quantity_total,
                        $item->quantity_available,
                        $item->location ?? 'N/A',
                        $item->updated_at->format('M d, Y')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            \Log::error('CSV Export Error: ' . $e->getMessage());
            \Log::error('CSV Export Error Stack: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to generate CSV: ' . $e->getMessage()]);
        }
    }

    public function wishlisted(Request $request)
    {
        $query = Equipment::with(['category', 'equipmentType', 'images'])
            ->leftJoin('wishlists', 'equipment.id', '=', 'wishlists.equipment_id')
            ->where(function($q) {
                $q->where('wishlists.wishlist_count', '>', 0)
                  ->orWhereNotNull('wishlists.equipment_id');
            })
            ->select('equipment.*', 'wishlists.wishlist_count');

        // Apply common equipment filters using ManagementTrait
        $query = $this->applyEquipmentFilters($query, $request);

        // Apply common sorting
        $query = $this->applySorting($query, $request, 'wishlist_count');

        // Get all equipment data for charts (without pagination) - get the same data as the table
        $allEquipment = $query->get();
        
        // Debug: Log the data to see what we're getting
        \Log::info('Wishlist Equipment Data:', $allEquipment->toArray());
        
        // Apply common pagination
        $equipment = $this->applyPagination($query, $request);
        
        // Get common filter data
        $filterData = $this->getCommonFilterData();
        $categories = $filterData['categories'];
        $equipmentTypes = $filterData['equipmentTypes'];

        $viewPath = 'admin-manager.equipment-management.wishlisted';
        
        return view($viewPath, compact('equipment', 'allEquipment', 'categories', 'equipmentTypes'));
    }

    public function wishlistedPDF(Request $request)
    {
        try {
            $query = Equipment::with(['category', 'equipmentType', 'images'])
                ->leftJoin('wishlists', 'equipment.id', '=', 'wishlists.equipment_id')
                ->where(function($q) {
                    $q->where('wishlists.wishlist_count', '>', 0)
                      ->orWhereNotNull('wishlists.equipment_id');
                })
                ->select('equipment.*', 'wishlists.wishlist_count');

            // Apply filters
            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('equipment.brand', 'like', '%' . $request->search . '%')
                      ->orWhere('equipment.model', 'like', '%' . $request->search . '%');
                });
            }

            if ($request->filled('category')) {
                $query->where('equipment.category_id', $request->category);
            }

            // Date filtering
            if ($request->filled('date_from')) {
                $query->whereDate('equipment.created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('equipment.created_at', '<=', $request->date_to);
            }

            // Sorting by wishlist count
            $sort = $request->get('sort', 'wishlist_count');
            $direction = $request->get('direction', 'desc');

            if ($sort === 'wishlist_count') {
                $query->orderBy('wishlists.wishlist_count', $direction);
            } elseif ($sort === 'name') {
                $query->orderBy('equipment.brand', $direction);
            } elseif ($sort === 'category') {
                $query->join('equipment_categories', 'equipment.category_id', '=', 'equipment_categories.id')
                      ->orderBy('equipment_categories.name', $direction);
            } else {
                $query->orderBy('wishlists.wishlist_count', 'desc');
            }

            $equipment = $query->get();
            
            // Generate PDF
            $pdf = \App\Services\PDFService::generateWishlistedReport($equipment, $request->all());
            
            $filename = 'wishlisted_equipment_report_' . now()->format('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->stream($filename);
        } catch (\Exception $e) {
            \Log::error('Wishlisted PDF Generation Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to generate PDF: ' . $e->getMessage()]);
        }
    }

    public function wishlistedExcel(Request $request)
    {
        if (!class_exists(\Shuchkin\SimpleXLSXGen::class)) {
            $path = base_path('vendor/shuchkin/simplexlsxgen/src/SimpleXLSXGen.php');
            if (file_exists($path)) { require_once $path; }
        }

        $query = Equipment::with(['category', 'equipmentType'])
            ->leftJoin('wishlists', 'equipment.id', '=', 'wishlists.equipment_id')
            ->where(function($q) {
                $q->where('wishlists.wishlist_count', '>', 0)
                  ->orWhereNotNull('wishlists.equipment_id');
            })
            ->select('equipment.*', 'wishlists.wishlist_count');

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('equipment.brand', 'like', '%' . $request->search . '%')
                  ->orWhere('equipment.model', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category')) {
            $query->where('equipment.category_id', $request->category);
        }

        $equipment = $query->orderBy('wishlists.wishlist_count', 'desc')->get();

        $rows = [];
        $rows[] = ['Brand', 'Model', 'Category', 'Type', 'Wishlist Count', 'Available', 'Total'];
        foreach ($equipment as $eq) {
            $rows[] = [
                $eq->brand, $eq->model, optional($eq->category)->name, optional($eq->equipmentType)->name,
                $eq->wishlist_count ?? 0, $eq->quantity_available, $eq->instances()->count(),
            ];
        }
        $filename = 'wishlisted-equipment-export-' . date('Y-m-d-His') . '.xlsx';
        \Shuchkin\SimpleXLSXGen::fromArray($rows)->downloadAs($filename);
    }

    /**
     * Get equipment alerts and warnings
     */
    private function getEquipmentAlerts()
    {
        $alerts = [];

        // Low stock alerts (equipment with 1 or 0 available instances)
        $lowStockEquipment = Equipment::with(['category', 'equipmentType', 'images'])
            ->whereHas('instances', function($query) {
                $query->where('is_active', true)
                      ->where('is_available', true)
                      ->whereNotIn('condition', ['lost', 'damaged', 'needs_repair', 'under_maintenance']);
            }, '<=', 1)
            ->get()
            ->filter(function($equipment) {
                return $equipment->quantity_available <= 1;
            });

        if ($lowStockEquipment->count() > 0) {
            $alerts[] = [
                'type' => 'low_stock',
                'title' => 'Low Stock Alert',
                'message' => 'Some equipment has very low availability. Consider restocking or maintenance.',
                'equipment' => $lowStockEquipment,
                'count' => $lowStockEquipment->count()
            ];
        }

        // High demand alerts (equipment with many wishlist entries but low availability)
        $highDemandEquipment = Equipment::with(['category', 'equipmentType', 'images', 'wishlists'])
            ->whereHas('wishlists')
            ->get()
            ->filter(function($equipment) {
                $wishlistCount = $equipment->wishlists()->count();
                return $wishlistCount >= 3 && $equipment->quantity_available <= 2;
            });

        if ($highDemandEquipment->count() > 0) {
            $alerts[] = [
                'type' => 'high_demand',
                'title' => 'High Demand Alert',
                'message' => 'Some equipment has high demand but limited availability. Consider acquiring more units.',
                'equipment' => $highDemandEquipment,
                'count' => $highDemandEquipment->count()
            ];
        }

        // Unavailable equipment alerts (equipment with 0 available instances)
        $unavailableEquipment = Equipment::with(['category', 'equipmentType', 'images'])
            ->get()
            ->filter(function($equipment) {
                return $equipment->quantity_available <= 0;
            });

        if ($unavailableEquipment->count() > 0) {
            $alerts[] = [
                'type' => 'unavailable',
                'title' => 'Unavailable Equipment',
                'message' => 'Some equipment is completely unavailable. Check maintenance status or restock.',
                'equipment' => $unavailableEquipment,
                'count' => $unavailableEquipment->count()
            ];
        }

        return $alerts;
    }
}
