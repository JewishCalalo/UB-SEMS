<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Category Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment Categories', 'url' => route('equipment-categories.index')],
                ['label' => $category->name]
            ]" />
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-red-900 mb-2">{{ $category->name }}</h3>
                        <p class="text-red-700 font-medium">{{ $category->description ?? 'No description provided' }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <x-form-button variant="danger" size="md" href="{{ route('equipment-categories.edit', $category) }}" icon="fas fa-edit">
                            Edit Category
                        </x-form-button>
                        <x-form-button variant="secondary" size="md" href="{{ route('equipment-categories.index') }}" icon="fas fa-arrow-left">
                            Back to List
                        </x-form-button>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div class="bg-red-50/60 p-6 rounded-xl border border-red-100">
                            <h4 class="text-xl font-bold text-red-900 mb-6 flex items-center">
                                <i class="fas fa-info-circle mr-3 text-red-600"></i>
                                Basic Information
                            </h4>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Category Name</label>
                                    <p class="text-xl font-bold text-gray-900 bg-white p-4 rounded-lg border shadow-sm">{{ $category->name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                    <p class="text-base font-medium text-gray-900 bg-white p-4 rounded-lg border shadow-sm min-h-[60px]">{{ $category->description ?: 'No description provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="bg-red-50/60 p-6 rounded-xl border border-red-100">
                            <h4 class="text-xl font-bold text-red-900 mb-6 flex items-center">
                                <i class="fas fa-chart-bar mr-3 text-red-600"></i>
                                Statistics
                            </h4>
                            
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Equipment Count</label>
                                    <p class="text-4xl font-bold text-red-600">{{ $category->equipment->count() }}</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">equipment items</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Equipment Types</label>
                                    <p class="text-4xl font-bold text-blue-600">{{ $category->equipmentTypes->count() }}</p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">equipment types</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Created</label>
                                    <p class="text-base font-bold text-gray-900">{{ $category->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Last Updated</label>
                                    <p class="text-base font-bold text-gray-900">{{ $category->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($category->equipment->count() > 0)
                        <!-- Associated Equipment -->
                        <div class="mt-8">
                            <div class="bg-red-50/60 p-6 rounded-xl border border-red-100">
                                <h4 class="text-xl font-bold text-red-900 mb-6 flex items-center">
                                    <i class="fas fa-cogs mr-3 text-red-600"></i>
                                    Associated Equipment
                                </h4>
                                <div class="bg-white rounded-lg p-6 border shadow-sm">
                                    <p class="text-base font-bold text-gray-700 mb-2">This category is currently used by {{ $category->equipment->count() }} equipment item(s).</p>
                                    <p class="text-sm font-medium text-gray-600">To delete this category, you must first remove or reassign all associated equipment.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($category->equipmentTypes->count() > 0)
                        <!-- Associated Equipment Types -->
                        <div class="mt-8">
                            <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                                <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                    <i class="fas fa-tags mr-3 text-blue-600"></i>
                                    Associated Equipment Types
                                </h4>
                                <div class="bg-white rounded-lg p-6 border shadow-sm">
                                    <p class="text-base font-bold text-blue-700 mb-2">This category has {{ $category->equipmentTypes->count() }} equipment type(s) defined.</p>
                                    <p class="text-sm font-medium text-blue-600">Equipment types help organize equipment within this category.</p>
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
