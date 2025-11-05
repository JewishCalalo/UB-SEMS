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
            <?php echo e(__('User Management')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Users']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Users']
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
                         <!-- Header with Create Button -->
             <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                 <div class="flex justify-between items-center">
                     <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Manage Users</h3>
                        <p class="text-lg font-semibold text-gray-600">Create, edit, and manage user accounts</p>
                     </div>
                        <a href="<?php echo e(route('profile-user-management.create')); ?>" 
                           class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-red-600 text-white hover:bg-red-700 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add User
                        </a>
                 </div>
             </div>

                         <!-- Search and Filter Toggle Section -->
                     <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-4">
                         <div class="flex justify-between items-center">
                             <h4 class="text-xl font-bold text-gray-900">Search & Filter</h4>
                             <button type="button" onclick="toggleSearchFilter()" 
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
                             <form id="searchFilterForm" method="GET" action="<?php echo e(route('profile-user-management.index')); ?>" class="space-y-6">
                                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Search</label>
                                         <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                                placeholder="Name or email..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Role</label>
                                         <select name="role" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Roles</option>
                                             <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <option value="<?php echo e($role); ?>" <?php echo e(request('role') == $role ? 'selected' : ''); ?>>
                                                     <?php echo e(ucfirst($role)); ?>

                                                 </option>
                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                         </select>
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Status</label>
                                         <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Status</option>
                                             <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                                             <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                                             <option value="verified" <?php echo e(request('status') === 'verified' ? 'selected' : ''); ?>>Verified</option>
                                             <option value="unverified" <?php echo e(request('status') === 'unverified' ? 'selected' : ''); ?>>Unverified</option>
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
                                             <button type="button" id="userClearBtn"
                                                     class="px-4 py-3 rounded-lg text-white flex-1 text-center transition-transform duration-150"
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

                                                   <!-- Action Legend -->
              <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-lg shadow-sm mb-4">
                  <div class="p-4">
                      <div class="flex justify-between items-center">
                          <h4 class="text-sm font-semibold text-gray-800 flex items-center">
                              <i class="fas fa-info-circle mr-2 text-gray-600"></i>
                              Action Legend:
                          </h4>
                         <div class="flex flex-wrap gap-4">
                             <div class="flex items-center space-x-2">
                                 <div style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                     </svg>
                                 </div>
                                 <span class="text-sm text-gray-600">View Details</span>
                             </div>
                             <div class="flex items-center space-x-2">
                                 <div style="background: linear-gradient(to right, #eab308, #ca8a04); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                     </svg>
                                 </div>
                                 <span class="text-sm text-gray-600">Edit User</span>
                             </div>
                             <div class="flex items-center space-x-2">
                                 <div style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                     </svg>
                                 </div>
                                 <span class="text-sm text-gray-600">Delete User</span>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

                         <!-- Users Table -->
             <div id="usersTableContainer" class="bg-white border border-gray-200 rounded-lg shadow-sm">
                 <div class="p-6">
                    <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-table mr-2 text-gray-600"></i>
                        Users List
                    </h4>
                    <?php if($users->count() > 0): ?>
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
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            <a href="<?php echo e(route('profile-user-management.index', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('direction') === 'asc' && request('sort')==='created_at' ? 'desc' : 'asc']))); ?>" class="inline-flex items-center gap-1 text-white hover:text-gray-200">
                                                User
                                                <span class="ml-1 inline-flex flex-col leading-none">
                                                    <i class="fas fa-caret-up <?php echo e(request('sort')==='created_at' && request('direction')==='asc' ? 'text-white' : 'text-gray-300'); ?>"></i>
                                                    <i class="fas fa-caret-down <?php echo e(request('sort')==='created_at' && request('direction')==='desc' ? 'text-white' : 'text-gray-300'); ?>"></i>
                                                </span>
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Date Added</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-gray-700">
                                                                <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-bold text-gray-900"><?php echo e($user->name); ?></div>
                                                        <div class="text-sm font-medium text-gray-700"><?php echo e($user->email); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800
                                                    <?php elseif($user->role === 'manager'): ?> bg-yellow-100 text-yellow-800
                                                    <?php else: ?> bg-blue-100 text-blue-800
                                                    <?php endif; ?>">
                                                    <?php echo e(ucfirst($user->role)); ?>

                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                <?php echo e($user->department ?: 'N/A'); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-col space-y-1">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        <?php if($user->is_verified): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                                        <?php echo e($user->is_verified ? 'Active' : 'Inactive'); ?>

                                                    </span>
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        <?php if($user->email_verified_at): ?> bg-green-100 text-green-800 <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                                        <?php echo e($user->email_verified_at ? 'Verified' : 'Unverified'); ?>

                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                <?php echo e($user->created_at->format('M d, Y H:i')); ?>

                                            </td>
                                            
                                                                                         <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                 <div class="flex items-center space-x-2">
                                                                                                                                                                 <a href="<?php echo e(route('profile-user-management.show', $user)); ?>" 
                                                         style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                         onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                         onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                         title="View Details">
                                                          <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                         </svg>
                                                     </a>
                                                                                                           <a href="<?php echo e(route('profile-user-management.edit', $user)); ?>" 
                                                         style="background: linear-gradient(to right, #eab308, #ca8a04); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                         onmouseover="this.style.background='linear-gradient(to right, #ca8a04, #a16207)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                         onmouseout="this.style.background='linear-gradient(to right, #eab308, #ca8a04)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                         title="Edit User">
                                                          <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                         </svg>
                                                     </a>
                                                                                                         <?php if($user->id !== auth()->id()): ?>
                                                        <button type="button" 
                                                                id="delete_user_btn_<?php echo e($user->id); ?>"
                                                                onclick="showDeleteUserConfirmation('<?php echo e($user->id); ?>', '<?php echo e($user->name); ?>')"
                                                                style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Delete User">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    <?php endif; ?>
                                                 </div>
                                             </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            <?php echo e($users->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating your first user account.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('profile-user-management.create')); ?>" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                    <i class="fas fa-plus mr-2"></i>Add User
                                </a>
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
                    icon: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Operation Successful!</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700"><?php echo e(session('success')); ?></p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close();">
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

            // Clear button functionality
            const clearBtn = document.getElementById('userClearBtn');
            const form = document.querySelector('form[action="<?php echo e(route('profile-user-management.index')); ?>"]');
            
            if (clearBtn && form) {
                clearBtn.addEventListener('click', function() {
                    // Clear all form fields
                    form.querySelectorAll('input[type="text"], select').forEach(field => {
                        field.value = '';
                    });
                    
                    // Submit the form to refresh the table
                    form.submit();
                });
            }
        });

        // Delete User Confirmation Modal
        function showDeleteUserConfirmation(userId, userName) {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-red-600 text-white p-4 -m-6 mb-6 rounded-t-lg">
                        <h2 class="text-xl font-bold flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete User Account
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-red-800 mb-2">Permanent Action Warning</h4>
                                    <p class="text-sm text-red-700">This action will permanently delete the user account for <strong class="font-bold">${userName}</strong>. This cannot be undone and the user data will be lost forever.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-800 mb-2">What will happen:</h4>
                            <ul class="text-sm text-gray-700 space-y-1">
                                <li class="flex items-start">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2 mt-1.5 flex-shrink-0"></span>
                                    <span>The user account will be permanently removed from the system</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2 mt-1.5 flex-shrink-0"></span>
                                    <span>All user data, settings, and profile information will be deleted</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2 mt-1.5 flex-shrink-0"></span>
                                    <span>User's reservation history will be preserved for record keeping</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2 mt-1.5 flex-shrink-0"></span>
                                    <span>This action cannot be reversed or undone</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-sm text-yellow-800">
                                    <strong>Confirmation Required.</strong> Enter your password below to proceed with deleting the user account.
                                </p>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label for="delete-confirmation" class="block text-sm font-medium text-gray-700">Enter your password:</label>
                            <input type="password" id="delete-confirmation" placeholder="Enter your password..." 
                                   class="w-full px-3 py-2 border border-red-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-semibold" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" id="confirm-delete-btn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold opacity-50 cursor-not-allowed" disabled onclick="confirmDeleteUser('${userId}')">
                            Delete User Account
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '600px',
                customClass: {
                    popup: 'swal-custom-popup'
                },
                didOpen: () => {
                    const confirmInput = document.getElementById('delete-confirmation');
                    const confirmBtn = document.getElementById('confirm-delete-btn');
                    
                    confirmInput.addEventListener('input', function() {
                        if (this.value.length >= 6) {
                            confirmBtn.disabled = false;
                            confirmBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            confirmBtn.classList.add('opacity-100', 'cursor-pointer');
                        } else {
                            confirmBtn.disabled = true;
                            confirmBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            confirmBtn.classList.remove('opacity-100', 'cursor-pointer');
                        }
                    });
                }
            });
        }

        function confirmDeleteUser(userId) {
            const pwd = document.getElementById('delete-confirmation')?.value || '';
            
            if (!pwd) {
                Swal.fire({
                    title: 'Password Required',
                    text: 'Please enter your password to confirm user deletion.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626'
                });
                return;
            }
            
            // Show loading state
            Swal.fire({
                title: 'Verifying Password...',
                text: 'Please wait while we verify your password.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Make AJAX request
            fetch(`<?php echo e(route('profile-user-management.destroy', ':userId')); ?>`.replace(':userId', userId), {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ password: pwd })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success === true) {
                    // Show success message
                    Swal.fire({
                        title: '',
                        html: `
                            <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Success!</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-lg font-medium">User account has been successfully deleted.</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.reload();">
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
                    // Show error message based on password validation
                    if (data.message && data.message.includes('password')) {
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">User Deletion Blocked</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">User Deletion Blocked because of wrong password. Please check your password and try again.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
                            title: '',
                            html: `
                                <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">User Deletion Blocked</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 text-lg font-medium">${data.message || 'An error occurred while deleting the user.'}</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
                }
            })
            .catch(error => {
                console.error('User deletion error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while deleting the user. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc2626'
                });
            });
        }

        // Toggle search and filter functionality
        function toggleSearchFilter() {
            const content = document.getElementById('searchFilterContent');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            const toggleButton = document.querySelector('[onclick="toggleSearchFilter()"]');
            
            if (content.style.display === 'none') {
                // Show the content
                content.style.display = 'block';
                toggleText.textContent = 'Hide';
                toggleIcon.style.transform = 'rotate(180deg)';
                
                // Change to active state (green)
                toggleButton.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
            } else {
                // Hide the content
                content.style.display = 'none';
                toggleText.textContent = 'Show';
                toggleIcon.style.transform = 'rotate(0deg)';
                
                // Change back to default state (blue)
                toggleButton.style.background = 'linear-gradient(135deg, #3b82f6 0%, #6366f1 100%)';
            }
        }

        // Handle search and filter form submission with AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchFilterForm');
            const clearBtn = document.getElementById('userClearBtn');
            
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    performSearch();
                });
            }
            
            if (clearBtn) {
                clearBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    clearFilters();
                });
            }
        });

        function performSearch() {
            const form = document.getElementById('searchFilterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams();
            
            // Add all form data to URL parameters
            for (let [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value);
                }
            }
            
            // Show loading state
            const tableContainer = document.getElementById('usersTableContainer');
            tableContainer.innerHTML = '<div class="p-6 text-center"><div class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Loading...</div></div>';
            
            // Make AJAX request
            fetch(`<?php echo e(route('profile-user-management.index')); ?>?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
            .then(response => response.text())
            .then(html => {
                // Extract only the table content from the response
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTableContainer = doc.getElementById('usersTableContainer');
                
                if (newTableContainer) {
                    tableContainer.innerHTML = newTableContainer.innerHTML;
                } else {
                    tableContainer.innerHTML = '<div class="p-6 text-center text-red-500">Error loading results</div>';
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                tableContainer.innerHTML = '<div class="p-6 text-center text-red-500">Error loading results</div>';
            });
        }

        function clearFilters() {
            const form = document.getElementById('searchFilterForm');
            const inputs = form.querySelectorAll('input, select');
            
            // Clear all form inputs
            inputs.forEach(input => {
                if (input.type === 'text' || input.type === 'email') {
                    input.value = '';
                } else if (input.type === 'select-one') {
                    input.selectedIndex = 0;
                }
            });
            
            // Perform search with empty filters
            performSearch();
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
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/admin/user-management/index.blade.php ENDPATH**/ ?>