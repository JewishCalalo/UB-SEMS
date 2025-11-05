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
            <?php echo e(__('Edit Reservation')); ?> #<?php echo e($reservation->id); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if($reservation->status === 'cancelled'): ?>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100">
                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Reservation Cannot Be Edited</h3>
                            <p class="mt-1 text-sm text-gray-500">This reservation has been cancelled and cannot be modified.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('reservation-management.index')); ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-150 shadow-sm">
                                    Back to Reservations
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                                            <form method="POST" action="<?php echo e(route('reservation-management.update', $reservation)); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- Reservation Details -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Reservation Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <?php if($reservation->createdBy && !$reservation->user): ?>
                                        <p class="text-sm font-medium text-gray-500">PE Staff Member</p>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo e($reservation->name ?? 'Unknown'); ?></p>
                                        <p class="text-sm text-gray-600">PE Class Equipment Reservation</p>
                                        <div class="mt-2">
                                            <p class="text-sm font-medium text-gray-500">Created by</p>
                                            <p class="text-sm text-gray-600"><?php echo e($reservation->createdBy->name); ?> (<?php echo e(ucfirst($reservation->createdBy->role)); ?>)</p>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-sm font-medium text-gray-500">Requested By</p>
                                        <p class="mt-1 text-sm text-gray-900"><?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?></p>
                                        <p class="text-sm text-gray-600"><?php echo e($reservation->user ? $reservation->user->email : ($reservation->email ?? 'No email')); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Request Date</p>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($reservation->created_at->format('M d, Y g:i A')); ?></p>
                                </div>
                            </div>
                            
                            <?php if(!$reservation->createdBy || $reservation->user): ?>
                                <!-- ID Upload Status - Only show for user reservations -->
                            <?php endif; ?>
                        </div>

                        <!-- Equipment Items -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Equipment Items</h3>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-900"><?php echo e($item->equipment->display_name); ?></h4>
                                                <p class="text-sm text-gray-600"><?php echo e($item->equipment->category->name); ?></p>
                                                <p class="text-sm text-gray-500">Quantity: <?php echo e($item->quantity_requested); ?></p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Available: <?php echo e($item->equipment->quantity_available); ?></p>
                                                <p class="text-sm text-gray-500">Total: <?php echo e($item->equipment->quantity_total); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Status Update -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                    <select name="status" id="status" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <?php
                                            // Different status workflows for PE staff vs user reservations
                                            if ($reservation->createdBy && !$reservation->user) {
                                                // PE Staff reservation workflow - uses same statuses but different logic
                                                $allowedTransitions = [
                                                    'pending' => ['approved', 'denied', 'cancelled'],
                                                    'approved' => ['picked_up', 'denied', 'cancelled'],
                                                    'picked_up' => ['returned'],
                                                    'returned' => ['completed'],
                                                    'denied' => [],
                                                    'completed' => [],
                                                    'cancelled' => [],
                                                ];
                                            } else {
                                                // User reservation workflow
                                                $allowedTransitions = [
                                                    'pending' => ['approved', 'denied', 'cancelled'],
                                                    'approved' => ['picked_up', 'denied', 'cancelled'],
                                                    'picked_up' => ['returned'],
                                                    'returned' => ['completed'],
                                                    'denied' => [],
                                                    'completed' => [],
                                                    'cancelled' => [],
                                                ];
                                            }
                                            $currentStatus = $reservation->status;
                                            $allowedStatuses = $allowedTransitions[$currentStatus] ?? [];
                                        ?>
                                        
                                        <?php $__currentLoopData = ['pending', 'approved', 'denied', 'picked_up', 'returned', 'completed', 'cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(in_array($status, $allowedStatuses) || $status === $currentStatus): ?>
                                                <option value="<?php echo e($status); ?>" <?php echo e($reservation->status === $status ? 'selected' : ''); ?>>
                                                    <?php echo e(ucfirst(str_replace('_', ' ', $status))); ?>

                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php if(empty($allowedStatuses)): ?>
                                        <p class="mt-1 text-sm text-gray-500">No further status changes allowed for <?php echo e(ucfirst(str_replace('_', ' ', $currentStatus))); ?> reservations</p>
                                    <?php endif; ?>
                                </div>

                                <?php if(!$reservation->createdBy || $reservation->user): ?>
                                    <!-- Pickup Date - Only for user reservations -->
                                    <div>
                                        <label for="pickup_date" class="block text-sm font-medium text-gray-700">Pickup Date</label>
                                        <input type="date" name="pickup_date" id="pickup_date" 
                                               value="<?php echo e($reservation->pickup_date ? $reservation->pickup_date->format('Y-m-d') : ''); ?>"
                                               min="<?php echo e($reservation->borrow_date->format('Y-m-d')); ?>"
                                               max="<?php echo e($reservation->return_date->format('Y-m-d')); ?>"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <p class="mt-1 text-sm text-gray-500">Set pickup date when approving reservation (between <?php echo e($reservation->borrow_date->format('M d, Y')); ?> and <?php echo e($reservation->return_date->format('M d, Y')); ?>)</p>
                                    </div>
                                <?php else: ?>
                                    <!-- PE Staff reservation info -->
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">PE Class Equipment</p>
                                        <p class="mt-1 text-sm text-gray-600">Equipment is used during class time</p>
                                        <p class="text-sm text-gray-500">No pickup required - equipment stays in PE department</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Remarks</h3>
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700">
                                    <?php if($reservation->createdBy && !$reservation->user): ?>
                                        Class/Activity Notes
                                    <?php else: ?>
                                        Manager Remarks
                                    <?php endif; ?>
                                </label>
                                <textarea name="remarks" id="remarks" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="<?php if($reservation->createdBy && !$reservation->user): ?>Add notes about the PE class or activity...@elseAdd any remarks or notes about this reservation...<?php endif; ?>"><?php echo e($reservation->remarks); ?></textarea>
                                <p class="mt-1 text-sm text-gray-500">
                                    <?php if($reservation->createdBy && !$reservation->user): ?>
                                        Optional notes about the PE class or activity
                                    <?php else: ?>
                                        Optional remarks for the user
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="history.back()" 
                                   class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-400 transition duration-150 shadow-sm">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-150 shadow-sm">
                                Update Reservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Auto-show pickup date field when status is approved (only for user reservations)
        document.getElementById('status').addEventListener('change', function() {
            const pickupDateField = document.getElementById('pickup_date');
            if (pickupDateField) { // Only if pickup date field exists (user reservations)
                if (this.value === 'approved') {
                    pickupDateField.style.display = 'block';
                    pickupDateField.required = true;
                } else {
                    pickupDateField.style.display = 'block';
                    pickupDateField.required = false;
                }
            }
        });
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
<?php /**PATH C:\UB-SEMS\resources\views\admin-manager\reservation-management\edit.blade.php ENDPATH**/ ?>