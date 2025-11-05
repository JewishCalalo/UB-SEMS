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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Notifications')); ?>

            </h2>
            <?php if($unreadCount > 0): ?>
                <button onclick="markAllAsRead()" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm">
                    Mark All as Read
                </button>
            <?php endif; ?>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Notifications']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Notifications']
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
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Notifications</h3>
                        <p class="text-gray-600 font-medium">Stay updated with your reservation and equipment status</p>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-bell mr-2 text-red-500"></i>
                        <?php echo e($unreadCount); ?> Unread
                    </div>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <?php if($notifications->count() > 0): ?>
                    <div class="divide-y divide-gray-200">
                        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-6 hover:bg-gray-50 transition-colors <?php echo e(!$notification->is_read ? 'bg-red-50 border-l-4 border-red-500' : ''); ?>" 
                                 data-notification-id="<?php echo e($notification->id); ?>">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <?php if(!$notification->is_read): ?>
                                                <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0"></div>
                                            <?php endif; ?>
                                            
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900 <?php echo e(!$notification->is_read ? 'font-bold' : ''); ?>">
                                                    <?php echo e($notification->title); ?>

                                                </h4>
                                                <p class="text-sm text-gray-600 mt-1"><?php echo e($notification->message); ?></p>
                                                
                                                <?php if($notification->data): ?>
                                                    <div class="mt-2 text-xs text-gray-500">
                                                        <?php if(isset($notification->data['reservation_id'])): ?>
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                                Reservation #<?php echo e($notification->data['reservation_id']); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(isset($notification->data['equipment_id'])): ?>
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                                                Equipment ID: <?php echo e($notification->data['equipment_id']); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                        
                                                        <?php if(isset($notification->data['incident_id'])): ?>
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 ml-2">
                                                                Incident #<?php echo e($notification->data['incident_id']); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4 ml-4">
                                        <div class="text-right">
                                            <div class="text-sm text-gray-500">
                                                <?php echo e($notification->created_at->diffForHumans()); ?>

                                            </div>
                                            <?php if($notification->read_at): ?>
                                                <div class="text-xs text-gray-400">
                                                    Read <?php echo e($notification->read_at->diffForHumans()); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <?php if(!$notification->is_read): ?>
                                            <button onclick="markAsRead(<?php echo e($notification->id); ?>)" 
                                                    class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                Mark as Read
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5-5-5h5v-5a7.5 7.5 0 00-15 0v5h5l-5 5-5-5h5v-5a7.5 7.5 0 0115 0v5z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                        <p class="mt-1 text-sm text-gray-500">You're all caught up! No new notifications.</p>
                    </div>
                <?php endif; ?>
            </div>
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

<script>
function markAsRead(notificationId) {
    fetch(`/instructor/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the unread styling
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.classList.remove('bg-red-50', 'border-l-4', 'border-red-500');
                notificationElement.querySelector('.font-bold').classList.remove('font-bold');
                notificationElement.querySelector('.bg-red-500').remove();
                
                // Add read timestamp
                const readTime = new Date().toLocaleString();
                const readInfo = document.createElement('div');
                readInfo.className = 'text-xs text-gray-400';
                readInfo.textContent = `Read just now`;
                notificationElement.querySelector('.text-right').appendChild(readInfo);
                
                // Remove the mark as read button
                const markAsReadButton = notificationElement.querySelector('button[onclick*="markAsRead"]');
                if (markAsReadButton) {
                    markAsReadButton.remove();
                }
            }
            
            // Update unread count
            updateUnreadCount();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to mark notification as read', 'error');
    });
}

function markAllAsRead() {
    fetch('/instructor/notifications/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove all unread styling
            document.querySelectorAll('[data-notification-id]').forEach(element => {
                element.classList.remove('bg-red-50', 'border-l-4', 'border-red-500');
                element.querySelector('.font-bold')?.classList.remove('font-bold');
                element.querySelector('.bg-red-500')?.remove();
                
                // Remove mark as read buttons
                element.querySelectorAll('button[onclick*="markAsRead"]').forEach(button => button.remove());
            });
            
            // Update unread count
            updateUnreadCount();
            
            showNotification('All notifications marked as read', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to mark all notifications as read', 'error');
    });
}

function updateUnreadCount() {
    fetch('/instructor/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const unreadElement = document.querySelector('.text-sm.text-gray-600.bg-white');
            if (unreadElement) {
                unreadElement.innerHTML = `<i class="fas fa-bell mr-2 text-red-500"></i>${data.count} Unread`;
            }
        });
}

// Auto-refresh unread count every 30 seconds
setInterval(updateUnreadCount, 30000);
</script>
<?php /**PATH C:\UB-SEMS\resources\views\instructor\notifications\index.blade.php ENDPATH**/ ?>