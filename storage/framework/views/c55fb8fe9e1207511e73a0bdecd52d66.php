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
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            <?php echo e(__('Equipment Type Details')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment Types', 'url' => route('equipment-types.index')],
                ['label' => $equipmentType->name]
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment Types', 'url' => route('equipment-types.index')],
                ['label' => $equipmentType->name]
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
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900 mb-2"><?php echo e($equipmentType->name); ?></h3>
                        <p class="text-blue-700 font-medium"><?php echo e($equipmentType->description ?? 'No description provided'); ?></p>
                    </div>
                    <div class="flex space-x-3">
                        <?php if (isset($component)) { $__componentOriginalbb660c7d3380b22758129b879204cbaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb660c7d3380b22758129b879204cbaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['variant' => 'primary','size' => 'md','href' => ''.e(route('equipment-types.edit', $equipmentType)).'','icon' => 'fas fa-edit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','size' => 'md','href' => ''.e(route('equipment-types.edit', $equipmentType)).'','icon' => 'fas fa-edit']); ?>
                            Edit Equipment Type
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['variant' => 'secondary','size' => 'md','href' => ''.e(route('equipment-types.index')).'','icon' => 'fas fa-arrow-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'secondary','size' => 'md','href' => ''.e(route('equipment-types.index')).'','icon' => 'fas fa-arrow-left']); ?>
                            Back to List
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
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Basic Information -->
                        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                            <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                <i class="fas fa-info-circle mr-3 text-blue-600"></i>
                                Basic Information
                            </h4>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Equipment Type Name</label>
                                    <p class="text-xl font-bold text-gray-900 bg-white p-4 rounded-lg border shadow-sm"><?php echo e($equipmentType->name); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-base font-bold bg-red-100 text-red-800 border shadow-sm">
                                        <i class="fas fa-tag mr-2"></i>
                                        <?php echo e($equipmentType->category->name); ?>

                                    </span>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                    <p class="text-base font-medium text-gray-900 bg-white p-4 rounded-lg border shadow-sm min-h-[60px]"><?php echo e($equipmentType->description ?: 'No description provided'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                            <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                <i class="fas fa-chart-bar mr-3 text-blue-600"></i>
                                Statistics
                            </h4>
                            
                            <div class="space-y-6">
                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Equipment</label>
                                    <p class="text-4xl font-bold text-blue-600"><?php echo e(optional($equipmentType->equipment)->count() ?? 0); ?></p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">equipment items</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Available Equipment</label>
                                    <p class="text-4xl font-bold text-green-600"><?php echo e(optional($equipmentType->equipment)->where('is_active', true)->count() ?? 0); ?></p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">active items</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Total Reservations</label>
                                    <p class="text-4xl font-bold text-purple-600"><?php echo e(optional($equipmentType->equipment)->sum(function($equipment) { return optional($equipment->reservations)->count() ?? 0; }) ?? 0); ?></p>
                                    <p class="text-sm font-medium text-gray-500 mt-1">reservations</p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Created</label>
                                    <p class="text-base font-bold text-gray-900"><?php echo e($equipmentType->created_at->format('M d, Y \a\t g:i A')); ?></p>
                                </div>

                                <div class="bg-white p-6 rounded-lg border shadow-sm">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Last Updated</label>
                                    <p class="text-base font-bold text-gray-900"><?php echo e($equipmentType->updated_at->format('M d, Y \a\t g:i A')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment List -->
                    <?php if(optional($equipmentType->equipment)->count() > 0): ?>
                        <div class="mt-8">
                            <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                                <h4 class="text-xl font-bold text-blue-900 mb-6 flex items-center">
                                    <i class="fas fa-list mr-3 text-blue-600"></i>
                                    Associated Equipment
                                </h4>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 bg-white rounded-lg shadow-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Name</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Brand</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Model</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php $__currentLoopData = optional($equipmentType->equipment); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-base font-bold text-gray-900"><?php echo e($equipment->name); ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900"><?php echo e($equipment->brand ?: 'N/A'); ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900"><?php echo e($equipment->model ?: 'N/A'); ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold <?php echo e($equipment->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                            <i class="fas <?php echo e($equipment->is_active ? 'fa-check-circle' : 'fa-times-circle'); ?> mr-1"></i>
                                                            <?php echo e($equipment->is_active ? 'Active' : 'Inactive'); ?>

                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="<?php echo e(route('equipment-management.show', $equipment)); ?>" class="text-blue-600 hover:text-blue-900 font-bold">
                                                            <i class="fas fa-eye mr-1"></i>View
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mt-8">
                            <div class="bg-blue-50/60 p-6 rounded-xl border border-blue-100">
                                <div class="text-center py-8">
                                    <i class="fas fa-inbox text-6xl text-blue-400 mb-4"></i>
                                    <h4 class="text-xl font-bold text-blue-900 mb-2">No Equipment Found</h4>
                                    <p class="text-blue-700 font-medium">This equipment type doesn't have any associated equipment yet.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show success modal if there's a success message
            <?php if(session('success')): ?>
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                            <h2 class="text-xl font-bold">Success!</h2>
                        </div>
                        <div class="flex items-center justify-center mb-4">
                            <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-center text-gray-700"><?php echo e(session('success')); ?></p>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition-all transform hover:scale-105" onclick="Swal.close()">
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
<?php /**PATH C:\UB-SEMS\resources\views\admin-manager\equipment-types\show.blade.php ENDPATH**/ ?>