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
            <?php echo e(__('Equipment Management')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment']
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                         <!-- Header with Create Button and Quick Actions -->
             <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                 <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                     <div>
                         <h3 class="text-xl font-bold text-gray-900 mb-2">Manage Equipment</h3>
                         <p class="text-gray-600">Add, edit, and manage your equipment inventory</p>
                     </div>
                     <div class="flex flex-col sm:flex-row gap-3">
                         <a href="<?php echo e(route('equipment-management.wishlisted')); ?>" 
                            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 flex items-center justify-center" style="background-color: #9333ea !important; color: white !important;">
                             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                             </svg>
                             Wishlisted Items
                         </a>
                         <?php if (isset($component)) { $__componentOriginalbb660c7d3380b22758129b879204cbaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb660c7d3380b22758129b879204cbaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['variant' => 'primary','size' => 'md','href' => ''.e(route('equipment-management.create')).'','icon' => 'fas fa-plus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'primary','size' => 'md','href' => ''.e(route('equipment-management.create')).'','icon' => 'fas fa-plus']); ?>
                             Add Equipment
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

                     <!-- Search and Filter Toggle Section -->
                     <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-4">
                         <div class="flex justify-between items-center">
                             <h4 class="text-lg font-semibold text-gray-900">Search & Filter</h4>
                            <button id="sfToggleBtn" type="button" onclick="toggleSearchFilter()" 
                                    style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out; display: flex; align-items: center; gap: 8px;"
                                     onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                                     onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                                 <span id="toggleText">Show</span>
                                 <svg id="toggleIcon" style="width: 20px; height: 20px; transition: transform 0.2s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                 </svg>
                             </button>
                         </div>
                     </div>

                     <!-- Search and Filters Content -->
                     <div id="searchFilterContent" class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6" style="display: none;">
                         <div class="p-6">
                            <form id="eqFilterForm" method="GET" action="<?php echo e(route('equipment-management.index')); ?>" class="space-y-6">
                                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Search</label>
                                         <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                                placeholder="Name, brand, or model..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Category</label>
                                         <select name="category" id="filter_category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Categories</option>
                                             <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                                     <?php echo e($category->name); ?>

                                                 </option>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                         </select>
                                     </div>
                                     
                                     <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Equipment Type</label>
                                        <select name="equipment_type" id="filter_equipment_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                            <option value="">All Types</option>
                                        </select>
                                        
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Status</label>
                                         <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Status</option>
                                             <option value="available" <?php echo e(request('status') === 'available' ? 'selected' : ''); ?>>Available</option>
                                             <option value="unavailable" <?php echo e(request('status') === 'unavailable' ? 'selected' : ''); ?>>Unavailable</option>
                                         </select>
                                     </div>
                                     
                                    <div class="md:col-span-2 lg:col-span-1 space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Actions</label>
                                        <div class="flex space-x-2">
                                            <button type="submit"
                                                    class="px-4 py-3 rounded-lg text-white flex-1 transition-transform duration-150"
                                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.12)';"
                                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                                                    style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                                Search
                                            </button>
                                            <button type="button" id="eqClearBtn"
                                                    class="px-4 py-3 rounded-lg text-white flex-1 transition-transform duration-150"
                                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.12)';"
                                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                                                    style="background: linear-gradient(135deg, #64748b 0%, #334155 100%);">
                                                Clear
                                            </button>
                                        </div>
                                    </div>
                                 </div>
                             </form>
                         </div>
                     </div>
                     

                                                                                             <!-- Action Legend and Generate Report Button -->
                      <div class="flex items-center justify-between mb-4">
                          <!-- Generate Report Button -->
                          <div>
                              <button onclick="openReportModal()" 
                                      style="background: linear-gradient(to right, #8b5cf6, #ec4899); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; transition: all 0.2s; display: inline-flex; align-items: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: none; cursor: pointer;"
                                      onmouseover="this.style.background='linear-gradient(to right, #7c3aed, #db2777)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(0, 0, 0, 0.2)'"
                                      onmouseout="this.style.background='linear-gradient(to right, #8b5cf6, #ec4899)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'"
                                      title="Generate Equipment Report">
                                  <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                  </svg>
                                  Generate Report
                              </button>
                          </div>
                          
                      </div>

                     <!-- Action Legend -->
                     <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                         <div class="flex justify-between items-center mb-3">
                             <h4 class="text-sm font-medium text-gray-700">Action Legend</h4>
                             <button type="button" onclick="toggleActionLegend()" 
                                     class="text-sm text-gray-600 hover:text-gray-800 flex items-center space-x-1 transition-colors">
                                 <span id="actionLegendToggleText">Hide</span>
                                 <svg id="actionLegendToggleIcon" class="w-4 h-4 transform rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                 </svg>
                             </button>
                         </div>
                        <div id="actionLegendContent" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="flex flex-col items-center text-center" title="View details of the equipment, including specs, images, and history.">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm mb-1" style="background: linear-gradient(to right, #3b82f6, #2563eb);" aria-label="View Details">
                                     <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                     </svg>
                                 </div>
                                <span class="text-sm text-gray-700">View Details</span>
                                <p class="text-xs text-gray-500">Opens the equipment information page.</p>
                             </div>
                            <div class="flex flex-col items-center text-center" title="Edit equipment information, images, and settings.">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm mb-1" style="background: linear-gradient(to right, #eab308, #ca8a04);" aria-label="Edit Equipment">
                                     <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                     </svg>
                                 </div>
                                 <span class="text-sm text-gray-700">Edit Equipment</span>
                                 <p class="text-xs text-gray-500">Modify equipment information and settings.</p>
                             </div>
                            <div class="flex flex-col items-center text-center" title="Open maintenance actions to add records or mark items under maintenance.">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm mb-1" style="background: linear-gradient(to right, #10b981, #059669);" aria-label="Maintenance">
                                     <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                     </svg>
                                 </div>
                             <span class="text-sm text-gray-700">Maintenance</span>
                             <p class="text-xs text-gray-500">Add maintenance record or set under maintenance.</p>
                             </div>
                            <div class="flex flex-col items-center text-center" title="Add a new physical instance of this equipment to inventory.">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm mb-1" style="background: linear-gradient(to right, #8b5cf6, #7c3aed);" aria-label="Add Instance">
                                     <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                     </svg>
                                 </div>
                                 <span class="text-sm text-gray-700">Add Instance</span>
                                 <p class="text-xs text-gray-500">Add new Instances for this Equipment</p>
                             </div>
                         </div>
                     </div>


                           <!-- Equipment Table -->
                           <div class="bg-white border border-gray-200 rounded-lg shadow-sm" id="equipmentTableWrapper">
                 <div class="p-6">
                      <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                          <i class="fas fa-table mr-2 text-gray-600"></i>
                          Equipment Inventory
                      </h4>
                     <?php if($equipment->count() > 0): ?>
                         <?php if (isset($component)) { $__componentOriginala8c8be3548067f73036f4ed77d30e639 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8c8be3548067f73036f4ed77d30e639 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-toolbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8c8be3548067f73036f4ed77d30e639)): ?>
<?php $attributes = $__attributesOriginala8c8be3548067f73036f4ed77d30e639; ?>
<?php unset($__attributesOriginala8c8be3548067f73036f4ed77d30e639); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8c8be3548067f73036f4ed77d30e639)): ?>
<?php $component = $__componentOriginala8c8be3548067f73036f4ed77d30e639; ?>
<?php unset($__componentOriginala8c8be3548067f73036f4ed77d30e639); ?>
<?php endif; ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category & Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Model</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Availability</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $equipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <?php
                                                        $hasImages = false;
                                                        $firstImage = null;
                                                        try {
                                                            if ($item && is_object($item) && isset($item->images) && is_object($item->images) && method_exists($item->images, 'count') && $item->images->count() > 0) {
                                                                $hasImages = true;
                                                                $firstImage = $item->images->first();
                                                            }
                                                        } catch (Exception $e) {
                                                            $hasImages = false;
                                                        }
                                                    ?>
                                                    <?php if($hasImages && $firstImage): ?>
                                                        <img class="h-10 w-10 rounded-lg object-cover mr-3" 
                                                             src="<?php echo e($firstImage->url); ?>" 
                                                             alt="<?php echo e($item->name); ?>"
                                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                             onload="this.style.display='block';">
                                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3" style="display: none;">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <?php
                                                            $itemName = 'Unknown Equipment';
                                                            $itemBrand = 'No brand';
                                                            $itemModel = 'No model';
                                                            try {
                                                                if ($item && is_object($item)) {
                                                                    $itemName = $item->name ?? null;
                                                                    $itemBrand = $item->brand ?? 'No brand';
                                                                    $itemModel = $item->model ?? 'No model';
                                                                    
                                                                    // If no name, use Brand + Model
                                                                    if (empty($itemName)) {
                                                                        $itemName = $itemBrand . ' ' . $itemModel;
                                                                    }
                                                                }
                                                            } catch (Exception $e) {
                                                                $itemName = 'Unknown Equipment';
                                                                $itemBrand = 'No brand';
                                                                $itemModel = 'No model';
                                                            }
                                                        ?>
                                                        <div class="text-sm font-bold text-gray-900">
                                                            <?php echo e($itemName); ?>

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="space-y-1">
                                                    <?php
                                                        $categoryName = 'Unknown';
                                                        $typeName = 'Unknown';
                                                        try {
                                                            if ($item && is_object($item) && isset($item->category) && is_object($item->category) && isset($item->category->name)) {
                                                                $categoryName = $item->category->name;
                                                            }
                                                            if ($item && is_object($item) && isset($item->equipmentType) && is_object($item->equipmentType) && isset($item->equipmentType->name)) {
                                                                $typeName = $item->equipmentType->name;
                                                            }
                                                        } catch (Exception $e) {
                                                            $categoryName = 'Unknown';
                                                            $typeName = 'Unknown';
                                                        }
                                                    ?>
                                                    <span class="inline-flex px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-900 border border-blue-200">
                                                        <?php echo e($categoryName); ?>

                                                    </span>
                                                    <?php if($item && is_object($item) && isset($item->equipmentType) && is_object($item->equipmentType)): ?>
                                                        <br>
                                                        <span class="inline-flex px-2 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-900 border border-purple-200">
                                                            <?php echo e($typeName); ?>

                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    <?php
                                                        $itemModel = 'N/A';
                                                        try {
                                                            if ($item && is_object($item)) {
                                                                $itemModel = $item->model ?? 'N/A';
                                                            }
                                                        } catch (Exception $e) {
                                                            $itemModel = 'N/A';
                                                        }
                                                    ?>
                                                    <?php echo e($itemModel); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?php
                                                        $quantityAvailable = 0;
                                                        $quantityTotal = 0;
                                                        try {
                                                            if ($item && is_object($item)) {
                                                                $quantityAvailable = $item->quantity_available ?? 0;
                                                                $quantityTotal = $item->quantity_total ?? 0;
                                                            }
                                                        } catch (Exception $e) {
                                                            $quantityAvailable = 0;
                                                            $quantityTotal = 0;
                                                        }
                                                    ?>
                                                    <div class="flex items-center space-x-2">
                                                        <span class="font-bold text-gray-900"><?php echo e($quantityAvailable); ?></span>
                                                        <span class="text-gray-600">/</span>
                                                        <span class="font-semibold text-gray-900"><?php echo e($quantityTotal); ?></span>
                                                        <?php if($quantityTotal > 0): ?>
                                                            <span class="text-xs font-medium text-gray-600">(<?php echo e($quantityTotal); ?> instances)</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                        <?php
                                                            $percentage = $quantityTotal > 0 ? ($quantityAvailable / $quantityTotal) * 100 : 0;
                                                            $percentage = max(0, min(100, $percentage));
                                                        ?>
                                                        <div class="bg-red-600 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                                                    </div>
                                                    <?php if($item->instances->count() > 0): ?>
                                                        <?php
                                                            $damagedInstances = $item->instances->where('condition', 'damaged')->count();
                                                            $needsRepairInstances = $item->instances->where('condition', 'needs_repair')->count();
                                                        ?>
                                                        <?php if($damagedInstances > 0 || $needsRepairInstances > 0): ?>
                                                            <div class="mt-1 flex space-x-1">
                                                                <?php if($damagedInstances > 0): ?>
                                                                    <span class="inline-flex px-1 py-0.5 text-xs rounded bg-red-100 text-red-800"><?php echo e($damagedInstances); ?> damaged</span>
                                                                <?php endif; ?>
                                                                <?php if($needsRepairInstances > 0): ?>
                                                                    <span class="inline-flex px-1 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800"><?php echo e($needsRepairInstances); ?> needs repair</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if($item->quantity_available > 0): ?>
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Available
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Unavailable
                                                    </span>
                                                <?php endif; ?>
                                                
                                            </td>

                                            <td class="px-8 py-4 whitespace-nowrap text-sm font-medium">
                                                <?php
                                                    $itemId = 0;
                                                    try {
                                                        if ($item && is_object($item)) {
                                                            $itemId = $item->id ?? 0;
                                                        }
                                                    } catch (Exception $e) {
                                                        $itemId = 0;
                                                    }
                                                ?>
                                                <?php if($itemId > 0): ?>
                                                    <div class="flex items-center space-x-2">
                                                        <a href="<?php echo e(route('equipment-management.show', $item)); ?>" 
                                                           style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                           onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                           onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                           title="View Details">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </a>
                                                        <a href="<?php echo e(route('equipment-management.edit', $item)); ?>" 
                                                           style="background: linear-gradient(to right, #eab308, #ca8a04); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                           onmouseover="this.style.background='linear-gradient(to right, #ca8a04, #a16207)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                           onmouseout="this.style.background='linear-gradient(to right, #eab308, #ca8a04)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                           title="Edit Equipment">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                            </svg>
                                                        </a>
                                                        <a href="<?php echo e(route('maintenance-management.show', $item)); ?>" 
                                                           style="background: linear-gradient(to right, #10b981, #059669); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                           onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                           onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                           title="Maintenance">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                        </a>
                                                        <button type="button" 
                                                                id="add_instance_btn_<?php echo e($itemId); ?>"
                                                                onclick="showAddInstanceModal(<?php echo e($itemId); ?>)"
                                                                style="background: linear-gradient(to right, #8b5cf6, #7c3aed); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #7c3aed, #6d28d9)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #8b5cf6, #7c3aed)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Add Instance">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-xs text-gray-500">Invalid Item</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            <?php echo e($equipment->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding your first piece of equipment.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('equipment-management.create')); ?>" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                    <i class="fas fa-plus mr-2"></i>Add Equipment
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>





    <script>
        // Report Modal Functions
        function openReportModal() {
            Swal.fire({
                buttonsStyling: false,
                html: `
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Generate Equipment Report</h2>
                    </div>
                    <form id="eqReportForm" method="GET" action="<?php echo e(route('equipment-management.generate-pdf')); ?>" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                            <select name="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="all">All Equipment</option>
                                <option value="available">Available Equipment</option>
                                <option value="unavailable">Unavailable Equipment</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="modal_category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Type</label>
                            <select id="modal_equipment_type" name="equipment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm" disabled>
                                <option value="">All Types</option>
                            </select>
                            <p id="modal_equipment_type_help" class="mt-1 text-xs text-gray-500">Select an Equipment Category first to enable Equipment Type.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                            </select>
                        </div>
                    </form>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">Cancel</button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105" onclick="(function(){ const f=document.getElementById('eqReportForm'); const params=new URLSearchParams(new FormData(f)).toString(); const fmt=new FormData(f).get('format'); const base = fmt==='excel' ? '<?php echo e(route('equipment-management.export-excel')); ?>' : (fmt==='csv' ? '<?php echo e(route('equipment-management.export-csv')); ?>' : '<?php echo e(route('equipment-management.generate-pdf')); ?>'); window.open(base + (params ? ('?' + params) : ''), '_blank'); })()">Generate Report</button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '700px',
                customClass: { popup: 'swal-custom-popup' },
                didOpen: () => {
                    const cat = document.getElementById('modal_category');
                    const type = document.getElementById('modal_equipment_type');
                    const help = document.getElementById('modal_equipment_type_help');
                    const sync = () => {
                        const id = cat.value;
                        const has = Boolean(id);
                        type.disabled = !has;
                        type.classList.toggle('opacity-50', !has);
                        type.classList.toggle('cursor-not-allowed', !has);
                        help.textContent = has ? '' : 'Select an Equipment Category first to enable Equipment Type.';
                        if (has) {
                            fetch(`/equipment-types/by-category/${id}`).then(r=>r.json()).then(d=>{
                                type.innerHTML = '<option value="">All Types</option>';
                                d.forEach(t=>{ const o=document.createElement('option'); o.value=t.id; o.textContent=t.name; type.appendChild(o); });
                            });
                        } else {
                            type.innerHTML = '<option value="">All Types</option>';
                        }
                    };
                    cat.addEventListener('change', sync);
                    sync();
                }
            });
        }

        // Bulk Add Instances Modal Functions
        function showAddInstanceModal(equipmentId) {
            ManagementCommon.showAddInstanceModal(equipmentId);
        }

        // Toggle Search Filter Function
        function toggleSearchFilter() {
            const searchFilterContent = document.getElementById('searchFilterContent');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleBtn = document.getElementById('sfToggleBtn');
            
            if (searchFilterContent.style.display === 'none' || searchFilterContent.style.display === '') {
                searchFilterContent.style.display = 'block';
                toggleText.textContent = 'Hide';
                toggleIcon.style.transform = 'rotate(180deg)';
                if (toggleBtn) toggleBtn.style.background = 'linear-gradient(135deg, #0ea5e9 0%, #1d4ed8 100%)';
            } else {
                searchFilterContent.style.display = 'none';
                toggleText.textContent = 'Show';
                toggleIcon.style.transform = 'rotate(0deg)';
                if (toggleBtn) toggleBtn.style.background = 'linear-gradient(135deg, #3b82f6 0%, #6366f1 100%)';
            }
        }

    </script>
    <script>
        // Auto-apply filters and clear logic for Equipment Management (manager)
        (function(){
            const form = document.getElementById('eqFilterForm');
            const search = form ? form.querySelector('input[name="search"]') : null;
            const cat = document.getElementById('filter_category');
            const type = document.getElementById('filter_equipment_type');
            const status = form ? form.querySelector('select[name="status"]') : null;
            const clearBtn = document.getElementById('eqClearBtn');

            if (cat) {
                // Lock type when no category selected
                const toggleTypeLock = () => {
                    if (type) type.disabled = !cat.value;
                    const help = document.getElementById('eqTypeHelpMgr');
                    if (help) help.style.display = cat.value ? 'none' : '';
                };
                toggleTypeLock();
                cat.addEventListener('change', () => { toggleTypeLock(); });
            }
            // No auto-submit on field changes; rely on Search button

            if (clearBtn && form) {
                clearBtn.addEventListener('click', () => {
                    if (search) search.value = '';
                    if (cat) cat.value = '';
                    if (type) { type.value = ''; type.disabled = true; }
                    if (status) status.value = '';
                    submitAjax(new URL(form.action));
                });
            }

            // Intercept submit for AJAX-only refresh
            if (form) {
                form.addEventListener('submit', function(e){
                    e.preventDefault();
                    const url = new URL(form.action, window.location.origin);
                    const data = new FormData(form);
                    for (const [k,v] of data.entries()) { if (v) url.searchParams.set(k,v); }
                    submitAjax(url);
                });
            }

            function submitAjax(url){
                const wrapper = document.getElementById('equipmentTableWrapper');
                fetch(url.toString(), { headers: { 'X-Requested-With':'XMLHttpRequest' } })
                  .then(r=>r.text())
                  .then(html=>{
                      const doc = new DOMParser().parseFromString(html,'text/html');
                      const next = doc.querySelector('#equipmentTableWrapper');
                      if (wrapper && next) { wrapper.innerHTML = next.innerHTML; }
                      window.history.replaceState({},'',url);
                  })
                  .catch(()=>{ if (form.requestSubmit) form.requestSubmit(); else form.submit(); });
            }
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
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/admin-manager/equipment-management/index.blade.php ENDPATH**/ ?>