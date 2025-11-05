<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'SEMS')); ?> - Verify Reservation</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/ub-logo.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/ub-logo.png')); ?>">

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
    <!-- Navigation (same as homepage) -->
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
        <!-- Background overlay for readability like login -->
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>

        <!-- Verify Card (mirrors login card without logo) -->
        <div class="w-full max-w-sm px-4 sm:px-6 py-6 sm:py-8 bg-white shadow-md rounded-lg border border-gray-100 login__card relative z-10">
            <div class="mb-4 text-center">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900">Enter 6-Digit Code</h2>
                <p class="text-sm sm:text-base text-gray-600 mt-1">We sent a 6‑digit code to <strong><?php echo e($reservation->email); ?></strong>. Enter it below to verify your email.</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-red-800 text-sm">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form id="verifyForm" method="POST" action="<?php echo e(route('reservations.verify.submit', $reservation)); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div class="flex items-center justify-center gap-2">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,1)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,2)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,3)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,4)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,5)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,6)">
                </div>
                <input type="hidden" name="code" id="otp_code">
                <div class="mb-2"></div>
                <button type="submit" 
                        style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 12px 18px; border-radius: 10px; border: none; font-weight: 600; font-size: 15px; width: 100%; transition: all 0.3s; cursor: pointer; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); display: inline-flex; align-items: center; justify-content: center; gap: 8px; transform: translateY(0);"
                        onmouseover="this.style.background='linear-gradient(135deg, #b91c1c 0%, #991b1b 100%)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'"
                        onmouseout="this.style.background='linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                    Verify
                </button>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-200 relative z-10">
            <p>&copy; <?php echo e(date('Y')); ?> University of Baguio. All rights reserved.</p>
        </div>
    </div>

    <script>
        function otpShift(el, idx) {
            const val = el.value.replace(/\D/g,'');
            el.value = val.substring(0,1);
            const inputs = Array.from(document.querySelectorAll('input[inputmode="numeric"]'));
            const code = inputs.map(i => i.value || '').join('');
            document.getElementById('otp_code').value = code;
            if (val && idx < inputs.length) {
                inputs[idx].focus();
            }
            if (code.length === 6) {
                const form = document.getElementById('verifyForm');
                if (form) form.submit();
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\UB-SEMS\resources\views\user\reservations\verify.blade.php ENDPATH**/ ?>