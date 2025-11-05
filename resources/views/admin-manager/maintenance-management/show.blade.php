<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equipment Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Maintenance Management', 'url' => route('maintenance-management.index')],
                ['label' => $equipment->display_name]
            ]" />
            
            <!-- Equipment Header Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-red-600 px-8 py-6">
                    <div class="flex justify-between items-start">
                        <div class="text-white">
                            <h1 class="text-3xl font-bold mb-2 text-white">{{ $equipment->display_name }}</h1>
                            <div class="flex items-center space-x-4 text-white">
                                <span class="flex items-center">
                                    <i class="fas fa-tag mr-2"></i>
                                    {{ $equipment->category->name }}
                                </span>
                                @if($equipment->model)
                                    <span class="flex items-center">
                                        <i class="fas fa-cube mr-2"></i>
                                        {{ $equipment->model }}
                                    </span>
                                @endif
                                <span class="flex items-center">
                                    <i class="fas fa-tools mr-2"></i>
                                    {{ $maintenanceRecords->count() }} Maintenance Records
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('maintenance-management.create-record', $equipment) }}" 
                               class="inline-flex items-center px-6 py-3 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-plus mr-2"></i>
                                Add Record
                            </a>

                            <button onclick="history.back()" 
                               class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Maintenance Records Full Width Content -->
            <div class="w-full">
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-clipboard-list  text-slate-600"></i>
                                Maintenance Records
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Complete history of maintenance activities for this equipment</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($maintenanceRecords->count() > 0)
                        <div class="px-8 py-4">
                            <x-table-toolbar />
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-50 border-b-2 border-red-200">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-red-900 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-red-900 uppercase tracking-wider">Maintenance Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-red-900 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-red-900 uppercase tracking-wider">Performed By</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-red-900 uppercase tracking-wider">Instance Code</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-red-900 uppercase tracking-wider">Before Condition</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-red-900 uppercase tracking-wider">After Condition</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($maintenanceRecords as $record)
                                        @php
                                            $affectedInstances = $record->affected_instances ?? [];
                                            $instanceCount = count($affectedInstances);
                                        @endphp
                                        
                                        @if($instanceCount > 0)
                                            @foreach($affectedInstances as $index => $instance)
                                                <tr class="hover:bg-gray-50 transition-colors duration-150" data-record-id="{{ $record->id }}">
                                                    @if($index === 0)
                                                        <!-- Date column (shared across instances) -->
                                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $instanceCount }}">
                                                            <div class="text-sm text-gray-900 font-medium">{{ $record->maintenance_date->format('M d, Y') }}</div>
                                                            <div class="text-sm text-gray-500">{{ $record->maintenance_date->format('g:i A') }}</div>
                                                        </td>
                                                        <!-- Maintenance Type column (shared across instances) -->
                                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $instanceCount }}">
                                                            @php
                                                                $typeColors = [
                                                                    'routine' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                                                    'routine_maintenance_mode' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                                                    'repair' => 'bg-orange-100 text-orange-800 border border-orange-200',
                                                                    'inspection' => 'bg-purple-100 text-purple-800 border border-purple-200',
                                                                    'upgrade' => 'bg-indigo-100 text-indigo-800 border border-indigo-200',
                                                                    'calibration' => 'bg-pink-100 text-pink-800 border border-pink-200',
                                                                    'emergency_enforcement' => 'bg-red-100 text-red-800 border border-red-200'
                                                                ];
                                                                // Extract custom "Other" maintenance label if present in description
                                                                $customLabel = null;
                                                                if ($record->maintenance_type === 'inspection' && $record->description) {
                                                                    if (preg_match('/^\s*Other\s+maintenance\s+type:\s*(.+)$/i', trim($record->description), $m)) {
                                                                        $customLabel = trim($m[1]);
                                                                    }
                                                                }
                                                                $displayType = $customLabel ?: ucfirst(str_replace('_', ' ', $record->maintenance_type));
                                                                $typeColor = $typeColors[$record->maintenance_type] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
                                                            @endphp
                                                            <span class="inline-flex px-3 py-1.5 text-xs font-semibold rounded-full {{ $typeColor }} shadow-sm">
                                                                {{ $displayType }}
                                                            </span>
                                                        </td>
                                                        <!-- Description column (shared across instances) -->
                                                        <td class="px-6 py-4" rowspan="{{ $instanceCount }}">
                                                            @php
                                                                $descToShow = $record->description;
                                                                if ($record->maintenance_type === 'inspection' && $descToShow) {
                                                                    $descToShow = preg_replace('/^\s*Other\s+maintenance\s+type:\s*.*/i', '', $descToShow);
                                                                    $descToShow = trim($descToShow);
                                                                }
                                                            @endphp
                                                            <div class="text-sm text-gray-900">
                                                                {{ $descToShow ? Str::limit($descToShow, 60) : 'No description provided' }}
                                                            </div>
                                                            @if($record->notes)
                                                                <div class="text-sm text-gray-500 mt-1">
                                                                    {{ Str::limit($record->notes, 40) }}
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <!-- Performed By column (shared across instances) -->
                                                        <td class="px-6 py-4 whitespace-nowrap" rowspan="{{ $instanceCount }}">
                                                            <div class="text-sm text-gray-900">{{ $record->performed_by ?: 'Not specified' }}</div>
                                                        </td>
                                                    @endif
                                                    
                                                    <!-- Instance Code column (individual for each instance) -->
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $instance['instance_code'] ?? 'N/A' }}
                                                        </div>
                                                    </td>
                                                    
                                                    <!-- Before Condition column (individual for each instance) -->
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $conditionColors = [
                                                                'excellent' => 'bg-emerald-100 text-emerald-800',
                                                                'good' => 'bg-blue-100 text-blue-800',
                                                                'fair' => 'bg-yellow-100 text-yellow-800',
                                                                'needs_repair' => 'bg-orange-100 text-orange-800',
                                                                'damaged' => 'bg-red-100 text-red-800',
                                                                'under_maintenance' => 'bg-amber-100 text-amber-800',
                                                                'lost' => 'bg-gray-100 text-gray-800',
                                                                'retired' => 'bg-slate-100 text-slate-800'
                                                            ];
                                                            $oldConditionColor = $conditionColors[$instance['old_condition']] ?? 'bg-gray-100 text-gray-800';
                                                        @endphp
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $oldConditionColor }}">
                                                            {{ ucfirst(str_replace('_', ' ', $instance['old_condition'] ?? 'Not tracked')) }}
                                                        </span>
                                                    </td>
                                                    
                                                    <!-- After Condition column (individual for each instance) -->
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $newConditionColor = $conditionColors[$instance['new_condition']] ?? 'bg-gray-100 text-gray-800';
                                                        @endphp
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $newConditionColor }}">
                                                            {{ ucfirst(str_replace('_', ' ', $instance['new_condition'] ?? 'Not tracked')) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <!-- Fallback for records without affected instances -->
                                            <tr class="hover:bg-gray-50 transition-colors duration-150" data-record-id="{{ $record->id }}">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 font-medium">{{ $record->maintenance_date->format('M d, Y') }}</div>
                                                    <div class="text-sm text-gray-500">{{ $record->maintenance_date->format('g:i A') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @php
                                                        $typeColors = [
                                                            'routine' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                                            'routine_maintenance_mode' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                                            'repair' => 'bg-orange-100 text-orange-800 border border-orange-200',
                                                            'inspection' => 'bg-purple-100 text-purple-800 border border-purple-200',
                                                            'upgrade' => 'bg-indigo-100 text-indigo-800 border border-indigo-200',
                                                            'calibration' => 'bg-pink-100 text-pink-800 border border-pink-200',
                                                            'emergency_enforcement' => 'bg-red-100 text-red-800 border border-red-200'
                                                        ];
                                                        $typeColor = $typeColors[$record->maintenance_type] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
                                                    @endphp
                                                    <span class="inline-flex px-3 py-1.5 text-xs font-semibold rounded-full {{ $typeColor }} shadow-sm">
                                                        {{ ucfirst(str_replace('_', ' ', $record->maintenance_type)) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900">
                                                        {{ $record->description ? Str::limit($record->description, 60) : 'No description provided' }}
                                                    </div>
                                                    @if($record->notes)
                                                        <div class="text-sm text-gray-500 mt-1">
                                                            {{ Str::limit($record->notes, 40) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $record->performed_by ?: 'Not specified' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">N/A</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">N/A</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">N/A</div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $maintenanceRecords->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 px-8">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-tools text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No maintenance records yet</h3>
                            <p class="text-gray-500 mb-6">Get started by adding your first maintenance record for this equipment.</p>
                            <a href="{{ route('maintenance-management.create-record', $equipment) }}" 
                               class="inline-flex items-center px-6 py-3 bg-slate-600 text-white font-semibold rounded-lg hover:bg-slate-700 transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Add First Record
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Details Modal -->
    <div id="maintenanceDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-[9999] backdrop-blur-sm">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-6xl mx-4 transform transition-all">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 rounded-t-xl bg-gradient-to-r from-slate-600 to-slate-700">
                <h2 class="text-xl font-semibold text-white">Maintenance Record Details</h2>
                <button onclick="hideMaintenanceDetails()" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div id="maintenanceDetailsContent" class="p-6">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
    
    <script>
        // Helper function to get condition color classes
        function getConditionColor(condition) {
            switch(condition) {
                case 'excellent': return 'bg-emerald-100 text-emerald-800';
                case 'good': return 'bg-blue-100 text-blue-800';
                case 'fair': return 'bg-yellow-100 text-yellow-800';
                case 'needs_repair': return 'bg-orange-100 text-orange-800';
                case 'damaged': return 'bg-red-100 text-red-800';
                case 'lost': return 'bg-gray-100 text-gray-800';
                case 'under_maintenance': return 'bg-amber-100 text-amber-800';
                default: return 'bg-gray-100 text-gray-800';
            }
        }

        function showMaintenanceDetails(recordId) {
            // Find the record data from the table
            const row = document.querySelector(`tr[data-record-id="${recordId}"]`);
            if (!row) return;

            // Extract data from the row
            const instanceCode = row.querySelector('.text-sm.text-gray-900:first-child')?.textContent || 'N/A';
            const maintenanceType = row.querySelector('.bg-emerald-100, .bg-red-100, .bg-violet-100, .bg-blue-100, .bg-gray-100')?.textContent || 'Unknown';
            const description = row.querySelector('.text-sm.text-gray-900')?.textContent || 'No description provided';
            const notes = row.querySelector('.text-sm.text-gray-500')?.textContent || 'No additional notes';
            const date = row.querySelector('.text-sm.text-gray-900.font-medium')?.textContent || 'No date';
            const time = row.querySelector('.text-sm.text-gray-500')?.textContent || 'No time';
            const performedBy = row.querySelector('.text-sm.text-gray-900:last-child')?.textContent || 'Not specified';

            // Get the maintenance record data from the backend
            // API call removed - using table data directly
                .then(response => response.json())
                .then(data => {
                    // Populate modal content with actual data
                    const content = document.getElementById('maintenanceDetailsContent');
                    content.innerHTML = `
                        <div class="space-y-6">
                            <!-- Header Info -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                    <div class="text-sm font-medium text-slate-700 mb-1">Maintenance Type</div>
                                    <div class="text-lg font-semibold text-slate-900">${data.maintenance_type || maintenanceType}</div>
                                </div>
                                <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-200">
                                    <div class="text-sm font-medium text-emerald-700 mb-1">Performed By</div>
                                    <div class="text-lg font-semibold text-emerald-900">${data.performed_by || performedBy}</div>
                                </div>
                                <div class="bg-violet-50 p-4 rounded-lg border border-violet-200">
                                    <div class="text-sm font-medium text-violet-700 mb-1">Date</div>
                                    <div class="text-lg font-semibold text-violet-900">${data.maintenance_date || date}</div>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <div class="text-sm font-medium text-blue-700 mb-1">Time</div>
                                    <div class="text-lg font-semibold text-blue-900">${time}</div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="text-sm font-medium text-gray-700 mb-2">Description</div>
                                <div class="text-gray-900">${data.description || description}</div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <div class="text-sm font-medium text-yellow-700 mb-2">Additional Notes</div>
                                <div class="text-gray-900">${data.notes || notes}</div>
                            </div>

                            <!-- Equipment Instances Affected Table -->
                            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                <div class="text-sm font-medium text-orange-700 mb-3">Equipment Instances Affected</div>
                                <div class="text-gray-900">
                                    <p class="text-sm text-gray-600 mb-3">This maintenance record affects the following equipment instances:</p>
                                    <div class="bg-white rounded-lg border border-orange-200 overflow-hidden">
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instance Code</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Before Maintenance</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">After Maintenance</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    ${data.instances && data.instances.length > 0 ? 
                                                        data.instances.map(instance => `
                                                            <tr class="hover:bg-gray-50">
                                                                <td class="px-4 py-3 text-sm font-medium text-gray-900">${instance.instance_code || 'N/A'}</td>
                                                                <td class="px-4 py-3 text-sm">
                                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${getConditionColor(instance.old_condition)}">
                                                                        ${instance.old_condition || 'Not tracked'}
                                                                    </span>
                                                                </td>
                                                                <td class="px-4 py-3 text-sm">
                                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${getConditionColor(instance.new_condition)}">
                                                                        ${instance.new_condition || 'Not tracked'}
                                                                    </span>
                                                                </td>
                                                                <td class="px-4 py-3 text-sm text-gray-900">${instance.location || 'Not available'}</td>
                                                                <td class="px-4 py-3 text-sm text-gray-900">${instance.notes || 'No notes'}</td>
                                                            </tr>
                                                        `).join('') : 
                                                        `<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No equipment instances found</td></tr>`
                                                    }
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="px-4 py-3 bg-slate-50 border-t border-slate-200">
                                            <p class="text-xs text-slate-700">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                <strong>Note:</strong> The "Before Maintenance" condition represents the instance's condition before maintenance, 
                                                while "After Maintenance" shows the updated condition after maintenance was performed.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    // Fallback to basic information if API call fails
                    const content = document.getElementById('maintenanceDetailsContent');
                    content.innerHTML = `
                        <div class="space-y-6">
                            <!-- Header Info -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                                    <div class="text-sm font-medium text-slate-700 mb-1">Maintenance Type</div>
                                    <div class="text-lg font-semibold text-slate-900">${maintenanceType}</div>
                                </div>
                                <div class="bg-emerald-50 p-4 rounded-lg border border-emerald-200">
                                    <div class="text-sm font-medium text-emerald-700 mb-1">Performed By</div>
                                    <div class="text-lg font-semibold text-emerald-900">${performedBy}</div>
                                </div>
                                <div class="bg-violet-50 p-4 rounded-lg border border-violet-200">
                                    <div class="text-sm font-medium text-violet-700 mb-1">Date</div>
                                    <div class="text-lg font-semibold text-violet-900">${date}</div>
                                </div>
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <div class="text-sm font-medium text-blue-700 mb-1">Time</div>
                                    <div class="text-lg font-semibold text-blue-900">${time}</div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="text-sm font-medium text-gray-700 mb-2">Description</div>
                                <div class="text-gray-900">${description}</div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                                <div class="text-sm font-medium text-yellow-700 mb-2">Additional Notes</div>
                                <div class="text-gray-900">${notes}</div>
                            </div>

                            <!-- Equipment Instance Information -->
                            <div class="bg-orange-50 p-4 rounded-lg border border-orange-200">
                                <div class="text-sm font-medium text-orange-700 mb-2">Equipment Instance Information</div>
                                <div class="text-gray-900">
                                    <p class="text-sm text-gray-600 mb-2">This maintenance record affects the following equipment instance:</p>
                                    <div class="bg-white p-3 rounded border border-orange-200">
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-700">Instance Code:</span>
                                                <span class="text-sm text-gray-900 bg-gray-100 px-2 py-1 rounded">Available in database</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-700">Old Condition (Current):</span>
                                                <span class="text-sm text-gray-900 bg-gray-100 px-2 py-1 rounded">Not currently tracked</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-700">New Condition (Updated):</span>
                                                <span class="text-sm text-gray-900 bg-gray-100 px-2 py-1 rounded">Not currently tracked</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm font-medium text-gray-700">Location:</span>
                                                <span class="text-sm text-gray-900 bg-gray-100 px-2 py-1 rounded">Available in database</span>
                                            </div>
                                        </div>
                                        <div class="mt-4 p-3 bg-slate-50 rounded border border-slate-200">
                                            <p class="text-xs text-slate-700">
                                                <i class="fas fa-lightbulb mr-1"></i>
                                                <strong>Note:</strong> To track condition changes, the system would need additional fields 
                                                for 'old_condition' and 'new_condition' in the maintenance records table.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

            // Show modal
            document.getElementById('maintenanceDetailsModal').classList.remove('hidden');
        }

        // Hide maintenance details modal
        function hideMaintenanceDetails() {
            document.getElementById('maintenanceDetailsModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('maintenanceDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideMaintenanceDetails();
            }
        });
    </script>
</x-app-layout>
