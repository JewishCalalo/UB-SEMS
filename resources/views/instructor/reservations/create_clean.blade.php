<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Reservation') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'My Reservations', 'url' => route('instructor.reservations')],
                ['label' => 'Create Reservation']
            ]" />

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Create New Reservation</h3>
                        <p class="text-gray-600 font-medium">Request equipment for your PE classes and activities.</p>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-chalkboard-teacher mr-2 text-red-500"></i>
                        PE Instructor
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('instructor.reservations.store') }}" class="space-y-6" id="reservationForm">
                        @csrf
                        
                        <!-- Basic Information -->
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-lg font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Reservation Details
                            </h4>
                        </div>

                        <!-- Date Selection -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Select Date <span class="text-red-500">*</span>
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Borrow Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="borrow_date" id="borrow_date" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                           min="{{ date('Y-m-d') }}">
                                    <div id="borrow_date_error" class="text-sm text-red-600 mt-1 hidden"></div>
                                    @error('borrow_date')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Return Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="return_date" id="return_date" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                           min="{{ date('Y-m-d') }}">
                                    <div id="return_date_error" class="text-sm text-red-600 mt-1 hidden"></div>
                                    @error('return_date')
                                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Time Selection -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Time Selection <span class="text-red-500">*</span>
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <!-- Borrow Time -->
                                <div>
                                    <label for="borrow_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Borrow Time
                                    </label>
                                    <select name="borrow_time" id="borrow_time" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                        <option value="">Select borrow time</option>
                                        <option value="07:00">7:00 AM</option>
                                        <option value="07:30">7:30 AM</option>
                                        <option value="08:00">8:00 AM</option>
                                        <option value="08:30">8:30 AM</option>
                                        <option value="09:00">9:00 AM</option>
                                        <option value="09:30">9:30 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="10:30">10:30 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="11:30">11:30 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="12:30">12:30 PM</option>
                                        <option value="13:00">1:00 PM</option>
                                        <option value="13:30">1:30 PM</option>
                                        <option value="14:00">2:00 PM</option>
                                        <option value="14:30">2:30 PM</option>
                                        <option value="15:00">3:00 PM</option>
                                        <option value="15:30">3:30 PM</option>
                                        <option value="16:00">4:00 PM</option>
                                        <option value="16:30">4:30 PM</option>
                                        <option value="17:00">5:00 PM</option>
                                        <option value="17:30">5:30 PM</option>
                                    </select>
                                    <div id="borrow_time_error" class="text-sm text-red-600 mt-1 hidden"></div>
                                </div>

                                <!-- Return Time -->
                                <div>
                                    <label for="return_time" class="block text-sm font-medium text-gray-700 mb-2">
                                        Return Time
                                    </label>
                                    <select name="return_time" id="return_time" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                        <option value="">Select return time</option>
                                        <option value="07:00">7:00 AM</option>
                                        <option value="07:30">7:30 AM</option>
                                        <option value="08:00">8:00 AM</option>
                                        <option value="08:30">8:30 AM</option>
                                        <option value="09:00">9:00 AM</option>
                                        <option value="09:30">9:30 AM</option>
                                        <option value="10:00">10:00 AM</option>
                                        <option value="10:30">10:30 AM</option>
                                        <option value="11:00">11:00 AM</option>
                                        <option value="11:30">11:30 AM</option>
                                        <option value="12:00">12:00 PM</option>
                                        <option value="12:30">12:30 PM</option>
                                        <option value="13:00">1:00 PM</option>
                                        <option value="13:30">1:30 PM</option>
                                        <option value="14:00">2:00 PM</option>
                                        <option value="14:30">2:30 PM</option>
                                        <option value="15:00">3:00 PM</option>
                                        <option value="15:30">3:30 PM</option>
                                        <option value="16:00">4:00 PM</option>
                                        <option value="16:30">4:30 PM</option>
                                        <option value="17:00">5:00 PM</option>
                                        <option value="17:30">5:30 PM</option>
                                    </select>
                                    <div id="return_time_error" class="text-sm text-red-600 mt-1 hidden"></div>
                                </div>
                            </div>

                            <!-- Duration Display -->
                            <div id="duration_display" class="bg-blue-50 border border-blue-200 rounded-lg p-4 hidden">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-blue-800">Reservation Duration: <span id="duration_text"></span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Equipment Selection -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Select Equipment <span class="text-red-500">*</span>
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="equipment-grid">
                                @foreach($equipment as $item)
                                    <div class="equipment-card border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <div class="flex items-start space-x-3">
                                            <input type="checkbox" 
                                                   class="equipment-checkbox mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" 
                                                   value="{{ $item->id }}"
                                                   data-equipment-id="{{ $item->id }}"
                                                   data-equipment-name="{{ $item->display_name }}"
                                                   data-max-quantity="{{ $item->quantity_available }}">
                                            
                                            <div class="flex-1">
                                                <h5 class="text-sm font-medium text-gray-900">{{ $item->display_name }}</h5>
                                                <p class="text-xs text-gray-500 mt-1">Available: {{ $item->quantity_available }}</p>
                                                
                                                <div class="mt-3 quantity-controls hidden">
                                                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantity:</label>
                                                    <div class="flex items-center space-x-2">
                                                        <button type="button" class="quantity-decrease w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-sm hover:bg-gray-300">-</button>
                                                        <input type="number" 
                                                               class="quantity-input w-16 px-2 py-1 text-sm border border-gray-300 rounded text-center" 
                                                               min="1" 
                                                               max="{{ $item->quantity_available }}" 
                                                               value="1">
                                                        <button type="button" class="quantity-increase w-6 h-6 bg-gray-200 text-gray-600 rounded-full flex items-center justify-center text-sm hover:bg-gray-300">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Purpose/Reason -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Purpose/Reason <span class="text-red-500">*</span>
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="reason_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Purpose
                                    </label>
                                    <select name="reason_type" id="reason_type" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                        <option value="">Select a purpose</option>
                                        <option value="PE Class">PE Class</option>
                                        <option value="Sports Training">Sports Training</option>
                                        <option value="Tournament">Tournament</option>
                                        <option value="Practice Session">Practice Session</option>
                                        <option value="Event">Event</option>
                                        <option value="custom">Other (Specify)</option>
                                    </select>
                                    <div id="reason_type_error" class="text-sm text-red-600 mt-1 hidden"></div>
                                </div>
                                
                                <div id="custom_reason_div" class="hidden">
                                    <label for="custom_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                        Specify Purpose
                                    </label>
                                    <textarea name="custom_reason" id="custom_reason" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                              placeholder="Please specify the purpose of your reservation..."></textarea>
                                    <div id="custom_reason_error" class="text-sm text-red-600 mt-1 hidden"></div>
                                </div>
                                
                                <div>
                                    <label for="additional_details" class="block text-sm font-medium text-gray-700 mb-2">
                                        Additional Details (Optional)
                                    </label>
                                    <textarea name="additional_details" id="additional_details" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                              placeholder="Any additional information about your reservation..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden reservation data -->
                        <input type="hidden" name="reservation_data" id="reservation_data" value="">

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" id="submitBtn" disabled
                                    class="px-8 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                                <span class="submit-text">Submit Reservation</span>
                                <span class="loading-text hidden">Submitting...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - Starting initialization...');

            // Get form elements
            const form = document.getElementById('reservationForm');
            const submitBtn = document.getElementById('submitBtn');
            const reservationDataInput = document.getElementById('reservation_data');
            const equipmentCheckboxes = document.querySelectorAll('.equipment-checkbox');
            const reasonTypeSelect = document.getElementById('reason_type');
            const customReasonDiv = document.getElementById('custom_reason_div');
            const customReasonInput = document.getElementById('custom_reason');

            // Pre-fill dates from URL parameters (from dashboard calendar)
            const urlParams = new URLSearchParams(window.location.search);
            const borrowDate = urlParams.get('borrow_date');
            const returnDate = urlParams.get('return_date');
            
            if (borrowDate) {
                document.getElementById('borrow_date').value = borrowDate;
            }
            if (returnDate) {
                document.getElementById('return_date').value = returnDate;
            }

            // Time selection change handlers
            document.getElementById('borrow_time').addEventListener('change', function() {
                updateDuration();
                validateForm();
            });

            document.getElementById('return_time').addEventListener('change', function() {
                updateDuration();
                validateForm();
            });

            // Date change handlers
            document.getElementById('borrow_date').addEventListener('change', function() {
                updateDuration();
                validateForm();
            });

            document.getElementById('return_date').addEventListener('change', function() {
                updateDuration();
                validateForm();
            });

            // Update duration display
            function updateDuration() {
                const borrowDate = document.getElementById('borrow_date').value;
                const returnDate = document.getElementById('return_date').value;
                const borrowTime = document.getElementById('borrow_time').value;
                const returnTime = document.getElementById('return_time').value;
                
                const durationDisplay = document.getElementById('duration_display');
                
                if (borrowDate && returnDate && borrowTime && returnTime) {
                    const startDateTime = new Date(`${borrowDate}T${borrowTime}`);
                    const endDateTime = new Date(`${returnDate}T${returnTime}`);
                    
                    if (endDateTime > startDateTime) {
                        const diffMs = endDateTime - startDateTime;
                        const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                        const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                        
                        let durationText = '';
                        if (diffHours > 0) {
                            durationText += `${diffHours} hour${diffHours > 1 ? 's' : ''}`;
                        }
                        if (diffMinutes > 0) {
                            durationText += (durationText ? ', ' : '') + `${diffMinutes} minute${diffMinutes > 1 ? 's' : ''}`;
                        }
                        
                        document.getElementById('duration_text').textContent = durationText;
                        durationDisplay.classList.remove('hidden');
                    } else {
                        durationDisplay.classList.add('hidden');
                    }
                } else {
                    durationDisplay.classList.add('hidden');
                }
            }

            // Equipment selection handlers
            equipmentCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const card = this.closest('.equipment-card');
                    const quantityControls = card.querySelector('.quantity-controls');
                    
                    if (this.checked) {
                        quantityControls.classList.remove('hidden');
                    } else {
                        quantityControls.classList.add('hidden');
                    }
                    
                    updateReservationData();
                    validateForm();
                });
            });

            // Quantity control handlers
            document.querySelectorAll('.quantity-increase').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const max = parseInt(input.getAttribute('max'));
                    const current = parseInt(input.value);
                    if (current < max) {
                        input.value = current + 1;
                        updateReservationData();
                    }
                });
            });

            document.querySelectorAll('.quantity-decrease').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.nextElementSibling;
                    const current = parseInt(input.value);
                    if (current > 1) {
                        input.value = current - 1;
                        updateReservationData();
                    }
                });
            });

            // Reason type handler
            reasonTypeSelect.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customReasonDiv.classList.remove('hidden');
                    customReasonInput.required = true;
                } else {
                    customReasonDiv.classList.add('hidden');
                    customReasonInput.required = false;
                }
                validateForm();
            });

            // Update reservation data
            function updateReservationData() {
                const selectedItems = [];
                equipmentCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const quantity = parseInt(checkbox.closest('.equipment-card').querySelector('.quantity-input').value);
                        selectedItems.push({
                            equipment_id: checkbox.value,
                            quantity: quantity
                        });
                    }
                });
                reservationDataInput.value = JSON.stringify(selectedItems);
            }

            // Form validation
            function validateForm() {
                const borrowDate = document.getElementById('borrow_date').value;
                const returnDate = document.getElementById('return_date').value;
                const borrowTime = document.getElementById('borrow_time').value;
                const returnTime = document.getElementById('return_time').value;
                const reasonType = reasonTypeSelect.value;
                const customReason = customReasonInput.value;
                const hasEquipment = Array.from(equipmentCheckboxes).some(cb => cb.checked);

                let isValid = true;

                // Validate dates
                if (!borrowDate || !returnDate) {
                    isValid = false;
                } else if (new Date(returnDate) < new Date(borrowDate)) {
                    isValid = false;
                }

                // Validate times
                if (!borrowTime || !returnTime) {
                    isValid = false;
                } else if (borrowDate === returnDate && borrowTime >= returnTime) {
                    isValid = false;
                }

                // Validate reason
                if (!reasonType) {
                    isValid = false;
                } else if (reasonType === 'custom' && !customReason.trim()) {
                    isValid = false;
                }

                // Validate equipment
                if (!hasEquipment) {
                    isValid = false;
                }

                submitBtn.disabled = !isValid;
                return isValid;
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    alert('Please fill in all required fields correctly.');
                    return false;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.querySelector('.submit-text').classList.add('hidden');
                submitBtn.querySelector('.loading-text').classList.remove('hidden');

                // Update reservation data before submission
                updateReservationData();
            });

            // Initial validation
            validateForm();
        });
    </script>
</x-app-layout>
