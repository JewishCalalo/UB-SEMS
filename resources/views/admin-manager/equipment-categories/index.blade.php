<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Equipment Categories') }}
        </h2>
    </x-slot>
    

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Categories']
            ]" />
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with Create Button -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-red-900 mb-2">Manage Equipment Categories</h3>
                        <p class="text-red-700 font-medium">Organize and manage equipment types and classifications</p>
                    </div>
                    <x-form-button variant="danger" size="md" href="{{ route('equipment-categories.create') }}" icon="fas fa-plus">
                        Add Category
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
                        <svg class="w-6 h-6 mr-3 relative z-10 {{ request()->routeIs('equipment-types.*') ? 'text-white' : 'text-gray-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span class="relative z-10 {{ request()->routeIs('equipment-types.*') ? 'text-white' : 'text-gray-700' }}">Equipment Types</span>
                        @if(request()->routeIs('equipment-types.*'))
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-white opacity-80"></div>
                        @endif
                    </a>
                </nav>
            </div>

            <!-- Action Legend -->
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-lg shadow-sm mb-4">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <h4 class="text-sm font-semibold text-gray-800 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Action Legend:
                        </h4>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; width: 32px; height: 32px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-blue-700">View Details</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); color: white; width: 32px; height: 32px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-blue-700">Edit Category</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; width: 32px; height: 32px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-blue-700">Delete Category</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div style="background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%); color: white; width: 32px; height: 32px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
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

            <!-- Categories Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-tags mr-2 text-gray-600"></i>
                        Equipment Categories
                    </h4>
                    @if($categories->count() > 0)
                        <x-table-toolbar />
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            <a href="{{ route('equipment-categories.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' && request('sort')==='created_at' ? 'desc' : 'asc'])) }}" class="inline-flex items-center gap-1 text-white hover:text-gray-200">
                                                Date Added
                                                <span class="ml-1 inline-flex flex-col leading-none">
                                                    <i class="fas fa-caret-up {{ request('sort')==='created_at' && request('direction')==='asc' ? 'text-white' : 'text-gray-300' }}"></i>
                                                    <i class="fas fa-caret-down {{ request('sort')==='created_at' && request('direction')==='desc' ? 'text-white' : 'text-gray-300' }}"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment Count</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($categories as $category)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $category->name }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    {{ Str::limit($category->description, 100) ?: 'No description' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $category->created_at->format('M d, Y H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $category->equipment_count }} equipment
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('equipment-categories.show', $category) }}" 
                                                       style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; width: 36px; height: 36px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out;"
                                                       onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                                                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'"
                                                       title="View Category Details">
                                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('equipment-categories.edit', $category) }}" 
                                                       style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); color: white; width: 36px; height: 36px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out;"
                                                       onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                                                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'"
                                                       title="Edit Category">
                                                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    @if($category->equipment_count == 0)
                                                        <button type="button" 
                                                                id="delete_category_btn_{{ $category->id }}"
                                                                onclick="showDeleteCategoryConfirmation('{{ $category->id }}', '{{ $category->name }}')"
                                                                style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; width: 36px; height: 36px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out;"
                                                                onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                                                                onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'"
                                                                title="Delete Category">
                                                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                        

                                                    @else
                                                        <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-gray-100 text-gray-500 border border-gray-300 cursor-not-allowed"
                                                              title="Cannot delete category with existing equipment">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            {{ $categories->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating your first equipment category.</p>
                            <div class="mt-6">
                                <a href="{{ route('equipment-categories.create') }}" 
                                   style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out; display: inline-flex; align-items: center; gap: 8px;"
                                   onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                                   onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                                    <i class="fas fa-plus"></i>Add Category
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
                            <h2 class="text-xl font-bold text-center">Category {{ str_contains(session('success'), 'created') ? 'Created' : 'Updated' }}!</h2>
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

        // Delete Category Confirmation Modal
        function showDeleteCategoryConfirmation(categoryId, categoryName) {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Delete Category</h2>
                    </div>
                    <div class="flex items-center justify-center mb-4">
                        <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <p class="text-center">Are you sure you want to delete <strong>${categoryName}</strong>? This action cannot be undone.</p>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105" onclick="deleteEquipmentCategory('${categoryId}')">
                            Delete Category
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

        // Function to handle equipment category deletion
        function deleteEquipmentCategory(categoryId) {
            // Use AJAX with loading states
            const buttonId = `delete_category_btn_${categoryId}`;
            
            ActionHandler.handleAjaxAction(buttonId, `{{ route('equipment-categories.destroy', ':id') }}`.replace(':id', categoryId), {
                method: 'POST',
                data: { 
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                loadingText: 'Deleting...',
                successTitle: 'Category Deleted!',
                successMessage: 'The category has been deleted successfully.',
                errorTitle: 'Deletion Failed',
                errorMessage: `Failed to delete category. Please try again.`,
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
