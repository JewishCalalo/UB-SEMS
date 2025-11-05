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
            <?php if(Auth::user()->isManager() || Auth::user()->isAdmin()): ?>
                <?php echo e(__('Manage Reservations')); ?>

            <?php else: ?>
                <?php echo e(__('My Reservations')); ?>

            <?php endif; ?>
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with Create Button -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">
                    <?php if(Auth::user()->isManager() || Auth::user()->isAdmin()): ?>
                        Equipment Reservations Management
                    <?php else: ?>
                        Equipment Reservations
                    <?php endif; ?>
                </h1>
                <?php if(!Auth::user()->isManager() && !Auth::user()->isAdmin()): ?>
                    <a href="<?php echo e(route('reservations.create')); ?>" 
                       class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Make New Reservation
                    </a>
                <?php endif; ?>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <form method="GET" action="<?php echo e(route('reservations.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            <option value="">All Statuses</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                            <option value="denied" <?php echo e(request('status') == 'denied' ? 'selected' : ''); ?>>Denied</option>
                            <option value="picked_up" <?php echo e(request('status') == 'picked_up' ? 'selected' : ''); ?>>Picked Up</option>
                            <option value="returned" <?php echo e(request('status') == 'returned' ? 'selected' : ''); ?>>Returned</option>
                            <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                        <input type="date" name="date_from" id="date_from" value="<?php echo e(request('date_from')); ?>"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                        <input type="date" name="date_to" id="date_to" value="<?php echo e(request('date_to')); ?>"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Action Legend -->
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <h4 class="text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-gray-600"></i>
                            Action Legend:
                        </h4>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center space-x-2">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-700 border border-blue-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">View Details</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 text-green-700 border border-green-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Approve</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 text-red-700 border border-red-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Deny</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 text-blue-700 border border-blue-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Picked Up</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 text-purple-700 border border-purple-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Returned</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 text-yellow-700 border border-yellow-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-600">Cancel</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservations List -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <?php if($reservations->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-600">
                                <tr>
                                    <?php if(Auth::user()->isManager() || Auth::user()->isAdmin()): ?>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Borrower
                                        </th>
                                    <?php endif; ?>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Equipment
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Requested Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Pickup Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="transition-shadow hover:shadow-md hover:bg-gray-50">
                                        <?php if(Auth::user()->isManager() || Auth::user()->isAdmin()): ?>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">
                                                    <?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?>

                                                </div>
                                                <div class="text-sm font-medium text-gray-700">
                                                    <?php echo e($reservation->user ? $reservation->user->email : ($reservation->email ?? 'No email')); ?>

                                                </div>
                                                <?php if($reservation->user && $reservation->user->department): ?>
                                                    <div class="text-xs font-medium text-gray-600">
                                                        <?php echo e($reservation->user->department); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <?php if($reservation->items->first() && $reservation->items->first()->equipment->primary_image): ?>
                                                        <img class="h-10 w-10 rounded-full object-cover" 
                                                             src="<?php echo e($reservation->items->first()->equipment->primary_image->url); ?>" 
                                                             alt="<?php echo e($reservation->items->first()->equipment->name); ?>">
                                                    <?php else: ?>
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                            </svg>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-gray-900">
                                                        <?php echo e($reservation->items->count()); ?> item(s)
                                                    </div>
                                                    <div class="text-sm font-medium text-gray-700">
                                                        <?php $__currentLoopData = $reservation->items->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($item->equipment->name); ?><?php echo e(!$loop->last ? ', ' : ''); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($reservation->items->count() > 2): ?>
                                                            +<?php echo e($reservation->items->count() - 2); ?> more
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
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
                                                $statusColor = $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
                                            ?>
                                            <span class="px-3 py-1.5 text-xs font-semibold rounded-full <?php echo e($statusColor); ?> shadow-sm">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $reservation->status))); ?>

                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            <?php echo e($reservation->created_at->format('M d, Y')); ?>

                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            <?php if($reservation->pickup_date): ?>
                                                <?php echo e($reservation->pickup_date->format('M d, Y')); ?>

                                            <?php else: ?>
                                                <span class="text-gray-400">Not set</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="<?php echo e(route('reservations.show', $reservation)); ?>" 
                                               style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center; margin-right: 12px;"
                                               onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                               onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                            
                                            <?php if(Auth::user()->isManager() || Auth::user()->isAdmin()): ?>
                                                <?php if($reservation->status === 'pending'): ?>
                                                    <button type="button" 
                                                            id="approve_btn_<?php echo e($reservation->id); ?>"
                                                            onclick="showApproveConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?>')"
                                                            style="background: linear-gradient(to right, #10b981, #059669); color: white; padding: 6px 12px; border-radius: 6px; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center; cursor: pointer;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                                        <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Approve
                                                    </button>
                                                    
                                                    <!-- Hidden form for approval -->
                                                    <form id="approve-form-<?php echo e($reservation->id); ?>" 
                                                          method="POST" 
                                                          action="<?php echo e(route('reservations.update', $reservation)); ?>" 
                                                          class="hidden">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="status" value="approved">
                                                    </form>
                                                    

                                                    
                                                    <button type="button" 
                                                            id="deny_btn_<?php echo e($reservation->id); ?>"
                                                            onclick="showDenyConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?>')"
                                                            style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; padding: 6px 12px; border-radius: 6px; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center; cursor: pointer; margin-left: 8px;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Deny
                                                    </button>
                                                    
                                                    <!-- Hidden form for denial -->
                                                    <form id="deny-form-<?php echo e($reservation->id); ?>" 
                                                          method="POST" 
                                                          action="<?php echo e(route('reservations.update', $reservation)); ?>" 
                                                          class="hidden">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="status" value="denied">
                                                    </form>
                                                    

                                                <?php elseif($reservation->status === 'approved'): ?>
                                                    <button type="button" 
                                                            id="picked_up_btn_<?php echo e($reservation->id); ?>"
                                                            onclick="showPickedUpConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?>')"
                                                            style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; padding: 6px 12px; border-radius: 6px; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center; cursor: pointer;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                                        <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                                        </svg>
                                                        Picked Up
                                                    </button>
                                                    
                                                    <!-- Hidden form for picked up -->
                                                    <form id="picked-up-form-<?php echo e($reservation->id); ?>" 
                                                          method="POST" 
                                                          action="<?php echo e(route('reservations.update', $reservation)); ?>" 
                                                          class="hidden">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="status" value="picked_up">
                                                    </form>
                                                    

                                                <?php elseif($reservation->status === 'picked_up'): ?>
                                                    <button type="button" 
                                                            id="returned_btn_<?php echo e($reservation->id); ?>"
                                                            onclick="showReturnedConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?>')"
                                                            style="background: linear-gradient(to right, #8b5cf6, #7c3aed); color: white; padding: 6px 12px; border-radius: 6px; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center; cursor: pointer;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #7c3aed, #6d28d9)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #8b5cf6, #7c3aed)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                                        <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Returned
                                                    </button>
                                                    
                                                    <!-- Hidden form for returned -->
                                                    <form id="returned-form-<?php echo e($reservation->id); ?>" 
                                                          method="POST" 
                                                          action="<?php echo e(route('reservations.update', $reservation)); ?>" 
                                                          class="hidden">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <input type="hidden" name="status" value="returned">
                                                    </form>
                                                    

                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if($reservation->status === 'pending'): ?>
                                                    <button type="button" 
                                                            onclick="showCancelReservationConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->user ? $reservation->user->name : ($reservation->name ?? 'Guest User')); ?>')"
                                                            style="background: linear-gradient(to right, #f59e0b, #d97706); color: white; padding: 6px 12px; border-radius: 6px; border: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; display: inline-flex; align-items: center; cursor: pointer;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #d97706, #b45309)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #f59e0b, #d97706)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                                                        <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Cancel
                                                    </button>
                                                    
                                                    <!-- Hidden form for cancellation -->
                                                    <form id="cancel-reservation-form-<?php echo e($reservation->id); ?>" 
                                                          method="POST" 
                                                          action="<?php echo e(route('reservations.destroy', $reservation)); ?>" 
                                                          class="hidden">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                    

                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if($reservations->hasPages()): ?>
                        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                            <?php echo e($reservations->links()); ?>

                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No reservations found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            <?php if(request('status') || request('date_from') || request('date_to')): ?>
                                Try adjusting your filters or 
                            <?php endif; ?>
                            <?php if(Auth::user()->isManager() || Auth::user()->isAdmin()): ?>
                                There are no reservations to manage at the moment.
                            <?php else: ?>
                                Get started by making your first equipment reservation.
                            <?php endif; ?>
                        </p>
                        <?php if(!Auth::user()->isManager() && !Auth::user()->isAdmin()): ?>
                            <div class="mt-6">
                                <a href="<?php echo e(route('reservations.create')); ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                    Make Reservation
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
        // Approve Confirmation Modal
        function showApproveConfirmation(reservationId, userName) {
            Swal.fire({
                title: 'Approve Reservation?',
                html: `Are you sure you want to approve reservation #${reservationId} for <strong>${userName}</strong>?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`approve-form-${reservationId}`).submit();
                }
            });
        }

        // Deny Confirmation Modal
        function showDenyConfirmation(reservationId, userName) {
            Swal.fire({
                title: 'Deny Reservation?',
                html: `Are you sure you want to deny reservation #${reservationId} for <strong>${userName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Deny',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deny-form-${reservationId}`).submit();
                }
            });
        }

        // Picked Up Confirmation Modal
        function showPickedUpConfirmation(reservationId, userName) {
            Swal.fire({
                title: 'Mark as Picked Up?',
                html: `Are you sure you want to mark reservation #${reservationId} for <strong>${userName}</strong> as picked up?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Mark as Picked Up',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`picked-up-form-${reservationId}`).submit();
                }
            });
        }

        // Returned Confirmation Modal
        function showReturnedConfirmation(reservationId, userName) {
            Swal.fire({
                title: 'Mark as Returned?',
                html: `Are you sure you want to mark reservation #${reservationId} for <strong>${userName}</strong> as returned?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#8b5cf6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Mark as Returned',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`returned-form-${reservationId}`).submit();
                }
            });
        }

        // Cancel Reservation Confirmation Modal
        function showCancelReservationConfirmation(reservationId, userName) {
            Swal.fire({
                title: 'Cancel Reservation?',
                html: `Are you sure you want to cancel reservation #${reservationId} for <strong>${userName}</strong>? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Cancel Reservation',
                cancelButtonText: 'Keep Reservation',
                customClass: {
                    popup: 'swal-custom-popup',
                    confirmButton: 'swal-custom-confirm-button',
                    cancelButton: 'swal-custom-cancel-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`cancel-reservation-form-${reservationId}`).submit();
                }
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
<?php /**PATH C:\UB-SEMS\resources\views\user\reservations\index.blade.php ENDPATH**/ ?>