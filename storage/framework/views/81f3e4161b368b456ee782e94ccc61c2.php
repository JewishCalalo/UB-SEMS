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
            <?php echo e(__('Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Manager Dashboard</h3>
                        <p class="text-gray-600">Welcome back, <?php echo e(Auth::user()->name); ?>. Here's your system overview.</p>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-user-tie mr-2 text-red-500"></i>
                        Manager Access
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Equipment</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($totalEquipment); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Instances</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($totalInstances); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Available Instances</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($availableInstances); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Pending Reservations</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($pendingReservations); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Active Reservations</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($approvedReservations); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Overdue Reservations</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($overdueReservations); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-gray-600">Instances Needing Repair</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($instancesNeedingMaintenance); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Missing Equipment</p>
                                <p class="text-2xl font-bold text-gray-900"><?php echo e($stolenLostEquipment ?? 0); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-lg shadow-sm mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-bolt mr-2 text-red-600"></i>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="<?php echo e(route('equipment-management.index')); ?>" style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; padding: 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: flex; align-items: center;"
                           onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <div style="background: rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 14px; font-weight: 500; color: white;">Equipment Management</p>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.8);">Manage equipment inventory</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('equipment-categories.index')); ?>" style="background: linear-gradient(to right, #10b981, #059669); color: white; padding: 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: flex; align-items: center;"
                           onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <div style="background: rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 14px; font-weight: 500; color: white;">Equipment Categories</p>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.8);">Organize equipment types</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('maintenance-management.index')); ?>" style="background: linear-gradient(to right, #14b8a6, #0d9488); color: white; padding: 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: flex; align-items: center;"
                           onmouseover="this.style.background='linear-gradient(to right, #0d9488, #0f766e)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #14b8a6, #0d9488)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <div style="background: rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 14px; font-weight: 500; color: white;">Maintenance</p>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.8);">Schedule maintenance</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('reservation-management.index')); ?>" style="background: linear-gradient(to right, #f97316, #ea580c); color: white; padding: 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: flex; align-items: center;"
                           onmouseover="this.style.background='linear-gradient(to right, #ea580c, #c2410c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #f97316, #ea580c)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <div style="background: rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 14px; font-weight: 500; color: white;">Reservations</p>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.8);">Manage reservations</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('equipment-management.wishlisted')); ?>" style="background: linear-gradient(to right, #ec4899, #db2777); color: white; padding: 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: flex; align-items: center;"
                           onmouseover="this.style.background='linear-gradient(to right, #db2777, #be185d)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #ec4899, #db2777)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <div style="background: rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 14px; font-weight: 500; color: white;">Wishlisted Items</p>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.8);">View popular equipment</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('missing-equipment.index')); ?>" style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; padding: 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: flex; align-items: center;"
                           onmouseover="this.style.background='linear-gradient(to right, #b91c1c, #991b1b)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <div style="background: rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 14px; font-weight: 500; color: white;">Lost & Damaged</p>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.8);">Tracking lost and damaged equipment replacements</p>
                            </div>
                        </a>

                        <a href="<?php echo e(route('maintenance-management.discarded')); ?>" style="background: linear-gradient(to right, #eab308, #ca8a04); color: white; padding: 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: flex; align-items: center;"
                           onmouseover="this.style.background='linear-gradient(to right, #ca8a04, #a16207)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                           onmouseout="this.style.background='linear-gradient(to right, #eab308, #ca8a04)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                            <div style="background: rgba(255, 255, 255, 0.2); width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size: 14px; font-weight: 500; color: white;">Discarded Items</p>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.8);">View discarded items</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Reservations -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-clock mr-2 text-blue-600"></i>
                                Recent Reservations
                            </h3>
                            <a href="<?php echo e(route('reservation-management.index')); ?>" class="text-red-600 hover:text-red-800 text-sm font-medium">View All</a>
                        </div>
                        <?php if($recentReservations->count() > 0): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = $recentReservations->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900"><?php echo e($reservation->user ? $reservation->user->email : $reservation->email); ?></p>
                                                <p class="text-xs text-gray-500"><?php echo e($reservation->items->count()); ?> items • <?php echo e($reservation->created_at->diffForHumans()); ?></p>
                                            </div>
                                        </div>
                                        <span class="text-xs px-2 py-1 rounded-full <?php echo e($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($reservation->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')); ?>">
                                            <?php echo e(ucfirst($reservation->status)); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 text-center py-4">No recent reservations</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Equipment Status -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg shadow-sm">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-chart-bar mr-2 text-green-600"></i>
                                Equipment Status
                            </h3>
                            <a href="<?php echo e(route('equipment-management.index')); ?>" class="text-red-600 hover:text-red-800 text-sm font-medium">View All</a>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Available Instances</span>
                                </div>
                                <span class="text-lg font-semibold text-green-600"><?php echo e($availableInstances); ?></span>
                            </div>
                            
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Pending Reservations</span>
                                </div>
                                <span class="text-lg font-semibold text-yellow-600"><?php echo e($pendingReservations); ?></span>
                            </div>
                            
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Unavailable Instances</span>
                                </div>
                                <span class="text-lg font-semibold text-red-600"><?php echo e($totalInstances - $availableInstances); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(false): ?>
            <!-- Analytics Section (Graphs) -->
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Analytics Overview</h3>
                
                <!-- First Row: Equipment Status and Lifecycle Distribution side by side -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Equipment Status Distribution (Pie Chart) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Equipment Status Distribution
                            </h4>
                            <div class="relative" style="height: 400px;">
                                <canvas id="equipmentStatusChart" class="absolute inset-0 w-full h-full"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Equipment Lifecycle Distribution (Pie Chart) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Equipment Lifecycle Distribution
                            </h4>
                            <div class="relative" style="height: 400px;">
                                <canvas id="lifecycleChart" class="absolute inset-0 w-full h-full"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Second Row: Monthly Reservation Trends and Most Borrowed Equipment as rectangular graphs -->
                <div class="grid grid-cols-1 gap-8">
                    <!-- Monthly Reservation Trends (Line Chart) - Full width -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Monthly Reservation Trends
                            </h4>
                            <div class="relative" style="height: 300px;">
                                <canvas id="reservationTrendsChart" class="absolute inset-0 w-full h-full"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top Borrowed Equipment (Bar Chart) - Full width -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Most Borrowed Equipment
                            </h4>
                            <div class="relative" style="height: 300px;">
                                <canvas id="topBorrowedChart" class="absolute inset-0 w-full h-full"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $__env->startPush('scripts'); ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Equipment Status Distribution (Pie Chart)
                const statusCtx = document.getElementById('equipmentStatusChart');
                if (statusCtx) {
                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: <?php echo json_encode(array_keys($equipmentStatusData), 15, 512) ?>,
                            datasets: [{
                                data: <?php echo json_encode(array_values($equipmentStatusData), 15, 512) ?>,
                                backgroundColor: [
                                    '#10b981', // Available - Green
                                    '#6b7280', // Unavailable - Gray
                                    '#f59e0b', // Damaged - Yellow
                                    '#ef4444', // Needs Repair - Red
                                    '#8b5cf6'  // Lost - Purple
                                ],
                                borderWidth: 3,
                                borderColor: '#ffffff',
                                hoverBorderWidth: 4,
                                hoverBorderColor: '#f3f4f6'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#ffffff',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    displayColors: true
                                }
                            },
                            animation: {
                                animateRotate: true,
                                animateScale: true,
                                duration: 1000
                            }
                        }
                    });
                }

                // Monthly Reservation Trends (Line Chart)
                const trendsCtx = document.getElementById('reservationTrendsChart');
                if (trendsCtx) {
                    const reservationLabels = <?php echo json_encode($monthlyReservations->pluck('month')->map(function($month) {
                        return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y');
                    }), 512) ?>;
                    const reservationCounts = <?php echo json_encode($monthlyReservations->pluck('count'), 15, 512) ?>;
                    const resMax = Math.max(1, ...reservationCounts);
                    const resStep = Math.max(1, Math.ceil(resMax / 6));
                    new Chart(trendsCtx, {
                        type: 'line',
                        data: {
                            labels: reservationLabels,
                            datasets: [{
                                label: 'Reservations (last 6 months)',
                                data: reservationCounts,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 3,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                                borderWidth: 3
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { 
                                    display: true, 
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 14,
                                            weight: '600'
                                        }
                                    }
                                },
                                tooltip: { 
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#ffffff',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    callbacks: { 
                                        label: (ctx) => ` ${ctx.parsed.y} reservations` 
                                    } 
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        maxTicksLimit: 6,
                                        autoSkip: true,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    }
                                },
                                y: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)',
                                        drawBorder: false
                                    },
                                    beginAtZero: true,
                                    ticks: { 
                                        stepSize: resStep,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    },
                                    suggestedMax: resMax + resStep
                                }
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });
                }

                // Top Borrowed Equipment (Bar Chart)
                const borrowedCtx = document.getElementById('topBorrowedChart');
                if (borrowedCtx) {
                    const borrowedLabels = <?php echo json_encode($topBorrowed->map(function($item) { return $item->brand . ' ' . $item->model; }), 15, 512) ?>;
                    const borrowedCounts = <?php echo json_encode($topBorrowed->pluck('total_borrowed'), 15, 512) ?>;
                    const borMax = Math.max(1, ...borrowedCounts);
                    const borStep = Math.max(1, Math.ceil(borMax / 6));
                    new Chart(borrowedCtx, {
                        type: 'bar',
                        data: {
                            labels: borrowedLabels,
                            datasets: [{
                                label: 'Times Borrowed (top 8)',
                                data: borrowedCounts,
                                backgroundColor: 'rgba(249, 115, 22, 0.8)',
                                borderColor: '#f97316',
                                borderWidth: 2,
                                borderRadius: 8,
                                borderSkipped: false,
                                hoverBackgroundColor: 'rgba(249, 115, 22, 1)',
                                hoverBorderColor: '#ea580c',
                                hoverBorderWidth: 3
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { 
                                    display: true, 
                                    position: 'top',
                                    labels: {
                                        font: {
                                            size: 14,
                                            weight: '600'
                                        }
                                    }
                                },
                                tooltip: { 
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#ffffff',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    callbacks: { 
                                        label: (ctx) => ` ${ctx.parsed.y} borrows` 
                                    } 
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)',
                                        drawBorder: false
                                    },
                                    ticks: { 
                                        autoSkip: true, 
                                        maxTicksLimit: 8,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    }
                                },
                                y: {
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)',
                                        drawBorder: false
                                    },
                                    beginAtZero: true,
                                    ticks: { 
                                        stepSize: borStep,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    },
                                    suggestedMax: borMax + borStep
                                }
                            },
                            animation: {
                                duration: 1000,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });
                }

                // Equipment Lifecycle Distribution (Pie Chart)
                const lifecycleCtx = document.getElementById('lifecycleChart');
                if (lifecycleCtx) {
                    new Chart(lifecycleCtx, {
                        type: 'doughnut',
                        data: {
                            labels: <?php echo json_encode(array_keys($lifecycleData), 15, 512) ?>,
                            datasets: [{
                                data: <?php echo json_encode(array_values($lifecycleData), 15, 512) ?>,
                                backgroundColor: [
                                    '#10b981', // Active - Green
                                    '#6b7280', // Retired - Gray
                                    '#ef4444', // Missing - Red
                                    '#f59e0b'  // In Maintenance - Yellow
                                ],
                                borderWidth: 3,
                                borderColor: '#ffffff',
                                hoverBorderWidth: 4,
                                hoverBorderColor: '#f3f4f6'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '60%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#ffffff',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    displayColors: true
                                }
                            },
                            animation: {
                                animateRotate: true,
                                animateScale: true,
                                duration: 1000
                            }
                        }
                    });
                }
            });
            </script>
            <?php $__env->stopPush(); ?>
            <?php endif; ?>
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
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/manager/dashboard/index.blade.php ENDPATH**/ ?>