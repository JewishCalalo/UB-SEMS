<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Equipment Types') }}
        </h2>
    </x-slot>
    

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment Types']
            ]" />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with Create Button -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900 mb-2">Manage Equipment Types</h3>
                        <p class="text-blue-700 font-medium">Organize equipment types within categories for better classification</p>
                    </div>
                    <x-form-button variant="primary" size="md" href="{{ route('equipment-types.create') }}" icon="fas fa-plus">
                        Add Equipment Type
                    </x-form-button>
                </div>
            </div>

            <!-- Sub-Navigation Tabs -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg mb-6 overflow-hidden">
                <nav class="flex" aria-label="Tabs">
                    <a href="{{ route('equipment-categories.index') }}" 
                       class="flex-1 flex items-center justify-center px-8 py-6 text-lg font-semibold {{ request()->routeIs('equipment-categories.*') ? 'text-white bg-gradient-to-r from-red-600 to-red-700' : 'text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 hover:text-gray-900' }} transition-all duration-300 hover:from-red-700 hover:to-red-800 relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-red-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <svg class="w-6 h-6 mr-3 relative z-10 {{ request()->routeIs('equipment-categories.*') ? 'text-white' : 'text-gray-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="relative z-10 {{ request()->routeIs('equipment-categories.*') ? 'text-white' : 'text-gray-700' }}">Categories</span>
                        @if(request()->routeIs('equipment-categories.*'))
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-white opacity-80"></div>
                        @endif
                    </a>
                    <a href="{{ route('equipment-types.index') }}" 
                       class="flex-1 flex items-center justify-center px-8 py-6 text-lg font-semibold {{ request()->routeIs('equipment-types.*') ? 'text-white bg-gradient-to-r from-blue-600 to-blue-700' : 'text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 hover:text-gray-900' }} transition-all duration-300 hover:from-blue-700 hover:to-blue-800 relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-blue-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                        <svg class="w-6 h-6 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="relative z-10">Equipment Types</span>
                        @if(request()->routeIs('equipment-types.*'))
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-white opacity-80"></div>
                        @endif
                    </a>
                </nav>
            </div>

            <!-- Action Legend -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm mb-4">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <h4 class="text-sm font-semibold text-blue-800 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Action Legend:
                        </h4>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-blue-700">View Details</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(to right, #eab308, #ca8a04); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-blue-700">Edit Equipment Type</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-blue-700">Delete Equipment Type</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(to right, #9ca3af, #6b7280); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-blue-700">Cannot Delete (Has Equipment)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Types Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Equipment Types
                    </h4>
                    
                    @if($equipmentTypes->count() > 0)
                        <x-table-toolbar />
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment Count</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($equipmentTypes as $equipmentType)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $equipmentType->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $equipmentType->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    {{ Str::limit($equipmentType->description, 100) ?: 'No description' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $equipmentType->equipment->count() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('equipment-types.show', $equipmentType) }}" 
                                                       style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-decoration: none;"
                                                       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                       title="View Details">
                                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    <a href="{{ route('equipment-types.edit', $equipmentType) }}" 
                                                       style="background: linear-gradient(to right, #eab308, #ca8a04); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-decoration: none;"
                                                       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                       title="Edit Equipment Type">
                                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    @if($equipmentType->equipment->count() == 0)
                                                                                                                <button type="button" 
                                                                id="delete_type_btn_{{ $equipmentType->id }}"
                                                                onclick="showDeleteTypeConfirmation('{{ $equipmentType->id }}', '{{ $equipmentType->name }}')"
                                                                style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); border: none; cursor: pointer;"
                                                                onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Delete Equipment Type">
                                                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>




                                                    @else
                                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-500 border border-gray-300 cursor-not-allowed" title="Cannot delete - has associated equipment">
                                                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $equipmentTypes->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment types</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new equipment type.</p>
                            <div class="mt-6">
                                <a href="{{ route('equipment-types.create') }}" 
                                   style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px;"
                                   onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(0, 0, 0, 0.2)'"
                                   onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                                    <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Equipment Type
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show success modal if there's a success message
            @if(session('success'))
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Equipment Type {{ str_contains(session('success'), 'created') ? 'Created' : 'Updated' }}!</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700">{{ session('success') }}</p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close()">
                                OK
                            </button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            @endif
        });

        // Delete Equipment Type Confirmation Modal
        function showDeleteTypeConfirmation(typeId, typeName) {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Delete Equipment Type</h2>
                    </div>
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <p class="text-center">Are you sure you want to delete <strong>${typeName}</strong>? This action cannot be undone.</p>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105" onclick="deleteEquipmentType('${typeId}')">
                            Delete Type
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        }

        // Function to handle equipment type deletion
        function deleteEquipmentType(typeId) {
            // Use AJAX with loading states
            const buttonId = `delete_type_btn_${typeId}`;
            
            ActionHandler.handleAjaxAction(buttonId, `{{ route('equipment-types.destroy', ':id') }}`.replace(':id', typeId), {
                method: 'POST',
                data: { 
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                loadingText: 'Deleting...',
                successTitle: 'Type Deleted!',
                successMessage: 'The equipment type has been deleted successfully.',
                errorTitle: 'Deletion Failed',
                errorMessage: `Failed to delete equipment type. Please try again.`,
                onSuccess: () => {
                    // Reload page after successful deletion
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            });
        }

    </script>
</x-app-layout>
