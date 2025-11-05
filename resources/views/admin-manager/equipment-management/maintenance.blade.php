<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Equipment Maintenance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with Actions -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg shadow-sm mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Maintenance for: {{ $equipment->name }}
                            </h3>
                            <p class="text-gray-600">{{ $equipment->model ?: 'No model' }} • {{ $equipment->category->name }}</p>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('maintenance-management.create-record', $equipment) }}" 
                               style="background: linear-gradient(to right, #10b981, #059669); color: white; padding: 12px 16px; border-radius: 8px; border: none; font-weight: 600; transition: all 0.2s; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); display: inline-flex; align-items: center; text-decoration: none;"
                               onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0, 0, 0, 0.15)'"
                               onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Record
                            </a>
                            <a href="{{ route('equipment-management.show', $equipment) }}" 
                               style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; padding: 12px 16px; border-radius: 8px; border: none; font-weight: 600; transition: all 0.2s; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); display: inline-flex; align-items: center; text-decoration: none;"
                               onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0, 0, 0, 0.15)'"
                               onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View Equipment
                            </a>
                            <a href="{{ route('equipment-management.index') }}" 
                               style="background: linear-gradient(to right, #6b7280, #4b5563); color: white; padding: 12px 16px; border-radius: 8px; border: none; font-weight: 500; transition: all 0.2s; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); display: inline-flex; align-items: center; text-decoration: none;"
                               onmouseover="this.style.background='linear-gradient(to right, #4b5563, #374151)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)'"
                               onmouseout="this.style.background='linear-gradient(to right, #6b7280, #4b5563)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Equipment Maintenance Info -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Maintenance Information</h4>
                            
                            <div class="space-y-4">
                                
                                

                                @if($equipment->warranty_expiry)
                                    <div>
                                        <span class="text-sm text-gray-600">Warranty Expiry:</span>
                                        <div class="mt-1">
                                            @if($equipment->warranty_expiry <= now())
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Expired: {{ $equipment->warranty_expiry->format('M d, Y') }}
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Valid until: {{ $equipment->warranty_expiry->format('M d, Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div>
                                    <span class="text-sm text-gray-600">Total Records:</span>
                                    <p class="text-sm font-medium text-gray-900">{{ $maintenanceRecords->count() }}</p>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Maintenance Records -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="mb-4">
                                <h4 class="text-md font-medium text-gray-900">Maintenance Records</h4>
                            </div>

                            @if($maintenanceRecords->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performed</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performed By</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($maintenanceRecords as $record)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ $record->maintenance_type }}</div>
                                                            <div class="text-sm text-gray-500">{{ Str::limit($record->description, 50) }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $record->maintenance_date->format('M d, Y') }}</div>
                                                        <div class="text-sm text-gray-500">{{ $record->created_at->format('g:i A') }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $record->performed_by ?: 'Not specified' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        @if($record->cost)
                                                            <span class="text-sm font-medium text-gray-900">${{ number_format($record->cost, 2) }}</span>
                                                        @else
                                                            <span class="text-sm text-gray-500">Not specified</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <div class="flex space-x-2">
                                                            <a href="{{ route('maintenance-management.edit-record', $record) }}" 
                                                               class="text-indigo-600 hover:text-indigo-900">
                                                                <i class="fas fa-edit mr-1"></i>Edit
                                                            </a>
                                                            <button type="button" 
                                                                    onclick="showDeleteMaintenanceConfirmation('{{ $record->id }}', '{{ $record->maintenance_type }}')"
                                                                    class="text-red-600 hover:text-red-900">
                                                                <i class="fas fa-trash mr-1"></i>Delete
                                                            </button>
                                                            
                                                            <!-- Hidden form for deletion -->
                                                            <form id="delete-maintenance-form-{{ $record->id }}" 
                                                                  method="POST" 
                                                                  action="{{ route('maintenance-management.delete-record', $record) }}" 
                                                                  class="hidden">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if($maintenanceRecords->hasPages())
                                    <div class="mt-6">
                                        {{ $maintenanceRecords->links() }}
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No maintenance records</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by adding your first maintenance record.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Delete Maintenance Record Confirmation Modal
        function showDeleteMaintenanceConfirmation(recordId, maintenanceType) {
            Swal.fire({
                title: 'Delete Maintenance Record?',
                html: `Are you sure you want to delete the maintenance record for <strong>${maintenanceType}</strong>? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Delete Record',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-maintenance-form-${recordId}`).submit();
                }
            });
        }
    </script>
</x-app-layout>
