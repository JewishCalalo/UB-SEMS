<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'images',
    'label' => 'Upload Images',
    'multiple' => false,
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'description' => null,
    'required' => false
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
    'name' => 'images',
    'label' => 'Upload Images',
    'multiple' => false,
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'description' => null,
    'required' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div>
    <label for="<?php echo e($name); ?>" class="block text-sm font-medium text-gray-700">
        <?php echo e($label); ?>

        <?php if($required): ?>
            <span class="text-red-500">*</span>
        <?php endif; ?>
    </label>
    
    <input type="file" 
           name="<?php echo e($name); ?><?php echo e($multiple ? '[]' : ''); ?>" 
           id="<?php echo e($name); ?>" 
           <?php echo e($multiple ? 'multiple' : ''); ?>

           accept="<?php echo e($accept); ?>"
           <?php echo e($required ? 'required' : ''); ?>

           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
           <?php echo e($attributes); ?>>
    
    <?php if($description): ?>
        <p class="mt-1 text-sm text-gray-500"><?php echo e($description); ?></p>
    <?php else: ?>
        <p class="mt-1 text-sm text-gray-500">
            <?php if($multiple): ?>
                You can select multiple images. Maximum file size: <?php echo e($maxSize); ?> each.
            <?php else: ?>
                Maximum file size: <?php echo e($maxSize); ?>.
            <?php endif; ?>
        </p>
    <?php endif; ?>
    
    <?php $__errorArgs = [$name . '.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-sm text-red-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <?php echo e($message); ?>

        </p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/components/image-upload.blade.php ENDPATH**/ ?>