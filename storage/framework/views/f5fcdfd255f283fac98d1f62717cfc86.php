<!-- Reservations Report -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
    <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
        <h4 class="text-lg font-semibold text-red-800 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Reservations Report
        </h4>
    </div>
    <div class="p-6">
        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-gray-900"><?php echo e($data['total']); ?></div>
                <div class="text-sm text-gray-600">Total Reservations</div>
            </div>
            
            <?php $__currentLoopData = $data['status_counts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900"><?php echo e($count); ?></div>
                    <div class="text-sm text-gray-600"><?php echo e(ucfirst($status)); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        

        <!-- Recent Reservations Table -->
        <?php if($data['reservations']->count() > 0): ?>
        <div>
            <h5 class="text-lg font-semibold text-gray-900 mb-4">Recent Reservations</h5>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-red-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Duration</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $data['reservations']->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <?php echo e($reservation->reservation_code); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($reservation->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php if($reservation->status === 'approved'): ?> bg-green-100 text-green-800
                                    <?php elseif($reservation->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($reservation->status === 'denied'): ?> bg-red-100 text-red-800
                                    <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($reservation->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($reservation->items->count()); ?> items
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if($reservation->borrow_date && $reservation->return_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($reservation->borrow_date)->diffInDays(\Carbon\Carbon::parse($reservation->return_date))); ?> days
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations found</h3>
            <p class="mt-1 text-sm text-gray-500">No reservations match your selected criteria.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if($data['monthly_data']->count() > 0): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = <?php echo json_encode($data['monthly_data'], 15, 512) ?>;
    
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(monthlyData),
            datasets: [{
                label: 'Reservations',
                data: Object.values(monthlyData),
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
<?php endif; ?>
<?php /**PATH C:\UB-SEMS\resources\views\instructor\reports\partials\reservations.blade.php ENDPATH**/ ?>