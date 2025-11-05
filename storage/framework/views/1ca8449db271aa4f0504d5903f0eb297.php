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
            <?php echo e(__('Add Maintenance Record')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-stone-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Maintenance Management', 'url' => route('maintenance-management.index')],
                ['label' => 'Create Record']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Maintenance Management', 'url' => route('maintenance-management.index')],
                ['label' => 'Create Record']
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
            
            <!-- Back Button -->
            <div class="mb-6">
                <a href="<?php echo e(route('maintenance-management.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Maintenance Management
                </a>
            </div>

            <!-- Header Section -->
            <div class="bg-white border border-gray-200 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Create Maintenance Record</h3>
                        <p class="text-sm text-gray-600">Record maintenance activities for equipment instances</p>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-500">Equipment</div>
                        <div class="text-base font-medium text-gray-900"><?php echo e($equipment->display_name); ?></div>
                        <div class="text-xs text-gray-600"><?php echo e($equipment->category->name); ?></div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-200">
                <div class="p-8">
                    <!-- Equipment Info Card -->
                    <div class="mb-8 p-6 bg-emerald-50/60 rounded-xl border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-3">Equipment Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-500 uppercase text-xs tracking-wide">Equipment Name</span>
                                        <span class="text-gray-900 font-semibold"><?php echo e($equipment->display_name); ?></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-500 uppercase text-xs tracking-wide">Category</span>
                                        <span class="text-gray-900 font-semibold"><?php echo e($equipment->category->name); ?></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-500 uppercase text-xs tracking-wide">Brand</span>
                                        <span class="text-gray-900 font-semibold"><?php echo e($equipment->brand ?: 'Not specified'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="<?php echo e(route('maintenance-management.store-record', $equipment)); ?>" class="space-y-6" id="maintenanceForm" novalidate>
                        <?php echo csrf_field(); ?>
                        
                        <?php if($errors->any()): ?>
                            <?php
                                $messages = [];
                                foreach($errors->getMessages() as $key => $errs){
                                    if(\Illuminate\Support\Str::contains($key, 'maintenance_type')){
                                        $messages['maintenance_type'] = 'Please select a maintenance type.';
                                    } elseif(\Illuminate\Support\Str::contains($key, 'performed_at')){
                                        $messages['performed_at'] = 'Please enter the maintenance date.';
                                    } elseif(\Illuminate\Support\Str::contains($key, 'instances') && \Illuminate\Support\Str::contains($errs[0] ?? '', 'selected')){
                                        $messages['instances'] = 'Please select at least one equipment instance.';
                                    } else {
                                        $messages[] = $errs[0];
                                    }
                                }
                            ?>
                            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-bold text-red-800">Please review the form:</h4>
                                        <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1 font-semibold">
                                            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($m); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Maintenance Details Section -->
                        <div class="bg-emerald-50/60 p-6 rounded-xl border border-green-100 mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Maintenance Details</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="maintenance_type" class="block text-sm font-medium text-gray-700 mb-2">Maintenance Type *</label>
                                    <select name="maintenance_type" id="maintenance_type" required 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                                        <option value="">Select maintenance type</option>
                                        <option value="routine" <?php echo e(old('maintenance_type') == 'routine' ? 'selected' : ''); ?>>Routine Maintenance</option>
                                        <option value="repair" <?php echo e(old('maintenance_type') == 'repair' ? 'selected' : ''); ?>>Repair</option>
                                        <option value="inspection" <?php echo e(old('maintenance_type') == 'inspection' ? 'selected' : ''); ?>>Inspection</option>
                                        <option value="other" <?php echo e(old('maintenance_type') == 'other' ? 'selected' : ''); ?>>Other</option>
                                    </select>
                                    <?php $__errorArgs = ['maintenance_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            <?php echo e($message); ?>

                                        </p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div id="maintenance_type_other_wrapper" class="mt-3 <?php echo e(old('maintenance_type') === 'other' ? '' : 'hidden'); ?>">
                                        <label for="maintenance_type_other" class="block text-sm font-medium text-gray-700 mb-2">Specify Other Type *</label>
                                        <input type="text" name="maintenance_type_other" id="maintenance_type_other" value="<?php echo e(old('maintenance_type_other')); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="e.g., Deep Cleaning, Firmware Update">
                                        <?php $__errorArgs = ['maintenance_type_other'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i>
                                                <?php echo e($message); ?>

                                            </p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div>
                                    <label for="performed_date" class="block text-sm font-medium text-gray-700 mb-2">Performed Date *</label>
                                    <input type="date" name="performed_date" id="performed_date" required 
                                           value="<?php echo e(old('performed_date', now('Asia/Manila')->toDateString())); ?>"
                                           max="<?php echo e(now('Asia/Manila')->toDateString()); ?>"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <?php $__errorArgs = ['performed_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            <?php echo e($message); ?>

                                        </p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="4" 
                                          placeholder="Describe the maintenance work performed in detail..."
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                        </div>
                        
                        <!-- Removed next maintenance, interval, and parts used per request -->
                        
                        
                        <!-- Instances selection table -->
                        <div class="bg-emerald-50/60 p-6 rounded-xl border border-green-100 mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Select Equipment Instances to Update</h4>
                            <p class="text-sm text-gray-600 mb-4">Choose which equipment instances were affected by this maintenance and update their condition.</p>
                            <div class="overflow-x-auto rounded-xl shadow-sm border border-gray-200 bg-white">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-green-600 text-white">
                                        <tr>
                                            <th class="px-6 py-4 text-left">
                                                <input type="checkbox" id="selectAllInstances" class="rounded border-gray-300 text-green-600 focus:ring-green-500 bg-white">
                                                <label for="selectAllInstances" class="ml-2 text-sm font-medium text-white">Select All</label>
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Instance Code</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Current Condition</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">New Condition</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php $__currentLoopData = $equipment->instances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inst): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-green-50/30 transition-colors duration-150">
                                                <td class="px-6 py-4">
                                                    <input type="checkbox" name="instances[<?php echo e($inst->id); ?>][id]" value="<?php echo e($inst->id); ?>" class="instance-checkbox rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm font-semibold text-gray-900"><?php echo e($inst->instance_code); ?></div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full <?php echo e($inst->condition === 'excellent' ? 'bg-green-100 text-green-800' : ($inst->condition === 'good' ? 'bg-blue-100 text-blue-800' : ($inst->condition === 'fair' ? 'bg-yellow-100 text-yellow-800' : ($inst->condition === 'needs_repair' ? 'bg-orange-100 text-orange-800' : ($inst->condition === 'damaged' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))))); ?>"><?php echo e(ucfirst(str_replace('_',' ', $inst->condition))); ?></span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <select name="instances[<?php echo e($inst->id); ?>][condition]" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white">
                                                        <option value="excellent">Excellent</option>
                                                        <option value="good">Good</option>
                                                        <option value="fair">Fair</option>
                                                        <option value="needs_repair">Needs Repair</option>
                                                        <option value="damaged">Damaged</option>
                                                        <option value="lost">Lost</option>
                                                        <option value="retired">Retired</option>
                                                    </select>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" name="instances[<?php echo e($inst->id); ?>][notes]" placeholder="Optional notes for this instance..." class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm text-gray-700">Select the equipment instances that were serviced during this maintenance activity and update their condition based on the work performed.</p>
                            </div>
                        </div>
                        
                        <!-- Additional Notes Section -->
                        <div class="bg-white p-6 rounded-xl border border-gray-200 mb-8">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Additional Notes</h4>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">General Observations & Comments</label>
                            <textarea name="notes" id="notes" rows="4"
                                      placeholder="Record any additional observations, recommendations, or important details about this maintenance..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"><?php echo e(old('notes')); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Submit Section -->
                        <div class="flex justify-between items-center pt-8 border-t border-gray-200">
                            <div class="text-sm text-gray-600"><span class="text-red-500 font-semibold">*</span> Required fields</div>
                            <div class="flex space-x-3">
                                <?php if (isset($component)) { $__componentOriginalbb660c7d3380b22758129b879204cbaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb660c7d3380b22758129b879204cbaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['variant' => 'secondary','size' => 'md','type' => 'button','onclick' => 'window.history.back()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'secondary','size' => 'md','type' => 'button','onclick' => 'window.history.back()']); ?>
                                    <i class="fas fa-times mr-2"></i>Cancel
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $attributes = $__attributesOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__attributesOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $component = $__componentOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__componentOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginalbb660c7d3380b22758129b879204cbaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb660c7d3380b22758129b879204cbaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['variant' => 'success','size' => 'md','type' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'success','size' => 'md','type' => 'submit']); ?>
                                    <i class="fas fa-plus mr-2"></i>Create Maintenance Record
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $attributes = $__attributesOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__attributesOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $component = $__componentOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__componentOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const selectAll = document.getElementById('selectAllInstances');
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.instance-checkbox').forEach(cb => cb.checked = selectAll.checked);
            });
        }

        // Form submission handler
        document.getElementById('maintenanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get all checked instances
            const checkedInstances = document.querySelectorAll('.instance-checkbox:checked');
            
            if (checkedInstances.length === 0) {
                Swal.fire({
                    title: 'No Instances Selected',
                    text: 'Please select at least one instance to update.',
                    icon: 'warning',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
                return;
            }
            
            // Show loading state
            Swal.fire({
                title: 'Creating Maintenance Record...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Create a new form data object
            const formData = new FormData(this);
            
            // Remove all instance data first
            const entries = Array.from(formData.entries());
            entries.forEach(([key]) => {
                if (key.startsWith('instances[')) {
                    formData.delete(key);
                }
            });
            
            // Add only checked instances
            checkedInstances.forEach(checkbox => {
                const instanceId = checkbox.value;
                const condition = document.querySelector(`select[name="instances[${instanceId}][condition]"]`).value;
                const notes = document.querySelector(`input[name="instances[${instanceId}][notes]"]`).value;
                
                formData.append(`instances[${instanceId}][id]`, instanceId);
                formData.append(`instances[${instanceId}][condition]`, condition);
                if (notes) {
                    formData.append(`instances[${instanceId}][notes]`, notes);
                }
            });
            
            // Submit the form
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: false,
                        showConfirmButton: true,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Continue',
                        html: `
                            <div class="bg-gradient-to-r from-emerald-600 to-green-700 text-white p-6 -m-6 mb-4 rounded-t-lg">
                                <h2 class="text-xl font-bold text-center">Maintenance Record Created</h2>
                            </div>
                            <div class="text-center text-gray-700">
                                Maintenance record created successfully.
                            </div>
                        `
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Failed to create maintenance record.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while creating the maintenance record.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
    <script>
        // Toggle Other maintenance type field
        (function(){
            const select = document.getElementById('maintenance_type');
            const wrapper = document.getElementById('maintenance_type_other_wrapper');
            const input = document.getElementById('maintenance_type_other');
            if (!select || !wrapper) return;
            function sync(){
                const isOther = select.value === 'other';
                wrapper.classList.toggle('hidden', !isOther);
                if (isOther) {
                    input && input.setAttribute('required', 'required');
                } else {
                    input && input.removeAttribute('required');
                }
            }
            select.addEventListener('change', sync);
            sync();
        })();
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
<?php /**PATH C:\UB-SEMS\resources\views\admin-manager\maintenance-management\create-record.blade.php ENDPATH**/ ?>