<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>SEMS - Sports Equipment Management System</title>
    <meta name="welcome-search-url" content="<?php echo e(route('welcome.search')); ?>">
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/ub-logo.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('images/ub-logo.png')); ?>">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/js/app.js',
        'resources/js/components/welcome.js',
        'resources/js/components/searchFilter.js',
        'resources/js/components/sweetalert2-utils.js',
        'resources/css/app.css', 
        'resources/css/components/buttons.css',
        'resources/css/modules/auth.css',
        'resources/css/modules/welcome.css',
        'resources/css/sweetalert2-custom.css'
    ]); ?>
    
    <script>
        // Backup toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Backup script loaded');
            
            const toggleButton = document.querySelector('[data-action="toggle-filter"]');
            const content = document.getElementById('searchFilterContent');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            
            console.log('Elements found:', { toggleButton, content, toggleText, toggleIcon });
            
            if (toggleButton && content && toggleText && toggleIcon) {
                toggleButton.addEventListener('click', function(e) {
                    console.log('Button clicked!');
                    e.preventDefault();
                    
                    const isHidden = content.style.display === 'none' || content.style.display === '';
                    content.style.display = isHidden ? 'block' : 'none';
                    toggleText.textContent = isHidden ? 'Hide' : 'Show';
                    toggleIcon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
                    
                    console.log('Content display:', content.style.display);
                    console.log('Toggle text:', toggleText.textContent);
                });
                
                console.log('Event listener added successfully');
            } else {
                console.error('Some elements not found');
            }
        });
    </script>

    </head>

<body class="public-page">
    <!-- Notification System -->
    <?php if (isset($component)) { $__componentOriginal68e99e2a65707d22244bbd4c793cabb3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68e99e2a65707d22244bbd4c793cabb3 = $attributes; } ?>
<?php $component = App\View\Components\FlashNotifications::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flash-notifications'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FlashNotifications::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68e99e2a65707d22244bbd4c793cabb3)): ?>
<?php $attributes = $__attributesOriginal68e99e2a65707d22244bbd4c793cabb3; ?>
<?php unset($__attributesOriginal68e99e2a65707d22244bbd4c793cabb3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68e99e2a65707d22244bbd4c793cabb3)): ?>
<?php $component = $__componentOriginal68e99e2a65707d22244bbd4c793cabb3; ?>
<?php unset($__componentOriginal68e99e2a65707d22244bbd4c793cabb3); ?>
<?php endif; ?>
    
    <!-- Navigation -->
    <?php if (isset($component)) { $__componentOriginal27f402f979cba4f345c18ac5d011cb75 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal27f402f979cba4f345c18ac5d011cb75 = $attributes; } ?>
