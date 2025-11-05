<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Equipment Type Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment Types', 'url' => route('equipment-types.index')],
                ['label' => $equipmentType->name]
            ]" />
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900 mb-2">{{ $equipmentType->name }}</h3>
                        <p class="text-blue-700 font-medium">{{ $equipmentType->description ?? 'No description provided' }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <x-form-button variant="primary" size="md" href="{{ route('equipment-types.edit', $equipmentType) }}" icon="fas fa-edit">
                            Edit Equipment Type
                        </x-form-button>
                        <x-form-button variant="secondary" size="md" href="{{ route('equipment-types.index') }}" icon="fas fa-arrow-left">
                            Back to List
                        </x-form-button>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                            <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                                Basic Information
                            </h4>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Equipment Type Name</label>
                                    <p class="text-xl font-bold text-gray-900 bg-white p-4 rounded-lg border shadow-sm">{{ $equipmentType->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-base font-bold bg-red-100 text-red-800 border shadow-sm">
                                        <i class="fas fa-tag mr-2"></i>
                                        {{ $equipmentType->category->name }}
                                    </span>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                    <p class="text-base font-medium text-gray-900 bg-white p-4 rounded-lg border shadow-sm min-h-[60px]">{{ $equipmentType->description ?: 'No description provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                            <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                <i class="fas fa-chart-bar mr-3 text-blue-600"></i>
                                Statistics
                            </h4>
                            
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Equipment</label>
                                    <p class="text-4xl font-bold text-blue-600">{{ optional($equipmentType->equipment)->count() ?? 0 }}</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">equipment items</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Available Equipment</label>
                                    <p class="text-4xl font-bold text-green-600">{{ optional($equipmentType->equipment)->where('is_active', true)->count() ?? 0 }}</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">active items</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Reservations</label>
                                    <p class="text-4xl font-bold text-purple-600">{{ optional($equipmentType->equipment)->sum(function($equipment) { return optional($equipment->reservations)->count() ?? 0; }) ?? 0 }}</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">reservations</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Created</label>
                                    <p class="text-base font-bold text-gray-900">{{ $equipmentType->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Last Updated</label>
                                    <p class="text-base font-bold text-gray-900">{{ $equipmentType->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment List -->
                    @if(optional($equipmentType->equipment)->count() > 0)
                        <div class="mt-8">
                            <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                                <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                    <i class="fas fa-list mr-3 text-blue-600"></i>
                                    Associated Equipment
                                </h4>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Name</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Brand</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Model</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach(optional($equipmentType->equipment) as $equipment)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-base font-bold text-gray-900">{{ $equipment->name }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $equipment->brand ?: 'N/A' }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $equipment->model ?: 'N/A' }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $equipment->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                            <i class="fas {{ $equipment->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                                            {{ $equipment->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('equipment-management.show', $equipment) }}" class="text-blue-600 hover:text-blue-900 font-bold">
                                                            <i class="fas fa-eye mr-1"></i>View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mt-8">
                            <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-6xl text-blue-400 mb-4"></i>
                                    <h4 class="text-xl font-bold text-blue-900 mb-2">No Equipment Found</h4>
                                    <p class="text-blue-700 font-medium">This equipment type doesn't have any associated equipment yet.</p>
                                </div>
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
                    title: '',
                    html: `
                        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                            <h2 class="text-xl font-bold">Success!</h2>
                        </div>
                        <div class="flex items-center justify-center mb-4">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-center text-gray-700">{{ session('success') }}</p>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all transform hover:scale-105" onclick="Swal.close()">
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
    </script>
</x-app-layout>
