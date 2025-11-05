<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Discarded Equipment')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Maintenance Management', 'url' => route('maintenance-management.index')],
                ['label' => 'Discarded Equipment']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Maintenance Management', 'url' => route('maintenance-management.index')],
                ['label' => 'Discarded Equipment']
            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $attributes = $__attributesOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__attributesOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $component = $__componentOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__componentOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Discarded Equipment Overview</h3>
                            <p class="text-gray-600">View all equipment instances that have been permanently removed from the system</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button onclick="window.openReportModal && window.openReportModal()" 
                                   class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 flex items-center space-x-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="font-semibold">Generate Report</span>
                            </button>
                            <a href="<?php echo e(route('maintenance-management.index')); ?>" 
                               class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg transition-all duration-200 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                <span class="font-semibold">Back to Maintenance</span>
                            </a>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="text-2xl font-bold text-gray-900"><?php echo e($totalDiscarded); ?></div>
                            <div class="text-sm text-gray-600">Total Discarded</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <div class="text-2xl font-bold text-red-600"><?php echo e($discardedThisMonth); ?></div>
                            <div class="text-sm text-red-600">Discarded This Month</div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                            <div class="text-2xl font-bold text-orange-600"><?php echo e($discardedThisYear); ?></div>
                            <div class="text-sm text-orange-600">Discarded This Year</div>
                        </div>
                    </div>

                    <!-- Search and Filter Toggle Section -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-4">
                        <div class="flex justify-between items-center">
                            <h4 class="text-lg font-semibold text-gray-900">Search & Filter</h4>
                            <button type="button" onclick="toggleFilters()" 
                                    style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out; display: flex; align-items: center; gap: 8px;"
                                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 2px 6px -2px rgba(0, 0, 0, 0.05)'"
                                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                                <span id="filterToggleText">Show</span>
                                <svg id="filterToggleIcon" style="width: 20px; height: 20px; transition: transform 0.2s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Search and Filters Content -->
                    <div id="filterSection" class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6" style="display: none;">
                        <div class="p-6">
                            <form method="GET" action="<?php echo e(route('maintenance-management.discarded')); ?>" id="filterForm" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Equipment Name</label>
                                        <input type="text" name="equipment" value="<?php echo e(request('equipment')); ?>" 
                                               placeholder="Search equipment..."
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Category</label>
                                        <select id="filter_category" name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                            <option value="">All Categories</option>
                                            <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Equipment Type</label>
                                        <select id="filter_equipment_type" name="equipment_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                            <option value="">All Types</option>
                                        </select>
                                        <p id="filter_equipment_type_help" class="mt-1 text-xs text-gray-500"></p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Reason</label>
                                        <select name="reason" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                            <option value="">All Reasons</option>
                                            <option value="beyond_repair" <?php echo e(request('reason') === 'beyond_repair' ? 'selected' : ''); ?>>Beyond Repair</option>
                                            <option value="end_of_life" <?php echo e(request('reason') === 'end_of_life' ? 'selected' : ''); ?>>End of Life</option>
                                            <option value="retired" <?php echo e(request('reason') === 'retired' ? 'selected' : ''); ?>>Retired</option>
                                        </select>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">From Date</label>
                                        <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">To Date</label>
                                        <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                    </div>
                                    
                                    <div class="md:col-span-2 lg:col-span-1 space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Actions</label>
                                        <div class="flex space-x-2">
                                            <button type="submit" 
                                                    class="px-4 py-3 rounded-lg text-white flex-1 transition-transform duration-150"
                                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.12)';"
                                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                                Search
                                            </button>
                                            <button type="button"
                                                    id="discardedClearBtnAdmin"
                                                    class="px-4 py-3 rounded-lg text-white flex-1 text-center transition-transform duration-150"
                                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.12)';"
                                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                                                    style="background: linear-gradient(135deg, #64748b 0%, #334155 100%);">
                                                Clear
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Discarded Items Table -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Discarded Equipment List</h4>
                            
                            <?php if($discardedItems->count() > 0): ?>
                                <?php if (isset($component)) { $__componentOriginala8c8be3548067f73036f4ed77d30e639 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8c8be3548067f73036f4ed77d30e639 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-toolbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8c8be3548067f73036f4ed77d30e639)): ?>
