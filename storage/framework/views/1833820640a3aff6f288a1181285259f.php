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
            <?php echo e(__('Database Backup & Restore')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if (isset($component)) { $__componentOriginal360d002b1b676b6f84d43220f22129e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal360d002b1b676b6f84d43220f22129e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.breadcrumbs','data' => ['items' => [
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Database Backup & Restore']
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('breadcrumbs'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Database Backup & Restore']
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
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Database Backup & Restore</h3>
                        <p class="text-gray-600">Create backups of your database and restore from previous backups</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                            <i class="fas fa-database mr-2 text-red-500"></i>
                            System Backup & Restore
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Backup Section -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm mb-6 max-w-4xl mx-auto">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center justify-center">
                        <i class="fas fa-plus mr-2 text-blue-600"></i>
                        Create New Backup
                    </h4>
                    
                    <form action="<?php echo e(route('admin.database-backup.create')); ?>" method="POST" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div class="max-w-2xl mx-auto">
                            <div class="space-y-4">
                                <div>
                                    <label for="custom_filename" class="block text-sm font-bold text-gray-700 mb-2">Custom Filename (Optional)</label>
                                    <input type="text" name="custom_filename" id="custom_filename" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                           placeholder="e.g., pre-update-backup">
                                    <p class="mt-1 text-sm font-medium text-gray-600">If left empty, an automatic filename with timestamp will be generated.</p>
                                </div>
                                
                                <div>
                                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description (Optional)</label>
                                    <input type="text" name="description" id="description" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                           placeholder="e.g., Before system update">
                                    <p class="mt-1 text-sm font-medium text-gray-600">Additional notes about this backup for easy identification.</p>
                                </div>
                                
                                <div class="flex items-start">
                                    <input type="checkbox" name="encrypt" id="encrypt" value="1"
                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded mt-1">
                                    <div class="ml-2">
                                        <label for="encrypt" class="block text-sm font-bold text-gray-900">
                                            Encrypt backup file
                                        </label>
                                        <p class="text-sm font-medium text-gray-600">Adds password protection to the backup file</p>
                                    </div>
                                </div>
                                
                                <!-- Backup Information -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle text-blue-400"></i>
                                        </div>
                                        <div class="ml-2">
                                            <h3 class="text-sm font-bold text-blue-800 mb-1">What happens when you create a backup?</h3>
                                            <div class="text-sm font-medium text-blue-700">
                                                <ul class="list-disc list-inside space-y-0.5">
                                                    <li><strong>Database Export:</strong> Creates a complete copy of your current database</li>
                                                    <li><strong>Server Storage:</strong> Saves the backup file to the server's backup directory</li>
                                                    <li><strong>Filename:</strong> Uses your custom filename or generates one with timestamp</li>
                                                    <li><strong>Description:</strong> Stores additional notes for easy identification</li>
                                                    <li><strong>Encryption:</strong> Optional encryption adds an extra layer of security</li>
                                                    <li><strong>Access:</strong> You can download, restore, or view details from the backups list below</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-center pt-2">
                            <?php if (isset($component)) { $__componentOriginalbb660c7d3380b22758129b879204cbaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb660c7d3380b22758129b879204cbaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['type' => 'submit','variant' => 'primary','size' => 'md','icon' => 'fas fa-plus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'primary','size' => 'md','icon' => 'fas fa-plus']); ?>
                                Create Backup
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $attributes = $__attributesOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__attributesOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $component = $__componentOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__componentOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Action Legend -->
            <div class="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-lg shadow-sm p-4 mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-bold text-gray-800 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-gray-600"></i>
                        Action Legend
                    </h4>
                    <button type="button" onclick="toggleActionLegend()" 
                            class="text-sm text-gray-600 hover:text-gray-800 flex items-center space-x-1 transition-colors">
                        <span id="actionLegendToggleText">Hide</span>
                        <svg id="actionLegendToggleIcon" class="w-4 h-4 transform rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                <div id="actionLegendContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm" style="background: linear-gradient(to right, #8b5cf6, #7c3aed);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">View Details</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm" style="background: linear-gradient(to right, #10b981, #059669);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Restore Database</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-sm" style="background: linear-gradient(to right, #ef4444, #dc2626);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Delete Backup</span>
                    </div>
                </div>
            </div>

            <!-- Existing Backups Section -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 rounded-lg shadow-sm">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-green-900 mb-4 flex items-center">
                        <i class="fas fa-database mr-2 text-green-600"></i>
                        Existing Backups
                    </h4>
                    <?php
                        $backupPath = storage_path('app/backups');
                        $backups = [];
                        $metadata = [];
                        
                        // Load metadata
                        $metadataPath = $backupPath . '/metadata.json';
                        if (file_exists($metadataPath)) {
                            $metadata = json_decode(file_get_contents($metadataPath), true) ?? [];
                        }
                        
                        if (is_dir($backupPath)) {
                            $files = scandir($backupPath);
                            foreach ($files as $file) {
                                if ($file !== '.' && $file !== '..' && $file !== 'metadata.json' && !str_starts_with($file, 'temp_')) {
                                    $filePath = $backupPath . '/' . $file;
                                    if (is_file($filePath)) {
                                        // Find metadata for this file
                                        $fileMetadata = collect($metadata)->firstWhere('filename', $file);
                                        
                                        $backups[] = [
                                            'filename' => $file,
                                            'size' => filesize($filePath),
                                            'created' => date('Y-m-d H:i:s', filemtime($filePath)),
                                            'is_encrypted' => str_ends_with($file, '.encrypted'),
                                            'description' => $fileMetadata['description'] ?? 'No description',
                                            'created_by' => $fileMetadata['created_by'] ?? null,
                                            'metadata' => $fileMetadata
                                        ];
                                    }
                                }
                            }
                            // Sort by creation time (newest first)
                            usort($backups, function($a, $b) {
                                return strtotime($b['created']) - strtotime($a['created']);
                            });
                        }
                    ?>

                    <?php if(count($backups) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Filename</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Size</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Created</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900"><?php echo e($backup['filename']); ?></div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-700 max-w-xs truncate" title="<?php echo e($backup['description']); ?>">
                                                    <?php echo e($backup['description']); ?>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                <?php echo e(number_format($backup['size'] / 1024, 2)); ?> KB
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500">
                                                <?php echo e($backup['created']); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <?php if($backup['is_encrypted']): ?>
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Encrypted
                                                    </span>
                                                <?php else: ?>
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Normal
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-2">
                                                    <button onclick="viewBackupDetails('<?php echo e($backup['filename']); ?>', '<?php echo e($backup['description']); ?>', '<?php echo e($backup['size']); ?>', '<?php echo e($backup['created']); ?>', '<?php echo e($backup['is_encrypted'] ? 'Yes' : 'No'); ?>', '<?php echo e($backup['created_by'] ?? 'Unknown'); ?>')" 
                                                            style="background: linear-gradient(to right, #8b5cf6, #7c3aed); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #7c3aed, #6d28d9)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #8b5cf6, #7c3aed)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                            title="View Details">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </button>
                                                    
                                                    <button onclick="confirmRestore('<?php echo e($backup['filename']); ?>')" 
                                                            style="background: linear-gradient(to right, #10b981, #059669); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                            title="Restore Database">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                        </svg>
                                                    </button>
                                                    
                                                    <button onclick="confirmDelete('<?php echo e($backup['filename']); ?>')" 
                                                            style="background: linear-gradient(to right, #ef4444, #dc2626); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                            onmouseover="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                            onmouseout="this.style.background='linear-gradient(to right, #ef4444, #dc2626)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                            title="Delete Backup">
                                                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i class="fas fa-database text-4xl text-green-400 mb-4"></i>
                            <h3 class="text-sm font-medium text-green-900">No backups found</h3>
                            <p class="mt-1 text-sm text-green-700">Create your first backup using the form above.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

    <!-- View Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto border w-full max-w-lg shadow-2xl rounded-xl bg-white">
            <div class="space-y-6 p-6">
                <!-- Header -->
                <div class="bg-purple-600 text-white p-4 -m-6 mb-6 rounded-t-xl">
                    <div class="flex items-center justify-center gap-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold">Backup Details</h2>
                    </div>
                </div>
                
                <!-- Details Grid -->
                <div class="grid grid-cols-1 gap-4">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Filename</label>
                                <p class="text-sm font-medium text-gray-900 mt-1 break-all" id="detailFilename"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Description</label>
                                <p class="text-sm font-medium text-gray-900 mt-1" id="detailDescription"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">File Size</label>
                            <p class="text-sm font-medium text-gray-900 mt-1" id="detailSize"></p>
                        </div>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Encrypted</label>
                            <p class="text-sm font-medium text-gray-900 mt-1" id="detailEncrypted"></p>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Created</label>
                                <p class="text-sm font-medium text-gray-900 mt-1" id="detailCreated"></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wide">Created By</label>
                                <p class="text-sm font-medium text-gray-900 mt-1" id="detailCreatedBy"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Button -->
                <div class="flex justify-center pt-4">
                    <button onclick="closeDetailsModal()" 
                            class="px-8 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all transform hover:scale-105 font-semibold shadow-lg">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Restore Confirmation Modal -->
    <div id="restoreModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto border w-full max-w-sm shadow-2xl rounded-xl bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Confirm Database Restore</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        <strong>WARNING:</strong> This will completely replace your current database with the backup data. 
                        All current data will be lost and cannot be recovered.
                    </p>
                    <p class="text-sm text-gray-500 mt-2">
                        Are you absolutely sure you want to proceed?
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <form id="restoreForm" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <input type="checkbox" name="confirm_restore" value="1" required class="mr-2">
                        <label class="text-sm text-gray-700">I understand this will replace all current data</label>
                        <div class="mt-4 space-x-3">
                            <?php if (isset($component)) { $__componentOriginalbb660c7d3380b22758129b879204cbaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb660c7d3380b22758129b879204cbaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['type' => 'submit','variant' => 'danger','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','variant' => 'danger','size' => 'sm']); ?>
                                Yes, Restore Database
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $attributes = $__attributesOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__attributesOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $component = $__componentOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__componentOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalbb660c7d3380b22758129b879204cbaa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb660c7d3380b22758129b879204cbaa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-button','data' => ['type' => 'button','variant' => 'secondary','size' => 'sm','onclick' => 'closeRestoreModal()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'button','variant' => 'secondary','size' => 'sm','onclick' => 'closeRestoreModal()']); ?>
                                Cancel
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $attributes = $__attributesOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__attributesOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb660c7d3380b22758129b879204cbaa)): ?>
<?php $component = $__componentOriginalbb660c7d3380b22758129b879204cbaa; ?>
<?php unset($__componentOriginalbb660c7d3380b22758129b879204cbaa); ?>
<?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto border shadow-2xl rounded-xl bg-white w-full max-w-lg">
            <div class="space-y-6 p-6">
                <!-- Header -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-6 rounded-t-xl">
                    <div class="flex items-center justify-center gap-3">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold">Delete Backup File</h2>
                    </div>
                </div>
                
                <!-- Warning Section -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-1 bg-red-100 rounded">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-red-800 mb-2">Permanent Action Warning</h3>
                            <p class="text-red-700 text-sm">This action will permanently delete the backup file <strong id="deleteFilename"></strong>. This cannot be undone and the backup will be lost forever.</p>
                        </div>
                    </div>
                </div>
                
                <!-- What will happen section -->
                <div class="space-y-3">
                    <h4 class="font-semibold text-slate-800">What will happen:</h4>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span>The backup file will be permanently removed from the server</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span>All backup metadata will be deleted</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span>You will no longer be able to restore from this backup</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                            <span>This action cannot be reversed or undone</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Confirmation Required -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-1 bg-amber-100 rounded">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-amber-800 mb-1">Admin Password Required</h4>
                            <p class="text-amber-700 text-sm">Enter your admin password to confirm deletion of the backup file.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Admin Password:</label>
                    <input type="password" id="deletePasswordInput" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                           placeholder="Enter your password...">
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="closeDeleteModal()">
                        Cancel
                    </button>
                    <button type="button" class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105" onclick="confirmDeleteBackup()">
                        Delete Backup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleActionLegend() {
            const content = document.getElementById('actionLegendContent');
            const toggleText = document.getElementById('actionLegendToggleText');
            const toggleIcon = document.getElementById('actionLegendToggleIcon');
            
            if (content.style.display === 'none') {
                content.style.display = 'grid';
                toggleText.textContent = 'Hide';
                toggleIcon.style.transform = 'rotate(180deg)';
            } else {
                content.style.display = 'none';
                toggleText.textContent = 'Show';
                toggleIcon.style.transform = 'rotate(0deg)';
            }
        }

        function confirmRestore(filename) {
            document.getElementById('restoreForm').action = '<?php echo e(route("admin.database-backup.restore", ":filename")); ?>'.replace(':filename', filename);
            document.getElementById('restoreModal').classList.remove('hidden');
        }

        function closeRestoreModal() {
            document.getElementById('restoreModal').classList.add('hidden');
        }

        function confirmDelete(filename) {
            document.getElementById('deleteFilename').textContent = filename;
            document.getElementById('deletePasswordInput').value = '';
            document.getElementById('deleteModal').classList.remove('hidden');
            
            // Focus on the input field
            setTimeout(() => {
                document.getElementById('deletePasswordInput').focus();
            }, 100);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            // Don't clear the password input here as it's needed for the AJAX request
        }

        function confirmDeleteBackup() {
            const input = document.getElementById('deletePasswordInput');
            const filename = document.getElementById('deleteFilename').textContent;
            
            if (!input.value.trim()) {
                // Show validation error
                input.style.borderColor = '#ef4444';
                input.style.boxShadow = '0 0 0 3px rgba(239, 68, 68, 0.1)';
                input.placeholder = 'Please enter your password...';
                input.focus();
                return;
            }
            
            // Reset input styling
            input.style.borderColor = '';
            input.style.boxShadow = '';
            input.placeholder = 'Enter your password...';
            
            // Store password value before closing modal
            const passwordValue = input.value;
            
            // Close modal
            closeDeleteModal();
            
            // Show loading state
            Swal.fire({
                title: 'Verifying Password...',
                text: 'Please wait while we verify your password.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Make AJAX call to delete backup
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
            formData.append('_method', 'DELETE');
            formData.append('admin_password', passwordValue);
            
            // Debug logging
            console.log('Password value:', passwordValue);
            console.log('FormData entries:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }
            
            fetch('<?php echo e(route("admin.database-backup.delete", ":filename")); ?>'.replace(':filename', filename), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                return response.json().then(data => {
                    if (response.ok) {
                        return data;
                    } else {
                        // For 400/500 responses, return the error data instead of throwing
                        return { success: false, message: data.message || 'An error occurred' };
                    }
                });
            })
            .then(data => {
                if (data.success) {
                    // Show success modal
                    Swal.fire({
                        icon: false,
                        html: `
                            <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Backup Deleted Successfully</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">Backup deleted successfully</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close(); document.getElementById('deletePasswordInput').value = ''; location.reload();">
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
                    // Check if it's a password error
                    const isPasswordError = data.message && (data.message.includes('password') || data.message.includes('Incorrect'));
                    
                    if (isPasswordError) {
                        // Show password error modal
                        Swal.fire({
                            icon: false,
                            html: `
                                <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Incorrect Password</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-4">Incorrect Password, Please try again.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close(); document.getElementById('deletePasswordInput').value = '';">
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
                        // Show generic error modal
                        Swal.fire({
                            icon: false,
                            html: `
                                <div class="bg-orange-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                    <h2 class="text-xl font-bold text-center">Deletion Failed</h2>
                                </div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <p class="text-gray-700 mb-4">${data.message || 'An error occurred while deleting the backup.'}</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close(); document.getElementById('deletePasswordInput').value = '';">
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
                console.error('Error:', error);
                
                // Try to parse error data if it's JSON
                let errorData = null;
                try {
                    errorData = JSON.parse(error.message);
                } catch (e) {
                    // Not JSON, use generic error
                }
                
                // Check if it's a password error
                const isPasswordError = errorData && errorData.message && errorData.message.includes('password');
                
                if (isPasswordError) {
                    // Show password error modal
                    Swal.fire({
                        icon: false,
                        html: `
                            <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Incorrect Password</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                    <p class="text-gray-700 mb-4">The typed password is incorrect. Please try again.</p>
                                </div>
                                <div class="flex justify-center mt-6">
                                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close(); document.getElementById('deletePasswordInput').value = '';">
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
                    // Show generic error modal
                    Swal.fire({
                        icon: false,
                        html: `
                            <div class="bg-orange-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Deletion Failed</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4">${errorData ? errorData.message : 'An error occurred while deleting the backup. Please try again.'}</p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close(); document.getElementById('deletePasswordInput').value = '';">
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
            });
        }

        function viewBackupDetails(filename, description, size, created, encrypted, createdBy) {
            document.getElementById('detailFilename').textContent = filename;
            document.getElementById('detailDescription').textContent = description;
            document.getElementById('detailSize').textContent = (parseFloat(size) / 1024).toFixed(2) + ' KB';
            document.getElementById('detailCreated').textContent = created;
            document.getElementById('detailEncrypted').textContent = encrypted;
            document.getElementById('detailCreatedBy').textContent = createdBy;
            document.getElementById('detailsModal').classList.remove('hidden');
        }

        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const detailsModal = document.getElementById('detailsModal');
            const restoreModal = document.getElementById('restoreModal');
            const deleteModal = document.getElementById('deleteModal');
            
            if (event.target === detailsModal) {
                closeDetailsModal();
            }
            if (event.target === restoreModal) {
                closeRestoreModal();
            }
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        }

        // Handle Enter key in delete password input
        document.addEventListener('DOMContentLoaded', function() {
            const deleteInput = document.getElementById('deletePasswordInput');
            if (deleteInput) {
                deleteInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        confirmDeleteBackup();
                    }
                });
            }
        });
    </script>

    <!-- Success Modal -->
    <?php if(session('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Backup Created!</h2>
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
            });
        </script>
    <?php endif; ?>

    <!-- Delete Success Modal -->
    <?php if(session('delete_success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Backup Deleted Successfully</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700"><?php echo e(session('delete_success')); ?></p>
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
            });
        </script>
    <?php endif; ?>

    <!-- Error Modal -->
    <?php if($errors->any()): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if($errors->has('password_error')): ?>
                    // Password error modal
                    Swal.fire({
                        icon: false,
                        html: `
                            <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                                <h2 class="text-xl font-bold text-center">Incorrect Password</h2>
                            </div>
                            <div class="text-center">
                                <div class="mb-4">
                                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="text-gray-700 mb-4"><?php echo e($errors->first('password_error')); ?></p>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close();">
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
                <?php else: ?>
                    // General error modal
                    Swal.fire({
                        title: '',
                        html: `
                            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                                <h2 class="text-xl font-bold text-center">Backup Failed</h2>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-700 mb-4"><?php echo e($errors->first()); ?></p>
                                <?php if(str_contains($errors->first(), 'custom filename')): ?>
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <p class="text-sm text-red-800">
                                            <strong>Note:</strong> Please avoid using special characters in the custom filename. Use only letters, numbers, and basic punctuation.
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex justify-center mt-6">
                                <button type="button" class="px-6 py-2 text-white rounded-lg border-none outline-none" style="background:#ef4444" onclick="Swal.close()">OK</button>
                            </div>
                        `,
                        showConfirmButton: false,
                        customClass: { popup: 'swal-custom-popup' }
                    });
                <?php endif; ?>
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
<?php /**PATH C:\SEMSv26\resources\views/admin/database-backup/index.blade.php ENDPATH**/ ?>