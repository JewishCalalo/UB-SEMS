<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Equipment') }}: {{ $equipment->display_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('equipment.update', $equipment) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Equipment Name *</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $equipment->name) }}" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category *</label>
                                    <select name="category_id" id="category_id" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Category</option>
                                        @foreach(App\Models\EquipmentCategory::where('is_active', true)->get() as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $equipment->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" id="description" rows="3"
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $equipment->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="purchase_date" class="block text-sm font-medium text-gray-700">Acquisition Date</label>
                                    <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $equipment->purchase_date ? $equipment->purchase_date->format('Y-m-d') : '') }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('purchase_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                                    <input type="text" name="brand" id="brand" value="{{ old('brand', $equipment->brand) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('brand')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                                    <input type="text" name="model" id="model" value="{{ old('model', $equipment->model) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('model')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
                                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $equipment->serial_number) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('serial_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Quantity and Condition -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Quantity & Condition</h3>
                                
                                <div>
                                    <label for="quantity_total" class="block text-sm font-medium text-gray-700">Total Quantity *</label>
                                    <input type="number" name="quantity_total" id="quantity_total" value="{{ old('quantity_total', $equipment->quantity_total) }}" min="1" required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    <p class="mt-1 text-sm text-gray-500">Current: {{ $equipment->quantity_available }} available out of {{ $equipment->quantity_total }} total instances.</p>
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
                                    <label for="condition" class="block text-sm font-medium text-gray-700">Condition *</label>
                                    <select name="condition" id="condition" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Condition</option>
                                        <option value="excellent" {{ old('condition', $equipment->condition) == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="good" {{ old('condition', $equipment->condition) == 'good' ? 'selected' : '' }}>Good</option>
                                        <option value="fair" {{ old('condition', $equipment->condition) == 'fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="poor" {{ old('condition', $equipment->condition) == 'poor' ? 'selected' : '' }}>Poor</option>
                                        <option value="damaged" {{ old('condition', $equipment->condition) == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                    </select>
                                    @error('condition')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Storage Location</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $equipment->location) }}"
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @error('location')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        

                        <!-- Current Images -->
                        @if($equipment->images->count() > 0)
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Images</h3>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($equipment->images as $image)
                                        <div class="relative group">
                                            <img src="{{ $image->url }}" 
                                                 alt="{{ $equipment->display_name }}" 
                                                 class="w-full h-32 object-cover rounded-lg">
                                            @if($image->is_primary)
                                                <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">Primary</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Add New Images -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Images</h3>
                            <div>
                                <label for="images" class="block text-sm font-medium text-gray-700">Upload Additional Images</label>
                                <input type="file" name="images[]" id="images" multiple accept="image/*"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <p class="mt-1 text-sm text-gray-500">Select new images to add to the equipment. First image will be set as primary if no primary exists.</p>
                                @error('images')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Equipment Status</h3>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $equipment->is_active) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Equipment is active and available for reservation</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3 pt-6 border-t">
                            <a href="{{ route('equipment.show', $equipment) }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                Update Equipment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
