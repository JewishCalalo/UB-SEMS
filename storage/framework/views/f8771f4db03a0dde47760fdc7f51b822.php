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
            <?php echo e(__('User Activity')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="<?php echo e(route('profile-user-management.show', $user)); ?>" class="text-red-600 hover:text-red-800">
                    ← Back to User Details
                </a>
            </div>

            <!-- User Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-lg font-medium text-gray-700">
                                <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                            </span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900"><?php echo e($user->name); ?></h3>
                            <p class="text-gray-600"><?php echo e($user->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                        <button onclick="showTab('reservations')" 
                                class="tab-button border-b-2 border-red-500 py-4 px-1 text-sm font-medium text-red-600"
                                id="reservations-tab">
                            Reservations (<?php echo e($reservations->count()); ?>)
                        </button>

                    </nav>
                </div>

                <div class="p-6">
                    <!-- Reservations Tab -->
                    <div id="reservations-content" class="tab-content">
                        <?php if($reservations->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <span class="px-2 py-1 text-xs rounded-full 
                                                        <?php if($reservation->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                                        <?php elseif($reservation->status === 'approved'): ?> bg-green-100 text-green-800
                                                        <?php elseif($reservation->status === 'denied'): ?> bg-red-100 text-red-800
                                                        <?php elseif($reservation->status === 'picked_up'): ?> bg-blue-100 text-blue-800
                                                        <?php elseif($reservation->status === 'returned'): ?> bg-gray-100 text-gray-800
                                                        <?php elseif($reservation->status === 'overdue'): ?> bg-orange-100 text-orange-800
                                                        <?php elseif($reservation->status === 'cancelled'): ?> bg-red-100 text-red-800
                                                        <?php else: ?> bg-gray-100 text-gray-800
                                                        <?php endif; ?>">
                                                        <?php echo e(ucfirst($reservation->status)); ?>

                                                    </span>
                                                    <span class="text-xs text-gray-500"><?php echo e($reservation->created_at->format('M d, Y H:i')); ?></span>
                                                    <span class="text-xs text-gray-500">Code: <?php echo e($reservation->reservation_code); ?></span>
                                                </div>
                                                
                                                <div class="space-y-2">
                                                    <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="flex items-center space-x-2">
                                                            <span class="text-gray-600">•</span>
                                                            <span class="text-sm font-medium text-gray-900"><?php echo e($item->equipment->name); ?></span>
                                                            <span class="text-sm text-gray-500">(Qty: <?php echo e($item->quantity); ?>)</span>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                
                                                <?php if($reservation->reason): ?>
                                                    <div class="mt-2">
                                                        <span class="text-sm font-medium text-gray-700">Reason:</span>
                                                        <span class="text-sm text-gray-600"><?php echo e($reservation->reason); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="mt-2 text-sm text-gray-500">
                                                    <span>Borrow: <?php echo e($reservation->borrow_date->format('M d, Y')); ?></span>
                                                    <span class="mx-2">•</span>
                                                    <span>Return: <?php echo e($reservation->return_date->format('M d, Y')); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <!-- Pagination for Reservations -->
                            <div class="mt-6">
                                <?php echo e($reservations->links()); ?>

                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations found</h3>
                                <p class="mt-1 text-sm text-gray-500">This user hasn't made any reservations yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('border-red-500', 'text-red-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            const selectedContent = document.getElementById(tabName + '-content');
            if (selectedContent) {
                selectedContent.classList.remove('hidden');
            }
            
            // Add active state to selected tab button
            const selectedButton = document.getElementById(tabName + '-tab');
            if (selectedButton) {
                selectedButton.classList.remove('border-transparent', 'text-gray-500');
                selectedButton.classList.add('border-red-500', 'text-red-600');
            }
        }
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
<?php /**PATH C:\UB-SEMS\resources\views\admin\user-management\activity.blade.php ENDPATH**/ ?>