<?php $component = App\View\Components\WelcomeNavigation::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('welcome-navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\WelcomeNavigation::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal27f402f979cba4f345c18ac5d011cb75)): ?>
<?php $attributes = $__attributesOriginal27f402f979cba4f345c18ac5d011cb75; ?>
<?php unset($__attributesOriginal27f402f979cba4f345c18ac5d011cb75); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal27f402f979cba4f345c18ac5d011cb75)): ?>
<?php $component = $__componentOriginal27f402f979cba4f345c18ac5d011cb75; ?>
<?php unset($__componentOriginal27f402f979cba4f345c18ac5d011cb75); ?>
<?php endif; ?>

    <!-- Hero Section -->
    <div class="bg-red-600 text-white py-12 sm:py-16 shadow-inner relative z-[100]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl font-bold mb-4 drop-shadow">Sports Equipment Management System</h1>
            <p class="text-lg sm:text-xl mb-8 drop-shadow">University of Baguio Physical Education Office</p>
        </div>
    </div>


    <!-- Available Equipment Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 space-y-3 sm:space-y-0">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Sport Equipments</h2>
                <div class="flex flex-col sm:flex-row sm:items-center space-y-1 sm:space-y-0 sm:space-x-4 mt-1">
                    <span class="text-sm text-gray-500">Explore and add to your reservation box</span>
                    <span id="searchResultsCounter" class="text-sm font-medium text-blue-600" style="display: none;">
                        <span id="resultsCount">0</span> results found
                    </span>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div id="searchLoadingIndicator" class="hidden">
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <svg class="animate-spin h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Searching...</span>
                    </div>
                </div>
            </div>
        </div>
    

        <!-- Search and Filters -->
        

        <!-- Search and Filter Toggle Section -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-lg mb-6 p-4">
            <div class="flex justify-between items-center">
                <h4 class="text-lg font-semibold text-gray-900">Search & Filter</h4>
                <button class="actions__button actions__button--dropdown"  type="button" data-action="toggle-filter">
                    <span id="toggleText">Show</span>
                    <svg id="toggleIcon" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Search and Filters Content -->
        <div id="searchFilterContent" class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6" style="display: none;">
            <div class="p-4 sm:p-6">
                <form id="dynamicSearchForm" class="space-y-4 sm:space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Search Equipment</label>
                            <input type="text" name="search" id="searchInput" value="<?php echo e(request('search')); ?>"
                                placeholder="Equipment name, model, or type..."
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Category</label>
                            <select name="category" id="categorySelect" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Equipment Type</label>
                            <select name="equipment_type" id="equipmentTypeSelect" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                <option value="">All Types</option>
                                <?php $__currentLoopData = $equipmentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->id); ?>" data-category-id="<?php echo e($type->category_id); ?>" <?php echo e(request('equipment_type') == $type->id ? 'selected' : ''); ?>>
                                        <?php echo e($type->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <p id="equipmentTypeHelp" class="text-xs text-gray-500">Select a category first to enable equipment types.</p>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Availability</label>
                            <select name="availability" id="availabilitySelect" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                <option value="">All Availability</option>
                                <option value="available" <?php echo e(request('availability') == 'available' ? 'selected' : ''); ?>>Available</option>
                                <option value="unavailable" <?php echo e(request('availability') == 'unavailable' ? 'selected' : ''); ?>>Unavailable</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2 lg:col-span-1 space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Actions</label>
                            <div class="flex space-x-2">
                                <button type="button" id="clearFiltersButton" class="actions__button actions__button--clear flex-1">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="hidden sm:inline">Clear</span>
                                    <span class="sm:hidden">Clear</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <?php if(isset($error)): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-md">
                <div class="flex items-center" class="notification__icon">
                    <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path class="notification__icon"  stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-red-800">Error Loading Equipment</h3>
                        <p class="text-sm text-red-700 mt-1"><?php echo e($error); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(request('availability') == 'unavailable'): ?>
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-yellow-800">Unavailable Equipment</h3>
                        <p class="text-sm text-yellow-700 mt-1">These items are currently under maintenance. You can add them to your wishlist to be notified when they become available again.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Dynamic Equipment Container -->
        <div id="equipmentContainer">
            <?php echo $__env->make('components.equipment-grid', ['equipment' => $equipment], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

    <!-- Floating Reservation Box Button -->
    <button id="floatingReservationButton" onclick="proceedToReservation()" class="fixed bottom-6 right-6 z-50 shadow-lg rounded-full flex items-center justify-center floating__button">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l1.5 7m6.5-7l-1.5 7M9 21a2 2 0 110-4 2 2 0 010 4zm8 0a2 2 0 110-4 2 2 0 010 4z" />
        </svg>
        <span id="fabReservationCount" class="absolute -top-1 -right-1 inline-flex items-center justify-center rounded-full text-xs font-semibold">0</span>
    </button>


    </div>

    <!-- Features Section -->
    <div class="bg-gray-800 py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-white mb-6 sm:mb-8">System Features</h2>
            <!-- System Features -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mb-12">
                <div class="text-center">
                    <div class="bg-red-100 dark:bg-red-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">Browse & Filter Equipment</h3>
                    <p class="text-sm sm:text-base text-gray-300">Search by name, category, type, and availability status.</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 dark:bg-green-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11zm0 2v3m-6 4h12a2 2 0 002-2V10a2 2 0 00-2-2h-1V7a5 5 0 10-10 0v1H6a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">Guest Reservations</h3>
                    <p class="text-sm sm:text-base text-gray-300">Reserve equipment without creating an account.</p>
                </div>
                <div class="text-center">
                    <div class="bg-purple-100 dark:bg-purple-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold mb-2 text-white">Track Reservations</h3>
                    <p class="text-sm sm:text-base text-gray-300">Monitor your reservation status with tracking codes.</p>
                </div>
            </div>
            
            <!-- Additional Features for Mobile -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6 sm:hidden">
                <div class="text-center">
                    <div class="bg-blue-100 dark:bg-blue-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h4 class="text-base font-semibold mb-2">Equipment Management</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Staff can manage inventory and maintenance.</p>
                </div>
                <div class="text-center">
                    <div class="bg-yellow-100 dark:bg-yellow-900 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94-1.543.826-3.31-2.37-2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-base font-semibold mb-2">Maintenance Records</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Track equipment condition and maintenance history.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php if (isset($component)) { $__componentOriginal222c87a019257fb1d70ae0ff46ab02e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.site-footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('site-footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1)): ?>
<?php $attributes = $__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1; ?>
<?php unset($__attributesOriginal222c87a019257fb1d70ae0ff46ab02e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal222c87a019257fb1d70ae0ff46ab02e1)): ?>
<?php $component = $__componentOriginal222c87a019257fb1d70ae0ff46ab02e1; ?>
<?php unset($__componentOriginal222c87a019257fb1d70ae0ff46ab02e1); ?>
<?php endif; ?>

    <!-- Equipment Details Modal -->
    <div id="equipmentDetailsModal" class="hidden fixed inset-0 bg-gray-900/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-2 sm:p-4">
        <div class="relative w-full max-w-7xl bg-white rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95 opacity-0">
            <!-- Modal Header with Improved Gradient -->
            <div class="details__header w-full bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center justify-between">
                <div class="w-full px-4 sm:px-6 py-3 sm:py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-lg sm:text-xl font-semibold text-white">Equipment Details</h3>
                    </div>
                    <button onclick="closeEquipmentDetailsModal()" class="p-2 rounded-full hover:bg-indigo-600 transition-all duration-200 transform hover:rotate-90">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Approval Process Information removed per requirement -->
            
            <!-- Modal Content with Improved Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 p-4 sm:p-6 max-h-[70vh] overflow-y-auto">
                <!-- Left Column: Equipment Details -->
                <div class="lg:col-span-1 space-y-4 sm:space-y-6">
                    <!-- Equipment Information Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div class="h-8 w-1 sm:h-10 sm:w-1 bg-blue-600 rounded-full mr-3"></div>
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-blue-600">Equipment Information</h4>
                        </div>
                        <div class="space-y-3 sm:space-y-4">
                            <div class="bg-blue-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                                <p id="modalEquipmentName" class="text-sm text-gray-900 font-semibold"></p>
                            </div>
                            
                            <div class="bg-blue-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Category</label>
                                <p id="modalEquipmentCategory" class="text-sm text-gray-700 font-bold"></p>
                            </div>
                            
                            <div class="bg-blue-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Equipment Type</label>
                                <p id="modalEquipmentType" class="text-sm text-gray-700 font-bold"></p>
                            </div>
                            
                            <div class="bg-blue-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Overall Condition</label>
                                <div class="flex items-center mt-1">
                                    <div id="conditionMeter" class="h-2 bg-gray-200 rounded-full w-full mr-2">
                                        <div id="conditionProgress" class="h-2 rounded-full"></div>
                                    </div>
                                    <p id="modalEquipmentCondition" class="text-sm font-bold text-gray-700 w-16 text-right"></p>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50/50 p-2 sm:p-3 rounded-lg">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Availability</label>
                                <div class="flex items-center justify-between mt-1">
                                    <p id="modalEquipmentQuantity" class="text-sm text-gray-900 font-semibold"></p>
                                    <div id="availabilityBadge" class="px-2 py-1 rounded-full text-xs font-medium"></div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Description Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div class="h-8 w-1 sm:h-10 sm:w-1 bg-blue-600 rounded-full mr-3"></div>
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-blue-600">Description</h4>
                        </div>
                        <p id="modalEquipmentDescription" class="text-sm text-gray-700 leading-relaxed bg-blue-50/30 p-2 sm:p-3 rounded-lg"></p>
                    </div>
    
                    <!-- Images Card -->
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 sm:p-5 shadow-sm border border-gray-100">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <div class="h-8 w-1 sm:h-10 sm:w-1 bg-blue-600 rounded-full mr-3"></div>
                            <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-blue-600">Image</h4>
                        </div>
                        <div id="modalEquipmentImages" class="grid grid-cols-2 gap-2 sm:gap-3">
                            <!-- Images will be populated here -->
                        </div>
                    </div>
                </div>
    
                <!-- Right Column: Instances Table -->
                <div class="lg:col-span-2">
                    <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl overflow-hidden shadow-sm border border-gray-100 h-full">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="h-8 w-1 sm:h-10 sm:w-1 bg-blue-600 rounded-full mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 text-sm sm:text-base uppercase tracking-wide text-blue-700">Equipment Instances</h4>
                                    <p class="text-xs text-gray-600 mt-1">Detailed view of all available instances and their current status</p>
                                </div>
                            </div>
                        </div>
                        <div id="modalEquipmentInstances" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Instance Code
                                        </th>
                                        <th scope="col" class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Availability
                                        </th>
                                        <th scope="col" class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Condition
                                        </th>
                                        <th scope="col" class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Notes
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="modalEquipmentInstancesBody" class="bg-white divide-y divide-gray-200">
                                    <!-- Instances will be populated here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Modal Footer -->
            <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 flex justify-end">
                <button onclick="closeEquipmentDetailsModal()" class="px-3 sm:px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>



</body>
</html>

    <script>
        // Mobile reservation button synchronization
        document.addEventListener('DOMContentLoaded', function() {
            const mobileReservationButton = document.getElementById('mobileReservationButton');
            const mobileReservationCount = document.getElementById('mobileReservationCount');
            const reservationButton = document.getElementById('reservationButton');
            const reservationCount = document.getElementById('reservationCount');
            const reservationDropdown = document.getElementById('reservationDropdown');
            
            // Synchronize reservation counts
            function updateReservationCounts(count) {
                if (reservationCount) reservationCount.textContent = count;
                if (mobileReservationCount) mobileReservationCount.textContent = count;
            }
            
            // Toggle reservation dropdown for mobile
            if (mobileReservationButton) {
                mobileReservationButton.addEventListener('click', function() {
                    if (reservationDropdown) {
                        reservationDropdown.classList.toggle('hidden');
                    }
                });
            }
            
            // Close reservation dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!reservationButton?.contains(event.target) && !mobileReservationButton?.contains(event.target) && !reservationDropdown?.contains(event.target)) {
                    if (reservationDropdown) {
                        reservationDropdown.classList.add('hidden');
                    }
                }
            });
            
            // Initialize reservation counts from localStorage
            function initializeReservationCounts() {
                try {
                    const savedReservation = localStorage.getItem('sems_reservation');
                    if (savedReservation) {
                        const reservation = JSON.parse(savedReservation);
                        const totalItems = reservation.reduce((sum, item) => sum + (item.quantity || 0), 0);
                        updateReservationCounts(totalItems);
                    } else {
                        updateReservationCounts(0);
                    }
                } catch (e) {
                    console.error('Error initializing reservation counts:', e);
                    updateReservationCounts(0);
                }
            }
            
            // Initialize reservation counts
            initializeReservationCounts();
            
            // Listen for reservation updates from other components
            window.addEventListener('storage', function(e) {
                if (e.key === 'sems_reservation') {
                    try {
                        const reservation = JSON.parse(e.newValue || '[]');
                        const totalItems = reservation.reduce((sum, item) => sum + (item.quantity || 0), 0);
                        updateReservationCounts(totalItems);
                    } catch (e) {
                        console.error('Error updating reservation counts from storage:', e);
                    }
                }
            });
            
            // Custom event listener for reservation updates
            window.addEventListener('reservationUpdated', function() {
                initializeReservationCounts();
            });
        });
        
        // Mobile-friendly search and filter toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('[data-action="toggle-filter"]');
            const filterContent = document.getElementById('searchFilterContent');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (toggleButton && filterContent) {
                toggleButton.addEventListener('click', function() {
                    const isHidden = filterContent.style.display === 'none';
                    filterContent.style.display = isHidden ? 'block' : 'none';
                    toggleText.textContent = isHidden ? 'Hide' : 'Show';
                    toggleIcon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
                });
            }
        });
        
        // Mobile-responsive equipment grid
        function adjustEquipmentGrid() {
            const container = document.getElementById('equipmentContainer');
            if (container && window.innerWidth < 768) {
                // Add mobile-specific classes for better mobile layout
                container.classList.add('space-y-4');
                container.classList.remove('grid', 'grid-cols-1', 'md:grid-cols-2', 'lg:grid-cols-3', 'gap-6');
            }
        }
        
        // Call on load and resize
        window.addEventListener('load', adjustEquipmentGrid);
        window.addEventListener('resize', adjustEquipmentGrid);
        
        // Mobile-friendly floating button
        function adjustFloatingButton() {
            const floatingButton = document.getElementById('floatingReservationButton');
            if (floatingButton) {
                if (window.innerWidth < 768) {
                    floatingButton.style.bottom = '1rem';
                    floatingButton.style.right = '1rem';
                } else {
                    floatingButton.style.bottom = '1.5rem';
                    floatingButton.style.right = '1.5rem';
                }
            }
        }
        
        // Call on load and resize
        window.addEventListener('load', adjustFloatingButton);
        window.addEventListener('resize', adjustFloatingButton);
    </script>

<?php /**PATH C:\UB-SEMS\resources\views\welcome.blade.php ENDPATH**/ ?>