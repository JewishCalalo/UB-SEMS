<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEMS - Access Denied</title>
    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/js/app.js',
        'resources/css/app.css'
    ]); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/ub-logo.png')); ?>">
</head>
<body class="font-sans antialiased min-h-screen" style="background-image: url('<?php echo e(asset('images/Background.jpg')); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
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
    <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-10 relative">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="relative z-10 w-full max-w-xl bg-white/95 backdrop-blur rounded-xl shadow-lg border border-gray-100 p-8 text-center">
            <div class="mx-auto w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86A2 2 0 0021 17.15L13.93 4.6a2 2 0 00-3.46 0L3 17.15A2 2 0 005.07 19z" />
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-gray-900 mb-2">Access Denied (403)</h1>
            <p class="text-gray-600 mb-6">You don’t have permission to view this page. If you believe this is an error, please contact an administrator.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="<?php echo e(route('welcome')); ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg text-white" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
                    Go to Home
                </a>
                <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
                    Go to Dashboard
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>


<?php /**PATH C:\UB-SEMS\resources\views\errors\403.blade.php ENDPATH**/ ?>