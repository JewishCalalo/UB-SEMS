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
            <?php echo e(__('Reservation Management')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <style>
        .swal-custom-popup {
            border-radius: 12px !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }
        
        .equipment-checkbox {
            width: 20px !important;
            height: 20px !important;
            min-width: 20px !important;
            max-width: 20px !important;
            flex-shrink: 0 !important;
        }
        
        .equipment-quantity {
            width: 60px !important;
            min-width: 60px !important;
            max-width: 60px !important;
        }
        
        .approval-modal {
            display: none;
        }
        
        .approval-modal.show {
            display: flex;
        }
        
        .swal-custom-title {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: white !important;
            padding: 16px 24px !important;
            margin: -24px -24px 24px -24px !important;
            border-radius: 12px 12px 0 0 !important;
            font-size: 18px !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        
        .swal-custom-title::before {
            content: "✓" !important;
            background: rgba(255, 255, 255, 0.2) !important;
            border-radius: 50% !important;
            width: 24px !important;
            height: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 14px !important;
            font-weight: bold !important;
        }
        
        .swal-custom-confirm {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.2s ease !important;
        }
        
        .swal-custom-confirm:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 8px -1px rgba(0, 0, 0, 0.15) !important;
        }
        
        .swal-custom-cancel {
            background: #6b7280 !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 20px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            transition: all 0.2s ease !important;
        }
        
        .swal-custom-cancel:hover {
            background: #4b5563 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 8px -1px rgba(0, 0, 0, 0.15) !important;
        }
    </style>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Reservations']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Reservations']
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
                         <!-- Header -->
             <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                 <div class="flex justify-between items-center">
                     <div>
                         <h3 class="text-xl font-bold text-gray-900 mb-2">Manage All Reservations</h3>
                         <p class="text-gray-600">View, approve, and manage equipment reservations</p>
                     </div>
                     <div>
                         <a href="<?php echo e(route('reservation-management.create')); ?>" 
                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); transition: all 0.2s ease-in-out; display: inline-flex; align-items: center; gap: 8px;"
                            onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
                            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                             <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                             </svg>
                             Create New Reservation
                         </a>
                     </div>
                 </div>
             </div>

             <!-- Statistics Section -->
             <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4 mb-6">
                 <div class="bg-white border border-gray-200 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-gray-900"><?php echo e($totalReservations); ?></div>
                     <div class="text-sm text-gray-600">Total</div>
                 </div>
                 <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-yellow-700"><?php echo e($pendingReservations); ?></div>
                     <div class="text-sm text-yellow-600">Pending</div>
                 </div>
                 <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-green-700"><?php echo e($approvedReservations); ?></div>
                     <div class="text-sm text-green-600">Approved</div>
                 </div>
                 <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-blue-700"><?php echo e($pickedUpReservations); ?></div>
                     <div class="text-sm text-blue-600">Picked Up</div>
                 </div>
                 <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-gray-700"><?php echo e($returnedReservations); ?></div>
                     <div class="text-sm text-gray-600">Returned</div>
                 </div>
                 <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-purple-700"><?php echo e($completedReservations); ?></div>
                     <div class="text-sm text-purple-600">Completed</div>
                 </div>
                 <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-red-700"><?php echo e($overdueReservations); ?></div>
                     <div class="text-sm text-red-600">Overdue</div>
                 </div>
                 <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 text-center shadow-sm">
                     <div class="text-2xl font-bold text-gray-800"><?php echo e($cancelledReservations); ?></div>
                     <div class="text-sm text-gray-700">Cancelled</div>
                 </div>
             </div>

                         <!-- Main Content Area -->
             <div class="w-full">
                    <!-- Action Legend and Generate Report Button -->
                     <div class="flex flex-col space-y-4 mb-4">
                        <!-- Generate Report Button -->
                            <div>
                                   <button onclick="openReportModal()" 
               style="background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; transition: all 0.2s ease-in-out; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: none; cursor: pointer;"
               onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)'"
               onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                Generate Report
                                </button>
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
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-1" style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                         <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                         </svg>
                                     </div>
                                    <span class="text-sm text-gray-700">View Details</span>
                                    <p class="text-xs text-gray-500">Open reservation details and history.</p>
                                 </div>
                                <!-- Edit Reservation legend removed by request -->

                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-1" style="background: linear-gradient(to right, #1d4ed8, #1e40af); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                         <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                     </div>
                                    <span class="text-sm text-gray-700">Mark as Picked Up</span>
                                    <p class="text-xs text-gray-500">Confirm borrower picked up items.</p>
                                 </div>
                                 
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-1" style="background: linear-gradient(to right, #9333ea, #7c3aed); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                         <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                         </svg>
                                     </div>
                                    <span class="text-sm text-gray-700">Process Return</span>
                                    <p class="text-xs text-gray-500">Inspect and record returned equipment.</p>
                                 </div>
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-1" style="background: linear-gradient(to right, #4f46e5, #3730a3); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                         <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                         </svg>
                                     </div>
                                    <span class="text-sm text-gray-700">Mark as Completed</span>
                                    <p class="text-xs text-gray-500">Finalize reservation and free up instances.</p>
                                 </div>
                                 
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-1" style="background: linear-gradient(to right, #10b981, #059669); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                         <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                         </svg>
                                     </div>
                                    <span class="text-sm text-gray-700">Approve</span>
                                    <p class="text-xs text-gray-500">Approve request and allocate equipment.</p>
                                 </div>
                                 
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-1" style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                         <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                         </svg>
                                     </div>
                                    <span class="text-sm text-gray-700">Decline</span>
                                    <p class="text-xs text-gray-500">Reject request with a reason.</p>
                                 </div>
                                 
                                <div class="flex flex-col items-center text-center">
                                    <div class="mb-1" style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                         <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                         </svg>
                                     </div>
                                    <span class="text-sm text-gray-700">Cancel Reservation</span>
                                    <p class="text-xs text-gray-500">Cancel request and free allocated items.</p>
                                 </div>
                             </div>
                         </div>
                     </div>
                                         </div>
 
                     <!-- Search and Filters Toggle -->
                     <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-4">
                         <div class="p-4">
                             <div class="flex justify-between items-center">
                                 <h4 class="text-lg font-semibold text-gray-900">Search & Filter</h4>
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
                     </div>

                     <!-- Search and Filters Content -->
                     <div id="searchFilterContent" class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6" style="display: none;">
                         <div class="p-6">
                             <form method="GET" action="<?php echo e(route('reservation-management.index')); ?>" class="space-y-6">
                                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Status</label>
                                         <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Statuses</option>
                                             <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
                                             <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Approved</option>
                                             <option value="denied" <?php echo e(request('status') === 'denied' ? 'selected' : ''); ?>>Denied</option>
                                             <option value="picked_up" <?php echo e(request('status') === 'picked_up' ? 'selected' : ''); ?>>Picked Up</option>
                                             <option value="returned" <?php echo e(request('status') === 'returned' ? 'selected' : ''); ?>>Returned</option>
                                             <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                                             <option value="overdue" <?php echo e(request('status') === 'overdue' ? 'selected' : ''); ?>>Overdue</option>
                                             <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                                         </select>
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">User</label>
                                         <input type="text" name="user" value="<?php echo e(request('user')); ?>"
                                                placeholder="Name or email..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Reservation Code</label>
                                         <input type="text" name="reservation_code" value="<?php echo e(request('reservation_code')); ?>"
                                                placeholder="e.g. RES-MMJIYW5L..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                     </div>
                                     
                                    
                                     
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Date From</label>
                                        <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-semibold text-gray-700">Date To</label>
                                        <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
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
                                            <button type="button"
                                                    id="rmClearBtn"
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

            <script>
                (function(){
                    const form = document.querySelector('#searchFilterContent form');
                    const clearBtn = document.getElementById('rmClearBtn');
                    const content = document.getElementById('searchFilterContent');
                    const toggleText = document.getElementById('toggleText');
                    const toggleIcon = document.getElementById('toggleIcon');
                    if (!form) return;

                    // Persist toggle state like equipment-management
                    const toggleKey = 'rm_sf_open';
                    try {
                        const isOpen = localStorage.getItem(toggleKey) === '1';
                        if (isOpen && content && toggleText && toggleIcon) {
                            content.style.display = 'block';
                            toggleText.textContent = 'Hide';
                            toggleIcon.style.transform = 'rotate(180deg)';
                        }
                    } catch(e) {}

                    // Hook into the page's toggle button if present
                    window.toggleSearchFilter = (function(orig){
                        return function(){
                            if (content && (content.style.display === 'none' || content.style.display === '')) {
                                try { localStorage.setItem(toggleKey, '1'); } catch(e) {}
                            } else {
                                try { localStorage.setItem(toggleKey, '0'); } catch(e) {}
                            }
                            if (typeof orig === 'function') return orig.apply(this, arguments);
                        };
                    })(window.toggleSearchFilter);

                    if (clearBtn) {
                        clearBtn.addEventListener('click', function(){
                            resetForm();
                            // Ensure the panel stays open after refresh
                            try { localStorage.setItem(toggleKey, '1'); } catch(e) {}
                            submitAjax(new URL(form.action, window.location.origin));
                        });
                    }

                    // Intercept submit for AJAX-only refresh
                    form.addEventListener('submit', function(e){
                        e.preventDefault();
                        // Validate date range
                        const df = form.querySelector('input[name="date_from"]').value;
                        const dt = form.querySelector('input[name="date_to"]').value;
                        
                        // Check if Date To is filled without Date From
                        if (dt && !df) {
                            Swal.fire({
                                buttonsStyling: false,
                                html: `
                                    <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#f59e0b;">
                                        <h2 class="text-xl font-bold text-center">Invalid Date Selection</h2>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-gray-700">Date To cannot be used without Date From. Please select Date From first.</p>
                                    </div>
                                    <div class="flex justify-center mt-6">
                                        <button type="button" class="px-6 py-2 text-white rounded-lg" style="background:#f59e0b" onclick="Swal.close()">OK</button>
                                    </div>
                                `,
                                showConfirmButton: false,
                                customClass: { popup: 'swal-custom-popup' }
                            });
                            return;
                        }
                        
                        if (df && dt && df > dt) {
                            Swal.fire({
                                buttonsStyling: false,
                                html: `
                                    <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#f59e0b;">
                                        <h2 class="text-xl font-bold text-center">Invalid Date Range</h2>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-gray-700">Date From cannot be after Date To. Please adjust your dates.</p>
                                    </div>
                                    <div class="flex justify-center mt-6">
                                        <button type="button" class="px-6 py-2 text-white rounded-lg" style="background:#f59e0b" onclick="Swal.close()">OK</button>
                                    </div>
                                `,
                                showConfirmButton: false,
                                customClass: { popup: 'swal-custom-popup' }
                            });
                            return;
                        }
                        const url = new URL(form.action, window.location.origin);
                        const data = new FormData(form);
                        // Clean params first
                        url.search = '';
                        for (const [k,v] of data.entries()) { if (v) url.searchParams.set(k,v); }
                        submitAjax(url);
                    });

                    function resetForm(){
                        const inputs = form.querySelectorAll('input, select');
                        inputs.forEach(el => { if (el.tagName === 'SELECT') el.selectedIndex = 0; else el.value = ''; });
                        // Lock type if exists
                        const typeSelect = document.getElementById('equipmentTypeSelect');
                        const help = document.getElementById('equipmentTypeHelp');
                        if (typeSelect) typeSelect.disabled = true;
                        if (help) help.style.display = '';
                    }

                    function submitAjax(url){
                        const wrapper = document.getElementById('reservationTableWrapper');
                        fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(r=>r.text())
                            .then(html=>{
                                const doc = new DOMParser().parseFromString(html,'text/html');
                                const next = doc.querySelector('#reservationTableWrapper');
                                if (wrapper && next) wrapper.innerHTML = next.innerHTML;
                                window.history.replaceState({},'',url);
                                if (content && toggleText && toggleIcon) {
                                    content.style.display = 'block';
                                    toggleText.textContent = 'Hide';
                                    toggleIcon.style.transform = 'rotate(180deg)';
                                }
                            })
                            .catch(()=>{ if (form.requestSubmit) form.requestSubmit(); else form.submit(); });
                    }
                })();
            </script>

                         <!-- Conflict Notification Card -->
                         <?php if(!empty($conflicts)): ?>
                         <div class="mb-6">
                             <div class="bg-red-50 border-l-4 border-red-500 rounded-lg shadow-lg">
                                 <div class="p-4">
                                     <div class="flex items-start">
                                         <div class="mr-3">
                                             <div class="flex items-center justify-center w-8 h-8 bg-red-500 rounded-full">
                                                 <i class="fas fa-exclamation-triangle text-white"></i>
                                             </div>
                                         </div>
                                         <div class="flex-1">
                                             <h3 class="text-lg font-semibold text-red-900 mb-2">Reservation Conflict Detected</h3>
                                             <p class="text-sm text-red-700 mb-4">
                                                 Multiple reservations are competing for the same equipment during overlapping date ranges. The system has detected that the total requested quantity exceeds the available equipment for those specific dates. Review the conflicting reservations below and decide which ones to approve.
                                             </p>
                                             
                                             <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                                                 <h4 class="text-sm font-semibold text-red-800 mb-2">Why are these reservations conflicting?</h4>
                                                 <ul class="text-xs text-red-700 space-y-1">
                                                     <li>• Equipment instances are reserved for specific date ranges</li>
                                                     <li>• When dates overlap, the same instances cannot be used by multiple reservations</li>
                                                     <li>• The total requested quantity exceeds the available instances for the overlapping period</li>
                                                     <li>• You must approve or decline conflicting reservations to resolve the conflict</li>
                                                 </ul>
                                             </div>

                                             <div class="space-y-3">
                                                 <?php $__currentLoopData = $conflicts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conflict): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <div class="bg-white border border-red-200 rounded-lg p-3">
                                                         <div class="flex items-center justify-between mb-2">
                                                             <div>
                                                                 <h4 class="font-medium text-gray-900"><?php echo e($conflict['equipment']->display_name); ?></h4>
                                                                 <p class="text-xs text-gray-500"><?php echo e(optional($conflict['equipment']->category)->name); ?> • <?php echo e(optional($conflict['equipment']->equipmentType)->name); ?></p>
                                                                 <p class="text-xs text-gray-500">Total instances: <?php echo e($conflict['equipment']->quantity_total); ?></p>
                                                             </div>
                                                             <div class="text-right">
                                                                 <div class="text-sm font-medium text-red-600"><?php echo e($conflict['available']); ?> available for overlapping dates</div>
                                                                 <div class="text-xs text-gray-500"><?php echo e(count($conflict['reservations'])); ?> conflicting requests</div>
                                                                 <?php
                                                                     $totalRequested = array_sum(array_column($conflict['reservations'], 'quantity'));
                                                                 ?>
                                                                 <div class="text-xs text-red-600 font-medium"><?php echo e($totalRequested); ?> total requested</div>
                                                             </div>
                                                         </div>
                                                         
                                                         <div class="space-y-2">
                                                             <?php $__currentLoopData = $conflict['reservations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                 <?php $r = $entry['reservation']; ?>
                                                                 <div class="flex items-center justify-between text-sm bg-yellow-50 border border-yellow-200 rounded px-3 py-2">
                                                                     <div class="flex items-center space-x-3">
                                                                         <span class="font-medium text-gray-900"><?php echo e($r->reservation_code); ?></span>
                                                                         <span class="text-gray-600"><?php echo e($r->user->name ?? $r->name); ?></span>
                                                                         <span class="text-gray-500"><?php echo e(\Carbon\Carbon::parse($entry['borrow_date'])->format('M d')); ?> - <?php echo e(\Carbon\Carbon::parse($entry['return_date'])->format('M d')); ?></span>
                                                                         <span class="px-2 py-1 text-xs rounded-full <?php echo e($r->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($r->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800')); ?>">
                                                                             <?php echo e(ucfirst($r->status)); ?>

                                                                         </span>
                                                                     </div>
                                                                     <div class="text-right">
                                                                         <div class="font-medium text-red-600"><?php echo e($entry['quantity']); ?> items</div>
                                                                         <?php if($r->status === 'approved'): ?>
                                                                             <div class="text-xs text-green-600">Already approved</div>
                                                                         <?php else: ?>
                                                                             <div class="text-xs text-yellow-600">Awaiting approval</div>
                                                                         <?php endif; ?>
                                                                     </div>
                                                                 </div>
                                                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                         </div>
                                                     </div>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <?php endif; ?>

                         <!-- Reservations Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm" id="reservationTableWrapper">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                         <i class="fas fa-table mr-2 text-gray-600"></i>
                         Reservations List
                     </h4>
                    <?php if($reservations->count() > 0): ?>
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
                                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Reservation</th>
                                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Items</th>
                                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                        <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gray-50 <?php echo e(in_array($reservation->id, $conflictingReservationIds ?? []) ? 'bg-yellow-50 border-l-4 border-yellow-400' : ($reservation->user && $reservation->user->role === 'instructor' ? 'bg-blue-50 border-l-4 border-blue-500' : '')); ?>">
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 align-top text-sm">
                                                <div class="space-y-1">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="text-xs text-gray-500"><?php echo e($reservation->created_at->format('M d, Y H:i')); ?></span>
                                                        <?php if(in_array($reservation->id, $conflictingReservationIds ?? [])): ?>
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                Conflict
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-900"><?php echo e($reservation->reservation_code); ?></div>
                                                    <?php if($reservation->user && $reservation->user->role === 'instructor'): ?>
                                                        <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                                            <i class="fas fa-chalkboard-teacher mr-1"></i>
                                                            Instructor Priority
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="text-xs text-gray-700">
                                                        <?php if($reservation->createdBy && !$reservation->user): ?>
                                                            <span class="font-medium">PE Staff:</span> <?php echo e($reservation->name ?? 'Unknown'); ?>

                                                            <div class="text-xs text-gray-500 mt-1">
                                                                <span class="font-medium">Created by:</span> <?php echo e($reservation->createdBy->name); ?> (<?php echo e(ucfirst($reservation->createdBy->role)); ?>)
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="font-medium">User:</span>
                                                            <?php
                                                                $rName = $reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User');
                                                                $rEmail = $reservation->user ? $reservation->user->email : ($reservation->email ?? '');
                                                            ?>
                                                            <?php echo e($rName); ?> <?php if($rEmail): ?> (<?php echo e($rEmail); ?>) <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="text-xs text-gray-700 space-y-1">
                                                        <div>
                                                            <span class="font-medium">From:</span> <?php echo e($reservation->borrow_date->format('M d, Y')); ?>

                                                            <?php if($reservation->borrow_time): ?>
                                                                <span class="text-gray-600">(<?php echo e($reservation->borrow_time); ?>)</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div>
                                                            <span class="font-medium">To:</span> <?php echo e($reservation->return_date->format('M d, Y')); ?>

                                                            <?php if($reservation->return_time): ?>
                                                                <span class="text-gray-600">(<?php echo e($reservation->return_time); ?>)</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 align-top text-sm whitespace-nowrap">
                                                <?php
                                                    $totalQuantity = $reservation->items->sum(function ($item) { 
                                                        $requested = (int) ($item->quantity_requested ?? 0);
                                                        $instances = $item->reservationItemInstances?->count() ?? 0;
                                                        return max($requested, $instances);
                                                    });
                                                    $totalEquipment = $reservation->items->count();
                                                ?>
                                                <div class="space-y-1">
                                                    <div class="text-sm font-medium text-gray-900"><?php echo e($totalQuantity); ?> item(s) requested</div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php echo e($totalEquipment); ?> equipment type(s)
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        <?php $__currentLoopData = $reservation->items->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($item->equipment->name); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($reservation->items->count() > 2): ?>
                                                            +<?php echo e($reservation->items->count() - 2); ?> more
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-center align-top">
                                                <div class="flex justify-start items-center">
                                                <?php
                                                    // Check for real-time overdue status
                                                    $isOverdue = $reservation->isOverdue();
                                                    $displayStatus = $reservation->status;
                                                    
                                                    if ($isOverdue && $reservation->status === 'picked_up') {
                                                        $displayStatus = 'overdue';
                                                    }
                                                    
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                                        'approved' => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                                        'denied' => 'bg-red-100 text-red-800 border border-red-200',
                                                        'picked_up' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                                        'returned' => 'bg-purple-100 text-purple-800 border border-purple-200',
                                                        'completed' => 'bg-green-100 text-green-800 border border-green-200',
                                                        'overdue' => 'bg-red-100 text-red-800 border border-red-200',
                                                        'cancelled' => 'bg-gray-100 text-gray-600 border border-gray-200'
                                                    ];
                                                    $statusColor = $statusColors[$displayStatus] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
                                                ?>
                                                    <span class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-full <?php echo e($statusColor); ?> shadow-sm min-w-[80px] text-center status-display" data-reservation-id="<?php echo e($reservation->id); ?>">
                                                    <?php if($isOverdue && $reservation->status === 'picked_up'): ?>
                                                        <span class="flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Overdue
                                                        </span>
                                                    <?php else: ?>
                                                        <?php echo e(ucfirst(str_replace('_', ' ', $displayStatus))); ?>

                                                    <?php endif; ?>
                                                </span>
                                                </div>
                                            </td>
                                            <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium align-top">
                                                <div class="flex items-center space-x-2">
                                                    <a href="<?php echo e(route('reservation-management.show', $reservation)); ?>" 
                                                       style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                       onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                       onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                       title="View Details">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    
                                                    <?php if($reservation->status === 'pending'): ?>
                                                        <!-- Approve Button -->
                                                        <button type="button" 
                                                                id="approve_btn_<?php echo e($reservation->id); ?>"
                                                                onclick="showApproveConfirmation('<?php echo e($reservation->id); ?>', <?php echo e(json_encode($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User'))); ?>, <?php echo e(json_encode($reservation->reservation_code)); ?>, '<?php echo e($reservation->borrow_date); ?>', '<?php echo e($reservation->return_date); ?>')"
                                                                style="background: linear-gradient(to right, #10b981, #059669); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; cursor: pointer;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Approve">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                        
                                                        <!-- Decline Button -->
                                                        <button type="button" 
                                                                id="decline_btn_<?php echo e($reservation->id); ?>"
                                                                onclick="showDeclineConfirmation('<?php echo e($reservation->id); ?>', <?php echo e(json_encode($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User'))); ?>, <?php echo e(json_encode($reservation->reservation_code)); ?>)"
                                                                style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; cursor: pointer;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Decline">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                        
                                                        <!-- Hidden forms for submission -->
                                                        <form id="approveForm_<?php echo e($reservation->id); ?>" method="POST" action="<?php echo e(route('reservation-management.approve', $reservation)); ?>" class="hidden">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="pickup_date" id="pickup_date_<?php echo e($reservation->id); ?>">
                                                            <input type="hidden" name="return_date" id="return_date_<?php echo e($reservation->id); ?>">
                                                            <input type="hidden" name="remarks" id="remarks_<?php echo e($reservation->id); ?>">
                                                        </form>
                                                        
                                                        <form id="declineForm_<?php echo e($reservation->id); ?>" method="POST" action="<?php echo e(route('reservation-management.decline', $reservation)); ?>" class="hidden">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="remarks" id="decline_remarks_<?php echo e($reservation->id); ?>">
                                                        </form>
                                                    <?php endif; ?>
                                                    <?php if($reservation->status === 'approved'): ?>
                                                        <?php if($reservation->createdBy && !$reservation->user): ?>
                                                            <!-- Quick Mark as Picked Up Button (PE Staff) -->
                                                            <a href="<?php echo e(route('equipment-pickup.pickup-form', $reservation)); ?>" 
                                                                    onclick="event.preventDefault(); showMarkPickedUpConfirmation('<?php echo e($reservation->id); ?>', <?php echo e(json_encode($reservation->createdBy?->name ?? ($reservation->user?->name ?? 'Guest User'))); ?>, <?php echo e(json_encode($reservation->reservation_code)); ?>, 'pe_staff');"
                                                                    style="background: linear-gradient(to right, #1d4ed8, #1e40af); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                                    onmouseover="this.style.background='linear-gradient(to right, #1e40af, #1e3a8a)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                    onmouseout="this.style.background='linear-gradient(to right, #1d4ed8, #1e40af)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                    title="Mark as In Use (PE Class)">
                                                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </a>
                                                        <?php else: ?>
                                                            <!-- Quick Mark as Picked Up Button (User) -->
                                                            <a href="<?php echo e(route('equipment-pickup.pickup-form', $reservation)); ?>" 
                                                                    onclick="event.preventDefault(); showMarkPickedUpConfirmation('<?php echo e($reservation->id); ?>', <?php echo e(json_encode($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User'))); ?>, <?php echo e(json_encode($reservation->reservation_code)); ?>, 'user');"
                                                                    style="background: linear-gradient(to right, #1d4ed8, #1e40af); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                                    onmouseover="this.style.background='linear-gradient(to right, #1e40af, #1e3a8a)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                    onmouseout="this.style.background='linear-gradient(to right, #1d4ed8, #1e40af)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                    title="Mark as Picked Up">
                                                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </a>
                                                        <?php endif; ?>
                                                        
                                                        <!-- Cancel Button for Approved Reservations -->
                                                        <button type="button" 
                                                                id="cancel_btn_<?php echo e($reservation->id); ?>"
                                                                onclick="showCancelConfirmation('<?php echo e($reservation->id); ?>', <?php echo e(json_encode($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User'))); ?>, <?php echo e(json_encode($reservation->reservation_code)); ?>)"
                                                                style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; cursor: pointer;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Cancel Reservation">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </button>
                                                        
                                                        <!-- Hidden form for cancellation -->
                                                        <form id="cancelForm_<?php echo e($reservation->id); ?>" method="POST" action="<?php echo e(route('reservation-management.cancel', $reservation)); ?>" class="hidden">
                                                            <?php echo csrf_field(); ?>
                                                            <input type="hidden" name="remarks" id="cancel_remarks_<?php echo e($reservation->id); ?>">
                                                        </form>
                                                    <?php endif; ?>
                                                    <?php if($reservation->status === 'picked_up'): ?>
                                                        <!-- Process Return Button -->
                                                        <a href="<?php echo e(route('equipment-returns.return-form', $reservation)); ?>" 
                                                           style="background: linear-gradient(to right, #9333ea, #7c3aed); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                           onmouseover="this.style.background='linear-gradient(to right, #7c3aed, #6d28d9)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                           onmouseout="this.style.background='linear-gradient(to right, #9333ea, #7c3aed)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                           title="Process Return">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                            </svg>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if($reservation->status === 'returned'): ?>
                                                        <button type="button" 
                                                                id="complete_btn_<?php echo e($reservation->id); ?>"
                                                                onclick="showMarkCompletedConfirmation('<?php echo e($reservation->id); ?>', <?php echo e(json_encode($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User'))); ?>, <?php echo e(json_encode($reservation->reservation_code)); ?>)"
                                                                style="background: linear-gradient(to right, #4f46e5, #3730a3); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; cursor: pointer;"
                                                                onmouseover="this.style.background='linear-gradient(to right, #3730a3, #312e81)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                                onmouseout="this.style.background='linear-gradient(to right, #4f46e5, #3730a3)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                                title="Mark as Completed">
                                                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </button>
                                                        
                                                        <!-- Hidden form for submission -->
                                                        <form id="markCompletedForm_<?php echo e($reservation->id); ?>" method="POST" action="<?php echo e(route('reservation-management.update', $reservation)); ?>" class="hidden">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <input type="hidden" name="status" value="completed">
                                                        </form>
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
                            <?php echo e($reservations->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Show success message if redirected with success parameter
        <?php if(session('success')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Success!</h2>
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
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105 border-0" onclick="Swal.close()">
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
            });
        <?php endif; ?>

        // Show error message if redirected with error parameter
        <?php if(session('error')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '<?php echo e(session('error')); ?>',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            });
        <?php endif; ?>

        // Dynamic equipment type filtering
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('filter_category');
            const equipmentTypeSelect = document.getElementById('filter_equipment_type');
            
            if (categorySelect && equipmentTypeSelect) {
                categorySelect.addEventListener('change', function() {
                    const categoryId = this.value;
                    equipmentTypeSelect.innerHTML = '<option value="">All Types</option>';
                    
                    if (categoryId) {
                        fetch(`/equipment-types/by-category/${categoryId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(type => {
                                    const option = document.createElement('option');
                                    option.value = type.id;
                                    option.textContent = type.name;
                                    equipmentTypeSelect.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching equipment types:', error);
                            });
                    }
                });
                
                // Trigger change event if category is pre-selected
                if (categorySelect.value) {
                    categorySelect.dispatchEvent(new Event('change'));
                }
            }
        });



                 // Search & Filter Toggle Function
         // Search and Filter Toggle Function - using shared component
         function toggleSearchFilter() {
             ManagementCommon.toggleSearchFilter();
         }

         // Action Legend Toggle Function - using shared component
         function toggleActionLegend() {
             ManagementCommon.toggleActionLegend();
         }
         
         // Report Modal Functions - using shared component
         function openReportModal() {
            Swal.fire({
                buttonsStyling: false,
                html: `
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Generate Reservation Report</h2>
                    </div>
                    <form id="resReportForm" method="GET" action="<?php echo e(route('reservation-management.generate-pdf')); ?>" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                            <select name="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="all">All Reservations</option>
                                <option value="pending">Pending Reservations</option>
                                <option value="approved">Approved Reservations</option>
                                <option value="picked_up">Picked Up Reservations</option>
                                <option value="cancelled">Cancelled Reservations</option>
                                <option value="declined">Declined Reservations</option>
                                <option value="overdue">Overdue Reservations</option>
                                <option value="completed">Completed Reservations</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                <input type="date" name="date_from" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                <input type="date" name="date_to" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                                <option value="csv">CSV File</option>
                            </select>
                        </div>
                    </form>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">Cancel</button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105" onclick="(function(){ const f=document.getElementById('resReportForm'); const params=new URLSearchParams(new FormData(f)).toString(); const fmt=new FormData(f).get('format'); const base = fmt==='excel' ? '<?php echo e(route('reservation-management.export-excel')); ?>' : '<?php echo e(route('reservation-management.generate-pdf')); ?>'; window.open(base + (params ? ('?' + params) : ''), '_blank'); })()">Generate Report</button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '700px',
                customClass: { popup: 'swal-custom-popup' }
            });
         }


        


    </script>



    <script>
        // Mark as Picked Up Confirmation Modal
        function showMarkPickedUpConfirmation(reservationId, userName, reservationCode, reservationType = 'user') {
            const isPEStaff = reservationType === 'pe_staff';
            const title = isPEStaff ? 'Mark as In Use?' : 'Mark as Picked Up?';
            const message = isPEStaff 
                ? `Are you sure you want to mark reservation <strong>${reservationCode}</strong> for <strong>${userName}</strong> as in use? This indicates the PE class is currently using the equipment.`
                : `Are you sure you want to mark reservation <strong>${reservationCode}</strong> for <strong>${userName}</strong> as picked up? This will assign equipment instances and cannot be undone easily.`;
            const confirmText = isPEStaff ? 'Yes, mark as in use!' : 'Yes, mark as picked up!';
            const loadingText = isPEStaff ? 'Marking as In Use...' : 'Marking as Picked Up...';
            const successTitle = isPEStaff ? 'Equipment In Use!' : 'Pickup Confirmed!';
            const successMessage = isPEStaff 
                ? 'The PE class equipment is now marked as in use.'
                : 'The reservation has been marked as picked up successfully.';
            const errorMessage = isPEStaff 
                ? `Failed to mark reservation ${reservationCode} as in use. Please try again.`
                : `Failed to mark reservation ${reservationCode} as picked up. Please try again.`;
            
            // Fetch reservation dates to check early pickup
            fetch(`/reservation-management/${reservationId}/approval-data`)
                .then(r => r.ok ? r.json() : Promise.reject(new Error('Failed to load reservation data')))
                .then(data => {
                    try {
                        // Prefer ISO date; fall back to plain date if necessary
                        // Prefer a full ISO datetime if the API exposes it; otherwise compose from date + time
                        const borrowDateTimeIso = data?.reservation?.borrow_datetime_iso || null;
                        const borrowDateIso = data?.reservation?.borrow_date_iso || data?.reservation?.borrow_date || null;
                        const borrowTime = data?.reservation?.borrow_time || null;
                        const now = new Date();

                        let shouldWarn = false;
                        if (borrowDateTimeIso) {
                            // Use server-provided ISO datetime directly
                            const borrowStart = new Date(borrowDateTimeIso);
                            if (borrowStart instanceof Date && !isNaN(borrowStart)) {
                                shouldWarn = now < borrowStart;
                            }
                        } else if (borrowDateIso) {
                            const dateOnly = new Date(`${borrowDateIso}T00:00:00`);
                            const nowDateOnly = new Date(now.getFullYear(), now.getMonth(), now.getDate());

                            // If the borrow date is in the future, warn regardless of time
                            if (dateOnly > nowDateOnly) {
                                shouldWarn = true;
                            } else if (dateOnly.getTime() === nowDateOnly.getTime() && borrowTime) {
                                // Same day with a borrow time specified: warn if current time is earlier than borrow time
                                const borrowStart = new Date(`${borrowDateIso}T${borrowTime}:00`);
                                if (borrowStart && !isNaN(borrowStart.getTime()) && now < borrowStart) {
                                    shouldWarn = true;
                                }
                            }
                        }

                        if (shouldWarn) {
                            // Show orange themed early pickup reminder
                            Swal.fire({
                                icon: false,
                                buttonsStyling: false,
                                width: '560px',
                                customClass: { popup: 'swal-custom-popup' },
                                html: `
                                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                                        <h2 class="text-xl font-bold text-center">Early Pickup Warning</h2>
                                    </div>
                                    <div class="text-left space-y-3">
                                        <p class="text-gray-700">This reservation is scheduled to start on <strong>${(data?.reservation?.borrow_date_display || data?.reservation?.borrow_date || '—')}${data?.reservation?.borrow_time ? ' at ' + data.reservation.borrow_time : ''}</strong>.</p>
                                        <p class="text-gray-700">You're about to mark it as picked up earlier than scheduled.</p>
                                        <div class="rounded-md bg-amber-50 border border-amber-200 p-3 text-amber-800 text-sm">
                                            Recommendation: Proceed only if the user is present and equipment release is authorized ahead of schedule.
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mt-5 gap-3">
                                        <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600" onclick="Swal.close()">Go Back</button>
                                        <button type="button" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg hover:from-amber-600 hover:to-orange-700" id="proceedEarlyPickupBtn">Proceed anyway</button>
                                    </div>
                                `,
                                showConfirmButton: false,
                                showCancelButton: false,
                                didOpen: () => {
                                    const btn = document.getElementById('proceedEarlyPickupBtn');
                    if (btn) {
                        btn.addEventListener('click', () => {
                            Swal.close();
                            // Redirect straight to pickup form after acknowledging warning
                            window.location.href = `<?php echo e(route('equipment-pickup.pickup-form', ':id')); ?>`.replace(':id', reservationId);
                        });
                    }
                                }
                            });
                        } else {
            // Not early pickup: go straight to pickup form
            window.location.href = `<?php echo e(route('equipment-pickup.pickup-form', ':id')); ?>`.replace(':id', reservationId);
                        }
                    } catch (_) {
                        // Fallback gracefully
                        renderPickupModal();
                    }
                })
                .catch(() => {
                    // If fetch fails, continue with normal modal
                    renderPickupModal();
                });

            function renderPickupModal() {
                // Redirect to the dedicated pickup form; no green confirmation modal
                window.location.href = `<?php echo e(route('equipment-pickup.pickup-form', ':id')); ?>`.replace(':id', reservationId);
            }
        }



        // Mark as Completed Confirmation Modal
        function showMarkCompletedConfirmation(reservationId, userName, reservationCode) {
            // Get current date and time for display
            const now = new Date();
            const currentDateTime = now.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            Swal.fire({
                html: `
                    <div class="bg-gradient-to-r from-emerald-600 to-green-700 text-white p-6 -m-6 mb-6 rounded-t-lg">
                        <div class="flex flex-col items-center text-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto">
                                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h2 class="text-2xl font-bold">Mark as Completed</h2>
                                <p class="text-emerald-100 text-sm mt-1">Finalize this reservation and update its status</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Reservation Details Card (icon removed, centered) -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-5">
                            <div class="flex items-start justify-center">
                                <div class="flex-1 text-center">
                                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Reservation Details</h3>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-700 mr-2">Code:</span>
                                            <span class="text-sm font-mono bg-blue-100 text-blue-800 px-2 py-1 rounded">${reservationCode}</span>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-700 mr-2">User:</span>
                                            <span class="text-sm font-semibold text-blue-900">${userName}</span>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-700 mr-2">Date:</span>
                                            <span class="text-sm text-blue-800">${currentDateTime}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Details Card (icon removed, centered) -->
                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-5">
                            <div class="flex items-start justify-center text-center">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-amber-900 mb-2">What happens next?</h3>
                                    <ul class="space-y-2 text-sm text-amber-800">
                                        <li>Equipment instances will be marked as available</li>
                                        <li>Reservation status will be updated to "Completed"</li>
                                        <li>User will receive completion notification</li>
                                        <li>This action cannot be undone</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks Input -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <svg class="w-4 h-4 text-gray-500 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Completion Remarks <span class="text-gray-400 ml-1">(Optional)</span>
                            </label>
                            <textarea id="completion_remarks" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200 text-gray-700 resize-none" rows="3" placeholder="Add any final remarks about this reservation completion..."></textarea>
                        </div>
                    </div>
                `,
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: '✓ Mark as Completed',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                width: '1200px',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm',
                    cancelButton: 'swal-custom-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Use AJAX with loading states
                    const buttonId = `complete_btn_${reservationId}`;
                    
                    // Get remarks from textarea
                    const remarks = document.getElementById('completion_remarks')?.value || '';
                    
                    // Show loading modal
                    Swal.fire({
                        title: 'Marking as Completed...',
                        text: 'Please wait while we process your request.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Make AJAX request
                    fetch(`<?php echo e(route('reservation-management.mark-completed', ':id')); ?>`.replace(':id', reservationId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            remarks: remarks
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close(); // Close loading modal
                        
                        if (data.success) {
                            // Show beautiful success modal
                            Swal.fire({
                                html: `
                                    <div class="bg-gradient-to-r from-green-600 to-emerald-700 text-white p-6 -m-6 mb-6 rounded-t-lg">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <h2 class="text-3xl font-bold">Reservation Completed!</h2>
                                                <p class="text-green-100 text-lg mt-1">Successfully finalized the reservation</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <h3 class="text-lg font-semibold text-green-900">What was completed:</h3>
                                                    <ul class="mt-2 space-y-1 text-sm text-green-800">
                                                        <li class="flex items-center">
                                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Reservation ${reservationCode} status updated to "Completed"
                                                        </li>
                                                        <li class="flex items-center">
                                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            Equipment instances marked as available
                                                        </li>
                                                        <li class="flex items-center">
                                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            User notification sent to ${userName}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm text-blue-800">
                                                        <strong>${data.message || 'The reservation has been marked as completed successfully.'}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `,
                                showConfirmButton: true,
                                showCancelButton: false,
                                confirmButtonText: '✓ Great!',
                                confirmButtonColor: '#10b981',
                                width: '600px',
                                customClass: {
                                    popup: 'swal-custom-popup',
                                    confirmButton: 'swal-custom-confirm'
                                }
                            }).then(() => {
                                // Reload page after successful completion
                                window.location.reload();
                            });
                        } else {
                            // Show error modal
                            Swal.fire({
                                icon: 'error',
                                title: 'Completion Failed',
                                text: data.message || `Failed to mark reservation ${reservationCode} as completed. Please try again.`,
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.close(); // Close loading modal
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Completion Failed',
                            text: `Failed to mark reservation ${reservationCode} as completed. Please try again.`,
                            confirmButtonColor: '#dc2626'
                        });
                    });
                }
            });
        }

        // Validate pickup date function
        function validatePickupDate(input, borrowDateObj, returnDateObj) {
            const pickupDateObj = new Date(input.value);
            const errorMessage = input.parentNode.querySelector('.pickup-date-error');
            const errorText = errorMessage ? errorMessage.querySelector('.error-text') : null;
            
            if (input.value) {
                // Normalize dates to compare only date parts (set time to 00:00:00)
                const pickupDate = new Date(pickupDateObj.getFullYear(), pickupDateObj.getMonth(), pickupDateObj.getDate());
                const borrowDate = new Date(borrowDateObj.getFullYear(), borrowDateObj.getMonth(), borrowDateObj.getDate());
                const returnDate = new Date(returnDateObj.getFullYear(), returnDateObj.getMonth(), returnDateObj.getDate());
                
                if (pickupDate < borrowDate || pickupDate > returnDate) {
                    input.classList.add('border-red-500');
                    input.classList.remove('border-green-500');
                    if (errorMessage && errorText) {
                        errorText.textContent = 'Pickup date must be between borrow date and return date';
                        errorMessage.classList.remove('hidden');
                    }
                    return false;
                } else {
                    input.classList.remove('border-red-500');
                    input.classList.add('border-green-500');
                    if (errorMessage) {
                        errorMessage.classList.add('hidden');
                    }
                    return true;
                }
            } else {
                input.classList.remove('border-red-500', 'border-green-500');
                if (errorMessage) {
                    errorMessage.classList.add('hidden');
                }
                return false;
            }
        }

        // Global variables to store dates for approval
        let currentBorrowDate = '';
        let currentReturnDate = '';
        // Conflicting reservation ids for front-end checks
        const conflictingReservationIds = <?php echo json_encode($conflictingReservationIds ?? [], 15, 512) ?>;

        // Approve Confirmation Modal
        function showApproveConfirmation(reservationId, userName, reservationCode, borrowDate, returnDate) {
            // Store dates globally for use in approveReservation function
            currentBorrowDate = borrowDate;
            currentReturnDate = returnDate;
            
            // Store reservation ID for later use
            window.currentReservationId = reservationId;
            console.log('Setting currentReservationId to:', reservationId);
            
            // If this reservation is in conflict, show an orange reminder modal first
            if (Array.isArray(conflictingReservationIds) && conflictingReservationIds.includes(parseInt(reservationId))) {
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    width: '560px',
                    customClass: { popup: 'swal-custom-popup' },
                    html: `
                        <div class="bg-gradient-to-r from-amber-500 to-orange-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                            <h2 class="text-xl font-bold text-center">Reservation Conflict Detected</h2>
                        </div>
                        <div class="text-left space-y-3">
                            <p class="text-gray-700">Reservation <strong>${reservationCode}</strong> has overlapping dates with other reservations for some equipment.</p>
                            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                                <li>Approving this request may require declining the overlapping one(s).</li>
                                <li>Review quantities and availability before finalizing.</li>
                            </ul>
                            <div class="rounded-md bg-amber-50 border border-amber-200 p-3 text-amber-800 text-sm">
                                Recommendation: If you approve this reservation, consider declining the conflicting reservation(s) to free up equipment.
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-5 gap-3">
                            <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600" onclick="Swal.close()">Go Back</button>
                            <button type="button" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg hover:from-amber-600 hover:to-orange-700" id="proceedConflictApprove">Proceed anyway</button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    didOpen: () => {
                        const btn = document.getElementById('proceedConflictApprove');
                        if (btn) {
                            btn.addEventListener('click', () => {
                                Swal.close();
                                // continue to approval flow
                                loadApprovalDataAndOpenModal(reservationId);
                            });
                        }
                    }
                });
                return; // Stop here; continue only after proceed
            }

            // No conflict – continue directly
            loadApprovalDataAndOpenModal(reservationId);
        }

        // Extracted loader to allow reuse after conflict confirmation
        function loadApprovalDataAndOpenModal(reservationId) {
            // Show loading modal first
            Swal.fire({
                title: 'Loading Equipment Data...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Fetch approval data
            fetch(`/reservation-management/${reservationId}/approval-data`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Close loading modal
                        Swal.close();
                        
                        // Populate reservation information
                        document.getElementById('approvalReservationCode').textContent = data.reservation.reservation_code;
                        document.getElementById('approvalUserName').textContent = data.reservation.user_name;
                        
                        // Format dates with time information
                        let borrowDateText = data.reservation.borrow_date;
                        if (data.reservation.borrow_time) {
                            borrowDateText += ` at ${data.reservation.borrow_time}`;
                        }
                        document.getElementById('approvalBorrowDate').textContent = borrowDateText;
                        
                        let returnDateText = data.reservation.return_date;
                        if (data.reservation.return_time) {
                            returnDateText += ` at ${data.reservation.return_time}`;
                        }
                        document.getElementById('approvalReturnDate').textContent = returnDateText;
                        
                        // Generate equipment table
                        if (data.equipment && data.equipment.length > 0) {
                            generateApprovalEquipmentTable(data.equipment);
                        } else {
                            document.getElementById('approvalEquipmentTable').innerHTML = '<div class="p-4 text-center text-gray-500">No equipment data available</div>';
                        }
                        
                        // Set pickup date
                        const pickupDateInput = document.getElementById('pickupDateInput');
                        const today = new Date().toISOString().split('T')[0];
                        const borrowDate = new Date(data.reservation.borrow_date_iso).toISOString().split('T')[0];
                        const returnDate = new Date(data.reservation.return_date_iso).toISOString().split('T')[0];
                        
                        if (borrowDate === returnDate) {
                            // Same-day reservation
                            pickupDateInput.value = borrowDate;
                            pickupDateInput.disabled = true;
                            pickupDateInput.style.backgroundColor = '#f3f4f6';
                            pickupDateInput.style.cursor = 'not-allowed';
                            document.getElementById('sameDayNote').classList.remove('hidden');
                        } else {
                            // Multi-day reservation
                            pickupDateInput.min = today;
                            pickupDateInput.max = returnDate;
                            pickupDateInput.value = borrowDate;
                            pickupDateInput.disabled = false;
                            pickupDateInput.style.backgroundColor = '';
                            pickupDateInput.style.cursor = '';
                            document.getElementById('sameDayNote').classList.add('hidden');
                        }
                        
                        // Show modal with animation
                        const modal = document.getElementById('approvalModal');
                        const modalContent = document.getElementById('approvalModalContent');
                        modal.classList.add('show');
                        modalContent.style.transform = 'scale(1)';
                        modalContent.style.opacity = '1';
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to load equipment data'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading equipment data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load equipment data. Please try again.'
                    });
                });
        }
        
        // Enhanced Approve Modal with Equipment Management
        function showEnhancedApproveModal(reservationId) {
            // Store reservation ID for later use
            window.currentReservationId = reservationId;
            
            // Use the new modal instead of SweetAlert2
            showApprovalModal(reservationId);
        }
        
        // Old function - keeping for reference but not used
        /*function showEnhancedApproveModalOld(equipmentData, reservation) {
            // Build equipment table HTML
            let equipmentTableHtml = `
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 45%;">Equipment</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 12%;">Requested</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 12%;">Available</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 12%;">Approve</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 19%;">Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
            `;
            
            equipmentData.forEach((equipment, index) => {
                const isAvailable = equipment.is_available;
                const maxAvailable = equipment.quantity_available;
                const requestedQty = equipment.quantity_requested;
                
                equipmentTableHtml += `
                    <tr class="${!isAvailable ? 'bg-red-50' : 'hover:bg-gray-50'}">
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-gray-900">${equipment.equipment_name}</div>
                                <div class="text-sm text-gray-500">${equipment.category} • ${equipment.equipment_type}</div>
                                ${!isAvailable ? `
                                    <div class="text-xs text-red-600 mt-1 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        Not Available
                                    </div>
                                ` : ''}
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">${requestedQty}</span>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm">${maxAvailable}</span>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <div class="flex justify-center">
                                <input type="checkbox" 
                                       id="equipment_${equipment.item_id}_enabled" 
                                       class="equipment-checkbox text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                       ${!isAvailable ? 'disabled' : 'checked'}
                                       onchange="toggleEquipmentQuantity(${equipment.item_id}, this.checked)">
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <input type="number" 
                                       id="equipment_${equipment.item_id}_quantity" 
                                       class="equipment-quantity px-2 py-1 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       min="0" 
                                       max="${maxAvailable}"
                                       value="${isAvailable ? Math.min(requestedQty, maxAvailable) : 0}"
                                       ${!isAvailable ? 'disabled' : ''}
                                       onchange="validateQuantity(${equipment.item_id}, ${maxAvailable})">
                                <span class="text-xs text-gray-500">/${equipment.available_quantity}</span>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            equipmentTableHtml += `
                        </tbody>
                    </table>
                </div>
            `;
            
            Swal.fire({
                icon: false,
                buttonsStyling: false,
                width: '100%',
                maxWidth: '80rem',
                customClass: {
                    popup: 'swal-custom-popup swal-wide-modal'
                },
                html: `
                    <!-- Modal Header with Improved Gradient -->
                    <div class="w-full bg-gradient-to-r from-green-600 to-emerald-700 flex items-center justify-between">
                        <div class="w-full px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-lg sm:text-xl font-semibold text-white">Approve Reservation?</h3>
                            </div>
                            <button onclick="Swal.close()" class="p-2 rounded-full hover:bg-emerald-600 transition-all duration-200 transform hover:rotate-90">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Modal Content with Improved Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 p-4 sm:p-6 max-h-[70vh] overflow-y-auto">
                        <!-- Left Column: Reservation Details -->
                        <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                            <!-- Reservation Information Card -->
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100">
                                <div class="flex items-center mb-3 sm:mb-4">
                                    <div class="h-8 w-1 sm:h-10 sm:w-1 bg-green-600 rounded-full mr-3"></div>
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-green-600">Reservation Information</h4>
                                </div>
                                <div class="space-y-3 sm:space-y-4">
                                    <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Reservation Code</label>
                                        <p class="text-sm text-gray-900 font-semibold">${reservation.reservation_code}</p>
                                    </div>
                                    
                                    <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">User</label>
                                        <p class="text-sm text-gray-700 font-bold">${reservation.user_name}</p>
                                    </div>
                                    
                                    <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Borrow Date</label>
                                        <p class="text-sm text-gray-700 font-bold">${reservation.borrow_date}</p>
                                    </div>
                                    
                                    <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Return Date</label>
                                        <p class="text-sm text-gray-700 font-bold">${reservation.return_date}</p>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Approval Settings Card -->
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100">
                                <div class="flex items-center mb-3 sm:mb-4">
                                    <div class="h-8 w-1 sm:h-10 sm:w-1 bg-purple-600 rounded-full mr-3"></div>
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-purple-600">Approval Settings</h4>
                                </div>
                                <div class="space-y-3 sm:space-y-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-2">Pickup Date <span class="text-red-500">*</span></label>
                                        <div class="pickup-date-error hidden text-red-600 text-sm mb-2 bg-red-50 border border-red-200 rounded-md p-2">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                                <span class="error-text"></span>
                                            </div>
                                        </div>
                                        <input type="date" id="pickup_date_input" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm" 
                                               required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 mb-2">Remarks (Optional)</label>
                                        <textarea id="remarks_input" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm resize-none" 
                                                  rows="3" 
                                                  placeholder="Add any additional remarks..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Right Column: Equipment Approval Table -->
                        <div class="lg:col-span-2">
                            <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl overflow-hidden shadow-sm border border-gray-100 h-full">
                                <div class="bg-gradient-to-r from-orange-50 to-amber-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="h-8 w-1 sm:h-10 sm:w-1 bg-orange-600 rounded-full mr-3"></div>
                                        <div>
                                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-orange-700">Equipment Approval</h4>
                                            <p class="text-xs text-gray-600 mt-1">Review and approve equipment quantities for this reservation</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="max-h-80 overflow-y-auto">
                                    ${equipmentTableHtml}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="flex justify-between items-center px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-t border-gray-200">
                        <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all transform hover:scale-105 text-sm font-medium" onclick="approveReservationFromModal()">
                            Approve Reservation
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                didOpen: () => {
                    // Set min and max dates for pickup date input
                    const pickupDateInput = document.getElementById('pickup_date_input');
                    if (pickupDateInput) {
                        // Convert borrow and return dates to YYYY-MM-DD format
                        const borrowDateObj = new Date(reservation.borrow_date + 'T00:00:00');
                        const returnDateObj = new Date(reservation.return_date + 'T00:00:00');
                        
                        // Set min to borrow date (inclusive)
                        pickupDateInput.min = borrowDateObj.toISOString().split('T')[0];
                        // Set max to return date (inclusive)
                        pickupDateInput.max = returnDateObj.toISOString().split('T')[0];
                        
                        // Add real-time validation
                        pickupDateInput.addEventListener('change', function() {
                            validatePickupDate(this, borrowDateObj, returnDateObj);
                        });
                    }
                }
            });
        }*/

        // Helper functions for equipment management
        function toggleEquipmentQuantity(itemId, enabled) {
            const quantityInput = document.getElementById(`equipment_${itemId}_quantity`);
            if (quantityInput) {
                quantityInput.disabled = !enabled;
                if (!enabled) {
                    quantityInput.value = 0;
                } else {
                    // Set to requested quantity or max available
                    const maxAvailable = parseInt(quantityInput.getAttribute('max'));
                    const requestedQty = parseInt(quantityInput.getAttribute('data-requested') || maxAvailable);
                    quantityInput.value = Math.min(requestedQty, maxAvailable);
                }
            }
        }



        // Decline Confirmation Modal
        function showDeclineConfirmation(reservationId, userName, reservationCode) {
            Swal.fire({
                
                html: `
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold flex items-center justify-center gap-2 text-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Decline Reservation
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Reservation: ${reservationCode}</h3>
                                    <p class="mt-1 text-sm text-red-700">User: <strong>${userName}</strong></p>
                                    <p class="mt-1 text-sm text-red-700">Declining this reservation will notify the user.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Reason for Decline *</label>
                            <select id="decline_reason_select" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                    onchange="toggleCustomReason()">
                                <option value="">Select a reason...</option>
                                <option value="equipment_unavailable">Equipment not available</option>
                                <option value="insufficient_quantity">Insufficient equipment quantity</option>
                                <option value="maintenance_required">Equipment under maintenance</option>
                                <option value="schedule_conflict">Schedule Conflict</option>
                                <option value="invalid_reservation">Invalid reservation details</option>
                                <option value="policy_violation">Policy violation</option>
                                <option value="duplicate_reservation">Duplicate reservation</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <div id="decline_custom_div" class="hidden">
                            <label for="decline_remarks_input" class="block text-sm font-medium text-gray-700">Please specify *</label>
                            <textarea id="decline_remarks_input" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                      placeholder="Please provide details..."></textarea>
                            <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-6">
                        <button type="button" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-xl shadow-sm hover:bg-gray-700 transition-colors" onclick="Swal.close()">Keep Reservation</button>
                        <button type="button" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl shadow-sm hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105" onclick="declineReservation('${reservationId}')">Yes, Decline Reservation</button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '500px',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        }

        // Function to toggle custom reason textarea
        function toggleCustomReason() {
            // Handle Decline modal
            const declineSelect = document.getElementById('decline_reason_select');
            const declineDiv = document.getElementById('decline_custom_div');
            const declineText = document.getElementById('decline_remarks_input');
            if (declineSelect && declineDiv && declineText) {
                if (declineSelect.value === 'other') {
                    declineDiv.classList.remove('hidden');
                    declineText.required = true;
                } else {
                    declineDiv.classList.add('hidden');
                    declineText.required = false;
                    declineText.value = '';
                }
            }

            // Handle Cancel modal
            const cancelSelect = document.getElementById('cancel_reason_select');
            const cancelDiv = document.getElementById('custom_reason_div');
            const cancelText = document.getElementById('cancel_remarks_input');
            if (cancelSelect && cancelDiv && cancelText) {
                if (cancelSelect.value === 'other') {
                    cancelDiv.classList.remove('hidden');
                    cancelText.required = true;
                } else {
                    cancelDiv.classList.add('hidden');
                    cancelText.required = false;
                    cancelText.value = '';
                }
            }
        }

        // Function to handle reservation decline
        function declineReservation(reservationId) {
            const reasonSelect = document.getElementById('decline_reason_select');
            const remarks = document.getElementById('decline_remarks_input').value;
            
            // Validate reason selection
            if (!reasonSelect.value) {
                Swal.showValidationMessage('Please select a reason for decline');
                return;
            }
            
            // If "Other" is selected, validate custom reason
            if (reasonSelect.value === 'other' && !remarks.trim()) {
                Swal.showValidationMessage('Please specify the reason for decline');
                return;
            }
            
            // Use AJAX with loading states
            const buttonId = `decline_btn_${reservationId}`;
            
            // Prepare decline data
            const declineData = {
                _token: '<?php echo e(csrf_token()); ?>',
                reason: reasonSelect.value,
                remarks: remarks
            };
            
            ActionHandler.handleAjaxAction(buttonId, `<?php echo e(route('reservation-management.decline', ':id')); ?>`.replace(':id', reservationId), {
                method: 'POST',
                data: declineData,
                loadingText: 'Declining...',
                successTitle: 'Reservation Declined',
                successMessage: 'The reservation has been declined successfully.',
                errorTitle: 'Decline Failed',
                errorMessage: `Failed to decline reservation. Please try again.`,
                onSuccess: () => {
                    // Reload page after successful decline
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            });
        }

        // Cancel Confirmation Modal
        function showCancelConfirmation(reservationId, userName, reservationCode) {
            Swal.fire({
                
                html: `
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold flex items-center justify-center gap-2 text-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Cancel Reservation
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Reservation: ${reservationCode}</h3>
                                    <p class="mt-1 text-sm text-red-700">User: <strong>${userName}</strong></p>
                                    <p class="mt-1 text-sm text-red-700">This will cancel the reservation and restore equipment availability.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="cancel_reason_select" class="block text-sm font-medium text-gray-700">Reason for Cancellation *</label>
                            <select name="cancel_reason_select" id="cancel_reason_select" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                    onchange="toggleCustomReason()">
                                <option value="">Select a reason...</option>
                                <option value="equipment_unavailable">Equipment Unavailable</option>
                                <option value="user_request">User Request</option>
                                <option value="schedule_conflict">Schedule Conflict</option>
                                <option value="equipment_damaged">Equipment Damaged</option>
                                <option value="policy_violation">Policy Violation</option>
                                <option value="duplicate_reservation">Duplicate Reservation</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                        </div>
                        
                        <div id="custom_reason_div" class="hidden">
                            <label for="cancel_remarks_input" class="block text-sm font-medium text-gray-700">Please specify *</label>
                            <textarea name="cancel_remarks_input" id="cancel_remarks_input"
                                      rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                      placeholder="Please provide details..."></textarea>
                            <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-6">
                        <button type="button" class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-xl shadow-sm hover:bg-gray-700 transition-colors" onclick="Swal.close()">
                            Keep Reservation
                        </button>
                        <button type="button" class="flex-1 px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl shadow-sm hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105" onclick="cancelReservation('${reservationId}')">
                            Yes, Cancel Reservation
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '500px',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        }

        // (Removed duplicate toggleCustomReason implementation; unified handler is defined earlier)

        // Function to handle reservation cancellation
        function cancelReservation(reservationId) {
            const reasonSelect = document.getElementById('cancel_reason_select');
            const customReasonInput = document.getElementById('cancel_remarks_input');
            
            // Validate reason selection
            if (!reasonSelect.value) {
                Swal.showValidationMessage('Please select a reason for cancellation');
                return;
            }
            
            // If "Other" is selected, validate custom reason
            if (reasonSelect.value === 'other' && !customReasonInput.value.trim()) {
                Swal.showValidationMessage('Please provide details for the cancellation reason');
                return;
            }
            
            // Prepare remarks - use selected reason or custom text
            let remarks = reasonSelect.value === 'other' ? customReasonInput.value.trim() : reasonSelect.options[reasonSelect.selectedIndex].text;
            
            // Use AJAX with loading states
            const buttonId = `cancel_btn_${reservationId}`;
            
            ActionHandler.handleAjaxAction(buttonId, `<?php echo e(route('reservation-management.cancel', ':id')); ?>`.replace(':id', reservationId), {
                method: 'POST',
                data: { 
                    _token: '<?php echo e(csrf_token()); ?>',
                    remarks: remarks
                },
                loadingText: 'Cancelling...',
                successTitle: 'Reservation Cancelled',
                successMessage: 'The reservation has been cancelled successfully.',
                errorTitle: 'Cancellation Failed',
                errorMessage: `Failed to cancel reservation. Please try again.`,
                onSuccess: () => {
                    // Reload page after successful cancellation
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            });
        }

        // Approval Modal Functions
        function showApprovalModal(reservationId) {
            console.log('Fetching approval data for reservation ID:', reservationId);
            
            // Fetch reservation data
            fetch(`/reservation-management/${reservationId}/approval-data`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Approval data received:', data);
                    console.log('Equipment data:', data.equipment);
                    
                    // Populate reservation information
                    document.getElementById('approvalReservationCode').textContent = data.reservation.reservation_code;
                    document.getElementById('approvalUserName').textContent = data.reservation.user_name;
                    
                    // Format dates with time information
                    let borrowDateText = data.reservation.borrow_date;
                    if (data.reservation.borrow_time) {
                        borrowDateText += ` at ${data.reservation.borrow_time}`;
                    }
                    document.getElementById('approvalBorrowDate').textContent = borrowDateText;
                    
                    let returnDateText = data.reservation.return_date;
                    if (data.reservation.return_time) {
                        returnDateText += ` at ${data.reservation.return_time}`;
                    }
                    document.getElementById('approvalReturnDate').textContent = returnDateText;
                    document.getElementById('approvalBorrowTime').textContent = data.reservation.borrow_time || '—';
                    document.getElementById('approvalReturnTime').textContent = data.reservation.return_time || '—';
                    
                    // Generate equipment table
                    if (data.equipment && data.equipment.length > 0) {
                        generateApprovalEquipmentTable(data.equipment);
                    } else {
                        console.error('No equipment data received');
                        document.getElementById('approvalEquipmentTable').innerHTML = '<div class="p-4 text-center text-gray-500">No equipment data available</div>';
                    }
                    
                    // Set min and max dates for pickup date input
                    const pickupDateInput = document.getElementById('pickupDateInput');
                    const today = new Date().toISOString().split('T')[0];
                    const borrowDate = data.reservation.borrow_date_iso;
                    const returnDate = data.reservation.return_date_iso;
                    
                    console.log('Date debugging:', {
                        today: today,
                        borrowDate: borrowDate,
                        returnDate: returnDate,
                        isSameDay: borrowDate === returnDate
                    });
                    
                    // For same-day reservations (borrow date = return date), automatically set pickup date to borrow date
                    if (borrowDate === returnDate) {
                        pickupDateInput.value = borrowDate;
                        pickupDateInput.min = borrowDate;
                        pickupDateInput.max = returnDate;
                        // Disable the input since it's automatically set for same-day reservations
                        pickupDateInput.disabled = true;
                        pickupDateInput.style.backgroundColor = '#f3f4f6';
                        pickupDateInput.style.cursor = 'not-allowed';
                        // Show the note
                        document.getElementById('sameDayNote').classList.remove('hidden');
                    } else {
                        // For multi-day reservations, allow picking any date within the reservation window
                        // Use borrowDate as the lower bound instead of "today" so past-dated approvals still work
                        pickupDateInput.min = borrowDate;
                        pickupDateInput.max = returnDate;
                        pickupDateInput.value = borrowDate;
                        pickupDateInput.disabled = false;
                        pickupDateInput.style.backgroundColor = '';
                        pickupDateInput.style.cursor = '';
                        // Hide the note
                        document.getElementById('sameDayNote').classList.add('hidden');
                    }
                    
                    // Show modal with animation
                    const modal = document.getElementById('approvalModal');
                    const modalContent = document.getElementById('approvalModalContent');
                    modal.classList.add('show');
                    modalContent.style.transform = 'scale(1)';
                    modalContent.style.opacity = '1';
                })
                .catch(error => {
                    console.error('Error fetching approval data:', error);
                    console.error('Error details:', error.message);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load reservation data: ' + error.message
                    });
                });
        }

        function closeApprovalModal() {
            const modal = document.getElementById('approvalModal');
            const modalContent = document.getElementById('approvalModalContent');
            modalContent.style.transform = 'scale(0.95)';
            modalContent.style.opacity = '0';
            setTimeout(() => {
                modal.classList.remove('show');
            }, 300);
        }

        function generateApprovalEquipmentTable(equipmentData) {
            const tableContainer = document.getElementById('approvalEquipmentTable');
            
            let tableHtml = `
                <div class="overflow-x-auto">
                    <table class="w-full bg-white border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 45%;">Equipment</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 12%;">Requested</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 12%;">Available</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 12%;">Approve</th>
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 19%;">Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
            `;
            
            equipmentData.forEach((equipment, index) => {
                const isAvailable = equipment.available_quantity > 0;
                const maxAvailable = Math.min(equipment.requested_quantity, equipment.available_quantity);
                
                tableHtml += `
                    <tr class="${!isAvailable ? 'bg-red-50' : 'hover:bg-gray-50'}">
                        <td class="px-4 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-medium text-gray-900">${equipment.equipment_name}</div>
                                <div class="text-sm text-gray-500">${equipment.category} • ${equipment.equipment_type}</div>
                                ${!isAvailable ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">Not Available</span>` : ''}
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <span class="text-sm font-medium text-gray-900">${equipment.requested_quantity}</span>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <span class="text-sm font-medium ${isAvailable ? 'text-green-600' : 'text-red-600'}">${equipment.available_quantity}</span>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <div class="flex justify-center">
                                <input type="checkbox" id="equipment_${equipment.item_id}_enabled" 
                                       class="equipment-checkbox text-green-600 focus:ring-green-500 border-gray-300 rounded" 
                                       ${isAvailable ? 'checked' : 'disabled'}
                                       onchange="toggleEquipmentApproval(${equipment.item_id}, ${maxAvailable})">
                            </div>
                        </td>
                        <td class="px-3 py-4 text-center">
                            <div class="flex items-center justify-center space-x-1">
                                <button type="button" 
                                        class="w-6 h-6 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-l border border-gray-300 text-gray-600 text-sm font-bold"
                                        onclick="decreaseQuantity(${equipment.item_id}, ${maxAvailable})"
                                        ${!isAvailable ? 'disabled' : ''}>
                                    -
                                </button>
                                <input type="number" id="equipment_${equipment.item_id}_quantity" 
                                       class="equipment-quantity w-16 px-2 py-1 text-sm border-t border-b border-gray-300 text-center focus:ring-2 focus:ring-green-500 focus:border-green-500" 
                                       min="0" 
                                       max="${maxAvailable}" 
                                       value="${isAvailable ? maxAvailable : 0}"
                                       ${!isAvailable ? 'disabled' : ''}
                                       onchange="validateQuantity(${equipment.item_id}, ${maxAvailable})"
                                       oninput="validateQuantity(${equipment.item_id}, ${maxAvailable})">
                                <button type="button" 
                                        class="w-6 h-6 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded-r border border-gray-300 text-gray-600 text-sm font-bold"
                                        onclick="increaseQuantity(${equipment.item_id}, ${maxAvailable})"
                                        ${!isAvailable ? 'disabled' : ''}>
                                    +
                                </button>
                                <span class="text-xs text-gray-500 ml-1">/${equipment.available_quantity}</span>
                            </div>
                        </td>
                    </tr>
                `;
            });
            
            tableHtml += `</tbody></table></div>`;
            tableContainer.innerHTML = tableHtml;
        }

        function toggleEquipmentApproval(itemId, maxAvailable) {
            const checkbox = document.getElementById(`equipment_${itemId}_enabled`);
            const quantityInput = document.getElementById(`equipment_${itemId}_quantity`);
            
            if (checkbox.checked) {
                quantityInput.disabled = false;
                quantityInput.value = maxAvailable;
            } else {
                quantityInput.disabled = true;
                quantityInput.value = 0;
            }
        }

        function increaseQuantity(itemId, maxAvailable) {
            const quantityInput = document.getElementById(`equipment_${itemId}_quantity`);
            if (quantityInput && !quantityInput.disabled) {
                const currentValue = parseInt(quantityInput.value) || 0;
                
                // Get the actual available quantity from the table data
                const row = quantityInput.closest('tr');
                const availableCell = row.querySelector('td:nth-child(3) span');
                const actualAvailable = parseInt(availableCell.textContent);
                
                const newValue = Math.min(currentValue + 1, actualAvailable);
                quantityInput.value = newValue;
                validateQuantity(itemId, actualAvailable);
            }
        }

        function decreaseQuantity(itemId, maxAvailable) {
            const quantityInput = document.getElementById(`equipment_${itemId}_quantity`);
            if (quantityInput && !quantityInput.disabled) {
                const currentValue = parseInt(quantityInput.value) || 0;
                
                // Get the actual available quantity from the table data
                const row = quantityInput.closest('tr');
                const availableCell = row.querySelector('td:nth-child(3) span');
                const actualAvailable = parseInt(availableCell.textContent);
                
                const newValue = Math.max(currentValue - 1, 0);
                quantityInput.value = newValue;
                validateQuantity(itemId, actualAvailable);
            }
        }

        function validateQuantity(itemId, maxAvailable) {
            const quantityInput = document.getElementById(`equipment_${itemId}_quantity`);
            if (!quantityInput) return;
            
            const value = parseInt(quantityInput.value) || 0;
            
            // Get the actual available quantity from the table data
            const row = quantityInput.closest('tr');
            const availableCell = row.querySelector('td:nth-child(3) span');
            const actualAvailable = parseInt(availableCell.textContent);
            
            if (value > actualAvailable) {
                quantityInput.value = actualAvailable;
            } else if (value < 0) {
                quantityInput.value = 0;
            }
        }

        function approveReservationFromModal() {
            const pickupDateInput = document.getElementById('pickupDateInput');
            const pickupDate = pickupDateInput.value;
            const remarks = document.getElementById('remarksInput').value;
            
            // Get reservation ID from the current reservation data
            const reservationId = window.currentReservationId;
            console.log('Approving reservation ID:', reservationId);
            
            // Get the approve button and show loading state
            const approveButton = document.querySelector('button[onclick="approveReservationFromModal()"]');
            const originalButtonText = approveButton.innerHTML;
            const originalButtonClass = approveButton.className;
            
            // Show loading state
            approveButton.disabled = true;
            approveButton.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Approving...
            `;
            approveButton.className = approveButton.className.replace('hover:scale-105', '') + ' opacity-75 cursor-not-allowed';
            
            // For same-day reservations, pickup date is automatically set and disabled
            if (pickupDateInput.disabled) {
                // No validation needed for disabled same-day reservations
                hidePickupDateError();
            } else {
                // Validate pickup date for multi-day reservations
                if (!pickupDate) {
                    showPickupDateError('Pickup date is required');
                    return;
                }
                
                // Normalize dates to compare only date parts (no time)
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                const selectedDate = new Date(pickupDate);
                selectedDate.setHours(0, 0, 0, 0);
                
                const returnDateText = document.getElementById('approvalReturnDate').textContent;
                const returnDate = new Date(returnDateText);
                returnDate.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    showPickupDateError('Pickup date cannot be in the past');
                    return;
                }
                
                if (selectedDate > returnDate) {
                    showPickupDateError('Pickup date cannot be after the return date');
                    return;
                }
                
                hidePickupDateError();
            }
            
            // Collect approved equipment
            const approvedEquipment = [];
            const checkboxes = document.querySelectorAll('[id^="equipment_"][id$="_enabled"]');
            
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const itemId = checkbox.id.match(/equipment_(\d+)_enabled/)[1];
                    const quantity = parseInt(document.getElementById(`equipment_${itemId}_quantity`).value);
                    if (quantity > 0) {
                        approvedEquipment.push({
                            item_id: parseInt(itemId),
                            quantity: quantity
                        });
                    }
                }
            });
            
            if (approvedEquipment.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Equipment Selected',
                    text: 'Please select at least one equipment item to approve.'
                });
                return;
            }
            
            // Submit approval
            const url = `/reservation-management/${reservationId}/approve`;
            const formData = new FormData();
            formData.append('pickup_date', pickupDate);
            formData.append('remarks', remarks);
            formData.append('_token', '<?php echo e(csrf_token()); ?>');
            
            // Add each approved equipment item as separate form fields
            approvedEquipment.forEach((item, index) => {
                formData.append(`approved_equipment[${index}][item_id]`, item.item_id);
                formData.append(`approved_equipment[${index}][quantity]`, item.quantity);
            });
            
            console.log('Submitting to URL:', url);
            console.log('Request data:', Object.fromEntries(formData));
            console.log('Approved equipment array:', approvedEquipment);
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    // Try to get error details from response
                    return response.json().then(errorData => {
                        throw new Error(`HTTP error! status: ${response.status}. ${errorData.message || 'Unknown error'}`);
                    }).catch(() => {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    closeApprovalModal();
                    Swal.fire({
                        icon: false,
                        buttonsStyling: false,
                        html: `
                            <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Reservation Approved!</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700">The reservation has been approved successfully. The user will receive a confirmation email shortly.</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105 border-0" style="border: none !important; outline: none !important; box-shadow: none !important;" onclick="Swal.close()">
                                    OK
                                </button>
                            </div>
                        `,
                        showConfirmButton: false,
                        showCancelButton: false,
                        customClass: {
                            popup: 'swal-custom-popup'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    // Restore button state on error
                    approveButton.disabled = false;
                    approveButton.innerHTML = originalButtonText;
                    approveButton.className = originalButtonClass;
                    
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    html: `
                        <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#ef4444;">
                            <h2 class="text-xl font-bold text-center">Approval Failed</h2>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-700">${data.message || 'Failed to approve reservation. Please try again.'}</p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 text-white rounded-lg" style="background:#ef4444" onclick="Swal.close()">OK</button>
                        </div>
                    `,
                    showConfirmButton: false
                });
                }
            })
            .catch(error => {
                console.error('Approval error:', error);
                
                // Restore button state on error
                approveButton.disabled = false;
                approveButton.innerHTML = originalButtonText;
                approveButton.className = originalButtonClass;
                
                Swal.fire({
                    icon: false,
                    buttonsStyling: false,
                    html: `
                        <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#ef4444;">
                            <h2 class="text-xl font-bold text-center">Approval Failed</h2>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-700">Network error: ${error.message}. Please check the console for more details.</p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 text-white rounded-lg" style="background:#ef4444" onclick="Swal.close()">OK</button>
                        </div>
                    `,
                    showConfirmButton: false
                });
            });
        }

        function showPickupDateError(message) {
            const errorDiv = document.getElementById('pickupDateError');
            const errorText = document.getElementById('pickupDateErrorText');
            errorText.textContent = message;
            errorDiv.classList.remove('hidden');
        }

        function hidePickupDateError() {
            const errorDiv = document.getElementById('pickupDateError');
            errorDiv.classList.add('hidden');
        }
    </script>

    <!-- Approval Modal - Using exact welcome page modal structure -->
    <div id="approvalModal" class="approval-modal fixed inset-0 bg-gray-900/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-2 sm:p-4">
        <div class="relative w-full max-w-7xl bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0" id="approvalModalContent">
            <!-- Modal Header with Improved Gradient -->
            <div class="w-full bg-gradient-to-r from-green-600 to-emerald-700 flex items-center justify-between">
                <div class="w-full px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg sm:text-xl font-semibold text-white">Approve Reservation?</h3>
                    </div>
                    <button onclick="closeApprovalModal()" class="p-2 rounded-full hover:bg-emerald-600 transition-all duration-200 transform hover:rotate-90">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Content with Improved Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 p-4 sm:p-6 max-h-[70vh] overflow-y-auto">
                <!-- Left Column: Reservation Details -->
                <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                    <!-- Reservation Information Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div class="h-8 w-1 sm:h-10 sm:w-1 bg-green-600 rounded-full mr-3"></div>
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-green-600">Reservation Information</h4>
                        </div>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Reservation Code</label>
                                <p id="approvalReservationCode" class="text-sm text-gray-900 font-semibold"></p>
                            </div>
                            
                            <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">User</label>
                                <p id="approvalUserName" class="text-sm text-gray-700 font-bold"></p>
                            </div>
                            
                            <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Borrow Date</label>
                                <p id="approvalBorrowDate" class="text-sm text-gray-700 font-bold"></p>
                            </div>
                            
                            <div class="bg-green-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Return Date</label>
                                <p id="approvalReturnDate" class="text-sm text-gray-700 font-bold"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Approval Settings Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div class="h-8 w-1 sm:h-10 sm:w-1 bg-purple-600 rounded-full mr-3"></div>
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-purple-600">Approval Settings</h4>
                        </div>
                        <div class="space-y-3 sm:space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-2">Pickup Date <span class="text-red-500">*</span></label>
                                <div id="pickupDateError" class="hidden text-red-600 text-sm mb-2 bg-red-50 border border-red-200 rounded-md p-2">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <span id="pickupDateErrorText"></span>
                                    </div>
                                </div>
                                <input type="date" id="pickupDateInput" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm" 
                                       required>
                                <div id="sameDayNote" class="text-sm text-blue-600 hidden mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Automatically set to borrow date for same-day reservations
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-2">Remarks (Optional)</label>
                                <textarea id="remarksInput" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm resize-none" 
                                          rows="3" 
                                          placeholder="Add any additional remarks..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Equipment Approval Table -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl overflow-hidden shadow-sm border border-gray-100 h-full">
                        <div class="bg-gradient-to-r from-orange-50 to-amber-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="h-8 w-1 sm:h-10 sm:w-1 bg-orange-600 rounded-full mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-orange-700">Equipment Approval</h4>
                                    <p class="text-xs text-gray-600 mt-1">Review and approve equipment quantities for this reservation</p>
                                </div>
                            </div>
                        </div>
                        <div id="approvalEquipmentTable" class="max-h-80 overflow-y-auto">
                            <!-- Equipment table will be populated here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 flex justify-between">
                <button onclick="closeApprovalModal()" class="px-3 sm:px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Cancel
                </button>
                <button onclick="approveReservationFromModal()" class="px-3 sm:px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all transform hover:scale-105">
                    Approve Reservation
                </button>
            </div>
        </div>
    </div>

    <!-- Real-time Overdue Status Refresh Script -->
    <script>
        // Function to check overdue status via AJAX
        function checkOverdueStatus() {
            const pickedUpElements = document.querySelectorAll('.status-display');
            const reservationIds = [];
            
            pickedUpElements.forEach(element => {
                if (element.textContent.includes('Picked Up')) {
                    const reservationId = element.getAttribute('data-reservation-id');
                    if (reservationId) {
                        reservationIds.push(reservationId);
                    }
                }
            });
            
            if (reservationIds.length === 0) {
                return;
            }
            
            // Make AJAX request to check overdue status
            fetch('<?php echo e(route("reservation-management.check-overdue")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    reservation_ids: reservationIds
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.overdue_reservations && data.overdue_reservations.length > 0) {
                    // Update the display for overdue reservations
                    data.overdue_reservations.forEach(overdueReservation => {
                        const statusElement = document.querySelector(`[data-reservation-id="${overdueReservation.id}"]`);
                        if (statusElement && statusElement.textContent.includes('Picked Up')) {
                            // Update the status display to show overdue
                            statusElement.innerHTML = `
                                <span class="flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Overdue
                                </span>
                            `;
                            statusElement.className = 'inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-200 shadow-sm min-w-[80px] text-center status-display';
                            
                            // Show notification for new overdue status
                            showOverdueNotification(overdueReservation.id, overdueReservation.days_overdue);
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error checking overdue status:', error);
            });
        }

        // Function to show overdue notification
        function showOverdueNotification(reservationId, daysOverdue) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Reservation #${reservationId} is ${daysOverdue} day(s) overdue!
                </div>
            `;
            document.body.appendChild(notification);
            
            // Remove notification after 5 seconds
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 5000);
        }

        // Check overdue status every 2 minutes
        setInterval(checkOverdueStatus, 120000); // 2 minutes

        // Check overdue status on page load
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(checkOverdueStatus, 1000); // Check after 1 second
        });

        // Check overdue status when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                checkOverdueStatus();
            }
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
<?php /**PATH C:\Users\Bryan\SEMS\SEMSv23\resources\views/admin-manager/reservation-management/index.blade.php ENDPATH**/ ?>