<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Equipment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Equipment: {{ $equipment->display_name }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('equipment-management.show', $equipment) }}" 
                               style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center;"
                               onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(0, 0, 0, 0.2)'"
                               onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                                <i class="fas fa-eye mr-2"></i>View Details
                            </a>
                            <a href="{{ route('equipment-management.index') }}" 
                               style="background: linear-gradient(to right, #6b7280, #4b5563); color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center;"
                               onmouseover="this.style.background='linear-gradient(to right, #4b5563, #374151)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(0, 0, 0, 0.2)'"
                               onmouseout="this.style.background='linear-gradient(to right, #6b7280, #4b5563)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Equipment
                            </a>
                        </div>
                    </div>



                    <form method="POST" action="{{ route('equipment-management.update', $equipment) }}" enctype="multipart/form-data" class="space-y-6" onsubmit="return confirmUpdateEquipment(event);">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h4 class="text-md font-medium text-gray-900 border-b border-gray-200 pb-2">Basic Information</h4>
                                
                                <div>
                                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand *</label>
                                    <input type="text" name="brand" id="brand" value="{{ old('brand', $equipment->brand) }}" required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
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
                                    <label for="model" class="block text-sm font-medium text-gray-700">Model *</label>
                                    <input type="text" name="model" id="model" value="{{ old('model', $equipment->model) }}" required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
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
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category *</label>
                                    <select name="category_id" id="category_id" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                    <label for="equipment_type_id" class="block text-sm font-medium text-gray-700">Equipment Type *</label>
                                    <select name="equipment_type_id" id="equipment_type_id" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                        <option value="">Select a type</option>
                                    </select>
                                    @error('equipment_type_id')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">{{ old('description', $equipment->description) }}</textarea>
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
                                    <label for="purchase_date" class="block text-sm font-medium text-gray-700">Acquisition Date</label>
                                    <input type="date" name="purchase_date" id="purchase_date" 
                                           value="{{ old('purchase_date', $equipment->purchase_date ? $equipment->purchase_date->format('Y-m-d') : '') }}"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
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

                            <!-- Quantity and Location (quantity read-only; managed elsewhere) -->
                            <div class="space-y-4">
                                <h4 class="text-md font-medium text-gray-900 border-b border-gray-200 pb-2">Quantity & Location</h4>
                                <p class="text-sm text-gray-600">Current: {{ $equipment->quantity_available }} available out of {{ $equipment->quantity_total }} total instances. Total quantity is managed in the instances section.</p>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Equipment Condition</label>
                                    <div class="mt-1 px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($equipment->condition == 'excellent') bg-green-100 text-green-800
                                            @elseif($equipment->condition == 'good') bg-blue-100 text-blue-800
                                            @elseif($equipment->condition == 'fair') bg-yellow-100 text-yellow-800
                                            @elseif($equipment->condition == 'needs_repair') bg-orange-100 text-orange-800
                                            @elseif($equipment->condition == 'damaged') bg-red-100 text-red-800
                                            @elseif($equipment->condition == 'lost') bg-gray-100 text-gray-800
                                            @elseif($equipment->condition == 'under_maintenance') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $equipment->condition)) }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Equipment condition is managed at the individual instance level. To edit instance conditions, go to the equipment details page.</p>
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $equipment->location) }}"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $equipment->is_active) ? 'checked' : '' }}
                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-700">Active Equipment</label>
                                </div>
                            </div>
                        </div>

                        <!-- Current Images -->
                        @if($equipment->images->count() > 0)
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-4">Current Images</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($equipment->images as $image)
                                        <div class="relative">
                                            <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                                                                                 <img class="w-full h-32 object-cover rounded-lg" 
                                                      src="{{ $image->url }}" 
                                                      alt="{{ $equipment->display_name }}"
                                                      onerror="console.log('Image failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                      onload="console.log('Image loaded successfully:', this.src); this.nextElementSibling.style.display='none';">
                                                <div class="flex flex-col items-center justify-center text-gray-500 text-xs" style="display: none;">
                                                    <svg class="w-8 h-8 mb-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span>{{ $equipment->display_name }}</span>
                                                    <span class="text-xs text-red-500 mt-1">Image failed to load</span>
                                                </div>
                                            </div>
                                            <button type="button" 
                                                    onclick="showDeleteImageConfirmation({{ $image->id }})"
                                                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700">
                                                ×
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add New Image -->
                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Add New Image</h4>
                            <div class="space-y-4">
                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                                    <input type="file" name="images[]" id="image" accept="image/*"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    <p class="mt-1 text-sm text-gray-500">Select one image. Supported formats: JPEG, PNG, JPG, GIF, WebP. Maximum file size: 2MB. Equipment can only have one image.</p>
                                    @error('images')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <!-- Image Preview -->
                                <div id="imagePreview" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Image Preview</label>
                                    <div class="w-full h-48 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                        <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-full object-contain">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <button type="button" 
                                    onclick="window.location.href='{{ route('equipment-management.show', $equipment) }}'"
                                    style="background: linear-gradient(to right, #6b7280, #4b5563); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; transition: all 0.2s; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);"
                                    onmouseover="this.style.background='linear-gradient(to right, #4b5563, #374151)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1)'"
                                    onmouseout="this.style.background='linear-gradient(to right, #6b7280, #4b5563)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1)'">
                                <i class="fas fa-times" style="margin-right: 8px;"></i>
                                Cancel
                            </button>
                            <x-form-button type="submit" variant="primary" icon="fas fa-save">
                                Update Equipment
                            </x-form-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Delete Image Confirmation Modal
        function showDeleteImageConfirmation(imageId) {
            console.log('Delete image confirmation called for image ID:', imageId);
            
            Swal.fire({
                title: 'Delete Image?',
                html: 'Are you sure you want to delete this image? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Delete Image',
                cancelButtonText: 'Keep Image',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log('User confirmed deletion, sending delete request...');
                    
                    // Use fetch API to delete the image
                    const deleteUrl = `{{ route('equipment-management.images.destroy', ['equipment' => $equipment->id, 'image' => '__IMAGE_ID__']) }}`.replace('__IMAGE_ID__', imageId);
                    console.log('Delete URL:', deleteUrl);
                    fetch(deleteUrl, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Image deleted successfully:', data.message);
                            Swal.fire({
                                buttonsStyling: false,
                                showConfirmButton: false,
                                html: `
                                    <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;">
                                        <h2 class="text-xl font-bold text-center">Success</h2>
                                    </div>
                                    <div class="text-center">
                                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <p class="text-gray-700">${data.message || 'Image deleted successfully'}</p>
                                    </div>
                                    <div class="flex justify-center mt-6">
                                        <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors" onclick="Swal.close(); location.reload();">OK</button>
                                    </div>
                                `,
                                customClass: { popup: 'swal-custom-popup' }
                            });
                        } else {
                            console.error('Failed to delete image:', data.message);
                            Swal.fire('Error', data.message || 'Failed to delete image. Please try again.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting image:', error);
                        Swal.fire('Error', 'An error occurred while deleting the image.', 'error');
                    });
                } else {
                    console.log('User cancelled deletion');
                }
            });
        }

        // Dependent dropdown for equipment types based on category
        const equipmentTypesByCategory = @json($equipmentTypesByCategory);
        const categorySelect = document.getElementById('category_id');
        const typeSelect = document.getElementById('equipment_type_id');

        function populateTypes() {
            const categoryId = categorySelect.value;
            const types = equipmentTypesByCategory[categoryId] || [];
            const selectedType = '{{ old('equipment_type_id', $equipment->equipment_type_id) }}';

            // Reset options
            typeSelect.innerHTML = '<option value="">Select a type</option>';
            types.forEach(function(t) {
                const opt = document.createElement('option');
                opt.value = t.id;
                opt.textContent = t.name;
                if (String(t.id) === String(selectedType)) {
                    opt.selected = true;
                }
                typeSelect.appendChild(opt);
            });
        }

        if (categorySelect && typeSelect) {
            categorySelect.addEventListener('change', populateTypes);
            populateTypes();
        }

        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('imagePreview').classList.add('hidden');
            }
        });

        // Equipment Update Confirmation Modal
        function confirmUpdateEquipment(event) {
            event.preventDefault();
            
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Confirm Equipment Update</h2>
                    </div>
                    <div class="text-left">
                        <p>Are you sure you want to update this equipment with the following changes?</p>
                        <div class="mt-4 p-3 bg-green-50 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">Equipment Details:</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li><strong>Brand:</strong> <span id="confirm-brand">${document.querySelector('input[name="brand"]').value}</span></li>
                                <li><strong>Model:</strong> <span id="confirm-model">${document.querySelector('input[name="model"]').value}</span></li>
                                <li><strong>Category:</strong> <span id="confirm-category">${document.querySelector('select[name="category_id"] option:checked').textContent}</span></li>
                                <li><strong>Equipment Type:</strong> <span id="confirm-type">${document.querySelector('select[name="equipment_type_id"] option:checked').textContent}</span></li>
                            </ul>
                        </div>
                        <p class="mt-3 text-sm text-gray-600">This action will update the equipment information and cannot be undone.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Update Equipment',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#6b7280',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors mr-2',
                    cancelButton: 'px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Updating Equipment...',
                        text: 'Please wait while we update the equipment information.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form via AJAX to handle validation errors
                    const formData = new FormData(event.target);
                    
                    fetch(event.target.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '',
                                html: `
                                    <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                        <h2 class="text-xl font-bold text-center">Equipment Updated Successfully</h2>
                                    </div>
                                    <p class="text-gray-700 text-base text-center">Equipment updated successfully.</p>
                                `,
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#22c55e',
                                buttonsStyling: false,
                                customClass: { confirmButton: 'px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors' }
                            }).then(() => {
                                window.location.href = data.redirect || '{{ route("equipment-management.show", $equipment) }}';
                            });
                        } else {
                            // Handle validation errors
                            let errorMessage = 'Please fix the following errors:\n\n';
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    errorMessage += `• ${data.errors[field][0]}\n`;
                                });
                            }
                            
                            Swal.fire({
                                title: 'Validation Error',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while updating the equipment.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
            
            return false;
        }
    </script>
</x-app-layout>
