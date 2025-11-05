<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Maintenance Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Equipment Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Equipment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Name:</span>
                                <span class="text-gray-900">{{ $equipment->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Category:</span>
                                <span class="text-gray-900">{{ $equipment->category->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Model:</span>
                                <span class="text-gray-900">{{ $equipment->model ?: 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Serial Number:</span>
                                <span class="text-gray-900">{{ $equipment->serial_number ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('maintenance-management.update-record', $maintenanceRecord) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="maintenance_type" class="block text-sm font-medium text-gray-700">Maintenance Type *</label>
                                <select name="maintenance_type" id="maintenance_type" required 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                    <option value="">Select maintenance type</option>
                                    <option value="routine" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'routine' ? 'selected' : '' }}>Routine Maintenance</option>
                                    <option value="repair" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'repair' ? 'selected' : '' }}>Repair</option>
                                    <option value="inspection" {{ old('maintenance_type', $maintenanceRecord->maintenance_type) == 'inspection' ? 'selected' : '' }}>Inspection</option>
                                </select>
                                @error('maintenance_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="performed_date" class="block text-sm font-medium text-gray-700">Performed Date *</label>
                                <input type="date" name="performed_date" id="performed_date" required 
                                       value="{{ old('performed_date', $maintenanceRecord->maintenance_date ? $maintenanceRecord->maintenance_date->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('performed_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                            <textarea name="description" id="description" rows="4" required 
                                      placeholder="Describe the maintenance work performed..."
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('description', $maintenanceRecord->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="performed_by" class="block text-sm font-medium text-gray-700">Performed By *</label>
                                <input type="text" name="performed_by" id="performed_by" required 
                                       value="{{ old('performed_by', $maintenanceRecord->performed_by) }}"
                                       placeholder="Technician name"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('performed_by')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="cost" class="block text-sm font-medium text-gray-700">Cost (₱)</label>
                                <input type="number" name="cost" id="cost" step="0.01" min="0"
                                       value="{{ old('cost', $maintenanceRecord->cost) }}"
                                       placeholder="0.00"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                @error('cost')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        

                        
                        <div>
                            <label for="parts_used" class="block text-sm font-medium text-gray-700">Parts Used</label>
                            <input type="text" name="parts_used" id="parts_used"
                                   value="{{ old('parts_used', $maintenanceRecord->parts_used) }}"
                                   placeholder="List any parts replaced or used"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            @error('parts_used')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="technician_contact" class="block text-sm font-medium text-gray-700">Technician Contact</label>
                            <input type="text" name="technician_contact" id="technician_contact"
                                   value="{{ old('technician_contact', $maintenanceRecord->technician_contact) }}"
                                   placeholder="Phone number or email"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            @error('technician_contact')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      placeholder="Any additional information or observations..."
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('notes', $maintenanceRecord->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('maintenance-management.show', $equipment) }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Update Maintenance Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
