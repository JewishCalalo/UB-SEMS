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
            <?php echo e(__('Create Reservation')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'My Reservations', 'url' => route('instructor.reservations')],
                ['label' => 'Create Reservation']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'My Reservations', 'url' => route('instructor.reservations')],
                ['label' => 'Create Reservation']
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
                            <h3 class="text-2xl font-bold text-gray-900">Create New Reservation</h3>
                            <div class="relative ml-3 group">
                                <svg class="w-5 h-5 text-gray-500 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-80 bg-gray-900 text-white text-sm rounded-lg p-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10">
                                    <div class="text-center">
                                        <strong>How to Create Reservations:</strong><br><br>
                                        1. Select equipment you need for your class<br>
                                        2. Set your borrow and return dates<br>
                                        3. Choose specific times (use presets or custom)<br>
                                        4. Add a reason for the reservation<br>
                                        5. Review your selections<br>
                                        6. Submit for approval
                                    </div>
                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 font-medium">Request equipment for your PE classes and activities.</p>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-chalkboard-teacher mr-2 text-red-500"></i>
                        PE Instructor
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mb-4 flex justify-end">
                <a href="<?php echo e(url()->previous()); ?>" class="inline-flex items-center px-8 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 shadow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back
                </a>
            </div>

            <!-- Error Messages -->
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="<?php echo e(route('instructor.reservations.store')); ?>" class="space-y-6" id="reservationForm">
                        <?php echo csrf_field(); ?>
                        
                        <!-- Date and Time Selection -->
                        <div class="bg-white border border-gray-200 rounded-lg mb-8 shadow-sm">
                            <div class="px-6 py-4 bg-red-50 border-b border-red-200 rounded-t-lg">
                                <h4 class="text-lg font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Date & Time Selection <span class="text-red-500">*</span>
                                </h4>
                            </div>
                            <div class="p-6">
                            
                            <!-- Error Card for Date & Time Validation -->
                            <div id="dateTimeErrorCard" class="hidden bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Please correct the following date and time issues:</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul id="dateTimeErrorList" class="list-disc list-inside space-y-1">
                                                <!-- Error messages will be populated here -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Borrow Date -->
                                <div>
                                    <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Borrow Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="borrow_date" id="borrow_date" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all <?php $__errorArgs = ['borrow_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(old('borrow_date')); ?>">
                                    <?php $__errorArgs = ['borrow_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <!-- Return Date -->
                                <div>
                                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Return Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="return_date" id="return_date" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all <?php $__errorArgs = ['return_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           min="<?php echo e(date('Y-m-d')); ?>" value="<?php echo e(old('return_date')); ?>">
                                    <?php $__errorArgs = ['return_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Borrow Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Borrow Time <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-3">
                                        <!-- Custom Time Selector -->
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-1">
                                                <select id="borrow_hour" name="borrow_hour" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                                    <option value="">Hour</option>
                                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                                        <option value="<?php echo e(sprintf('%02d', $i)); ?>" <?php echo e(old('borrow_hour') == sprintf('%02d', $i) ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <span class="text-gray-500 font-bold text-lg">:</span>
                                            <div class="flex-1">
                                                <select id="borrow_minute" name="borrow_minute" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                                    <option value="">Min</option>
                                                    <?php for($i = 0; $i < 60; $i += 15): ?>
                                                        <option value="<?php echo e(sprintf('%02d', $i)); ?>" <?php echo e(old('borrow_minute') == sprintf('%02d', $i) ? 'selected' : ''); ?>><?php echo e(sprintf('%02d', $i)); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="flex-1">
                                                <select id="borrow_period" name="borrow_period" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                                    <option value="">AM/PM</option>
                                                    <option value="AM" <?php echo e(old('borrow_period') == 'AM' ? 'selected' : ''); ?>>AM</option>
                                                    <option value="PM" <?php echo e(old('borrow_period') == 'PM' ? 'selected' : ''); ?>>PM</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Quick Preset Buttons -->
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" onclick="setCustomTime('borrow', '07:00', 'AM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">7:00 AM</button>
                                            <button type="button" onclick="setCustomTime('borrow', '08:00', 'AM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">8:00 AM</button>
                                            <button type="button" onclick="setCustomTime('borrow', '09:00', 'AM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">9:00 AM</button>
                                            <button type="button" onclick="setCustomTime('borrow', '10:00', 'AM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">10:00 AM</button>
                                            <button type="button" onclick="setCustomTime('borrow', '01:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">1:00 PM</button>
                                            <button type="button" onclick="setCustomTime('borrow', '02:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">2:00 PM</button>
                                            <button type="button" onclick="setCustomTime('borrow', '03:30', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">3:30 PM</button>
                                        </div>
                                        
                                        <!-- Inline error hint removed -->
                                        <!-- Hidden input for form submission -->
                                        <input type="hidden" id="borrow_time" name="borrow_time" value="<?php echo e(old('borrow_time')); ?>">
                                    </div>
                                    <?php $__errorArgs = ['borrow_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Return Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Return Time <span class="text-red-500">*</span>
                                    </label>
                                    <div class="space-y-3">
                                        <!-- Custom Time Selector -->
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-1">
                                                <select id="return_hour" name="return_hour" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                                    <option value="">Hour</option>
                                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                                        <option value="<?php echo e(sprintf('%02d', $i)); ?>" <?php echo e(old('return_hour') == sprintf('%02d', $i) ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <span class="text-gray-500 font-bold text-lg">:</span>
                                            <div class="flex-1">
                                                <select id="return_minute" name="return_minute" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                                    <option value="">Min</option>
                                                    <?php for($i = 0; $i < 60; $i += 15): ?>
                                                        <option value="<?php echo e(sprintf('%02d', $i)); ?>" <?php echo e(old('return_minute') == sprintf('%02d', $i) ? 'selected' : ''); ?>><?php echo e(sprintf('%02d', $i)); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="flex-1">
                                                <select id="return_period" name="return_period" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                                    <option value="">AM/PM</option>
                                                    <option value="AM" <?php echo e(old('return_period') == 'AM' ? 'selected' : ''); ?>>AM</option>
                                                    <option value="PM" <?php echo e(old('return_period') == 'PM' ? 'selected' : ''); ?>>PM</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Quick Preset Buttons -->
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" onclick="setCustomTime('return', '12:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">12:00 PM</button>
                                            <button type="button" onclick="setCustomTime('return', '01:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">1:00 PM</button>
                                            <button type="button" onclick="setCustomTime('return', '02:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">2:00 PM</button>
                                            <button type="button" onclick="setCustomTime('return', '03:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">3:00 PM</button>
                                            <button type="button" onclick="setCustomTime('return', '04:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">4:00 PM</button>
                                            <button type="button" onclick="setCustomTime('return', '05:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">5:00 PM</button>
                                            <button type="button" onclick="setCustomTime('return', '06:00', 'PM')" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full hover:bg-red-200 transition-colors">6:00 PM</button>
                                        </div>
                                        
                                        <!-- Inline error hint removed -->
                                        <!-- Hidden input for form submission -->
                                        <input type="hidden" id="return_time" name="return_time" value="<?php echo e(old('return_time')); ?>">
                                    </div>
                                    <?php $__errorArgs = ['return_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Equipment Selection -->
                        <div class="bg-white border border-gray-200 rounded-lg mb-8 shadow-sm">
                            <div class="px-6 py-4 bg-red-50 border-b border-red-200 rounded-t-lg flex justify-between items-center">
                                <h4 class="text-lg font-semibold text-red-800 flex items-center m-0">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Select Equipment <span class="text-red-500">*</span>
                                </h4>
                            
                                <!-- Equipment Filter -->
                                <div class="flex items-center space-x-2">
                                    <div class="relative w-full max-w-xs">
                                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1119 9a7.5 7.5 0 01-2.35 7.65z"/></svg>
                                        <input type="text" id="equipment-search" placeholder="Search equipment..." 
                                               class="pl-9 pr-3 py-2 w-full border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 placeholder-gray-400">
                                    </div>
                                    <div class="relative">
                                        <select id="category-filter" class="appearance-none pl-3 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white w-full" style="background-image:none;">
                                            <option value="">All Categories</option>
                                            <?php $__currentLoopData = $equipment->pluck('category.name')->unique(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category); ?>"><?php echo e($category); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5" id="equipment-grid">
                                <?php $__currentLoopData = $equipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="equipment-card border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow <?php echo e($item->quantity_available <= 0 ? 'bg-gray-50' : 'bg-white'); ?>" 
                                         data-category="<?php echo e($item->category->name); ?>" 
                                         data-name="<?php echo e(strtolower($item->display_name)); ?>">
                                        <div class="flex items-start space-x-3">
                                            <input type="checkbox" 
                                                   class="equipment-checkbox mt-1 h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" 
                                                   value="<?php echo e($item->id); ?>" <?php if($item->quantity_available <= 0): ?> disabled <?php endif; ?>
                                                   data-equipment-id="<?php echo e($item->id); ?>"
                                                   data-equipment-name="<?php echo e($item->display_name); ?>"
                                                   data-max-quantity="<?php echo e($item->quantity_available); ?>">
                                            
                                            <!-- Equipment Image -->
                                            <div class="flex-shrink-0">
                                                <?php
                                                    $imageUrl = null;
                                                    try {
                                                        if (isset($item->images) && method_exists($item->images, 'count') && $item->images->count() > 0) {
                                                            $imageUrl = optional($item->images->first())->url;
                                                        } elseif (isset($item->primary_image) && $item->primary_image) {
                                                            $imageUrl = $item->primary_image->url ?? null;
                                                        }
                                                    } catch (Exception $e) {
                                                        $imageUrl = null;
                                                    }
                                                ?>
                                                <?php if($imageUrl): ?>
                                                    <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($item->display_name); ?>" class="w-16 h-16 object-cover rounded-lg border border-gray-200" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div class="w-16 h-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center" style="display:none;">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="w-16 h-16 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2z"></path></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between">
                                                    <h5 class="text-sm font-medium text-gray-900"><?php echo e($item->display_name); ?></h5>
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium <?php echo e($item->quantity_available>0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                                        <?php echo e($item->quantity_available>0 ? 'Available' : 'Unavailable'); ?>

                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1"><?php echo e($item->category->name); ?></p>
                                                <p class="text-xs text-gray-500">Available: <span class="font-medium <?php echo e($item->quantity_available>0 ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e($item->quantity_available); ?></span></p>
                                                
                                                <?php if($item->description): ?>
                                                    <p class="text-xs text-gray-600 mt-2"><?php echo e(Str::limit($item->description, 60)); ?></p>
                                                <?php endif; ?>
                                                
                                                <div class="mt-3 quantity-controls hidden">
                                                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantity:</label>
                                                    <div class="flex items-center space-x-2">
                                                        <button type="button" class="quantity-decrease w-7 h-7 bg-red-100 text-red-700 rounded-full flex items-center justify-center text-sm hover:bg-red-200 transition-colors">-</button>
                                                        <input type="number" 
                                                               class="quantity-input w-16 px-2 py-1 text-sm border border-gray-300 rounded text-center" 
                                                               <?php if($item->quantity_available <= 0): ?> disabled <?php endif; ?>
                                                               min="<?php echo e($item->quantity_available > 0 ? 1 : 0); ?>" 
                                                               max="<?php echo e($item->quantity_available); ?>" 
                                                               value="<?php echo e($item->quantity_available > 0 ? 1 : 0); ?>" 
                                                               aria-label="Quantity" inputmode="numeric" pattern="[0-9]*">
                                                        <button type="button" class="quantity-increase w-7 h-7 bg-red-100 text-red-700 rounded-full flex items-center justify-center text-sm hover:bg-red-200 transition-colors">+</button>
                                                    </div>
                                                    <div class="quantity-error text-xs text-red-600 mt-1 hidden"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            
                            <?php $__errorArgs = ['cart_data'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Purpose -->
                        <div class="bg-white border border-gray-200 rounded-lg mb-8 shadow-sm">
                            <div class="px-6 py-4 bg-red-50 border-b border-red-200 rounded-t-lg">
                                <h4 class="text-lg font-semibold text-red-800 flex items-center m-0">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Purpose <span class="text-red-500">*</span>
                                </h4>
                            </div>
                            <div class="p-6">
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="reason_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Purpose <span class="text-red-500">*</span>
                                    </label>
                                    <select name="reason_type" id="reason_type" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all <?php $__errorArgs = ['reason_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value="">Select a purpose</option>
                                        <option value="PE Class" <?php echo e(old('reason_type') == 'PE Class' ? 'selected' : ''); ?>>PE Class</option>
                                        <option value="Sports Training" <?php echo e(old('reason_type') == 'Sports Training' ? 'selected' : ''); ?>>Sports Training</option>
                                        <option value="Tournament" <?php echo e(old('reason_type') == 'Tournament' ? 'selected' : ''); ?>>Tournament</option>
                                        <option value="Practice Session" <?php echo e(old('reason_type') == 'Practice Session' ? 'selected' : ''); ?>>Practice Session</option>
                                        <option value="Intramural Sports" <?php echo e(old('reason_type') == 'Intramural Sports' ? 'selected' : ''); ?>>Intramural Sports</option>
                                        <option value="Special Event" <?php echo e(old('reason_type') == 'Special Event' ? 'selected' : ''); ?>>Special Event</option>
                                        <option value="Research/Study" <?php echo e(old('reason_type') == 'Research/Study' ? 'selected' : ''); ?>>Research/Study</option>
                                        <option value="Other" <?php echo e(old('reason_type') == 'Other' ? 'selected' : ''); ?>>Other (Specify)</option>
                                    </select>
                                    <?php $__errorArgs = ['reason_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div id="custom_reason_div" class="hidden">
                                    <label for="custom_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                        Specify Purpose <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="custom_reason" id="custom_reason" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all <?php $__errorArgs = ['custom_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              placeholder="Please specify the purpose of your reservation..."><?php echo e(old('custom_reason')); ?></textarea>
                                    <?php $__errorArgs = ['custom_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-sm text-red-600 mt-1"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div>
                                    <label for="additional_details" class="block text-sm font-medium text-gray-700 mb-2">
                                        Additional Details (Optional)
                                    </label>
                                    <textarea name="additional_details" id="additional_details" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                              placeholder="Any additional information about your reservation..."><?php echo e(old('additional_details')); ?></textarea>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- Hidden reservation data -->
                        <input type="hidden" name="cart_data" id="cart_data" value="">

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
            // Get form elements
            const form = document.getElementById('reservationForm');
            const submitBtn = document.getElementById('submitBtn');
            const reservationDataInput = document.getElementById('cart_data');
            const equipmentCheckboxes = document.querySelectorAll('.equipment-checkbox');
            const equipmentSearch = document.getElementById('equipment-search');
            const categoryFilter = document.getElementById('category-filter');
            const equipmentGrid = document.getElementById('equipment-grid');
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

            // Custom time selector functionality
            function setCustomTime(type, time, period) {
                const [hour, minute] = time.split(':');
                const hourSelect = document.getElementById(`${type}_hour`);
                const minuteSelect = document.getElementById(`${type}_minute`);
                const periodSelect = document.getElementById(`${type}_period`);
                
                hourSelect.value = hour;
                minuteSelect.value = minute;
                periodSelect.value = period;
                
                updateTimeInput(type);
                validateForm();
            }

            function updateTimeInput(type) {
                const hour = document.getElementById(`${type}_hour`).value;
                const minute = document.getElementById(`${type}_minute`).value;
                const period = document.getElementById(`${type}_period`).value;
                const timeInput = document.getElementById(`${type}_time`);
                
                if (hour && minute && period) {
                    // Convert 12-hour to 24-hour format
                    let hour24 = parseInt(hour);
                    if (period === 'AM' && hour24 === 12) {
                        hour24 = 0;
                    } else if (period === 'PM' && hour24 !== 12) {
                        hour24 += 12;
                    }
                    
                    const time24 = `${hour24.toString().padStart(2, '0')}:${minute}`;
                    timeInput.value = time24;
                } else {
                    timeInput.value = '';
                }
            }

            // Add event listeners for time selectors
            ['borrow', 'return'].forEach(type => {
                document.getElementById(`${type}_hour`).addEventListener('change', () => updateTimeInput(type));
                document.getElementById(`${type}_minute`).addEventListener('change', () => updateTimeInput(type));
                document.getElementById(`${type}_period`).addEventListener('change', () => updateTimeInput(type));
            });

            // Equipment search and filter
            function filterEquipment() {
                const searchTerm = equipmentSearch.value.toLowerCase();
                const selectedCategory = categoryFilter.value;
                
                document.querySelectorAll('.equipment-card').forEach(card => {
                    const name = card.dataset.name;
                    const category = card.dataset.category;
                    
                    const matchesSearch = name.includes(searchTerm);
                    const matchesCategory = !selectedCategory || category === selectedCategory;
                    
                    if (matchesSearch && matchesCategory) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            equipmentSearch.addEventListener('input', filterEquipment);
            categoryFilter.addEventListener('change', filterEquipment);

            // Reason type handler
            reasonTypeSelect.addEventListener('change', function() {
                if (this.value === 'Other') {
                    customReasonDiv.classList.remove('hidden');
                    customReasonInput.required = true;
                } else {
                    customReasonDiv.classList.add('hidden');
                    customReasonInput.required = false;
                    customReasonInput.value = ''; // Clear the custom reason when not needed
                }
                validateForm();
            });

            // Equipment selection handlers
            equipmentCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const card = this.closest('.equipment-card');
                    const quantityControls = card.querySelector('.quantity-controls');
                    const quantityInput = card.querySelector('.quantity-input');
                    const maxQuantity = parseInt(this.dataset.maxQuantity);
                    
                    if (this.checked) {
                        quantityControls.classList.remove('hidden');
                        quantityInput.max = maxQuantity;
                        if (parseInt(quantityInput.value) > maxQuantity) {
                            quantityInput.value = maxQuantity;
                        }
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
                        validateQuantity(input);
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
                        validateQuantity(input);
                    }
                });
            });

            // Manual quantity input validation
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    validateQuantity(this);
                    updateReservationData();
                });
            });

            function validateQuantity(input) {
                const max = parseInt(input.getAttribute('max'));
                const value = parseInt(input.value);
                const errorDiv = input.closest('.quantity-controls').querySelector('.quantity-error');
                
                if (value > max) {
                    input.value = max;
                    errorDiv.textContent = `Maximum available: ${max}`;
                    errorDiv.classList.remove('hidden');
                } else if (value < 1) {
                    input.value = 1;
                    errorDiv.textContent = 'Minimum quantity: 1';
                    errorDiv.classList.remove('hidden');
                } else {
                    errorDiv.classList.add('hidden');
                }
            }

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
            function validateForm(showErrors = false) {
                const borrowDate = document.getElementById('borrow_date').value;
                const returnDate = document.getElementById('return_date').value;
                const borrowTime = document.getElementById('borrow_time').value;
                const returnTime = document.getElementById('return_time').value;
                const reasonType = reasonTypeSelect.value;
                const customReason = customReasonInput.value.trim();
                const hasEquipment = Array.from(equipmentCheckboxes).some(cb => cb.checked);

                let isValid = true;
                let dateTimeErrors = [];

                // Only clear/show errors if showErrors is true (during submission)
                if (showErrors) {
                    clearDateTimeErrors();
                }

                // Validate dates
                if (!borrowDate) {
                    dateTimeErrors.push('Borrow date is required');
                    isValid = false;
                }
                if (!returnDate) {
                    dateTimeErrors.push('Return date is required');
                    isValid = false;
                }
                if (borrowDate && returnDate && new Date(returnDate) < new Date(borrowDate)) {
                    dateTimeErrors.push('Return date cannot be before borrow date');
                    isValid = false;
                }

                // Validate times: window 08:00-17:00 and if same day, at least 30 minutes apart
                function toMin(v){if(!v)return null;const [h,m]=v.split(':').map(Number);return h*60+m;}
                const MIN=8*60, MAX=18*60; // allow up to 6:00 PM
                const bMin = toMin(borrowTime); const rMin = toMin(returnTime);
                
                if (!borrowTime) {
                    dateTimeErrors.push('Borrow time is required');
                    isValid = false;
                }
                if (!returnTime) {
                    dateTimeErrors.push('Return time is required');
                    isValid = false;
                }
                if (bMin!==null && (bMin<MIN || bMin>MAX)) {
                    dateTimeErrors.push('Borrow time must be between 8:00 AM and 6:00 PM');
                    isValid = false;
                }
                if (rMin!==null && (rMin<MIN || rMin>MAX)) {
                    dateTimeErrors.push('Return time must be between 8:00 AM and 6:00 PM');
                    isValid = false;
                }
                
                // Check for past times on same day
                if (borrowDate && returnDate && borrowDate===returnDate && bMin!==null && rMin!==null) {
                    const today = new Date();
                    const todayStr = today.toISOString().split('T')[0];
                    const currentTime = today.getHours() * 60 + today.getMinutes();
                    
                    console.log('Time validation - borrowDate:', borrowDate, 'todayStr:', todayStr, 'currentTime:', currentTime, 'bMin:', bMin, 'rMin:', rMin);
                    
                    if (borrowDate === todayStr) {
                        if (bMin <= currentTime) {
                            console.log('Adding borrow time past error');
                            dateTimeErrors.push('Borrow time cannot be in the past for today\'s reservation');
                            isValid = false;
                        }
                        if (rMin <= currentTime) {
                            console.log('Adding return time past error');
                            dateTimeErrors.push('Return time cannot be in the past for today\'s reservation');
                            isValid = false;
                        }
                    }
                    
                    if (rMin<=bMin) {
                        dateTimeErrors.push('Return time must be after borrow time');
                        isValid = false;
                    } else if (rMin-bMin<30) {
                        dateTimeErrors.push('At least 30 minutes difference required for same-day reservations');
                        isValid = false;
                    }
                }

                // Show date/time errors in the error card
                console.log('Validation result - showErrors:', showErrors, 'dateTimeErrors.length:', dateTimeErrors.length, 'dateTimeErrors:', dateTimeErrors);
                
                // Always show time-related errors in the error card (both on field change and submission)
                const timeRelatedErrors = dateTimeErrors.filter(error => 
                    error.includes('past') || 
                    error.includes('time') || 
                    error.includes('Borrow time') || 
                    error.includes('Return time') ||
                    error.includes('30 minutes') ||
                    error.includes('after borrow time')
                );
                
                if (timeRelatedErrors.length > 0) {
                    console.log('Calling showDateTimeErrors for time errors');
                    showDateTimeErrors(timeRelatedErrors);
                } else if (showErrors && dateTimeErrors.length > 0) {
                    console.log('Calling showDateTimeErrors for all errors');
                    showDateTimeErrors(dateTimeErrors);
                } else if (showErrors) {
                    console.log('Calling clearDateTimeErrors');
                    clearDateTimeErrors();
                } else if (dateTimeErrors.length === 0) {
                    // Clear errors if no validation errors
                    clearDateTimeErrors();
                }

                // Validate reason
                console.log('Validating reason - reasonType:', reasonType, 'customReason:', customReason);
                if (!reasonType) {
                    if (showErrors) {
                        dateTimeErrors.push('Purpose/Reason is required');
                    }
                    isValid = false;
                    console.log('Reason validation failed: no reason type selected');
                } else if (reasonType === 'Other' && !customReason) {
                    if (showErrors) {
                        dateTimeErrors.push('Please specify the custom reason');
                    }
                    isValid = false;
                    console.log('Reason validation failed: custom reason required');
                } else {
                    console.log('Reason validation passed');
                }

                // Validate equipment
                if (!hasEquipment) {
                    if (showErrors) {
                        dateTimeErrors.push('Please select at least one equipment item');
                    }
                    isValid = false;
                }

                submitBtn.disabled = !isValid;
                return isValid;
            }

            // Clear date/time errors
            function clearDateTimeErrors() {
                const errorCard = document.getElementById('dateTimeErrorCard');
                const errorList = document.getElementById('dateTimeErrorList');
                errorCard.classList.add('hidden');
                errorList.innerHTML = '';
            }

            // Show date/time errors
            function showDateTimeErrors(errors) {
                console.log('showDateTimeErrors called with:', errors);
                const errorCard = document.getElementById('dateTimeErrorCard');
                const errorList = document.getElementById('dateTimeErrorList');
                
                console.log('errorCard:', errorCard, 'errorList:', errorList);
                
                if (!errorCard || !errorList) {
                    console.error('Error card elements not found!');
                    return;
                }
                
                errorList.innerHTML = '';
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
                
                errorCard.classList.remove('hidden');
                console.log('Error card should now be visible');
            }

            // Add event listeners for validation
            // Silent validation on field change (do not show error card)
            ['borrow_date', 'return_date', 'reason_type'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('change', function(){ validateForm(false); });
            });
            
            // Add event listeners for time selectors
            // Activate real-time validation only after interaction with the time fields
            ['borrow_hour', 'borrow_minute', 'borrow_period', 'return_hour', 'return_minute', 'return_period'].forEach(id => {
                const el = document.getElementById(id);
                if(!el) return;
                el.addEventListener('change', function(){
                    // When any selector changes, compose hidden HH:MM 24h values
                    function to24(h,period){ let x=parseInt(h||'0',10)%12; if(period==='PM') x+=12; return String(x).padStart(2,'0'); }
                    const bh=document.getElementById('borrow_hour').value, bm=document.getElementById('borrow_minute').value, bp=document.getElementById('borrow_period').value;
                    if (bh && bm && bp) document.getElementById('borrow_time').value = `${to24(bh,bp)}:${bm}`;
                    const rh=document.getElementById('return_hour').value, rm=document.getElementById('return_minute').value, rp=document.getElementById('return_period').value;
                    if (rh && rm && rp) document.getElementById('return_time').value = `${to24(rh,rp)}:${rm}`;
                    // Silent validation; only show errors on submit
                    validateForm(false);
                }, { once:false });
            });
            
            // Add event listener for custom reason input
            customReasonInput.addEventListener('input', validateForm);

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Always prevent default submission
                
                // Validate form and show errors if needed
                if (!validateForm(true)) {
                    // Show error card with validation errors
                    console.log('Form validation failed');
                    return false;
                }

                // Debug: Log form data before submission
                console.log('Form validation passed, proceeding with submission');
                console.log('Reason type:', document.getElementById('reason_type').value);
                console.log('Custom reason:', document.getElementById('custom_reason').value);
                
                // Update reservation data first
                updateReservationData();
                
                // Validate that reservation data is not empty
                if (!reservationDataInput.value || reservationDataInput.value === '[]') {
                    alert('Please select at least one equipment item.');
                    return false;
                }
                
                // Show confirmation modal (this will handle duplicate checking)
                showReservationConfirmationModal();
            });


            // Submit reservation
            function submitReservation() {
                // Show loading modal
                Swal.fire({
                    title: 'Submitting Reservation...',
                    text: 'Please wait while we process your reservation request.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit the form via AJAX to handle validation errors properly
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        // Show success modal
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Reservation Submitted Successfully!</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">Your reservation has been submitted successfully!</p>
                                    <p class="text-gray-600 text-sm mt-2">${data.message || 'Your reservation is pending approval.'}</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="window.location.href='<?php echo e(route('instructor.reservations')); ?>'">
                                        View My Reservations
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
                        // Handle duplicate detected from server gracefully
                        if (data.error_type === 'duplicate_detected') {
                            showDuplicateConfirmationModal(data.message || 'You already have a similar reservation with the same equipment, dates, times, and reason.');
                            return;
                        }
                        // Other errors
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'An error occurred while submitting your reservation.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Submission error:', error);
                    // If the server sent a duplicate_detected error, route to orange modal
                    if (error && error.error_type === 'duplicate_detected') {
                        showDuplicateConfirmationModal(error.message || 'You already have a similar reservation with the same equipment, dates, times, and reason.');
                        return;
                    }
                    if (error.errors) {
                        // Handle validation errors
                        showServerValidationErrors(error.errors);
                    } else {
                        // Handle other errors
                        Swal.fire({
                            title: 'Error',
                            text: error.message || 'An error occurred while submitting your reservation.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

            // Initialize custom reason field if "Other" is selected
            if (reasonTypeSelect.value === 'Other') {
                customReasonDiv.classList.remove('hidden');
                customReasonInput.required = true;
            }

            // Ensure error card is hidden on page load
            clearDateTimeErrors();
            
            // Don't run initial validation to avoid showing errors on page load
            // validateForm(); // Removed to prevent showing errors on page load

            // Check for success message and show modal
            <?php if(session('success')): ?>
                // Show success modal
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Reservation Submitted Successfully!</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700"><?php echo e(session('success')); ?></p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="window.location.href='<?php echo e(route('instructor.reservations')); ?>'">
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
            <?php endif; ?>

            // Check for error message and show modal
            <?php if(session('error')): ?>
                // Show error modal
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-orange-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Duplicate Reservation Detected</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg font-medium"><?php echo e(session('error')); ?></p>
                            <p class="text-gray-600 text-sm mt-2">Do you want to proceed with this duplicate reservation?</p>
                        </div>
                        <div class="flex justify-center space-x-4 mt-6">
                            <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                                Cancel
                            </button>
                            <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" onclick="proceedWithDuplicateReservation()">
                                Proceed
                            </button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            <?php endif; ?>

            // Proceed with regular reservation
            function proceedWithReservation() {
                // Close the confirmation modal
                Swal.close();
                
                // Submit the form
                submitReservation();
            }

            // Proceed with duplicate reservation
            function proceedWithDuplicateReservation() {
                // Close the confirmation modal
                Swal.close();
                
                // Add a hidden input to indicate we're proceeding with duplicate
                const form = document.getElementById('reservationForm');
                if (form) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'proceed_with_duplicate';
                    hiddenInput.value = '1';
                    form.appendChild(hiddenInput);
                    
                    // Submit the form
                    submitReservation();
                }
            }

            // Show server validation errors in the error card
            function showServerValidationErrors(errors) {
                const errorCard = document.getElementById('dateTimeErrorCard');
                const errorList = document.getElementById('dateTimeErrorList');
                
                if (!errorCard || !errorList) return;
                
                // Clear previous errors
                errorList.innerHTML = '';
                
                // Add server validation errors
                Object.keys(errors).forEach(field => {
                    errors[field].forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorList.appendChild(li);
                    });
                });
                
                // Show the error card
                errorCard.classList.remove('hidden');
            }

            // Make functions globally accessible for onclick handlers
            window.proceedWithReservation = proceedWithReservation;
            window.proceedWithDuplicateReservation = proceedWithDuplicateReservation;
        });

        // Show reservation confirmation modal with duplicate checking
        function showReservationConfirmationModal() {
            // Show loading modal first
            Swal.fire({
                title: 'Checking for duplicates...',
                text: 'Please wait while we verify your reservation.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Check for duplicates (fetch fresh form element here to avoid scope issues)
            const formEl = document.getElementById('reservationForm');

            // Compose hidden time fields from the dropdowns to ensure backend receives them
            const bHour = document.getElementById('borrow_hour')?.value;
            const bMin = document.getElementById('borrow_minute')?.value;
            const bPer = document.getElementById('borrow_period')?.value;
            const rHour = document.getElementById('return_hour')?.value;
            const rMin = document.getElementById('return_minute')?.value;
            const rPer = document.getElementById('return_period')?.value;

            function to24h(hourStr, minuteStr, period){
                if (!hourStr || !minuteStr || !period) return null;
                let h = parseInt(hourStr, 10);
                if (period === 'PM' && h !== 12) h += 12;
                if (period === 'AM' && h === 12) h = 0;
                return `${String(h).padStart(2,'0')}:${String(minuteStr).padStart(2,'0')}`;
            }

            const borrowTimeHidden = document.getElementById('borrow_time');
            const returnTimeHidden = document.getElementById('return_time');
            if (borrowTimeHidden && bHour && bMin && bPer) {
                const bVal = to24h(bHour, bMin, bPer);
                if (bVal) borrowTimeHidden.value = bVal;
            }
            if (returnTimeHidden && rHour && rMin && rPer) {
                const rVal = to24h(rHour, rMin, rPer);
                if (rVal) returnTimeHidden.value = rVal;
            }

            // Refresh cart_data to latest selection
            (function refreshCartData(){
                const selectedItems = [];
                document.querySelectorAll('.equipment-checkbox').forEach(cb => {
                    if (cb.checked) {
                        const qtyInput = cb.closest('.equipment-card')?.querySelector('.quantity-input');
                        const quantity = parseInt(qtyInput?.value || '1', 10) || 1;
                        selectedItems.push({ equipment_id: cb.value, quantity });
                    }
                });
                const reservationDataInput = document.getElementById('cart_data');
                if (reservationDataInput) {
                    reservationDataInput.value = JSON.stringify(selectedItems);
                }
            })();

            // Build FormData after composing hidden fields
            const formData = new FormData(formEl);
            // Ensure required fields for duplicate check are present
            formData.set('email', '<?php echo e(auth()->user()->email); ?>');
            // Reason fields (ensure latest)
            const reasonTypeVal = document.getElementById('reason_type')?.value || '';
            const customReasonVal = document.getElementById('custom_reason')?.value || '';
            formData.set('reason_type', reasonTypeVal);
            formData.set('custom_reason', customReasonVal);

            console.log('Checking for duplicates with form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            fetch('<?php echo e(route('instructor.reservations.check-duplicate')); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Duplicate check response:', data);
                Swal.close();
                if (data.is_duplicate) {
                    showDuplicateConfirmationModal(data.message);
                } else {
                    showNormalConfirmationModal();
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error checking for duplicates:', error);
                // If the check fails, default to normal confirmation (non-blocking)
                showNormalConfirmationModal();
            });
        }

        // Show normal confirmation modal
        function showNormalConfirmationModal() {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-blue-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Confirm Reservation</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700 text-lg font-medium">Are you ready to submit your reservation?</p>
                        <p class="text-gray-600 text-sm mt-2">Please review your reservation details before proceeding.</p>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors transform hover:scale-105" onclick="proceedWithReservation()">
                            Submit Reservation
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

        // Show duplicate confirmation modal
        function showDuplicateConfirmationModal(message) {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-orange-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Duplicate Reservation Detected</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700 text-lg font-medium">You already have a similar reservation</p>
                        <p class="text-gray-600 text-sm mt-2">${message}</p>
                        <p class="text-gray-600 text-sm mt-1">Do you want to proceed anyway?</p>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" onclick="proceedWithDuplicateReservation()">
                            Proceed
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
<?php /**PATH C:\UB-SEMS\resources\views\instructor\reservations\create.blade.php ENDPATH**/ ?>