<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wishlisted Equipment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Equipment', 'url' => route('equipment-management.index')],
                ['label' => 'Wishlisted Items']
            ]" />
            <!-- Header with Back Button and Generate PDF -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0">
                <h3 class="text-lg font-semibold text-gray-900">Wishlisted Equipment Items</h3>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <button onclick="openWishlistReportModal()" 
                           class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Generate Report
                    </button>
                    <a href="{{ route('equipment-management.index') }}" 
                       class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Equipment
                    </a>
                </div>
            </div>

            <!-- Wishlist Analytics Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-chart-pie mr-2 text-red-600"></i>
                        Wishlist Analytics
                    </h4>
                    
                    <!-- Analytics Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-heart text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-blue-600">Total Wishlisted</p>
                                    <p class="text-2xl font-bold text-blue-900" id="totalWishlisted">{{ $equipment->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-check-circle text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-green-600">Available Items</p>
                                    <p class="text-2xl font-bold text-green-900" id="availableItems">-</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-4 border border-yellow-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-yellow-600">Unavailable Items</p>
                                    <p class="text-2xl font-bold text-yellow-900" id="unavailableItems">-</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-star text-white text-lg"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-purple-600">Avg. Wishlist Count</p>
                                    <p class="text-2xl font-bold text-purple-900" id="avgWishlistCount">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Top Wishlisted Equipment Chart -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-4">
                            <h5 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-trophy mr-2 text-blue-600"></i>
                                Top Wishlisted Equipment
                            </h5>
                            <div class="relative" style="height: 300px;">
                                <canvas id="topWishlistedChart"></canvas>
                            </div>
                            <div id="topWishlistedLegend" class="mt-4 space-y-2"></div>
                        </div>
                        
                        <!-- Category Distribution Chart -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg p-4">
                            <h5 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-tags mr-2 text-green-600"></i>
                                Categories Distribution
                            </h5>
                            <div class="relative" style="height: 300px;">
                                <canvas id="categoryDistributionChart"></canvas>
                            </div>
                        </div>
                        
                        <!-- Availability chart removed as requested -->
                    </div>
                </div>
            </div>

            <!-- Wishlisted Equipment Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-heart mr-2 text-red-600"></i>
                        Wishlisted Equipment Items
                    </h4>
                    @if($equipment->count() > 0)
                        <!-- Table Controls -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 space-y-2 sm:space-y-0">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm font-medium text-gray-700">Sort by:</label>
                                    <select id="sortSelect" class="px-3 py-2 pr-8 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm min-w-[200px]">
                                        <option value="wishlist_count_desc" {{ request('sort') == 'wishlist_count' && request('direction') == 'desc' ? 'selected' : '' }}>Wishlist Count (Highest)</option>
                                        <option value="wishlist_count_asc" {{ request('sort') == 'wishlist_count' && request('direction') == 'asc' ? 'selected' : '' }}>Wishlist Count (Lowest)</option>
                                        <option value="name_asc" {{ request('sort') == 'name' && request('direction') == 'asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                        <option value="name_desc" {{ request('sort') == 'name' && request('direction') == 'desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                        <option value="category_asc" {{ request('sort') == 'category' && request('direction') == 'asc' ? 'selected' : '' }}>Category (A-Z)</option>
                                        <option value="category_desc" {{ request('sort') == 'category' && request('direction') == 'desc' ? 'selected' : '' }}>Category (Z-A)</option>
                                    </select>
                                </div>
                            </div>
                            <x-table-toolbar />
                        </div>
                        
                        <div id="wishlistTableWrapper" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-red-600">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Brand / Model</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Equipment Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'wishlist_count', 'direction' => request('sort') == 'wishlist_count' && request('direction') == 'desc' ? 'asc' : 'desc']) }}" 
                                               class="flex items-center text-white hover:text-gray-200 transition">
                                                Wishlist Count
                                                @if(request('sort') == 'wishlist_count')
                                                    <i class="fas fa-sort-{{ request('direction') == 'desc' ? 'down' : 'up' }} ml-1"></i>
                                                @else
                                                    <i class="fas fa-sort ml-1 text-gray-300"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-white uppercase tracking-wider">Availability</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($equipment as $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($item->images->count() > 0)
                                                        <img class="h-10 w-10 rounded-lg object-cover mr-3" 
                                                             src="{{ $item->images->first()->url }}" 
                                                             alt="{{ $item->brand }} {{ $item->model }}"
                                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                             onload="this.style.display='block';">
                                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3" style="display: none;">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    @else
                                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3">
                                                            <i class="fas fa-image text-gray-400"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-semibold text-gray-900">{{ trim(($item->brand ? $item->brand : '').' '.($item->model ? $item->model : '')) ?: 'No brand/model' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $item->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                    {{ $item->equipmentType->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <i class="fas fa-heart text-red-500 mr-2"></i>
                                                    <span class="text-lg font-bold text-red-600">{{ $item->wishlist_count ?? 0 }}</span>
                                                    <span class="text-sm font-medium text-gray-700 ml-1">wishes</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="font-bold">{{ $item->quantity_available }}</span>
                                                        <span class="text-gray-600">/</span>
                                                        <span class="font-semibold">{{ $item->quantity_total }}</span>
                                                        @if($item->instances->count() > 0)
                                                            <span class="text-xs text-gray-500">({{ $item->instances->count() }} instances)</span>
                                                        @endif
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                        @php
                                                            $percentage = $item->quantity_total > 0 ? ($item->quantity_available / $item->quantity_total) * 100 : 0;
                                                        @endphp
                                                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                    @if($item->instances->count() > 0)
                                                        @php
                                                            $damagedInstances = $item->instances->where('condition', 'damaged')->count();
                                                            $needsRepairInstances = $item->instances->where('condition', 'needs_repair')->count();
                                                        @endphp
                                                        @if($damagedInstances > 0 || $needsRepairInstances > 0)
                                                            <div class="mt-1 flex space-x-1">
                                                                @if($damagedInstances > 0)
                                                                    <span class="inline-flex px-1 py-0.5 text-xs rounded bg-red-100 text-red-800">{{ $damagedInstances }} damaged</span>
                                                                @endif
                                                                @if($needsRepairInstances > 0)
                                                                    <span class="inline-flex px-1 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800">{{ $needsRepairInstances }} needs repair</span>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $equipment->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment found</h3>
                            <p class="mt-1 text-sm text-gray-500">No equipment matches your search criteria. Try adjusting your filters.</p>
                            <div class="mt-6">
                                <a href="{{ route('equipment-management.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to Equipment
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        function openWishlistReportModal() {
            Swal.fire({
                buttonsStyling: false,
                html: `
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 -m-6 mb-4 rounded-t-lg">
                        <h2 class="text-xl font-bold">Generate Wishlisted Equipment Report</h2>
                    </div>
                    <form id="wishlistReportForm" method="GET" action="{{ route('equipment-management.wishlisted-pdf') }}" class="space-y-4">
                        <!-- Report Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
                            <select name="report_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="all">All Wishlisted Equipment</option>
                                <option value="by_category">By Category</option>
                                <option value="by_wishlist_count">By Wishlist Count</option>
                                <option value="by_availability">By Availability</option>
                            </select>
                        </div>
                        
                        <!-- Category Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="modal_category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Equipment Type Filter (depends on Category) -->
                        <div id="equipment_type_group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Type</label>
                            <select id="modal_equipment_type" name="equipment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="">All Types</option>
                            </select>
                            <p id="modal_equipment_type_help" class="mt-1 text-xs text-gray-500">Select an Equipment Category first to enable Equipment Type.</p>
                        </div>
                        
                        
                        <!-- Export Format -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-sm">
                                <option value="pdf">PDF Document</option>
                                <option value="excel">Excel Spreadsheet</option>
                            </select>
                        </div>
                        
                    </form>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                            Cancel
                        </button>
                        <button type="button" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all transform hover:scale-105" onclick="(function(){ const f=document.getElementById('wishlistReportForm'); const params=new URLSearchParams(new FormData(f)).toString(); const fmt=new FormData(f).get('format'); const base = fmt==='excel' ? '{{ route('equipment-management.wishlisted.export-excel') }}' : '{{ route('equipment-management.wishlisted-pdf') }}'; window.open(base + (params ? ('?' + params) : ''), '_blank'); })()">
                            Generate Report
                        </button>
                    </div>
                `,
                showConfirmButton: false,
                showCancelButton: false,
                width: '700px',
                customClass: {
                    popup: 'swal-custom-popup'
                },
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
        // Sort functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    const value = this.value;
                    const [sort, direction] = value.split('_');
                    const url = new URL(window.location);
                    url.searchParams.set('sort', sort);
                    url.searchParams.set('direction', direction);
                    window.location.href = url.toString();
                });
            }
        });

        // Enhanced Charts and Analytics
        document.addEventListener('DOMContentLoaded', function() {
            const raw = @json($allEquipment ?? []);
            const equipment = Array.isArray(raw) ? raw : Object.values(raw || {});
            
            if (!Array.isArray(equipment) || equipment.length === 0) {
                document.querySelector('.grid.grid-cols-1.lg\\:grid-cols-2.xl\\:grid-cols-3').innerHTML = 
                    '<div class="col-span-3 flex items-center justify-center h-64 text-gray-500"><p>No wishlisted equipment data available</p></div>';
                return;
            }
            
            // Calculate analytics
            const totalWishlisted = equipment.length;
            const availableItems = equipment.filter(item => (item.available_count || 0) > 0).length;
            const unavailableItems = totalWishlisted - availableItems;
            const totalWishlistCount = equipment.reduce((sum, item) => sum + (item.wishlist_count || 0), 0);
            const avgWishlistCount = totalWishlisted > 0 ? (totalWishlistCount / totalWishlisted).toFixed(1) : 0;
            
            // Update summary cards
            document.getElementById('availableItems').textContent = availableItems;
            document.getElementById('unavailableItems').textContent = unavailableItems;
            document.getElementById('avgWishlistCount').textContent = avgWishlistCount;

            // 1. Top Wishlisted Equipment Chart
            const topWishlistedCtx = document.getElementById('topWishlistedChart');
            if (topWishlistedCtx) {
                const raw2 = @json($allEquipment ?? []);
                const equipment = Array.isArray(raw2) ? raw2 : Object.values(raw2 || {});
                
                if (!Array.isArray(equipment) || equipment.length === 0) {
                    topWishlistedCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500"><p>No wishlisted equipment data available</p></div>';
                    return;
                }
                
                // Filter equipment with wishlist count > 0
                const wishlistedEquipment = equipment.filter(item => ((item && item.wishlist_count) || 0) > 0);
                
                if (wishlistedEquipment.length === 0) {
                    // Show "No Data" message
                    topWishlistedCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500"><p>No wishlisted equipment data available</p></div>';
                    return;
                }
                
                const sortedEquipment = wishlistedEquipment
                    .sort((a, b) => (b.wishlist_count || 0) - (a.wishlist_count || 0))
                    .slice(0, 8);

                const fullLabels = sortedEquipment.map(item => String(((item && item.brand) ? item.brand : '') + (item && item.model ? ( (item && item.brand) ? ' ' : '') + item.model : '')) || '');
                const labels = sortedEquipment.map(item => {
                    const base = (((item && item.brand) ? item.brand : '') + (item && item.model ? ((item && item.brand) ? ' ' : '') + item.model : '')) || '';
                    const name = String(base);
                    return name.length > 20 ? name.substring(0, 20) + '...' : name;
                });
                const counts = sortedEquipment.map(item => (item && item.wishlist_count) || 0);

                const topChart = new Chart(topWishlistedCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: ['#ef4444','#f97316','#eab308','#22c55e','#3b82f6','#8b5cf6','#06b6d4','#84cc16'],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { 
                                position: 'bottom', 
                                labels: { 
                                    usePointStyle: true, 
                                    padding: 12,
                                    generateLabels: (chart) => {
                                        const colors = chart.data.datasets[0].backgroundColor;
                                        return fullLabels.map((label, i) => ({
                                            text: `${label} (${counts[i] ?? 0})`,
                                            fillStyle: colors[i],
                                            strokeStyle: '#ffffff',
                                            hidden: false,
                                            index: i
                                        }));
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Top Wishlisted Equipment'
                            }
                        }
                    }
                });
                // Explicit legend with full names and counts
                (function(){
                    const legendEl = document.getElementById('topWishlistedLegend');
                    if (!legendEl) return;
                    const colors = topChart.data.datasets[0].backgroundColor;
                    legendEl.innerHTML = fullLabels.map((label, i) => {
                        const value = counts[i] ?? 0;
                        return `<div class="flex items-center text-sm text-gray-700">`
                             + `<span class="inline-block w-3 h-3 rounded-full mr-2" style="background:${colors[i]}"></span>`
                             + `<span class="font-medium">${label}</span>`
                             + `<span class="ml-2 text-gray-500">(${value})</span>`
                             + `</div>`;
                    }).join('');
                })();
            }
            
            // 2. Category Distribution Chart
            const categoryCtx = document.getElementById('categoryDistributionChart');
            if (categoryCtx) {
                const categoryData = {};
                equipment.forEach(item => {
                    const category = (item.category && item.category.name) || 'Unknown';
                    categoryData[category] = (categoryData[category] || 0) + 1;
                });
                
                const categoryLabels = Object.keys(categoryData);
                const categoryCounts = Object.values(categoryData);
                
                new Chart(categoryCtx, {
                    type: 'pie',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            data: categoryCounts,
                            backgroundColor: [
                                '#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', 
                                '#06b6d4', '#84cc16', '#f97316', '#ec4899', '#6366f1'
                            ],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 10,
                                    usePointStyle: true
                                }
                            }
                        }
                    }
                });
            }
            
            // 3. Availability Status Chart
            const availabilityCtx = document.getElementById('availabilityChart');
            if (availabilityCtx) {
                new Chart(availabilityCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Available', 'Unavailable'],
                        datasets: [{
                            data: [availableItems, unavailableItems],
                            backgroundColor: ['#10b981', '#ef4444'],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
