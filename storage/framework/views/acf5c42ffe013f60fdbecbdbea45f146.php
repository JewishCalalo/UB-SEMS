<div>
<!-- Flash Notifications Component -->
<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2">
    <?php if(session('success')): ?>
        <div class="notification success bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    
    
</div>
</div>
<?php /**PATH C:\UB-SEMS\resources\views\components\notification\flash-notifications.blade.php ENDPATH**/ ?>