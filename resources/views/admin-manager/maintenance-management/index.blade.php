<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Maintenance Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Maintenance Management']
            ]" />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Equipment Maintenance Overview</h3>
                    
                     <!-- Maintenance Overview and Routine Maintenance Section -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm mb-6 p-6">
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-blue-900 mb-4">Maintenance Overview</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div class="flex flex-col items-center p-4 bg-white rounded-lg border border-blue-200 shadow-sm">
                                    <span class="text-2xl font-bold text-green-600">{{ $maintenanceStats['available_instances'] ?? 0 }}</span>
                                    <span class="text-sm text-gray-600 text-center">Equipment Available</span>
                                </div>
                                <div class="flex flex-col items-center p-4 bg-white rounded-lg border border-red-200 shadow-sm">
                                    <span class="text-2xl font-bold text-red-600">{{ $maintenanceStats['needing_maintenance'] ?? 0 }}</span>
                                    <span class="text-sm text-gray-600 text-center">Needs Repair</span>
                                </div>
                                <div class="flex flex-col items-center p-4 bg-white rounded-lg border border-blue-200 shadow-sm">
                                    <span class="text-2xl font-bold text-blue-600">{{ $maintenanceStats['instances_with_maintenance'] ?? 0 }}</span>
                                    <span class="text-sm text-gray-600 text-center">With Maintenance History</span>
                                </div>
                                <div class="flex flex-col items-center p-4 bg-white rounded-lg border border-gray-200 shadow-sm">
                                    <span class="text-2xl font-bold text-gray-600">{{ ($maintenanceStats['total_instances'] ?? 0) - ($maintenanceStats['instances_with_maintenance'] ?? 0) }}</span>
                                    <span class="text-sm text-gray-600 text-center">No Maintenance History</span>
                                </div>
                                <div class="flex flex-col items-center p-4 bg-white rounded-lg border border-purple-200 shadow-sm">
                                    <span class="text-2xl font-bold text-purple-600">{{ $maintenanceStats['maintenance_completion_percentage'] ?? 0 }}%</span>
                                    <span class="text-sm text-gray-600 text-center">Completion Rate</span>
                                </div>
                                <div class="flex flex-col items-center p-4 bg-white rounded-lg border border-blue-200 shadow-sm">
                                    <span class="text-2xl font-bold text-blue-600">{{ $maintenanceStats['total_instances'] ?? 0 }}</span>
                                    <span class="text-sm text-gray-600 text-center">Total Equipment</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Routine Maintenance Button -->
                        <div class="text-center">
                            <div class="px-8 py-6 rounded-lg shadow-lg inline-block" style="background:#eaf2ff; border:1px solid #d6e6ff; color:#1e3a8a;">
                                <button onclick="openRoutineMaintenanceModal()" 
                                        class="text-white px-6 py-3 rounded font-semibold text-base transition-transform duration-200 flex items-center justify-center gap-3 mx-auto"
                                        style="background:#1d4ed8; border:none;"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(0,0,0,0.2)'; this.style.background='#1d4ed8'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='#1d4ed8'">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Routine Maintenance Mode
                                </button>
                                <p class="text-sm mt-3" style="color:#3553a5;">Schedule routine maintenance for all equipment</p>
                            </div>
                        </div>
                    </div>

                     <!-- Search and Filter Toggle Section -->
                     <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6 p-4">
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

                     <!-- Search and Filters Content -->
                     <div id="searchFilterContent" class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6" style="display: none;">
                         <div class="p-6">
                             <form id="maintenanceFilterFormAdmin" method="GET" action="{{ route('maintenance-management.index') }}" class="space-y-6">
                                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Search Equipment</label>
                                         <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="Equipment name, model, or type..."
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Category</label>
                                         <select name="category" id="filter_category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Categories</option>
                                             @foreach($categories as $category)
                                                 <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                     {{ $category->name }}
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Equipment Type</label>
                                         <select name="equipment_type" id="filter_equipment_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Types</option>
                                         </select>
                                         <p id="filter_equipment_type_help" class="mt-1 text-xs text-gray-500">Select a category first to enable equipment types.</p>
                                     </div>
                                     
                                     <div class="space-y-2">
                                         <label class="block text-sm font-semibold text-gray-700">Maintenance Status</label>
                                         <select name="maintenance_status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all">
                                             <option value="">All Status</option>
                                             <option value="under_maintenance" {{ request('maintenance_status') === 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                             <option value="needs_repair" {{ request('maintenance_status') === 'needs_repair' ? 'selected' : '' }}>Instances Need Repair</option>
                                             <option value="damaged" {{ request('maintenance_status') === 'damaged' ? 'selected' : '' }}>Damaged Instances Need Attention</option>
                                             <option value="has-maintenance-history" {{ request('maintenance_status') === 'has-maintenance-history' ? 'selected' : '' }}>Has Maintenance History</option>
                                             <option value="no-maintenance-history" {{ request('maintenance_status') === 'no-maintenance-history' ? 'selected' : '' }}>No Maintenance History</option>
                                         </select>
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
                                                     id="mmClearBtnAdmin"
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
                    
                                          <!-- Action Legend and Generate Report -->
                     <div class="flex justify-between items-center mb-4">
                         <!-- Generate Report Button -->
                         <div>
                             <button onclick="openReportModal()" 
                                     style="background: linear-gradient(to right, #8b5cf6, #ec4899); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; transition: all 0.2s; display: inline-flex; align-items: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: none; cursor: pointer;"
                                     onmouseover="this.style.background='linear-gradient(to right, #7c3aed, #db2777)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(0, 0, 0, 0.2)'"
                                     onmouseout="this.style.background='linear-gradient(to right, #8b5cf6, #ec4899)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'"
                                     title="Generate Maintenance Report">
                                 <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                 </svg>
                                 Generate Report
                             </button>
                         </div>
                         
                         <!-- View Discarded Items Button -->
                         <div>
                             <a href="{{ route('maintenance-management.discarded') }}" 
                                style="background: linear-gradient(to right, #6b7280, #4b5563); color: white; padding: 12px 24px; border-radius: 12px; font-weight: 600; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 14px; transition: all 0.2s; display: inline-flex; align-items: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); text-decoration: none;"
                                onmouseover="this.style.background='linear-gradient(to right, #4b5563, #374151)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 15px rgba(0, 0, 0, 0.2)'"
                                onmouseout="this.style.background='linear-gradient(to right, #6b7280, #4b5563)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'"
                                title="View Discarded Equipment">
                                 <svg style="width: 20px; height: 20px; margin-right: 8px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                 </svg>
                                 View Discarded Items
                             </a>
                         </div>
                     </div>
                     
                     <!-- Action Legend -->
                     <div class="bg-gray-50 px-4 py-3 rounded-lg border border-gray-200 mb-6">
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
                        <div id="actionLegendContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <div class="flex flex-col items-center text-center">
                                <div class="mb-1" style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                     </svg>
                                 </div>
                                <div class="text-sm font-medium text-gray-900">View Details</div>
                                <div class="text-xs text-gray-500">View equipment information</div>
                             </div>
                             
                             <div class="flex flex-col items-center text-center">
                                 <div class="mb-1" style="background: linear-gradient(to right, #10b981, #059669); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                     </svg>
                                 </div>
                                 <div class="text-sm font-medium text-gray-900">Add Maintenance (Normal)</div>
                                 <div class="text-xs text-gray-500">Record maintenance work</div>
                             </div>
                             
                            
                             
                             <div class="flex flex-col items-center text-center">
                                 <div class="mb-1" style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                     </svg>
                                 </div>
                                 <div>
                                     <div class="text-sm font-medium text-gray-900">Add Maintenance (Urgent)</div>
                                     <div class="text-xs text-gray-500">Urgent maintenance needed</div>
                                 </div>
                             </div>
                             
                             <div class="flex flex-col items-center text-center">
                                 <div class="mb-1" style="background: #fef2f2; color: #dc2626; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                     </svg>
                                 </div>
                                 <div class="text-sm font-medium text-gray-900">High Priority</div>
                                 <div class="text-xs text-gray-500">Needs immediate attention</div>
                             </div>
                             
                             <div class="flex flex-col items-center text-center">
                                 <div class="mb-1" style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; width: 32px; height: 32px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                     <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                     </svg>
                                 </div>
                                 <div class="text-sm font-medium text-gray-900">Discard</div>
                                 <div class="text-xs text-gray-500">Remove damaged instances</div>
                             </div>
                         </div>
                     </div>
                    
                    @if(isset($equipment) && $equipment->count() > 0)
                        <x-table-toolbar />
                        <div id="maintenanceTableWrapperAdmin" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category and Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Total Instances</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Maintenance Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Last Maintenance Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                                                         @foreach($equipment as $item)
                                         @php
                                             $needsMaintenance = false;
                                             $isUnderMaintenance = false;
                                             $maintenanceStatus = '';
                                             $rowClass = '';
                                             $statusColor = '';
                                             $hasDamagedInstances = false;
                                             $hasDiscardableInstances = false;
                                             $underMaintenanceInstances = 0;
                                             
                                             // Check for different maintenance conditions
                                             $damagedInstances = $item->instances->where('condition', 'damaged')->count();
                                             $needsRepairInstances = $item->instances->where('condition', 'needs_repair')->count();
                                             $underMaintenanceInstances = $item->instances->where('condition', 'under_maintenance')->count();
                                             
                                             if($underMaintenanceInstances > 0) {
                                                 $isUnderMaintenance = true;
                                                 $rowClass = 'bg-amber-50 border-l-4 border-amber-500';
                                                 $maintenanceStatus = 'Under Maintenance';
                                                 $statusColor = 'bg-amber-100 text-amber-800 border border-amber-200';
                                             } elseif($damagedInstances > 0 || $needsRepairInstances > 0) {
                                                 $needsMaintenance = true;
                                                 $rowClass = 'bg-red-50 border-l-4 border-red-500';
                                                 $hasDamagedInstances = $damagedInstances > 0;
                                                 $hasDiscardableInstances = $damagedInstances > 0 || $needsRepairInstances > 0;
                                                 
                                                 if($damagedInstances > 0) {
                                                     $maintenanceStatus = 'Damaged instances need attention';
                                                     $statusColor = 'bg-red-100 text-red-800 border border-red-200';
                                                 } else {
                                                     $maintenanceStatus = 'Instances need repair';
                                                     $statusColor = 'bg-orange-100 text-orange-800 border border-orange-200';
                                                 }
                                             } elseif($item->maintenanceRecords->count() > 0) {
                                                 $maintenanceStatus = 'Has maintenance history';
                                                 $statusColor = 'bg-emerald-100 text-emerald-800 border border-emerald-200';
                                             } else {
                                                 $maintenanceStatus = 'No maintenance history';
                                                 $statusColor = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                             }
                                         @endphp
                                         <tr class="{{ $rowClass }} hover:bg-gray-50 transition-colors duration-200">
                                             <td class="px-6 py-4 whitespace-nowrap">
                                                 <div class="flex items-center space-x-3">
                                                     @if($isUnderMaintenance)
                                                         <div class="flex-shrink-0">
                                                             <div class="w-3 h-3 bg-amber-500 rounded-full animate-pulse"></div>
                                                         </div>
                                                     @elseif($needsMaintenance)
                                                         <div class="flex-shrink-0">
                                                             <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                                         </div>
                                                     @endif
                                                     <div>
                                                         <div class="text-sm font-medium {{ $isUnderMaintenance ? 'text-amber-900 font-semibold' : ($needsMaintenance ? 'text-red-900 font-semibold' : 'text-gray-900') }}">
                                                             {{ $item->display_name }}
                                                             @if($isUnderMaintenance)
                                                                 <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                                                     <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                     </svg>
                                                                     MAINTENANCE
                                                                 </span>
                                                             @elseif($needsMaintenance)
                                                                 <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                                     <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 2h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                                     </svg>
                                                                     URGENT
                                                                 </span>
                                                             @endif
                                                         </div>
                                                     </div>
                                                 </div>
                                             </td>
                                             <td class="px-6 py-4 whitespace-nowrap">
                                                 <div class="space-y-1">
                                                     <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                         {{ $item->category->name }}
                                                     </span>
                                                     @if($item->equipmentType)
                                                         <br>
                                                         <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                             {{ $item->equipmentType->name }}
                                                         </span>
                                                     @endif
                                                 </div>
                                             </td>
                                             <td class="px-6 py-4 whitespace-nowrap">
                                                 @php
                                                     $totalInstances = $item->instances->count();
                                                     $activeInstances = $item->instances->where('is_active', true)->count();
                                                     $availableInstances = $item->instances->where('is_active', true)->where('is_available', true)->count();
                                                 @endphp
                                                 <div class="text-sm font-bold text-gray-900">
                                                     {{ $totalInstances }} total
                                                 </div>
                                                 <div class="text-xs font-medium text-gray-700">
                                                     {{ $availableInstances }} available
                                                 </div>
                                                 @if($activeInstances === 0)
                                                     <div class="text-xs text-red-600 font-medium mt-1">
                                                         No active instances
                                                     </div>
                                                 @endif
                                             </td>
                                             <td class="px-6 py-4 whitespace-nowrap">
                                                 <span class="inline-flex px-3 py-1.5 text-xs font-semibold rounded-full {{ $statusColor }} shadow-sm">
                                                     {{ $maintenanceStatus }}
                                                 </span>
                                                 
                                                 @if($needsMaintenance)
                                                     <div class="mt-1 text-xs text-red-600 font-medium">
                                                         @if($hasDamagedInstances)
                                                             {{ $damagedInstances }} damaged, {{ $needsRepairInstances }} needs repair
                                                         @else
                                                             Needs attention
                                                         @endif
                                                     </div>
                                                 @endif
                                             </td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                 @if($item->maintenanceRecords->count() > 0)
                                                     {{ $item->maintenanceRecords->first()->maintenance_date->format('Y-m-d') }}
                                                 @else
                                                     N/A
                                                 @endif
                                             </td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                 <!-- DEBUG: Action buttons should have icons and colors -->
                                                 <div class="flex items-center space-x-2">
                                                     <!-- View Maintenance Details Button -->
                                                     <a href="{{ route('maintenance-management.show', $item) }}" 
                                                        style="background: linear-gradient(to right, #3b82f6, #2563eb); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                        onmouseover="this.style.background='linear-gradient(to right, #2563eb, #1d4ed8)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                        onmouseout="this.style.background='linear-gradient(to right, #3b82f6, #2563eb)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                        title="View Maintenance Details">
                                                         <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                         </svg>
                                                     </a>
                                                     
                                                     <!-- Add Maintenance Record Button -->
                                                     <a href="{{ route('maintenance-management.create-record', $item) }}" 
                                                        style="background: linear-gradient(to right, {{ $needsMaintenance ? '#dc2626' : '#10b981' }}, {{ $needsMaintenance ? '#b91c1c' : '#059669' }}); color: white; width: 40px; height: 40px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: all 0.2s;"
                                                        onmouseover="this.style.background='linear-gradient(to right, {{ $needsMaintenance ? '#b91c1c' : '#059669' }}, {{ $needsMaintenance ? '#991b1b' : '#047857' }}); this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)'"
                                                        onmouseout="this.style.background='linear-gradient(to right, {{ $needsMaintenance ? '#dc2626' : '#10b981' }}, {{ $needsMaintenance ? '#b91c1c' : '#059669' }}); this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'"
                                                        title="{{ $needsMaintenance ? 'URGENT: Add Maintenance Record' : 'Add Maintenance Record' }}">
                                                         <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                         </svg>
                                                     </a>
                                                     
                                                    
                                                     
                                                     @if($needsMaintenance)
                                                         <!-- Priority Indicator -->
                                                         <div class="flex-shrink-0">
                                                             <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center" title="High Priority - Needs Immediate Attention">
                                                                 <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                                 </svg>
                                                             </div>
                                                         </div>
                                                     @endif
                                                     
                                                     @if($hasDiscardableInstances)
                                                         <!-- Discard Button -->
                                                         <button id="discard_btn_{{ $item->id }}" 
                                                                 onclick="openDiscardModal('{{ $item->id }}', '{{ $item->display_name }}', {{ $damagedInstances }})" 
                                                                 class="bg-red-600 hover:bg-red-700 text-white w-10 h-10 rounded-lg flex items-center justify-center shadow-sm transition-colors flex-shrink-0"
                                                                 title="Discard Damaged Instances">
                                                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                             </svg>
                                                         </button>
                                                     @endif
                                                 </div>
                                             </td>
                                         </tr>
                                     @endforeach
                                </tbody>
                            </table>
                        </div>
                        

                        
                        @if($equipment->hasPages())
                            <div class="mt-6">
                                {{ $equipment->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment found</h3>
                            <p class="mt-1 text-sm text-gray-500">No equipment matches your search criteria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    

    



    <!-- Maintenance Management Specific JavaScript -->
    <script>
        // Set up routes for maintenance management
        window.routes = {
            maintenanceManagement: {
                emergencyEnforcement: '{{ route("maintenance-management.emergency-enforcement") }}',
                completeMaintenance: '{{ route("maintenance-management.complete-maintenance") }}',
                discardDamaged: '{{ route("maintenance-management.discard-damaged") }}',
                routineMaintenance: '{{ route("maintenance-management.routine-maintenance") }}'
            }
        };

        // Report Modal Functions
        function openReportModal() {
            Swal.fire({
                buttonsStyling: false,
                html: `
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Generate Maintenance Report</h2>
                    </div>
                    <form id="mntReportForm" method="GET" action="{{ route('maintenance-management.generate-pdf') }}" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                            <select name="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="all">All Maintenance Records</option>
                                <option value="routine">Routine Maintenance</option>
                                <option value="repair">Repair Records</option>
                                <option value="inspection">Inspection Records</option>
                                <option value="recent">Recent Maintenance (Last 30 Days)</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">From Date</label>
                                <input type="date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">To Date</label>
                                <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="modal_category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="">All Categories</option>
                        @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Type</label>
                            <select id="modal_equipment_type" name="equipment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm" disabled>
                                <option value="">All Types</option>
                            </select>
                            <p id="modal_equipment_type_help" class="mt-1 text-xs text-gray-500">Select an Equipment Category first to enable Equipment Type.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                            </select>
                        </div>
                    </form>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">Cancel</button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105" onclick="(function(){ const f=document.getElementById('mntReportForm'); const cat=document.getElementById('modal_category'); const typ=document.getElementById('modal_equipment_type'); const fmt=(new FormData(f)).get('format'); if(cat && cat.value){ const hi=document.createElement('input'); hi.type='hidden'; hi.name='category_name'; hi.value=cat.options[cat.selectedIndex].text; f.appendChild(hi); } if(typ && typ.value){ const ht=document.createElement('input'); ht.type='hidden'; ht.name='equipment_type_name'; ht.value=typ.options[typ.selectedIndex].text; f.appendChild(ht); } f.action = (fmt==='excel') ? '{{ route('maintenance-management.export-excel') }}' : '{{ route('maintenance-management.generate-pdf') }}'; f.target = '_blank'; f.submit(); })()">Generate Report</button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '700px',
                customClass: { popup: 'swal-custom-popup' },
                didOpen: () => {
                    const cat = document.getElementById('modal_category');
                    const type = document.getElementById('modal_equipment_type');
                    const help = document.getElementById('modal_equipment_type_help');
                    const sync = () => {
                        const id = cat.value;
                        const has = Boolean(id);
                        type.disabled = !has;
                        type.classList.toggle('opacity-50', !has);
                        type.classList.toggle('cursor-not-allowed', !has);
                        help.textContent = has ? '' : 'Select an Equipment Category first to enable Equipment Type.';
                        if (has) {
                            fetch(`/equipment-types/by-category/${id}`).then(r=>r.json()).then(d=>{
                                type.innerHTML = '<option value="">All Types</option>';
                                d.forEach(t=>{ const o=document.createElement('option'); o.value=t.id; o.textContent=t.name; type.appendChild(o); });
                            });
                        } else {
                            type.innerHTML = '<option value="">All Types</option>';
                        }
                    };
                    cat.addEventListener('change', sync);
                    sync();
                }
            });
        }


        // Toggle function for search filter
        function toggleSearchFilter() {
            const content = document.getElementById('searchFilterContent');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (content && toggleText && toggleIcon) {
                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                    toggleText.textContent = 'Hide';
                    toggleIcon.style.transform = 'rotate(180deg)';
                    try { localStorage.setItem('maintenanceManagementFilterToggle', '1'); } catch(e) {}
                } else {
                    content.style.display = 'none';
                    toggleText.textContent = 'Show';
                    toggleIcon.style.transform = 'rotate(0deg)';
                    try { localStorage.setItem('maintenanceManagementFilterToggle', '0'); } catch(e) {}
                }
            }
        }

        // AJAX form submission for maintenance management
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('maintenanceFilterFormAdmin');
            const clearBtn = document.getElementById('mmClearBtnAdmin');
            const toggleKey = 'maintenanceManagementFilterToggle';

            if (form) {
                // Clear button functionality
                if (clearBtn) {
                    clearBtn.addEventListener('click', function(){
                        // Reset all form fields
                        form.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
                        form.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
                        
                        // Reset Equipment Type dropdown and show helper text
                        const equipmentTypeSelect = document.getElementById('filter_equipment_type');
                        const equipmentTypeHelp = document.getElementById('filter_equipment_type_help');
                        if (equipmentTypeSelect && equipmentTypeHelp) {
                            equipmentTypeSelect.innerHTML = '<option value="">All Types</option>';
                            equipmentTypeSelect.disabled = true;
                            equipmentTypeSelect.classList.add('opacity-50', 'cursor-not-allowed');
                            equipmentTypeHelp.textContent = 'Select a category first to enable equipment types.';
                        }
                        
                        // Ensure the panel stays open after refresh
                        try { localStorage.setItem(toggleKey, '1'); } catch(e) {}
                        
                        // Use AJAX to refresh table only
                        const url = new URL(form.action, window.location.origin);
                        fetch(url)
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newTable = doc.querySelector('#maintenanceTableWrapperAdmin');
                                const currentTable = document.querySelector('#maintenanceTableWrapperAdmin');
                                
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

                // Intercept form submission for AJAX
                form.addEventListener('submit', function(e){
                    e.preventDefault();
                    
                    const url = new URL(form.action, window.location.origin);
                    const data = new FormData(form);
                    
                    // Clean params first
                    url.search = '';
                    for (const [k,v] of data.entries()) { 
                        if (v) url.searchParams.set(k,v); 
                    }
                    
                    // Fetch and replace table content
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newTable = doc.querySelector('#maintenanceTableWrapperAdmin');
                            const currentTable = document.querySelector('#maintenanceTableWrapperAdmin');
                            
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

        // Initialize Category → Equipment Type dependency for Search/Filter (admin)
        (function(){
            const categorySelect = document.getElementById('filter_category');
            const typeSelect = document.getElementById('filter_equipment_type');
            const help = document.getElementById('filter_equipment_type_help');
            if(!categorySelect || !typeSelect || !help) return;

            const presetType = '{{ request('equipment_type') }}';

            const sync = () => {
                const id = categorySelect.value;
                const has = Boolean(id);
                typeSelect.disabled = !has;
                typeSelect.classList.toggle('opacity-50', !has);
                typeSelect.classList.toggle('cursor-not-allowed', !has);
                help.textContent = has ? '' : 'Select a category first to enable equipment types.';
                if (has) {
                    fetch(`/equipment-types/by-category/${id}`).then(r=>r.json()).then(list=>{
                        const current = typeSelect.value || presetType;
                        typeSelect.innerHTML = '<option value="">All Types</option>';
                        list.forEach(t=>{
                            const o = document.createElement('option');
                            o.value = t.id;
                            o.textContent = t.name;
                            if (current && String(current) === String(t.id)) o.selected = true;
                            typeSelect.appendChild(o);
                        });
                    });
                } else {
                    typeSelect.innerHTML = '<option value="">All Types</option>';
                }
            };

            categorySelect.addEventListener('change', sync);
            sync();
        })();


     </script>
 </x-app-layout>
