/**
 * Management Common Functions
 * Shared JavaScript functions for all management views
 */

// Global variables
let searchTimeout;
let currentPage = 1;

/**
 * Toggle search filter visibility
 */
function toggleSearchFilter() {
    const content = document.getElementById('searchFilterContent');
    const toggleText = document.getElementById('toggleText');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleButton = document.querySelector('[onclick="toggleSearchFilter()"]');
    
    if (!content || !toggleText || !toggleIcon) {
        console.error('Required elements not found for toggleSearchFilter');
        return;
    }
    
    const isHidden = content.style.display === 'none' || content.style.display === '';
    
    if (isHidden) {
        // Show the content
        content.style.display = 'block';
        toggleText.textContent = 'Hide';
        toggleIcon.style.transform = 'rotate(180deg)';
        
        // Change to active state (green)
        if (toggleButton) {
            toggleButton.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        }
    } else {
        // Hide the content
        content.style.display = 'none';
        toggleText.textContent = 'Show';
        toggleIcon.style.transform = 'rotate(0deg)';
        
        // Change back to default state (blue)
        if (toggleButton) {
            toggleButton.style.background = 'linear-gradient(135deg, #3b82f6 0%, #6366f1 100%)';
        }
    }
}

/**
 * Toggle action legend visibility
 */
function toggleActionLegend() {
    const content = document.getElementById('actionLegendContent');
    const toggleText = document.getElementById('actionLegendToggleText');
    const toggleIcon = document.getElementById('actionLegendToggleIcon');
    
    if (!content || !toggleText || !toggleIcon) {
        console.error('Required elements not found for toggleActionLegend');
        return;
    }
    
    if (content.style.display === 'none') {
        // Show the content
        content.style.display = 'grid';
        toggleText.textContent = 'Hide';
        toggleIcon.style.transform = 'rotate(180deg)';
    } else {
        // Hide the content
        content.style.display = 'none';
        toggleText.textContent = 'Show';
        toggleIcon.style.transform = 'rotate(0deg)';
    }
}

/**
 * Initialize equipment type filtering based on category selection
 */
