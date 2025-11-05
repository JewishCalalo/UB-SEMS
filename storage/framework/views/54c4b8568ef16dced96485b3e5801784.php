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
            <?php echo e(__('Reservation Details')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'My Reservations', 'url' => route('instructor.reservations')],
                ['label' => 'Reservation Details']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'My Reservations', 'url' => route('instructor.reservations')],
                ['label' => 'Reservation Details']
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

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Reservation Details</h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <span class="font-medium">Code:</span>
                                <span class="font-bold text-red-600 ml-1"><?php echo e($reservation->reservation_code); ?></span>
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Created:</span>
                                <span class="ml-1"><?php echo e($reservation->created_at->format('M d, Y \a\t g:i A')); ?></span>
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            <?php if($reservation->status === 'approved'): ?> bg-green-100 text-green-800 border border-green-200
                            <?php elseif($reservation->status === 'pending'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                            <?php elseif($reservation->status === 'rejected'): ?> bg-red-100 text-red-800 border border-red-200
                            <?php elseif($reservation->status === 'picked_up'): ?> bg-blue-100 text-blue-800 border border-blue-200
                            <?php elseif($reservation->status === 'returned'): ?> bg-purple-100 text-purple-800 border border-purple-200
                            <?php elseif($reservation->status === 'completed'): ?> bg-gray-100 text-gray-800 border border-gray-200
                            <?php else: ?> bg-gray-100 text-gray-800 border border-gray-200 <?php endif; ?>">
                            <?php echo e(ucfirst(str_replace('_', ' ', $reservation->status))); ?>

                        </span>
                        <a href="<?php echo e(route('instructor.reservations')); ?>" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:ring-2 focus:ring-gray-300 shadow">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Reservations
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Main Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Equipment Details -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                            <h3 class="text-lg font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                </svg>
                                Equipment Details
                            </h3>
                        </div>
                        <div class="px-6 py-4">
                            <?php if($reservation->items && $reservation->items->count() > 0): ?>
                                <div class="space-y-4">
                                    <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-red-200 transition-colors">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center mb-2">
                                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                                            </svg>
                                                        </div>
                                                        <h4 class="font-medium text-gray-900"><?php echo e($item->equipment->description ?? 'Equipment'); ?></h4>
                                                    </div>
                                                    <div class="ml-11 space-y-1">
                                                        <?php if($item->equipment->brand): ?>
                                                            <p class="text-sm text-gray-600 flex items-center">
                                                                <svg class="w-3 h-3 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                                </svg>
                                                                Brand: <?php echo e($item->equipment->brand); ?>

                                                            </p>
                                                        <?php endif; ?>
                                                        <?php if($item->equipment->model): ?>
                                                            <p class="text-sm text-gray-600 flex items-center">
                                                                <svg class="w-3 h-3 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                                </svg>
                                                                Model: <?php echo e($item->equipment->model); ?>

                                                            </p>
                                                        <?php endif; ?>
                                                        <?php if($item->equipment->category): ?>
                                                            <p class="text-sm text-gray-600 flex items-center">
                                                                <svg class="w-3 h-3 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                                </svg>
                                                                Category: <?php echo e($item->equipment->category->name); ?>

                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm text-gray-600 mb-1">
                                                        <span class="font-medium text-red-600">Requested:</span> 
                                                        <span class="font-bold text-gray-900"><?php echo e($item->quantity_requested); ?></span>
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        <span class="font-medium text-red-600">Approved:</span> 
                                                        <span class="font-bold text-gray-900"><?php echo e($item->quantity_approved ?? 'Pending'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500 italic">No equipment details available.</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Reservation Timeline -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                            <h3 class="text-lg font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Reservation Timeline
                            </h3>
                        </div>
                        <div class="px-6 py-6">
                            <div class="flow-root">
                                <ul class="-mb-8 pb-4">
                                    <!-- Created -->
                                    <li>
                                        <div class="relative pb-8">
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Reservation created</p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <?php echo e($reservation->created_at->format('M d, Y g:i A')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <?php if($reservation->approved_at): ?>
                                    <!-- Approved -->
                                    <li>
                                        <div class="relative pb-8">
                                            <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></div>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Reservation approved</p>
                                                        <?php if($reservation->approvedBy): ?>
                                                            <p class="text-xs text-gray-400">by <?php echo e($reservation->approvedBy->name); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <?php echo e($reservation->approved_at->format('M d, Y g:i A')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endif; ?>

                                    <?php if($reservation->picked_up_at): ?>
                                    <!-- Picked Up -->
                                    <li>
                                        <div class="relative pb-8">
                                            <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"></div>
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Equipment picked up</p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <?php echo e($reservation->picked_up_at->format('M d, Y g:i A')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endif; ?>

                                    <?php if($reservation->returned_at): ?>
                                    <!-- Returned -->
                                    <li>
                                        <div class="relative pb-2">
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Equipment returned</p>
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <?php echo e($reservation->returned_at->format('M d, Y g:i A')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Sidebar -->
                <div class="space-y-6">
                    <!-- Reservation Summary -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                            <h3 class="text-lg font-semibold text-red-800">Reservation Summary</h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Borrow Date and Time</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php if($reservation->borrow_date): ?>
                                        <div class="font-medium"><?php echo e(\Carbon\Carbon::parse($reservation->borrow_date)->format('M d, Y')); ?></div>
                                        <?php if($reservation->borrow_time): ?>
                                            <div class="text-gray-600"><?php echo e(\Carbon\Carbon::parse($reservation->borrow_time)->format('g:i A')); ?></div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-gray-400">Not set</span>
                                    <?php endif; ?>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Return Date and Time</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <?php if($reservation->return_date): ?>
                                        <div class="font-medium"><?php echo e(\Carbon\Carbon::parse($reservation->return_date)->format('M d, Y')); ?></div>
                                        <?php if($reservation->return_time): ?>
                                            <div class="text-gray-600"><?php echo e(\Carbon\Carbon::parse($reservation->return_time)->format('g:i A')); ?></div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-gray-400">Not set</span>
                                    <?php endif; ?>
                                </dd>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Information -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                            <h3 class="text-lg font-semibold text-red-800">Instructor Information</h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($reservation->name ?? 'N/A'); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($reservation->email ?? 'N/A'); ?></dd>
                            </div>
                            <?php if($reservation->contact_number): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Contact Number</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($reservation->contact_number); ?></dd>
                            </div>
                            <?php endif; ?>
                            <?php if($reservation->department): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Department</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($reservation->department); ?></dd>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <?php if($reservation->reason || $reservation->additional_details): ?>
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                        <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                            <h3 class="text-lg font-semibold text-red-800">Additional Details</h3>
                        </div>
                        <div class="px-6 py-4 space-y-4">
                            <?php if($reservation->reason): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Reason for Reservation</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($reservation->reason); ?></dd>
                            </div>
                            <?php endif; ?>
                            <?php if($reservation->additional_details): ?>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Additional Details</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($reservation->additional_details); ?></dd>
                            </div>
                            <?php endif; ?>
                        </div>
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
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv25\resources\views/instructor/reservations/show.blade.php ENDPATH**/ ?>