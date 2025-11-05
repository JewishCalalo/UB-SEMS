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
            <?php echo e(__('Lost & Damaged Management')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    
    <?php $__env->startPush('head'); ?>
        <style>
            /* Override global SweetAlert2 confirm button color for orange theme */
            .swal2-popup .swal2-confirm.swal2-styled,
            .swal2-popup .swal2-confirm,
            .swal2-confirm {
                background: #f97316 !important;
                background-color: #f97316 !important;
                border-color: #f97316 !important;
                border: none !important;
            }
            .swal2-popup .swal2-confirm.swal2-styled:hover,
            .swal2-popup .swal2-confirm:hover,
            .swal2-confirm:hover {
                background: #ea580c !important;
                background-color: #ea580c !important;
                border-color: #ea580c !important;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                                    <h2 class="text-xl font-bold">Success</h2>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-700"><?php echo e(session('success')); ?></p>
                                </div>
                            `,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#10b981',
                            customClass: { popup: 'swal-custom-popup' }
                        });
                    });
                </script>
            <?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Lost and Missing Equipments']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Lost and Missing Equipments']
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

            <!-- Header with Create Button and Quick Actions -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Track Lost and Missing Equipments</h3>
                        <p class="text-gray-600">Track and manage equipment that has been lost or not returned during the return process</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="openGenerateReportModal()" 
                                class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Generate Report</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Items</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo e($totalItems); ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-yellow-600"><?php echo e($pendingItems); ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Replaced</p>
                            <p class="text-2xl font-bold text-green-600"><?php echo e($replacedItems); ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Not Replaced</p>
                            <p class="text-2xl font-bold text-red-600"><?php echo e($notReplacedItems); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incident Type Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white border border-red-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Lost</p>
                            <p class="text-2xl font-bold text-red-600"><?php echo e($lostCount); ?></p>
                        </div>
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-orange-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Lost</p>
                            <p class="text-2xl font-bold text-orange-600"><?php echo e($lostCount); ?></p>
                        </div>
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-yellow-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Not Returned</p>
                            <p class="text-2xl font-bold text-yellow-600"><?php echo e($notReturnedCount); ?></p>
                        </div>
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Toggle Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-4">
                <div class="flex justify-between items-center">
                    <h4 class="text-lg font-semibold text-gray-900">Search & Filter</h4>
                    <div class="flex items-center gap-3">
                        <a href="<?php echo e(route('blacklist.index')); ?>"
                           class="inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white shadow-sm"
                           style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out; display: inline-flex; align-items: center; gap: 8px;"
                           onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                           onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'"><span>View Blacklist Emails</span></a>
                        <button type="button" onclick="toggleSearchFilter()" 
                                style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out; display: flex; align-items: center; gap: 8px;"
                                onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                            <span id="toggleText">Show</span>
                            <svg id="toggleIcon" style="width: 20px; height: 20px; transition: transform 0.2s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search and Filters Content -->
            <div id="searchFilterContent" class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6" style="display: none;">
                <div class="p-6">
                    <form method="GET" action="<?php echo e(route('missing-equipment.index')); ?>" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Search</label>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                       placeholder="Borrower name, email, or equipment..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Incident Type</label>
                                <select name="incident_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                    <option value="">All Types</option>
                                    <option value="lost" <?php echo e(request('incident_type') === 'lost' ? 'selected' : ''); ?>>Lost</option>
                                    <option value="damaged" <?php echo e(request('incident_type') === 'damaged' ? 'selected' : ''); ?>>Damaged</option>
                                    <option value="not_returned" <?php echo e(request('incident_type') === 'not_returned' ? 'selected' : ''); ?>>Not Returned</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Replacement Status</label>
                                <select name="replacement_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                    <option value="">All Status</option>
                                    <option value="pending" <?php echo e(request('replacement_status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="replaced" <?php echo e(request('replacement_status') === 'replaced' ? 'selected' : ''); ?>>Replaced</option>
                                    <option value="not_replaced" <?php echo e(request('replacement_status') === 'not_replaced' ? 'selected' : ''); ?>>Not Replaced</option>
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Category</label>
                                <select id="filter_category" name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                    <option value="">All Categories</option>
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <label class="block text-sm font-semibold text-gray-700">Date From</label>
                                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Date To</label>
                                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Actions</label>
                                <div class="flex space-x-2">
                                    <button type="submit" 
                                            class="px-4 py-3 rounded-lg text-white flex-1 transition-transform duration-150"
                                            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.12)';"
                                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                        Search
                                    </button>
                                    <button type="button" id="missingClearBtnAdmin"
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

            <!-- Action Legend -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-medium text-gray-700">Action Legend</h4>
                    <button type="button" onclick="toggleActionLegend()" 
                            class="text-sm text-gray-600 hover:text-gray-800 flex items-center space-x-1 transition-colors">
                        <span id="actionLegendToggleText">Hide</span>
                        <svg id="actionLegendToggleIcon" class="w-4 h-4 transform rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                <div id="actionLegendContent" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-1 w-8 h-8 rounded-lg flex items-center justify-center shadow-sm" style="background: linear-gradient(to right, #3b82f6, #2563eb);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">View Details</span>
                        <p class="text-xs text-gray-500">Open missing-equipment record details.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-1 w-8 h-8 rounded-lg flex items-center justify-center shadow-sm" style="background: linear-gradient(to right, #8b5cf6, #7c3aed);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Edit Record</span>
                        <p class="text-xs text-gray-500">Modify details or correct information.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-1 w-8 h-8 rounded-lg flex items-center justify-center shadow-sm" style="background: linear-gradient(to right, #10b981, #059669);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Mark as Replaced</span>
                        <p class="text-xs text-gray-500">Mark item as replaced and close incident.</p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-1 w-8 h-8 rounded-lg flex items-center justify-center shadow-sm" style="background: linear-gradient(to right, #ef4444, #dc2626);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700">Mark as Not Replaced</span>
                        <p class="text-xs text-gray-500">Flag item as not replaced (still pending).</p>
                    </div>
                </div>
            </div>

            <!-- Stolen/Lost Equipment List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="missingTableWrapper" class="overflow-x-auto">
                        <?php if($stolenLostItems->count() > 0): ?>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Brand/Model</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Borrower</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Incident</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Replacement</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $stolenLostItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                <div class="flex items-center">
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900">
                                                            <?php echo e($item->equipmentInstance->equipment->brand); ?> / <?php echo e($item->equipmentInstance->equipment->model); ?>

                                                        </div>
                                                        <div class="text-sm font-medium text-gray-700">
                                                            <?php echo e($item->equipmentInstance->equipment->category->name); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div class="text-sm font-bold text-gray-900"><?php echo e($item->borrower_name); ?></div>
                                                    <div class="text-sm font-medium text-gray-700"><?php echo e($item->borrower_email); ?></div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?php echo e($item->incident_type_color); ?>-100 text-<?php echo e($item->incident_type_color); ?>-800">
                                                    <?php echo e($item->incident_type_text); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?php echo e($item->replacement_status_color); ?>-100 text-<?php echo e($item->replacement_status_color); ?>-800">
                                                    <?php echo e($item->replacement_status_text); ?>

                                                </span>
                                            </td>
                                            <td class="px-8 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="<?php echo e(route('missing-equipment.show', $item)); ?>" 
                                                       style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                       onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                       onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                       title="View Details">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="<?php echo e(route('missing-equipment.edit', $item)); ?>" 
                                                       style="background: linear-gradient(to right, #8b5cf6, #7c3aed); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                       onmouseover="this.style.background='linear-gradient(to right, #7c3aed, #6d28d9)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                       onmouseout="this.style.background='linear-gradient(to right, #8b5cf6, #7c3aed)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                       title="Edit Record">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <?php if($item->replacement_status === 'pending'): ?>
                                                        <button type="button" onclick="confirmMarkReplaced(<?php echo e($item->id); ?>)" 
                                                                style="background: linear-gradient(to right, #10b981, #059669); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Mark as Replaced">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                        <button type="button" onclick="confirmMarkNotReplaced(<?php echo e($item->id); ?>)" 
                                                                style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Mark as Not Replaced">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            <?php echo e($stolenLostItems->links()); ?>

                        </div>
                        <?php else: ?>
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No lost or missing equipment records</h3>
                                <p class="mt-1 text-sm text-gray-500">Lost & Missing equipment records are automatically created when items are marked as lost during the return process.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openBlacklistModal(){
            // Simple fetch of blacklist and display via SweetAlert table
            fetch('/api/blacklist')
                .then(r=>r.json())
                .then(data=>{
                    const rows = (data.items||[]).map(i=>`<tr><td class=\"px-4 py-2\">${i.email}</td><td class=\"px-4 py-2\">${i.reason||''}</td><td class=\"px-4 py-2\"><button onclick=\"releaseEmail('${i.email}')\" class=\"px-2 py-1 bg-green-600 text-white rounded\">Release</button></td></tr>`).join('');
                    SweetAlertUtils.custom('Blacklisted Emails', `
                        <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50"><tr><th class="px-4 py-2">Email</th><th class="px-4 py-2">Reason</th><th class="px-4 py-2">Action</th></tr></thead>
                            <tbody>${rows||'<tr><td class="px-4 py-3" colspan="3">No blacklisted emails.</td></tr>'}</tbody>
                        </table>
                        </div>
                    `, {confirmButtonText:'Close'});
                });
        }

        function releaseEmail(email){
            fetch('/api/blacklist/release', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'}, body: JSON.stringify({email})})
                .then(()=>openBlacklistModal());
        }
    </script>
    <script>
        function toggleSearchFilter() {
            const content = document.getElementById('searchFilterContent');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (content.style.display === 'none') {
                content.style.display = 'block';
                toggleText.textContent = 'Hide';
                toggleIcon.style.transform = 'rotate(180deg)';
            } else {
                content.style.display = 'none';
                toggleText.textContent = 'Show';
                toggleIcon.style.transform = 'rotate(0deg)';
            }
        }

        function toggleActionLegend() {
            const content = document.getElementById('actionLegendContent');
            const toggleText = document.getElementById('actionLegendToggleText');
            const toggleIcon = document.getElementById('actionLegendToggleIcon');
            
            if (content.style.display === 'none') {
                // Show the content
                content.style.display = 'grid';
                toggleText.textContent = 'Hide';
                toggleIcon.style.transform = 'rotate(0deg)';
            } else {
                // Hide the content
                content.style.display = 'none';
                toggleText.textContent = 'Show';
                toggleIcon.style.transform = 'rotate(180deg)';
            }
        }

        function openGenerateReportModal() {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Generate Lost and Missing Equipments Report</h2>
                    </div>
                    <form id="report-form" method="GET" action="<?php echo e(route('missing-equipment.generate-pdf')); ?>" class="space-y-4">
                        <!-- Incident Type Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Incident Type</label>
                            <select name="incident_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Incident Types</option>
                                <option value="lost">Lost</option>
                                <option value="not_returned">Not Returned</option>
                            </select>
                        </div>
                        
                        <!-- Replacement Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Replacement Status</label>
                            <select name="replacement_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="replaced">Replaced</option>
                                <option value="not_replaced">Not Replaced</option>
                            </select>
                        </div>
                        
                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="modal_category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- Equipment Type Filter (depends on Category) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Type</label>
                            <select id="modal_equipment_type" name="equipment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled>
                                <option value="">All Types</option>
                            </select>
                            <p id="modal_equipment_type_help" class="mt-1 text-xs text-gray-500">Select an Equipment Category first to enable Equipment Type.</p>
                        </div>

                        <!-- Date Range -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                <input type="date" name="date_from" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                <input type="date" name="date_to" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <!-- Export Format Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                            </select>
                        </div>
                    </form>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all transform hover:scale-105" onclick="submitAdminMissingReport()">
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
            // Avoid inline IIFE to prevent Alpine parse errors
            window.submitAdminMissingReport = function(){
                const f = document.getElementById('report-form');
                if (!f) return;
                const params = new URLSearchParams(new FormData(f)).toString();
                const fmt = new FormData(f).get('format');
                const base = fmt === 'excel' ? '<?php echo e(route('missing-equipment.export-excel')); ?>' : '<?php echo e(route('missing-equipment.generate-pdf')); ?>';
                window.open(base + (params ? ('?' + params) : ''), '_blank');
            };
        }

        function confirmMarkReplaced(itemId) {
            Swal.fire({
                html: `
                    <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#10b981;">
                        <h2 class="text-xl font-bold text-center">Mark as Replaced?</h2>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-700 mb-4">Are you sure you want to mark this item as replaced?</p>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Yes, Mark as Replaced',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                customClass: {
                    popup: 'swal-custom-popup'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we mark this item as replaced.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create and submit the form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `<?php echo e(route('missing-equipment.mark-replaced', ':id')); ?>`.replace(':id', itemId);
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '<?php echo e(csrf_token()); ?>';
                    
                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function confirmMarkNotReplaced(itemId) {
            Swal.fire({
                html: `
                    <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#f97316;">
                        <h2 class="text-xl font-bold text-center">Mark as Not Replaced?</h2>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-700 mb-4">Are you sure you want to mark this item as not replaced?</p>
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-4">
                            <p class="text-orange-800 text-sm">
                                <strong>Note:</strong> Marking this item as not replaced will result in the user's email being blacklisted from future equipment reservations.
                            </p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Yes, Mark as Not Replaced',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                customClass: {
                    popup: 'swal-custom-popup'
                },
                didOpen: () => {
                    // Force apply orange color to confirm button
                    const confirmBtn = document.querySelector('.swal2-confirm');
                    if (confirmBtn) {
                        confirmBtn.style.backgroundColor = '#f97316';
                        confirmBtn.style.borderColor = '#f97316';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we mark this item as not replaced.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Create and submit the form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `<?php echo e(route('missing-equipment.mark-not-replaced', ':id')); ?>`.replace(':id', itemId);
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '<?php echo e(csrf_token()); ?>';
                    
                    form.appendChild(csrfToken);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        // AJAX search and clear functionality
        (function(){
            const form = document.querySelector('#searchFilterContent form');
            const clearBtn = document.getElementById('missingClearBtnAdmin');
            const content = document.getElementById('searchFilterContent');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            if (!form) return;

            // Persist toggle state like equipment-management
            const toggleKey = 'me_sf_open';
            try {
                const isOpen = localStorage.getItem(toggleKey) === '1';
                if (isOpen && content && toggleText && toggleIcon) {
                    content.style.display = 'block';
                    toggleText.textContent = 'Hide';
                    toggleIcon.style.transform = 'rotate(180deg)';
                }
            } catch(e) {}

            // Hook into the page's toggle button if present
            window.toggleSearchFilter = function(){
                if (content && (content.style.display === 'none' || content.style.display === '')) {
                    content.style.display = 'block';
                    toggleText.textContent = 'Hide';
                    toggleIcon.style.transform = 'rotate(180deg)';
                    try { localStorage.setItem(toggleKey, '1'); } catch(e) {}
                } else {
                    content.style.display = 'none';
                    toggleText.textContent = 'Show';
                    toggleIcon.style.transform = 'rotate(0deg)';
                    try { localStorage.setItem(toggleKey, '0'); } catch(e) {}
                }
            };

            if (clearBtn) {
                clearBtn.addEventListener('click', function(){
                    resetForm();
                    // Ensure the panel stays open after refresh
                    try { localStorage.setItem(toggleKey, '1'); } catch(e) {}
                    submitAjax(new URL(form.action, window.location.origin));
                });
            }

            // Intercept submit for AJAX-only refresh
            form.addEventListener('submit', function(e){
                e.preventDefault();
                // Validate date range
                const df = form.querySelector('input[name="date_from"]').value;
                const dt = form.querySelector('input[name="date_to"]').value;
                
                // Check if Date To is filled without Date From
                if (dt && !df) {
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
                    return;
                }
                
                if (df && dt && df > dt) {
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
                    return;
                }
                const url = new URL(form.action, window.location.origin);
                const data = new FormData(form);
                // Clean params first
                url.search = '';
                for (const [k,v] of data.entries()) { if (v) url.searchParams.set(k,v); }
                submitAjax(url);
            });

            function resetForm(){
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(el => { if (el.tagName === 'SELECT') el.selectedIndex = 0; else el.value = ''; });
                // Lock type if exists
                const typeSelect = document.getElementById('filter_equipment_type');
                const help = document.getElementById('filter_equipment_type_help');
                if (typeSelect) typeSelect.disabled = true;
                if (help) help.style.display = '';
            }

            function submitAjax(url){
                const wrapper = document.getElementById('missingTableWrapper');
                fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r=>r.text())
                    .then(html=>{
                        const doc = new DOMParser().parseFromString(html,'text/html');
                        const next = doc.querySelector('#missingTableWrapper');
                        if (wrapper && next) wrapper.innerHTML = next.innerHTML;
                        window.history.replaceState({},'',url);
                        if (content && toggleText && toggleIcon) {
                            content.style.display = 'block';
                            toggleText.textContent = 'Hide';
                            toggleIcon.style.transform = 'rotate(180deg)';
                        }
                    })
                    .catch(()=>{ if (form.requestSubmit) form.requestSubmit(); else form.submit(); });
            }
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
<?php /**PATH C:\UB-SEMS\resources\views\admin-manager\missing-equipment\index.blade.php ENDPATH**/ ?>