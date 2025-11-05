<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/ub-logo.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/ub-logo.png')); ?>">

    <title><?php echo e(config('app.name', 'SEMS')); ?> - Track Reservation</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/js/app.js',
        'resources/js/components/welcome.js',
        'resources/css/app.css',
        'resources/css/components/buttons.css',
        'resources/css/modules/auth.css',
        'resources/css/modules/welcome.css',
        'resources/css/sweetalert2-custom.css'
        
    ]); ?>
</head>
<body class="font-sans antialiased public-page">
    <!-- Navigation -->
    <?php if (isset($component)) { $__componentOriginal27f402f979cba4f345c18ac5d011cb75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27f402f979cba4f345c18ac5d011cb75 = $attributes; } ?>
<?php $component = App\View\Components\WelcomeNavigation::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome-navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\WelcomeNavigation::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27f402f979cba4f345c18ac5d011cb75)): ?>
<?php $attributes = $__attributesOriginal27f402f979cba4f345c18ac5d011cb75; ?>
<?php unset($__attributesOriginal27f402f979cba4f345c18ac5d011cb75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27f402f979cba4f345c18ac5d011cb75)): ?>
<?php $component = $__componentOriginal27f402f979cba4f345c18ac5d011cb75; ?>
<?php unset($__componentOriginal27f402f979cba4f345c18ac5d011cb75); ?>
<?php endif; ?>

    <div class="py-8 min-h-screen flex items-center justify-center relative">
        <!-- Background overlay for better readability -->
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 w-full relative z-10">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-200">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-white flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Track Your Reservation
                        </h2>
                        <p class="text-red-100 text-sm mt-1">Enter your reservation code to check the status of your equipment reservation</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8 text-gray-900">
                    
                    <?php if(session('success')): ?>
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-3 py-2 rounded text-sm" role="alert">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Search Form -->
                    <form method="GET" action="<?php echo e(route('reservations.track')); ?>" class="mb-6">
                        <div class="flex items-start space-x-3">
                            <div class="flex-1">
                                <label for="reservation_code" class="block text-sm font-medium text-gray-700 mb-1">
                                    Reservation Code
                                </label>
                                <input type="text" 
                                       name="reservation_code" 
                                       id="reservation_code" 
                                       value="<?php echo e(request('reservation_code')); ?>"
                                       placeholder="e.g., RES-ABC12345"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500 text-sm">
                                <p class="mt-1 text-xs text-gray-500">
                                    Enter the reservation code you received when you submitted your reservation.
                                </p>
                            </div>
                            <div class="flex flex-col justify-end" style="margin-top: 1.5rem;">
                                <button type="submit" 
                                        class="actions__button actions__button--dropdown h-10">
                                    Track
                                </button>
                            </div>
                        </div>
                    </form>

                    <?php if($error): ?>
                        <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-4 w-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-2">
                                    <h3 class="text-sm font-medium text-red-800">Reservation Not Found</h3>
                                    <div class="mt-1 text-sm text-red-700">
                                        <?php echo e($error); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($reservation): ?>
                        <!-- Reservation Details -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Reservation #<?php echo e($reservation->reservation_code); ?>

                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Submitted on <?php echo e($reservation->created_at->format('M d, Y \a\t g:i A')); ?>

                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        <?php if($reservation->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($reservation->status === 'approved'): ?> bg-green-100 text-green-800
                                        <?php elseif($reservation->status === 'denied'): ?> bg-red-100 text-red-800
                                        <?php elseif($reservation->status === 'picked_up'): ?> bg-blue-100 text-blue-800
                                        <?php elseif($reservation->status === 'returned'): ?> bg-gray-100 text-gray-800
                                        <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $reservation->status))); ?>

                                    </span>
                                </div>
                            </div>

                            <!-- Borrower Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Borrower Information</h4>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p><strong>Name:</strong> <?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?></p>
                                        <p><strong>Email:</strong> <?php echo e($reservation->user ? $reservation->user->email : ($reservation->email ?? 'No email')); ?></p>
                                        <?php if($reservation->user && $reservation->user->contact_number): ?>
                                            <p><strong>Contact:</strong> <?php echo e($reservation->user->contact_number); ?></p>
                                        <?php endif; ?>
                                        <?php if($reservation->user && $reservation->user->department): ?>
                                            <p><strong>Department:</strong> <?php echo e($reservation->user->department); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Reservation Details</h4>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p><strong>Borrow Date:</strong> <?php echo e($reservation->borrow_date->format('M d, Y')); ?></p>
                                        <p><strong>Return Date:</strong> <?php echo e($reservation->return_date->format('M d, Y')); ?></p>
                                        <p><strong>Reason:</strong> <?php echo e($reservation->reason); ?></p>
                                        <?php if($reservation->additional_details): ?>
                                            <p><strong>Additional Details:</strong> <?php echo e($reservation->additional_details); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipment Items (with inline editing while pending) -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900">Equipment Requested</h4>
                                    <?php if($reservation->status === 'pending'): ?>
                                        <button type="button" onclick="openEditReservationModal()" title="Edit Reservation"
                                                class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-xl shadow-sm bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Edit Reservation
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div class="space-y-2" id="trackReservationItems">
                                    <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex justify-between items-center p-3 bg-white rounded border shadow-sm">
                                            <div>
                                                <?php $brandModel = trim(($item->equipment->brand ?? '') . ' ' . ($item->equipment->model ?? '')); ?>
                                                <p class="font-semibold text-gray-900"><?php echo e($brandModel ?: ($item->equipment->name ?? 'Equipment')); ?></p>
                                                <p class="text-xs text-gray-600"><?php echo e($item->equipment->name ?? $item->equipment->category->name); ?></p>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-800">Qty: <?php echo e($item->quantity_requested); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php if($reservation->status === 'pending'): ?>
                                    <p class="text-xs text-gray-500 mt-1">Edit is available via the Edit Reservation button.</p>
                                <?php endif; ?>
                            </div>

                            <!-- Status Timeline -->
                            <div>
                                <h4 class="font-medium text-gray-900 mb-2">Status Timeline</h4>
                                <div class="space-y-3">
                                    <!-- Reservation Submitted - Always shown -->
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="w-3 h-3 bg-green-400 rounded-full mt-2"></div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Reservation Submitted</p>
                                            <p class="text-sm text-gray-600"><?php echo e($reservation->created_at->format('M d, Y \a\t g:i A')); ?></p>
                                        </div>
                                    </div>

                                    <!-- Approval/Denial - Show if approved_at exists -->
                                    <?php if($reservation->approved_at): ?>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-3 h-3 
                                                    <?php if($reservation->status === 'approved'): ?> bg-green-400
                                                    <?php elseif($reservation->status === 'denied'): ?> bg-red-400
                                                    <?php else: ?> bg-gray-400 <?php endif; ?> rounded-full mt-2"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    Reservation <?php echo e(ucfirst($reservation->status)); ?>

                                                    <?php if($reservation->approvedBy): ?>
                                                        by <?php echo e($reservation->approvedBy->name); ?>

                                                    <?php endif; ?>
                                                </p>
                                                <p class="text-sm text-gray-600"><?php echo e($reservation->approved_at->format('M d, Y \a\t g:i A')); ?></p>
                                                <?php if($reservation->remarks): ?>
                                                    <p class="text-sm text-gray-600 mt-1"><?php echo e($reservation->remarks); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Pickup Date Set - Show if pickup_date exists and reservation is approved or picked up -->
                                    <?php if($reservation->pickup_date && in_array($reservation->status, ['approved', 'picked_up', 'returned', 'completed'])): ?>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-3 h-3 bg-blue-400 rounded-full mt-2"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Pickup Date Set</p>
                                                <p class="text-sm text-gray-600"><?php echo e($reservation->pickup_date->format('M d, Y')); ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Equipment Picked Up - Show if picked_up_at exists -->
                                    <?php if($reservation->picked_up_at): ?>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-3 h-3 bg-blue-400 rounded-full mt-2"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Equipment Picked Up</p>
                                                <p class="text-sm text-gray-600"><?php echo e($reservation->picked_up_at->format('M d, Y \a\t g:i A')); ?></p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Equipment Returned - Show if returned_at exists -->
                                    <?php if($reservation->returned_at): ?>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-3 h-3 bg-purple-400 rounded-full mt-2"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Equipment Returned</p>
                                                <p class="text-sm text-gray-600"><?php echo e($reservation->returned_at->format('M d, Y \a\t g:i A')); ?></p>
                                                <p class="text-xs text-gray-500 mt-1">Equipment has been returned and is being processed</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Reservation Completed - Show if status is completed -->
                                    <?php if($reservation->status === 'completed'): ?>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-3 h-3 bg-green-600 rounded-full mt-2"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Reservation Completed</p>
                                                <p class="text-sm text-gray-600">All equipment processed and returned</p>
                                                <p class="text-xs text-gray-500 mt-1">This reservation is now fully closed</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Cancelled - Show if status is cancelled -->
                                    <?php if($reservation->status === 'cancelled'): ?>
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div class="w-3 h-3 bg-red-400 rounded-full mt-2"></div>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Reservation Cancelled</p>
                                                <p class="text-sm text-gray-600">
                                                    <?php if($reservation->cancelled_at): ?>
                                                        <?php echo e($reservation->cancelled_at->format('M d, Y \a\t g:i A')); ?>

                                                    <?php else: ?>
                                                        Cancelled
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Cancel Reservation Button -->
                            <?php if(in_array($reservation->status, ['pending', 'approved'])): ?>
                                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-red-900 mb-1">Need to Cancel?</h4>
                                            <p class="text-sm text-red-700">
                                                You can cancel your reservation if your plans have changed. This action cannot be undone.
                                            </p>
                                        </div>
                                        <button onclick="showCancelConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->reservation_code); ?>')"
                                                class="actions__button actions__button--dropdown px-5 py-3 rounded-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold whitespace-normal leading-tight text-center max-w-full sm:max-w-[14rem]">
                                            <span class="hidden sm:inline">Cancel Reservation</span>
                                            <span class="inline sm:hidden">Cancel</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Next Steps -->
                            <?php if($reservation->status === 'pending'): ?>
                                <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-blue-900 mb-2">What's Next?</h4>
                                    <div class="text-sm text-blue-800 space-y-2">
                                                <p><strong>Review in Progress:</strong> PE Office staff are currently reviewing your reservation request and checking equipment availability.</p>
                                                <p><strong>Email Notification:</strong> You'll receive an email update within 24-48 hours with the approval status.</p>
                                                <p><strong>Track Status:</strong> Check back here anytime using your reservation code <code class="bg-blue-100 px-1 rounded text-xs"><?php echo e($reservation->reservation_code); ?></code> to see updates.</p>
                                                <p><strong>Need Changes?</strong> Use the "Edit Reservation" button above for equipment changes, or contact the office for date/reason modifications.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif($reservation->status === 'approved'): ?>
                                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-0.5">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-green-900 mb-2">Reservation Approved! 🎉</h4>
                                            <div class="text-sm text-green-800 space-y-2">
                                                <p><strong>Pickup Instructions:</strong> Visit the PE Office during business hours (8:00 AM - 5:00 PM) on your scheduled borrow date.</p>
                                                <p><strong>What to Bring:</strong> Valid University ID, and be prepared to provide collateral if required by office policy.</p>
                                                <p><strong>Return Schedule:</strong> Equipment must be returned by <?php echo e($reservation->return_date->format('M d, Y')); ?> during business hours.</p>
                                                <p><strong>Contact Info:</strong> For questions or schedule changes, contact the Physical Education Office directly.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif($reservation->status === 'denied'): ?>
                                <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mt-0.5">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-red-900 mb-2">Reservation Request Denied</h4>
                                            <div class="text-sm text-red-800 space-y-2">
                                                <p><strong>Status:</strong> Unfortunately, your reservation could not be approved at this time.</p>
                                                <p><strong>Common Reasons:</strong> Equipment unavailable, conflicting reservations, or policy restrictions.</p>
                                                <p><strong>Next Steps:</strong> Contact the Physical Education Office for specific details and alternative options.</p>
                                                <p><strong>Resubmit:</strong> You can submit a new reservation with different dates or equipment if needed.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Help Section -->
                    <div class="mt-6 bg-gray-50 rounded-lg p-4">
                        <h3 class="text-base font-medium text-gray-900 mb-3">Need Help?</h3>
                        <div class="text-sm text-gray-600 space-y-3">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <strong>Lost your reservation code?</strong><br>
                                    <span class="text-gray-500">Contact the Physical Education Office at UB Main Campus or check your email confirmation.</span>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <div>
                                    <strong>Questions about equipment availability?</strong><br>
                                    <span class="text-gray-500">Browse our equipment catalog to see real-time availability and add items to your wishlist.</span>
                        </div>
                            </div>
                            
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 109.75 9.75c0-.218-.007-.435-.021-.65A9.75 9.75 0 0012 2.25z"/>
                                </svg>
                                <div>
                                    <strong>Need to modify your reservation?</strong><br>
                                    <span class="text-gray-500">For major changes (dates, reason), contact the office. For equipment changes, use the Edit button while pending.</span>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-purple-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <strong>Staff login or technical issues?</strong><br>
                                    <span class="text-gray-500">Contact the system administrator or the Physical Education Office for assistance.</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-gray-200">
                            <a href="<?php echo e(route('equipment.index')); ?>" 
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Browse Equipment Catalog
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Reservation Modal Script -->
    <script>
        <?php if($reservation): ?>
        const RES_ID = <?php echo e($reservation->id); ?>;
        <?php endif; ?>

        function openEditReservationModal(){
            <?php
                $editItems = $reservation ? $reservation->items->map(function($i){
                    $label = trim(($i->equipment->brand ?? '') . ' ' . ($i->equipment->model ?? ''));
                    if ($label === '') { $label = $i->equipment->name ?? 'Equipment'; }
                    return [
                        'id' => $i->id,
                        'equipment_id' => $i->equipment_id,
                        'equipment' => $label,
                        'qty' => $i->quantity_requested,
                    ];
                })->values()->all() : [];
            ?>
            const items = <?php echo json_encode($editItems, 15, 512) ?>;
            const equipmentList = (<?php echo json_encode($equipmentList ?? [], 15, 512) ?>)
                .filter(e => Number(e.available || 0) > 0); // hide unavailable
            const availabilityMap = Object.fromEntries((equipmentList || []).map(e => [String(e.id), Number(e.available || 0)]));

            const html = `
                <!-- Enhanced Header with Full-Width Gradient -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-t-lg" style="margin: -24px -24px 0 -24px; padding: 20px 24px;">
                    <div class="relative text-center">
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            <h2 class="text-2xl font-bold tracking-tight">Edit Reservation</h2>
                        </div>
                        <p class="text-blue-100 text-sm max-w-lg mx-auto leading-relaxed">
                            Modify your equipment selection and quantities. Changes are saved in real-time to your reservation.
                        </p>
                        <button id=\"edit_close\" class=\"absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 transition-all duration-200 flex items-center justify-center text-xl font-medium\" onclick=\"Swal.close()\">×</button>
                    </div>
                </div>

                <!-- Main Content with Improved Layout -->
                <div class="px-6 pt-4 pb-6 max-h-[75vh] overflow-auto">
                    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
                        <!-- Equipment Selection Panel -->
                        <div class="xl:col-span-3 space-y-4">
                            <!-- Search Section -->
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200">
                                <div class="flex items-center gap-3 mb-3">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                                    </svg>
                                    <h3 class="font-semibold text-gray-900">Browse Equipment</h3>
                </div>
                                <div class="relative">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                                    </svg>
                                    <input id="equip_search" type="text" placeholder="Search by equipment name or category..." 
                                           class="pl-10 pr-4 py-3 w-full border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white shadow-sm font-medium text-gray-900 placeholder-gray-500">
                            </div>
                            </div>

                            <!-- Equipment Grid -->
                            <div id="equip_grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                ${equipmentList.map(e=>`
                                    <div class="group border border-gray-200 rounded-2xl p-5 bg-white shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 cursor-pointer">
                                        <div class="flex items-start justify-between gap-3 mb-4">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900 truncate mb-1" title="${e.label}">${e.label}</h4>
                                                <p class="text-sm text-gray-600 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                                                    </svg>
                                                    ${e.category || 'Equipment'}
                                                </p>
                                            </div>
                                            <div class="flex flex-col items-end gap-1">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ${e.available>0 ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-500 border border-gray-200'}">
                                                    ${e.available} Available
                                                </span>
                                        </div>
                                        </div>
                                        <div class="flex items-end gap-3">
                                            <div class="flex-1">
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Quantity</label>
                                                <input type="number" min="1" value="1" ${e.available?`max="${e.available}"`:''} 
                                                       class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm sel-qty focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-medium text-center">
                                            </div>
                                            <button data-id="${e.id}" data-label="${e.label}" data-avail="${e.available}" 
                                                    class="flex-shrink-0 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 ${e.available>0?'bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md':'bg-gray-200 text-gray-400 cursor-not-allowed'} sel-add" 
                                                    ${e.available>0?'':'disabled'}>
                                                Add
                                            </button>
                                        </div>
                                    </div>`).join('')}
                            </div>
                        </div>

                        <!-- Enhanced Reservation Summary Panel -->
                        <div class="xl:col-span-2 sticky-summary">
                            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm">
                                <!-- Summary Header -->
                                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-4 border-b border-gray-200 rounded-t-2xl">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900">Reservation Summary</h3>
                                </div>
                                    <p class="text-sm text-gray-600 mt-1">Items in your current reservation</p>
                                </div>

                                <!-- Summary Content -->
                                <div id="edit_rows" class="divide-y divide-gray-100 min-h-[200px]">
                                    ${items.length ? items.map(it=>`
                                        <div class="group flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors" data-id="${it.id}" data-eid="${it.equipment_id}">
                                            <div class="flex-1 pr-3">
                                                <h4 class="font-medium text-gray-900 truncate" title="${it.equipment}">${it.equipment}</h4>
                                                <p class="text-sm text-gray-500 mt-1">Reserved item</p>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <div class="text-center">
                                                    <label class="block text-xs font-medium text-gray-700 mb-1">Qty</label>
                                                    <input type="number" min="1" ${availabilityMap[String(it.equipment_id)]!==undefined?`max="${availabilityMap[String(it.equipment_id)]}"`:''} 
                                                           value="${it.qty}" class="w-16 text-center border border-gray-300 rounded-lg px-2 py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <button type="button" aria-label="Remove item" title="Remove from reservation" 
                                                        class="remove-row p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>`).join('') : `
                                        <div class="px-5 py-12 text-center">
                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p class="text-gray-500 font-medium">No items selected yet</p>
                                            <p class="text-sm text-gray-400 mt-1">Browse equipment on the left to add items</p>
                                        </div>`}
                                </div>

                                <!-- Summary Footer -->
                                <div class="px-5 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-sm font-medium text-gray-700">Total Items:</span>
                                        <span id="summary_count" class="text-lg font-bold text-gray-900">${items.reduce((n,i)=>n+Number(i.qty||0),0)}</span>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <button id="edit_undo" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            <span>Reset Changes</span>
                                        </button>
                                        <button id="edit_save" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Save Changes</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            Swal.fire({
                buttonsStyling:false,
                width: 'auto',
                html: html,
                showConfirmButton:false,
                customClass:{ popup:'swal-custom-popup swal-edit-reservation' }
            });

            const popup = Swal.getPopup();
            const rowsEl = popup.querySelector('#edit_rows');
            const summaryCount = ()=>{ const total=[...rowsEl.querySelectorAll('input[type=number]')].reduce((n,i)=>n+(parseInt(i.value||'0',10)||0),0); popup.querySelector('#summary_count').textContent = `Total items: ${total}`; };

            // Helper: render original snapshot back into summary (Undo)
            function renderRowsFromSnapshot(snapshot){
                rowsEl.innerHTML = '';
                if (!Array.isArray(snapshot) || snapshot.length === 0) {
                    rowsEl.innerHTML = `<div class="px-5 py-12 text-center">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="text-gray-500 font-medium">No items selected yet</p>
                        <p class="text-sm text-gray-400 mt-1">Browse equipment on the left to add items</p>
                    </div>`;
                    summaryCount();
                    return;
                }
                const html = snapshot.map(it => {
                    const maxAttr = (availabilityMap[String(it.equipment_id)]!==undefined) ? `max="${availabilityMap[String(it.equipment_id)]}"` : '';
                    return `<div class=\"group flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors\" data-id=\"${it.id}\" data-eid=\"${it.equipment_id}\">`
                        + `<div class=\"flex-1 pr-3\">`
                        + `<h4 class=\"font-medium text-gray-900 truncate\" title=\"${it.equipment}\">${it.equipment}</h4>`
                        + `<p class=\"text-sm text-gray-500 mt-1\">Reserved item</p>`
                        + `</div>`
                        + `<div class=\"flex items-center gap-3\">`
                        + `<div class=\"text-center\">`
                        + `<label class=\"block text-xs font-medium text-gray-700 mb-1\">Qty</label>`
                        + `<input type=\"number\" min=\"1\" ${maxAttr} value=\"${it.qty}\" class=\"w-16 text-center border border-gray-300 rounded-lg px-2 py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500\">`
                        + `</div>`
                        + `<button type=\"button\" aria-label=\"Remove item\" title=\"Remove from reservation\" class=\"remove-row p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200\">`
                        + `<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\"/></svg>`
                        + `</button>`
                        + `</div>`
                        + `</div>`;
                }).join('');
                rowsEl.innerHTML = html;
                wireRemovers();
                summaryCount();
            }
            const wireRemovers = ()=> rowsEl.querySelectorAll('.remove-row').forEach(b=> b.onclick = ()=> { b.closest('[data-id]').remove(); summaryCount(); });
            wireRemovers(); summaryCount();

            // Add from selector grid
            popup.querySelectorAll('.sel-add').forEach(btn=>{
                btn.onclick = ()=>{
                    if (btn.hasAttribute('disabled')) return;
                    const card = btn.closest('.border');
                    const qtyInput = card.querySelector('.sel-qty');
                    const maxAvail = parseInt(btn.getAttribute('data-avail')||'0',10);
                    let qty = Math.max(1, parseInt(qtyInput.value||'1',10));
                    if (maxAvail && qty > maxAvail) { qty = maxAvail; qtyInput.value = String(qty); }
                    const label = btn.getAttribute('data-label');
                    const equipId = btn.getAttribute('data-id');
                    
                    // Check if equipment already exists in summary
                    const existingRow = rowsEl.querySelector(`[data-eid="${equipId}"]`);
                    if (existingRow) {
                        // Equipment already exists, update quantity instead of creating duplicate
                        const existingQtyInput = existingRow.querySelector('input[type="number"]');
                        if (existingQtyInput) {
                            const currentQty = parseInt(existingQtyInput.value || '0', 10);
                            const newQty = Math.min(currentQty + qty, maxAvail || 999);
                            existingQtyInput.value = String(newQty);
                            summaryCount();
                            
                            // Show feedback that quantity was updated
                            existingRow.style.backgroundColor = '#dbeafe';
                            setTimeout(() => {
                                existingRow.style.backgroundColor = '';
                            }, 1000);
                        }
                        return;
                    }
                    
                    // Create new row only if equipment doesn't exist
                    const row = document.createElement('div');
                    row.setAttribute('data-new','1'); row.setAttribute('data-eid', equipId);
                    row.className = 'group flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors';
                    row.innerHTML = `
                        <div class="flex-1 pr-3">
                            <h4 class="font-medium text-gray-900 truncate" title="${label}">${label}</h4>
                            <p class="text-sm text-gray-500 mt-1">New item</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-center">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Qty</label>
                                <input type="number" min="1" value="${qty}" class="w-16 text-center border border-gray-300 rounded-lg px-2 py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <button type="button" aria-label="Remove item" title="Remove from reservation" class="remove-row p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <input type="hidden" class="eq-id" value="${equipId}">
                        </div>`;
                    rowsEl.appendChild(row); wireRemovers(); summaryCount();
                };
            });

            // Clamp typing in selector qty fields to max availability
            popup.querySelectorAll('.sel-qty').forEach(inp => {
                inp.addEventListener('input', function(){
                    let v = parseInt(this.value||'1',10); if (isNaN(v) || v < 1) v = 1;
                    const max = parseInt(this.dataset.avail||this.getAttribute('max')||'0',10);
                    if (max && v > max) v = max; this.value = String(v);
                });
            });

            // Clamp any manual edits in summary to >=1
            rowsEl.addEventListener('input', (e)=>{
                if (e.target && e.target.matches('input[type=number]')) {
                    let v = parseInt(e.target.value||'1',10); if (isNaN(v) || v < 1) v = 1;
                    const row = e.target.closest('[data-eid]');
                    const eid = row ? row.getAttribute('data-eid') : (e.target.closest('[data-new]')?.querySelector('.eq-id')?.value);
                    const max = eid && availabilityMap[String(eid)] !== undefined ? parseInt(availabilityMap[String(eid)],10) : 0;
                    if (max && v > max) v = max;
                    e.target.value = String(v);
                    summaryCount();
                }
            });

            // Search filter
            popup.querySelector('#equip_search').addEventListener('input', (e)=>{
                const q = e.target.value.toLowerCase();
                popup.querySelectorAll('#equip_grid > div').forEach(card=>{
                    const text = card.querySelector('.font-medium')?.textContent.toLowerCase() || card.textContent.toLowerCase();
                    card.style.display = text.includes(q) ? '' : 'none';
                });
            });

            const close = ()=> Swal.close();
            // Capture original snapshot of items (existing reservation items)
            const ORIGINAL_SNAPSHOT = items.map(it => ({ id: it.id, equipment_id: it.equipment_id, equipment: it.equipment, qty: it.qty }));

            // Undo: restore snapshot and keep modal open
            popup.querySelector('#edit_undo').onclick = () => {
                renderRowsFromSnapshot(ORIGINAL_SNAPSHOT);
            };

            popup.querySelector('#edit_save').onclick = async ()=>{
                const summaryRows = Array.from(rowsEl.children).filter(el => el.hasAttribute('data-id') || el.hasAttribute('data-new'));
                // If empty, warn about cancellation
                if (summaryRows.length === 0) {
                    if (window.Swal) {
                        // Close the edit overlay first so the alert is on top and the background is accessible
                        close();
                        Swal.fire({
                            buttonsStyling:false,
                            html:`
                                <div class="bg-red-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">No Equipment Selected</h2></div>
                                <div class="text-left">
                                    <p class="text-sm text-gray-700">Your summary is empty. Proceeding will cancel this reservation. This action cannot be undone.</p>
                                </div>
                                <div class="flex justify-end mt-6 gap-2">
                                    <button class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded" id="keep_editing_btn">Keep Editing</button>
                                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded" id="proceed_cancel_btn">Proceed Anyway</button>
                                </div>
                            `,
                            showConfirmButton:false,
                            customClass:{ popup:'swal-custom-popup' },
                            zIndex: 12000
                        });
                        // Wire custom buttons
                        const keep = document.getElementById('keep_editing_btn');
                        const proceed = document.getElementById('proceed_cancel_btn');
                        keep && (keep.onclick = ()=> { Swal.close(); openEditReservationModal(); });
                        proceed && (proceed.onclick = async ()=>{
                            // Loading modal
                            Swal.fire({
                                buttonsStyling:false,
                                html:`<div class="bg-red-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">Cancelling...</h2></div>
                                      <div class="p-4 text-center text-sm text-gray-700">Please wait while we cancel your reservation.</div>`,
                                allowOutsideClick:false,
                                didOpen:()=>{ Swal.showLoading(); },
                                zIndex: 12000
                            });
                            try {
                                const r = await fetch(`/reservations/${RES_ID}/cancel`, { method:'POST', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=\"csrf-token\"]').content }, body: JSON.stringify({})});
                                const d = await r.json();
                                Swal.close();
                                if(d && d.success){
                                    Swal.fire({
                                        buttonsStyling:false,
                                        html:`<div class=\"bg-green-600 text-white p-4 -m-6 mb-4 rounded-t-lg\"><h2 class=\"text-xl font-bold text-center\">Reservation Cancelled</h2></div>
                                              <div class=\"p-4 text-center text-sm text-gray-700\">Your reservation has been cancelled.</div>`,
                                        showConfirmButton:false,
                                        timer:1400,
                                        zIndex: 12000
                                    }).then(()=>{ window.location.href = '/'; });
                                } else {
                                    Swal.fire({title:'Error', text:(d && d.message) || 'Failed to cancel reservation. Please try again.', icon:'error', zIndex:12000});
                                }
                            } catch (e) {
                                Swal.close();
                                Swal.fire({title:'Error', text:'Failed to cancel reservation. Please try again.', icon:'error', zIndex:12000});
                            }
                        });
                    }
                    return; // Stop normal save flow
                }

                const trs = Array.from(rowsEl.querySelectorAll('tr,[data-id],[data-new]'));
                const existingIds = <?php echo json_encode($reservation ? $reservation->items->pluck('id') : collect(), 15, 512) ?>;
                const stillIds = trs.map(tr=> tr.dataset.id).filter(Boolean);
                const toRemove = existingIds.filter(id=> !stillIds.includes(String(id)));
                for(const id of toRemove){
                    const r = await fetch(`/reservations/${RES_ID}/items/${id}`, { method:'POST', headers:{ 'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=\"csrf-token\"]').content }, body: JSON.stringify({})});
                    let d; try { d = await r.json(); } catch(e){ d = { success:false, message:'Unexpected response' }; }
                    Swal.close();
                    if(!d.success){ alert(d.message||'Failed to remove item'); return; }
                    if(d.cancelled){ close(); if(window.Swal){ Swal.fire('Reservation Cancelled','Your reservation was cancelled because it has no items left.','success'); } location.reload(); return; }
                }
                for(const tr of trs){
                    const qty = parseInt(tr.querySelector('input[type=number]').value||'1',10);
                    if(tr.dataset.id){
                        const r = await fetch(`/reservations/${RES_ID}/items/${tr.dataset.id}/quantity`, { method:'POST', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=\"csrf-token\"]').content }, body: JSON.stringify({ quantity: qty })});
                        const d = await r.json(); if(!d.success){ alert(d.message||'Unable to update quantity'); return; }
                    }else{
                        const eid = tr.querySelector('.eq-id').value;
                        const r = await fetch(`/reservations/${RES_ID}/items`, { method:'POST', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=\"csrf-token\"]').content }, body: JSON.stringify({ equipment_id: eid, quantity: qty })});
                        const d = await r.json(); if(!d.success){ alert(d.message||'Failed to add equipment'); return; }
                    }
                }
                close();
                if (window.Swal) {
                    Swal.fire({
                        buttonsStyling:false,
                        html:`
                            <div class="bg-green-600 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">Saved</h2></div>
                            <div class="p-2 text-center text-gray-700">Reservation updated successfully.</div>
                        `,
                        showConfirmButton:true,
                        confirmButtonText:'OK',
                        customClass:{ popup:'swal-custom-popup' },
                        confirmButtonColor:'#16a34a'
                    }).then(()=>{ location.reload(); });
                } else {
                    location.reload();
                }
            };
        }
        // Show add equipment modal (simple selector with quantity)
        function showAddEquipmentModal(){
            const list = <?php echo json_encode($equipmentList ?? [], 15, 512) ?>;
            let options = '';
            list.forEach(e => { options += `<option value="${e.id}">${e.label}${e.category? ' • '+e.category : ''}</option>`; });
            Swal.fire({
                buttonsStyling:false,
                html:`
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold">Add Equipment</h2></div>
                    <div class="text-left">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select equipment</label>
                        <select id="add_equipment_select" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">${options}</select>
                        <label class="block text-sm font-medium text-gray-700 mt-3 mb-1">Quantity</label>
                        <input id="add_equipment_qty" type="number" min="1" value="1" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div class="flex justify-end mt-6 gap-2">
                        <button class="px-4 py-2 bg-gray-500 text-white rounded" onclick="Swal.close()">Cancel</button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded" onclick="submitAdd()">Add</button>
                    </div>
                `,
                showConfirmButton:false,
                width:'520px',
                customClass:{ popup:'swal-custom-popup' }
            });
        }

        function submitAdd(){ /* no-op, moved into edit modal */ }

        function removeItem(itemId){ /* no-op in read-only mode */ }

        function editQty(itemId, currentQty, label){
            Swal.fire({
                buttonsStyling:false,
                html:`
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold">Edit Quantity</h2></div>
                    <div class="text-left">
                        <p class="text-sm text-gray-700 mb-2"><strong>${label}</strong></p>
                        <input id="qty_edit_input" type="number" min="1" value="${currentQty}" class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div class="flex justify-end mt-6 gap-2">
                        <button class="px-4 py-2 bg-gray-500 text-white rounded" onclick="Swal.close()">Cancel</button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded" onclick="(function(){ const v = parseInt(document.getElementById('qty_edit_input').value||'1',10); changeQty(${itemId}, v); })()">Save</button>
                    </div>
                `,
                showConfirmButton:false,
                width:'420px',
                customClass:{ popup:'swal-custom-popup' }
            });
        }

        function changeQty(itemId, qty){ /* no-op in read-only mode */ }

        function showCancelConfirmation(reservationId, reservationCode) {
            Swal.fire({
                buttonsStyling: false,
                html: `
                    <div class="bg-gradient-to-r from-red-600 to-pink-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Cancel Reservation</h2>
                    </div>
                    <div class="text-left">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <div class="flex items-start gap-3">
                                <div class="p-1 bg-red-100 rounded">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-red-800 mb-2">Confirmation Required</h3>
                                    <p class="text-red-700 text-sm">Are you sure you want to cancel reservation <strong>#${reservationCode}</strong>? This action cannot be undone.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-800">What will happen:</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Reservation status will be updated to "cancelled"
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Equipment instances will be restored to available status (if already approved)
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    System will log the cancellation with timestamp
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Email notification will be sent about the cancellation
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                            Keep Reservation
                        </button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-red-600 to-pink-600 text-white rounded-lg hover:from-red-700 hover:to-pink-700 transition-all transform hover:scale-105" onclick="cancelReservation('${reservationId}')">
                            Cancel Reservation
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

        function cancelReservation(reservationId) {
            // Show loading state
            Swal.fire({
                title: 'Cancelling Reservation...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send cancellation request
            fetch(`/reservations/${reservationId}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Reservation Cancelled!',
                        text: 'Your reservation has been successfully cancelled. You will receive a confirmation email shortly.',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Reload the page to show updated status
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Failed to cancel reservation. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while cancelling the reservation. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\UB-SEMS\resources\views\user\reservations\track.blade.php ENDPATH**/ ?>