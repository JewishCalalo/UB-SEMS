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
            <?php echo e(__('Equipment Details')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment', 'url' => route('equipment-management.index')],
                ['label' => $equipment->display_name]
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment', 'url' => route('equipment-management.index')],
                ['label' => $equipment->display_name]
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
            <!-- Header with Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Equipment Details
                            </h3>
                            <p class="text-gray-600">View and manage equipment information</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo e(route('maintenance-management.show', $equipment)); ?>" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Maintenance
                        </a>
                        <a href="<?php echo e(route('equipment-management.index')); ?>" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Equipment Information -->
                <div class="lg:col-span-2">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <?php if($equipment->images->count() > 0): ?>
                                    <img class="h-24 w-24 rounded-lg object-cover" 
                                         src="<?php echo e($equipment->images->first()->url); ?>" 
                                         alt="<?php echo e($equipment->display_name); ?>">
                                <?php else: ?>
                                    <div class="h-24 w-24 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-1">
                                    <h2 class="text-2xl font-bold text-gray-900"><?php echo e($equipment->display_name); ?></h2>
                                    <p class="text-gray-600"><?php echo e($equipment->brand ?: 'No brand specified'); ?></p>
                                    
                                    <div class="mt-2">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?php echo e($equipment->category->name); ?>

                                        </span>
                                        <?php if($equipment->equipmentType): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 ml-2">
                                                <?php echo e($equipment->equipmentType->name); ?>

                                            </span>
                                        <?php endif; ?>
                                        <?php if($equipment->model): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 ml-2">
                                                <?php echo e($equipment->model); ?>

                                            </span>
                                        <?php endif; ?>
                                        <?php if($equipment->quantity_available > 0): ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 ml-2">
                                                Available
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 ml-2">
                                                Unavailable
                                            </span>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>

                            <?php if($equipment->description): ?>
                                <div class="mt-6">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Description</h4>
                                    <p class="text-gray-700"><?php echo e($equipment->description); ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Equipment Details Grid -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Quantity Information</h4>
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Total Quantity:</span>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->quantity_total); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Available:</span>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->quantity_available); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">In Use:</span>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->quantity_total - $equipment->quantity_available); ?></span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <?php
                                                $percentage = $equipment->quantity_total > 0 ? ($equipment->quantity_available / $equipment->quantity_total) * 100 : 0;
                                            ?>
                                            <div class="bg-red-600 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Equipment Details</h4>
                                    <div class="space-y-2">
                                        <?php if($equipment->equipmentType): ?>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600">Equipment Type:</span>
                                                <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->equipmentType->name); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($equipment->model): ?>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600">Model:</span>
                                                <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->model); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Location:</span>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->location ?: 'Not specified'); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Status:</span>
                                            <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->is_active ? 'Active' : 'Inactive'); ?></span>
                                        </div>
                                        <?php if($equipment->purchase_date): ?>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-gray-600">Purchase Date:</span>
                                                <span class="text-sm font-medium text-gray-900"><?php echo e($equipment->purchase_date->format('M d, Y')); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Equipment Images -->
                    <?php if($equipment->images->count() > 0): ?>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Equipment Images</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    <?php $__currentLoopData = $equipment->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <img class="w-full h-24 object-cover rounded-lg" 
                                             src="<?php echo e($image->url); ?>" 
                                             alt="<?php echo e($equipment->display_name); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Recent Maintenance Records -->
                    <?php if($maintenanceRecords->count() > 0): ?>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                            <div class="p-6">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Recent Maintenance</h4>
                                <div class="space-y-3">
                                    <?php $__currentLoopData = $maintenanceRecords->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border-l-4 border-green-500 pl-3">
                                            <p class="text-sm font-medium text-gray-900"><?php echo e($record->maintenance_type); ?></p>
                                            <p class="text-xs text-gray-600"><?php echo e($record->maintenance_date->format('M d, Y')); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e(Str::limit($record->description, 50)); ?></p>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="mt-3">
                                    <a href="<?php echo e(route('maintenance-management.show', $equipment)); ?>" 
                                       class="text-sm text-red-600 hover:text-red-800">
                                        View all maintenance records →
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Equipment Actions -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-900 mb-3">Equipment Actions</h3>
                            <div class="space-y-3">
                                <button type="button" 
                                        onclick="showAddInstanceModal()"
                                        class="w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-md shadow-sm hover:from-blue-700 hover:to-indigo-700 transition flex items-center justify-center text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Instances
                                </button>
                                <button type="button" 
                                        onclick="showDeleteEquipmentConfirmation('<?php echo e($equipment->id); ?>', '<?php echo e($equipment->display_name); ?>')"
                                        class="w-full px-4 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-md shadow-sm hover:from-red-700 hover:to-pink-700 transition flex items-center justify-center text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Equipment
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                <!-- Centered Deletion & Retirement Rules just below Equipment Details -->
                <div class="mt-4">
                        <div class="flex justify-center">
                            <button type="button" onclick="toggleRules()" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-semibold hover:bg-blue-700 transition">
                                <span id="rulesToggleLabel">Show</span> Equipment Tool Guide
                            </button>
                        </div>
                        <div id="rulesPanel" class="mt-3 hidden text-sm text-blue-900">
                            <div class="max-w-4xl mx-auto bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Instance Management -->
                                    <div>
                                        <h4 class="font-bold text-blue-800 mb-3">Instance Management</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><strong>Add Instances:</strong> Bulk add new equipment instances with initial condition and location.</li>
                                            <li><strong>Retire Selected:</strong> Remove instances from future availability while preserving history.</li>
                                            <li><strong>Delete Selected:</strong> Permanently remove instances with no reservation records.</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Equipment Actions -->
                                    <div>
                                        <h4 class="font-bold text-blue-800 mb-3">Equipment Actions</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><strong>Maintenance:</strong> View and manage maintenance records for this equipment.</li>
                                            <li><strong>Delete Equipment:</strong> Remove entire equipment and all data (requires password confirmation).</li>
                                            <li><strong>Back:</strong> Return to equipment management list.</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Instance Status Guide -->
                                    <div>
                                        <h4 class="font-bold text-blue-800 mb-3">Instance Status Guide</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li><strong>Has Record = Yes:</strong> Instance has reservation history. Use <em>Retire</em> instead of delete.</li>
                                            <li><strong>Has Record = No:</strong> Instance has no history. Safe to <em>Delete</em>.</li>
                                            <li><strong>Available:</strong> Instance is ready for new reservations.</li>
                                            <li><strong>Reserved Dates:</strong> Shows current/future reservation periods.</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Quick Tips -->
                                    <div>
                                        <h4 class="font-bold text-blue-800 mb-3">Quick Tips</h4>
                                        <ul class="space-y-2 text-sm">
                                            <li>Select multiple instances using checkboxes for bulk operations.</li>
                                            <li>Retirement preserves data for reporting and history.</li>
                                            <li>Deletion is permanent and cannot be undone.</li>
                                            <li>Active reservations block both retirement and deletion.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    <!-- Equipment Instances Table - Full Width Container -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900">Equipment Instances</h3>
                        <div class="flex items-center gap-3">
                            <div class="text-sm font-semibold text-gray-700">Total: <?php echo e($equipment->instances->count()); ?> instances</div>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick="bulkRetireInstances()" class="px-4 py-2 bg-yellow-600 text-white rounded-md text-sm font-semibold hover:bg-yellow-700 transition">Retire Selected</button>
                                <button type="button" onclick="bulkDeleteInstances()" class="px-4 py-2 bg-black text-white rounded-md text-sm font-semibold hover:bg-gray-900 transition">Delete Selected</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-600 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider w-12">
                                        <div class="flex items-center gap-2">
                                            <input type="checkbox" id="selectAllInstances" onclick="toggleSelectAllInstances(this)" class="w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Condition</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Available</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Has Record</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Reserved Dates</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $equipment->instances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $instance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"><input type="checkbox" class="instance-checkbox w-4 h-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" value="<?php echo e($instance->id); ?>"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($instance->instance_code); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex px-2 py-0.5 text-xs rounded-full <?php echo e($instance->condition === 'excellent' ? 'bg-green-100 text-green-800' : ($instance->condition === 'good' ? 'bg-blue-100 text-blue-800' : ($instance->condition === 'fair' ? 'bg-yellow-100 text-yellow-800' : ($instance->condition === 'needs_repair' ? 'bg-orange-100 text-orange-800' : ($instance->condition === 'damaged' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))))); ?>"><?php echo e(ucfirst(str_replace('_',' ', $instance->condition))); ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?php $status = $equipment->getInstanceReservationStatus($instance->id); $isAvailable = $status === 'Available'; ?> <?php echo e($isAvailable ? 'Yes' : 'No'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?php $status = $equipment->getInstanceReservationStatus($instance->id); ?> <?php if($status === 'Reserved'): ?><span class="inline-flex px-2 py-0.5 text-xs rounded-full bg-purple-100 text-purple-800">Reserved</span><?php elseif($status === 'Borrowed'): ?><span class="inline-flex px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-800">Borrowed</span><?php elseif($status === 'Unavailable'): ?><span class="inline-flex px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-800">Unavailable</span><?php else: ?><span class="inline-flex px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-800">Available</span><?php endif; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($instance->has_reservation_history ? 'Yes' : 'No'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?php echo e($instance->location ?? '—'); ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?php $reservations = $instance->getCurrentReservationDates(); ?> <?php if($reservations->count() > 0): ?> <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <div class="text-xs"><span class="text-black"><?php echo e(\Carbon\Carbon::parse($reservation['borrow_date'])->format('M d')); ?> - <?php echo e(\Carbon\Carbon::parse($reservation['return_date'])->format('M d')); ?></span> <span class="ml-1 px-1 py-0.5 rounded text-xs <?php echo e($reservation['is_current'] ? 'bg-red-100 text-red-800' : ($reservation['is_future'] ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-600')); ?>"><?php echo e($reservation['is_current'] ? 'Current' : ($reservation['is_future'] ? 'Future' : 'Past')); ?></span></div> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> <?php else: ?> <span class="text-gray-400">—</span> <?php endif; ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500" colspan="8">No instances available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Hidden form for equipment deletion -->
    <form id="delete-equipment-form" 
          method="POST" 
          action="<?php echo e(route('equipment-management.destroy', $equipment)); ?>" 
          class="hidden">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
    </form>
    




    
    <script>
        // Delete Instance Confirmation Modal
        function showDeleteInstanceConfirmation(instanceId, instanceCode) {
            Swal.fire({
                title: 'Delete Instance?',
                html: `Are you sure you want to delete instance <strong>${instanceCode}</strong>? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Delete Instance',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-instance-form-${instanceId}`).submit();
                }
            });
        }

        // Delete Equipment Confirmation Modal
        function showDeleteEquipmentConfirmation(equipmentId, equipmentName) {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Delete Equipment</h2>
                    </div>
                    
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex items-start gap-3">
                            <div class="p-1 bg-red-100 rounded">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-red-800 mb-2">Permanent Action Warning</h3>
                                <p class="text-red-700 text-sm">This action will permanently delete <strong>${equipmentName}</strong> and ALL associated data. This cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <h4 class="font-semibold text-slate-800 text-left">What will be deleted:</h4>
                        <ul class="space-y-2 text-sm text-slate-600 text-left">
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>All equipment instances and their data</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>All maintenance records for this equipment</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>All images and documentation</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Equipment specifications and details</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                                <span>Equipment will be removed from all future reservations</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="space-y-3 mb-4">
                        <h4 class="font-semibold text-slate-800">Deletion Requirements:</h4>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                <span>No active reservations (pending/approved/picked up)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                <span>All instances must be retired or deleted first</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                        <div class="flex items-start gap-3">
                            <div class="p-1 bg-amber-100 rounded">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-amber-800 mb-1">Confirmation Required</h4>
                                <p class="text-amber-700 text-sm">Enter your password to proceed with deleting the equipment.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Enter your password:</label>
                        <input type="password" id="deleteConfirmInput" 
                               class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                               placeholder="Enter your password...">
                    </div>
                    
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105" onclick="confirmDeleteEquipment()">
                            Delete Equipment
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '600px',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        }
        
        function confirmDeleteEquipment() {
            const confirmInput = document.getElementById('deleteConfirmInput');
            if (!confirmInput.value) {
                Swal.showValidationMessage('Password is required');
                return;
            }
            
            // Show loading state
            Swal.fire({
                title: 'Verifying Password...',
                text: 'Please wait while we verify your password.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Create a new form with password
            const form = document.getElementById('delete-equipment-form');
            const formData = new FormData(form);
            formData.append('password', confirmInput.value);
            
            // Submit via AJAX to handle password validation
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        title: '',
                        html: `
                            <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Success!</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-lg font-medium">Equipment has been successfully deleted.</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.href='<?php echo e(route('equipment-management.index')); ?>';">
                                    OK
                                </button>
                            </div>
                        `,
                        showConfirmButton: false,
                        showCancelButton: false,
                        customClass: {
                            popup: 'swal-custom-popup'
                        }
                    });
                } else {
                    // Show error message based on the type of error
                    if (data.message && data.message.includes('password')) {
                        // Password error
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Equipment Deletion Blocked</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">Equipment Deletion Blocked because of wrong password. Please check your password and try again.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                                        OK
                                    </button>
                                </div>
                            `,
                            showConfirmButton: false,
                            showCancelButton: false,
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                    } else if (data.message && data.message.includes('active instances')) {
                        // Active instances error
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-orange-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Cannot Delete Equipment</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">${data.message}</p>
                                    <p class="text-gray-600 text-sm mt-2">Please retire or delete all equipment instances first before deleting the equipment.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                                        OK
                                    </button>
                                </div>
                            `,
                            showConfirmButton: false,
                            showCancelButton: false,
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                    } else if (data.message && data.message.includes('active reservations')) {
                        // Active reservations error
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-orange-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Cannot Delete Equipment</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">${data.message}</p>
                                    <p class="text-gray-600 text-sm mt-2">Please complete or cancel all active reservations first before deleting the equipment.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                                        OK
                                    </button>
                                </div>
                            `,
                            showConfirmButton: false,
                            showCancelButton: false,
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                    } else {
                        // Generic error
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Equipment Deletion Blocked</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">${data.message || 'Failed to delete equipment.'}</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                                        OK
                                    </button>
                                </div>
                            `,
                            showConfirmButton: false,
                            showCancelButton: false,
                            customClass: {
                                popup: 'swal-custom-popup'
                            }
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Delete equipment error:', error);
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Network Error</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg font-medium">A network error occurred. Please check your internet connection and try again.</p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                                OK
                            </button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            });
        }

        // Bulk Add Instances Modal Functions
        function showAddInstanceModal() {
            Swal.fire({
                html: `
                    <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#10b981;">
                        <h2 class="text-xl font-bold text-center">Add Equipment Instances</h2>
                    </div>
                    <form id="addInstanceForm" method="POST" action="<?php echo e(route('instances.add', $equipment)); ?>" class="space-y-4">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Number of Instances</label>
                            <input type="number" name="quantity" id="instanceQuantity" min="1" max="99" value="1" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <p class="mt-1 text-xs text-gray-500">Enter the number of instances you want to add (1-99)</p>
                            <p id="quantityError" class="mt-1 text-xs text-red-600 hidden">Number of instances must be between 1 and 99.</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Initial Condition</label>
                            <select name="condition" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="excellent">Excellent</option>
                                <option value="good">Good</option>
                                <option value="fair">Fair</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" name="location" value="Storage Room A" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Add Instances',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                width: '500px',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                },
                preConfirm: () => {
                    const form = document.getElementById('addInstanceForm');
                    if (form) {
                        const quantity = parseInt(form.querySelector('#instanceQuantity').value);
                        const errorElement = document.getElementById('quantityError');
                        
                        // Validate quantity
                        if (quantity < 1 || quantity > 99 || isNaN(quantity)) {
                            errorElement.classList.remove('hidden');
                            return false; // Prevent modal from closing
                        } else {
                            errorElement.classList.add('hidden');
                        }
                        
                        const formData = new FormData(form);
                        const data = {};
                        formData.forEach((value, key) => {
                            data[key] = value;
                        });
                        
                        // Use AJAX with loading states
                        const buttonId = `add_instance_btn_<?php echo e($equipment->id); ?>`;
                        
                        ActionHandler.handleAjaxAction(buttonId, "<?php echo e(route('instances.add', $equipment)); ?>", {
                            method: 'POST',
                            data: data,
                            loadingText: 'Adding Instances...',
                            successTitle: 'Instances Added!',
                            successMessage: 'Equipment instances have been added successfully.',
                            errorTitle: 'Failed to Add Instances',
                            errorMessage: 'An error occurred while adding instances. Please try again.',
                            onSuccess: () => {
                                // Refresh only the instances table content
                                setTimeout(() => {
                                    const url = new URL(window.location.href);
                                    fetch(url)
                                        .then(response => response.text())
                                        .then(html => {
                                            const parser = new DOMParser();
                                            const doc = parser.parseFromString(html, 'text/html');
                                            const newTable = doc.querySelector('#instancesTableWrapper');
                                            const currentTable = document.querySelector('#instancesTableWrapper');
                                            
                                            if (newTable && currentTable) {
                                                currentTable.innerHTML = newTable.innerHTML;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            window.location.reload();
                                        });
                                }, 1500);
                            }
                        });
                        
                        return false; // Prevent form submission
                    }
                }
            });
        }

        function toggleSelectAllInstances(src){
            document.querySelectorAll('.instance-checkbox').forEach(cb => cb.checked = src.checked);
        }
        async function bulkDeleteInstances(){
            const selected = Array.from(document.querySelectorAll('.instance-checkbox:checked')).map(cb => cb.value);
            if(selected.length === 0){
                Swal.fire({icon:'info', title:'No instances selected', text:'Select at least one instance.', customClass:{popup:'swal-custom-popup'}});
                return;
            }
            // Check for instances that are currently assigned to active reservations (these cannot be deleted)
            const checks = Array.from(document.querySelectorAll('.instance-checkbox:checked'));
            const currentlyBlocked = checks.filter(cb => {
                const row = cb.closest('tr');
                const statusCell = row.querySelectorAll('td')[4]; // Status badge column
                const hasRecordCell = row.querySelectorAll('td')[5]; // Has Record column
                const reservedDatesCell = row.querySelectorAll('td')[7]; // Reserved Dates column

                const statusText = (statusCell?.innerText || '').trim().toLowerCase();
                const hasRecordText = (hasRecordCell?.innerText || '').trim().toLowerCase();
                const reservedDatesText = (reservedDatesCell?.innerText || '').trim();

                const isAvailable = statusText.includes('available');
                const hasRecord = hasRecordText === 'yes';
                const hasReservedDates = reservedDatesText && reservedDatesText !== '—';

                return hasRecord || hasReservedDates || !isAvailable;
            });
            if(currentlyBlocked.length > 0){
                Swal.fire({buttonsStyling:false, html:`<div class="bg-gradient-to-r from-red-600 to-pink-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold">Deletion Not Allowed</h2></div><div class="text-left"><p class="text-gray-700">Some selected instances are currently assigned to active reservations or have reserved dates. These cannot be deleted.</p><p class="mt-2 text-gray-600">Tip: Use "Retire Selected" for instances with active assignments.</p></div><div class="mt-6 text-center"><button class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-900" onclick="Swal.close()">OK</button></div>`, showConfirmButton:false, customClass:{popup:'swal-custom-popup'}});
                return;
            }
            const res = await Swal.fire({ title:'Delete Selected Instances?', html:`You are about to delete <strong>${selected.length}</strong> instance(s). This cannot be undone.`, icon:'warning', showCancelButton:true, confirmButtonText:'Delete', cancelButtonText:'Cancel', confirmButtonColor:'#dc2626', cancelButtonColor:'#6b7280', customClass:{popup:'swal-custom-popup'} });
            if(!res.isConfirmed) return;
            Swal.fire({title:'Deleting...', allowOutsideClick:false, didOpen:()=>Swal.showLoading(), customClass:{popup:'swal-custom-popup'}});
            let success=0, failed=0;
            for(const id of selected){
                try{
                    const resp = await fetch(`<?php echo e(url('/instances')); ?>/${id}`, {method:'POST', headers:{'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>','Accept':'application/json'}, body:new URLSearchParams({'_method':'DELETE'})});
                    if(resp.ok){ success++; } else { failed++; }
                }catch(e){ failed++; }
            }
            if(failed===0){
                Swal.fire({
                    buttonsStyling:false,
                    html:`
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                            <h2 class="text-xl font-bold">Deletion Successful</h2>
                        </div>
                        <div class="text-center">
                            <div class="mx-auto w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="text-gray-700">${success} instance(s) deleted successfully.</p>
                        </div>
                        <div class="mt-6 text-center"><button class="px-6 py-2 text-white rounded-lg" style="background: linear-gradient(135deg, #16a34a 0%, #059669 100%);" onmouseover="this.style.background='linear-gradient(135deg,#059669 0%, #047857 100%)'" onmouseout="this.style.background='linear-gradient(135deg,#16a34a 0%, #059669 100%)'" onclick="Swal.close(); location.reload();">OK</button></div>
                    `,
                    showConfirmButton:false,
                    customClass:{popup:'swal-custom-popup'}
                });
            }else{
                Swal.fire({
                    buttonsStyling:false,
                    html:`
                        <div class="bg-gradient-to-r from-red-600 to-pink-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                            <h2 class="text-xl font-bold">Some deletions failed</h2>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold mb-2">${success} succeeded, ${failed} failed.</p>
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                                </div>
                                <div>
                                    <p class="text-gray-700">Reasons:</p>
                                    <ul class="list-disc pl-5 mt-2 text-gray-700">
                                        <li>Instance has a pending/approved/picked-up reservation</li>
                                        <li>Instance is currently assigned for pickup/borrow</li>
                                    </ul>
                                    <p class="mt-3 text-gray-600">Please resolve these reservations first, then try again.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-center"><button class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-900" onclick="Swal.close(); location.reload();">OK</button></div>
                    `,
                    showConfirmButton:false,
                    customClass:{popup:'swal-custom-popup'}
                });
            }
        }
        async function bulkRetireInstances(){
            const selected = Array.from(document.querySelectorAll('.instance-checkbox:checked')).map(cb => cb.value);
            if(selected.length === 0){
                Swal.fire({icon:'info', title:'No instances selected', text:'Select at least one instance.', customClass:{popup:'swal-custom-popup'}});
                return;
            }
            const res = await Swal.fire({ title:'Retire Selected Instances?', html:`Retire <strong>${selected.length}</strong> instance(s). They will no longer be available for reservations.`, icon:'warning', showCancelButton:true, confirmButtonText:'Retire', cancelButtonText:'Cancel', confirmButtonColor:'#d97706', cancelButtonColor:'#6b7280', customClass:{popup:'swal-custom-popup'} });
            if(!res.isConfirmed) return;
            Swal.fire({title:'Retiring...', allowOutsideClick:false, didOpen:()=>Swal.showLoading(), customClass:{popup:'swal-custom-popup'}});
            let success=0, failed=0;
            for(const id of selected){
                try{
                    const resp = await fetch(`<?php echo e(url('/instances')); ?>/${id}/retire`, {method:'POST', headers:{'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>','Accept':'application/json'}});
                    if(resp.ok){ success++; } else { failed++; }
                }catch(e){ failed++; }
            }
            const html = failed===0 ? `
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold">Retirement Completed</h2></div>
                <div class="text-center"><p class="text-gray-700">${success} instance(s) retired.</p></div>
                <div class="mt-6 text-center"><button class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-900" onclick="Swal.close(); location.reload();">OK</button></div>
            ` : `
                <div class="bg-gradient-to-r from-yellow-600 to-amber-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold">Some retirements failed</h2></div>
                <div class="text-left">
                    <p class="font-semibold mb-2">${success} succeeded, ${failed} failed.</p>
                    <p class="text-gray-700">One or more instances have an ongoing reservation and cannot be retired until returned.</p>
                </div>
                <div class="mt-6 text-center"><button class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-900" onclick="Swal.close(); location.reload();">OK</button></div>
            `;
            Swal.fire({buttonsStyling:false, html, showConfirmButton:false, customClass:{popup:'swal-custom-popup'}});
        }
    </script>

    <script>
        function toggleRules(){
            const panel = document.getElementById('rulesPanel');
            const label = document.getElementById('rulesToggleLabel');
            const isHidden = panel.classList.contains('hidden');
            if(isHidden){ panel.classList.remove('hidden'); label.textContent = 'Hide'; }
            else { panel.classList.add('hidden'); label.textContent = 'Show'; }
        }
    </script>

    <?php if($errors->any()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                Swal.fire({
                    buttonsStyling:false,
                    html:`
                        <div class="bg-gradient-to-r from-red-600 to-pink-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                            <h2 class="text-xl font-bold">Delete Equipment Failed</h2>
                        </div>
                        <div class="text-left">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                                </div>
                                <div>
                                    <p class="text-gray-700">This equipment cannot be deleted because at least one of its instances is part of a pending/approved/picked-up reservation.</p>
                                    <p class="mt-2 text-gray-600">Please complete or cancel related reservations first, then try again.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-center"><button class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-900" onclick="Swal.close()">OK</button></div>
                    `,
                    showConfirmButton:false,
                    customClass:{popup:'swal-custom-popup'}
                });
            });
        </script>
    <?php endif; ?>
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
<?php /**PATH C:\SEMSv26\resources\views/admin-manager/equipment-management/show.blade.php ENDPATH**/ ?>