<?php $attributes = $__attributesOriginala8c8be3548067f73036f4ed77d30e639; ?>
<?php unset($__attributesOriginala8c8be3548067f73036f4ed77d30e639); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8c8be3548067f73036f4ed77d30e639)): ?>
<?php $component = $__componentOriginala8c8be3548067f73036f4ed77d30e639; ?>
<?php unset($__componentOriginala8c8be3548067f73036f4ed77d30e639); ?>
<?php endif; ?>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-red-600">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Instance Code</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Reason</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Discarded By</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Notes</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php $__currentLoopData = $discardedItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">
                                                            <?php echo e($item->equipmentInstance->equipment->name); ?>

                                                        </div>
                                                        <div class="text-sm font-medium text-gray-700">
                                                            <?php echo e($item->equipmentInstance->equipment->brand ?: 'No brand'); ?>

                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                            <?php echo e($item->equipmentInstance->instance_code); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            <?php echo e($item->equipmentInstance->equipment->category->name); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                            <?php echo e($item->reason === 'beyond_repair' ? 'bg-red-100 text-red-800' : 
                                                               ($item->reason === 'retired' ? 'bg-blue-100 text-blue-800' : 
                                                               ($item->reason === 'lost' ? 'bg-yellow-100 text-yellow-800' : 
                                                               ($item->reason === 'stolen' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')))); ?>">
                                                            <?php echo e(ucwords(str_replace('_', ' ', $item->reason))); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                        <?php echo e($item->actedBy ? $item->actedBy->name : 'System'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                        <?php echo e($item->acted_at ? $item->acted_at->format('M d, Y H:i') : 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                        <div class="max-w-xs truncate" title="<?php echo e($item->notes); ?>">
                                                            <?php echo e($item->notes ?: 'No notes'); ?>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <div class="mt-6">
                                    <?php echo e($discardedItems->links()); ?>

                                </div>
                            <?php else: ?>
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No discarded equipment found</h3>
                                    <p class="mt-1 text-sm text-gray-500">No equipment has been discarded yet, or no items match your search criteria.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Report Modal Functions
        window.openReportModal = function() {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Generate Discarded Equipment Report</h2>
                    </div>
                    <form id="reportForm" action="<?php echo e(route('maintenance-management.generate-discarded-report')); ?>" method="GET" class="space-y-4">
                        <!-- Report Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                            <select name="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="all">All Discarded Items</option>
                                <option value="beyond_repair">Beyond Repair Only</option>
                                <option value="lost">Lost Only</option>
                                <option value="end_of_life">End of Life Only</option>
                                <option value="retired">Retired Only</option>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Category</label>
                            <select id="modal_category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Equipment Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Type</label>
                            <select id="modal_equipment_type" name="equipment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" disabled>
                                <option value="">All Types</option>
                            </select>
                            <p id="modal_equipment_type_help" class="mt-1 text-xs text-gray-500">Select an Equipment Category first to enable Equipment Type.</p>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                <input type="date" name="start_date" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                <input type="date" name="end_date" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>

                        

                        <!-- Format Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                            </select>
                        </div>
                    </form>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105" onclick="(function(){ const f=document.getElementById('reportForm'); const data=new FormData(f); const params=new URLSearchParams(data).toString(); const fmt=data.get('format'); const base = fmt==='excel' ? '<?php echo e(route('maintenance-management.discarded.export-excel')); ?>' : '<?php echo e(route('maintenance-management.generate-discarded-report')); ?>'; window.open(base + (params ? ('?' + params) : ''), '_blank'); })()">
                            Generate Report
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '600px',
                customClass: {
                    popup: 'swal-custom-popup'
                },
                didOpen: () => {
                    const cat = document.getElementById('modal_category');
                    const type = document.getElementById('modal_equipment_type');
                    const help = document.getElementById('modal_equipment_type_help');
                    const sync = () => {
                        const id = cat.value;
                        const has = Boolean(id);
                        type.disabled = !has;
                        type.classList.toggle('opacity-50', !has);
                        type.classList.toggle('cursor-not-allowed', !has);
                        help.textContent = has ? '' : 'Select an Equipment Category first to enable Equipment Type.';
                        if (has) {
                            fetch(`/equipment-types/by-category/${id}`).then(r=>r.json()).then(d=>{
                                type.innerHTML = '<option value="">All Types</option>';
                                d.forEach(t=>{ const o=document.createElement('option'); o.value=t.id; o.textContent=t.name; type.appendChild(o); });
                            });
                        } else {
                            type.innerHTML = '<option value=\"\">All Types</option>';
                        }
                    };
                    cat.addEventListener('change', sync);
                    sync();
                }
            });
        }

        // Function to toggle filters visibility
        function toggleFilters() {
            const filterSection = document.getElementById('filterSection');
            const toggleText = document.getElementById('filterToggleText');
            const toggleIcon = document.getElementById('filterToggleIcon');
            
            if (filterSection.style.display === 'none') {
                filterSection.style.display = 'block';
                toggleText.textContent = 'Hide';
                toggleIcon.style.transform = 'rotate(180deg)';
            } else {
                filterSection.style.display = 'none';
                toggleText.textContent = 'Show';
                toggleIcon.style.transform = 'rotate(0deg)';
            }
        }

        // AJAX form submission for discarded equipment (admin)
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            const clearBtn = document.getElementById('discardedClearBtnAdmin');
            const toggleKey = 'discardedFilterToggleAdmin';
            const dateFromInput = form.querySelector('input[name="date_from"]');
            const dateToInput = form.querySelector('input[name="date_to"]');

            // Date validation
            function validateDates() {
                const dateFrom = dateFromInput.value;
                const dateTo = dateToInput.value;
                
                // Check if Date To is filled without Date From
                if (dateTo && !dateFrom) {
                    Swal.fire({
                        buttonsStyling: false,
                        html: `
                            <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#f59e0b;">
                                <h2 class="text-xl font-bold text-center">Invalid Date Selection</h2>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-700">Date To cannot be used without Date From. Please select Date From first.</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 text-white rounded-lg" style="background:#f59e0b" onclick="Swal.close()">OK</button>
                            </div>
                        `,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-custom-popup' }
                    });
                    return false;
                }
                
                if (dateFrom && dateTo && dateFrom > dateTo) {
                    Swal.fire({
                        buttonsStyling: false,
                        html: `
                            <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#f59e0b;">
                                <h2 class="text-xl font-bold text-center">Invalid Date Range</h2>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-700">Date From cannot be after Date To. Please adjust your dates.</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 text-white rounded-lg" style="background:#f59e0b" onclick="Swal.close()">OK</button>
                            </div>
                        `,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-custom-popup' }
                    });
                    return false;
                }
                return true;
            }

            if (form) {
                // Add validation to form submission
                form.addEventListener('submit', function(e) {
                    if (!validateDates()) {
                        e.preventDefault();
                        return false;
                    }
                });

                // Clear button functionality
                if (clearBtn) {
                    clearBtn.addEventListener('click', function(){
                        // Reset all form fields
                        form.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
                        form.querySelectorAll('input[type="date"]').forEach(input => input.value = '');
                        form.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
                        
                        // Ensure the panel stays open after refresh
                        try { localStorage.setItem(toggleKey, '1'); } catch(e) {}
                        
                        // Submit form to refresh table
                        form.submit();
                    });
                }

                // Intercept form submission for AJAX
                form.addEventListener('submit', function(e){
                    e.preventDefault();
                    
                    if (!validateDates()) {
                        return false;
                    }
                    
                    const url = new URL(form.action, window.location.origin);
                    const data = new FormData(form);
                    
                    // Clean params first
                    url.search = '';
                    for (const [k,v] of data.entries()) { 
                        if (v) url.searchParams.set(k,v); 
                    }
                    
                    // Fetch and replace table content
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newTable = doc.querySelector('.overflow-x-auto');
                            const currentTable = document.querySelector('.overflow-x-auto');
                            
                            if (newTable && currentTable) {
                                currentTable.innerHTML = newTable.innerHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Fallback to regular form submission
                            form.submit();
                        });
                });
            }
        });

        // Initialize Category → Equipment Type dependency for Search/Filter (admin)
        (function(){
            const categorySelect = document.getElementById('filter_category');
            const typeSelect = document.getElementById('filter_equipment_type');
            const help = document.getElementById('filter_equipment_type_help');
            if(!categorySelect || !typeSelect || !help) return;

            const presetType = '<?php echo e(request('equipment_type')); ?>';

            const sync = () => {
                const id = categorySelect.value;
                const has = Boolean(id);
                typeSelect.disabled = !has;
                typeSelect.classList.toggle('opacity-50', !has);
                typeSelect.classList.toggle('cursor-not-allowed', !has);
                help.textContent = has ? '' : 'Select an Equipment Category first to enable Equipment Type.';
                if (has) {
                    fetch(`/equipment-types/by-category/${id}`).then(r=>r.json()).then(list=>{
                        const current = typeSelect.value || presetType;
                        typeSelect.innerHTML = '<option value="">All Types</option>';
                        list.forEach(t=>{
                            const o = document.createElement('option');
                            o.value = t.id;
                            o.textContent = t.name;
                            if (current && String(current) === String(t.id)) o.selected = true;
                            typeSelect.appendChild(o);
                        });
                    });
                } else {
                    typeSelect.innerHTML = '<option value="">All Types</option>';
                }
            };

            categorySelect.addEventListener('change', sync);
            // Run once on page load
            sync();
        })();
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\UB-SEMS\resources\views\admin-manager\maintenance-management\discarded.blade.php ENDPATH**/ ?>