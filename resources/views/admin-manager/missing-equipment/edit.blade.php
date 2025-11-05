<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Stolen/Lost Equipment Record') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Missing Equipment', 'url' => route('missing-equipment.index')],
                ['label' => 'Edit']
            ]" />
            
            <!-- Main Edit Form Card -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-red-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Missing Equipment Record
                    </h3>
                    <p class="text-red-100 text-sm mt-1">Update missing equipment information and status</p>
                    @if($stolenLostEquipment->reservation)
                        <p class="text-red-100 text-sm">Reservation Code: {{ $stolenLostEquipment->reservation->reservation_code }}</p>
                    @endif
                </div>
                
                <div class="p-6">
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
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
                    
                    <form method="POST" action="{{ route('missing-equipment.update', $stolenLostEquipment) }}" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <!-- Equipment Instance Information Section -->
                        <div>
                            <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                                <h4 class="text-md font-semibold text-red-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    Equipment Instance Information
                                </h4>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700">
                                {{ $stolenLostEquipment->equipmentInstance->equipment->display_name }} - {{ $stolenLostEquipment->equipmentInstance->equipment->category->name }} (Instance: {{ $stolenLostEquipment->equipmentInstance->instance_code }})
                            </div>
                        </div>

                        <!-- Borrower Information Section -->
                        <div>
                            <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                                <h4 class="text-md font-semibold text-red-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Borrower Information
                                </h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label for="borrower_name" class="block text-sm font-semibold text-gray-700">
                                        Borrower Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="borrower_name" id="borrower_name" required
                                           value="{{ old('borrower_name', $stolenLostEquipment->borrower_name ?? optional($stolenLostEquipment->reservation)->name) }}"
                                           placeholder="Enter borrower's full name"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    @error('borrower_name')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="borrower_email" class="block text-sm font-semibold text-gray-700">
                                        Borrower Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="borrower_email" id="borrower_email" required
                                           value="{{ old('borrower_email', $stolenLostEquipment->borrower_email ?? optional($stolenLostEquipment->reservation)->email) }}"
                                           placeholder="Enter borrower's email address"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    @error('borrower_email')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div class="space-y-3">
                                    <label for="borrower_contact_number" class="block text-sm font-semibold text-gray-700">
                                        Contact Number
                                    </label>
                                    <input type="text" name="borrower_contact_number" id="borrower_contact_number"
                                           value="{{ old('borrower_contact_number', $stolenLostEquipment->borrower_contact_number ?? optional($stolenLostEquipment->reservation)->contact_number) }}"
                                           placeholder="Enter contact number"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    @error('borrower_contact_number')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="borrower_department" class="block text-sm font-semibold text-gray-700">
                                        Department
                                    </label>
                                    <input type="text" name="borrower_department" id="borrower_department"
                                           value="{{ old('borrower_department', $stolenLostEquipment->borrower_department ?? optional($stolenLostEquipment->reservation)->department) }}"
                                           placeholder="Enter department"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    @error('borrower_department')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Incident Information Section -->
                        <div>
                            <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                                <h4 class="text-md font-semibold text-red-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Incident Information
                                </h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label for="incident_date" class="block text-sm font-semibold text-gray-700">
                                        Incident Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="incident_date" id="incident_date" required
                                           value="{{ old('incident_date', $stolenLostEquipment->incident_date->format('Y-m-d')) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    @error('incident_date')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="incident_type" class="block text-sm font-semibold text-gray-700">
                                        Incident Type <span class="text-red-500">*</span>
                                    </label>
                                    <select name="incident_type" id="incident_type" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                        <option value="">Select Incident Type</option>
                                        <option value="lost" {{ old('incident_type', $stolenLostEquipment->incident_type) === 'lost' ? 'selected' : '' }}>Lost</option>
                                        <option value="not_returned" {{ old('incident_type', $stolenLostEquipment->incident_type) === 'not_returned' ? 'selected' : '' }}>Not Returned</option>
                                    </select>
                                    @error('incident_type')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="incident_description" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Incident Description
                                </label>
                                <textarea name="incident_description" id="incident_description" rows="4"
                                          placeholder="Provide detailed description of the incident..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">{{ old('incident_description', $stolenLostEquipment->incident_description) }}</textarea>
                                @error('incident_description')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Replacement Status Section -->
                        <div>
                            <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                                <h4 class="text-md font-semibold text-red-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Replacement Status
                                </h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label for="replacement_status" class="block text-sm font-semibold text-gray-700">
                                        Replacement Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="replacement_status" id="replacement_status" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                        <option value="">Select Replacement Status</option>
                                        <option value="pending" {{ old('replacement_status', $stolenLostEquipment->replacement_status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="replaced" {{ old('replacement_status', $stolenLostEquipment->replacement_status) === 'replaced' ? 'selected' : '' }}>Replaced</option>
                                        <option value="not_replaced" {{ old('replacement_status', $stolenLostEquipment->replacement_status) === 'not_replaced' ? 'selected' : '' }}>Not Replaced</option>
                                    </select>
                                    @error('replacement_status')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-3">
                                    <label for="replacement_date" class="block text-sm font-semibold text-gray-700">
                                        Replacement Date
                                    </label>
                                    <input type="date" name="replacement_date" id="replacement_date"
                                           value="{{ old('replacement_date', $stolenLostEquipment->replacement_date ? $stolenLostEquipment->replacement_date->format('Y-m-d') : '') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    @error('replacement_date')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-center space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('missing-equipment.show', $stolenLostEquipment) }}" 
                               class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Update Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Information -->
            <div class="mt-6 bg-blue-50/60 p-6 rounded-xl border border-blue-100">
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
                                <li>All fields marked with <span class="text-red-500">*</span> are required</li>
                                <li>Changing the incident type will update the equipment instance condition</li>
                                <li>Setting replacement status to 'replaced' will require a replacement date</li>
                                <li>You can update the replacement status later from the main list</li>
                                <li>Editing these records helps track replacement progress and update incident details</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-fill replacement date when status is set to 'replaced'
        document.getElementById('replacement_status').addEventListener('change', function() {
            const replacementDateField = document.getElementById('replacement_date');
            if (this.value === 'replaced') {
                if (!replacementDateField.value) {
                    replacementDateField.value = new Date().toISOString().split('T')[0];
                }
            }
        });
    </script>
</x-app-layout>
