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
            <?php echo e(__('My Reservations')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'My Reservations']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'My Reservations']
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
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">My Reservations</h3>
                        <p class="text-gray-600 font-medium">View and manage your equipment reservations.</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="<?php echo e(route('instructor.reservations.create')); ?>" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Reservation
                        </a>
                    </div>
                </div>
            </div>

            <!-- Back/Actions Row -->
            <div class="mb-4 flex justify-end">
                <a href="<?php echo e(url()->previous()); ?>" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:ring-2 focus:ring-gray-300 shadow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back
                </a>
            </div>

            <!-- Action Legend -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
                <h3 class="text-sm font-medium text-gray-900 mb-3">Action Legend</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-2">
                        <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; width: 32px; height: 32px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600">View Details</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; width: 32px; height: 32px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600">Cancel (Pending Only)</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; width: 32px; height: 32px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600">Edit (Pending Only)</span>
                    </div>
                </div>
            </div>

            <!-- Reservations Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                    <h4 class="text-lg font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Reservation History
                    </h4>
                </div>
                
                <?php if($reservations->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-600">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Reservation ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Borrow Date and Time
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Return Date and Time
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Equipment Count
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Created
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reservation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="<?php echo e(route('instructor.reservations.show', $reservation)); ?>" 
                                               class="text-lg font-semibold text-gray-900 hover:text-red-600 transition-colors">
                                                <?php echo e($reservation->reservation_code); ?>

                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                                <?php if($reservation->status === 'approved'): ?> bg-green-100 text-green-800 border border-green-200
                                                <?php elseif($reservation->status === 'pending'): ?> bg-yellow-100 text-yellow-800 border border-yellow-200
                                                <?php elseif($reservation->status === 'rejected'): ?> bg-red-100 text-red-800 border border-red-200
                                                <?php elseif($reservation->status === 'picked_up'): ?> bg-blue-100 text-blue-800 border border-blue-200
                                                <?php elseif($reservation->status === 'returned'): ?> bg-purple-100 text-purple-800 border border-purple-200
                                                <?php elseif($reservation->status === 'completed'): ?> bg-gray-100 text-gray-800 border border-gray-200
                                                <?php else: ?> bg-gray-100 text-gray-800 border border-gray-200 <?php endif; ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $reservation->status))); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php if($reservation->borrow_date): ?>
                                                <div class="font-medium"><?php echo e(\Carbon\Carbon::parse($reservation->borrow_date)->format('M d, Y')); ?></div>
                                                <?php if($reservation->borrow_time): ?>
                                                    <div class="text-gray-500 text-xs"><?php echo e(\Carbon\Carbon::parse($reservation->borrow_time)->format('g:i A')); ?></div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-gray-400">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php if($reservation->return_date): ?>
                                                <div class="font-medium"><?php echo e(\Carbon\Carbon::parse($reservation->return_date)->format('M d, Y')); ?></div>
                                                <?php if($reservation->return_time): ?>
                                                    <div class="text-gray-500 text-xs"><?php echo e(\Carbon\Carbon::parse($reservation->return_time)->format('g:i A')); ?></div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-gray-400">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <?php if($reservation->items && $reservation->items->count() > 0): ?>
                                                <div class="space-y-1">
                                                    <?php $__currentLoopData = $reservation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="text-xs">
                                                            <span class="font-medium text-gray-900">
                                                                <?php if($item->equipment->brand && $item->equipment->model): ?>
                                                                    <?php echo e($item->equipment->brand); ?> <?php echo e($item->equipment->model); ?>

                                                                <?php elseif($item->equipment->brand): ?>
                                                                    <?php echo e($item->equipment->brand); ?>

                                                                <?php elseif($item->equipment->model): ?>
                                                                    <?php echo e($item->equipment->model); ?>

                                                                <?php else: ?>
                                                                    <?php echo e($item->equipment->description ?? 'Unknown Equipment'); ?>

                                                                <?php endif; ?>
                                                            </span>
                                                            <span class="text-gray-600">
                                                                (<?php echo e($item->quantity_requested); ?>)
                                                            </span>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-gray-400">No equipment</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php echo e($reservation->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <!-- Action Buttons -->
                                            <div class="flex items-center space-x-2">
                                                <!-- View Details Button -->
                                                <a href="<?php echo e(route('instructor.reservations.show', $reservation)); ?>" 
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
                                                    <!-- Edit Button (Track-style) -->
                                                    <button onclick="openInstructorFullEdit('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->reservation_code); ?>')"
                                                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; border: none; cursor: pointer;"
                                                            onmouseover="this.style.background='linear-gradient(135deg, #059669 0%, #047857 100%)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(135deg, #10b981 0%, #059669 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                            title="Edit Reservation">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </button>
                                                    <!-- Cancel Button -->
                                                    <button onclick="showCancelConfirmation('<?php echo e($reservation->id); ?>', '<?php echo e($reservation->user->name ?? 'User'); ?>', '<?php echo e($reservation->reservation_code); ?>')"
                                                            style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s; border: none; cursor: pointer;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                            title="Cancel Reservation">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
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
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex-1 order-2 sm:order-1">
                                <?php echo e($reservations->appends(request()->query())->links()); ?>

                            </div>
                            <div class="order-1 sm:order-2 mb-4 sm:mb-0 sm:ml-auto">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-700">Rows per page:</span>
                                    <select id="per-page-select" class="px-3 py-1 pr-8 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white" onchange="changePerPage(this.value)">
                                        <option value="10" <?php echo e(request('per_page', 15) == 10 ? 'selected' : ''); ?>>10</option>
                                        <option value="15" <?php echo e(request('per_page', 15) == 15 ? 'selected' : ''); ?>>15</option>
                                        <option value="25" <?php echo e(request('per_page', 15) == 25 ? 'selected' : ''); ?>>25</option>
                                        <option value="50" <?php echo e(request('per_page', 15) == 50 ? 'selected' : ''); ?>>50</option>
                                        <option value="100" <?php echo e(request('per_page', 15) == 100 ? 'selected' : ''); ?>>100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
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

    <script>
        // Track page-style editor (exact copy layout; no date/time editing)
        async function openInstructorFullEdit(resId, code){
            try{
                const r = await fetch(`/instructor/reservations/${resId}/edit-data`, { headers:{ 'X-Requested-With':'XMLHttpRequest' }});
                const data = await r.json();
                if (!r.ok || !data.success) throw new Error(data.message||'Failed to load data');

                const items = data.items || [];
                const equipmentList = (data.equipmentList||[]).filter(e => Number(e.available||0) > 0);
                const availabilityMap = Object.fromEntries((equipmentList||[]).map(e => [String(e.id), Number(e.available||0)]));

                const html = `
                    <div class=\"bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-t-lg\" style=\"margin:-24px -24px 0 -24px; padding: 20px 24px;\">
                        <div class=\"relative text-center\">
                            <div class=\"flex items-center justify-center gap-2 mb-2\">
                                <svg class=\"w-6 h-6 text-white\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z\"/></svg>
                                <h2 class=\"text-2xl font-bold tracking-tight\">Edit Reservation</h2>
                            </div>
                            <p class=\"text-blue-100 text-sm max-w-lg mx-auto leading-relaxed\">Modify your equipment selection and quantities. Changes are saved in real-time to your reservation.</p>
                            <button id=\"edit_close\" class=\"absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 transition-all duration-200 flex items-center justify-center text-xl font-medium\" onclick=\"Swal.close()\">×</button>
                            <div class=\"mt-2 text-blue-100 text-xs\">Reservation Code: ${code}</div>
                        </div>
                    </div>
                    <div class=\"px-6 pt-4 pb-6 max-h-[75vh] overflow-auto\">
                        <div class=\"grid grid-cols-1 xl:grid-cols-5 gap-6\">
                            <div class=\"xl:col-span-3 space-y-4\">
                                <div class=\"bg-gray-50 rounded-2xl p-4 border border-gray-200\">
                                    <div class=\"flex items-center gap-3 mb-3\">
                                        <svg class=\"w-5 h-5 text-gray-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z\"/></svg>
                                        <h3 class=\"font-semibold text-gray-900\">Browse Equipment</h3>
                                    </div>
                                    <div class=\"relative\">
                                        <svg class=\"w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z\"/></svg>
                                        <input id=\"equip_search\" type=\"text\" placeholder=\"Search by equipment name or category...\" class=\"pl-10 pr-4 py-3 w-full border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white shadow-sm font-medium text-gray-900 placeholder-gray-500\">
                                    </div>
                                </div>

                                <div id=\"equip_grid\" class=\"grid grid-cols-1 md:grid-cols-2 gap-4\">
                                    ${(equipmentList||[]).map(e=>`
                                        <div class=\"group border border-gray-200 rounded-2xl p-5 bg-white shadow-sm hover:shadow-md hover:border-blue-300 transition-all duration-200 cursor-pointer\">
                                            <div class=\"flex items-start justify-between gap-3 mb-4\">
                                                <div class=\"flex-1\">
                                                    <h4 class=\"font-semibold text-gray-900 truncate mb-1\" title=\"${e.label||e.name}\">${(e.label||e.name)}</h4>
                                                    <p class=\"text-sm text-gray-600 flex items-center gap-1\"><svg class=\"w-3 h-3\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z\"/></svg> ${(e.category||'Equipment')}</p>
                                                </div>
                                                <div class=\"flex flex-col items-end gap-1\"><span class=\"inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold ${e.available>0 ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-400 border border-gray-200'}\">${e.available} Available</span></div>
                                            </div>
                                            <div class=\"flex items-end gap-3\">
                                                <div class=\"flex-1\">
                                                    <label class=\"block text-xs font-medium text-gray-700 mb-1\">Quantity</label>
                                                    <input type=\"number\" min=\"1\" value=\"1\" ${e.available?`max=\"${e.available}\"`:''} class=\"w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm sel-qty focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-50 font-medium text-center\">
                                                </div>
                                                <button data-id=\"${e.id}\" data-label=\"${(e.label||e.name)}\" data-avail=\"${e.available}\" class=\"flex-shrink-0 inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 ${e.available>0?'bg-blue-600 hover:bg-blue-700 text-white shadow-sm hover:shadow-md':'bg-gray-200 text-gray-400 cursor-not-allowed'} sel-add\" ${e.available>0?'':'disabled'}>Add</button>
                                            </div>
                                        </div>`).join('')}
                                </div>
                            </div>

                            <div class=\"xl:col-span-2 sticky-summary\">
                                <div class=\"bg-white border border-gray-200 rounded-2xl shadow-sm\">
                                    <div class=\"bg-gradient-to-r from-gray-50 to-gray-100 px-5 py-4 border-b border-gray-200 rounded-t-2xl\">
                                        <div class=\"flex items-center gap-2\"><svg class=\"w-5 h-5 text-gray-600\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2\"/></svg><h3 class=\"text-lg font-semibold text-gray-900\">Reservation Summary</h3></div>
                                        <p class=\"text-sm text-gray-600 mt-1\">Items in your current reservation</p>
                                    </div>
                                    <div id=\"edit_rows\" class=\"divide-y divide-gray-100 min-h-[200px]\">
                                        ${items.length ? items.map(it=>`
                                            <div class=\"group flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors\" data-id=\"${it.id}\" data-eid=\"${it.equipment_id}\"> 
                                                <div class=\"flex-1 pr-3\"> 
                                                    <h4 class=\"font-medium text-gray-900 truncate\" title=\"${it.equipment}\">${it.equipment}</h4> 
                                                    <p class=\"text-sm text-gray-500 mt-1\">Reserved item</p> 
                                                </div> 
                                                <div class=\"flex items-center gap-3\"> 
                                                    <div class=\"text-center\"> 
                                                        <label class=\"block text-xs font-medium text-gray-700 mb-1\">Qty</label> 
                                                        <input type=\"number\" min=\"1\" ${availabilityMap[String(it.equipment_id)]!==undefined?`max=\\\"${availabilityMap[String(it.equipment_id)]}\\\"`:''} value=\"${it.qty}\" class=\"w-16 text-center border border-gray-300 rounded-lg px-2 py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500\"> 
                                                    </div> 
                                                    <button type=\"button\" aria-label=\"Remove item\" title=\"Remove from reservation\" class=\"remove-row p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200\"> 
                                                        <svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"> 
                                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\"/> 
                                                        </svg> 
                                                    </button> 
                                                </div> 
                                            </div>`).join('') : `
                                            <div class=\"px-5 py-12 text-center\"> 
                                                <svg class=\"w-12 h-12 text-gray-300 mx-auto mb-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"> 
                                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4\"/> 
                                                </svg> 
                                                <p class=\"text-gray-500 font-medium\">No items selected yet</p> 
                                                <p class=\"text-sm text-gray-400 mt-1\">Browse equipment on the left to add items</p> 
                                            </div>`}
                                    </div>
                                    <div class=\"px-5 py-4 bg-gray-50 border-t border-gray-200 rounded-b-2xl\">
                                        <div class=\"flex items-center justify-between mb-4\"><span class=\"text-sm font-medium text-gray-700\">Total Items:</span><span id=\"summary_count\" class=\"text-lg font-bold text-gray-900\">${items.reduce((n,i)=>n+Number(i.qty||0),0)}</span></div>
                                        <div class=\"flex flex-col sm:flex-row gap-3\">
                                            <button id=\"edit_undo\" class=\"flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm\"><svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15\"/></svg><span>Reset Changes</span></button>
                                            <button id=\"edit_save\" class=\"flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-sm hover:shadow-md\"><svg class=\"w-4 h-4\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\"/></svg><span>Save Changes</span></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                Swal.fire({
                    buttonsStyling:false,
                    width: 'auto',
                    html: html,
                    showConfirmButton:false,
                    customClass:{ popup:'swal-custom-popup swal-edit-reservation swal-wide-modal' }
                });

                // Wire actions like track page (DOM editing; persist on Save)
                const RES_ID = resId;
                const popup = Swal.getPopup();
                const rowsEl = popup.querySelector('#edit_rows');
                const summaryCount = ()=>{ const total=[...rowsEl.querySelectorAll('input[type=number]')].reduce((n,i)=>n+(parseInt(i.value||'0',10)||0),0); popup.querySelector('#summary_count').textContent = `Total items: ${total}`; };

                function wireRemovers(){ rowsEl.querySelectorAll('.remove-row').forEach(b=> b.onclick = ()=> { b.closest('[data-id], [data-new]')?.remove(); summaryCount(); }); }

                // Add from selector grid
                popup.querySelectorAll('.sel-add').forEach(btn=>{
                    btn.onclick = ()=>{
                        if (btn.hasAttribute('disabled')) return;
                        const card = btn.closest('.border');
                        const qtyInput = card.querySelector('.sel-qty');
                        const maxAvail = parseInt(btn.getAttribute('data-avail')||'0',10);
                        let qty = Math.max(1, parseInt(qtyInput.value||'1',10));
                        if (maxAvail && qty > maxAvail) { qty = maxAvail; qtyInput.value = String(qty); }
                        const label = btn.getAttribute('data-label');
                        const equipId = btn.getAttribute('data-id');
                        const existingRow = rowsEl.querySelector(`[data-eid="${equipId}"]`);
                        if (existingRow) {
                            const existingQtyInput = existingRow.querySelector('input[type="number"]');
                            if (existingQtyInput) { const currentQty = parseInt(existingQtyInput.value||'0',10); const newQty = Math.min(currentQty + qty, maxAvail || 999); existingQtyInput.value = String(newQty); summaryCount(); }
                            return;
                        }
                        const row = document.createElement('div');
                        row.setAttribute('data-new','1'); row.setAttribute('data-eid', equipId);
                        row.className = 'group flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors';
                        row.innerHTML = `
                            <div class="flex-1 pr-3">
                                <h4 class="font-medium text-gray-900 truncate" title="${label}">${label}</h4>
                                <p class="text-sm text-gray-500 mt-1">New item</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="text-center">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Qty</label>
                                    <input type="number" min="1" value="${qty}" class="w-16 text-center border border-gray-300 rounded-lg px-2 py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <button type="button" aria-label="Remove item" title="Remove from reservation" class="remove-row p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <input type="hidden" class="eq-id" value="${equipId}">
                            </div>`;
                        rowsEl.appendChild(row); wireRemovers(); summaryCount();
                    };
                });

                rowsEl.addEventListener('input', (e)=>{
                    if (e.target && e.target.matches('input[type=number]')) {
                        let v = parseInt(e.target.value||'1',10); if (isNaN(v) || v < 1) v = 1; e.target.value = String(v); summaryCount();
                    }
                });

                const ORIGINAL_SNAPSHOT = items.map(it => ({ id: it.id, equipment_id: it.equipment_id, equipment: it.equipment, qty: it.qty }));
                function renderRowsFromSnapshot(snapshot){
                    rowsEl.innerHTML = snapshot.map(it => {
                        const maxAttr = (availabilityMap[String(it.equipment_id)]!==undefined) ? `max="${availabilityMap[String(it.equipment_id)]}"` : '';
                        return `<div class=\"group flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors\" data-id=\"${it.id}\" data-eid=\"${it.equipment_id}\">`
                            + `<div class=\"flex-1 pr-3\">`
                            + `<h4 class=\"font-medium text-gray-900 truncate\" title=\"${it.equipment}\">${it.equipment}</h4>`
                            + `<p class=\"text-sm text-gray-500 mt-1\">Reserved item</p>`
                            + `</div>`
                            + `<div class=\"flex items-center gap-3\">`
                            + `<div class=\"text-center\">`
                            + `<label class=\"block text-xs font-medium text-gray-700 mb-1\">Qty</label>`
                            + `<input type=\"number\" min=\"1\" ${maxAttr} value=\"${it.qty}\" class=\"w-16 text-center border border-gray-300 rounded-lg px-2 py-2 text-sm font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500\">`
                            + `</div>`
                            + `<button type=\"button\" aria-label=\"Remove item\" title=\"Remove from reservation\" class=\"remove-row p-2 rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200\">`
                            + `<svg class=\"w-5 h-5\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\"/></svg>`
                            + `</button>`
                            + `</div>`
                            + `</div>`;
                    }).join('');
                    wireRemovers(); summaryCount();
                }
                wireRemovers(); summaryCount();

                popup.querySelector('#edit_undo').onclick = () => { renderRowsFromSnapshot(ORIGINAL_SNAPSHOT); };
                popup.querySelector('#edit_save').onclick = async ()=>{
                    const summaryRows = Array.from(rowsEl.children).filter(el => el.hasAttribute('data-id') || el.hasAttribute('data-new'));

                    // If empty, warn about cancellation (match track page behavior)
                    if (summaryRows.length === 0) {
                        const close = ()=> Swal.close();
                        close();
                        Swal.fire({
                            buttonsStyling:false,
                            html:`
                                <div class="bg-red-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">No Equipment Selected</h2></div>
                                <div class="text-left">
                                    <p class="text-sm text-gray-700">Your summary is empty. Proceeding will cancel this reservation. This action cannot be undone.</p>
                                </div>
                                <div class="flex justify-end mt-6 gap-2">
                                    <button class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded" id="keep_editing_btn">Keep Editing</button>
                                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded" id="proceed_cancel_btn">Proceed Anyway</button>
                                </div>
                            `,
                            showConfirmButton:false,
                            customClass:{ popup:'swal-custom-popup' },
                            zIndex: 12000
                        });
                        const keep = document.getElementById('keep_editing_btn');
                        const proceed = document.getElementById('proceed_cancel_btn');
                        keep && (keep.onclick = ()=> { Swal.close(); openInstructorFullEdit(RES_ID, code); });
                        proceed && (proceed.onclick = async ()=>{
                            Swal.fire({
                                buttonsStyling:false,
                                html:`<div class="bg-red-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">Cancelling...</h2></div>
                                      <div class="p-4 text-center text-sm text-gray-700">Please wait while we cancel your reservation.</div>`,
                                allowOutsideClick:false,
                                didOpen:()=>{ Swal.showLoading(); },
                                zIndex: 12000
                            });
                            try {
                                const r = await fetch(`/instructor/reservations/${RES_ID}/cancel`, { method:'POST', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content, 'X-Requested-With':'XMLHttpRequest' }, body: JSON.stringify({ remarks: 'Auto-cancelled due to removing all items via edit modal' })});
                                const d = await r.json();
                                Swal.close();
                                if(d && d.success){
                                    Swal.fire({
                                        buttonsStyling:false,
                                        html:`
                                            <div class="bg-green-600 text-white p-4 -m-6 mb-4 rounded-t-lg"><h2 class="text-xl font-bold text-center">Reservation Cancelled</h2></div>
                                            <div class="p-4 text-center text-sm text-gray-700">Your reservation has been cancelled successfully.</div>
                                        `,
                                        showConfirmButton:true
                                    }).then(()=> window.location.reload());
                                } else {
                                    Swal.fire('Failed', (d && d.message) || 'Failed to cancel reservation.','error');
                                }
                            } catch(err){ Swal.fire('Failed', err.message||'Could not cancel reservation.','error'); }
                        });
                        return; // stop normal save
                    }

                    // Build operations
                    const toUpdate = [];
                    const toAdd = [];
                    const toRemove = [];
                    const presentExistingIds = new Set();
                    summaryRows.forEach(el=>{
                        const qty = parseInt(el.querySelector('input[type="number"]').value||'1',10);
                        if (el.hasAttribute('data-new')){
                            const eid = el.querySelector('.eq-id')?.value || el.getAttribute('data-eid');
                            toAdd.push({ equipment_id: eid, quantity: qty });
                        } else {
                            const id = el.getAttribute('data-id'); presentExistingIds.add(id); toUpdate.push({ id, quantity: qty });
                        }
                    });
                    // Any ORIGINAL items not present now should be removed
                    ORIGINAL_SNAPSHOT.forEach(it=>{ if (!presentExistingIds.has(String(it.id))) { toRemove.push({ id: it.id }); } });

                    try{
                        // Apply removals
                        for (const rm of toRemove){
                            const r = await fetch(`/reservations/${RES_ID}/items/${rm.id}`, { method:'POST', headers:{ 'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify({})});
                            const j = await r.json(); if (!r.ok || !j.success) throw new Error(j.message||'Failed removing item');
                        }
                        // Apply updates
                        for (const up of toUpdate){
                            const r = await fetch(`/reservations/${RES_ID}/items/${up.id}/quantity`, { method:'POST', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify({ quantity: up.quantity })});
                            const j = await r.json(); if (!r.ok || !j.success) throw new Error(j.message||'Failed updating quantity');
                        }
                        // Apply additions
                        for (const ad of toAdd){
                            const r = await fetch(`/reservations/${RES_ID}/items`, { method:'POST', headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content }, body: JSON.stringify(ad)});
                            const j = await r.json(); if (!r.ok || !j.success) throw new Error(j.message||'Failed adding item');
                        }
                        window.location.reload();
                    }catch(e){ Swal.fire('Failed', e.message||'Could not save changes.','error'); }
                };
            }catch(e){
                Swal.fire('Failed', e.message||'Could not open editor.','error');
            }
        }
        // Show success modal if there's a success message
        <?php if(session('success')): ?>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Reservation Submitted Successfully!</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700"><?php echo e(session('success')); ?></p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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

        // Show error modal if there's an error message
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

        // Cancel confirmation modal
        function showCancelConfirmation(reservationId, userName, reservationCode) {
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-orange-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Cancel Reservation</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700 text-lg font-medium">Are you sure you want to cancel this reservation?</p>
                        <p class="text-gray-600 text-sm mt-2">Reservation Code: <strong>${reservationCode}</strong></p>
                        <p class="text-gray-600 text-sm">This action will cancel your reservation and restore equipment availability.</p>
                    </div>
                    <div class="flex justify-center space-x-4 mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                            Keep Reservation
                        </button>
                        <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" onclick="cancelReservation('${reservationId}')">
                            Yes, Cancel
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

        // Function to toggle custom reason textarea
        function toggleCustomReason() {
            const reasonSelect = document.getElementById('cancel_reason_select');
            const customReasonDiv = document.getElementById('custom_reason_div');
            const customReasonInput = document.getElementById('cancel_remarks_input');

            if (reasonSelect.value === 'other') {
                customReasonDiv.classList.remove('hidden');
                customReasonInput.required = true;
            } else {
                customReasonDiv.classList.add('hidden');
                customReasonInput.required = false;
                customReasonInput.value = '';
            }
        }

        // Function to handle reservation cancellation
        function cancelReservation(reservationId) {
            // No reason required for instructor's own reservation cancellation
            let remarks = 'Instructor cancelled their own reservation';

            // Show loading
            Swal.fire({
                title: 'Cancelling...',
                text: 'Please wait while we cancel your reservation.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Make AJAX request
            fetch(`/instructor/reservations/${reservationId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    remarks: remarks
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '',
                        html: `
                            <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Reservation Cancelled</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-lg font-medium">Your reservation has been cancelled successfully.</p>
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
                    Swal.fire({
                        title: '',
                        html: `
                            <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Cancellation Failed</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 text-lg font-medium">${data.message || 'Failed to cancel reservation. Please try again.'}</p>
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
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Cancellation Failed</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg font-medium">An error occurred while cancelling the reservation. Please try again.</p>
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
            });
        }

        // Function to change rows per page
        function changePerPage(perPage) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', perPage);
            url.searchParams.delete('page'); // Reset to first page
            window.location.href = url.toString();
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


<?php /**PATH C:\Users\Bryan\SEMS\SEMSv25\resources\views/instructor/reservations/index.blade.php ENDPATH**/ ?>