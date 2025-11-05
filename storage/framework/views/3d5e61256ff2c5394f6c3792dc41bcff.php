<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'submit',
    'variant' => 'primary', // primary, secondary, danger, success
    'size' => 'md', // sm, md, lg
    'disabled' => false,
    'icon' => null,
    'href' => null
]));

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

foreach (array_filter(([
    'type' => 'submit',
    'variant' => 'primary', // primary, secondary, danger, success
    'size' => 'md', // sm, md, lg
    'disabled' => false,
    'icon' => null,
    'href' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-sm',
        'lg' => 'px-8 py-4 text-base'
    ];
    
    $variantClasses = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
        'danger' => 'bg-red-700 text-white hover:bg-red-800 focus:ring-red-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500'
    ];
    
    $classes = $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $variantClasses[$variant];
    
    if ($disabled) {
        $classes .= ' opacity-50 cursor-not-allowed';
    }
?>

<?php if($href): ?>
    <a href="<?php echo e($href); ?>" 
       class="<?php echo e($classes); ?>"
       <?php echo e($attributes); ?>>
        <?php if($icon): ?>
            <i class="<?php echo e($icon); ?> mr-2"></i>
        <?php endif; ?>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" 
            <?php echo e($disabled ? 'disabled' : ''); ?>

            class="<?php echo e($classes); ?>"
            <?php echo e($attributes); ?>>
        <?php if($icon): ?>
            <i class="<?php echo e($icon); ?> mr-2"></i>
        <?php endif; ?>
        <?php echo e($slot); ?>

    </button>
<?php endif; ?>
<?php /**PATH C:\SEMSv26\resources\views/components/form-button.blade.php ENDPATH**/ ?>