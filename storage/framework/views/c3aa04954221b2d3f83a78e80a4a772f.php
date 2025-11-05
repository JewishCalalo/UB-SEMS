<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Confirmation - SEMS</title>
    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/js/app.js',
        'resources/js/components/welcome.js',
        'resources/css/app.css',
        'resources/css/components/buttons.css',
        'resources/css/modules/auth.css',
        'resources/css/modules/welcome.css'
    ]); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
</head>
<body class="font-sans antialiased min-h-screen" style="background-image: url('<?php echo e(asset('images/Background.jpg')); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh;">
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

    <div class="min-h-screen flex flex-col">
    <div class="flex-1 py-8 sm:py-12 bg-black bg-opacity-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 sm:p-6">
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
                <div class="p-4 sm:p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Reservation Details</h3>
                        <p class="text-sm sm:text-base text-gray-600">Your equipment reservation has been submitted and is pending approval.</p>
                    </div>

                    <!-- Reservation Code -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 items-center">
                            <div>
                                <h4 class="font-medium text-blue-900">Reservation Code</h4>
                                <p class="text-sm text-blue-700">Use this code to track your reservation</p>
                            </div>
                            <div class="md:col-span-2 flex items-center justify-end gap-3">
                                <span class="text-2xl md:text-3xl font-bold text-blue-600 break-all"><?php echo e($reservation->reservation_code); ?></span>
                                <button type="button" id="copyReservationCodeBtn" data-code="<?php echo e($reservation->reservation_code); ?>" 
                                        class="group inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" 
                                        title="Copy reservation code">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                    </svg>
                                    <span class="text-sm font-medium">Copy Code</span>
                                </button>
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
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-500">Contact Number</label>
                                    <p class="text-sm text-gray-900"><?php echo e($reservation->contact_number); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if($reservation->department): ?>
                                <div class="md:col-span-2">
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
                                <p class="text-sm text-gray-900">
                                    <?php echo e($reservation->borrow_date->format('F d, Y')); ?>

                                    <?php if($reservation->borrow_time): ?>
                                        <span class="text-gray-600">at <?php echo e(\Carbon\Carbon::parse($reservation->borrow_time)->format('g:i A')); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Return Date</label>
                                <p class="text-sm text-gray-900">
                                    <?php echo e($reservation->return_date->format('F d, Y')); ?>

                                    <?php if($reservation->return_time): ?>
                                        <span class="text-gray-600">at <?php echo e(\Carbon\Carbon::parse($reservation->return_time)->format('g:i A')); ?></span>
                                    <?php endif; ?>
                                </p>
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
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Model / Brand</th>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category / Type</th>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Quantity</th>
                                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $brandModel = trim(($item->equipment->brand ?? '') . ' ' . ($item->equipment->model ?? ''));
                                        ?>
                                        <tr>
                                            <td class="px-3 sm:px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($brandModel ?: ($item->equipment->name ?? 'Equipment')); ?></div>
                                                <?php if($item->equipment->name && $brandModel): ?>
                                                    <div class="text-xs text-gray-500"><?php echo e($item->equipment->name); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-3 sm:px-6 py-4 text-sm text-gray-900">
                                                <?php echo e($item->equipment->category->name); ?> / <?php echo e(optional($item->equipment->equipmentType)->name ?? 'N/A'); ?>

                                            </td>
                                            <td class="px-3 sm:px-6 py-4 text-sm text-gray-900">
                                                <?php if(!is_null($item->quantity_approved) && $item->quantity_approved > 0): ?>
                                                    <?php echo e($item->quantity_approved); ?> <span class="text-xs text-gray-500">(Approved)</span>
                                                <?php else: ?>
                                                    <?php echo e($item->quantity_requested); ?>

                                                <?php endif; ?>
                                            </td>
                                            <td class="px-3 sm:px-6 py-4">
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

                    <!-- Status Timeline -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Status Timeline</h4>
                        <div class="space-y-4">
                            <!-- Submitted -->
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mt-2"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Reservation Submitted</p>
                                    <p class="text-sm text-gray-600"><?php echo e($reservation->created_at->format('M d, Y g:i A')); ?></p>
                                </div>
                            </div>

                            <!-- Approved -->
                            <?php if($reservation->approved_at): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-emerald-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Reservation Approved</p>
                                        <p class="text-sm text-gray-600"><?php echo e($reservation->approved_at->format('M d, Y g:i A')); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Scheduled Pickup (planned) -->
                            <?php if($reservation->pickup_date && in_array($reservation->status, ['approved','picked_up','returned','completed'])): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Scheduled Pickup</p>
                                        <p class="text-sm text-gray-600"><?php echo e(\Carbon\Carbon::parse($reservation->pickup_date)->format('M d, Y')); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Actual Pickup (actual) -->
                            <?php if($reservation->picked_up_at): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-blue-500 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Actual Pickup</p>
                                        <p class="text-sm text-gray-600"><?php echo e($reservation->picked_up_at->format('M d, Y g:i A')); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Actual Return (actual) -->
                            <?php if($reservation->returned_at): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-purple-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Actual Return</p>
                                        <p class="text-sm text-gray-600"><?php echo e($reservation->returned_at->format('M d, Y g:i A')); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Cancelled -->
                            <?php if($reservation->status === 'cancelled'): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-red-400 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Reservation Cancelled</p>
                                        <p class="text-sm text-gray-600"><?php echo e($reservation->cancelled_at ? $reservation->cancelled_at->format('M d, Y g:i A') : '—'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Completed -->
                            <?php if($reservation->completed_at): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-3 h-3 bg-green-600 rounded-full mt-2"></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Reservation Completed</p>
                                        <p class="text-sm text-gray-600"><?php echo e($reservation->completed_at->format('M d, Y g:i A')); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
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
                            <p>• When picking up the equipment, please bring a valid school ID. The PE Office will hold the ID during the borrowing period and return it once all items are brought back.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="<?php echo e(route('reservations.track')); ?>" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Track Your Reservation
                        </a>
                        
                        <?php if($reservation->status === 'pending'): ?>
                        <button type="button"
                                onclick="showCancelConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->reservation_code); ?>')"
                                class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel Reservation
                        </button>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('welcome')); ?>" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Back to Home
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

    <!-- Footer -->
    <?php if (isset($component)) { $__componentOriginal222c87a019257fb1d70ae0ff46ab02e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.site-footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1)): ?>
