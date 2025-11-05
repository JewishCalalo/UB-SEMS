<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Equipment') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-rose-50/40">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('instructor.dashboard')],
                ['label' => 'Browse Equipment']
            ]" />

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Browse Equipment</h3>
                        <p class="text-gray-600 font-medium">Explore available equipment for your PE classes and activities.</p>
                    </div>
                    <div class="text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                        <i class="fas fa-chalkboard-teacher mr-2 text-red-500"></i>
                        PE Instructor
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="get" class="space-y-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Equipment</label>
                                <input type="text" name="q" id="search" value="{{ request('q') }}" 
                                       placeholder="Search by brand, model, or description..." 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                            </div>
                            <div class="sm:w-48">
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category" id="category" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                    <option value="">All Categories</option>
                                    @foreach($equipment->pluck('category.name')->unique()->filter() as $categoryName)
                                        <option value="{{ $categoryName }}" {{ request('category') === $categoryName ? 'selected' : '' }}>
                                            {{ $categoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Equipment Grid -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-red-50 border-l-4 border-red-500 px-6 py-4">
                    <h4 class="text-lg font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Available Equipment ({{ $equipment->total() }} items)
                    </h4>
                </div>
                
                @if($equipment->count() > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($equipment as $item)
                                @php
                                    $currentlyAvailable = $item->quantity_available ?? 0;
                                    $totalQuantity = $item->quantity_total ?? 0;
                                @endphp
                                <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h5 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->brand }} {{ $item->model }}</h5>
                                            <p class="text-sm text-gray-600 mb-2">{{ $item->category->name ?? 'Uncategorized' }}</p>
                                        </div>
                                        <div class="ml-4 flex flex-col space-y-2">
                                            @if($currentlyAvailable > 0)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $currentlyAvailable }} Available
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Unavailable
                                                </span>
                                            @endif
                                            
                                            @if($item->last_maintenance_date)
                                                @php
                                                    $daysSinceMaintenance = \Carbon\Carbon::parse($item->last_maintenance_date)->diffInDays(now());
                                                @endphp
                                                @if($daysSinceMaintenance > 90)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Maintenance Due
                                                    </span>
                                                @elseif($daysSinceMaintenance > 60)
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                        Maintenance Soon
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Well Maintained
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($item->description)
                                        <p class="text-sm text-gray-700 mb-4">{{ Str::limit($item->description, 100) }}</p>
                                    @endif
                                    
                                    <div class="space-y-2 text-sm text-gray-600">
                                        @if($totalQuantity > 0)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                Available: {{ $currentlyAvailable }} / {{ $totalQuantity }}
                                            </div>
                                        @endif
                                        
                                        @if($item->last_maintenance_date)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Last Maintenance: {{ \Carbon\Carbon::parse($item->last_maintenance_date)->format('M d, Y') }}
                                            </div>
                                        @endif
                                        
                                        @if($item->location)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                Location: {{ $item->location }}
                                            </div>
                                        @endif
                                        
                                        @if($item->purchase_date)
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                Acquired: {{ \Carbon\Carbon::parse($item->purchase_date)->format('M Y') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <a href="{{ route('instructor.reservations.create') }}" 
                                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Reserve This Item
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $equipment->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request('q') || request('category'))
                                Try adjusting your search criteria.
                            @else
                                No equipment is currently available.
                            @endif
                        </p>
                        @if(request('q') || request('category'))
                            <div class="mt-6">
                                <a href="{{ route('instructor.equipment') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Clear Filters
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Show success modal if there's a success message
        @if(session('success'))
            document.addEventListener('DOMContentLoaded', function() {
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
                            <p class="text-gray-700 mb-4">{{ session('success') }}</p>
                        </div>
                    `,
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            });
        @endif

        // Show error modal if there's an error message
        @if(session('error'))
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            });
        @endif
    </script>
</x-app-layout>


