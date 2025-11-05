// searchFilter.js - Clean, simple implementation

// Global variables
let searchTimeout;
let currentPage = 1;
let allTypeOptionsCache = null; // cache of original type <option>s for reset

// Toggle search filter visibility
function toggleSearchFilter() {
    const content = document.getElementById('searchFilterContent');
    const toggleText = document.getElementById('toggleText');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (!content || !toggleText || !toggleIcon) {
        console.error('Required elements not found');
        return;
    }
    
    const isHidden = content.style.display === 'none' || content.style.display === '';
    
    // Toggle visibility
    content.style.display = isHidden ? 'block' : 'none';
    toggleText.textContent = isHidden ? 'Hide' : 'Show';
    toggleIcon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
}

// Perform search with debouncing
function performSearch(page = 1) {
    currentPage = page;
    
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    
    searchTimeout = setTimeout(() => {
        const searchInput = document.getElementById('searchInput');
        const categorySelect = document.getElementById('categorySelect');
        const equipmentTypeSelect = document.getElementById('equipmentTypeSelect');
        const availabilitySelect = document.getElementById('availabilitySelect');
        const equipmentContainer = document.getElementById('equipmentContainer');
        const loadingIndicator = document.getElementById('searchLoadingIndicator');
        
        if (!equipmentContainer) return;
        
        // Show loading
        if (loadingIndicator) {
            loadingIndicator.classList.remove('hidden');
        }
        
        // Build search parameters
        const params = new URLSearchParams({
            search: searchInput?.value || '',
            category: categorySelect?.value || '',
            equipment_type: equipmentTypeSelect?.value || '',
            availability: availabilitySelect?.value || '',
            page: page
        });
        
        // Make API request
        const searchUrl = '/welcome/search';
        
        fetch(`${searchUrl}?${params}`)
            .then(response => response.json())
            .then(data => {
                if (loadingIndicator) {
                    loadingIndicator.classList.add('hidden');
                }
                
                if (data.success) {
                    equipmentContainer.innerHTML = data.html;
                    
                    // Update URL without page refresh
                    const newUrl = new URL(window.location);
                    ['search', 'category', 'equipment_type', 'availability'].forEach(param => {
                        const value = params.get(param);
                        if (value) {
                            newUrl.searchParams.set(param, value);
                        } else {
                            newUrl.searchParams.delete(param);
                        }
                    });
                    
                    if (page > 1) {
                        newUrl.searchParams.set('page', page);
                    } else {
                        newUrl.searchParams.delete('page');
                    }
                    
                    window.history.pushState({}, '', newUrl);
                    
                    // Show results counter if filters are active
                    const hasFilters = params.get('search') || params.get('category') || 
                                    params.get('equipment_type') || params.get('availability');
                    
                    const resultsCounter = document.getElementById('searchResultsCounter');
                    if (hasFilters && resultsCounter && data.pagination) {
                        const countElement = document.getElementById('resultsCount');
                        if (countElement) {
                            countElement.textContent = data.pagination.total;
                        }
                        resultsCounter.style.display = 'inline';
                    }
                } else {
                    equipmentContainer.innerHTML = '<div class="text-center py-12 text-gray-500">No results found</div>';
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                if (loadingIndicator) {
                    loadingIndicator.classList.add('hidden');
                }
                equipmentContainer.innerHTML = '<div class="text-center py-12 text-red-500">Error loading results</div>';
            });
    }, 300);
}

// Clear all filters
function clearFilters() {
    const elements = ['searchInput', 'categorySelect', 'equipmentTypeSelect', 'availabilitySelect'];
    
    elements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.value = '';
        }
    });
    // If we have a dependent type select, restore all options
    const typeSelect = document.getElementById('equipmentTypeSelect');
    if (typeSelect) {
        if (!allTypeOptionsCache) {
            allTypeOptionsCache = Array.from(typeSelect.options).map(o => o.cloneNode(true));
        }
        typeSelect.innerHTML = '';
        allTypeOptionsCache.forEach(opt => typeSelect.appendChild(opt.cloneNode(true)));
        typeSelect.value = '';
        // Lock type until a category is chosen
        typeSelect.disabled = true;
        try {
            const help = document.getElementById('equipmentTypeHelp');
            if (help) {
                help.classList.remove('hidden');
                help.style.display = '';
                help.style.opacity = '1';
            }
        } catch (e) {}
    }
    
    // Hide results counter
    const resultsCounter = document.getElementById('searchResultsCounter');
    if (resultsCounter) {
        resultsCounter.style.display = 'none';
    }
    
    // Reset search
    performSearch(1);
    // Ensure helper reappears after any DOM/style mutations
    setTimeout(() => {
        const typeSelect2 = document.getElementById('equipmentTypeSelect');
        const help2 = document.getElementById('equipmentTypeHelp');
        if (typeSelect2) typeSelect2.disabled = true;
        if (help2) {
            help2.classList.remove('hidden');
            help2.style.display = '';
            help2.style.opacity = '1';
        }
    }, 0);
    
    // Clear URL parameters
    window.history.pushState({}, '', window.location.pathname);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('SearchFilter.js initialized');
    
    // Add click event to toggle button
    const toggleButton = document.querySelector('[data-action="toggle-filter"]');
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSearchFilter);
        console.log('Toggle button event listener added');
    } else {
        console.error('Toggle button not found');
    }
    
    // Auto-show search content if there are active filters
    const urlParams = new URLSearchParams(window.location.search);
    const hasActiveFilters = urlParams.has('search') || urlParams.has('category') || 
                           urlParams.has('equipment_type') || urlParams.has('availability');
    
    if (hasActiveFilters) {
        const content = document.getElementById('searchFilterContent');
        const toggleText = document.getElementById('toggleText');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (content && toggleText && toggleIcon) {
            content.style.display = 'block';
            toggleText.textContent = 'Hide';
            toggleIcon.style.transform = 'rotate(180deg)';
        }
    }
    
    // Add event listeners for search inputs
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', () => performSearch(1));
    }
    
    const categorySelect = document.getElementById('categorySelect');
    if (categorySelect) {
        const typeSelect = document.getElementById('equipmentTypeSelect');
        const allTypeOptions = typeSelect ? Array.from(typeSelect.options) : [];
        if (allTypeOptions.length && !allTypeOptionsCache) {
            allTypeOptionsCache = allTypeOptions.map(o => o.cloneNode(true));
        }
        const filterTypeOptions = () => {
            if (!typeSelect) return;
            const selectedCategory = categorySelect.value;
            // Preserve the first option (All Types)
            typeSelect.innerHTML = '';
            const first = allTypeOptions[0];
            if (first) typeSelect.appendChild(first.cloneNode(true));
            allTypeOptions.slice(1).forEach(opt => {
                const catId = opt.getAttribute('data-category-id');
                if (!selectedCategory || selectedCategory === '' || catId === selectedCategory) {
                    typeSelect.appendChild(opt.cloneNode(true));
                }
            });
            // Reset selected value when category changes
            typeSelect.value = '';
            // Enable/disable equipment type based on category selection
            if (!selectedCategory) {
                typeSelect.disabled = true;
                const help = document.getElementById('equipmentTypeHelp');
                if (help) {
                    help.classList.remove('hidden');
                    help.style.display = '';
                    help.style.opacity = '1';
                }
            } else {
                typeSelect.disabled = false;
                const help = document.getElementById('equipmentTypeHelp');
                if (help) {
                    help.style.display = 'none';
                }
            }
        };
        // Initial filter on load
        filterTypeOptions();
        categorySelect.addEventListener('change', () => { filterTypeOptions(); performSearch(1); });
    }
    
    const equipmentTypeSelect = document.getElementById('equipmentTypeSelect');
    if (equipmentTypeSelect) {
        equipmentTypeSelect.addEventListener('change', () => performSearch(1));
    }
    
    const availabilitySelect = document.getElementById('availabilitySelect');
    if (availabilitySelect) {
        availabilitySelect.addEventListener('change', () => performSearch(1));
    }
    
    // Add clear filters button event
    const clearButton = document.getElementById('clearFiltersButton');
    if (clearButton) {
        clearButton.addEventListener('click', clearFilters);
    }
});

// Export for pagination links
window.loadPage = function(page) {
    performSearch(page);
};
