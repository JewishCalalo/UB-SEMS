<!-- Search and Filter Toggle Section -->
<div class="bg-white border border-gray-200 rounded-lg shadow-ld mb-6 p-4">
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
    <div class="p-6">
        <form id="dynamicSearchForm" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Search Equipment</label>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Equipment name, model, or type..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Category</label>
                    <select name="category" id="categorySelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
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
                    <select name="equipment_type" id="equipmentTypeSelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                        <option value="">All Types</option>
                        @foreach($equipmentTypes as $type)
                            <option value="{{ $type->id }}" {{ request('equipment_type') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Availability</label>
                    <select name="availability" id="availabilitySelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                        <option value="">All Availability</option>
                        <option value="available" {{ request('availability') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="unavailable" {{ request('availability') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                    </select>
                </div>
                
                <div class="md:col-span-2 lg:col-span-1 space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Actions</label>
                    <div class="flex space-x-2">
                        <button type="button" id="clearFiltersButton" class="actions__button actions__button--clear">
                            <svg viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
