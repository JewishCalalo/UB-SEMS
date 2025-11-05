<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

        <title><?php echo e(config('app.name', 'SEMS')); ?></title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('images/ub-logo.png')); ?>">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/ub-logo.png')); ?>">
        <link rel="shortcut icon" href="<?php echo e(asset('images/ub-logo.png')); ?>">
        <link rel="apple-touch-icon" href="<?php echo e(asset('images/ub-logo.png')); ?>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/sweetalert2-custom.css', 'resources/js/app.js', 'resources/js/components/sweetalert2-utils.js', 'resources/js/utils/action-handler.js']); ?>
    </head>
    <body class="font-sans antialiased" style="background-image: url('<?php echo e(asset('images/Background.jpg')); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
        <div class="min-h-screen bg-white/500">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php
                $sectionTitle = null;
                if (request()->routeIs('dashboard')) $sectionTitle = 'Dashboard';
                elseif (request()->routeIs('equipment-management.*')) $sectionTitle = 'Equipment';
                elseif (request()->routeIs('reservation-management.*') || request()->routeIs('reservations.*')) $sectionTitle = 'Reservations';
                elseif (request()->routeIs('maintenance-management.*')) $sectionTitle = 'Maintenance';
                elseif (request()->routeIs('equipment-categories.*')) $sectionTitle = 'Categories';
                elseif (request()->routeIs('equipment-types.*')) $sectionTitle = 'Equipment Types';
                elseif (request()->routeIs('profile-user-management.*')) $sectionTitle = 'Users';
                elseif (request()->routeIs('admin.database-backup.*')) $sectionTitle = 'Backups';
                elseif (request()->routeIs('missing-equipment.*')) $sectionTitle = 'Missing Equipment';
                elseif (request()->routeIs('admin.*')) $sectionTitle = 'Admin Panel';
                elseif (request()->routeIs('user.*')) $sectionTitle = 'User Dashboard';
                elseif (request()->routeIs('manager.*')) $sectionTitle = 'Manager Dashboard';
                elseif (request()->routeIs('equipment-returns.*')) $sectionTitle = 'Equipment Returns';
                elseif (request()->routeIs('profile.*')) $sectionTitle = 'Profile';
            ?>

            <?php if($sectionTitle): ?>
                <?php if (isset($component)) { $__componentOriginalf8e5343931740460398d264871ecb57b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8e5343931740460398d264871ecb57b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-banner','data' => ['title' => $sectionTitle]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($sectionTitle)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8e5343931740460398d264871ecb57b)): ?>
<?php $attributes = $__attributesOriginalf8e5343931740460398d264871ecb57b; ?>
<?php unset($__attributesOriginalf8e5343931740460398d264871ecb57b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8e5343931740460398d264871ecb57b)): ?>
<?php $component = $__componentOriginalf8e5343931740460398d264871ecb57b; ?>
<?php unset($__componentOriginalf8e5343931740460398d264871ecb57b); ?>
<?php endif; ?>
            <?php endif; ?>

            <!-- Notification System -->
            <div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2">
                <?php if(session('success')): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // If variant is banner, emulate the deletion-success header style
                            const variant = <?php echo json_encode(session('success_variant'), 15, 512) ?>;
                            if (window.Swal && variant !== 'banner') {
                                Swal.fire({
                                    icon: 'success',
                                    title: <?php echo json_encode(session('success_title') ?? 'Action Completed', 15, 512) ?>,
                                    text: <?php echo json_encode(session('success'), 15, 512) ?>,
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    customClass: { popup: 'swal-custom-popup', title: 'swal2-success-title', confirmButton: 'swal-custom-confirm' }
                                });
                            } else {
                                // Banner-style: build a custom SweetAlert with a green header like deletion modal
                                if (window.Swal) {
                                    Swal.fire({
                                        buttonsStyling: false,
                                        showConfirmButton: true,
                                        confirmButtonText: 'OK',
                                        showCancelButton: false,
                                        html: `
                                            <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;">
                                                <h2 class="text-xl font-bold text-center">` + <?php echo json_encode(session('success_title') ?? 'Success', 15, 512) ?> + `</h2>
                                            </div>
                                            <div class="text-center">
                                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </div>
                                                <p class="text-gray-700">` + <?php echo json_encode(session('success'), 15, 512) ?> + `</p>
                                            </div>
                                        `,
                                        customClass: { popup: 'swal-custom-popup' }
                                    });
                                } else {
                                    showNotification(<?php echo json_encode(session('success'), 15, 512) ?>, 'success');
                                }
                            }
                        });
                    </script>
                <?php endif; ?>

                

                <?php if(session('warning')): ?>
                    <div class="notification warning bg-yellow-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span><?php echo e(session('warning')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(session('info')): ?>
                    <div class="notification info bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <span><?php echo e(session('info')); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                
            </div>

            <!-- Page Heading (disabled to avoid duplicate page titles in content) -->

            <!-- Page Content -->
            <main>
                <?php if (! empty(trim($__env->yieldContent('breadcrumbs')))): ?>
                    <div class="bg-white border-b">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 text-sm text-gray-600">
                            <?php echo $__env->yieldContent('breadcrumbs'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(isset($slot)): ?>
                    <?php echo e($slot); ?>

                <?php else: ?>
                    <?php echo $__env->yieldContent('content'); ?>
                <?php endif; ?>
            </main>
        </div>

        <script>
            // Security: Prevent back button access after logout
            document.addEventListener('DOMContentLoaded', function() {
                // Check if user is authenticated
                const isAuthenticated = <?php echo e(Auth::check() ? 'true' : 'false'); ?>;
                
                if (isAuthenticated) {
                    // Store current page in session storage
                    sessionStorage.setItem('lastAuthenticatedPage', window.location.href);
                    
                    // Listen for page visibility changes
                    document.addEventListener('visibilitychange', function() {
                        if (document.visibilityState === 'visible') {
                            // Check if session is still valid
                            fetch('/api/check-auth', {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    // Session expired, redirect to login
                                    window.location.href = '/login';
                                }
                            })
                            .catch(() => {
                                // Network error or session expired
                                window.location.href = '/login';
                            });
                        }
                    });
                    
                    // Handle browser back button
                    window.addEventListener('pageshow', function(event) {
                        if (event.persisted) {
                            // Page was loaded from cache (back button)
                            window.location.reload();
                        }
                    });
                }
                
                // Notification system
                const notifications = document.querySelectorAll('.notification');
                
                notifications.forEach(notification => {
                    // Show notification
                    setTimeout(() => {
                        notification.classList.remove('translate-x-full');
                    }, 100);
                    
                    // Auto-hide after 8 seconds
                    setTimeout(() => {
                        notification.classList.add('translate-x-full');
                        setTimeout(() => {
                            notification.remove();
                        }, 300);
                    }, 8000);
                    
                    // Add close button functionality
                    const closeButton = document.createElement('button');
                    closeButton.innerHTML = '×';
                    closeButton.className = 'ml-4 text-white hover:text-gray-200 text-xl font-bold';
                    closeButton.onclick = function() {
                        notification.classList.add('translate-x-full');
                        setTimeout(() => {
                            notification.remove();
                        }, 300);
                    };
                    
                    notification.querySelector('div').appendChild(closeButton);
                });

                // Tooltip helper for elements with data-tooltip
                const tip = document.createElement('div');
                tip.style.position = 'fixed';
                tip.style.zIndex = '9999';
                tip.style.pointerEvents = 'none';
                tip.style.padding = '6px 10px';
                tip.style.borderRadius = '8px';
                tip.style.fontSize = '12px';
                tip.style.color = '#fff';
                tip.style.background = 'rgba(17,24,39,0.92)';
                tip.style.boxShadow = '0 6px 18px rgba(0,0,0,0.15)';
                tip.style.opacity = '0';
                tip.style.transition = 'opacity .12s ease';
                document.body.appendChild(tip);

                let current = null;
                function showTip(e){
                    const t = e.currentTarget; const text = t.getAttribute('data-tooltip');
                    if (!text) return; current = t; tip.textContent = text;
                    const r = t.getBoundingClientRect();
                    const top = r.top - 14; const left = r.left + (r.width/2);
                    tip.style.top = `${Math.max(8, top - tip.offsetHeight)}px`;
                    tip.style.left = `${Math.max(8, left - tip.offsetWidth/2)}px`;
                    tip.style.opacity = '1';
                }
                function hideTip(){ current = null; tip.style.opacity = '0'; }
                function moveTip(){ if (!current) return; showTip({ currentTarget: current }); }

                const tooltipTargets = new Set([
                    ...Array.from(document.querySelectorAll('[data-tooltip]')),
                    ...Array.from(document.querySelectorAll('[title]'))
                ]);
                tooltipTargets.forEach(el => {
                    el.addEventListener('mouseenter', showTip);
                    el.addEventListener('mouseleave', hideTip);
                    el.addEventListener('mousemove', moveTip);
                });
            });

            // Global notification function
            function showNotification(message, type = 'info') {
                const container = document.getElementById('notification-container');
                const colors = {
                    success: 'bg-green-500',
                    error: 'bg-red-500',
                    warning: 'bg-yellow-500',
                    info: 'bg-blue-500'
                };
                
                const icons = {
                    success: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>',
                    error: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>',
                    warning: '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>',
                    info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>'
                };
                
                const notification = document.createElement('div');
                notification.className = `notification ${type} ${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            ${icons[type]}
                        </svg>
                        <span>${message}</span>
                        <button class="ml-4 text-white hover:text-gray-200 text-xl font-bold" onclick="this.parentElement.parentElement.remove()">×</button>
                    </div>
                `;
                
                container.appendChild(notification);
                
                // Show notification
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Auto-hide after 8 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 8000);
            }
        </script>

        <?php echo $__env->yieldPushContent('scripts'); ?>
        
        <?php if(auth()->guard()->check()): ?>
            <!-- Profile Completion Success Modal -->
            <?php if(session('status') === 'profile-completed'): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Profile Setup Complete!',
                            html: `
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">Welcome to SEMS!</p>
                                    <p class="text-gray-600 mt-2">Your profile has been successfully set up. You can now access all system features.</p>
                                </div>
                            `,
                            icon: false,
                            showConfirmButton: true,
                            confirmButtonText: 'Continue to Dashboard',
                            confirmButtonColor: '#dc2626',
                            customClass: {
                                popup: 'swal-custom-popup',
                                confirmButton: 'swal-custom-confirm'
                            },
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    });
                </script>
            <?php endif; ?>

            <!-- Profile Setup Required Modal -->
            <?php if(session('status') === 'please-complete-profile'): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: false,
                            buttonsStyling: false,
                            html: `
                                <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Profile Setup Required</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">Complete Your Profile Setup</p>
                                    <p class="text-gray-600 mt-2">You must complete your profile information before accessing other parts of the system. Please update your profile details to continue.</p>
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
                            },
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    });
                </script>
            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/layouts/app.blade.php ENDPATH**/ ?>