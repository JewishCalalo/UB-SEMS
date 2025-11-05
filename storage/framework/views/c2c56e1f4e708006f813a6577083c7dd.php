<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => null]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['title' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<div class="bg-red-600 text-white shadow-lg border-b border-red-500">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-8 flex items-center justify-between">
		<h1 class="text-2xl sm:text-3xl font-bold text-white"><?php echo e($title ?? ''); ?></h1>
		<div class="text-sm text-red-100 font-medium"><?php echo e(now()->format('M d, Y')); ?></div>
	</div>
</div>
<?php /**PATH C:\UB-SEMS\resources\views\components\section-banner.blade.php ENDPATH**/ ?>