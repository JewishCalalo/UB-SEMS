<x-app-layout>
    <!-- ADMIN CREATE VIEW MARKER -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Equipment') }}
        </h2>
        <div class="text-xs text-blue-600">ADMIN CREATE VIEW</div>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment Management', 'url' => route('equipment-management.index')],
                ['label' => 'Add New Equipment']
            ]" />

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2 flex items-center">
                                <i class="fas fa-plus-circle mr-3 text-blue-600"></i>
                                Add New Equipment
                            </h3>
                            <p class="text-gray-600">Create a new equipment item with detailed specifications and images</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <x-form-button variant="secondary" size="md" href="{{ route('equipment-management.index') }}" icon="fas fa-arrow-left">
                                Back to Equipment
                            </x-form-button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if($errors->has('duplicate'))
                        <div class="mb-4 rounded-lg overflow-hidden shadow border border-red-200">
                            <div class="bg-gradient-to-r from-red-600 to-pink-600 text-white px-4 py-3">
                                <h4 class="font-semibold">Duplicate Equipment Detected</h4>
                            </div>
                            <div class="bg-red-50 text-red-700 px-4 py-3 text-sm">
                                {{ $errors->first('duplicate') }}
                            </div>
                        </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function(){
                                    const el = document.querySelector('[data-duplicate-error-anchor]') || document.body;
                                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                });
                            </script>
                    @endif

                    <form method="POST" action="{{ route('equipment-management.store') }}" enctype="multipart/form-data" class="space-y-4" novalidate id="equipmentCreateForm" data-duplicate-error-anchor>
                        @csrf
                        @if($errors->any() && !$errors->has('duplicate'))
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-bold text-red-800">Please review the form:</h4>
                                        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1 font-semibold">
                                            @foreach($errors->all() as $m)
                                                <li>{{ $m }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Category and Equipment Type Section -->
                        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100 mb-6">
                            <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                                <i class="fas fa-tags mr-2"></i>
                                Equipment Classification
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <select name="category_id" id="category_id" required aria-required="true"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $selectedCategory) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_category_id">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span></span>
                                    </p>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="equipment_type_id" class="block text-sm font-medium text-gray-700 mb-2">Equipment Type *</label>
                                    <select name="equipment_type_id" id="equipment_type_id" required aria-required="true"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select a category first</option>
                                        @if(isset($equipmentTypesByCategory))
                                            @foreach($equipmentTypesByCategory as $categoryId => $types)
                                                <optgroup label="{{ \App\Models\EquipmentCategory::find($categoryId)->name ?? 'Unknown Category' }}" data-category="{{ $categoryId }}" style="display: none;">
                                                    @foreach($types as $type)
                                                        <option value="{{ $type->id }}" data-category="{{ $type->category_id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_equipment_type_id">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span></span>
                                    </p>
                                    @error('equipment_type_id')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="bg-green-50/60 p-6 rounded-xl border border-green-100">
                                <h4 class="text-lg font-semibold text-green-900 mb-4 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Basic Information
                                </h4>
                                <div class="space-y-4">
                                
                                <div>
                                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                                    <input type="text" name="brand" id="brand" value="{{ old('brand') }}" required aria-required="true"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_brand">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span></span>
                                    </p>
                                    @error('brand')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Model *</label>
                                    <input type="text" name="model" id="model" value="{{ old('model') }}" required aria-required="true"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="e.g., GG7, Voltric, etc.">
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_model">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span></span>
                                    </p>
                                    @error('model')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">Acquisition Date *</label>
                                    <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}" required aria-required="true"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <p class="mt-1 text-sm text-yellow-700 flex items-center hidden" id="warning_purchase_date">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>You entered a future date. Please confirm this is intentional.</span>
                                    </p>
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_purchase_date">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Acquisition date is required</span>
                                    </p>
                                    @error('purchase_date')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                </div>
                            </div>

                            <!-- Quantity and Location -->
                            <div class="bg-purple-50/60 p-6 rounded-xl border border-purple-100">
                                <h4 class="text-lg font-semibold text-purple-900 mb-4 flex items-center">
                                    <i class="fas fa-cubes mr-2"></i>
                                    Quantity & Location
                                </h4>
                                <div class="space-y-4">
                                
                                <div>
                                    <label for="quantity_total" class="block text-sm font-medium text-gray-700 mb-2">Total Quantity *</label>
                                    <input type="number" name="quantity_total" id="quantity_total" value="{{ old('quantity_total', 1) }}" min="1" required aria-required="true"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <p class="mt-1 text-xs text-gray-500">This will create the specified number of individual equipment instances.</p>
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_quantity_total">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span></span>
                                    </p>
                                    @error('quantity_total')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Equipment Condition *</label>
                                    <select name="condition" id="condition" required aria-required="true"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <option value="">Select condition</option>
                                        <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                        <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                    </select>
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_condition">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span></span>
                                    </p>
                                    @error('condition')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                                    <input type="text" name="location" id="location" value="{{ old('location') }}" required aria-required="true"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <p class="mt-1 text-sm text-red-600 flex items-center hidden" id="error_location">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Location is required</span>
                                    </p>
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="bg-orange-50/60 p-6 rounded-xl border border-orange-100 mb-6">
                            <h4 class="text-lg font-semibold text-orange-900 mb-4 flex items-center">
                                <i class="fas fa-images mr-2"></i>
                                Equipment Images
                            </h4>
                            <x-image-upload 
                                name="images" 
                                label="Upload Images" 
                                multiple="true" 
                                description="You can select multiple images. Maximum file size: 2MB each." />
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                            <x-form-button type="button" variant="secondary" size="md" href="{{ route('equipment-management.index') }}" icon="fas fa-times">
                                Cancel
                            </x-form-button>
                            <x-form-button type="submit" variant="primary" size="md" icon="fas fa-save" id="createEquipmentButton" disabled>
                                Create Equipment
                            </x-form-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dynamic Equipment Type dropdown based on selected Category
        document.getElementById('category_id').addEventListener('change', function() {
            const categoryId = this.value;
            const equipmentTypeSelect = document.getElementById('equipment_type_id');
            
            // Hide all optgroups first
            const optgroups = equipmentTypeSelect.querySelectorAll('optgroup');
            optgroups.forEach(optgroup => {
                optgroup.style.display = 'none';
            });
            
            // Clear current selection
            equipmentTypeSelect.value = '';
            
            if (categoryId) {
                // Show only the optgroup for the selected category
                const targetOptgroup = equipmentTypeSelect.querySelector(`optgroup[data-category="${categoryId}"]`);
                if (targetOptgroup) {
                    targetOptgroup.style.display = 'block';
                }
            }
        });

        // Initialize equipment types if category is pre-selected
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category_id');
            if (categorySelect.value) {
                categorySelect.dispatchEvent(new Event('change'));
            }
            // Inline validation and submit locking
            const form = document.getElementById('equipmentCreateForm');
            const submitBtn = document.getElementById('createEquipmentButton');
            const requiredFields = [
                'brand', 'model', 'category_id', 'equipment_type_id', 'quantity_total', 'condition', 'purchase_date', 'location'
            ].map(id => document.getElementById(id));

            const errorMap = {
                brand: 'Brand is required',
                model: 'Model is required',
                category_id: 'Please choose a category',
                equipment_type_id: 'Please choose an equipment type',
                quantity_total: 'Enter a quantity of at least 1',
                condition: 'Please choose a condition',
                purchase_date: 'Acquisition date is required',
                location: 'Location is required'
            };

            function setError(el, message){
                const errorEl = document.getElementById('error_' + el.id);
                if (!errorEl) return;
                if (message) {
                    errorEl.classList.remove('hidden');
                    errorEl.querySelector('span').textContent = message;
                    el.classList.add('border-red-500');
                } else {
                    errorEl.classList.add('hidden');
                    errorEl.querySelector('span').textContent = '';
                    el.classList.remove('border-red-500');
                }
            }

            function isFieldValid(el) {
                if (!el) return true;
                if (el.type === 'number') {
                    const val = el.value.trim();
                    const num = Number(val);
                    const ok = val !== '' && Number.isFinite(num) && num >= 1;
                    setError(el, ok ? '' : errorMap[el.id]);
                    return ok;
                }
                const ok = el.value && el.value.toString().trim() !== '';
                setError(el, ok ? '' : errorMap[el.id]);
                return ok;
            }

            function updateSubmitState() {
                const allValid = requiredFields.every(isFieldValid);
                if (allValid) {
                    submitBtn.removeAttribute('disabled');
                    submitBtn.classList.remove('opacity-50','pointer-events-none','cursor-not-allowed');
                    submitBtn.setAttribute('aria-disabled','false');
                } else {
                    submitBtn.setAttribute('disabled', 'disabled');
                    submitBtn.classList.add('opacity-50','pointer-events-none','cursor-not-allowed');
                    submitBtn.setAttribute('aria-disabled','true');
                }
            }

            requiredFields.forEach(el => {
                if (!el) return;
                el.addEventListener('input', updateSubmitState);
                el.addEventListener('change', updateSubmitState);
                el.addEventListener('blur', () => isFieldValid(el));
            });

            updateSubmitState();

            // Future-date soft warning
            const purchaseDateEl = document.getElementById('purchase_date');
            const warningEl = document.getElementById('warning_purchase_date');
            function updatePurchaseDateWarning(){
                const v = purchaseDateEl.value;
                if (!v) { warningEl.classList.add('hidden'); return; }
                const inputDate = new Date(v + 'T00:00:00');
                const today = new Date(); today.setHours(0,0,0,0);
                if (inputDate > today) {
                    warningEl.classList.remove('hidden');
                } else {
                    warningEl.classList.add('hidden');
                }
            }
            if (purchaseDateEl) {
                purchaseDateEl.addEventListener('change', updatePurchaseDateWarning);
                purchaseDateEl.addEventListener('blur', updatePurchaseDateWarning);
                updatePurchaseDateWarning();
            }

            form.addEventListener('submit', function(e){
                const allValid = requiredFields.every(isFieldValid);
                if (!allValid) {
                    e.preventDefault();
                    updateSubmitState();
                    const firstInvalid = requiredFields.find(f => !isFieldValid(f));
                    if (firstInvalid) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    // Guard double submit
                    submitBtn.setAttribute('disabled','disabled');
                    submitBtn.classList.add('opacity-50','pointer-events-none','cursor-not-allowed');
                }
            });
        });
    </script>
</x-app-layout>
