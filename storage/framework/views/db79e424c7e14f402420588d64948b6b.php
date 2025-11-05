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
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        <?php echo e(__('Profile Settings')); ?>

                    </h2>
                    <p class="text-sm text-gray-600">Manage your account settings and preferences</p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Profile Settings']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Profile Settings']
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
            
            <!-- First Time Login Banner -->
            <?php if(!auth()->user()->first_name || !auth()->user()->last_name || !auth()->user()->contact_number): ?>
            <div class="mb-8">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6 shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-blue-800">Welcome! Complete Your Profile Setup</h3>
                            <p class="mt-2 text-sm text-blue-700">
                                This is your first login. Please complete your profile information below to get started with the system.
                                All fields marked with <span class="text-red-500 font-semibold">*</span> are required.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Main Profile Card -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-red-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile Settings
                    </h3>
                    <p class="text-red-100 text-sm mt-1">Manage your account settings and preferences</p>
                </div>
                
                <div class="p-6">
                    <?php if($errors->any()): ?>
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-red-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-bold text-red-800">Please review the form:</h4>
                                    <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1 font-semibold">
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Profile Information Section or Summary -->
                    <?php if(isset($completed) && $completed): ?>
                    <!-- Completed profile summary view -->
                    <div class="mb-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile Information
                            </h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First name</label>
                                <p class="text-gray-900"><?php echo e($user->first_name); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last name</label>
                                <p class="text-gray-900"><?php echo e($user->last_name); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Display name</label>
                                <p class="text-gray-900"><?php echo e($user->name); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-gray-900"><?php echo e($user->email); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                <p class="text-gray-900"><?php echo e($user->contact_number); ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <p class="text-gray-900 capitalize"><?php echo e($user->role); ?></p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <a href="#edit-profile" onclick="document.getElementById('profile-edit-form').scrollIntoView({behavior:'smooth'})" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">Edit Profile</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div id="profile-edit-form" class="mb-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Profile Information
                            </h4>
                        </div>
                        
                        <?php echo $__env->make('admin-manager.profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                <?php if(auth()->user()->first_name && auth()->user()->last_name && auth()->user()->contact_number): ?>
                <!-- Password Security Section - Only show for established users -->
                <div class="mb-8">
                    <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                        <h4 class="text-md font-semibold text-red-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Password Security
                        </h4>
                    </div>
                    
                    <?php echo $__env->make('admin-manager.profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <?php endif; ?>

                    <?php if(!auth()->user()->isAdmin() && auth()->user()->first_name && auth()->user()->last_name && auth()->user()->contact_number): ?>
                    <!-- Account Deletion Section - Only show for established users -->
                    <div class="border-t border-gray-200 pt-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Danger Zone
                            </h4>
                        </div>
                        
                        <?php echo $__env->make('admin-manager.profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <?php if(session('status') === 'profile-updated'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: 'Your profile has been updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#10b981',
                    customClass: {
                        confirmButton: 'swal2-confirm-button'
                    }
                }).then(() => {
                    // Clear the session status
                    fetch('<?php echo e(route("profile.edit")); ?>', {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                });
            });
        </script>
    <?php endif; ?>

    <!-- Error Modal for Admin Delete Attempt -->
    <?php if($errors->has('error') && $errors->first('error') === 'Admin accounts cannot be deleted for security reasons.'): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Access Denied',
                    text: 'Admin accounts cannot be deleted for security reasons.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ef4444',
                    customClass: {
                        confirmButton: 'swal2-confirm-button'
                    }
                });
            });
        </script>
    <?php endif; ?>

    <style>
        .swal2-confirm-button {
            border: none !important;
            outline: none !important;
        }
    </style>
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
<?php /**PATH C:\SEMSv26\resources\views/admin-manager/profile/edit.blade.php ENDPATH**/ ?>