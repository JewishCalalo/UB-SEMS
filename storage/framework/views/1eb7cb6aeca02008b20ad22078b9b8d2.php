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
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')]
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')]
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
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Instructor Dashboard</h3>
                        <p class="text-gray-600 font-medium">Welcome back, <?php echo e(Auth::user()->name); ?>. Here's your system overview.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                            <i class="fas fa-chalkboard-teacher mr-2 text-red-500"></i>
                            Instructor Access
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-600 mb-1">Total Reservations</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo e($totalReservations); ?></p>
                                <p class="text-xs text-gray-500 mt-1">All time</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-2">
                        <div class="text-xs text-red-600 font-medium flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Complete track record
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-600 mb-1">Completed</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo e($completedReservations); ?></p>
                                <p class="text-xs text-gray-500 mt-1">Successfully returned</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-2">
                        <div class="text-xs text-green-600 font-medium flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Equipment returned safely
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-600 mb-1">Pending</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo e($pendingReservations); ?></p>
                                <p class="text-xs text-gray-500 mt-1">Awaiting approval</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 px-6 py-2">
                        <div class="text-xs text-yellow-600 font-medium flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            Under review process
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-semibold text-gray-600 mb-1">This Month</p>
                                <p class="text-3xl font-bold text-gray-900"><?php echo e($thisMonthReservations); ?></p>
                                <p class="text-xs text-gray-500 mt-1"><?php echo e(date('F Y')); ?> activity</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-2">
                        <div class="text-xs text-blue-600 font-medium flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            Current month progress
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Calendar Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            My Reservations Calendar
                        </h3>
                        <div class="flex space-x-2">
                            <button id="createReservationBtn" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                New Reservation
                            </button>
                        </div>
                    </div>
                    
                    <!-- Calendar Legend -->
                    <div class="flex flex-wrap gap-4 mb-4 text-sm">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #fbbf24;"></div>
                            <span class="text-gray-600">Pending</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #10b981;"></div>
                            <span class="text-gray-600">Approved</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #3b82f6;"></div>
                            <span class="text-gray-600">Picked Up</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #6b7280;"></div>
                            <span class="text-gray-600">Returned</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #ef4444;"></div>
                            <span class="text-gray-600">Denied</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #dc2626;"></div>
                            <span class="text-gray-600">Overdue</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #9ca3af;"></div>
                            <span class="text-gray-600">Cancelled</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded mr-2" style="background-color: #22c55e;"></div>
                            <span class="text-gray-600">Completed</span>
                        </div>
                    </div>
                    
                    <!-- Calendar Container -->
                    <div id="dashboardCalendar" class="w-full"></div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="<?php echo e(route('instructor.reservations.create')); ?>" class="group bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:border-red-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition-colors">
                                        Create Reservation
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">Make a new equipment reservation</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-red-50 to-orange-50 px-6 py-3 border-t border-red-100">
                            <div class="text-xs text-red-600 font-medium flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    Start new request
                                </span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo e(route('instructor.reservations')); ?>" class="group bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:border-blue-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        My Reservations
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">View and manage your equipment reservations</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-3 border-t border-blue-100">
                            <div class="text-xs text-blue-600 font-medium flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"/>
                                    </svg>
                                    Track & manage
                                </span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo e(route('instructor.incidents.create')); ?>" class="group bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:border-orange-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-r from-orange-500 to-red-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-orange-600 transition-colors">
                                        Report Incident
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">Report equipment issues or damage</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-3 border-t border-orange-100">
                            <div class="text-xs text-orange-600 font-medium flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    Report issues
                                </span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo e(route('instructor.incidents.index')); ?>" class="group bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:border-purple-200">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow">
                                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-purple-600 transition-colors">
                                        Incident Reports
                                    </h4>
                                    <p class="text-sm text-gray-600 mt-1">View and generate incident reports</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-3 border-t border-purple-100">
                            <div class="text-xs text-purple-600 font-medium flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    View reports
                                </span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>



            <!-- Recent Incidents Section -->
            <?php if($recentIncidents->count() > 0): ?>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 mb-8">
                <div class="bg-orange-50 border-l-4 border-orange-500 px-6 py-4">
                    <h4 class="text-lg font-semibold text-orange-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        Recent Incidents
                    </h4>
                </div>
                <div class="p-6">
                    <?php $__currentLoopData = $recentIncidents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incident): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-b border-gray-200 py-4 last:border-b-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <a href="<?php echo e(route('instructor.incidents.show', $incident)); ?>" class="text-lg font-semibold text-gray-900 hover:text-red-600 transition-colors">
                                        <?php echo e($incident->incident_code); ?>

                                    </a>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <?php echo e($incident->incident_type); ?> - <?php echo e($incident->created_at->format('M d, Y')); ?>

                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                        <?php if($incident->status === 'resolved'): ?> bg-green-100 text-green-800 border border-green-200
                                        <?php elseif($incident->status === 'investigating'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                                        <?php else: ?> bg-red-100 text-red-800 border border-red-200 <?php endif; ?>">
                                        <?php echo e(ucfirst($incident->status)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Recent Reservations Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                    <h4 class="text-lg font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Recent Reservations
                    </h4>
                </div>
                <div class="p-6">
                    <?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border-b border-gray-200 py-4 last:border-b-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <a href="<?php echo e(route('instructor.reservations.show', $reservation)); ?>" class="text-lg font-semibold text-gray-900 hover:text-red-600 transition-colors">
                                        <?php echo e($reservation->reservation_code); ?>

                                    </a>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Created: <?php echo e($reservation->created_at->format('M d, Y')); ?>

                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                        <?php if($reservation->status === 'approved'): ?> bg-green-100 text-green-800 border border-green-200
                                        <?php elseif($reservation->status === 'pending'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                                        <?php elseif($reservation->status === 'rejected'): ?> bg-red-100 text-red-800 border border-red-200
                                        <?php else: ?> bg-gray-100 text-gray-800 border border-gray-200 <?php endif; ?>">
                                        <?php echo e(ucfirst($reservation->status)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new reservation.</p>
                            <div class="mt-6">
                                <a href="<?php echo e(route('instructor.reservations.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Reservation
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    
    <!-- Custom Calendar Red Theme -->
    <style>
        .fc-theme-standard .fc-scrollgrid {
            border-color: #fecaca;
        }
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #fecaca;
        }
        .fc-theme-standard .fc-scrollgrid-sync-table {
            border-color: #fecaca;
        }
        .fc-daygrid-day-number {
            color: #7f1d1d;
            font-weight: 500;
        }
        .fc-daygrid-day-number:hover {
            color: #dc2626;
        }
        .fc-col-header-cell {
            background-color: #fef2f2;
            color: #7f1d1d;
            font-weight: 600;
        }
        .fc-day-today {
            background-color: #fef2f2 !important;
        }
        .fc-day-today .fc-daygrid-day-number {
            background-color: #dc2626;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2px;
        }
        .fc-button-primary {
            background-color: #dc2626;
            border-color: #dc2626;
        }
        .fc-button-primary:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
        }
        .fc-button-primary:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.25);
        }
        .fc-button-primary:disabled {
            background-color: #fca5a5;
            border-color: #fca5a5;
        }
        .fc-button-primary:not(:disabled):active {
            background-color: #991b1b;
            border-color: #991b1b;
        }
        .fc-toolbar-title {
            color: #7f1d1d;
            font-weight: 700;
        }
        .fc-event {
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .fc-event-title {
            font-weight: 600;
        }
    </style>
    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Dashboard Calendar
            const calendarEl = document.getElementById('dashboardCalendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 600,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                events: [
                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    {
                        id: '<?php echo e($reservation->id); ?>',
                        title: '<?php echo e($reservation->reservation_code); ?>',
                        start: '<?php echo e($reservation->borrow_date); ?>',
                        end: '<?php echo e($reservation->return_date); ?>',
                        allDay: true,
                        display: 'block',
                        backgroundColor: getStatusColor('<?php echo e($reservation->status); ?>'),
                        borderColor: getStatusColor('<?php echo e($reservation->status); ?>'),
                        textColor: '#ffffff',
                        extendedProps: {
                            status: '<?php echo e($reservation->status); ?>',
                            reason: '<?php echo e($reservation->reason); ?>',
                            items: <?php echo e($reservation->items->count()); ?>,
                            code: '<?php echo e($reservation->reservation_code); ?>',
                            url: '<?php echo e(route("instructor.reservations.show", $reservation)); ?>'
                        }
                    },
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                ],
                eventClick: function(info) {
                    // Open reservation details
                    window.location.href = info.event.extendedProps.url;
                },
                select: function(info) {
                    // Create new reservation with pre-selected dates
                    const startDate = info.startStr;
                    const endDate = info.endStr;
                    
                    // Redirect to create reservation with pre-filled dates
                    const url = new URL('<?php echo e(route("instructor.reservations.create")); ?>', window.location.origin);
                    url.searchParams.set('borrow_date', startDate);
                    url.searchParams.set('return_date', endDate);
                    
                    window.location.href = url.toString();
                },
                eventDidMount: function(info) {
                    // Add tooltip with reservation details
                    const tooltip = `${info.event.extendedProps.code} - ${info.event.extendedProps.status.toUpperCase()}\nReason: ${info.event.extendedProps.reason}\nItems: ${info.event.extendedProps.items}\nClick to view details`;
                    
                    info.el.setAttribute('title', tooltip);
                }
            });
            
            calendar.render();

            // Create reservation button
            document.getElementById('createReservationBtn').addEventListener('click', function() {
                window.location.href = '<?php echo e(route("instructor.reservations.create")); ?>';
            });
        });

        function getStatusColor(status) {
            switch(status) {
                case 'pending': return '#fbbf24'; // yellow
                case 'approved': return '#10b981'; // green
                case 'picked_up': return '#3b82f6'; // blue
                case 'returned': return '#6b7280'; // gray
                case 'denied': return '#ef4444'; // red
                case 'overdue': return '#dc2626'; // dark red
                case 'cancelled': return '#9ca3af'; // light gray
                case 'completed': return '#22c55e'; // emerald
                default: return '#6b7280';
            }
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show success modal if there's a success message
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            html: `
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4"><?php echo e(session('success')); ?></p>
                </div>
            `,
            confirmButtonText: 'OK',
            customClass: {
                popup: 'swal-custom-popup'
            }
        });
    <?php endif; ?>

    // Show error modal if there's an error message
    <?php if(session('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo e(session('error')); ?>',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'swal-custom-popup'
            }
        });
    <?php endif; ?>
});
</script>


<?php /**PATH C:\Users\Bryan\SEMS\SEMSv25\resources\views/instructor/dashboard.blade.php ENDPATH**/ ?>