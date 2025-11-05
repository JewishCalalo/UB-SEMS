<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['id', 'title', 'message', 'confirmText' => 'Delete', 'cancelText' => 'Cancel', 'confirmClass' => 'bg-red-600 hover:bg-red-700']));

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

foreach (array_filter((['id', 'title', 'message', 'confirmText' => 'Delete', 'cancelText' => 'Cancel', 'confirmClass' => 'bg-red-600 hover:bg-red-700']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div id="<?php echo e($id); ?>" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
    <div class="relative mx-auto p-6 border shadow-2xl rounded-xl bg-white w-full max-w-lg">
        <div class="mt-3 text-center">
            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-medium text-gray-900 mb-2"><?php echo e($title); ?></h3>
            
            <!-- Message -->
            <div class="mt-2 px-6 py-3">
                <div class="text-sm text-gray-600" style="white-space: normal !important; overflow-wrap: anywhere !important; word-break: break-word !important; max-width: 28rem; margin: 0 auto; text-align: center;">
                    <?php echo e($message); ?>

                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-center space-x-3 mt-4">
                <button onclick="hideConfirmationModal('<?php echo e($id); ?>')" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                    <?php echo e($cancelText); ?>

                </button>
                <button onclick="confirmDelete('<?php echo e($id); ?>')" 
                        class="px-4 py-2 text-white rounded-md transition duration-200 <?php echo e($confirmClass); ?>">
                    <?php echo e($confirmText); ?>

                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showConfirmationModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }
    
    function hideConfirmationModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
    
    function confirmDelete(modalId) {
        hideConfirmationModal(modalId);
        // Dispatch a custom event that the parent page can listen for
        document.dispatchEvent(new CustomEvent('confirm-delete', { detail: { modalId: modalId } }));
    }
</script>
<?php /**PATH C:\UB-SEMS\resources\views\components\confirmation-modal.blade.php ENDPATH**/ ?>