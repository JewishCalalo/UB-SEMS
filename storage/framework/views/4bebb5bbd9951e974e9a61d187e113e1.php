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
            <?php echo e(__('Edit Maintenance Record')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

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
                                <span class="text-gray-900"><?php echo e($equipment->name); ?></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Category:</span>
                                <span class="text-gray-900"><?php echo e($equipment->category->name); ?></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Model:</span>
                                <span class="text-gray-900"><?php echo e($equipment->model ?: 'N/A'); ?></span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Serial Number:</span>
                                <span class="text-gray-900"><?php echo e($equipment->serial_number ?: 'N/A'); ?></span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="<?php echo e(route('maintenance-management.update-record', $maintenanceRecord)); ?>" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="maintenance_type" class="block text-sm font-medium text-gray-700">Maintenance Type *</label>
                                <select name="maintenance_type" id="maintenance_type" required 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                    <option value="">Select maintenance type</option>
                                    <option value="routine" <?php echo e(old('maintenance_type', $maintenanceRecord->maintenance_type) == 'routine' ? 'selected' : ''); ?>>Routine Maintenance</option>
                                    <option value="repair" <?php echo e(old('maintenance_type', $maintenanceRecord->maintenance_type) == 'repair' ? 'selected' : ''); ?>>Repair</option>
                                    <option value="inspection" <?php echo e(old('maintenance_type', $maintenanceRecord->maintenance_type) == 'inspection' ? 'selected' : ''); ?>>Inspection</option>
                                </select>
                                <?php $__errorArgs = ['maintenance_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div>
                                <label for="performed_date" class="block text-sm font-medium text-gray-700">Performed Date *</label>
                                <input type="date" name="performed_date" id="performed_date" required 
                                       value="<?php echo e(old('performed_date', $maintenanceRecord->maintenance_date ? $maintenanceRecord->maintenance_date->format('Y-m-d') : '')); ?>"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                <?php $__errorArgs = ['performed_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                            <textarea name="description" id="description" rows="4" required 
                                      placeholder="Describe the maintenance work performed..."
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"><?php echo e(old('description', $maintenanceRecord->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="performed_by" class="block text-sm font-medium text-gray-700">Performed By *</label>
                                <input type="text" name="performed_by" id="performed_by" required 
                                       value="<?php echo e(old('performed_by', $maintenanceRecord->performed_by)); ?>"
                                       placeholder="Technician name"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                <?php $__errorArgs = ['performed_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div>
                                <label for="cost" class="block text-sm font-medium text-gray-700">Cost (₱)</label>
                                <input type="number" name="cost" id="cost" step="0.01" min="0"
                                       value="<?php echo e(old('cost', $maintenanceRecord->cost)); ?>"
                                       placeholder="0.00"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                                <?php $__errorArgs = ['cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        

                        
                        <div>
                            <label for="parts_used" class="block text-sm font-medium text-gray-700">Parts Used</label>
                            <input type="text" name="parts_used" id="parts_used"
                                   value="<?php echo e(old('parts_used', $maintenanceRecord->parts_used)); ?>"
                                   placeholder="List any parts replaced or used"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            <?php $__errorArgs = ['parts_used'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div>
                            <label for="technician_contact" class="block text-sm font-medium text-gray-700">Technician Contact</label>
                            <input type="text" name="technician_contact" id="technician_contact"
                                   value="<?php echo e(old('technician_contact', $maintenanceRecord->technician_contact)); ?>"
                                   placeholder="Phone number or email"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            <?php $__errorArgs = ['technician_contact'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      placeholder="Any additional information or observations..."
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"><?php echo e(old('notes', $maintenanceRecord->notes)); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="<?php echo e(route('maintenance-management.show', $equipment)); ?>" 
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
<?php /**PATH C:\UB-SEMS\resources\views\admin-manager\maintenance-management\edit-record.blade.php ENDPATH**/ ?>