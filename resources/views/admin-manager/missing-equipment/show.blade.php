<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stolen/Lost Equipment Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Missing Equipment', 'url' => route('missing-equipment.index')],
                ['label' => 'Details']
            ]" />
            @php
                $resolvedIncident = $stolenLostEquipment->incidentReport ?? \App\Models\IncidentReport::query()
                    ->when($stolenLostEquipment->reservation_id, function($q) use ($stolenLostEquipment) {
                        $q->where('reservation_id', $stolenLostEquipment->reservation_id);
                    })
                    ->where(function($q) use ($stolenLostEquipment) {
                        $q->whereJsonContains('equipment_instances', $stolenLostEquipment->equipment_instance_id)
                          ->orWhere('equipment_instance_id', $stolenLostEquipment->equipment_instance_id);
                    })
                    ->latest('id')
                    ->first();
            @endphp
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-red-900 mb-2">{{ $stolenLostEquipment->equipmentInstance->equipment->display_name }}</h3>
                        <p class="text-red-700">Instance: {{ $stolenLostEquipment->equipmentInstance->instance_code }}</p>
                        @if($stolenLostEquipment->reservation)
                            <p class="text-sm text-red-600 mt-1">Reservation Code: <span class="font-semibold">{{ $stolenLostEquipment->reservation->reservation_code }}</span></p>
                        @endif
                    </div>
                    <div class="flex space-x-3">
                        <x-form-button variant="danger" size="md" href="{{ route('missing-equipment.edit', $stolenLostEquipment) }}" icon="fas fa-edit">
                            Edit Record
                        </x-form-button>
                        <x-form-button variant="secondary" size="md" href="{{ route('missing-equipment.index') }}" icon="fas fa-arrow-left">
                            Back to List
                        </x-form-button>
                    </div>
                </div>
            </div>

            <!-- Record Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Equipment Information -->
                        <div class="bg-gray-50/60 p-6 rounded-xl border border-gray-100">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-cog mr-2"></i>
                                Equipment Information
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Equipment Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->equipmentInstance->equipment->display_name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->equipmentInstance->equipment->category->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Instance Code</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->equipmentInstance->instance_code }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Condition</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $stolenLostEquipment->equipmentInstance->condition === 'stolen' ? 'red' : ($stolenLostEquipment->equipmentInstance->condition === 'lost' ? 'orange' : 'yellow') }}-100 text-{{ $stolenLostEquipment->equipmentInstance->condition === 'stolen' ? 'red' : ($stolenLostEquipment->equipmentInstance->condition === 'lost' ? 'orange' : 'yellow') }}-800">
                                        {{ ucfirst($stolenLostEquipment->equipmentInstance->condition) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Incident Information -->
                        <div class="bg-red-50/60 p-6 rounded-xl border border-red-100">
                            <h4 class="text-lg font-semibold text-red-900 mb-4 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Incident Information
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Incident Type</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $stolenLostEquipment->incident_type_color }}-100 text-{{ $stolenLostEquipment->incident_type_color }}-800">
                                        {{ $stolenLostEquipment->incident_type_text }}
                                    </span>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Incident Date</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->incident_date ? $stolenLostEquipment->incident_date->format('M d, Y') : 'Not specified' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Replacement Status</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $stolenLostEquipment->replacement_status_color }}-100 text-{{ $stolenLostEquipment->replacement_status_color }}-800">
                                        {{ $stolenLostEquipment->replacement_status_text }}
                                    </span>
                                </div>
                                
                                @if($stolenLostEquipment->replacement_date)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Replacement Date</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->replacement_date ? $stolenLostEquipment->replacement_date->format('M d, Y') : 'Not specified' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Borrower Information -->
                    <div class="mt-6">
                        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                            <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                Borrower Information
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Borrower Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->borrower_name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Borrower Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->borrower_email ?: optional($stolenLostEquipment->reservation)->email ?: '—' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->borrower_contact_number ?: optional($stolenLostEquipment->reservation)->contact_number ?: '—' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Department</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->borrower_department ?: optional($stolenLostEquipment->reservation)->department ?: '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Incident Description -->
                    @php
                        $linkedIncident = $resolvedIncident ?? null;
                        $incidentDescription = $linkedIncident && !empty($linkedIncident->description)
                            ? $linkedIncident->description
                            : $stolenLostEquipment->incident_description;
                    @endphp
                    @if(!empty($incidentDescription) || ($linkedIncident && $stolenLostEquipment->reservation && $stolenLostEquipment->reservation->user && $stolenLostEquipment->reservation->user->role === 'instructor'))
                        <div class="mt-6">
                            <div class="bg-yellow-50/60 p-6 rounded-xl border border-yellow-100">
                                <h4 class="text-lg font-semibold text-yellow-900 mb-4 flex items-center">
                                    <i class="fas fa-file-alt mr-2"></i>
                                    Incident Description
                                </h4>
                                @if(!empty($incidentDescription))
                                    <p class="text-sm text-gray-700">{{ $incidentDescription }}</p>
                                @else
                                    <p class="text-sm text-gray-500 italic">No description available</p>
                                @endif
                                
                                @if($linkedIncident && $stolenLostEquipment->reservation && $stolenLostEquipment->reservation->user && $stolenLostEquipment->reservation->user->role === 'instructor')
                                    <div class="mt-4 pt-4 border-t border-yellow-200">
                                        <a href="{{ route('incident-reports.show', $linkedIncident->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            <i class="fas fa-external-link-alt mr-2"></i>
                                            View Full Incident Report
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Reservation Information -->
                    @if($stolenLostEquipment->reservation)
                        <div class="mt-6">
                            <div class="bg-purple-50/60 p-6 rounded-xl border border-purple-100">
                                <h4 class="text-lg font-semibold text-purple-900 mb-4 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    Reservation Information
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Reservation Code</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->reservation->reservation_code }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Borrow Date</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->reservation->borrow_date ? $stolenLostEquipment->reservation->borrow_date->format('M d, Y') : 'Not specified' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Return Date</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->reservation->return_date ? $stolenLostEquipment->reservation->return_date->format('M d, Y') : 'Not specified' }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $stolenLostEquipment->reservation->status === 'approved' ? 'green' : ($stolenLostEquipment->reservation->status === 'pending' ? 'yellow' : 'red') }}-100 text-{{ $stolenLostEquipment->reservation->status === 'approved' ? 'green' : ($stolenLostEquipment->reservation->status === 'pending' ? 'yellow' : 'red') }}-800">
                                            {{ ucfirst($stolenLostEquipment->reservation->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Record Actions -->
                    

                    <!-- Record Metadata -->
                    <div class="mt-6">
                        <div class="bg-gray-50/60 p-6 rounded-xl border border-gray-100">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Record Metadata
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created By</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->actedBy->name ?? 'System' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->acted_at ? $stolenLostEquipment->acted_at->format('M d, Y H:i:s') : 'Not specified' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $stolenLostEquipment->updated_at ? $stolenLostEquipment->updated_at->format('M d, Y H:i:s') : 'Not specified' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Incident Report (linked) -->
                    @php
                        $incident = $resolvedIncident ?? null;
                    @endphp
                    @if($incident)
                        <div class="mt-6">
                            <div class="bg-red-50/60 p-6 rounded-xl border border-red-100">
                                <h4 class="text-lg font-semibold text-red-900 mb-4 flex items-center">
                                    <i class="fas fa-file-medical-alt mr-2"></i>
                                    Incident Report
                                </h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Incident Code</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $incident->incident_code }}</p>
                                    </div>

                                    <div>
                                        @php
                                            $perInstanceSeverity = $incident->severity ?? null;
                                            if (is_array($incident->equipment_instances ?? null) && is_array($incident->equipment_severities ?? null)) {
                                                $idx = array_search($stolenLostEquipment->equipment_instance_id, $incident->equipment_instances);
                                                if ($idx !== false && isset($incident->equipment_severities[$idx])) {
                                                    $perInstanceSeverity = $incident->equipment_severities[$idx];
                                                }
                                            }
                                            $sev = strtolower((string) $perInstanceSeverity);
                                            $sevColor = $sev === 'lost' ? 'red' : ($sev === 'damaged' ? 'orange' : ($sev === 'needs_repair' ? 'yellow' : 'gray'));
                                        @endphp
                                        <label class="block text-sm font-medium text-gray-700">Severity</label>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $sevColor }}-100 text-{{ $sevColor }}-800">
                                            {{ ucfirst(str_replace('_', ' ', $perInstanceSeverity)) }}
                                        </span>
                                    </div>
                                </div>

                                @if(!empty($incident->description))
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $incident->description }}</p>
                                    </div>
                                @endif

                                @if(is_array($incident->attachments) && count($incident->attachments) > 0)
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Attachments</label>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                            @foreach($incident->attachments as $att)
                                                <div class="border border-gray-200 rounded-lg p-2">
                                                    <div class="text-xs font-medium text-gray-800 truncate">{{ $att['filename'] ?? 'Attachment' }}</div>
                                                    @if(isset($att['path']) && str_starts_with($att['mime_type'] ?? '', 'image/'))
                                                        <img src="/{{ ltrim($att['path'], '/') }}" class="mt-2 w-full h-28 object-cover rounded" />
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @php
                                    $instancesRaw = $incident->equipment_instances ?? [];
                                    $instanceIds = is_array($instancesRaw) ? $instancesRaw : (is_string($instancesRaw) ? (json_decode($instancesRaw, true) ?: []) : []);
                                    $sevRaw = $incident->equipment_severities ?? [];
                                    $sevMap = is_array($sevRaw) ? $sevRaw : (is_string($sevRaw) ? (json_decode($sevRaw, true) ?: []) : []);
                                @endphp
                                @if(!empty($instanceIds))
                                    <div class="mt-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Instances in this Incident</label>
                                        <div class="overflow-hidden border border-gray-200 rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th class="px-4 py-2 text-left font-semibold text-gray-700">Instance Code</th>
                                                        <th class="px-4 py-2 text-left font-semibold text-gray-700">Reported Severity</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-100">
                                                    @foreach($instanceIds as $iid)
                                                        @php
                                                            $inst = \App\Models\EquipmentInstance::find($iid);
                                                            $sevVal = $sevMap[$iid] ?? ($sevMap[(string)$iid] ?? ($incident->severity ?? 'unknown'));
                                                            $sev = strtolower((string)$sevVal);
                                                            $sevColor = $sev === 'lost' ? 'red' : ($sev === 'damaged' ? 'orange' : ($sev === 'needs_repair' ? 'yellow' : 'gray'));
                                                            $isCurrent = (int)$iid === (int)$stolenLostEquipment->equipment_instance_id;
                                                        @endphp
                                                        @if($inst)
                                                            <tr class="@if($isCurrent) bg-red-50 @endif">
                                                                <td class="px-4 py-2 whitespace-nowrap font-medium text-gray-900">{{ $inst->instance_code }}</td>
                                                                <td class="px-4 py-2">
                                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $sevColor }}-100 text-{{ $sevColor }}-800">{{ ucfirst(str_replace('_',' ', $sevVal)) }}</span>
                                                                    @if($isCurrent)
                                                                        <span class="ml-2 text-xs text-red-700 font-semibold">(This instance)</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-6">
                                    <a href="{{ route('instructor.incidents.show', $incident) }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-sm">
                                        <i class="fas fa-external-link-alt mr-2"></i>
                                        View Full Incident
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (window.Swal) {
                    Swal.fire({
                        title: '',
                        html: `
                            <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Action Completed</h2>
                            </div>
                            <p class="text-gray-700 text-base text-center">{{ session('success') }}</p>
                        `,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#22c55e',
                        buttonsStyling: false,
                        customClass: { confirmButton: 'px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors' }
                    });
                }
            });
        </script>
    @endif
</x-app-layout>
