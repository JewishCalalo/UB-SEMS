<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Report Incident')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Incident Reports', 'url' => route('instructor.incidents.index')],
                ['label' => 'Report Incident']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Incident Reports', 'url' => route('instructor.incidents.index')],
                ['label' => 'Report Incident']
            ])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $attributes = $__attributesOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__attributesOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal360d002b1b676b6f84d43220f22129e2)): ?>
<?php $component = $__componentOriginal360d002b1b676b6f84d43220f22129e2; ?>
<?php unset($__componentOriginal360d002b1b676b6f84d43220f22129e2); ?>
<?php endif; ?>

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="flex items-center mb-2">
                            <h3 class="text-2xl font-bold text-gray-900">Report Equipment Incident</h3>
                            <div class="relative ml-3 group">
                                <svg class="w-5 h-5 text-gray-500 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-80 bg-gray-900 text-white text-sm rounded-lg p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10">
                                    <div class="text-center">
                                        <strong>How to Report Equipment Incidents:</strong><br><br>
                                        1. Select a reservation with picked-up equipment<br>
                                        2. Choose specific equipment instances that have issues<br>
                                        3. Set severity: Lost, Damaged, or Needs Repair<br>
                                        4. Add incident details and any student involvement<br>
                                        5. Upload photos if available<br>
                                        6. Submit for admin/manager review
                                    </div>
                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 font-medium">Report equipment issues, damage, or incidents that occurred during your classes.</p>
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
                    <form method="POST" action="<?php echo e(route('instructor.incidents.store')); ?>" class="space-y-6" id="incidentForm">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Reservation Selection -->
                        <div class="bg-white border border-gray-200 rounded-lg mb-6 shadow-sm">
                            <div class="px-6 py-4 bg-red-50 border-b border-red-200 rounded-t-lg">
                                <h4 class="text-lg font-semibold text-red-800 flex items-center m-0">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Reservation & Equipment Details
                                </h4>
                            </div>
                            <div class="p-6">

                            <!-- Reservation Selection -->
                            <div class="mb-6">
                                <label for="reservation_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Reservation <span class="text-red-500">*</span>
                                </label>
                                <select name="reservation_id" id="reservation_id" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    <option value="">Select a reservation...</option>
                                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $approvedEquipment = $reservation->items->map(function($item) {
                                                return [
                                                    'id' => $item->equipment->id,
                                                    'brand' => $item->equipment->brand,
                                                    'model' => $item->equipment->model,
                                                    'display_name' => $item->equipment->display_name,
                                                    'instances' => $item->reservationItemInstances->map(function($rii) {
                                                        return [
                                                            'id' => $rii->equipmentInstance->id,
                                                            'instance_code' => $rii->equipmentInstance->instance_code,
                                                            'status' => $rii->equipmentInstance->status
                                                        ];
                                                    })->toArray()
                                                ];
                                            })->toArray();
                                        ?>
                                        <option value="<?php echo e($reservation->id); ?>" 
                                                data-equipment="<?php echo e(json_encode($approvedEquipment)); ?>">
                                            <?php echo e($reservation->reservation_code); ?> - <?php echo e($reservation->borrow_date->format('M d, Y')); ?> to <?php echo e($reservation->return_date->format('M d, Y')); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="error-message text-sm text-red-600 mt-1 hidden" id="reservation_error"></div>
                            </div>

                            <!-- Equipment Instances Table -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Equipment Instances <span class="text-red-500">*</span>
                                </label>
                                <div id="equipment_instances_container" class="hidden">
                                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                        <div class="overflow-x-auto max-h-80">
                                            <table class="w-full text-sm">
                                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Equipment</th>
                                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Instance Code</th>
                                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Select</th>
                                                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Severity</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="equipment_instances_table" class="bg-white divide-y divide-gray-200">
                                                    <!-- Dynamic content will be inserted here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="error-message text-sm text-red-600 mt-1 hidden" id="equipment_error"></div>
                                </div>
                                <div id="no_equipment_message" class="text-gray-500 text-sm italic">
                                    Please select a reservation first
                                </div>
                            </div>

                            <!-- Equipment Summary -->
                            <div id="equipment_summary" class="hidden mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <h5 class="text-sm font-semibold text-blue-800 mb-2">Selected Equipment Summary:</h5>
                                <div id="summary_content" class="text-sm text-blue-700">
                                    <!-- Summary will be populated here -->
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Incident Details -->
                        <div class="bg-white border border-gray-200 rounded-lg mb-6 shadow-sm">
                            <div class="px-6 py-4 bg-red-50 border-b border-red-200 rounded-t-lg">
                                <h4 class="text-lg font-semibold text-red-800 flex items-center m-0">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Incident Details
                                </h4>
                            </div>
                            <div class="p-6">

                            <!-- Incident Description -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Incident Description <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                          placeholder="Please provide a detailed description of what happened..."></textarea>
                                <div class="error-message text-sm text-red-600 mt-1 hidden" id="description_error"></div>
                            </div>

                            </div>
                        </div>

                        <!-- Student Involvement -->
                        <div class="bg-white border border-gray-200 rounded-lg mb-6 shadow-sm">
                            <div class="px-6 py-4 bg-red-50 border-b border-red-200 rounded-t-lg flex justify-between items-center">
                                <h4 class="text-lg font-semibold text-red-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    Student Involvement (Optional)
                                </h4>
                                <button type="button" id="addStudentBtn" 
                                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 transition-colors">
                                    <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Student
                                </button>
                            </div>
                            <div class="p-6">

                            <!-- Students Container -->
                            <div id="studentsContainer" class="space-y-4">
                                <!-- Student template will be added here dynamically -->
                            </div>

                            <!-- Student Involvement Details -->
                            <div class="mt-6">
                                <label for="student_involvement" class="block text-sm font-medium text-gray-700 mb-2">
                                    Student Involvement Details
                                </label>
                                <textarea name="student_involvement" id="student_involvement" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                          placeholder="Describe how the students were involved in the incident..."></textarea>
                            </div>
                            </div>
                        </div>

                        

                        

                        <!-- Form Actions -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <a href="<?php echo e(route('instructor.incidents.index')); ?>" 
                               class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" id="submitBtn"
                                    class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-red-600 text-white hover:bg-red-700 focus:ring-red-500">
                                <span id="submitText" class="inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Submit Incident Report
                                </span>
                                <span id="loadingText" class="hidden inline-flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Submitting...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('incidentForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const loadingText = document.getElementById('loadingText');
            const reservationSelect = document.getElementById('reservation_id');
            const equipmentInstancesContainer = document.getElementById('equipment_instances_container');
            const noEquipmentMessage = document.getElementById('no_equipment_message');
            const equipmentInstancesTable = document.getElementById('equipment_instances_table');
            
            const addStudentBtn = document.getElementById('addStudentBtn');
            const studentsContainer = document.getElementById('studentsContainer');

            // Real-time validation
            function validateField(fieldId, validationFn, errorMessageId) {
                const field = document.getElementById(fieldId);
                const errorDiv = document.getElementById(errorMessageId);
                
                if (validationFn(field.value)) {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-gray-300');
                    errorDiv.classList.add('hidden');
                    return true;
                } else {
                    field.classList.add('border-red-500');
                    field.classList.remove('border-gray-300');
                    errorDiv.textContent = getErrorMessage(fieldId);
                    errorDiv.classList.remove('hidden');
                    return false;
                }
            }

            function getErrorMessage(fieldId) {
                const messages = {
                    'reservation_id': 'Please select a reservation',
                    'description': 'Please provide a description',
                    'equipment': 'Please select at least one equipment instance',
                    'student_id': 'Student ID must be exactly 8 digits',
                    'student_email': 'Student email must end with @s.ubaguio.edu'
                };
                return messages[fieldId] || 'This field is required';
            }

            function validateForm() {
                let isValid = true;

                // Validate reservation
                isValid &= validateField('reservation_id', value => value !== '', 'reservation_error');

                // Validate description
                isValid &= validateField('description', value => value.trim() !== '', 'description_error');

                // Validate equipment instances
                const selectedInstances = document.querySelectorAll('input[name="equipment_instances[]"]:checked');
                if (selectedInstances.length === 0) {
                    document.getElementById('equipment_error').textContent = 'Please select at least one equipment instance';
                    document.getElementById('equipment_error').classList.remove('hidden');
                    isValid = false;
                } else {
                    document.getElementById('equipment_error').classList.add('hidden');
                }

                return isValid;
            }

            // Handle reservation selection
            reservationSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const equipmentData = selectedOption.dataset.equipment;
                
                if (equipmentData) {
                    const equipment = JSON.parse(equipmentData);
                    populateEquipmentInstances(equipment);
                    equipmentInstancesContainer.classList.remove('hidden');
                    noEquipmentMessage.classList.add('hidden');
                } else {
                    equipmentInstancesContainer.classList.add('hidden');
                    noEquipmentMessage.classList.remove('hidden');
                }
                
                validateForm();
            });

            // Populate equipment instances table
            function populateEquipmentInstances(equipment) {
                equipmentInstancesTable.innerHTML = '';
                
                equipment.forEach(item => {
                    if (item.instances && item.instances.length > 0) {
                        item.instances.forEach(instance => {
                            const row = document.createElement('tr');
                            row.className = 'border-b border-gray-200 hover:bg-gray-50';
                            row.innerHTML = `
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">${item.brand} ${item.model}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">${instance.instance_code || `#${instance.id}`}</td>
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" name="equipment_instances[]" value="${instance.id}" 
                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded equipment-checkbox"
                                           data-equipment-name="${item.brand} ${item.model}"
                                           data-instance-code="${instance.instance_code || `#${instance.id}`}">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <select name="severity_${instance.id}" class="text-xs px-2 py-1 border border-gray-300 rounded focus:ring-1 focus:ring-red-500 severity-select"
                                            data-instance-id="${instance.id}">
                                        <option value="">Select severity...</option>
                                        <option value="needs_repair">Needs Repair</option>
                                        <option value="damaged">Damaged</option>
                                        <option value="lost">Lost</option>
                                    </select>
                                </td>
                            `;
                            equipmentInstancesTable.appendChild(row);
                        });
                    }
                });
                
                // Add event listeners for checkboxes and severity selects
                addEquipmentEventListeners();
            }

            // Add event listeners for equipment checkboxes and severity selects
            function addEquipmentEventListeners() {
                const checkboxes = document.querySelectorAll('.equipment-checkbox');
                const severitySelects = document.querySelectorAll('.severity-select');
                
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateEquipmentSummary);
                });
                
                severitySelects.forEach(select => {
                    select.addEventListener('change', updateEquipmentSummary);
                });
            }

            // Update equipment summary
            function updateEquipmentSummary() {
                const summaryDiv = document.getElementById('equipment_summary');
                const summaryContent = document.getElementById('summary_content');
                const checkboxes = document.querySelectorAll('.equipment-checkbox:checked');
                
                // Clear equipment validation error when equipment is selected
                const equipmentError = document.getElementById('equipment_error');
                if (equipmentError && checkboxes.length > 0) {
                    equipmentError.classList.add('hidden');
                }
                
                if (checkboxes.length === 0) {
                    summaryDiv.classList.add('hidden');
                    return;
                }
                
                let summaryHtml = '<div class="space-y-2">';
                checkboxes.forEach(checkbox => {
                    const equipmentName = checkbox.dataset.equipmentName;
                    const instanceCode = checkbox.dataset.instanceCode;
                    const instanceId = checkbox.value;
                    const severitySelect = document.querySelector(`select[name="severity_${instanceId}"]`);
                    const severity = severitySelect ? severitySelect.value : 'Not selected';
                    
                    summaryHtml += `
                        <div class="flex justify-between items-center bg-white p-2 rounded border">
                            <span class="font-medium">${equipmentName} (${instanceCode})</span>
                            <span class="text-sm px-2 py-1 rounded ${
                                severity === 'needs_repair' ? 'bg-yellow-100 text-yellow-800' :
                                severity === 'damaged' ? 'bg-orange-100 text-orange-800' :
                                severity === 'lost' ? 'bg-red-100 text-red-800' :
                                'bg-gray-100 text-gray-800'
                            }">${severity === 'needs_repair' ? 'Needs Repair' : 
                                severity === 'damaged' ? 'Damaged' : 
                                severity === 'lost' ? 'Lost' : 
                                'Not selected'}</span>
                        </div>
                    `;
                });
                summaryHtml += '</div>';
                
                summaryContent.innerHTML = summaryHtml;
                summaryDiv.classList.remove('hidden');
            }


            // Student management
            let studentCount = 0;

            function addStudent() {
                studentCount++;
                const studentDiv = document.createElement('div');
                studentDiv.className = 'bg-white border border-gray-200 rounded-lg p-4 student-entry';
                studentDiv.innerHTML = `
                    <div class="flex justify-between items-center mb-4">
                        <h5 class="text-sm font-semibold text-gray-700">Student ${studentCount}</h5>
                        <button type="button" class="remove-student-btn text-red-600 hover:text-red-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student Name</label>
                            <input type="text" name="students[${studentCount}][name]" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                   placeholder="Student's full name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Student Email</label>
                            <input type="email" name="students[${studentCount}][email]" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm"
                                   placeholder="student@s.ubaguio.edu">
                            <div class="error-message text-xs text-red-600 mt-1 hidden"></div>
                        </div>
                    </div>
                `;
                
                studentsContainer.appendChild(studentDiv);
                
                // Add event listeners for validation
                const emailInput = studentDiv.querySelector('input[name*="[email]"]');
                
                emailInput.addEventListener('input', function() {
                    validateStudentField(this, value => value === '' || /^[a-zA-Z0-9._%+-]+@s\.ubaguio\.edu$/.test(value));
                });
                
                // Add remove functionality
                const removeBtn = studentDiv.querySelector('.remove-student-btn');
                removeBtn.addEventListener('click', function() {
                    studentDiv.remove();
                });
            }

            function validateStudentField(field, validationFn) {
                const errorDiv = field.parentNode.querySelector('.error-message');
                
                if (validationFn(field.value)) {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-gray-300');
                    if (errorDiv) errorDiv.classList.add('hidden');
                    return true;
                } else {
                    field.classList.remove('border-gray-300');
                    field.classList.add('border-red-500');
                    if (errorDiv) {
                        errorDiv.textContent = 'Email must end with @s.ubaguio.edu';
                        errorDiv.classList.remove('hidden');
                    }
                    return false;
                }
            }

            // Add student button event listener
            addStudentBtn.addEventListener('click', addStudent);

            // Real-time validation for text inputs
            ['description'].forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', function() {
                        validateField(fieldId, value => value.trim() !== '', fieldId + '_error');
                    });
                }
            });

            // File attachments removed per requirement

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!validateForm()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields correctly.',
                        confirmButtonColor: '#dc2626'
                    });
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');

                // Show loading modal
                Swal.fire({
                    title: 'Submitting Incident Report...',
                    text: 'Please wait while we process your report.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        // Try to parse as JSON first
                        return response.text().then(text => {
                            try {
                                const data = JSON.parse(text);
                                throw new Error(data.message || 'An error occurred');
                            } catch (e) {
                                // If not JSON, show the text response
                                throw new Error(text || 'An error occurred');
                            }
                        });
                    }
                    
                    // Check if response is JSON
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json();
                    } else {
                        // If not JSON, redirect to success page
                        window.location.href = '<?php echo e(route('instructor.incidents.index')); ?>';
                        return;
                    }
                })
                .then(data => {
                    // Check if data exists and has success property
                    if (data && data.success) {
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 -mx-6 -mt-6 mb-6 rounded-t-lg">
                                    <h2 class="text-xl font-bold text-center">Incident Report Submitted Successfully!</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">${data.message || 'Incident report submitted successfully.'}</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.href='<?php echo e(route('instructor.incidents.index')); ?>'">
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
                    } else if (data && data.success === false) {
                        throw new Error(data.message || 'An error occurred');
                    } else {
                        // If data is undefined or doesn't have success property, treat as success
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 -mx-6 -mt-6 mb-6 rounded-t-lg">
                                    <h2 class="text-xl font-bold text-center">Incident Report Submitted Successfully!</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">Incident report submitted successfully.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.href='<?php echo e(route('instructor.incidents.index')); ?>'">
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
                })
                .catch(error => {
                    console.error('Form submission error:', error);
                    
                    // Check if it's a JSON parsing error
                    if (error.message.includes('Unexpected token') || error.message.includes('<!DOCTYPE')) {
                        // This means we got HTML instead of JSON, likely a redirect
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 -mx-6 -mt-6 mb-6 rounded-t-lg">
                                    <h2 class="text-xl font-bold text-center">Incident Report Submitted Successfully!</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700">Incident report submitted successfully.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.href='<?php echo e(route('instructor.incidents.index')); ?>'">
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
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Failed to submit incident report. Please try again.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                })
                .finally(() => {
                    // Reset loading state
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    loadingText.classList.add('hidden');
                });
            });

            // Initial validation
            validateForm();
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv25\resources\views/instructor/incidents/create.blade.php ENDPATH**/ ?>