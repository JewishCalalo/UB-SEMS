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
            <?php echo e(__('Reservation Confirmation')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-green-800">Reservation Submitted Successfully!</h3>
                            <p class="mt-1 text-sm text-green-700"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Reservation Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Reservation Details</h3>
                        <p class="text-gray-600">Your equipment reservation has been submitted and is pending approval.</p>
                    </div>

                    <!-- Reservation Code -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-blue-900">Reservation Code</h4>
                                <p class="text-sm text-blue-700">Use this code to track your reservation</p>
                            </div>
                            <div class="text-right">
                                <span class="text-2xl font-bold text-blue-600"><?php echo e($reservation->reservation_code); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Status</h4>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Pending Approval
                        </span>
                    </div>

                    <!-- Borrower Information -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Borrower Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                <p class="text-sm text-gray-900"><?php echo e($reservation->name); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="text-sm text-gray-900"><?php echo e($reservation->email); ?></p>
                            </div>
                            <?php if($reservation->contact_number): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Contact Number</label>
                                    <p class="text-sm text-gray-900"><?php echo e($reservation->contact_number); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if($reservation->department): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Department</label>
                                    <p class="text-sm text-gray-900"><?php echo e($reservation->department); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reservation Dates -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Reservation Period</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Borrow Date</label>
                                <p class="text-sm text-gray-900"><?php echo e($reservation->borrow_date->format('F d, Y')); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Return Date</label>
                                <p class="text-sm text-gray-900"><?php echo e($reservation->return_date->format('F d, Y')); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Purpose -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Purpose</h4>
                        <p class="text-sm text-gray-900"><?php echo e($reservation->reason); ?></p>
                        <?php if($reservation->additional_details): ?>
                            <div class="mt-2">
                                <label class="block text-sm font-medium text-gray-500">Additional Details</label>
                                <p class="text-sm text-gray-900"><?php echo e($reservation->additional_details); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Reserved Equipment -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Reserved Equipment</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity Requested</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($item->equipment->name); ?></div>
                                                <div class="text-sm text-gray-500"><?php echo e($item->equipment->brand ?? 'N/A'); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($item->equipment->category->name); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($item->quantity_requested); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <h4 class="font-medium text-blue-900 mb-2">What's Next?</h4>
                        <div class="text-sm text-blue-800 space-y-2">
                            <p>• Your reservation is currently under review by our staff</p>
                            <p>• You will receive an email notification once your request is approved or denied</p>
                            <p>• You can track your reservation status using your reservation code: <strong><?php echo e($reservation->reservation_code); ?></strong></p>
                            <p>• If approved, please pick up your equipment on the scheduled borrow date</p>
                            <p>• If you need to update your reason, department, or reservation dates while the request is pending, please contact the office or reply to the email confirmation. For larger changes, consider cancelling and submitting a new reservation.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo e(route('reservations.show', $reservation)); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Full Details
                        </a>
                        
                        <a href="<?php echo e(route('reservations.track')); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Track Another Reservation
                        </a>
                        
                        <a href="<?php echo e(route('equipment.index')); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Browse More Equipment
                        </a>
                    </div>

                    <!-- Important Notes -->
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                        <h4 class="font-medium text-yellow-900 mb-2">Important Notes</h4>
                        <div class="text-sm text-yellow-800 space-y-1">
                            <p>• Please keep your reservation code safe - you'll need it to track your reservation</p>
                            <p>• Equipment must be returned in the same condition as borrowed</p>
                            <p>• Late returns may result in penalties or restrictions on future reservations</p>
                            <p>• Contact the Physical Education Office if you have any questions</p>
                        </div>
                    </div>
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
<?php /**PATH C:\UB-SEMS\resources\views\user\reservations\confirmation.blade.php ENDPATH**/ ?>