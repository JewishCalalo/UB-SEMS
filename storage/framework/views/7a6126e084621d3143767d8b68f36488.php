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
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <?php echo e(__('User Details')); ?>

                    </h2>
                    <p class="text-sm text-gray-600">View and manage user information</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'User Management', 'url' => route('profile-user-management.index')],
                ['label' => 'User Details']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'User Management', 'url' => route('profile-user-management.index')],
                ['label' => 'User Details']
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
            <div class="mb-6 flex justify-end">
                <a href="<?php echo e(route('profile-user-management.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to User Management
                </a>
            </div>

            <!-- Main User Profile Card -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-red-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        User Profile: <?php echo e($user->name); ?>

                    </h3>
                    <p class="text-red-100 text-sm mt-1">Complete user information and activity details</p>
                </div>
                
                <div class="p-6">
                    <!-- User Profile Header -->
                    <div class="mb-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                User Overview
                            </h4>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="h-16 w-16 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center shadow-lg">
                                    <span class="text-xl font-bold text-white">
                                        <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900"><?php echo e($user->name); ?></h3>
                                    <p class="text-gray-600 font-medium"><?php echo e($user->email); ?></p>
                                    <div class="flex items-center space-x-3 mt-2">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                            <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800 border border-red-200
                                            <?php elseif($user->role === 'manager'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                                            <?php else: ?> bg-blue-100 text-blue-800 border border-blue-200
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst($user->role)); ?>

                                        </span>
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                            <?php if($user->is_verified): ?> bg-green-100 text-green-800 border border-green-200 <?php else: ?> bg-red-100 text-red-800 border border-red-200 <?php endif; ?>">
                                            <?php echo e($user->is_verified ? 'Active' : 'Inactive'); ?>

                                        </span>
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                            <?php if($user->email_verified_at): ?> bg-green-100 text-green-800 border border-green-200 <?php else: ?> bg-yellow-100 text-yellow-800 border border-yellow-200 <?php endif; ?>">
                                            <?php echo e($user->email_verified_at ? 'Verified' : 'Unverified'); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <a href="<?php echo e(route('profile-user-management.edit', $user)); ?>" 
                                   class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-red-600 text-white hover:bg-red-700 focus:ring-red-500">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit User
                                </a>
                                <?php if($user->id !== auth()->id()): ?>
                                    <button type="button" 
                                            onclick="showDeleteUserConfirmation('<?php echo e($user->id); ?>', '<?php echo e($user->name); ?>')"
                                            class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete User
                                    </button>
                                    
                                    <!-- Hidden form for deletion -->
                                    <form id="delete-form" 
                                          method="POST" 
                                          action="<?php echo e(route('profile-user-management.destroy', $user)); ?>" 
                                          class="hidden">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- User Information Section -->
                    <div class="mb-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                User Information
                            </h4>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Department:</span>
                                    <p class="text-sm text-gray-900 font-medium"><?php echo e($user->department ?: 'Not specified'); ?></p>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Contact Number:</span>
                                    <p class="text-sm text-gray-900 font-medium"><?php echo e($user->contact_number ?: 'Not specified'); ?></p>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Member Since:</span>
                                    <p class="text-sm text-gray-900 font-medium"><?php echo e($user->created_at->format('M d, Y')); ?></p>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                                    <p class="text-sm text-gray-900 font-medium"><?php echo e($user->updated_at->format('M d, Y')); ?></p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <?php if($user->email_verified_at): ?>
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <span class="text-sm font-medium text-gray-600">Email Verified:</span>
                                        <p class="text-sm text-green-600 font-medium"><?php echo e($user->email_verified_at->format('M d, Y H:i')); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Last Activity:</span>
                                    <span class="text-sm text-gray-900 font-medium"><?php echo e($lastActivity->diffForHumans()); ?></span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium text-gray-600">Account Status:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->is_verified): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php echo e($user->is_verified ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Statistics Section -->
                    <div class="mb-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Activity Statistics
                            </h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center bg-gray-50 rounded-lg p-6 shadow-sm">
                                <div class="text-3xl font-bold text-blue-600 mb-2"><?php echo e($totalReservations); ?></div>
                                <div class="text-sm text-gray-600 font-medium">Total Reservations</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-6 shadow-sm">
                                <div class="text-3xl font-bold text-yellow-600 mb-2"><?php echo e($pendingReservations); ?></div>
                                <div class="text-sm text-gray-600 font-medium">Pending Reservations</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg p-6 shadow-sm">
                                <div class="text-3xl font-bold text-green-600 mb-2"><?php echo e($approvedReservations); ?></div>
                                <div class="text-sm text-gray-600 font-medium">Approved Reservations</div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity Logs Section -->
                    <div class="mb-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Recent Activity Logs
                            </h4>
                        </div>
                        
                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                            <div class="max-h-96 overflow-y-auto">
                                <?php if($recentActivities->count() > 0): ?>
                                    <div class="divide-y divide-gray-200">
                                        <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="p-4 hover:bg-gray-50 transition-colors">
                                                <div class="flex items-start justify-between">
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-8 h-8 bg-<?php echo e($activity->action_color); ?>-100 rounded-full flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-<?php echo e($activity->action_color); ?>-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path d="<?php echo e($activity->action_icon); ?>"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900"><?php echo e($activity->actionDescription); ?> <?php echo e($activity->model_name); ?></p>
                                                            <p class="text-sm text-gray-600 mt-1"><?php echo e($activity->description); ?></p>
                                                            <p class="text-xs text-gray-500 mt-1">Model: <?php echo e(class_basename($activity->model_type)); ?> <?php if($activity->model_id): ?> • #<?php echo e($activity->model_id); ?> <?php endif; ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 text-right">
                                                        <p class="text-xs text-gray-500"><?php echo e($activity->created_at->diffForHumans()); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="p-8 text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-gray-500 text-sm">No recent activity found</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- System Access Section -->
                    <div class="border-t border-gray-200 pt-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                System Access & Permissions
                            </h4>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Equipment Management:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> Full Access <?php else: ?> No Access <?php endif; ?>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Reservation Management:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> Full Access <?php else: ?> No Access <?php endif; ?>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">User Management:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->role === 'admin'): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php if($user->role === 'admin'): ?> Full Access <?php else: ?> No Access <?php endif; ?>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-sm font-medium text-gray-600">Maintenance Management:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> Full Access <?php else: ?> No Access <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">System Reports:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                        <?php if($user->role === 'admin' || $user->role === 'manager'): ?> Full Access <?php else: ?> No Access <?php endif; ?>
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Equipment Reservations:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Full Access
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm font-medium text-gray-600">Email Status:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->email_verified_at): ?> bg-green-100 text-green-800 <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                        <?php echo e($user->email_verified_at ? 'Verified' : 'Unverified'); ?>

                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-sm font-medium text-gray-600">Role Level:</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($user->role === 'admin'): ?> bg-red-100 text-red-800
                                        <?php elseif($user->role === 'manager'): ?> bg-yellow-100 text-yellow-800
                                        <?php else: ?> bg-blue-100 text-blue-800
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($user->role)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <button type="button" id="confirm-delete-btn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold opacity-50 cursor-not-allowed" disabled onclick="confirmDeleteUser()">
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
                        if (this.value.trim() !== '') {
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

        function confirmDeleteUser() {
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
            fetch(document.getElementById('delete-form').action, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
                                <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.href='<?php echo e(route('profile-user-management.index')); ?>';">
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
<?php /**PATH C:\UB-SEMS\resources\views\admin\user-management\show.blade.php ENDPATH**/ ?>