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
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <a href="<?php echo e(route('profile-user-management.edit', $user)); ?>" 
                                           class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <?php if($user->id !== auth()->id()): ?>
                                            <button type="button" 
                                                    onclick="showDeleteUserConfirmation('<?php echo e($user->id); ?>', '<?php echo e($user->name); ?>')"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
<?php /**PATH C:\UB-SEMS\resources\views\admin\user-management\partials\table.blade.php ENDPATH**/ ?>