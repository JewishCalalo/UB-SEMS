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
            <?php echo e(__('Instance History')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Instance Details Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                <?php echo e($instance->equipment->name); ?> - <?php echo e($instance->instance_code); ?>

                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-500">Brand:</span>
                                    <span class="text-gray-900"><?php echo e($instance->equipment->brand ?? 'No brand'); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500">Current Condition:</span>
                                    <span class="text-gray-900"><?php echo e(ucfirst($instance->condition)); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500">Location:</span>
                                    <span class="text-gray-900"><?php echo e($instance->location ?? 'Not specified'); ?></span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-500">Status:</span>
                                    <?php if($instance->is_available): ?>
                                        <span class="text-green-600 font-medium">Available</span>
                                    <?php else: ?>
                                        <span class="text-red-600 font-medium">Unavailable</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="<?php echo e(route('equipment-returns.history')); ?>" 
                               class="text-red-600 hover:text-red-900 text-sm">
                                <i class="fas fa-arrow-left mr-1"></i>Back to Returns
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Return History Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Return History</h4>
                    
                    <?php if($returnLogs->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="<?php echo e(route('equipment-returns.instance-history', array_merge(['instance' => $instance->id], request()->query(), ['sort' => 'returned_at', 'direction' => request('direction') === 'asc' && request('sort')==='returned_at' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1">
                                                Return Date
                                                <span class="ml-1 inline-flex flex-col leading-none">
                                                    <i class="fas fa-caret-up <?php echo e(request('sort')==='returned_at' && request('direction')==='asc' ? 'text-gray-700' : 'text-gray-300'); ?>"></i>
                                                    <i class="fas fa-caret-down <?php echo e(request('sort')==='returned_at' && request('direction')==='desc' ? 'text-gray-700' : 'text-gray-300'); ?>"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reservation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penalties</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Processed By</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $returnLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo e($log->returned_at->format('M d, Y')); ?>

                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <?php echo e($log->returned_at->format('H:i')); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?php echo e($log->reservation->reservation_code); ?>

                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <?php echo e($log->reservation->borrow_date->format('M d, Y')); ?> - <?php echo e($log->reservation->return_date->format('M d, Y')); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo e($log->reservation->user->name ?? 'Guest User'); ?>

                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <?php echo e($log->reservation->user->email ?? 'No email'); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php
                                                    $conditionColors = [
                                                        'excellent' => 'bg-green-100 text-green-800',
                                                        'good' => 'bg-blue-100 text-blue-800',
                                                        'fair' => 'bg-yellow-100 text-yellow-800',
                                                        'needs_repair' => 'bg-orange-100 text-orange-800',
                                                        'damaged' => 'bg-red-100 text-red-800',
                                                        'lost' => 'bg-gray-100 text-gray-800'
                                                    ];
                                                ?>
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($conditionColors[$log->returned_condition] ?? 'bg-gray-100 text-gray-800'); ?>">
                                                    <?php echo e(ucfirst($log->returned_condition)); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <div><strong>Returned:</strong> <?php echo e($log->quantity_returned); ?></div>
                                                    <?php if($log->quantity_damaged > 0): ?>
                                                        <div class="text-red-600"><strong>Damaged:</strong> <?php echo e($log->quantity_damaged); ?></div>
                                                    <?php endif; ?>
                                                    <?php if($log->quantity_lost > 0): ?>
                                                        <div class="text-red-600"><strong>Lost:</strong> <?php echo e($log->quantity_lost); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if($log->condition_notes): ?>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        <?php echo e(Str::limit($log->condition_notes, 60)); ?>

                                                    </div>
                                                <?php endif; ?>
                                                <?php if($log->damage_description): ?>
                                                    <div class="text-xs text-red-600 mt-1">
                                                        <strong>Damage:</strong> <?php echo e(Str::limit($log->damage_description, 60)); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if($log->quantity_damaged > 0 || $log->quantity_lost > 0): ?>
                                                    <div class="text-sm font-medium text-red-600">
                                                        $<?php echo e(number_format($log->total_penalty, 2)); ?>

                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-sm text-gray-500">No penalties</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php echo e($log->processedBy->name); ?>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            <?php echo e($returnLogs->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No return history for this instance</h3>
                            <p class="mt-1 text-sm text-gray-500">This equipment instance hasn't been returned yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\UB-SEMS\resources\views\equipment-returns\instance-history.blade.php ENDPATH**/ ?>