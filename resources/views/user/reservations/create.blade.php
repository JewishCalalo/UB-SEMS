<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Your Reservation') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-4">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-4 rounded-lg shadow-sm mb-4">
                <div class="flex items-center">
                    <div class="h-8 w-8 rounded-lg bg-white/20 flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-plus text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Complete Your Reservation</h3>
                        <p class="text-sm text-red-100">Fill in your details and select equipment for reservation</p>
                    </div>
                </div>
            </div>

            <!-- Approval Process Information -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Approval Process Information</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Your request will be reviewed by staff members</li>
                                <li>Staff will set a pickup date between your requested borrow and return dates</li>
                                <li>You'll receive an email notification once your request is approved</li>
                                <li>Equipment must be returned by the specified return date to avoid overdue status</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <form method="POST" action="{{ route('reservations.store') }}" class="p-6" id="reservationForm">
                    @csrf
                    <input type="hidden" name="cart_data" id="cartDataInput">
                    
                    <!-- Personal Details Section -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-user mr-2 text-gray-600"></i>
                            Personal Information
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="name" id="name" required 
                                       value="{{ Auth::user()->name ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="email" id="email" required 
                                       value="{{ Auth::user()->email ?? '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Use your University of Baguio email (e.g., 12345678@s.ubaguio.edu, 87654321@e.ubaguio.edu)</p>
                            </div>
                            
                            <div>
                                <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-1">Contact Number *</label>
                                <input type="tel" name="contact_number" id="contact_number" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                            </div>
                            
                            <div>
                                <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                <select name="department" id="department" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all" onchange="document.getElementById('department_other_div').classList.toggle('hidden', this.value !== 'Other')">
                                    <option value="">Select department...</option>
                                    <option value="SBAA">SBAA</option>
                                    <option value="SCJPS">SCJPS</option>
                                    <option value="SOD">SOD</option>
                                    <option value="SEA">SEA</option>
                                    <option value="SIT">SIT</option>
                                    <option value="SOL">SOL</option>
                                    <option value="SNS">SNS</option>
                                    <option value="SON">SON</option>
                                    <option value="STELA">STELA</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div id="department_other_div" class="mt-2 hidden">
                                    <input type="text" name="department_other" id="department_other" placeholder="Please specify department" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reservation Details Section -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-gray-600"></i>
                            Reservation Details
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                            <div>
                                <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Borrow Date *</label>
                                <input type="date" name="borrow_date" id="borrow_date" required 
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">Select when you need the equipment</p>
                            </div>
                            
                            <div>
                                <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Return Date *</label>
                                <input type="date" name="return_date" id="return_date" required 
                                       min="{{ date('Y-m-d') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                                <p class="mt-1 text-xs text-gray-500">When you plan to return the equipment</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                            <div>
                                <label for="borrow_time" class="block text-sm font-medium text-gray-700 mb-1">Borrow Time</label>
                                <input type="time" name="borrow_time" id="borrow_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                            </div>
                            <div>
                                <label for="return_time" class="block text-sm font-medium text-gray-700 mb-1">Return Time</label>
                                <input type="time" name="return_time" id="return_time" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all">
                            </div>
                        </div>
                        
                        
                        <div class="mb-3">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Reservation *</label>
                            <textarea name="reason" id="reason" rows="2" required 
                                      placeholder="Please describe why you need this equipment..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all"></textarea>
                        </div>
                        
                        <div>
                            <label for="additional_details" class="block text-sm font-medium text-gray-700 mb-1">Additional Details</label>
                            <textarea name="additional_details" id="additional_details" rows="1" 
                                      placeholder="Any additional information..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm transition-all"></textarea>
                        </div>
                    </div>
                    
                    <!-- Equipment Selection Section -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-table mr-2 text-gray-600"></i>
                            Select Equipment *
                        </h4>
                        
                        <!-- Equipment Filters -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
                                <select id="category_filter" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="equipment_type_filter" class="block text-sm font-medium text-gray-700 mb-2">Filter by Equipment Type</label>
                                <select id="equipment_type_filter" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    <option value="">All Types</option>
                                    @foreach($equipmentTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="equipment_search" class="block text-sm font-medium text-gray-700 mb-2">Search Equipment</label>
                                <input type="text" id="equipment_search" placeholder="Type to search equipment..." 
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        
                        <!-- Equipment Selection Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category & Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Availability</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="equipment-table-body">
                                    @foreach($equipment as $item)
                                        <tr class="equipment-row hover:bg-gray-50 transition-colors duration-150" 
                                            data-category="{{ $item->category_id }}"
                                            data-equipment-type="{{ $item->equipment_type_id }}"
                                            data-brand="{{ strtolower($item->brand) }}"
                                            data-model="{{ strtolower($item->model) }}"
                                            data-category-name="{{ strtolower($item->category->name) }}"
                                            data-type-name="{{ strtolower($item->equipmentType->name ?? '') }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3">
                                                        <i class="fas fa-cube text-gray-400"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900">{{ $item->name }}</div>
                                                        <div class="text-sm font-medium text-gray-700">{{ $item->brand ?: 'No brand' }}</div>
                                                        <div class="text-sm text-gray-500">{{ $item->model ?: 'No model' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="space-y-1">
                                                    <span class="inline-flex px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-900 border border-blue-200">
                                                        {{ $item->category->name }}
                                                    </span>
                                                    @if($item->equipmentType)
                                                        <br>
                                                        <span class="inline-flex px-2 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-900 border border-purple-200">
                                                            {{ $item->equipmentType->name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="font-bold text-gray-900">{{ $item->quantity_available }}</span>
                                                        <span class="text-gray-600">/</span>
                                                        <span class="font-semibold text-gray-900">{{ $item->quantity_total }}</span>
                                                        @if($item->quantity_total > 0)
                                                            <span class="text-xs font-medium text-gray-600">({{ $item->quantity_total }} instances)</span>
                                                        @endif
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                        @php
                                                            $percentage = $item->quantity_total > 0 ? ($item->quantity_available / $item->quantity_total) * 100 : 0;
                                                        @endphp
                                                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
                                                    <input type="number" 
                                                           data-equipment-id="{{ $item->id }}"
                                                           min="1" 
                                                           max="{{ $item->quantity_available }}" 
                                                           value="1"
                                                           class="w-20 px-2 py-1 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 quantity-input"
                                                           data-max-available="{{ $item->quantity_available }}">
                                                    <span class="text-xs text-gray-500">max {{ $item->quantity_available }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button type="button" 
                                                        onclick="addToCart({{ $item->id }}, '{{ $item->display_name }}', {{ $item->quantity_available }})"
                                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                    <i class="fas fa-plus mr-1"></i>
                                                    Add
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Cart Summary Section -->
                    <div class="border-t border-gray-200 pt-3 mb-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-shopping-cart mr-2 text-gray-600"></i>
                            Reservation Summary
                        </h4>
                        <div id="cartItems" class="space-y-2">
                            <!-- Cart items will be displayed here -->
                        </div>
                        <div id="cartEmpty" class="text-gray-500 text-sm bg-gray-50 p-3 rounded-lg text-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            No items selected. Please add equipment to your reservation.
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-3 border-t border-gray-200">
                        <a href="{{ route('reservations.index') }}" 
                           style="background: linear-gradient(to right, #6b7280, #4b5563); color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                           onmouseover="this.style.background='linear-gradient(to right, #4b5563, #374151)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #6b7280, #4b5563)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <button type="submit" 
                                style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; padding: 8px 16px; border-radius: 6px; border: none; font-weight: 500; display: inline-flex; align-items: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; cursor: pointer;"
                                onmouseover="this.style.background='linear-gradient(to right, #b91c1c, #991b1b)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                onmouseout="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                id="submitBtn" disabled>
                            <i class="fas fa-plus mr-2"></i>
                            Submit Reservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Cart functionality
        let cart = [];
        
        // Equipment filtering functionality
        function filterEquipment() {
            const selectedCategory = document.getElementById('category_filter')?.value || '';
            const selectedType = document.getElementById('equipment_type_filter')?.value || '';
            const searchTerm = document.getElementById('equipment_search')?.value.toLowerCase() || '';
            
            const equipmentItems = document.querySelectorAll('.equipment-item');
            
            equipmentItems.forEach(item => {
                let showItem = true;
                
                // Category filter
                if (selectedCategory && item.dataset.category !== selectedCategory) {
                    showItem = false;
                }
                
                // Equipment type filter
                if (selectedType && item.dataset.equipmentType !== selectedType) {
                    showItem = false;
                }
                
                // Search filter
                if (searchTerm) {
                    const searchableText = [
                        item.dataset.brand,
                        item.dataset.model,
                        item.dataset.categoryName,
                        item.dataset.typeName,
                        item.textContent.toLowerCase()
                    ].join(' ');
                    
                    if (!searchableText.includes(searchTerm)) {
                        showItem = false;
                    }
                }
                
                item.style.display = showItem ? 'flex' : 'none';
            });
        }

        // Initialize filtering
        document.addEventListener('DOMContentLoaded', function() {
            // Category filter
            const categoryFilter = document.getElementById('category_filter');
            if (categoryFilter) {
                categoryFilter.addEventListener('change', filterEquipment);
            }

            // Equipment type filter
            const equipmentTypeFilter = document.getElementById('equipment_type_filter');
            if (equipmentTypeFilter) {
                equipmentTypeFilter.addEventListener('change', filterEquipment);
            }

            // Search filter
            const equipmentSearch = document.getElementById('equipment_search');
            if (equipmentSearch) {
                equipmentSearch.addEventListener('input', filterEquipment);
            }
        });
        
        // Add item to cart - using the main function from welcome.js
        // The addToCart function is defined in welcome.js and handles all cart logic including modals
        
        // Update cart display
        function updateCartDisplay() {
            const cartItems = document.getElementById('cartItems');
            const cartEmpty = document.getElementById('cartEmpty');
            const submitBtn = document.getElementById('submitBtn');
            
            if (cart.length === 0) {
                cartItems.innerHTML = '';
                cartEmpty.style.display = 'block';
                submitBtn.disabled = true;
            } else {
                cartEmpty.style.display = 'none';
                submitBtn.disabled = false;
                
                // Update cart items display
                cartItems.innerHTML = '';
                cart.forEach((item, index) => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-200';
                    itemDiv.innerHTML = `
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                                <i class="fas fa-box text-red-600 text-xs"></i>
                            </div>
                            <div>
                                <span class="font-medium text-sm">${item.name}</span>
                                <span class="text-gray-500 text-xs ml-2">x${item.quantity}</span>
                            </div>
                        </div>
                        <button type="button" onclick="removeFromCart(${index})" 
                                class="text-red-500 hover:text-red-700 transition-colors p-1 rounded-full hover:bg-red-50">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    `;
                    cartItems.appendChild(itemDiv);
                });
            }
        }
        
        // Remove item from cart
        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCartDisplay();
        }
        
        
        function parseYmdToLocalDate(ymd) {
            if (!ymd) return null;
            const parts = ymd.split('-').map(Number);
            if (parts.length !== 3) return null;
            return new Date(parts[0], parts[1] - 1, parts[2]);
        }

        function formatDateYmd(date) {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        }

        function setMinDatesFromLocal() {
            const today = new Date();
            today.setHours(0,0,0,0);
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const minYmd = formatDateYmd(tomorrow);
            const borrowInput = document.getElementById('borrow_date');
            const returnInput = document.getElementById('return_date');
            if (borrowInput) borrowInput.min = minYmd;
            if (returnInput) returnInput.min = minYmd;
        }

        // Initialize min dates using local timezone
        setMinDatesFromLocal();

        // Set minimum return date based on borrow date (local date-only)
        document.getElementById('borrow_date').addEventListener('change', function() {
            const returnDateInput = document.getElementById('return_date');
            const borrowLocal = parseYmdToLocalDate(this.value);
            if (!borrowLocal) return;
            const minReturn = new Date(borrowLocal);
            returnDateInput.min = formatDateYmd(minReturn);
        });

        // Initialize cart display
        updateCartDisplay();
        
        // Form submission
        document.getElementById('reservationForm').addEventListener('submit', function(e) {
            if (cart.length === 0) {
                e.preventDefault();
                alert('Please add at least one item to your reservation');
                return;
            }
            
            // Set cart data for form submission
            document.getElementById('cartDataInput').value = JSON.stringify(cart);
        });
    </script>
</x-app-layout>