function initializeEquipmentTypeFiltering() {
    const categorySelect = document.getElementById('filter_category');
    const equipmentTypeSelect = document.getElementById('filter_equipment_type');
    
    if (categorySelect && equipmentTypeSelect) {
        // Insert or update help text element under equipment type select
        let help = document.getElementById('filter_equipment_type_help');
        if (!help) {
            help = document.createElement('p');
            help.id = 'filter_equipment_type_help';
            help.className = 'mt-1 text-xs text-gray-500';
            equipmentTypeSelect.insertAdjacentElement('afterend', help);
        }

        const syncDisabledState = () => {
            const hasCategory = Boolean(categorySelect.value);
            equipmentTypeSelect.disabled = !hasCategory;
            equipmentTypeSelect.classList.toggle('opacity-50', !hasCategory);
            equipmentTypeSelect.classList.toggle('cursor-not-allowed', !hasCategory);
            help.textContent = hasCategory ? '' : 'Select an Equipment Category first to enable Equipment Type.';
        };

        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            equipmentTypeSelect.innerHTML = '<option value="">All Types</option>';
            
            if (categoryId) {
                fetch(`/equipment-types/by-category/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(type => {
                            const option = document.createElement('option');
                            option.value = type.id;
                            option.textContent = type.name;
                            equipmentTypeSelect.appendChild(option);
                        });
                        syncDisabledState();
                    })
                    .catch(error => {
                        console.error('Error fetching equipment types:', error);
                    });
            }
            syncDisabledState();
        });
        
        // Trigger change event if category is pre-selected
        if (categorySelect.value) {
            categorySelect.dispatchEvent(new Event('change'));
        }
        syncDisabledState();
    }
}

/**
 * Initialize table filtering
 */
function initializeTableFiltering() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const tableRows = document.querySelectorAll('tbody tr');
    
    if (!searchInput || !tableRows.length) return;
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter ? statusFilter.value.toLowerCase() : '';
        const categoryValue = categoryFilter ? categoryFilter.value.toLowerCase() : '';
        
        tableRows.forEach(row => {
            const equipmentName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const category = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const status = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            
            const matchesSearch = equipmentName.includes(searchTerm) || category.includes(searchTerm);
            const matchesStatus = !statusValue || status.includes(statusValue);
            const matchesCategory = !categoryValue || category.includes(categoryValue);
            
            if (matchesSearch && matchesStatus && matchesCategory) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Event listeners
    searchInput.addEventListener('input', filterTable);
    if (statusFilter) statusFilter.addEventListener('change', filterTable);
    if (categoryFilter) categoryFilter.addEventListener('change', filterTable);
    
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            searchInput.value = '';
            if (statusFilter) statusFilter.value = '';
            if (categoryFilter) categoryFilter.value = '';
            tableRows.forEach(row => row.style.display = '');
        });
    }
}

/**
 * Create a standardized report modal
 */
function createReportModal(title, formAction, formFields) {
    const fieldsHtml = (formFields || [])
        .filter(field => field && field.type) // ignore undefined/empty entries
        .map(field => {
        if (field.type === 'select') {
            return `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">${field.label}</label>
                    <select name="${field.name}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm">
                        ${field.options.map(option => `<option value="${option.value}">${option.text}</option>`).join('')}
                    </select>
                </div>
            `;
        } else if (field.type === 'date') {
            return `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">${field.label}</label>
                    <input type="date" name="${field.name}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm">
                </div>
            `;
        } else {
            return `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">${field.label}</label>
                    <input type="${field.type || 'text'}" name="${field.name}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm">
                </div>
            `;
        }
    }).join('');
    
    // Adjust: if format select exists, dynamically set action to Excel route when chosen
    Swal.fire({
        title: '',
        html: `
            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                <h2 class="text-xl font-bold">${title}</h2>
            </div>
            <form id="reportForm" method="GET" action="${formAction}" class="space-y-4">
                ${fieldsHtml}
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                        Cancel
                    </button>
                    <button type="button" onclick="generateReport()" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all transform hover:scale-105">
                        Generate Report
                    </button>
                </div>
            </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        width: '600px',
        customClass: {
            popup: 'swal-custom-popup'
        },
        didOpen: () => {
            const formEl = document.getElementById('reportForm');
            const formatEl = formEl?.querySelector('select[name="format"]');
            // Hide Equipment Type until Category is selected
            const categoryEl = formEl?.querySelector('select[name="category"]');

            if (formatEl) {
                // Remove CSV option from UI
                Array.from(formatEl.options).forEach(opt => { if (opt.value === 'csv') opt.remove(); });

                // This event listener is causing the issue by changing the form action.
                // We will handle URL generation dynamically in `generateReport` instead.
                /*
                formatEl.addEventListener('change', () => {
                    const currentPath = window.location.pathname;
                    if (formatEl.value === 'excel') {
                        if (currentPath.includes('/reservation-management')) {
                            formEl.action = '/reservation-management/export/excel';
                        } else if (currentPath.includes('/equipment-management')) {
                            formEl.action = '/equipment-management/export/excel';
                        } else if (currentPath.includes('/maintenance-management')) {
                            formEl.action = '/maintenance-management/export/excel';
                        } else if (currentPath.includes('/missing-equipment')) {
                            formEl.action = '/missing-equipment/export/excel';
                        } else {
                            formEl.action = formAction; // fallback
                        }
                    } else {
                        formEl.action = formAction; // PDF
                    }
                });
                */
            }
            
            // Add generateReport function to window scope
            window.generateReport = function() {
                const form = document.getElementById('reportForm');
                const formData = new FormData(form);
                const params = new URLSearchParams();
                
                // Add all form data to URL parameters
                for (let [key, value] of formData.entries()) {
                    if (value) {
                        params.append(key, value);
                    }
                }
                
                // Get format from form
                const format = formData.get('format') || 'pdf';
                
                // Build the URL based on format
                let url;
                const basePath = form.action; // The original PDF route

                if (format === 'excel') {
                    // This logic handles all the different report URL structures
                    if (basePath.includes('wishlisted-pdf')) {
                        url = basePath.replace('wishlisted-pdf', 'wishlisted/export/excel');
                    } else if (basePath.includes('generate-discarded-report')) {
                        url = basePath.replace('generate-discarded-report', 'export/excel'); // Assuming a similar pattern
                    } else {
                        // General case for most reports
                        const newPath = basePath.replace(/generate-pdf$/, 'export/excel');
                        if (newPath !== basePath) {
                            url = newPath;
                        } else {
                            // Fallback for any other structure, like /missing-equipment
                            url = basePath.replace(/$/, '/export/excel').replace('//', '/');
                        }
                    }
                } else {
                    url = basePath; // PDF
                }

                url += '?' + params.toString();
                
                // Show preview for PDF, download for others
                if (format === 'pdf') {
                    // Create preview modal
                    Swal.fire({
                        title: 'Generating Report...',
                        html: `
                            <div class="flex items-center justify-center py-8">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-red-600"></div>
                            </div>
                            <p class="mt-4 text-gray-600">Please wait while your report is being generated...</p>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    
                    // Generate preview iframe
                    setTimeout(() => {
                        Swal.fire({
                            title: '',
                            html: `
                                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-4 rounded-t-lg">
                                    <h2 class="text-xl font-bold">Report Preview</h2>
                                </div>
                                <div class="flex justify-between mb-4 px-1">
                                    <button onclick="downloadReport('${url}')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Download PDF</button>
                                    <button onclick="shareReport('${url}')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Share Report</button>
                                </div>
                                <iframe src="${url}" class="w-full h-96 border border-gray-300 rounded-lg" 
                                        style="width: 100%; height: 400px; border: 1px solid #ddd; border-radius: 8px;"></iframe>
                            `,
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText: 'Close Preview',
                            width: '900px'
                        });
                    }, 1500);
                } else {
                    // Direct download for Excel/CSV
                    window.location.href = url;
                    Swal.close();
                }
            };
            
            // Helper functions for PDF preview actions
            window.downloadReport = function(url) {
                window.open(url, '_blank');
                Swal.close();
            };
            
            window.shareReport = function(url) {
                if (navigator.share) {
                    navigator.share({
                        title: 'Equipment Report',
                        url: url
                    });
                } else {
                    // Fallback: copy to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Report URL Copied!',
                            text: 'The report URL has been copied to your clipboard.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    });
                }
            };

            // Enforce category-before-type inside report modal if both selects exist
            const modalCategory = formEl?.querySelector('select[name="category"]');
            const modalType = formEl?.querySelector('select[name="equipment_type"]');
            if (modalCategory && modalType) {
                let note = formEl.querySelector('#modal_equipment_type_help');
                if (!note) {
                    note = document.createElement('p');
                    note.id = 'modal_equipment_type_help';
                    note.className = 'mt-1 text-xs text-gray-500';
                    modalType.insertAdjacentElement('afterend', note);
                }
                const sync = () => {
                    const selectedCategory = modalCategory.value;
                    const hasCategory = Boolean(selectedCategory);
                    
                    modalType.disabled = !hasCategory;
                    modalType.classList.toggle('opacity-50', !hasCategory);
                    modalType.classList.toggle('cursor-not-allowed', !hasCategory);
                    note.textContent = hasCategory ? '' : 'Select an Equipment Category first to enable Equipment Type.';
                    
                    // Clear equipment type selection when category changes
                    modalType.value = '';
                    
                    // If a category is selected, fetch equipment types for that category
                    if (hasCategory) {
                        fetch(`/equipment-types/by-category/${selectedCategory}`)
                            .then(response => response.json())
                            .then(data => {
                                // Clear existing options except the first one
                                modalType.innerHTML = '<option value="">All Equipment Types</option>';
                                
                                // Add new options
                                data.forEach(type => {
                                    const option = document.createElement('option');
                                    option.value = type.id;
                                    option.textContent = type.name;
                                    modalType.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching equipment types:', error);
                                note.textContent = 'Error loading equipment types.';
                            });
                    } else {
                        // Reset to all equipment types
                        modalType.innerHTML = `
                            <option value="">All Equipment Types</option>
                            <option value="1">Ball</option>
                            <option value="2">Racket</option>
                            <option value="3">Net</option>
                            <option value="4">Paddle</option>
                            <option value="5">Table</option>
                            <option value="6">Shoes</option>
                            <option value="7">Jersey</option>
                            <option value="8">Knee Pads</option>
                            <option value="9">Shuttlecock</option>
                        `;
                    }
                };
                modalCategory.addEventListener('change', sync);
                sync();
            }
        }
    });
}

/**
 * Initialize all common management functionality
 */
function initializeManagementCommon() {
    // Initialize equipment type filtering
    initializeEquipmentTypeFiltering();
    
    // Initialize table filtering
    initializeTableFiltering();
    
    // Auto-show search content if there are active filters
    const urlParams = new URLSearchParams(window.location.search);
    const hasActiveFilters = urlParams.has('search') || urlParams.has('category') || 
                           urlParams.has('equipment_type') || urlParams.has('availability') ||
                           urlParams.has('status') || urlParams.has('maintenance_status');
    
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
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Management Common JS initialized');
    initializeManagementCommon();
});

/**
 * Show Add Instance Modal
 * @param {number} equipmentId - The ID of the equipment to add instances to
 */
function showAddInstanceModal(equipmentId) {
    Swal.fire({
        html: `
            <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#10b981;">
                <h2 class="text-xl font-bold text-center">Add Equipment Instances</h2>
            </div>
            <form id="addInstanceForm" method="POST" action="/instances/${equipmentId}/add" class="space-y-4">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || ''}">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Number of Instances</label>
                    <input type="number" name="quantity" id="instanceQuantity" min="1" max="99" value="1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <p class="mt-1 text-xs text-gray-500">Enter the number of instances you want to add (1-99)</p>
                    <p id="quantityError" class="mt-1 text-xs text-red-600 hidden">Number of instances must be between 1 and 99.</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Initial Condition</label>
                    <select name="condition" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="excellent">Excellent</option>
                        <option value="good">Good</option>
                        <option value="fair">Fair</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                    <input type="text" name="location" value="Storage Room A" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add Instances',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        width: '500px',
        customClass: {
            popup: 'swal-custom-popup',
            confirmButton: 'swal-custom-confirm-button',
            cancelButton: 'swal-custom-cancel-button'
        },
        preConfirm: () => {
            const form = document.getElementById('addInstanceForm');
            if (form) {
                const quantity = parseInt(form.querySelector('#instanceQuantity').value);
                const errorElement = document.getElementById('quantityError');
                
                // Validate quantity
                if (quantity < 1 || quantity > 99 || isNaN(quantity)) {
                    errorElement.classList.remove('hidden');
                    return false; // Prevent modal from closing
                } else {
                    errorElement.classList.add('hidden');
                }
                
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                
                // Use AJAX with loading states
                const buttonId = `add_instance_btn_${equipmentId}`;
                
                ActionHandler.handleAjaxAction(buttonId, `/instances/${equipmentId}/add`, {
                    method: 'POST',
                    data: data,
                    loadingText: 'Adding Instances...',
                    successTitle: 'Instances Added!',
                    successMessage: 'Equipment instances have been added successfully.',
                    errorTitle: 'Failed to Add Instances',
                    errorMessage: 'An error occurred while adding instances. Please try again.',
                    onSuccess: () => {
                        // Refresh only the table content
                        setTimeout(() => {
                            const url = new URL(window.location.href);
                            fetch(url)
                                .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newTable = doc.querySelector('#equipmentTableWrapper');
                                    const currentTable = document.querySelector('#equipmentTableWrapper');
                                    
                                    if (newTable && currentTable) {
                                        currentTable.innerHTML = newTable.innerHTML;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    window.location.reload();
                                });
                        }, 1500);
                    }
                });
                
                return false; // Prevent form submission
            }
        }
    });
}

// Export functions for global use
window.ManagementCommon = {
    toggleSearchFilter,
    toggleActionLegend,
    initializeEquipmentTypeFiltering,
    initializeTableFiltering,
    createReportModal,
    showAddInstanceModal,
    initializeManagementCommon
};
