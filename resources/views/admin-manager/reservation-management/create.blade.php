<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Walk-in Equipment Reservation (University Staff/Employees)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex items-center">
                    <div class="h-10 w-10 rounded-lg bg-white/20 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Walk-in Reservation for University Staff/Employees</h3>
                        <p class="text-sm text-red-100 mt-1">Create and approve a walk-in reservation for UB staff and employees.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    
                    <form method="POST" action="{{ route('reservation-management.store') }}" class="space-y-6" id="reservationForm" novalidate>
                        @csrf
                        
                        @if($errors->any())
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-bold text-red-800">Please review the form:</h4>
                                        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1 font-semibold">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Staff Information -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Staff Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="teacher_name" class="block text-sm font-medium text-gray-700">Name *</label>
                                    <input type="text" name="teacher_name" id="teacher_name" required
                                           value="{{ old('teacher_name') }}"
                                           placeholder="Enter staff member's name"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    @error('teacher_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="teacher_email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                                    <input type="email" name="teacher_email" id="teacher_email" required
                                           value="{{ old('teacher_email') }}"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                           onblur="validateEmail(this)">
                                    <div id="email-error" class="mt-1 text-sm text-red-600 hidden"></div>
                                    @error('teacher_email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700">Department *</label>
                                    <select name="department" id="department" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                            onchange="toggleOtherDepartment()">
                                        <option value="">Select department...</option>
                                        <option value="Human Resources" {{ old('department')==='Human Resources' ? 'selected' : '' }}>Human Resources</option>
                                        <option value="Finance" {{ old('department')==='Finance' ? 'selected' : '' }}>Finance</option>
                                        <option value="Registrar" {{ old('department')==='Registrar' ? 'selected' : '' }}>Registrar</option>
                                        <option value="Facilities" {{ old('department')==='Facilities' ? 'selected' : '' }}>Facilities</option>
                                        <option value="IT" {{ old('department')==='IT' ? 'selected' : '' }}>IT</option>
                                        <option value="PE Department" {{ old('department')==='PE Department' ? 'selected' : '' }}>PE Department</option>
                                        <option value="Other" {{ old('department')==='Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div id="other_department_wrapper" class="{{ old('department')==='Other' ? '' : 'hidden' }}">
                                    <label for="other_department" class="block text-sm font-medium text-gray-700">Specify Department *</label>
                                    <input type="text" name="other_department" id="other_department"
                                           value="{{ old('other_department') }}"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                           placeholder="Enter department name">
                                    @error('other_department')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Date and Time Selection -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Reservation Date & Time
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="borrow_date" class="block text-sm font-medium text-gray-700">Borrow Date *</label>
                                    <input type="date" name="borrow_date" id="borrow_date" required
                                           value="{{ old('borrow_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    @error('borrow_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Borrow Time *</label>
                                    <div class="mt-1 flex items-center gap-2">
                                        <select id="borrow_hour" class="px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" style="width: 4.5rem;">
                                            @for($h=1;$h<=12;$h++)
                                                <option value="{{ str_pad($h,2,'0',STR_PAD_LEFT) }}">{{ $h }}</option>
                                            @endfor
                                        </select>
                                        <select id="borrow_minute" class="px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" style="width: 4.5rem;">
                                            @foreach(["00","05","10","15","20","25","30","35","40","45","50","55"] as $m)
                                                <option value="{{ $m }}">{{ $m }}</option>
                                            @endforeach
                                        </select>
                                        <select id="borrow_period" class="px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" style="width: 5.5rem;">
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="borrow_time" id="borrow_time" value="{{ old('borrow_time') }}">
                                    @error('borrow_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="return_date" class="block text-sm font-medium text-gray-700">Return Date *</label>
                                    <input type="date" name="return_date" id="return_date" required
                                           value="{{ old('return_date') }}"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    @error('return_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Return Time *</label>
                                    <div class="mt-1 flex items-center gap-2">
                                        <select id="return_hour" class="px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" style="width: 4.5rem;">
                                            @for($h=1;$h<=12;$h++)
                                                <option value="{{ str_pad($h,2,'0',STR_PAD_LEFT) }}">{{ $h }}</option>
                                            @endfor
                                        </select>
                                        <select id="return_minute" class="px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" style="width: 4.5rem;">
                                            @foreach(["00","05","10","15","20","25","30","35","40","45","50","55"] as $m)
                                                <option value="{{ $m }}">{{ $m }}</option>
                                            @endforeach
                                        </select>
                                        <select id="return_period" class="px-2 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" style="width: 5.5rem;">
                                            <option value="AM">AM</option>
                                            <option value="PM">PM</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="return_time" id="return_time" value="{{ old('return_time') }}">
                                    @error('return_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Times must be between 8:00 AM and 5:00 PM. If same day, return time must be at least 30 minutes after borrow time.</p>
                        </div>

                        <!-- Reason For Reservation -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Reason For Reservation
                            </h3>
                            <div>
                                <label for="reason" class="block text-sm font-medium text-gray-700">Reason *</label>
                                <select name="reason" id="reason" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                        onchange="toggleCustomReason()">
                                    <option value="">Select a reason...</option>
                                    <option value="PE Class" {{ old('reason') == 'PE Class' ? 'selected' : '' }}>PE Class</option>
                                    <option value="Sports Event" {{ old('reason') == 'Sports Event' ? 'selected' : '' }}>Sports Event</option>
                                    <option value="Training Session" {{ old('reason') == 'Training Session' ? 'selected' : '' }}>Training Session</option>
                                    <option value="Research/Study" {{ old('reason') == 'Research/Study' ? 'selected' : '' }}>Research/Study</option>
                                    <option value="Other" {{ old('reason') == 'Other' ? 'selected' : '' }}>Other (Specify)</option>
                                </select>
                                @error('reason')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div id="custom_reason_div" class="hidden mt-4">
                                <label for="custom_reason" class="block text-sm font-medium text-gray-700">
                                    Specify Purpose <span class="text-red-500">*</span>
                                </label>
                                <textarea name="custom_reason" id="custom_reason" rows="3"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                          placeholder="Please specify the purpose of your reservation...">{{ old('custom_reason') }}</textarea>
                                @error('custom_reason')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Equipment Selection -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-cube mr-2 text-red-600"></i>
                                    Equipment Selection
                                </h3>
                            
                            <!-- Equipment Filters -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div>
                                    <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select id="category_filter" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="equipment_type_filter" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                                    <select id="equipment_type_filter" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" disabled>
                                        <option value="">Select a category first</option>
                                    </select>
                            </div>
                            
                                    <div>
                                <label for="equipment_search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                                <input type="text" id="equipment_search" placeholder="Search equipment..." 
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                    </div>
                            </div>
                            


                                <!-- Equipment Selection Table -->
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-red-600">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment</th>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category and Type</th>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Available</th>
                                                <th class="px-4 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200" id="equipment-table-body">
                                                @foreach($equipment as $eq)
                                                <tr class="equipment-row hover:bg-gray-50" 
                                                            data-category="{{ $eq->category_id }}"
                                                            data-equipment-type="{{ $eq->equipment_type_id }}"
                                                            data-brand="{{ strtolower($eq->brand) }}"
                                                            data-model="{{ strtolower($eq->model) }}"
                                                            data-category-name="{{ strtolower($eq->category->name) }}"
                                                            data-type-name="{{ strtolower($eq->equipmentType->name ?? '') }}">
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $eq->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $eq->brand ?: 'No brand' }} {{ $eq->model ?: '' }}</div>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <div class="space-y-1">
                                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                                                {{ $eq->category->name }}
                                                            </span>
                                                            @if($eq->equipmentType)
                                                                <br>
                                                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                                                    {{ $eq->equipmentType->name }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <span class="text-sm text-gray-900">
                                                            <span class="block">{{ $eq->quantity_available }}</span>
                                                            <span class="text-xs text-gray-500 date-specific-availability" style="display: none;">
                                                                for selected dates: <span class="bookable-count" data-equipment-id="{{ $eq->id }}">-</span>
                                                            </span>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap">
                                                        <x-form-button 
                                                                type="button" 
                                                                variant="primary" 
                                                                size="sm" 
                                                                icon="fas fa-plus"
                                                                data-equipment-id="{{ $eq->id }}"
                                                                data-equipment-name="{{ $eq->name }}"
                                                                data-equipment-brand="{{ $eq->brand }}"
                                                                data-equipment-model="{{ $eq->model }}"
                                                                data-equipment-category="{{ $eq->category->name }}"
                                                                data-equipment-type="{{ $eq->equipmentType->name ?? 'N/A' }}"
                                                                data-equipment-available="{{ $eq->quantity_available }}"
                                                                onclick="showQuantityModal(this)">
                                                            Add
                                                        </x-form-button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                        </div>
                                    </div>
                                </div>

                        <!-- Selected Equipment -->
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-green-600"></i>
                                    Selected Equipment
                                </h3>
                                
                                <div id="selected-equipment-list" class="space-y-3">
                                    <!-- Selected equipment items will be added here dynamically -->
                            </div>

                                <div id="no-equipment-selected" class="text-center py-8 text-gray-500">
                                    <i class="fas fa-boxes text-4xl mb-2"></i>
                                    <p>No equipment selected yet. Use the table above to add equipment to your reservation.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Additional Information
                            </h3>
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks (Optional)</label>
                                <textarea name="remarks" id="remarks" rows="2"
                                          class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                          placeholder="Any special notes or instructions...">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Error Notification Card -->
                        <div id="form-error-card" class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg hidden">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-bold text-red-800">Please fix the following errors:</h4>
                                    <ul id="form-error-list" class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1 font-semibold">
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <x-form-button variant="secondary" size="md" href="{{ route('reservation-management.index') }}" icon="fas fa-times">
                                Cancel
                            </x-form-button>
                            <x-form-button type="submit" variant="primary" size="md" icon="fas fa-check">
                                Create & Approve Reservation
                            </x-form-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quantity Selection Modal -->
    <x-modal name="quantity-modal" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Select Quantity</h3>
                <button type="button" onclick="closeQuantityModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="mb-6">
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <div class="text-sm text-gray-600 mb-2">
                        <strong>Equipment:</strong> <span id="modal-equipment-name" class="text-gray-900"></span>
                    </div>
                    <div class="text-sm text-gray-600">
                        <strong>Available:</strong> <span id="modal-equipment-available" class="text-green-600 font-semibold"></span> instances
                    </div>
                </div>
                
                <div>
                    <label for="modal-quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity to Reserve</label>
                    <input type="number" id="modal-quantity" min="1" max="1" value="1" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 text-lg"
                           oninput="validateModalQuantity(this)">
                    <div id="modal-quantity-error" class="mt-2 text-sm text-red-600 hidden"></div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <x-form-button type="button" variant="secondary" size="md" onclick="closeQuantityModal()" icon="fas fa-times">
                    Cancel
                </x-form-button>
                <x-form-button type="button" variant="primary" size="md" onclick="addEquipmentFromModal()" icon="fas fa-plus">
                    Add to Reservation
                </x-form-button>
            </div>
        </div>
    </x-modal>

    <!-- Notification Modal -->
    <x-modal name="notification-modal" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center justify-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Equipment Already Selected</h3>
                <p id="notification-message" class="text-sm text-gray-600 mb-6"></p>
                
                <x-form-button type="button" variant="primary" size="md" onclick="closeNotificationModal()" icon="fas fa-check">
                    OK
                </x-form-button>
            </div>
        </div>
    </x-modal>

    <script>
        function toggleOtherDepartment(){
            const sel = document.getElementById('department');
            const wrap = document.getElementById('other_department_wrapper');
            if (!sel || !wrap) return;
            if (sel.value === 'Other') {
                wrap.classList.remove('hidden');
            } else {
                wrap.classList.add('hidden');
            }
        }
        // Compose hidden time fields from hour/minute/period dropdowns so backend receives HH:MM 24h
        function to24h(hour12, minute, period){
            let h = parseInt(hour12, 10) % 12; if (period === 'PM') h += 12; return String(h).padStart(2, '0') + ':' + String(minute).padStart(2, '0');
        }
        function syncTimes(){
            const bh = document.getElementById('borrow_hour');
            const bm = document.getElementById('borrow_minute');
            const bp = document.getElementById('borrow_period');
            const rh = document.getElementById('return_hour');
            const rm = document.getElementById('return_minute');
            const rp = document.getElementById('return_period');
            const bt = document.getElementById('borrow_time');
            const rt = document.getElementById('return_time');
            if (bh && bm && bp && bt) bt.value = to24h(bh.value, bm.value, bp.value);
            if (rh && rm && rp && rt) rt.value = to24h(rh.value, rm.value, rp.value);
        }
        document.addEventListener('DOMContentLoaded', function(){
            ['borrow_hour','borrow_minute','borrow_period','return_hour','return_minute','return_period']
                .forEach(id => { const el = document.getElementById(id); if (el) el.addEventListener('change', syncTimes); });
            syncTimes();
        });
        // Global variables
        let selectedEquipment = [];
        let itemCounter = 0;
        let currentEquipmentData = null;

        // Toggle custom reason field
        window.toggleCustomReason = function() {
            const reasonType = document.getElementById('reason');
            const customReasonDiv = document.getElementById('custom_reason_div');
            const customReasonField = document.getElementById('custom_reason');
            
            if (reasonType.value === 'Other') {
                customReasonDiv.classList.remove('hidden');
                customReasonField.required = true;
            } else {
                customReasonDiv.classList.add('hidden');
                customReasonField.required = false;
                customReasonField.value = '';
            }
        };

        // Email validation function
        window.validateEmail = function(input) {
            const email = input.value.trim();
            const errorDiv = document.getElementById('email-error');
            
            if (!email) {
                errorDiv.textContent = 'Email is required';
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                errorDiv.textContent = 'Please enter a valid email address';
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }
            
            // Check for University of Baguio email format (students/PE staff/teachers)
            const universityEmailRegex = /^[a-zA-Z0-9._%+-]+@(s\.ubaguio\.edu|e\.ubaguio\.edu)$/i;
            if (!universityEmailRegex.test(email)) {
                errorDiv.textContent = 'Please use a valid University of Baguio email address (e.g., 12345678@s.ubaguio.edu or 12345678@e.ubaguio.edu)';
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }
            
            // Check if email has existing reservation
            fetch('/api/check-email-reservation', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.has_reservation) {
                    errorDiv.textContent = 'This email already has an active reservation';
                    errorDiv.classList.remove('hidden');
                    input.classList.add('border-red-500');
                } else {
                    errorDiv.classList.add('hidden');
                    input.classList.remove('border-red-500');
                }
            })
            .catch(error => {
                console.error('Error checking email:', error);
                errorDiv.classList.add('hidden');
                input.classList.remove('border-red-500');
            });
        };

        // Quantity modal functions
        window.showQuantityModal = function(button) {
            currentEquipmentData = {
                id: button.dataset.equipmentId,
                name: button.dataset.equipmentName,
                brand: button.dataset.equipmentBrand,
                model: button.dataset.equipmentModel,
                category: button.dataset.equipmentCategory,
                type: button.dataset.equipmentType,
                available: parseInt(button.dataset.equipmentAvailable)
            };
            
            document.getElementById('modal-equipment-name').textContent = currentEquipmentData.name;
            document.getElementById('modal-equipment-available').textContent = currentEquipmentData.available;
            document.getElementById('modal-quantity').max = currentEquipmentData.available;
            document.getElementById('modal-quantity').value = 1;
            
            // Use system modal
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'quantity-modal' }));
        };

        window.closeQuantityModal = function() {
            console.log('closeQuantityModal called');
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'quantity-modal' }));
            currentEquipmentData = null;
            console.log('Modal close event dispatched');
        };

        // Notification modal functions
        window.showNotificationModal = function(message) {
            document.getElementById('notification-message').textContent = message;
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'notification-modal' }));
        };

        window.closeNotificationModal = function() {
            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'notification-modal' }));
        };

        // Form error card functions
        window.showFormErrorCard = function(errors) {
            const errorCard = document.getElementById('form-error-card');
            const errorList = document.getElementById('form-error-list');
            
            // Clear previous errors
            errorList.innerHTML = '';
            
            // Add each error to the list
            errors.forEach(error => {
                const li = document.createElement('li');
                li.textContent = error;
                errorList.appendChild(li);
            });
            
            // Show the error card
            errorCard.classList.remove('hidden');
            
            // Scroll to the error card
            errorCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        };

        window.hideFormErrorCard = function() {
            const errorCard = document.getElementById('form-error-card');
            errorCard.classList.add('hidden');
        };

        window.validateModalQuantity = function(input) {
            const maxAvailable = parseInt(input.max);
            const value = parseInt(input.value) || 0;
            const errorDiv = document.getElementById('modal-quantity-error');
            
            if (value < 1) {
                errorDiv.textContent = 'Quantity must be at least 1';
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }
            
            if (value > maxAvailable) {
                errorDiv.textContent = `Quantity cannot exceed ${maxAvailable} available instances`;
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500');
                return false;
            }
            
            errorDiv.classList.add('hidden');
            input.classList.remove('border-red-500');
            return true;
        };

        window.addEquipmentFromModal = function() {
            console.log('addEquipmentFromModal called');
            const quantityInput = document.getElementById('modal-quantity');
            
            if (!validateModalQuantity(quantityInput)) {
                console.log('Validation failed, not closing modal');
                return;
            }
            
            const quantity = parseInt(quantityInput.value);
            console.log('Adding equipment with quantity:', quantity);
            
            addEquipmentToSelected(currentEquipmentData, quantity);
            
            // Reset modal inputs after successful addition
            quantityInput.value = 1;
            quantityInput.classList.remove('border-green-500', 'border-red-500');
            
            // Clear any error messages in the modal
            const errorDiv = document.getElementById('modal-quantity-error');
            if (errorDiv) {
                errorDiv.classList.add('hidden');
            }
            
            console.log('Closing modal...');
            // Close the modal
            closeQuantityModal();
        };

        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up event listeners...');
            
            // Filter out equipment with 0 availability
            const equipmentRows = document.querySelectorAll('.equipment-row');
            equipmentRows.forEach(row => {
                const availableCell = row.querySelector('td:nth-child(3)');
                const available = parseInt(availableCell.textContent.trim());
                if (available === 0) {
                    row.style.display = 'none';
                }
            });

            // Equipment filtering functionality
            const categoryFilter = document.getElementById('category_filter');
            const equipmentTypeFilter = document.getElementById('equipment_type_filter');
            const equipmentSearch = document.getElementById('equipment_search');
            
            function filterEquipment() {
                const categoryValue = categoryFilter ? categoryFilter.value : '';
                const typeValue = equipmentTypeFilter ? equipmentTypeFilter.value : '';
                const searchValue = equipmentSearch ? equipmentSearch.value.toLowerCase() : '';
                
                console.log('Filtering with:', { categoryValue, typeValue, searchValue });
                
                const equipmentRows = document.querySelectorAll('.equipment-row');
                console.log('Found', equipmentRows.length, 'equipment rows');
                
                let visibleCount = 0;
                equipmentRows.forEach(row => {
                    const categoryMatch = !categoryValue || row.dataset.category === categoryValue;
                    const typeMatch = !typeValue || row.dataset.equipmentType === typeValue;
                    const searchMatch = !searchValue || 
                        row.dataset.brand.includes(searchValue) ||
                        row.dataset.model.includes(searchValue) ||
                        row.dataset.categoryName.includes(searchValue) ||
                        row.dataset.typeName.includes(searchValue) ||
                        row.textContent.toLowerCase().includes(searchValue);
                    
                    if (categoryMatch && typeMatch && searchMatch) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                console.log('Visible rows after filtering:', visibleCount);
            }

            // Populate equipment types based on selected category (Category-first rule)
            const allTypes = @json($equipmentTypes->map(fn($t) => ['id'=>$t->id,'name'=>$t->name,'category_id'=>$t->category_id]));
            function refreshEquipmentTypeOptions() {
                const cat = categoryFilter.value;
                equipmentTypeFilter.innerHTML = '';
                if (!cat) {
                    equipmentTypeFilter.disabled = true;
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Select a category first';
                    equipmentTypeFilter.appendChild(opt);
                    filterEquipment();
                    return;
                }
                equipmentTypeFilter.disabled = false;
                const placeholder = document.createElement('option');
                placeholder.value = '';
                placeholder.textContent = 'All Types';
                equipmentTypeFilter.appendChild(placeholder);
                allTypes.filter(t => String(t.category_id) === String(cat)).forEach(t => {
                    const o = document.createElement('option');
                    o.value = t.id;
                    o.textContent = t.name;
                    equipmentTypeFilter.appendChild(o);
                });
                filterEquipment();
            }
            if (categoryFilter) categoryFilter.addEventListener('change', refreshEquipmentTypeOptions);
            if (equipmentTypeFilter) equipmentTypeFilter.addEventListener('change', filterEquipment);
            refreshEquipmentTypeOptions();

            // Date-aware availability: fetch bookable counts for visible equipment
            async function refreshBookableCounts() {
                const borrowInput = document.getElementById('borrow_date');
                const returnInput = document.getElementById('return_date');
                const dateSpecificElements = document.querySelectorAll('.date-specific-availability');
                
                if (!borrowInput || !returnInput || !borrowInput.value || !returnInput.value) {
                    // Hide "for selected dates" text when no dates are selected
                    dateSpecificElements.forEach(el => el.style.display = 'none');
                    document.querySelectorAll('.bookable-count').forEach(el => el.textContent = '-');
                    return;
                }
                
                // Show "for selected dates" text when dates are selected
                dateSpecificElements.forEach(el => el.style.display = 'inline');
                
                const borrow = borrowInput.value;
                const ret = returnInput.value;
                const elems = document.querySelectorAll('.bookable-count');
                elems.forEach(async el => {
                    const id = el.getAttribute('data-equipment-id');
                    try {
                        const url = `/api/equipment/${id}/availability?borrow_date=${encodeURIComponent(borrow)}&return_date=${encodeURIComponent(ret)}`;
                        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
                        const data = await res.json();
                        el.textContent = (data && typeof data.bookable_count === 'number') ? data.bookable_count : '-';
                    } catch (e) {
                        el.textContent = '-';
                    }
                });
            }

            // Recompute when dates change
            const borrowInputEl = document.getElementById('borrow_date');
            const returnInputEl = document.getElementById('return_date');
            if (borrowInputEl) borrowInputEl.addEventListener('change', refreshBookableCounts);
            if (returnInputEl) returnInputEl.addEventListener('change', refreshBookableCounts);
            refreshBookableCounts();

            // Inline quantity validation
            window.validateQuantity = function(input) {
                const maxAvailable = parseInt(input.dataset.maxAvailable);
                const value = parseInt(input.value) || 0;
                const errorDiv = input.parentElement.querySelector('.quantity-error');
                
                // Clear previous error
                errorDiv.classList.add('hidden');
                input.classList.remove('border-red-500');
                
                if (value < 0) {
                    input.value = 0;
                    return;
                }
                
                if (value > maxAvailable) {
                    input.value = maxAvailable;
                    showQuantityError(input, `Maximum available: ${maxAvailable}`);
                    return;
                }
                
                if (value > 0 && value <= maxAvailable) {
                    input.classList.add('border-green-500');
                } else {
                    input.classList.remove('border-green-500');
                }
            }
            
            // Show quantity error
            function showQuantityError(input, message) {
                const errorDiv = input.parentElement.querySelector('.quantity-error');
                errorDiv.textContent = message;
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500');
            }
            
            // Add equipment to selected list - Global function
            window.addEquipmentToSelected = function(equipmentData, quantity = 1) {
                console.log('addEquipmentToSelected called with data:', equipmentData, 'quantity:', quantity);
                
                const equipmentId = equipmentData.id;
                const equipmentName = equipmentData.name;
                const equipmentBrand = equipmentData.brand;
                const equipmentModel = equipmentData.model;
                const equipmentCategory = equipmentData.category;
                const equipmentType = equipmentData.type;
                const equipmentAvailable = equipmentData.available;
                
                console.log('Equipment data:', { equipmentId, equipmentName, equipmentAvailable });
                
                // Check if equipment is already selected
                if (selectedEquipment.find(item => item.equipmentId === equipmentId)) {
                    showNotificationModal('This equipment is already selected. Please remove it first if you want to change the quantity.');
                    return;
                }
                
                // Add to selected equipment
                const selectedItem = {
                    id: itemCounter++,
                    equipmentId: equipmentId,
                    name: equipmentName,
                    brand: equipmentBrand,
                    model: equipmentModel,
                    category: equipmentCategory,
                    type: equipmentType,
                    quantity: quantity,
                    available: equipmentAvailable
                };
                
                selectedEquipment.push(selectedItem);
                updateSelectedEquipmentList();
                updateFormInputs();
                
                console.log('Equipment added successfully:', selectedItem);
                
                // Clear all quantity validation errors to ensure clean state
                clearAllQuantityErrors();
            }

            // Remove equipment from selected list - Global function
            window.removeEquipmentFromSelected = function(equipmentId) {
                selectedEquipment = selectedEquipment.filter(item => item.equipmentId !== equipmentId);
                updateSelectedEquipmentList();
                updateFormInputs();
            }

            // Update selected equipment list display
            function updateSelectedEquipmentList() {
                const selectedList = document.getElementById('selected-equipment-list');
                const noEquipmentMessage = document.getElementById('no-equipment-selected');
                
                if (selectedEquipment.length === 0) {
                    selectedList.innerHTML = '';
                    noEquipmentMessage.style.display = 'block';
                    return;
                }
                
                noEquipmentMessage.style.display = 'none';
                
                selectedList.innerHTML = selectedEquipment.map(item => `
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">${item.name}</div>
                                <div class="text-sm text-gray-500">${item.brand || 'No brand'} ${item.model || ''}</div>
                                <div class="text-xs text-gray-400">${item.category} - ${item.type}</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm font-medium text-gray-900">
                                Qty: <span class="text-green-600 font-semibold">${item.quantity}</span>
                            </div>
                            <button type="button" 
                                    onclick="removeEquipmentFromSelected('${item.equipmentId}')"
                                    class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-full transition-all duration-200 font-bold text-lg"
                                    title="Remove equipment">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
            }

            // Update hidden form inputs
            function updateFormInputs() {
                // Remove existing hidden inputs
                const existingInputs = document.querySelectorAll('input[name^="equipment_items"]');
                existingInputs.forEach(input => input.remove());
                
                // Add new hidden inputs for selected equipment
                selectedEquipment.forEach((item, index) => {
                    const equipmentIdInput = document.createElement('input');
                    equipmentIdInput.type = 'hidden';
                    equipmentIdInput.name = `equipment_items[${index}][equipment_id]`;
                    equipmentIdInput.value = item.equipmentId;
                    
                    const quantityInput = document.createElement('input');
                    quantityInput.type = 'hidden';
                    quantityInput.name = `equipment_items[${index}][quantity_requested]`;
                    quantityInput.value = item.quantity;
                    
                    document.getElementById('reservationForm').appendChild(equipmentIdInput);
                    document.getElementById('reservationForm').appendChild(quantityInput);
                });
            }
            
            // Add equipment buttons now use onclick="showQuantityModal(this)" directly in the HTML

            // Set up filter event listeners
            if (categoryFilter) {
                categoryFilter.addEventListener('change', filterEquipment);
                categoryFilter.addEventListener('input', filterEquipment);
            }

            if (equipmentTypeFilter) {
                equipmentTypeFilter.addEventListener('change', filterEquipment);
                equipmentTypeFilter.addEventListener('input', filterEquipment);
            }

            if (equipmentSearch) {
                equipmentSearch.addEventListener('input', filterEquipment);
                equipmentSearch.addEventListener('keyup', filterEquipment);
            }

            // Quantity input validation
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    const max = parseInt(this.dataset.maxAvailable);
                    const value = parseInt(this.value);
                    
                    if (value > max) {
                        this.value = max;
                    }
                    
                    if (value < 0) {
                        this.value = 0;
                    }
                });
            });
            
            // Real-time form field validation
            const teacherName = document.getElementById('teacher_name');
            if (teacherName) {
                teacherName.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        showFieldError(this, 'Teacher/Staff name is required');
                    } else {
                        clearFieldError(this);
                    }
                });
            }
            
            function parseYmdToLocalDate(ymd) {
                if (!ymd) return null;
                const parts = ymd.split('-').map(Number);
                if (parts.length !== 3) return null;
                return new Date(parts[0], parts[1]-1, parts[2]);
            }

            function formatDateYmd(date) {
                const y = date.getFullYear();
                const m = String(date.getMonth()+1).padStart(2,'0');
                const d = String(date.getDate()).padStart(2,'0');
                return `${y}-${m}-${d}`;
            }

            function setMinDatesFromLocal() {
                const today = new Date();
                today.setHours(0,0,0,0);
                const minYmd = formatDateYmd(today); // allow same-day
                const borrowInput = document.getElementById('borrow_date');
                const returnInput = document.getElementById('return_date');
                if (borrowInput) borrowInput.min = minYmd;
                if (returnInput) returnInput.min = minYmd;
            }

            setMinDatesFromLocal();

            const borrowDate = document.getElementById('borrow_date');
            if (borrowDate) {
                borrowDate.addEventListener('change', function() {
                    if (!this.value) {
                        showFieldError(this, 'Borrow date is required');
                    } else {
                        const today = new Date(); today.setHours(0,0,0,0);
                        const selectedDate = parseYmdToLocalDate(this.value);
                        if (!selectedDate || selectedDate < today) {
                            showFieldError(this, 'Borrow date cannot be in the past');
                        } else {
                            clearFieldError(this);
                        }
                    }
                });
            }
            
            const returnDate = document.getElementById('return_date');
            if (returnDate) {
                returnDate.addEventListener('change', function() {
                    if (!this.value) {
                        showFieldError(this, 'Return date is required');
                    } else {
                        const borrowDateValue = new Date(borrowDate.value);
                        const returnDateValue = new Date(this.value);
                        if (returnDateValue < borrowDateValue) {
                            showFieldError(this, 'Return date must be on or after borrow date');
                        } else {
                            clearFieldError(this);
                        }
                    }
                });
            }
            
            const reason = document.getElementById('reason');
            if (reason) {
                reason.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        showFieldError(this, 'Reason for reservation is required');
                    } else {
                        clearFieldError(this);
                    }
                });
            }
                
            // Comprehensive form validation
            function validateForm() {
                let isValid = true;
                const errors = [];
                
                // Hide any existing error card
                hideFormErrorCard();
                
                // Validate teacher name
                const teacherName = document.getElementById('teacher_name');
                if (!teacherName.value.trim()) {
                    showFieldError(teacherName, 'Teacher/Staff name is required');
                    isValid = false;
                } else {
                    clearFieldError(teacherName);
                }
                
                // Validate borrow date
                const borrowDate = document.getElementById('borrow_date');
                if (!borrowDate.value) {
                    showFieldError(borrowDate, 'Borrow date is required');
                    isValid = false;
                } else {
                    const today = new Date(); today.setHours(0,0,0,0);
                    const selectedDate = parseYmdToLocalDate(borrowDate.value);
                    if (!selectedDate || selectedDate < today) {
                        showFieldError(borrowDate, 'Borrow date cannot be in the past');
                        isValid = false;
                    } else {
                        clearFieldError(borrowDate);
                    }
                }
                
                // Validate return date
                const returnDate = document.getElementById('return_date');
                if (!returnDate.value) {
                    showFieldError(returnDate, 'Return date is required');
                    isValid = false;
                } else {
                    const borrowDateValue = new Date(borrowDate.value);
                    const returnDateValue = new Date(returnDate.value);
                    if (returnDateValue < borrowDateValue) {
                        showFieldError(returnDate, 'Return date must be on or after borrow date');
                        isValid = false;
                    } else {
                        clearFieldError(returnDate);
                    }
                }
                
                // Validate reason type
                const reasonType = document.getElementById('reason_type');
                if (!reasonType.value) {
                    showFieldError(reasonType, 'Reason for reservation is required');
                    isValid = false;
                } else {
                    clearFieldError(reasonType);
                }
                
                // Validate custom reason if "Other" is selected
                const customReason = document.getElementById('custom_reason');
                if (reasonType.value === 'Other' && !customReason.value.trim()) {
                    showFieldError(customReason, 'Please specify the purpose of your reservation');
                    isValid = false;
                } else {
                    clearFieldError(customReason);
                }
                
                // Validate equipment selection
                if (selectedEquipment.length === 0) {
                    errors.push('Please select at least one equipment item.');
                    isValid = false;
                }
                
                // Show all errors
                if (!isValid) {
                    if (errors.length > 0) {
                        showFormErrorCard(errors);
                    }
                }
                
                return isValid;
            }
            
            // Show field error
            function showFieldError(field, message) {
                field.classList.add('border-red-500');
                let errorDiv = field.parentElement.querySelector('.field-error');
                if (!errorDiv) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'field-error text-xs text-red-600 mt-1';
                    field.parentElement.appendChild(errorDiv);
                }
                errorDiv.textContent = message;
            }
            
            // Clear field error
            function clearFieldError(field) {
                field.classList.remove('border-red-500');
                const errorDiv = field.parentElement.querySelector('.field-error');
                if (errorDiv) {
                    errorDiv.remove();
                }
                
                // Hide form error card when individual fields are corrected
                hideFormErrorCard();
            }
            
            // Clear all quantity validation errors
            function clearAllQuantityErrors() {
                document.querySelectorAll('.quantity-error').forEach(errorDiv => {
                    errorDiv.classList.add('hidden');
                });
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.classList.remove('border-red-500');
                });
            }
            
            // Form submission validation
            const form = document.getElementById('reservationForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                        return false;
                    }
                });
            }
            
            // Clear all validation errors on page load
            clearAllQuantityErrors();
            
            // Verify that add buttons are properly set up
            const addButtons = document.querySelectorAll('.add-equipment-btn');
            console.log('Found', addButtons.length, 'add equipment buttons');
            
            // Test filtering on page load
            filterEquipment();
            
            console.log('All event listeners set up successfully');
        });
    </script>
</x-app-layout>
