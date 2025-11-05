<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Incident Reports') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Incident Reports']
            ]" />

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Incident Reports</h3>
                        <p class="text-gray-600 font-medium">Report and track equipment incidents during your classes.</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('instructor.incidents.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            Report Incident
                        </a>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('instructor.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:ring-2 focus:ring-gray-300 shadow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back
                </a>
                
            </div>

            <!-- Incidents Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-table mr-2 text-gray-600"></i>
                        My Incident Reports
                    </h4>
                    
                    @if($incidents->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Incident Code</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Reservation</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment Count</th>
                                        
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Reported</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($incidents as $incident)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">{{ $incident->incident_code }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">#{{ $incident->reservation_id }}</div>
                                                <div class="text-sm text-gray-500">{{ $incident->reservation->borrow_date->format('M d, Y') }} to {{ $incident->reservation->return_date->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @php
                                                        $instances = $incident->equipment_instances;
                                                        if (is_string($instances)) { $instances = json_decode($instances, true); }
                                                        $equipmentCount = is_array($instances) ? count($instances) : 1;
                                                    @endphp
                                                    <div class="flex items-center space-x-3">
                                                        <span class="font-bold text-gray-900">{{ $equipmentCount }}</span>
                                                        <span class="text-gray-600">equipment</span>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    @if($incident->status === 'reported') bg-blue-100 text-blue-800
                                                    @elseif($incident->status === 'investigating') bg-yellow-100 text-yellow-800
                                                    @elseif($incident->status === 'resolved') bg-green-100 text-green-800
                                                    @elseif($incident->status === 'closed') bg-gray-100 text-gray-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($incident->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $incident->created_at->format('M d, Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('instructor.incidents.show', $incident) }}" 
                                                       style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                       onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                       onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                       title="View Details">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <button type="button" onclick="confirmDeleteIncident('{{ route('instructor.incidents.destroy', $incident) }}')"
                                                        style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; border:none; cursor:pointer;"
                                                        onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                        onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                        title="Delete Incident">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $incidents->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No incident reports</h3>
                        <p class="mt-1 text-sm text-gray-500">You haven't reported any incidents yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('instructor.incidents.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Report Incident
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteIncident(url){
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">Delete Incident Report</h2></div>
                    <div class="text-center text-gray-700">This action cannot be undone. Do you want to proceed?</div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                customClass: { popup: 'swal-custom-popup' }
            }).then(async (res)=>{
                if (!res.isConfirmed) return;
                try{
                    const r = await fetch(url, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept':'application/json' }});
                    const j = await r.json();
                    if (!r.ok || !j.success) throw new Error(j.message||'Failed to delete');
                    Swal.fire({
                        buttonsStyling:false,
                        html:`
                            <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">Incident Deleted</h2></div>
                            <div class="text-center text-sm text-gray-700">Incident report deleted successfully.</div>
                        `,
                        showConfirmButton:true,
                        customClass:{ popup:'swal-custom-popup' }
                    }).then(()=> window.location.reload());
                }catch(e){
                    Swal.fire({ icon:'error', title:'Failed', text: e.message || 'Could not delete incident.', customClass:{ popup:'swal-custom-popup' }});
                }
            });
        }
        // Show success modal if there's a success message
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    html: `
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 mb-4">{{ session('success') }}</p>
                        </div>
                    `,
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            });
        @endif

        // Show error modal if there's an error message
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            });
        @endif
    </script>
</x-app-layout>
