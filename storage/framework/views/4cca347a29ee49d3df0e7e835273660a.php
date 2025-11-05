<div id="logoutConfirmation" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Confirm Logout</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to logout? This will end your session and you will need to log in again to access the system.
                </p>
                <p class="text-xs text-red-500 mt-2">
                    <strong>Security Note:</strong> After logout, you will not be able to access previous pages using the browser's back button.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form method="POST" action="<?php echo e(route('logout')); ?>" id="logoutForm">
                    <?php echo csrf_field(); ?>
                    <button type="button" id="confirmLogout" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Yes, Logout
                    </button>
                    <button type="button" id="cancelLogout" class="mt-2 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const logoutConfirmation = document.getElementById('logoutConfirmation');
    const confirmLogout = document.getElementById('confirmLogout');
    const cancelLogout = document.getElementById('cancelLogout');
    const logoutForm = document.getElementById('logoutForm');

    // Show confirmation when logout is clicked
    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest('form[action*="logout"]') && !e.target.closest('#logoutConfirmation')) {
            e.preventDefault();
            logoutConfirmation.classList.remove('hidden');
        }
    });

    // Confirm logout
    confirmLogout.addEventListener('click', function() {
        logoutForm.submit();
    });

    // Cancel logout
    cancelLogout.addEventListener('click', function() {
        logoutConfirmation.classList.add('hidden');
    });

    // Close on outside click
    logoutConfirmation.addEventListener('click', function(e) {
        if (e.target === logoutConfirmation) {
            logoutConfirmation.classList.add('hidden');
        }
    });

    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !logoutConfirmation.classList.contains('hidden')) {
            logoutConfirmation.classList.add('hidden');
        }
    });
});
</script>
<?php /**PATH C:\UB-SEMS\resources\views\components\logout-confirmation.blade.php ENDPATH**/ ?>