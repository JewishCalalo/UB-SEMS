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
        <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center gap-3">
            <?php echo e(__('Blacklisted Emails')); ?>

            <span class="inline-flex items-center text-sm font-bold rounded-full px-3 py-1.5 bg-gradient-to-r from-red-600 to-red-700 text-white shadow-sm"><?php echo e(number_format($items->total())); ?></span>
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php $__env->startPush('head'); ?>
                <?php echo app('Illuminate\Foundation\Vite')('resources/js/components/sweetalert2-utils.js'); ?>
            <?php $__env->stopPush(); ?>
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Lost & Damaged'],
                ['label' => 'Blacklisted Emails']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Lost & Damaged'],
                ['label' => 'Blacklisted Emails']
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

            <!-- Themed intro section -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-6">
                    <h3 class="text-2xl font-bold mb-2">Blacklist Management</h3>
                    <p class="text-red-100 text-sm font-medium">Control access to reservation system</p>
                </div>
                <div class="p-8">
                    <p class="text-gray-700 text-base leading-relaxed font-medium">
                        Manage emails prevented from making reservations due to unresolved lost or damaged items. 
                        You can search, filter, and release emails when appropriate.
                    </p>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl shadow-lg mb-8 p-6">
                <div class="flex justify-between items-center">
                    <h4 class="text-xl font-bold text-gray-900">Search & Filter</h4>
                    <button type="button" onclick="toggleSearchFilter()"
                            class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <span id="toggleText">Show</span>
                        <svg id="toggleIcon" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div id="searchFilterContent" class="bg-white border border-gray-200 rounded-xl shadow-lg mb-8" style="display: none;">
                <div class="p-8">
                    <form method="GET" action="<?php echo e(route('blacklist.index')); ?>" id="blacklistSearchForm" class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="block text-base font-bold text-gray-800">Search Email</label>
                                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Enter email address to search..." 
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-base font-medium transition-all duration-200">
                            </div>
                            <div class="space-y-3 flex items-end">
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-base font-bold rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200">
                                    Apply Filters
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-lg font-semibold text-gray-900">Action Legend</h4>
                    <button type="button" onclick="ManagementCommon.toggleActionLegend()"
                            class="inline-flex items-center gap-2 px-3 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md hover:scale-105 transition-all duration-200"
                            onmouseover="this.style.transform='scale(1.05)'"
                            onmouseout="this.style.transform='scale(1)'">
                        <span id="actionLegendToggleText">Hide</span>
                        <svg id="actionLegendToggleIcon" class="w-4 h-4 transition-transform duration-200 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
                <div id="actionLegendContent" class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm bg-gradient-to-r from-emerald-500 to-green-600">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">Release</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Blacklisted Emails</h3>
                        <?php if (isset($component)) { $__componentOriginale43a0c64c2ca4729d3c5b59fae0856df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale43a0c64c2ca4729d3c5b59fae0856df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.table-pagination','data' => ['paginator' => $items]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table-pagination'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paginator' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($items)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale43a0c64c2ca4729d3c5b59fae0856df)): ?>
<?php $attributes = $__attributesOriginale43a0c64c2ca4729d3c5b59fae0856df; ?>
<?php unset($__attributesOriginale43a0c64c2ca4729d3c5b59fae0856df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale43a0c64c2ca4729d3c5b59fae0856df)): ?>
<?php $component = $__componentOriginale43a0c64c2ca4729d3c5b59fae0856df; ?>
<?php unset($__componentOriginale43a0c64c2ca4729d3c5b59fae0856df); ?>
<?php endif; ?>
                    </div>
                    
                    <?php if($items->count() > 0): ?>
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
                    <?php endif; ?>

                    <div id="blacklistTableWrapper" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-red-600">
                                <tr>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Email Address</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Reason</th>
                                    <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($item->email); ?></div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500"><?php echo e($item->reason ?: '—'); ?></div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                            <form method="POST" action="<?php echo e(route('blacklist.release')); ?>" onsubmit="return handleRelease(event, this)" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="email" value="<?php echo e($item->email); ?>">
                                                <button type="submit" title="Release from blacklist" aria-label="Release from blacklist"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg shadow-sm bg-gradient-to-r from-emerald-500 to-green-600 text-white hover:shadow-md hover:scale-105 transition-all duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="px-3 sm:px-6 py-8 text-center">
                                            <div class="text-gray-500 text-sm font-medium">No blacklisted emails found.</div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4"><?php echo e($items->links()); ?></div>
                    <script>
                        function toggleSearchFilter(){
                            const c=document.getElementById('searchFilterContent');
                            const t=document.getElementById('toggleText');
                            const i=document.getElementById('toggleIcon');
                            if(!c||!t||!i) return;
                            const show = c.style.display==='none'||c.style.display==='';
                            c.style.display = show ? 'block' : 'none';
                            t.textContent = show ? 'Hide' : 'Show';
                            i.style.transform = show ? 'rotate(180deg)' : 'rotate(0deg)';
                        }

                        function handleRelease(e, form){
                            e.preventDefault();
                            Swal.fire({
                                title: '',
                                html: `
                                    <div class="bg-gradient-to-r from-emerald-600 to-green-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                                        <h2 class="text-xl font-bold">Release email from blacklist?</h2>
                                    </div>
                                    <div class="space-y-4 text-left">
                                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                            <div class="flex items-start gap-3">
                                                <div class="p-1 bg-amber-100 rounded">
                                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-semibold text-amber-800 mb-1">Confirmation Required</h4>
                                                    <p class="text-amber-700 text-sm">Type "CONFIRM" in the field below to proceed with releasing this email.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Type "CONFIRM" to proceed:</label>
                                            <input type="text" id="releaseConfirmInput" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white text-sm font-medium transition-all" placeholder="Type CONFIRM here...">
                                        </div>
                                        <div class="flex justify-between mt-6">
                                            <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">Cancel</button>
                                            <button type="button" id="releaseConfirmBtn" class="px-6 py-2 bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-lg hover:from-emerald-700 hover:to-green-700 transition-all transform hover:scale-105">Release</button>
                                        </div>
                                    </div>
                                `,
                                showConfirmButton: false,
                                showCancelButton: false,
                                width: '600px',
                                customClass: { popup: 'swal-custom-popup' },
                                didOpen: () => {
                                    const input = document.getElementById('releaseConfirmInput');
                                    const btn = document.getElementById('releaseConfirmBtn');
                                    if (input) input.focus();
                                    if (btn) {
                                        btn.addEventListener('click', function(){
                                            const val = (input?.value || '').trim().toUpperCase();
                                            if (val !== 'CONFIRM') {
                                                Swal.showValidationMessage('Please type "CONFIRM" to continue');
                                                return;
                                            }
                                            form.submit();
                                        });
                                    }
                                }
                            });
                            return false;
                        }

                        <?php if(session('success')): ?>
                        SweetAlertUtils.success('Success','<?php echo e(session('success')); ?>');
                        <?php endif; ?>
                    </script>

                    <script>
                        // AJAX search functionality
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('blacklistSearchForm');
                            if (form) {
                                form.addEventListener('submit', function(e) {
                                    e.preventDefault();
                                    
                                    const url = new URL(form.action, window.location.origin);
                                    const data = new FormData(form);
                                    
                                    // Clean params first
                                    url.search = '';
                                    for (const [k, v] of data.entries()) { 
                                        if (v) url.searchParams.set(k, v); 
                                    }
                                    
                                    // Fetch and replace table content
                                    fetch(url)
                                        .then(response => response.text())
                                        .then(html => {
                                            const parser = new DOMParser();
                                            const doc = parser.parseFromString(html, 'text/html');
                                            const newTable = doc.querySelector('#blacklistTableWrapper');
                                            const currentTable = document.querySelector('#blacklistTableWrapper');
                                            
                                            if (newTable && currentTable) {
                                                currentTable.innerHTML = newTable.innerHTML;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            // Fallback to regular form submission
                                            form.submit();
                                        });
                                });
                            }
                        });
                    </script>
                </div>
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


<?php /**PATH C:\UB-SEMS\resources\views\admin-manager\missing-equipment\blacklist.blade.php ENDPATH**/ ?>