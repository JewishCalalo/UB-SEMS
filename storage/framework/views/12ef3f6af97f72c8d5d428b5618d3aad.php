<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'SEMS')); ?> - Login</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/ub-logo.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/ub-logo.png')); ?>">

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
        'resources/css/modules/welcome.css'
    ]); ?>
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

    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8 py-6 sm:py-0 relative">
        <!-- Background overlay for better readability -->
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>

        <!-- Login Card -->
        <div class="w-full max-w-sm px-4 sm:px-6 py-6 sm:py-8 bg-white shadow-md rounded-lg border border-gray-100 login__card relative z-10">
            <div class="mb-6 text-center">
                <img src="<?php echo e(asset('images/ub-logo.png')); ?>" alt="SEMS Logo" class="mx-auto h-20 w-auto object-contain" />
            </div>
            <div class="mb-6 text-center">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900">Staff Login</h2>
                <p class="text-sm sm:text-base text-gray-600 mt-1">Sign in as Manager or Admin to manage the system</p>
            </div>

            <!-- Session Status -->
            <?php if(session('status')): ?>
                <?php if(session('status') === 'email-verification-sent-logout'): ?>
                    <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-md">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium">Email Changed Successfully</p>
                                <p class="text-sm mt-1">
                                    Your email has been updated and you have been logged out for security. 
                                    Please log in with your <strong>new email address</strong> and check your email for the verification link.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Global Error Card -->
            <?php if($errors->any()): ?>
                <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-r-lg p-4 shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">
                                Invalid email or password. Please try again.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6" novalidate>
                <?php echo csrf_field(); ?>

                <!-- User Type Selection -->
                

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-3">
                        University Email
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-500 pointer-events-none" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <input id="email" 
                            type="text" 
                            name="email" 
                            value="<?php echo e(old('email')); ?>" 
                            autofocus 
                            autocomplete="username"
                            placeholder="staff@ubaguio.edu"
                            class="block w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150 ease-in-out">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-3">
                        Password
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-500 pointer-events-none" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z">
                            </path>
                        </svg>
                        <input id="password" 
                                type="password" 
                                name="password" 
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="block w-full pl-11 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150 ease-in-out">
                        <button type="button" 
                                id="password-toggle"
                                class="absolute inset-y-0 right-0 my-1 mr-1 inline-flex items-center justify-center w-10 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg id="password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" 
                               type="checkbox" 
                               name="remember"
                               class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm text-gray-600"><?php echo e(__('Remember me')); ?></span>
                    </label>

                    <?php if(Route::has('password.request')): ?>
                        <a class="text-sm text-red-600 hover:text-red-500 transition-all duration-150 ease-in-out font-medium hover:underline" 
                           href="<?php echo e(route('password.request')); ?>">
                            <?php echo e(__('Forgot password?')); ?>

                        </a>
                    <?php endif; ?>
                </div>

                <!-- Submit Button -->
                <div class="mb-6">
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 16px 24px; border-radius: 12px; border: none; font-weight: 600; font-size: 16px; width: 100%; transition: all 0.3s; cursor: pointer; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px; transform: translateY(0);"
                            onmouseover="this.style.background='linear-gradient(135deg, #b91c1c 0%, #991b1b 100%)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'"
                            onmouseout="this.style.background='linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        <?php echo e(__('Sign In')); ?>

                    </button>
                </div>
            </form>



            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Need an account? Contact our administrator<br>
                    sample@t.ubaguio.edu 
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    Only @ubaguio.edu email addresses are allowed
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500 relative z-10">
            <p>&copy; <?php echo e(date('Y')); ?> University of Baguio. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Handle radio button selection styling
        document.querySelectorAll('input[name="user_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove active class from all labels
                document.querySelectorAll('input[name="user_type"]').forEach(r => {
                    r.closest('label').classList.remove('border-blue-500', 'ring-2', 'ring-blue-500');
                    r.closest('label').classList.add('border-gray-300');
                });
                
                // Add active class to selected label
                if (this.checked) {
                    this.closest('label').classList.remove('border-gray-300');
                    this.closest('label').classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
                }
            });
        });

        // Password visibility toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');
            const passwordEye = document.getElementById('password-eye');
            const passwordEyeSlash = document.getElementById('password-eye-slash');

            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Toggle eye icons
                    if (type === 'text') {
                        passwordEye.classList.add('hidden');
                        passwordEyeSlash.classList.remove('hidden');
                    } else {
                        passwordEye.classList.remove('hidden');
                        passwordEyeSlash.classList.add('hidden');
                    }
                });
            }

            // Set initial active state for radio buttons
            const managerRadio = document.querySelector('input[value="manager"]');
            if (managerRadio) {
                managerRadio.closest('label').classList.remove('border-gray-300');
                managerRadio.closest('label').classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv25\resources\views/auth/login.blade.php ENDPATH**/ ?>