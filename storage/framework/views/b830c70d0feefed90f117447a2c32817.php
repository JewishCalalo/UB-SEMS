<!-- Role-specific Dashboard Content -->
<?php if(Auth::user()->isAdmin()): ?>
    <?php echo $__env->make('admin.dashboard.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php elseif(Auth::user()->isManager()): ?>
    <?php echo $__env->make('manager.dashboard.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('user.dashboard.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>
<?php /**PATH C:\UB-SEMS\resources\views\dashboard.blade.php ENDPATH**/ ?>