<!-- Equipment Usage Report -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
    <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
        <h4 class="text-lg font-semibold text-red-800 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            Equipment Usage Report
        </h4>
    </div>
    <div class="p-6">
        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $data['total_equipment_types'] }}</div>
                <div class="text-sm text-gray-600">Equipment Types Used</div>
            </div>
            
            @if($data['most_used'])
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $data['most_used']['count'] }}</div>
                <div class="text-sm text-gray-600">Most Used Count</div>
            </div>
            
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-gray-900">{{ $data['most_used']['total_quantity'] }}</div>
                <div class="text-sm text-gray-600">Total Quantity Used</div>
            </div>
            @endif
        </div>

        <!-- Equipment Usage Chart -->
        @if($data['equipment_usage']->count() > 0)
        <div class="mb-8">
            <h5 class="text-lg font-semibold text-gray-900 mb-4">Equipment Usage Distribution</h5>
            <canvas id="equipmentUsageChart" width="400" height="200"></canvas>
        </div>
        @endif

        <!-- Equipment Usage Table -->
        @if($data['equipment_usage']->count() > 0)
        <div>
            <h5 class="text-lg font-semibold text-gray-900 mb-4">Equipment Usage Details</h5>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Times Used</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage Rate</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data['equipment_usage'] as $usage)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $usage['equipment']->brand }} {{ $usage['equipment']->model }}</div>
                                <div class="text-sm text-gray-500">{{ $usage['equipment']->description ?? 'No description' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $usage['equipment']->category->name ?? 'Uncategorized' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $usage['count'] }} times
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $usage['total_quantity'] }} units
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @php
                                    $maxUsage = $data['equipment_usage']->max('count');
                                    $usageRate = $maxUsage > 0 ? ($usage['count'] / $maxUsage) * 100 : 0;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-red-600 h-2 rounded-full" style="width: {{ $usageRate }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($usageRate, 1) }}%</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment usage data</h3>
            <p class="mt-1 text-sm text-gray-500">No equipment usage found for the selected period.</p>
        </div>
        @endif
    </div>
</div>

@if($data['equipment_usage']->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const equipmentCtx = document.getElementById('equipmentUsageChart').getContext('2d');
    const equipmentData = @json($data['equipment_usage']->take(10));
    
    const labels = equipmentData.map(item => item.equipment.brand + ' ' + item.equipment.model);
    const counts = equipmentData.map(item => item.count);
    
    new Chart(equipmentCtx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: counts,
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(14, 165, 233, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(168, 85, 247, 0.8)'
                ],
                borderColor: [
                    'rgb(239, 68, 68)',
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(245, 158, 11)',
                    'rgb(168, 85, 247)',
                    'rgb(236, 72, 153)',
                    'rgb(14, 165, 233)',
                    'rgb(34, 197, 94)',
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
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
});
</script>
@endif
