<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['active']));

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

foreach (array_filter((['active']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-full bg-red-600 text-white text-sm font-semibold leading-5 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-full text-sm font-medium leading-5 text-gray-700 hover:text-red-700 hover:bg-red-50 hover:ring-1 hover:ring-red-200 focus:outline-none focus:bg-red-50 focus:text-red-700 transition duration-150 ease-in-out';
?>

<a <?php echo e($attributes->merge(['class' => $classes])); ?> <?php echo e(($active ?? false) ? 'aria-current=page' : ''); ?>>
    <?php echo e($slot); ?>

</a>
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv25\resources\views/components/nav-link.blade.php ENDPATH**/ ?>