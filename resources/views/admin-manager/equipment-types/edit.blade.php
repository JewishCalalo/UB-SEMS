<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Edit Equipment Type') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment Types', 'url' => route('equipment-types.index')],
                ['label' => 'Edit']
            ]" />
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900 mb-2">Edit Equipment Type</h3>
                        <p class="text-blue-700 font-medium">Update equipment type information: {{ $equipmentType->name }}</p>
                    </div>
                    <x-form-button variant="secondary" size="md" href="{{ route('equipment-types.index') }}" icon="fas fa-arrow-left">
                        Back to List
                    </x-form-button>
                </div>
            </div>

            <!-- User-Friendly Error Notification Card -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-bold text-red-800 mb-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Please Review the Form
                            </h3>
                            <div class="text-sm text-red-700">
                                <ul class="mt-2 list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-3">
                                <p class="text-xs text-red-600">
                                    <i class="fas fa-lightbulb mr-1"></i>
                                    <strong>Tip:</strong> Please fill in all required fields marked with an asterisk (*). Equipment type names are case-insensitive within the same category.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('equipment-types.update', $equipmentType) }}" class="space-y-6" id="editTypeForm" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <!-- Equipment Type Information Section -->
                        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                            <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                <i class="fas fa-cog mr-3"></i>
                                Equipment Type Information
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                                    <div class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-md text-base font-medium text-blue-900">
                                        <div class="flex items-center">
                                            <i class="fas fa-tag mr-2 text-blue-600"></i>
                                            {{ $equipmentType->category->name }}
                                        </div>
                                    </div>
                                    <input type="hidden" name="category_id" value="{{ $equipmentType->category_id }}">
                                    <p class="mt-2 text-sm text-gray-600">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Category cannot be changed to maintain data integrity
                                    </p>
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Equipment Type Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $equipmentType->name) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base font-medium"
                                           placeholder="e.g., Ball, Racket, Net">
                                    <div id="name-error" class="mt-2 text-sm text-red-600 hidden"></div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 font-medium">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description (Optional)</label>
                                <textarea name="description" id="description" rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base font-medium"
                                          placeholder="Describe what this equipment type is used for...">{{ old('description', $equipmentType->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600 font-medium">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-6 border-t border-gray-200">
                            <div class="text-sm text-gray-600"><span class="text-blue-600 font-semibold">*</span> Required fields</div>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <x-form-button type="button" variant="secondary" onclick="window.history.back()">Cancel</x-form-button>
                                <x-form-button type="submit" variant="primary" icon="fas fa-save">Update Equipment Type</x-form-button>
                            </div>
                        </div>
                    </form>
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
                            <h2 class="text-xl font-bold text-center">Equipment Type Updated!</h2>
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
            const form = document.getElementById('editTypeForm');
            const nameInput = document.getElementById('name');
            const nameError = document.getElementById('name-error');
            const originalName = '{{ $equipmentType->name }}';
            const categoryId = '{{ $equipmentType->category_id }}';
            
            // Inline validation for duplicate equipment type names
            nameInput.addEventListener('blur', function() {
                const typeName = this.value.trim();
                if (typeName && typeName !== originalName) {
                    checkTypeDuplicate(typeName, categoryId);
                }
            });
            
            // Real-time validation on input
            nameInput.addEventListener('input', function() {
                const typeName = this.value.trim();
                if (typeName.length > 2 && typeName !== originalName) {
                    checkTypeDuplicate(typeName, categoryId);
                } else {
                    // Clear error if input is too short or same as original
                    nameError.classList.add('hidden');
                    nameInput.classList.remove('border-red-500');
                    nameInput.classList.add('border-gray-300');
                }
            });
            
            function checkTypeDuplicate(name, categoryId) {
                fetch('{{ route("equipment-types.check-duplicate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name: name, category_id: categoryId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        nameError.textContent = `An equipment type with the name '${name}' already exists in the selected category. Please choose a different name.`;
                        nameError.classList.remove('hidden');
                        nameInput.classList.add('border-red-500');
                        nameInput.classList.remove('border-gray-300');
                    } else {
                        nameError.classList.add('hidden');
                        nameInput.classList.remove('border-red-500');
                        nameInput.classList.add('border-gray-300');
                    }
                })
                .catch(error => {
                    console.error('Error checking duplicate:', error);
                });
            }
            
            form.addEventListener('submit', function(e) {
                // Only prevent default if there are client-side validation errors
                if (!nameError.classList.contains('hidden') && nameError.textContent) {
                    e.preventDefault();
                    // Show specific error message
                    Swal.fire({
                        title: '',
                        html: `
                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                                <h2 class="text-xl font-bold">Duplicate Equipment Type Name</h2>
                            </div>
                            <div class="flex items-center justify-center mb-4">
                                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-center text-gray-700">${nameError.textContent}</p>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all transform hover:scale-105" onclick="Swal.close()">
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
                }
                // Otherwise, let the form submit normally to show server-side validation
            });
        });
    </script>
</x-app-layout>
