@if($equipment->count() == 0)
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment found</h3>
        <p class="mt-1 text-sm text-gray-500">
            @if(request('search') || request('category') || request('equipment_type') || request('availability'))
                Try adjusting your search criteria or filters.
            @else
                No equipment is currently available.
            @endif
        </p>
    </div>
@else
    <!-- Equipment Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-gray-900">
        @foreach($equipment as $item)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200 transform hover:-translate-y-0.5">
                <!-- Equipment Image with top-right Notify button when unavailable -->
                <div class="relative aspect-w-16 aspect-h-9 bg-gray-100">
                    @if($item->availableCount <= 0)
                        <button
                            onclick="notifyWhenAvailable({{ $item->id }}, '{{ addslashes($item->display_name) }}', event)"
                            class="absolute top-2 right-2 z-10 inline-flex items-center justify-center w-6 h-6 text-blue-700 hover:text-blue-800 transition"
                            title="Notify me when available"
                            aria-label="Notify me when available"
                            data-equipment-id="{{ $item->id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-2-2V11a6 6 0 10-12 0v4l-2 2h5a3 3 0 006 0z" />
                            </svg>
                        </button>
                    @endif

                    @if($item->images->count() > 0)
                        <img src="{{ $item->images->first()->url }}" 
                             alt="{{ $item->display_name }}" 
                             class="w-full h-48 object-cover cursor-zoom-in transition-transform duration-200 ease-out hover:scale-[1.02] js-image-popup"
                             loading="lazy"
                             decoding="async"
                             onclick="window.openImagePopup && window.openImagePopup(this.getAttribute('src'))">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Equipment Details -->
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 line-clamp-2">{{ $item->display_name }}</h3>
                        <span class="text-sm text-gray-500">{{ $item->category->name }}</span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($item->description, 100) }}</p>
                    
                    <!-- Single action row: availability left, buttons right (aligned in one row) -->
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            @if($item->availableCount > 0)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-base font-semibold bg-green-100 text-green-800">
                                    Available ({{ $item->availableCount }})
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-base font-semibold bg-red-100 text-red-800">
                                    Unavailable
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($item->availableCount <= 0)
                                <!-- Heart: Add to Wishlist (only when unavailable) -->
                                <button onclick="addToWishlist({{ $item->id }}, '{{ addslashes($item->display_name) }}', event)"
                                        class="wishlist-btn group inline-flex items-center gap-0.5 px-2 py-1.5 mt-1 bg-white border border-gray-300 hover:border-amber-400 text-gray-600 hover:text-amber-600 rounded-md transition-all duration-200 hover:shadow-md hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1 text-xs"
                                        title="Add to Wishlist"
                                        data-equipment-id="{{ $item->id }}">
                                    <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span class="text-xs font-medium">Add to Wishlist</span>
                                </button>
                            @endif
                            
                            @if($item->availableCount > 0)
                                <button onclick="addToReservation({{ $item->id }}, '{{ addslashes($item->display_name) }}', {{ $item->availableCount }})" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm font-medium transition-colors duration-200 shadow-sm">
                                    Add to Reservation
                                </button>
                            @else
                                <button disabled 
                                         class="inline-flex items-center gap-1 bg-gray-200 text-gray-600 px-3 py-1.5 rounded-md text-sm font-medium cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c.828 0 1.5-.672 1.5-1.5S12.828 8 12 8s-1.5.672-1.5 1.5S11.172 11 12 11zm0 2v3m-6 4h12a2 2 0 002-2V10a2 2 0 00-2-2h-1V7a5 5 0 10-10 0v1H6a2 2 0 00-2 2v8a2 2 0 002 2zM9 8a3 3 0 116 0v1H9V8z"/></svg>
                                    Unavailable
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Condition removed; space reclaimed by taller image above -->
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($equipment->hasPages())
        <div class="mt-8">
            <nav class="flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($equipment->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <button onclick="loadPage({{ $equipment->currentPage() - 1 }})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Previous
                        </button>
                    @endif

                    @if($equipment->hasMorePages())
                        <button onclick="loadPage({{ $equipment->currentPage() + 1 }})" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </button>
                    @else
                        <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-500 bg-white cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $equipment->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $equipment->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $equipment->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            @if($equipment->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <button onclick="loadPage({{ $equipment->currentPage() - 1 }})" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif

                            @foreach($equipment->getUrlRange(1, $equipment->lastPage()) as $page => $url)
                                @if($page == $equipment->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button onclick="loadPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach

                            @if($equipment->hasMorePages())
                                <button onclick="loadPage({{ $equipment->currentPage() + 1 }})" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </nav>
        </div>
    @endif
@endif
