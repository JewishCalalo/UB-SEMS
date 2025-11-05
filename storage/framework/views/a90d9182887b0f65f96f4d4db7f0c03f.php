<!-- Incidents Report -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
    <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
        <h4 class="text-lg font-semibold text-red-800 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            Incidents Report
        </h4>
    </div>
    <div class="p-6">
        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-gray-900"><?php echo e($data['total']); ?></div>
                <div class="text-sm text-gray-600">Total Incidents</div>
            </div>
            
            <?php $__currentLoopData = $data['status_counts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900"><?php echo e($count); ?></div>
                    <div class="text-sm text-gray-600"><?php echo e(ucfirst($status)); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        

        <!-- Incidents Table -->
        <?php if($data['incidents']->count() > 0): ?>
        <div>
            <h5 class="text-lg font-semibold text-gray-900 mb-4">Recent Incidents</h5>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-red-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Severity</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $data['incidents']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="<?php echo e(route('instructor.incidents.show', $incident)); ?>" class="text-red-600 hover:text-red-800">
                                    <?php echo e($incident->incident_code); ?>

                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(ucfirst($incident->incident_type)); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php if($incident->severity === 'critical'): ?> bg-red-100 text-red-800
                                    <?php elseif($incident->severity === 'high'): ?> bg-orange-100 text-orange-800
                                    <?php elseif($incident->severity === 'medium'): ?> bg-yellow-100 text-yellow-800
                                    <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($incident->severity)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php if($incident->status === 'resolved'): ?> bg-green-100 text-green-800
                                    <?php elseif($incident->status === 'investigating'): ?> bg-yellow-100 text-yellow-800
                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($incident->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($incident->created_at->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php if($incident->equipment): ?>
                                    <?php echo e($incident->equipment->brand); ?> <?php echo e($incident->equipment->model); ?>

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No incidents found</h3>
            <p class="mt-1 text-sm text-gray-500">No incidents match your selected criteria.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if($data['incidents']->count() > 0): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Incident Types Chart
    <?php if($data['incident_types']->count() > 0): ?>
    const incidentTypesCtx = document.getElementById('incidentTypesChart').getContext('2d');
    const incidentTypesData = <?php echo json_encode($data['incident_types'], 15, 512) ?>;
    
    new Chart(incidentTypesCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(incidentTypesData),
            datasets: [{
                data: Object.values(incidentTypesData),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(168, 85, 247, 0.8)'
                ],
                borderColor: [
                    'rgb(239, 68, 68)',
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(245, 158, 11)',
                    'rgb(168, 85, 247)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    <?php endif; ?>

    // Severity Chart
    <?php if($data['severity_counts']->count() > 0): ?>
    const severityCtx = document.getElementById('severityChart').getContext('2d');
    const severityData = <?php echo json_encode($data['severity_counts'], 15, 512) ?>;
    
    new Chart(severityCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(severityData),
            datasets: [{
                data: Object.values(severityData),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',   // Critical - Red
                    'rgba(245, 158, 11, 0.8)',  // High - Orange
                    'rgba(234, 179, 8, 0.8)',   // Medium - Yellow
                    'rgba(34, 197, 94, 0.8)'    // Low - Green
                ],
                borderColor: [
                    'rgb(239, 68, 68)',
                    'rgb(245, 158, 11)',
                    'rgb(234, 179, 8)',
                    'rgb(34, 197, 94)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    <?php endif; ?>
});
</script>
<?php endif; ?>
<?php /**PATH C:\UB-SEMS\resources\views\instructor\reports\partials\incidents.blade.php ENDPATH**/ ?>