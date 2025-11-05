<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Incident Report Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Incident Reports', 'url' => route('instructor.incidents.index')],
                ['label' => $incident->incident_code]
            ]" />

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Incident Report: {{ $incident->incident_code }}</h3>
                        <p class="text-gray-600 font-medium">Reported on {{ $incident->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            @if($incident->status === 'reported') bg-blue-100 text-blue-800
                            @elseif($incident->status === 'investigating') bg-yellow-100 text-yellow-800
                            @elseif($incident->status === 'resolved') bg-green-100 text-green-800
                            @elseif($incident->status === 'closed') bg-gray-100 text-gray-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($incident->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Incident Details -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Incident Details
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reported</label>
                                    <p class="text-gray-900">{{ $incident->created_at->format('M d, Y \a\t H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                        @if($incident->status === 'reported') bg-blue-100 text-blue-800
                                        @elseif($incident->status === 'investigating') bg-yellow-100 text-yellow-800
                                        @elseif($incident->status === 'resolved') bg-green-100 text-green-800
                                        @elseif($incident->status === 'closed') bg-gray-100 text-gray-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($incident->status) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $incident->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-blue-50 border-l-4 border-blue-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-blue-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Equipment Information
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reservation</label>
                                    <a href="{{ route('instructor.reservations.show', $incident->reservation) }}" 
                                       class="text-lg font-semibold text-blue-600 hover:text-blue-800">
                                        {{ $incident->reservation->reservation_code ?? ('#'.$incident->reservation_id) }}
                                    </a>
                                    <p class="text-sm text-gray-600">
                                        {{ $incident->reservation->borrow_date }} to {{ $incident->reservation->return_date }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Equipment Count</label>
                                    <p class="text-lg font-semibold text-gray-900">
                                        @php
                                            $instancesRaw = $incident->equipment_instances;
                                            $instances = is_array($instancesRaw)
                                                ? $instancesRaw
                                                : (is_string($instancesRaw) ? (json_decode($instancesRaw, true) ?: []) : []);
                                            $equipmentCount = !empty($instances) ? count($instances) : 1;
                                        @endphp
                                        {{ $equipmentCount }} Equipment Instance{{ $equipmentCount > 1 ? 's' : '' }}
                                    </p>
                                </div>
                            </div>
                            
                            @php
                                $instancesRaw = $incident->equipment_instances;
                                $instances = is_array($instancesRaw)
                                    ? $instancesRaw
                                    : (is_string($instancesRaw) ? (json_decode($instancesRaw, true) ?: []) : []);
                            @endphp
                            @if(!empty($instances) && count($instances) > 0)
                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Equipment Instances</label>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-red-600">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment</th>
                                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Instance</th>
                                                    <th class="px-4 py-2 text-left text-xs font-bold text-white uppercase tracking-wider">Severity</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($instances as $instanceId)
                                                @php
                                                    $instance = \App\Models\EquipmentInstance::find($instanceId);
                                                    $sevRaw = $incident->equipment_severities;
                                                    $sevMap = is_array($sevRaw) ? $sevRaw : (is_string($sevRaw) ? (json_decode($sevRaw, true) ?: []) : []);
                                                    $severity = $sevMap[$instanceId] ?? 'unknown';
                                                @endphp
                                                @if($instance)
                                                <tr>
                                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $instance->equipment->brand }} {{ $instance->equipment->model }}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $instance->instance_code }}</td>
                                                    <td class="px-4 py-2">
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                            @if($severity === 'low') bg-green-100 text-green-800
                                                            @elseif($severity === 'medium') bg-yellow-100 text-yellow-800
                                                            @elseif($severity === 'high') bg-orange-100 text-orange-800
                                                            @elseif($severity === 'critical') bg-red-100 text-red-800
                                                            @elseif($severity === 'needs_repair') bg-orange-100 text-orange-800
                                                            @elseif($severity === 'damaged') bg-red-100 text-red-800
                                                            @elseif($severity === 'lost') bg-red-100 text-red-800
                                                            @else bg-gray-100 text-gray-800 @endif">{{ ucfirst(str_replace('_', ' ', $severity)) }}</span>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @elseif($incident->equipmentInstance)
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Equipment Instance</label>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $incident->equipmentInstance->equipment->brand }} {{ $incident->equipmentInstance->equipment->model }}</p>
                                                <p class="text-sm text-gray-600">Instance: {{ $incident->equipmentInstance->instance_code }}</p>
                                            </div>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($incident->severity === 'low') bg-green-100 text-green-800
                                                @elseif($incident->severity === 'medium') bg-yellow-100 text-yellow-800
                                                @elseif($incident->severity === 'high') bg-orange-100 text-orange-800
                                                @elseif($incident->severity === 'critical') bg-red-100 text-red-800
                                                @elseif($incident->severity === 'needs_repair') bg-orange-100 text-orange-800
                                                @elseif($incident->severity === 'damaged') bg-red-100 text-red-800
                                                @elseif($incident->severity === 'lost') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $incident->severity)) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Student Involvement -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-yellow-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Student Involvement
                            </h4>
                        </div>
                        <div class="p-6">
                            @php
                                $studentsRaw = $incident->students;
                                $students = is_array($studentsRaw) ? $studentsRaw : (is_string($studentsRaw) ? (json_decode($studentsRaw, true) ?: []) : []);
                            @endphp

                            @if(!empty($students))
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Students Involved</label>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($students as $student)
                                                    <tr>
                                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $student['name'] ?? 'N/A' }}</td>
                                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $student['email'] ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                                        <p class="text-gray-900">{{ $incident->student_name ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <p class="text-gray-900">{{ $incident->student_email ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Student ID</label>
                                        <p class="text-gray-900">{{ $incident->student_id ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Involvement Details</label>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $incident->student_involvement ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    @if($incident->action_taken)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="bg-green-50 border-l-4 border-green-500 px-6 py-4">
                            <h4 class="text-lg font-semibold text-green-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Immediate Action Taken
                            </h4>
                        </div>
                        <div class="p-6">
                            <div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-gray-900 whitespace-pre-wrap">{{ $incident->action_taken }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    

                    <!-- Reporter Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Reporter</h4>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $incident->reporter->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $incident->reporter->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resolution Notes -->
                    @if($incident->resolution_notes)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Resolution Notes</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $incident->resolution_notes }}</p>
                            </div>
                            @if($incident->resolver)
                                <div class="mt-3">
                                    <p class="text-xs text-gray-500">Resolved by: {{ $incident->resolver->name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Actions</h4>
                            <div class="space-y-2">
                                <a href="{{ route('instructor.incidents.index') }}" 
                                   style="background: linear-gradient(to right, #6b7280, #4b5563); color: white; width: 100%; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; font-weight: 500;"
                                   onmouseover="this.style.background='linear-gradient(to right, #4b5563, #374151)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                   onmouseout="this.style.background='linear-gradient(to right, #6b7280, #4b5563)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Back to Reports
                                </a>
                                <a href="{{ route('instructor.incidents.export-pdf', $incident) }}" 
                                   target="_blank"
                                   style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; width: 100%; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; font-weight: 500;"
                                   onmouseover="this.style.background='linear-gradient(to right, #b91c1c, #991b1b)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                   onmouseout="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Generate Report (PDF)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="hideImageModal()">
        <div class="max-w-5xl w-full px-4" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="Attachment" class="w-full h-auto rounded shadow-2xl">
        </div>
    </div>

    <script>
        function showImageModal(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            img.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function hideImageModal() {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            img.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>
