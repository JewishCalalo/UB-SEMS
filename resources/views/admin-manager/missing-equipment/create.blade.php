<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Stolen/Lost Equipment Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-red-800">Create New Stolen/Lost Equipment Record</h3>
                        <p class="text-sm text-red-700 mt-1">Add a new record for equipment that has been stolen, lost, or not returned</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('missing-equipment.store') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Equipment Instance Selection -->
                        <div class="space-y-2">
                            <label for="equipment_instance_id" class="block text-sm font-semibold text-gray-700">
                                Equipment Instance <span class="text-red-500">*</span>
                            </label>
                            <select name="equipment_instance_id" id="equipment_instance_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                <option value="">Select Equipment Instance</option>
                                @foreach($equipmentInstances as $instance)
                                    <option value="{{ $instance->id }}" 
                                            data-equipment-name="{{ $instance->equipment->name }}"
                                            data-category="{{ $instance->equipment->category->name }}">
                                        {{ $instance->equipment->name }} - {{ $instance->equipment->category->name }} ({{ $instance->instance_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('equipment_instance_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reservation ID (Optional) -->
                        <div class="space-y-2">
                            <label for="reservation_id" class="block text-sm font-semibold text-gray-700">
                                Reservation ID (Optional)
                            </label>
                            <input type="text" name="reservation_id" id="reservation_id" 
                                   placeholder="Enter reservation ID if available"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                            @error('reservation_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Borrower Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="borrower_name" class="block text-sm font-semibold text-gray-700">
                                    Borrower Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="borrower_name" id="borrower_name" required
                                       placeholder="Enter borrower's full name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                @error('borrower_name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="borrower_email" class="block text-sm font-semibold text-gray-700">
                                    Borrower Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="borrower_email" id="borrower_email" required
                                       placeholder="Enter borrower's email address"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                @error('borrower_email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="borrower_contact_number" class="block text-sm font-semibold text-gray-700">
                                    Contact Number
                                </label>
                                <input type="text" name="borrower_contact_number" id="borrower_contact_number"
                                       placeholder="Enter contact number"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                @error('borrower_contact_number')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="borrower_department" class="block text-sm font-semibold text-gray-700">
                                    Department
                                </label>
                                <input type="text" name="borrower_department" id="borrower_department"
                                       placeholder="Enter department"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                @error('borrower_department')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="incident_date" class="block text-sm font-semibold text-gray-700">
                                    Incident Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="incident_date" id="incident_date" required
                                       value="{{ old('incident_date', now()->format('Y-m-d')) }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                @error('incident_date')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="incident_type" class="block text-sm font-semibold text-gray-700">
                                    Incident Type <span class="text-red-500">*</span>
                                </label>
                                <select name="incident_type" id="incident_type" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    <option value="">Select Incident Type</option>
                                    <option value="lost" {{ old('incident_type') === 'lost' ? 'selected' : '' }}>Lost</option>
                                    <option value="not_returned" {{ old('incident_type') === 'not_returned' ? 'selected' : '' }}>Not Returned</option>
                                </select>
                                @error('incident_type')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Incident Description -->
                        <div class="space-y-2">
                            <label for="incident_description" class="block text-sm font-semibold text-gray-700">
                                Incident Description
                            </label>
                            <textarea name="incident_description" id="incident_description" rows="4"
                                      placeholder="Provide detailed description of the incident..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">{{ old('incident_description') }}</textarea>
                            @error('incident_description')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('missing-equipment.index') }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-all">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                Create Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Information -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Important Notes</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Only equipment instances marked as 'lost' or 'stolen' will appear in the dropdown</li>
                                <li>Creating this record will automatically update the equipment instance condition</li>
                                <li>All fields marked with <span class="text-red-500">*</span> are required</li>
                                <li>You can update the replacement status later from the main list</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill borrower information if reservation ID is provided
        document.getElementById('reservation_id').addEventListener('change', function() {
            // This could be enhanced with AJAX to fetch reservation details
            // For now, it's just a placeholder for future enhancement
        });

        // Equipment instance selection change
        document.getElementById('equipment_instance_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                // You could add logic here to auto-fill some fields based on the selected equipment
                console.log('Selected equipment:', selectedOption.dataset.equipmentName);
            }
        });
    </script>
</x-app-layout>