<?php $attributes = $__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1; ?>
<?php unset($__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal222c87a019257fb1d70ae0ff46ab02e1)): ?>
<?php $component = $__componentOriginal222c87a019257fb1d70ae0ff46ab02e1; ?>
<?php unset($__componentOriginal222c87a019257fb1d70ae0ff46ab02e1); ?>
<?php endif; ?>
    </div>

    <!-- SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Clear homepage reservation cart after successful confirmation
        try {
            localStorage.removeItem('sems_reservation');
            // Broadcast an event so any listeners can refresh UI
            window.dispatchEvent(new CustomEvent('sems:cartCleared', { detail: { source: 'guest-confirmation' } }));
        } catch (e) { /* noop */ }
    </script>
    
    <!-- Cancel Reservation Modal Script -->
    <script>
        // Copy reservation code to clipboard with feedback
        (function(){
            const btn = document.getElementById('copyReservationCodeBtn');
            if (!btn) return;
            btn.addEventListener('click', async () => {
                const code = btn.getAttribute('data-code');
                try {
                    await navigator.clipboard.writeText(code);
                    // Show visual feedback on button
                    const originalHTML = btn.innerHTML;
                    btn.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm font-medium">Copied!</span>
                    `;
                    btn.className = 'group inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg shadow-md cursor-not-allowed';
                    
                    // Reset after 2 seconds
                    setTimeout(() => {
                        btn.innerHTML = originalHTML;
                        btn.className = 'group inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2';
                    }, 2000);
                } catch (e) {
                    alert('Copy failed. Please copy manually.');
                }
            });
        })();
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
                                    <h3 class="font-semibold text-red-800 mb-2">⚠️ Confirmation Required</h3>
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
                                    Your reservation will be marked as cancelled
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Reserved equipment will be released back to available inventory
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    You will receive a confirmation email
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
                        // Redirect to homepage after cancellation for guest flow
                        window.location.href = '/';
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
<?php /**PATH C:\UB-SEMS\resources\views\user\reservations\guest-confirmation.blade.php ENDPATH**/ ?>