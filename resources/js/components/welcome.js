// Notification system
document.addEventListener('DOMContentLoaded', function() {
    // Make submitReservationForm globally accessible
    window.submitReservationForm = function() {
        console.log('submitReservationForm function called from global scope'); // Debug log
        
        // Find the form within the SweetAlert2 modal
        const form = document.querySelector('.swal2-popup #reservationForm');
        console.log('Form found:', form); // Debug log
        
        if (!form) {
            console.error('Form not found in modal'); // Debug log
            Swal.fire({
                icon: 'error',
                title: 'Form Error',
                text: 'Reservation form not found. Please refresh the page and try again.',
            });
            return;
        }

        // Clear previous error states
        clearFormErrors();
        
        // Validate form
        const requiredFields = ['name', 'email', 'contact_number', 'department', 'borrow_date', 'return_date', 'reason_type'];
        let isValid = true;
        let firstInvalidField = null;
        let errorMessages = [];

        requiredFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value.trim()) {
                field.classList.add('border-red-500');
                showFieldError(field, 'This field is required');
                if (!firstInvalidField) firstInvalidField = field;
                isValid = false;
                errorMessages.push(`${getFieldLabel(fieldName)} is required`);
            } else if (field) {
                field.classList.remove('border-red-500');
                clearFieldError(field);
            }
        });

        // Validate department_other field if "Other" is selected
        const departmentField = form.querySelector('[name="department"]');
        const departmentOtherField = form.querySelector('[name="department_other"]');
        if (departmentField && departmentField.value === 'Other') {
            if (!departmentOtherField || !departmentOtherField.value.trim()) {
                if (departmentOtherField) {
                    departmentOtherField.classList.add('border-red-500');
                    showFieldError(departmentOtherField, 'Please specify the department');
                    if (!firstInvalidField) firstInvalidField = departmentOtherField;
                }
                isValid = false;
                errorMessages.push('Please specify the department when "Other" is selected');
            } else {
                if (departmentOtherField) {
                    departmentOtherField.classList.remove('border-red-500');
                    clearFieldError(departmentOtherField);
                }
            }
        }

        // Validate custom reason if "Other" is selected
        const reasonTypeField = form.querySelector('[name="reason_type"]');
        const customReasonField = form.querySelector('[name="custom_reason"]');
        if (reasonTypeField && reasonTypeField.value === 'Other') {
            if (!customReasonField || !customReasonField.value.trim()) {
                customReasonField.classList.add('border-red-500');
                showFieldError(customReasonField, 'Please specify the purpose of your reservation');
                if (!firstInvalidField) firstInvalidField = customReasonField;
                isValid = false;
                errorMessages.push('Please specify the purpose of your reservation');
            } else {
                customReasonField.classList.remove('border-red-500');
                clearFieldError(customReasonField);
            }
        }

        // Validate dates
        const borrowDate = new Date(form.borrow_date.value);
        const returnDate = new Date(form.return_date.value);
        
        // Use local date-only comparison to avoid timezone issues
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        // Normalize borrow date to local date-only
        const borrowDateLocal = new Date(borrowDate);
        borrowDateLocal.setHours(0, 0, 0, 0);
        // Compute max borrow date (today + 6 days)
        const maxBorrowLocal = new Date(today);
        maxBorrowLocal.setDate(maxBorrowLocal.getDate() + 6);

        if (borrowDateLocal < today || borrowDateLocal > maxBorrowLocal) {
            const borrowDateField = form.querySelector('[name="borrow_date"]');
            borrowDateField.classList.add('border-red-500');
            const maxStr = maxBorrowLocal.toISOString().slice(0,10);
            showFieldError(borrowDateField, `Please select a date from today up to ${maxStr}`);
            if (!firstInvalidField) firstInvalidField = borrowDateField;
            isValid = false;
            errorMessages.push('Borrow date must be within the next 7 days');
        }

        // Allow same-day return; only block if return date is before borrow date
        if (returnDate < borrowDate) {
            const returnDateField = form.querySelector('[name="return_date"]');
            returnDateField.classList.add('border-red-500');
            showFieldError(returnDateField, 'Return date cannot be before borrow date');
            if (!firstInvalidField) firstInvalidField = returnDateField;
            isValid = false;
            errorMessages.push('Return date cannot be before borrow date');
        }

        // Validate times if provided: between 08:00-17:00 and if same-day, at least 30 minutes apart
        const btVal0 = form.querySelector('#borrow_time')?.value;
        const rtVal0 = form.querySelector('#return_time')?.value;
        const toMinutes = (v) => { if(!v) return null; const [h,m]=v.split(':').map(Number); return h*60+m; };
        const MIN0 = 8*60, MAX0 = 17*60;
        const b0 = toMinutes(btVal0), r0 = toMinutes(rtVal0);
        const borrowTimeErrorDiv = document.getElementById('borrow_time_error');
        const returnTimeErrorDiv = document.getElementById('return_time_error');
        if (borrowTimeErrorDiv) { borrowTimeErrorDiv.textContent=''; borrowTimeErrorDiv.classList.add('hidden'); }
        if (returnTimeErrorDiv) { returnTimeErrorDiv.textContent=''; returnTimeErrorDiv.classList.add('hidden'); }
        if (b0 !== null) {
            const bf = form.querySelector('#borrow_time');
            if (b0 < MIN0 || b0 > MAX0) {
                bf.classList.add('border-red-500');
                showFieldError(bf, 'Borrow time must be between 8:00 AM and 5:00 PM');
                if (borrowTimeErrorDiv) { borrowTimeErrorDiv.textContent='Borrow time must be between 8:00 AM and 5:00 PM'; borrowTimeErrorDiv.classList.remove('hidden'); }
                if (!firstInvalidField) firstInvalidField = bf;
                isValid = false;
                errorMessages.push('Borrow time must be between 8:00 AM and 5:00 PM');
            }
            // Additional: if borrow date is today, prevent selecting past time
            const isBorrowToday = borrowDateLocal && borrowDateLocal.getTime() === today.getTime();
            if (isBorrowToday) {
                const now = new Date();
                const nowMin = now.getHours() * 60 + now.getMinutes();
                if (b0 <= nowMin) {
                    bf.classList.add('border-red-500');
                    showFieldError(bf, 'Borrow time cannot be in the past');
                    if (borrowTimeErrorDiv) { borrowTimeErrorDiv.textContent='Borrow time cannot be in the past'; borrowTimeErrorDiv.classList.remove('hidden'); }
                    if (!firstInvalidField) firstInvalidField = bf;
                    isValid = false;
                    errorMessages.push('Borrow time cannot be in the past');
                }
            }
        }
        if (r0 !== null) {
            const rf = form.querySelector('#return_time');
            if (r0 < MIN0 || r0 > MAX0) {
                rf.classList.add('border-red-500');
                showFieldError(rf, 'Return time must be between 8:00 AM and 5:00 PM');
                if (returnTimeErrorDiv) { returnTimeErrorDiv.textContent='Return time must be between 8:00 AM and 5:00 PM'; returnTimeErrorDiv.classList.remove('hidden'); }
                if (!firstInvalidField) firstInvalidField = rf;
                isValid = false;
                errorMessages.push('Return time must be between 8:00 AM and 5:00 PM');
            }
            const returnDateLocal = new Date(returnDate); if (!isNaN(returnDateLocal)) { returnDateLocal.setHours(0,0,0,0); }
            if (!isNaN(returnDateLocal) && returnDateLocal.getTime() === today.getTime()) {
                const now = new Date();
                const nowMin = now.getHours() * 60 + now.getMinutes();
                if (r0 <= nowMin) {
                    rf.classList.add('border-red-500');
                    showFieldError(rf, 'Return time cannot be in the past');
                    if (returnTimeErrorDiv) { returnTimeErrorDiv.textContent='Return time cannot be in the past'; returnTimeErrorDiv.classList.remove('hidden'); }
                    if (!firstInvalidField) firstInvalidField = rf;
                    isValid = false;
                    errorMessages.push('Return time cannot be in the past');
                }
            }
        }
        if (
            borrowDate && returnDate &&
            borrowDate.toDateString() === returnDate.toDateString() &&
            b0 !== null && r0 !== null
        ) {
            const diff = r0 - b0;
            if (diff < 30) {
                const rf = form.querySelector('#return_time');
                rf.classList.add('border-red-500');
                showFieldError(rf, 'For same-day reservations, return time must be at least 30 minutes after borrow time');
                if (returnTimeErrorDiv) { returnTimeErrorDiv.textContent='For same-day reservations, return time must be at least 30 minutes after borrow time'; returnTimeErrorDiv.classList.remove('hidden'); }
                if (!firstInvalidField) firstInvalidField = rf;
                isValid = false;
                errorMessages.push('For same-day reservations, return time must be at least 30 minutes after borrow time');
            }
        }

        if (!isValid) {
            // Show error summary at the top of the form
            showFormErrorSummary(errorMessages);
            if (firstInvalidField) firstInvalidField.focus();
            return;
        }

        console.log('Form validation passed, delegating to duplicate-check...'); return submitReservationForm();

        // Show loading state
        Swal.fire({
            title: 'Submitting Reservation...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Determine the final reason value
        let finalReason = reasonTypeField ? reasonTypeField.value : '';
        if (reasonTypeField && reasonTypeField.value === 'Other' && customReasonField && customReasonField.value.trim()) {
            finalReason = customReasonField.value.trim();
        }
        
        // Get form data
        const formData = new FormData(form);
        
        // Override the reason field with the final value
        formData.set('reason', finalReason);
        
        // Submit via AJAX
        fetch('/reservations/initiate', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(JSON.stringify(errorData));
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response received:', data); // Debug log
            if (data.success && data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Try to parse error data for validation errors
            let errorMessage = 'An error occurred while submitting your reservation. Please try again.';
            
            try {
                const errorData = JSON.parse(error.message);
                if (errorData.errors) {
                    // Handle validation errors
                    const errorMessages = [];
                    Object.keys(errorData.errors).forEach(field => {
                        errorData.errors[field].forEach(message => {
                            errorMessages.push(message);
                        });
                    });
                    errorMessage = errorMessages.join('\n');
                } else if (errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch (parseError) {
                // If parsing fails, use the original error message
                console.error('Error parsing error data:', parseError);
            }
            
            Swal.fire({
                html: `
                    <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:#dc2626;">
                        <h2 class="text-xl font-bold text-center">Reservation Blocked</h2>
                    </div>
                    <div class="text-center">
                        <p class="text-gray-700 mb-4">${errorMessage}</p>
                    </div>
                `,
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626',
                customClass: {
                    popup: 'swal-custom-popup'
                }
            });
        });
    };

    const notifications = document.querySelectorAll('.notification');
    
    notifications.forEach(notification => {
        // Show notification
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
        
        // Add close button functionality
        const closeButton = document.createElement('button');
        closeButton.innerHTML = '×';
        closeButton.className = 'ml-4 text-white hover:text-gray-200 text-xl font-bold';
        closeButton.onclick = function() {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                notification.remove();
            }, 300);
        };
        
        const notificationDiv = notification.querySelector('div');
        if (notificationDiv) {
            notificationDiv.appendChild(closeButton);
        }
    });

    // Initialize all event listeners after DOM is ready
    initializeEventListeners();
});

// Global notification function
function showNotification(message, type = 'info') {
    const container = document.getElementById('notification-container');
    if (!container) {
        console.error('Notification container not found');
        return;
    }
    
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    const icons = {
        success: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>',
        error: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>',
        warning: '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>',
        info: '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>'
    };
    
    const notification = document.createElement('div');
    notification.className = `notification ${type} ${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                ${icons[type]}
            </svg>
            <span>${message}</span>
            <button class="ml-4 text-white hover:text-gray-200 text-xl font-bold" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;
    
    container.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

// Modal helpers for SweetAlert2 styled like category management
function showSuccessModal(title, message) {
    Swal.fire({
        icon: false,
        buttonsStyling: false,
        html: `
            <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                <h2 class="text-xl font-bold text-center">${title || 'Success'}</h2>
            </div>
            <div class="text-center">
                <div class="mb-4">
                    <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-700">${message || ''}</p>
            </div>
            <div class="flex justify-center mt-6">
                <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close()">OK</button>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: { popup: 'swal-custom-popup' }
    });
}

function showErrorModal(title, message) {
    Swal.fire({
        icon: false,
        buttonsStyling: false,
        html: `
            <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                <h2 class="text-xl font-bold text-center">${title || 'Error'}</h2>
            </div>
            <div class="text-center">
                <div class="mb-4">
                    <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-700">${message || ''}</p>
            </div>
            <div class="flex justify-center mt-6">
                <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close()">OK</button>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: { popup: 'swal-custom-popup' }
    });
}

// Lightweight fullscreen image viewer used by equipment cards
// Usage: window.openImagePopup(src)
window.openImagePopup = function(src) {
    try {
        const overlay = document.createElement('div');
        overlay.className = 'fixed inset-0 bg-black/80 backdrop-blur-sm z-[9999] flex items-center justify-center p-4';

    const container = document.createElement('div');
    container.className = 'relative max-w-6xl w-full flex items-center justify-center';

        const img = document.createElement('img');
        img.src = src;
        img.alt = 'Equipment image';
        img.className = 'max-h-[85vh] max-w-full rounded-xl shadow-2xl select-none';

        const close = () => {
            document.removeEventListener('keydown', onKey);
            overlay.remove();
        };
        const onKey = (e) => { if (e.key === 'Escape') close(); };

        overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); });
        document.addEventListener('keydown', onKey);

        container.appendChild(img);
        overlay.appendChild(container);
        document.body.appendChild(overlay);
    } catch (e) {
        console.error('openImagePopup error:', e);
    }
};

// Bind click handlers to any equipment images if inline handler isn't available
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        const target = e.target;
        if (target && target.classList && target.classList.contains('js-image-popup')) {
            const src = target.getAttribute('src');
            if (src) {
                e.preventDefault();
                if (window.openImagePopup) {
                    window.openImagePopup(src);
                }
            }
        }
    });
});

// Orange-themed info modal used for reservation notices
function showOrangeInfoModal(message, title = 'Reservation Updated') {
    const activeSwal = document.querySelector('.swal2-container .swal2-popup');
    if (activeSwal) {
        // Inline overlay inside the existing SweetAlert modal (keeps form state intact)
        let overlay = document.getElementById('inline-orange-modal');
        if (overlay) overlay.remove();
        overlay = document.createElement('div');
        overlay.id = 'inline-orange-modal';
        overlay.className = 'fixed inset-0 flex items-center justify-center';
        overlay.style.background = 'rgba(0,0,0,0.35)';
        overlay.style.zIndex = '10000';
        overlay.innerHTML = `
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md relative" role="dialog" aria-modal="true">
                <div class="bg-orange-500 text-white p-4 rounded-t-lg">
                    <h2 class="text-lg font-bold text-center">${title}</h2>
                </div>
                <div class="px-6 pt-6 pb-4 text-center">
                    <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86A2 2 0 0021 17.15L13.93 4.6a2 2 0 00-3.46 0L3 17.15A2 2 0 005.07 19z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-700">${message || ''}</p>
                    <div class="flex justify-center mt-6">
                        <button type="button" id="inline-orange-modal-ok" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-orange-400">OK</button>
                    </div>
                </div>
            </div>`;
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) overlay.remove();
        });
        activeSwal.appendChild(overlay);
        const okBtn = overlay.querySelector('#inline-orange-modal-ok');
        if (okBtn) okBtn.addEventListener('click', () => overlay.remove());
        return;
    }
    // Fallback when no SweetAlert modal is open
    Swal.fire({
        icon: false,
        buttonsStyling: false,
        allowOutsideClick: true,
        html: `
            <div class="bg-orange-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                <h2 class="text-xl font-bold text-center">${title}</h2>
            </div>
            <div class="text-center">
                <div class="mb-4">
                    <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86A2 2 0 0021 17.15L13.93 4.6a2 2 0 00-3.46 0L3 17.15A2 2 0 005.07 19z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-gray-700">${message || ''}</p>
            </div>
            <div class="flex justify-center mt-6">
                <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close()">OK</button>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: { popup: 'swal-custom-popup' }
    });
}

// Initialize all event listeners
function initializeEventListeners() {
    // Reservation functionality
    const reservationBtnEl = document.getElementById('reservationButton');
    if (reservationBtnEl) {
        reservationBtnEl.addEventListener('click', function() {
            const dropdown = document.getElementById('reservationDropdown');
            if (dropdown) dropdown.classList.toggle('hidden');
        });
    }

    // Close reservation dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const reservationButton = document.getElementById('reservationButton');
        const reservationDropdown = document.getElementById('reservationDropdown');
        
        if (reservationButton && reservationDropdown && 
            !reservationButton.contains(event.target) && 
            !reservationDropdown.contains(event.target)) {
            reservationDropdown.classList.add('hidden');
        }
    });

    // Proceed to reservation button
    const proceedBtnEl = document.getElementById('proceedToReservation');
    if (proceedBtnEl) {
        proceedBtnEl.addEventListener('click', proceedToReservation);
    }

    // Disable equipment type until a category is selected
    const categorySelectEl = document.getElementById('categorySelect');
    const equipmentTypeSelectEl = document.getElementById('equipmentTypeSelect');
    if (categorySelectEl && equipmentTypeSelectEl) {
        const syncEquipmentTypeState = () => {
            const hasCategory = Boolean(categorySelectEl.value);
            equipmentTypeSelectEl.disabled = !hasCategory;
            equipmentTypeSelectEl.classList.toggle('opacity-50', !hasCategory);
            equipmentTypeSelectEl.classList.toggle('cursor-not-allowed', !hasCategory);
            const helpEl = document.getElementById('equipmentTypeHelp');
            if (helpEl) helpEl.style.visibility = hasCategory ? 'hidden' : 'visible';
            if (!hasCategory) {
                equipmentTypeSelectEl.value = '';
            }
        };
        syncEquipmentTypeState();
        categorySelectEl.addEventListener('change', syncEquipmentTypeState);
    }

    // Removed older return-date min logic to avoid conflicts; unified logic lives in modal setup

    // Form submission handling
    const reservationFormEl = document.getElementById('reservationForm');
    if (reservationFormEl) {
        reservationFormEl.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                const originalText = submitButton.textContent;
                
                // Show loading state
                submitButton.textContent = 'Submitting...';
                submitButton.disabled = true;
                
                // Re-enable after 3 seconds if no response
                setTimeout(() => {
                    submitButton.textContent = originalText;
                    submitButton.disabled = false;
                }, 3000);
            }
        });
    }

    // Add event listeners for real-time filtering
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const equipmentTypeSelect = document.getElementById('equipmentTypeSelect');
    const availabilitySelect = document.getElementById('availabilitySelect');
    
    if (searchInput) searchInput.addEventListener('input', () => performDynamicSearch(1));
    if (categorySelect) categorySelect.addEventListener('change', () => performDynamicSearch(1));
    if (equipmentTypeSelect) equipmentTypeSelect.addEventListener('change', () => performDynamicSearch(1));
    if (availabilitySelect) availabilitySelect.addEventListener('change', () => performDynamicSearch(1));
    
    // Initialize reservation from localStorage
    initializeReservation();
}

// Reservation functionality
let reservation = [];

// Initialize reservation from localStorage
function initializeReservation() {
    const savedReservation = localStorage.getItem('sems_reservation');
    if (savedReservation) {
        try {
            reservation = JSON.parse(savedReservation);
        } catch (e) {
            console.error('Error parsing saved reservation:', e);
            reservation = [];
        }
    }
    updateReservationDisplay();
}

// Save reservation to localStorage
function saveReservation() {
    localStorage.setItem('sems_reservation', JSON.stringify(reservation));
}

// Clear reservation from localStorage
function clearReservation() {
    reservation = [];
    localStorage.removeItem('sems_reservation');
    updateReservationDisplay();
}

// Add item to reservation
function addToReservation(equipmentId, equipmentName, maxAvailable) {
    console.log('Adding to reservation:', equipmentId, equipmentName, 'Available:', maxAvailable);
    
    // Validate maxAvailable parameter
    if (!maxAvailable || maxAvailable <= 0) {
        console.error('Invalid available count:', maxAvailable);
        showNotification(`Error: Invalid available count for ${equipmentName}`, 'error');
        return;
    }
    
    // Check if item already exists in reservation (check both id and equipment_id for compatibility)
    const existingItem = reservation.find(item => (item.id === equipmentId || item.equipment_id === equipmentId));
    
    if (existingItem) {
        // Show quantity input modal for existing item with current quantity
        const currentQuantity = existingItem.quantity;
        const remainingAvailable = maxAvailable - currentQuantity;
        
        if (remainingAvailable <= 0) {
            console.log('DEBUG: Showing Already in Reservation modal - this is the NEW version');
            Swal.fire({
                icon: false,
                buttonsStyling: false,
                html: `
                    <div class="bg-red-500 rounded-t-lg -m-6 -mt-6 mb-4">
                        <h2 class="text-xl text-white font-bold">Already in Reservation!</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700">You already have <strong class="text-orange-600 font-bold">${currentQuantity} units</strong> of <strong class="text-gray-900 font-bold">${equipmentName}</strong> in your reservation, which is the maximum available.</p>
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
            return;
        }
        
        showQuantityModal(equipmentId, equipmentName, maxAvailable, currentQuantity);
    } else {
        // Show quantity input modal for new item
        showQuantityModal(equipmentId, equipmentName, maxAvailable, 1);
    }
}

// Show quantity input modal
function showQuantityModal(equipmentId, equipmentName, maxAvailable, currentQuantity) {
    Swal.fire({
        icon: false,
        buttonsStyling: false,
        html: `
            <div class="bg-red-600 text-white p-4 -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                <h2 class="text-xl font-bold">Add to Reservation</h2>
            </div>
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-4">${equipmentName}</h3>
                <p class="text-sm text-gray-600 mb-4">Available: ${maxAvailable} units</p>
                
                <div class="mb-6">
                    <label for="quantityInput" class="block text-sm font-medium text-gray-700 mb-2">Quantity to Add</label>
                    <div class="flex items-center justify-center space-x-3">
                        <button type="button" id="decrementBtn" class="w-10 h-10 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <input type="number" id="quantityInput" value="${currentQuantity}" min="1" max="${maxAvailable}" 
                               class="w-20 text-center border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" id="incrementBtn" class="w-10 h-10 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Current in reservation: ${currentQuantity}</p>
                </div>
            </div>
            <div class="flex justify-between mt-6">
                <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
                    Cancel
                </button>
                <button type="button" id="confirmAddBtn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors transform hover:scale-105">
                    Add to Reservation
                </button>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'swal-small-popup'
        },
        didOpen: () => {
            // Add event listeners after modal is opened
            const quantityInput = document.getElementById('quantityInput');
            const incrementBtn = document.getElementById('incrementBtn');
            const decrementBtn = document.getElementById('decrementBtn');
            const confirmAddBtn = document.getElementById('confirmAddBtn');
            
            // Add real-time validation for reservation form fields
            const reservationForm = document.querySelector('#reservationForm');
            if (reservationForm) {
                const fields = reservationForm.querySelectorAll('input, textarea');
                fields.forEach(field => {
                    field.addEventListener('blur', () => validateField(field));
                    field.addEventListener('input', () => {
                        if (field.classList.contains('border-red-500')) {
                            validateField(field);
                        }
                    });
                });
            }
            
            // Increment button functionality
            incrementBtn.addEventListener('click', () => {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue < maxAvailable) {
                    quantityInput.value = currentValue + 1;
                    updateQuantityValidation();
                }
            });
            
            // Decrement button functionality
            decrementBtn.addEventListener('click', () => {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    updateQuantityValidation();
                }
            });
            
            // Quantity input change handler
            quantityInput.addEventListener('input', updateQuantityValidation);
            
            // Confirm button functionality
            confirmAddBtn.addEventListener('click', () => {
                const quantity = parseInt(quantityInput.value);
                if (quantity >= 1 && quantity <= maxAvailable) {
                    confirmAddToReservation(equipmentId, equipmentName, maxAvailable);
                } else {
                    Swal.showValidationMessage('Please enter a valid quantity');
                }
            });
            
            // Initial validation
            updateQuantityValidation();
            
            function updateQuantityValidation() {
                const quantity = parseInt(quantityInput.value);
                const isValid = quantity >= 1 && quantity <= maxAvailable;
                
                // Update button states
                incrementBtn.disabled = quantity >= maxAvailable;
                decrementBtn.disabled = quantity <= 1;
                
                if (incrementBtn.disabled) {
                    incrementBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    incrementBtn.classList.remove('hover:bg-gray-300');
                } else {
                    incrementBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    incrementBtn.classList.add('hover:bg-gray-300');
                }
                
                if (decrementBtn.disabled) {
                    decrementBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    decrementBtn.classList.remove('hover:bg-gray-300');
                } else {
                    decrementBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    decrementBtn.classList.add('hover:bg-gray-300');
                }
                
                // Update confirm button state
                confirmAddBtn.disabled = !isValid;
                if (!isValid) {
                    confirmAddBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    confirmAddBtn.classList.remove('hover:bg-red-700', 'hover:scale-105');
                } else {
                    confirmAddBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    confirmAddBtn.classList.add('hover:bg-red-700', 'hover:scale-105');
                }
            }
        }
    });
}

// Confirm add to reservation
function confirmAddToReservation(equipmentId, equipmentName, maxAvailable) {
    const quantityInput = document.getElementById('quantityInput');
    if (!quantityInput) {
        Swal.showValidationMessage('Quantity input not found');
        return;
    }
    
    const quantity = parseInt(quantityInput.value);
    
    // Enhanced validation
    if (isNaN(quantity) || quantity < 1) {
        Swal.showValidationMessage('Quantity must be at least 1');
        return;
    }
    
    // For existing items, we need to check if the new total exceeds max available
    const existingItem = reservation.find(item => (item.id === equipmentId || item.equipment_id === equipmentId));
    const currentReservationQuantity = existingItem ? existingItem.quantity : 0;
    
    if (existingItem) {
        // For existing items, the input represents the total desired quantity
        if (quantity > maxAvailable) {
            Swal.showValidationMessage(`Total quantity cannot exceed available units (${maxAvailable})`);
            return;
        }
    } else {
        // For new items, the input represents the quantity to add
        if (quantity > maxAvailable) {
            Swal.showValidationMessage(`Quantity cannot exceed available units (${maxAvailable})`);
            return;
        }
    }
    
    // Calculate the new total quantity
    const newTotalQuantity = existingItem ? quantity : currentReservationQuantity + quantity;
    
    if (newTotalQuantity > maxAvailable) {
        Swal.showValidationMessage(`Total quantity in reservation (${newTotalQuantity}) would exceed available units (${maxAvailable})`);
        return;
    }
    
    // Add or update item in reservation
    if (existingItem) {
        existingItem.quantity = newTotalQuantity; // Set the total quantity
        Swal.fire({
            icon: false,
            buttonsStyling: false,
            html: `
                <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                    <h2 class="text-xl font-bold text-center">Reservation Updated!</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700">${equipmentName} quantity updated to ${quantity} units</p>
                </div>
            `,
            showConfirmButton: false,
            showCancelButton: false,
            timer: 3000,
            customClass: {
                popup: 'swal-custom-popup'
            }
        });
    } else {
        reservation.push({
            id: equipmentId, // Use id for consistency
            equipment_id: equipmentId, // Keep equipment_id for backward compatibility
            name: equipmentName,
            quantity: quantity
        });
        Swal.fire({
            icon: false,
            buttonsStyling: false,
            html: `
                <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                    <h2 class="text-xl font-bold text-center">Added to Reservation!</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700">${equipmentName} added to reservation (${quantity} units)</p>
                </div>
            `,
            showConfirmButton: false,
            showCancelButton: false,
            timer: 3000,
            customClass: {
                popup: 'swal-small-popup'
            }
        });
    }
    
    updateReservationDisplay();
    
}

// Update reservation display
function updateReservationDisplay() {
    const reservationCount = document.getElementById('reservationCount');
    const fabReservationCount = document.getElementById('fabReservationCount');
    const reservationItems = document.getElementById('reservationItems');
    const reservationTotalItems = document.getElementById('reservationTotalItems');
    
    const totalItems = reservation.reduce((sum, item) => sum + item.quantity, 0);
    
    // Update reservation count displays if they exist
    if (reservationCount) reservationCount.textContent = totalItems;
    if (fabReservationCount) fabReservationCount.textContent = totalItems;
    if (reservationTotalItems) reservationTotalItems.textContent = totalItems;
    
    // Update reservation items display if it exists
    if (reservationItems) {
        reservationItems.innerHTML = '';
        if (reservation.length === 0) {
            reservationItems.innerHTML = `
                <div class="text-center py-6 text-gray-500">
                    <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 12H6L5 9z"></path>
                    </svg>
                    <p>Your reservation is empty</p>
                </div>
            `;
        } else {
            reservation.forEach((item, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex items-center justify-between p-2 bg-gray-50 rounded';
                itemDiv.innerHTML = `
                    <div>
                        <span class="font-medium">${item.name}</span>
                        <span class="text-gray-500">x${item.quantity}</span>
                    </div>
                    <button type="button" data-remove-index="${index}" class="text-red-500 hover:text-red-700 remove-reservation-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                reservationItems.appendChild(itemDiv);
            });
            // Bind click handlers after rendering to ensure they work
            reservationItems.querySelectorAll('.remove-reservation-item').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const idx = parseInt(e.currentTarget.getAttribute('data-remove-index'));
                    removeFromReservation(idx);
                });
            });
        }
    }
    
    // Save reservation to localStorage
    saveReservation();
    
    // Log reservation state for debugging
    console.log('Reservation updated:', reservation);
    console.log('Total items:', totalItems);
}

// Remove item from reservation
function removeFromReservation(index) {
    if (reservation[index]) {
        const itemName = reservation[index].name;
        reservation.splice(index, 1);
        updateReservationDisplay();
        // Use modal (orange) instead of flash notification
        showOrangeInfoModal(`${itemName} removed from reservation`, 'Reservation Updated');
    }
}

// Remove item from modal reservation (for equipment details modal)
function removeFromModalReservation(index) {
    // Delegate to main remover to keep logic unified
    return removeFromReservation(index);
}

// Setup real-time validation for submit button
function setupRealTimeValidation() {
    const form = document.querySelector('.swal2-popup #reservationForm');
    const submitBtn = document.getElementById('submitReservationBtn');
    
    if (!form || !submitBtn) return;

    function validateForm() {
        const requiredFields = ['name', 'email', 'contact_number', 'department', 'borrow_date', 'return_date', 'reason_type'];
        let isValid = true;

        // Check required fields
        requiredFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field && !field.value.trim()) {
                isValid = false;
            }
        });

        // Check department_other if "Other" is selected
        const departmentField = form.querySelector('[name="department"]');
        const departmentOtherField = form.querySelector('[name="department_other"]');
        if (departmentField && departmentField.value === 'Other') {
            if (!departmentOtherField || !departmentOtherField.value.trim()) {
                isValid = false;
            }
        }

        // Check custom reason if "Other" is selected
        const reasonTypeField = form.querySelector('[name="reason_type"]');
        const customReasonField = form.querySelector('[name="custom_reason"]');
        if (reasonTypeField && reasonTypeField.value === 'Other') {
            if (!customReasonField || !customReasonField.value.trim()) {
                isValid = false;
            }
        }

        // Update button state
        if (isValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled:bg-gray-400', 'disabled:cursor-not-allowed', 'disabled:transform-none');
            submitBtn.classList.add('hover:bg-red-700', 'transform', 'hover:scale-105');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('disabled:bg-gray-400', 'disabled:cursor-not-allowed', 'disabled:transform-none');
            submitBtn.classList.remove('hover:bg-red-700', 'transform', 'hover:scale-105');
        }
    }

    // Add event listeners to all form fields
    const fields = form.querySelectorAll('input, select, textarea');
    fields.forEach(field => {
        field.addEventListener('input', validateForm);
        field.addEventListener('change', validateForm);
    });

    // Initial validation
    validateForm();
}

// Proceed to reservation
function proceedToReservation() {
    if (reservation.length === 0) {
        showOrangeInfoModal('Your reservation is empty');
        return;
    }
    
    // Pre-compute 7-day window (today + 7 days), allowing future dates beyond current month
    const today = new Date();
    const toYMD = d => d.toISOString().split('T')[0];
    const borrowMaxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7); // today + 7 days
    const todayStr = toYMD(today);
    const borrowMaxStr = toYMD(borrowMaxDate);

    // Generate reservation items HTML
    let reservationItemsHTML = '';
    reservation.forEach((item, index) => {
        reservationItemsHTML += `
            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-blue-200 mb-2">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">${item.name}</p>
                        <p class="text-sm text-gray-500">Quantity: ${item.quantity}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ${item.quantity} item${item.quantity > 1 ? 's' : ''}
                    </span>
                    <button type="button" class="ml-2 text-gray-400 hover:text-red-600" aria-label="Remove item" onclick="removeFromReservationSummary(${index})">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        `;
    });
    
    // Show SweetAlert2 modal
    Swal.fire({
        buttonsStyling: false,
        allowOutsideClick: false,
        customClass: { popup: 'swal-reservation-form' },
        html: `
            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-6 -m-6 -mt-6 mb-6 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                <div class="flex items-center justify-center gap-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h2 class="text-2xl font-bold">Complete Your Reservation</h2>
                </div>
                <p class="text-red-100 text-sm mt-2 text-center">Fill out the details below to submit your equipment reservation request</p>
            </div>
            
            <!-- Reservation Details - Toggleable -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <button type="button" id="toggleReservationDetails" class="w-full text-left">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-blue-900 text-left">How Reservation Works</h3>
                        <svg id="toggleIcon" class="w-5 h-5 text-blue-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                </button>
                <div id="reservationDetailsContent" class="mt-4 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800 text-left">
                        <div class="flex items-start space-x-2 text-left">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">1</div>
                            <div>
                                <p class="font-medium">Submit Request</p>
                                <p class="text-blue-600">Fill out this form with your details and equipment needs</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-2 text-left">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">2</div>
                            <div>
                                <p class="font-medium">Verify Email</p>
                                <p class="text-blue-600">We will send a 6-digit verification code to your email. You will enter it on the verification page to continue.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-2 text-left">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">3</div>
                            <div>
                                <p class="font-medium">Admin Review</p>
                                <p class="text-blue-600">Your request will be reviewed by our staff</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-2 text-left">
                            <div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">4</div>
                            <div>
                                <p class="font-medium">Approval & Pickup</p>
                                <p class="text-blue-600">You'll receive updates on your email. Pick up and return items on schedule to avoid penalties.</p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            <form id="reservationForm" method="POST" action="/reservations" class="space-y-6 text-left max-w-5xl mx-auto w-full">
                <input type="hidden" name="cart_data" value='${JSON.stringify(Array.isArray(reservation)?reservation:[])}'>
                
                <!-- Personal Details -->
                <div class="bg-gradient-to-r from-gray-50 to-blue-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Personal Details</h4>
                    </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                        <input type="text" name="name" id="name" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white"
                                   value="${(window.currentUserName || '').replace(/"/g,'&quot;')}">
                    </div>
                    <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</nlabel>
                        <input type="email" name="email" id="email" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white"
                                   value="${(window.currentUserEmail || '').replace(/"/g,'&quot;')}">
                    </div>
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number *</label>
                            <input type="tel" name="contact_number" id="contact_number" required placeholder="09123456789"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white">
                    </div>
                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
                        <select name="department" id="department" required 
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white"
                                onchange="document.getElementById('department_other_wrap').classList.toggle('hidden', this.value !== 'Other')">
                            <option value="">Select department...</option>
                            <option value="SBAA">SBAA</option>
                            <option value="SCJPS">SCJPS</option>
                            <option value="SOD">SOD</option>
                            <option value="SEA">SEA</option>
                            <option value="SIT">SIT</option>
                            <option value="SOL">SOL</option>
                            <option value="SNS">SNS</option>
                            <option value="SON">SON</option>
                            <option value="STELA">STELA</option>
                            <option value="Other">Other</option>
                        </select>
                        <div id="department_other_wrap" class="mt-2 hidden">
                            <input type="text" name="department_other" id="department_other" placeholder="Please specify department"
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white">
                        </div>
                        <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                        </div>
                    </div>
                </div>

                <!-- Date & Time -->
                <div class="bg-gradient-to-r from-gray-50 to-green-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Date & Time</h4>
                    </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-2">Borrow Date *</label>
                        <input type="date" name="borrow_date" id="borrow_date" required 
                               min="${todayStr}"
                                   max="${(() => { const d=new Date(); d.setHours(0,0,0,0); d.setDate(d.getDate()+6); return d.toISOString().slice(0,10); })()}"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white">
                        <p class="mt-1 text-sm text-gray-500">Please choose from the dates available on the calendar.</p>
                        <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                    
                    <div>
                        <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">Return Date *</label>
                        <input type="date" name="return_date" id="return_date" required 
                               min="${todayStr}"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white">
                        <p class="mt-1 text-sm text-gray-500">Up to 7 days from your chosen borrow date.</p>
                        <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                </div>
                    <div class="flex flex-col md:flex-row md:space-x-6 mt-4">
                    <div class="md:w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Borrow Time</label>
                        <div class="flex gap-2">
                                <select id="borrow_hour" class="w-20 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white" onchange="updateHiddenTimesAndValidate()">
                                ${Array.from({length:12}, (_,i)=>`<option value="${String(i+1).padStart(2,'0')}">${i+1}</option>`).join('')}
                            </select>
                                <select id="borrow_minute" class="w-20 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white" onchange="updateHiddenTimesAndValidate()">
                                ${[0,5,10,15,20,25,30,35,40,45,50,55].map(m=>`<option value="${String(m).padStart(2,'0')}">${String(m).padStart(2,'0')}</option>`).join('')}
                            </select>
                                <select id="borrow_period" class="w-24 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white" onchange="updateHiddenTimesAndValidate()">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                        <input type="hidden" name="borrow_time" id="borrow_time">
                        <div id="borrow_time_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                    <div class="md:w-1/2 mt-4 md:mt-0">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Return Time</label>
                        <div class="flex gap-2">
                                <select id="return_hour" class="w-20 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white" onchange="updateHiddenTimesAndValidate()">
                                ${Array.from({length:12}, (_,i)=>`<option value="${String(i+1).padStart(2,'0')}">${i+1}</option>`).join('')}
                            </select>
                                <select id="return_minute" class="w-20 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white" onchange="updateHiddenTimesAndValidate()">
                                ${[0,5,10,15,20,25,30,35,40,45,50,55].map(m=>`<option value="${String(m).padStart(2,'0')}">${String(m).padStart(2,'0')}</option>`).join('')}
                            </select>
                                <select id="return_period" class="w-24 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-400 bg-white" onchange="updateHiddenTimesAndValidate()">
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                        <input type="hidden" name="return_time" id="return_time">
                        <div id="return_time_error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                </div>
                </div>

                <!-- Reservation & Additional Details -->
                <div class="bg-gradient-to-r from-gray-50 to-purple-50 border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Reservation & Additional Details</h4>
                    </div>
                    <label for="reason_type" class="block text-sm font-medium text-gray-700 mb-2">Reason for Reservation *</label>
                    <select name="reason_type" id="reason_type" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                            onchange="toggleCustomReasonModal()">
                        <option value="">Select a reason...</option>
                        <option value="PE Class">PE Class</option>
                        <option value="Sports Event">Sports Event</option>
                        <option value="Training Session">Training Session</option>
                        <option value="Research/Study">Research/Study</option>
                        <option value="Other">Other (Specify)</option>
                    </select>
                    <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                    <div id="custom_reason_div" class="hidden mt-3">
                        <label for="custom_reason" class="block text.sm font-medium text-gray-700 mb-2">Specify Purpose <span class="text-red-500">*</span></label>
                    <textarea name="custom_reason" id="custom_reason" rows="3" 
                              placeholder="Please specify the purpose of your reservation..."
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"></textarea>
                    <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                </div>
                    <div class="mt-3">
                    <label for="additional_details" class="block text-sm font-medium text-gray-700 mb-2">Additional Details</label>
                    <textarea name="additional_details" id="additional_details" rows="2" 
                              placeholder="Any additional information..."
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"></textarea>
                    <div class="field-error-message text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                </div>
                
                <!-- Reservation Summary -->
                <div class="border-t pt-4">
                    <h4 class="font-medium text-gray-900 mb-2">Reservation Summary</h4>
                    <div class="space-y-2 text-sm text-gray-600">
                        ${reservationItemsHTML}
                    </div>
                </div>
            </form>
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-between mt-8 pt-6 border-t border-gray-200">
                <button type="button" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-200 hover:shadow-md border border-gray-300" onclick="Swal.close()">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </button>
                <button type="button" id="submitReservationBtn" class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg font-semibold transition-all duration-200 hover:shadow-lg transform hover:scale-105 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none" onclick="submitReservationForm()">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                    Submit Reservation
                </button>
            </div>
        `,
            showConfirmButton: false,
            showCancelButton: false,
            width: '90%',
            maxWidth: '800px',
            customClass: {
                popup: 'swal-custom-popup'
            },
        didOpen: () => {
            // Clear all previous errors when modal opens
            setTimeout(() => {
                const form = document.querySelector('.swal2-popup #reservationForm');
                if (form) {
                    const errorMessages = form.querySelectorAll('.field-error-message');
                    errorMessages.forEach(msg => {
                        msg.classList.add('hidden');
                        msg.innerHTML = '';
                    });
                    const errorFields = form.querySelectorAll('.border-red-500');
                    errorFields.forEach(field => field.classList.remove('border-red-500'));
                    
                    // Specifically validate the email field if it has content
                    const emailField = form.querySelector('[name="email"]');
                    if (emailField && emailField.value.trim()) {
                        const value = emailField.value.trim();
                        const ubEmailRegex = /^[a-zA-Z0-9._%+-]+@(s\.ubaguio\.edu|e\.ubaguio\.edu)$/;
                        
                        if (ubEmailRegex.test(value)) {
                            // Email is valid, ensure no error is shown
                            emailField.classList.remove('border-red-500');
                            clearFieldError(emailField);
                            console.log('Email validated as valid on modal open:', value);
                        }
                    }
                }
            }, 100);
            
            // Add toggle functionality for reservation details
            window.updateHiddenTimesAndValidate = function() {
                const bh = document.getElementById('borrow_hour')?.value;
                const bm = document.getElementById('borrow_minute')?.value;
                const bp = document.getElementById('borrow_period')?.value;
                const rh = document.getElementById('return_hour')?.value;
                const rm = document.getElementById('return_minute')?.value;
                const rp = document.getElementById('return_period')?.value;
                function to24(h,period){ let x=parseInt(h||'0',10)%12; if(period==='PM') x+=12; return String(x).padStart(2,'0'); }
                if (bh && bm && bp) document.getElementById('borrow_time').value = `${to24(bh,bp)}:${bm}`;
                if (rh && rm && rp) document.getElementById('return_time').value = `${to24(rh,rp)}:${rm}`;
                // Run lightweight validation only (no submission)
                try {
                    const form = document.querySelector('.swal2-popup #reservationForm');
                    if (!form) return;
                    let dummyFirstInvalid = null; // not used
                    // reuse same checks as submitReservationForm but without alerts
                    const borrowDate = new Date(form.borrow_date.value);
                    const returnDate = new Date(form.return_date.value);
                    const btVal = document.getElementById('borrow_time')?.value;
                    const rtVal = document.getElementById('return_time')?.value;
                    // use unified toMinutes defined earlier
                    const MIN=8*60, MAX=17*60; const btMin = toMinutes(btVal); const rtMin = toMinutes(rtVal);
                    const borrowErr = document.getElementById('borrow_time_error');
                    const returnErr = document.getElementById('return_time_error');
                    const borrowTimeField = document.getElementById('borrow_minute') || document.getElementById('borrow_time');
                    const returnTimeField = document.getElementById('return_minute') || document.getElementById('return_time');
                    function clearErr(el,div){ if (el) clearFieldError(el); if(div){div.textContent=''; div.classList.add('hidden');}}
                    function setErr(el,div,msg){ if (el) showFieldError(el,msg); if(div){div.textContent=msg; div.classList.remove('hidden');}}
                    clearErr(borrowTimeField,borrowErr); clearErr(returnTimeField,returnErr);
                    if (btMin!==null && (btMin<MIN || btMin>MAX)) setErr(borrowTimeField,borrowErr,'Borrow time must be between 8:00 AM and 5:00 PM');
                    if (rtMin!==null && (rtMin<MIN || rtMin>MAX)) setErr(returnTimeField,returnErr,'Return time must be between 8:00 AM and 5:00 PM');
                    if (btMin!==null && rtMin!==null && borrowDate.toDateString()===returnDate.toDateString()){
                        if (rtMin<=btMin) setErr(returnTimeField,returnErr,'Return time must be after borrow time');
                        else if (rtMin-btMin<30) setErr(returnTimeField,returnErr,'At least 30 minutes difference required');
                    }
                } catch(e) {}
            };
            const toggleButton = document.getElementById('toggleReservationDetails');
            const toggleContent = document.getElementById('reservationDetailsContent');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (toggleButton && toggleContent && toggleIcon) {
                toggleButton.addEventListener('click', () => {
                    const isHidden = toggleContent.classList.contains('hidden');
                    if (isHidden) {
                        toggleContent.classList.remove('hidden');
                        toggleIcon.style.transform = 'rotate(180deg)';
                    } else {
                        toggleContent.classList.add('hidden');
                        toggleIcon.style.transform = 'rotate(0deg)';
                    }
                });
            }

            // Dynamic 7-day window enforcement for borrow/return
            const borrowInput = document.getElementById('borrow_date');
            const returnInput = document.getElementById('return_date');
            const today = new Date();
            const startBorrow = new Date(today.getFullYear(), today.getMonth(), today.getDate()); // today
            const endBorrowBase = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7); // today up to +7 days
            const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0); // last day of current month
            const endBorrow = new Date(Math.min(endBorrowBase.getTime(), endOfMonth.getTime()));
            const toYMD = d => d.toISOString().split('T')[0];

            if (borrowInput && returnInput) {
                // Set borrow bounds: [today, no max limit]
                borrowInput.min = toYMD(startBorrow);

                const syncReturnBounds = () => {
                    const borrow = borrowInput.value ? new Date(borrowInput.value) : startBorrow;
                    // Return: min(endOfMonth, borrow+7) and >= borrow
                    const maxReturnByWindow = new Date(borrow.getFullYear(), borrow.getMonth(), borrow.getDate() + 7);
                    const maxReturn = new Date(Math.min(endOfMonth.getTime(), maxReturnByWindow.getTime()));
                    const minReturn = borrow;
                    const minStr = toYMD(minReturn);
                    const maxStr = toYMD(maxReturn);
                    returnInput.min = minStr;
                    returnInput.max = maxStr;
                    if (returnInput.value && (returnInput.value < minStr || returnInput.value > maxStr)) {
                        returnInput.value = '';
                    }
                };
                borrowInput.addEventListener('change', syncReturnBounds);
                // Initialize with defaults
                borrowInput.value = '';
                returnInput.value = '';
                syncReturnBounds();
                returnInput.addEventListener('change', () => {
                    const err = returnInput.parentElement.querySelector('.field-error-message');
                    const b = borrowInput.value ? new Date(borrowInput.value) : null;
                    const r = returnInput.value ? new Date(returnInput.value) : null;
                    let msg = '';
                    if (!b || !r) { msg = ''; }
                    else if (r < b) { msg = 'Return date cannot be before borrow date.'; }
                    else if ((r - b) > 7*24*60*60*1000 + 1000) { msg = 'Return date can be at most 7 days after the borrow date.'; }
                    if (msg) {
                        if (err) { err.textContent = msg; err.classList.remove('hidden'); }
                        returnInput.classList.add('border-red-500');
                    } else {
                        if (err) err.classList.add('hidden');
                        returnInput.classList.remove('border-red-500');
                    }
                });
            }

            // Add real-time validation for reservation form fields
            const reservationForm = document.querySelector('.swal2-popup #reservationForm');
            // Handler for removing items directly from Reservation Summary
            window.removeFromReservationSummary = function(index) {
                if (typeof index !== 'number' || !reservation[index]) return;
                const removed = reservation.splice(index, 1)[0];
                // Sync the dropdown reservation UI
                updateReservationDisplay();
                // If no items left, close the modal and inform the user
                if (reservation.length === 0) {
                    Swal.close();
                    showOrangeInfoModal('Your reservation is now empty');
                    return;
                }
                // Re-render the summary list
                const summaryContainer = document.querySelector('.swal2-popup .space-y-2.text-sm.text-gray-600');
                if (summaryContainer) {
                    // Regenerate HTML
                    let newHTML = '';
                    reservation.forEach((item, idx) => {
                        newHTML += `
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-blue-200 mb-2">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">${item.name}</p>
                                        <p class="text-sm text-gray-500">Quantity: ${item.quantity}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">${item.quantity} item${item.quantity > 1 ? 's' : ''}</span>
                                    <button type="button" class="ml-2 text-gray-400 hover:text-red-600" aria-label="Remove item" onclick="removeFromReservationSummary(${idx})">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>`;
                    });
                    summaryContainer.innerHTML = newHTML;
                }
                // Update the hidden reservation field used on submit
                const reservationField = document.querySelector('.swal2-popup #reservationForm [name="cart_data"]');
                if (reservationField) reservationField.value = JSON.stringify(reservation);
                // Feedback via orange modal (no flash)
                showOrangeInfoModal(`${removed.name} removed from reservation`, 'Reservation Updated');
            };
            if (reservationForm) {
                const fields = reservationForm.querySelectorAll('input, textarea');
                fields.forEach(field => {
                    // Add validation on blur (when user leaves the field)
                    field.addEventListener('blur', () => {
                        validateField(field);
                        clearFormErrorSummary(); // Clear error summary when user starts fixing errors
                    });
                    
                    // Add validation on input (real-time as user types)
                    field.addEventListener('input', () => {
                        // Clear error styling and message when user starts typing
                        if (field.classList.contains('border-red-500')) {
                            field.classList.remove('border-red-500');
                            clearFieldError(field);
                        }
                        
                        // Special handling for contact number - limit to 11 digits and only numbers
                        if (field.name === 'contact_number') {
                            // Remove any non-numeric characters
                            field.value = field.value.replace(/\D/g, '');
                            // Limit to 11 digits and show error if exceeded
                            if (field.value.length > 11) {
                                field.value = field.value.substring(0, 11);
                                field.classList.add('border-red-500');
                                showFieldError(field, 'Contact number must be exactly 11 digits');
                            } else {
                                field.classList.remove('border-red-500');
                                clearFieldError(field);
                            }
                            setTimeout(() => validateField(field), 300);
                        }
                        
                        // For email field, validate as user types
                        if (field.name === 'email') {
                            // Clear error immediately when user starts typing
                            field.classList.remove('border-red-500');
                            clearFieldError(field);
                            
                            setTimeout(() => {
                                const value = field.value.trim();
                                const ubEmailRegex = /^[a-zA-Z0-9._%+-]+@(s\.ubaguio\.edu|e\.ubaguio\.edu)$/;
                                
                                console.log('Email validation:', { value, isValid: ubEmailRegex.test(value) });
                                
                                // Only show error if there's content and it's invalid
                                if (value && !ubEmailRegex.test(value)) {
                                    console.log('Email invalid, showing error');
                                    field.classList.add('border-red-500');
                                    showFieldError(field, 'Please use your University of Baguio email format.');
                                } else if (value && ubEmailRegex.test(value)) {
                                    console.log('Email valid, ensuring no error');
                                    field.classList.remove('border-red-500');
                                    clearFieldError(field);
                                }
                            }, 500); // Debounce validation
                        }
                    });
                    
                    // Add validation on change (for date fields and file inputs)
                    field.addEventListener('change', () => {
                        validateField(field);
                        clearFormErrorSummary();
                    });
                    
                    // Special handling for email field - validate on focus and blur
                    if (field.name === 'email') {
                        field.addEventListener('focus', () => {
                            // Clear any existing errors when user focuses on email field
                            field.classList.remove('border-red-500');
                            clearFieldError(field);
                        });
                        
                        field.addEventListener('blur', () => {
                            // Validate when user leaves the email field
                            const value = field.value.trim();
                            const ubEmailRegex = /^[a-zA-Z0-9._%+-]+@(s\.ubaguio\.edu|e\.ubaguio\.edu)$/;
                            
                            if (value && !ubEmailRegex.test(value)) {
                                field.classList.add('border-red-500');
                                showFieldError(field, 'Please use your University of Baguio email format.');
                            } else if (value && ubEmailRegex.test(value)) {
                                field.classList.remove('border-red-500');
                                clearFieldError(field);
                            }
                        });
                    }
                });
                
                // Set minimum return date based on borrow date (allow same day)
                const borrowDateField = reservationForm.querySelector('[name="borrow_date"]');
                const returnDateField = reservationForm.querySelector('[name="return_date"]');
                if (borrowDateField && returnDateField) {
                    borrowDateField.addEventListener('change', function() {
                        const borrowDate = this.value;
                        const minReturnDate = new Date(borrowDate); // same day allowed
                        const maxReturnDate = new Date(borrowDate);
                        maxReturnDate.setDate(maxReturnDate.getDate() + 7);
                        
                        returnDateField.min = minReturnDate.toISOString().split('T')[0];
                        returnDateField.max = maxReturnDate.toISOString().split('T')[0];
                        
                        // Clear return date if it's now invalid
                        if (returnDateField.value) {
                            const currentReturnDate = new Date(returnDateField.value);
                            if (currentReturnDate < new Date(borrowDate) || currentReturnDate > maxReturnDate) {
                            returnDateField.value = '';
                                returnDateField.classList.remove('border-red-500');
                                clearFieldError(returnDateField);
                            }
                        }
                        
                        // Validate both fields after change
                        validateField(borrowDateField);
                        validateField(returnDateField);
                    });
                }
            }

            // Add real-time validation for submit button
            setupRealTimeValidation();
        }
        ,
        customClass: { popup: 'swal-reservation-form' }
    });
}

// Submit reservation form
function submitReservationForm() {
    console.log('submitReservationForm function called'); // Debug log
    
    // Find the form within the SweetAlert2 modal
    const form = document.querySelector('.swal2-popup #reservationForm');
    console.log('Form found:', form); // Debug log
    
    if (!form) {
        console.error('Form not found in modal'); // Debug log
        Swal.fire({
            icon: false,
            buttonsStyling: false,
            html: `
                <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                    <h2 class="text-xl font-bold text-center">Form Error</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700">Reservation form not found. Please refresh the page and try again.</p>
                </div>
                <div class="flex justify-center mt-6">
                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
        return;
    }

    // Clear previous error states
    clearFormErrors();
    
        // Validate form
        const requiredFields = ['name', 'email', 'contact_number', 'department', 'borrow_date', 'return_date', 'reason'];
        let isValid = true;
        let firstInvalidField = null;
        let errorMessages = [];

        requiredFields.forEach(fieldName => {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                // Regular text inputs
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    showFieldError(field, 'This field is required');
                    if (!firstInvalidField) firstInvalidField = field;
                    isValid = false;
                    errorMessages.push(`${getFieldLabel(fieldName)} is required`);
                } else {
                    field.classList.remove('border-red-500');
                    clearFieldError(field);
                }
            }
        });

        // Validate department_other field if "Other" is selected
        const departmentField = form.querySelector('[name="department"]');
        const departmentOtherField = form.querySelector('[name="department_other"]');
        if (departmentField && departmentField.value === 'Other') {
            if (!departmentOtherField || !departmentOtherField.value.trim()) {
                if (departmentOtherField) {
                    departmentOtherField.classList.add('border-red-500');
                    showFieldError(departmentOtherField, 'Please specify the department');
                    if (!firstInvalidField) firstInvalidField = departmentOtherField;
                }
                isValid = false;
                errorMessages.push('Please specify the department when "Other" is selected');
            } else {
                if (departmentOtherField) {
                    departmentOtherField.classList.remove('border-red-500');
                    clearFieldError(departmentOtherField);
                }
            }
        }

    // Validate email format (UB email format)
    const emailField = form.querySelector('[name="email"]');
    if (emailField && emailField.value.trim()) {
        const email = emailField.value.trim();
        const ubEmailRegex = /^[a-zA-Z0-9._%+-]+@(s\.ubaguio\.edu|e\.ubaguio\.edu)$/;
        console.log('Form submission email validation:', { email, isValid: ubEmailRegex.test(email) });
        if (!ubEmailRegex.test(email)) {
            emailField.classList.add('border-red-500');
            showFieldError(emailField, 'Please use your University of Baguio email format.');
            if (!firstInvalidField) firstInvalidField = emailField;
            isValid = false;
            errorMessages.push('Please use your University of Baguio email format.');
        } else {
            // Clear any existing error if email is valid
            emailField.classList.remove('border-red-500');
            clearFieldError(emailField);
        }
    }

    // Validate contact number (11 digits Philippines format)
    const contactField = form.querySelector('[name="contact_number"]');
    if (contactField && contactField.value.trim()) {
        const contact = contactField.value.trim();
        const phContactRegex = /^09[0-9]{9}$/;
        if (!phContactRegex.test(contact)) {
            contactField.classList.add('border-red-500');
            showFieldError(contactField, 'Contact number must be 11 digits starting with 09 (Philippines format)');
            if (!firstInvalidField) firstInvalidField = contactField;
            isValid = false;
            errorMessages.push('Contact number must be 11 digits starting with 09');
        }
    }

    // Validate dates with unified logic
    const borrowDate = new Date(form.borrow_date.value);
    const returnDate = new Date(form.return_date.value);
    // Build HH:MM 24h strings from selectors if present
    const bh = document.getElementById('borrow_hour');
    if (bh) {
        const bm = document.getElementById('borrow_minute').value;
        const bp = document.getElementById('borrow_period').value;
        const h24 = (p)=>{ let h=parseInt(p,10)%12; if (bp==='PM') h+=12; return String(h).padStart(2,'0'); };
        document.getElementById('borrow_time').value = `${h24(bh.value)}:${bm}`;
    }
    const rh = document.getElementById('return_hour');
    if (rh) {
        const rm = document.getElementById('return_minute').value;
        const rp = document.getElementById('return_period').value;
        const h24 = (p)=>{ let h=parseInt(p,10)%12; if (rp==='PM') h+=12; return String(h).padStart(2,'0'); };
        document.getElementById('return_time').value = `${h24(rh.value)}:${rm}`;
    }

    // Also validate immediately after composing the times when users interact with selectors
    updateHiddenTimesAndValidate();
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    // Normalize borrow date to local date-only
    const borrowDateLocal = new Date(borrowDate);
    borrowDateLocal.setHours(0, 0, 0, 0);

    if (borrowDateLocal < today) {
        const borrowDateField = form.querySelector('[name="borrow_date"]');
        borrowDateField.classList.add('border-red-500');
        showFieldError(borrowDateField, 'Please select today or a future date');
        if (!firstInvalidField) firstInvalidField = borrowDateField;
        isValid = false;
        errorMessages.push('Please select today or a future date');
    }

    if (returnDate < borrowDate) {
        const returnDateField = form.querySelector('[name="return_date"]');
        returnDateField.classList.add('border-red-500');
        // allow same-day returns; only error if strictly before
        showFieldError(returnDateField, 'Return date cannot be before borrow date');
        if (!firstInvalidField) firstInvalidField = returnDateField;
        isValid = false;
        errorMessages.push('Return date cannot be before borrow date');
    } else if (returnDate > new Date(borrowDate.getTime() + 7 * 24 * 60 * 60 * 1000)) {
        const returnDateField = form.querySelector('[name="return_date"]');
        returnDateField.classList.add('border-red-500');
        showFieldError(returnDateField, 'Return date cannot be more than 7 days after borrow date');
        if (!firstInvalidField) firstInvalidField = returnDateField;
        isValid = false;
        errorMessages.push('Return date cannot be more than 7 days after borrow date');
    }

    // Time window validation (8:00 AM - 5:00 PM) and 30-minute difference if same-day
    // This should run regardless of date validation (unless returnDate < borrowDate)
    if (returnDate >= borrowDate) {
        const btVal = document.getElementById('borrow_time')?.value;
        const rtVal = document.getElementById('return_time')?.value;
        // Helper is defined here to avoid scope issues in minified bundles
        const toMinutes = (v) => { if (!v) return null; const parts = v.split(':').map(Number); if (parts.length !== 2 || Number.isNaN(parts[0]) || Number.isNaN(parts[1])) return null; return parts[0]*60 + parts[1]; };
        // use unified toMinutes defined earlier
        const MIN_TIME = 8*60;   // 08:00
        const MAX_TIME = 17*60;  // 17:00
        const btMin = toMinutes(btVal);
        const rtMin = toMinutes(rtVal);
        if (btMin !== null) {
            const borrowTimeField = document.getElementById('borrow_minute') || document.getElementById('borrow_time');
            const borrowErr = document.getElementById('borrow_time_error');
            if (btMin < MIN_TIME || btMin > MAX_TIME) {
                showFieldError(borrowTimeField, 'Borrow time must be between 8:00 AM and 5:00 PM');
                if (borrowErr) { borrowErr.textContent = 'Borrow time must be between 8:00 AM and 5:00 PM'; borrowErr.classList.remove('hidden'); }
                if (!firstInvalidField) firstInvalidField = borrowTimeField;
                isValid = false;
                errorMessages.push('Borrow time must be between 8:00 AM and 5:00 PM');
            } else {
                clearFieldError(borrowTimeField);
                if (borrowErr) { borrowErr.textContent = ''; borrowErr.classList.add('hidden'); }
            }
        }
        if (rtMin !== null) {
            const returnTimeField = document.getElementById('return_minute') || document.getElementById('return_time');
            const returnErr = document.getElementById('return_time_error');
            if (rtMin < MIN_TIME || rtMin > MAX_TIME) {
                showFieldError(returnTimeField, 'Return time must be between 8:00 AM and 5:00 PM');
                if (returnErr) { returnErr.textContent = 'Return time must be between 8:00 AM and 5:00 PM'; returnErr.classList.remove('hidden'); }
                if (!firstInvalidField) firstInvalidField = returnTimeField;
                isValid = false;
                errorMessages.push('Return time must be between 8:00 AM and 5:00 PM');
            } else {
                clearFieldError(returnTimeField);
                if (returnErr) { returnErr.textContent = ''; returnErr.classList.add('hidden'); }
            }
        }
        if (btMin !== null && rtMin !== null && borrowDate.toDateString() === returnDate.toDateString()) {
            if (rtMin <= btMin) {
                const returnTimeField = document.getElementById('return_minute') || document.getElementById('return_time');
                showFieldError(returnTimeField, 'Return time must be after borrow time');
                const returnErr = document.getElementById('return_time_error');
                if (returnErr) { returnErr.textContent = 'Return time must be after borrow time'; returnErr.classList.remove('hidden'); }
                if (!firstInvalidField) firstInvalidField = returnTimeField;
                isValid = false;
                errorMessages.push('Return time must be after borrow time');
            } else if (rtMin - btMin < 30) {
                const returnTimeField = document.getElementById('return_minute') || document.getElementById('return_time');
                showFieldError(returnTimeField, 'For same-day reservations, allow at least 30 minutes between times');
                const returnErr = document.getElementById('return_time_error');
                if (returnErr) { returnErr.textContent = 'At least 30 minutes difference required'; returnErr.classList.remove('hidden'); }
                if (!firstInvalidField) firstInvalidField = returnTimeField;
                isValid = false;
                errorMessages.push('At least 30 minutes difference required for same-day times');
            }
        }
    }

    if (!isValid) {
        // Show error summary at the top of the form
        showFormErrorSummary(errorMessages);
        if (firstInvalidField) firstInvalidField.focus();
        
        // Scroll to the first error field
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        return; // Don't proceed with submission
    }

    console.log('Form validation passed, submitting...'); // Debug log

    // Helper: actually submit the reservation
    // Helper to compute and ensure reason exists
    const ensureFinalReason = () => {
        const reasonTypeEl = form.querySelector('[name="reason_type"]');
        const customReasonEl = form.querySelector('[name="custom_reason"]');
        let reasonEl = form.querySelector('[name="reason"]');
        if (!reasonEl) {
            reasonEl = document.createElement('input');
            reasonEl.type = 'hidden';
            reasonEl.name = 'reason';
            form.appendChild(reasonEl);
        }
        let finalReasonVal = reasonTypeEl ? (reasonTypeEl.value || '') : (reasonEl.value || '');
        if (reasonTypeEl && reasonTypeEl.value === 'Other' && customReasonEl && customReasonEl.value.trim()) {
            finalReasonVal = customReasonEl.value.trim();
        }
        reasonEl.value = finalReasonVal;
        console.log('[Submit] Ensured reason value:', finalReasonVal);
        return finalReasonVal;
    };

    const actuallySubmitReservation = () => {
        // Ensure final reason value is set on the form prior to submission
        try { ensureFinalReason(); } catch (_) {}
        // Plain loading (no colored header)
        Swal.fire({
            title: 'Submitting Reservation...',
            text: 'Please wait while we process your request.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => { Swal.showLoading(); },
            customClass: { popup: 'swal-custom-popup' }
        });

        const formData = new FormData(form);

        fetch('/reservations/initiate', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(JSON.stringify(errorData));
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response received:', data);
            if (data.success && data.redirect_url) {
                window.location.href = data.redirect_url;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.close();
            let errorMessage = 'An error occurred while submitting your reservation. Please try again.';
            let hasValidationErrors = false;
            try {
                const errorData = JSON.parse(error.message);
                if (errorData.errors) {
                    hasValidationErrors = true;
                    clearFormErrors();
                    Object.keys(errorData.errors).forEach(fieldName => {
                        const field = form.querySelector(`[name="${fieldName}"]`);
                        if (field) {
                            field.classList.add('border-red-500');
                            showFieldError(field, errorData.errors[fieldName][0]);
                        }
                    });
                    const errorMessages = [];
                    Object.keys(errorData.errors).forEach(fieldName => {
                        errorData.errors[fieldName].forEach(message => {
                            errorMessages.push(`${getFieldLabel(fieldName)}: ${message}`);
                        });
                    });
                    showFormErrorSummary(errorMessages);
                    const firstErrorField = form.querySelector('.border-red-500');
                    if (firstErrorField) {
                        firstErrorField.focus();
                        firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return;
                } else if (errorData.message) {
                    errorMessage = errorData.message;
                }
            } catch (parseError) {
                console.error('Error parsing error data:', parseError);
            }
            if (!hasValidationErrors) {
                showFormErrorSummary([errorMessage]);
            }
        });
    };

    // Ensure cart_data reflects the latest reservation state
    try {
        const cartInput = form.querySelector('[name="cart_data"]');
        if (cartInput && typeof reservation !== 'undefined') {
            const safeCart = Array.isArray(reservation) ? reservation : [];
            cartInput.value = JSON.stringify(safeCart);
        }
    } catch (e) { /* noop */ }

    // Step 1: duplicate check before submit
    // Ensure final reason is populated for the check, matching instructor flow
    try { ensureFinalReason(); } catch(_) {}
    const checkData = new FormData();
    const getVal = (name) => (form.querySelector(`[name="${name}"]`) || {}).value || '';
    checkData.append('email', getVal('email'));
    checkData.append('borrow_date', getVal('borrow_date'));
    checkData.append('return_date', getVal('return_date'));
    checkData.append('borrow_time', getVal('borrow_time'));
    checkData.append('return_time', getVal('return_time'));
    checkData.append('reason', getVal('reason'));
    checkData.append('department', getVal('department'));
    checkData.append('department_other', getVal('department_other'));
    checkData.append('cart_data', getVal('cart_data'));

    // DEBUG: log payload for duplicate check
    try {
        console.log('[DupCheck] Starting duplicate check with payload:');
        const debugObj = {};
        ['email','borrow_date','return_date','borrow_time','return_time','reason','department','department_other','cart_data']
            .forEach(k => debugObj[k] = checkData.get(k));
        console.log('[DupCheck] Payload', debugObj);
    } catch (e) { console.warn('[DupCheck] Debug log failed', e); }

    Swal.fire({
        title: 'Checking for duplicate reservation...',
        text: 'Please wait a moment.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => Swal.showLoading(),
        customClass: { popup: 'swal-custom-popup' }
    });

    const minDelay = new Promise(resolve => setTimeout(resolve, 700));
    const dupCheck = fetch('/reservations/check-duplicate', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: checkData
    }).then(r => r.json());

    Promise.all([dupCheck, minDelay])
    .then(([res]) => {
        Swal.close();
        console.log('[DupCheck] Response', res);
        if (res && res.is_duplicate) {
            // Orange modal (copied styling from instructor flow)
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-orange-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;">
                        <h2 class="text-xl font-bold text-center">Duplicate Reservation Detected</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4 flex justify-center">
                            <div class="w-16 h-16 mb-2 rounded-full bg-orange-100 flex items-center justify-center">
                                <svg class="w-9 h-9 text-orange-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-5a1 1 0 102 0 1 1 0 00-2 0zm1-8a1 1 0 00-1 1v5a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700 text-lg font-medium">You already have a similar reservation</p>
                        <p class="text-gray-600 text-sm mt-2">${res.message || 'A similar reservation appears to exist with the same details.'}</p>
                        <p class="text-gray-600 text-sm mt-1">Do you want to proceed anyway?</p>
                    </div>
                    <div class="flex justify-between mt-6">
                        <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors transform hover:scale-105" onclick="Swal.close()">Cancel</button>
                        <button type="button" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors transform hover:scale-105" id="dupProceedBtn">Proceed</button>
                    </div>
                `,
                showConfirmButton: false,
                customClass: { popup: 'swal-custom-popup' }
            }).then(() => {
                // no-op; buttons handle actions
            });
            setTimeout(() => {
                const btn = document.getElementById('dupProceedBtn');
                if (btn) {
                    btn.addEventListener('click', () => {
                        let proceedInput = form.querySelector('[name="proceed_with_duplicate"]');
                        if (!proceedInput) {
                            proceedInput = document.createElement('input');
                            proceedInput.type = 'hidden';
                            proceedInput.name = 'proceed_with_duplicate';
                            form.appendChild(proceedInput);
                        }
                        proceedInput.value = '1';
                        console.log('[DupCheck] Proceeding despite duplicate (proceed_with_duplicate=1)');
                        actuallySubmitReservation();
                    });
                }
            }, 0);
            return; // prevent auto-submit after handling duplicate
        }
        // Blue confirmation modal when no duplicate (copied styling from instructor flow)
        Swal.fire({
            title: '',
            html: `
                <div class="bg-blue-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;">
                    <h2 class="text-xl font-bold text-center">Confirm Reservation</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700 text-lg font-medium">Are you ready to submit your reservation?</p>
                    <p class="text-gray-600 text-sm mt-2">Please review your reservation details before proceeding.</p>
                </div>
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors transform hover:scale-105" onclick="Swal.close()">Cancel</button>
                    <button type="button" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors transform hover:scale-105" id="confirmSubmitBtn">Submit Reservation</button>
                </div>
            `,
            showConfirmButton: false,
            customClass: { popup: 'swal-custom-popup' }
        });
        setTimeout(() => {
            const btn = document.getElementById('confirmSubmitBtn');
            if (btn) btn.addEventListener('click', () => actuallySubmitReservation());
        }, 0);
    })
    .catch((err) => {
        // If duplicate check fails, fail open and submit
        console.error('[DupCheck] Request failed, proceeding anyway', err);
        Swal.close();
        actuallySubmitReservation();
    });
}



// Close reservation modal
function closeReservationModal() {
    const modal = document.getElementById('reservationModal');
    if (modal) modal.classList.add('hidden');
}

// Helper functions for form validation (SweetAlert2 compatible)
function clearFormErrors() {
    // Remove all error messages from SweetAlert2 modal
    const errorMessages = document.querySelectorAll('.swal2-popup .field-error-message, .swal2-popup .form-error-summary');
    errorMessages.forEach(msg => msg.remove());
    
    // Remove error styling from all fields
    const errorFields = document.querySelectorAll('.swal2-popup .border-red-500');
    errorFields.forEach(field => field.classList.remove('border-red-500'));
}

function clearFormErrorSummary() {
    // Clear only the form error summary, not individual field errors
    const errorSummary = document.querySelector('.swal2-popup #formErrorSummary');
    if (errorSummary) {
        errorSummary.classList.add('hidden');
        errorSummary.innerHTML = '';
    }
}

function showFieldError(field, message) {
    // Find the error container for this field
    const errorContainer = field.parentNode.querySelector('.field-error-message');
    if (errorContainer) {
        // Make error messages more user-friendly
        let friendlyMessage = message;
        
        if (message.includes('required')) {
            friendlyMessage = 'This field is required to complete your reservation';
        } else if (message.includes('email')) {
            friendlyMessage = 'Please use your University of Baguio email format';
        } else if (message.includes('contact')) {
            friendlyMessage = 'Please enter a valid 11-digit Philippine mobile number';
        } else if (message.includes('date')) {
            friendlyMessage = message;
        } else if (message.includes('characters')) {
            friendlyMessage = message;
        } else if (message.includes('ID')) {
            friendlyMessage = 'Please upload a clear photo of your University ID';
        }
        
        errorContainer.innerHTML = `
            <div class="flex items-start text-red-600 text-sm mt-2 p-2 bg-red-50 rounded-md border border-red-200">
                <span class="leading-relaxed">${friendlyMessage}</span>
            </div>
        `;
        errorContainer.classList.remove('hidden');
    }
}

function clearFieldError(field) {
    const errorContainer = field.parentNode.querySelector('.field-error-message');
    if (errorContainer) {
        errorContainer.classList.add('hidden');
        errorContainer.innerHTML = '';
        console.log('Field error cleared for:', field.name);
    }
    
    // Also try to find and clear any error messages in the parent container
    const parentContainer = field.parentNode;
    if (parentContainer) {
        // Look for any div with red text that contains email-related error messages
        const errorDivs = parentContainer.querySelectorAll('div');
        errorDivs.forEach(div => {
            if (div.textContent && (
                div.textContent.includes('University of Baguio email') || 
                div.textContent.includes('email format') ||
                div.textContent.includes('Please use your University of Baguio email format')
            )) {
                div.style.display = 'none';
                div.innerHTML = '';
                div.classList.add('hidden');
                console.log('Cleared error div:', div.textContent);
            }
        });
    }
}

function showFormErrorSummary(errorMessages) {
    // Show error summary in SweetAlert2 modal
    const errorSummary = document.querySelector('.swal2-popup #formErrorSummary');
    if (errorSummary) {
        // Group errors by type for better user experience
        const requiredFields = errorMessages.filter(msg => msg.includes('is required'));
        const validationErrors = errorMessages.filter(msg => !msg.includes('is required'));
        
        errorSummary.innerHTML = `
            <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-r-lg p-4 mb-6 shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">
                            Please fill in all required fields to continue.
                        </p>
                    </div>
                </div>
            </div>
        `;
        errorSummary.classList.remove('hidden');
    }
}

function getFieldLabel(fieldName) {
    const labels = {
        'name': 'Full Name',
        'email': 'Email',
        'contact_number': 'Contact Number',
        'department': 'Department',
        'borrow_date': 'Borrow Date',
        'return_date': 'Return Date',
        'reason': 'Reason for Reservation',
    };
    return labels[fieldName] || fieldName;
}

function validateField(field) {
    const fieldName = field.name;
    const value = field.value ? field.value.trim() : '';
    
    // Clear previous error
    clearFieldError(field);
    field.classList.remove('border-red-500');
    
    // Validate based on field type
    let isValid = true;
    let errorMessage = '';
    
    // Special handling for file inputs
    if (field.type === 'file') {
        if (field.hasAttribute('required') && (!field.files || field.files.length === 0)) {
            isValid = false;
            errorMessage = 'This field is required';
        }
    } else if (field.hasAttribute('required') && !value) {
        isValid = false;
        errorMessage = 'This field is required';
    } else if (value) {
        switch (fieldName) {
            case 'name':
                if (value.length < 2) {
                    isValid = false;
                    errorMessage = 'Please enter your full name (at least 2 characters)';
                }
                break;
            case 'email':
                const ubEmailRegex = /^[a-zA-Z0-9._%+-]+@(s\.ubaguio\.edu|e\.ubaguio\.edu)$/;
                if (!ubEmailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Please use your University of Baguio email format.';
                }
                break;
            case 'contact_number':
                const phContactRegex = /^09[0-9]{9}$/;
                if (!phContactRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid Philippine mobile number (11 digits starting with 09)';
                }
                break;
            case 'borrow_date':
                const borrowDate = new Date(value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                // allow same-day
                
                // Normalize borrow date to local date-only
                const borrowDateLocal = new Date(borrowDate);
                borrowDateLocal.setHours(0, 0, 0, 0);
                
                if (borrowDateLocal < today) {
                    isValid = false;
                    errorMessage = 'Please select today or a future date';
                }
                break;
            case 'borrow_time':
            case 'return_time':
                // Handled via selectors; keep no-op to avoid default
                break;
            case 'return_date':
                const returnDate = new Date(value);
                const borrowDateField = field.closest('form').querySelector('[name="borrow_date"]');
                if (borrowDateField && borrowDateField.value) {
                    const borrowDate = new Date(borrowDateField.value);
                    const maxReturnDate = new Date(borrowDate);
                    maxReturnDate.setDate(maxReturnDate.getDate() + 7); // Max 7 days rental period
                    
                    if (returnDate < borrowDate) {
                        isValid = false;
                        errorMessage = 'Return date cannot be before your borrow date';
                    } else if (returnDate > maxReturnDate) {
                        isValid = false;
                        errorMessage = 'Maximum rental period is 7 days';
                    }
                } else if (field.hasAttribute('required')) {
                    isValid = false;
                    errorMessage = 'This field is required';
                }
                break;
            case 'reason':
                if (value.length < 10) {
                    isValid = false;
                    errorMessage = 'Please provide more details about why you need this equipment (at least 10 characters)';
                }
                break;
        }
    }
    
    // Show error if validation failed
    if (!isValid) {
        field.classList.add('border-red-500');
        showFieldError(field, errorMessage);
    }
    
    return isValid;
}

// Wishlist functionality (pure wishlist add)
function addToWishlist(equipmentId, equipmentName, event) {
    console.log('Adding to wishlist:', equipmentId, equipmentName);
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('CSRF token not found');
        showNotification('Error: CSRF token not found', 'error');
        return;
    }
    
    fetch(`/wishlist/add/${equipmentId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        return response.json().then(data => {
            return { status: response.status, data: data };
        });
    })
    .then(({ status, data }) => {
        if (data.success) {
            const button = event.target.closest('button');
            if (button) {
                // Only change the heart icon, not the entire button
                const heartIcon = button.querySelector('svg');
                if (heartIcon) {
                    // Store original icon
                    const originalIcon = heartIcon.outerHTML;
                    
                    // Change to filled star icon in yellow
                    heartIcon.innerHTML = '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>';
                    heartIcon.style.fill = '#f59e0b'; // Amber/yellow
                    
                    // Update button styling for success state (yellow theme)
                    button.className = 'wishlist-btn inline-flex items-center gap-1 px-3 py-2 bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-300 text-amber-700 rounded-lg cursor-not-allowed';
                    
                    // Create success text
                    const addedText = document.createElement('span');
                    addedText.textContent = 'Added!';
                    addedText.className = 'text-xs font-medium';
                    
                    // Clear button content and add icon + text
                    button.innerHTML = '';
                    button.appendChild(heartIcon);
                    button.appendChild(addedText);
                    
                    // Disable button to prevent further clicks
                    button.disabled = true;
                    button.style.cursor = 'not-allowed';
                    
                    setTimeout(() => {
                        // Restore original button state
                        button.innerHTML = originalIcon;
                        button.disabled = false;
                        button.style.cursor = 'pointer';
                    }, 3000);
                }
            }
            
            // Show green themed modal instead of flash notification
            Swal.fire({
                icon: false,
                html: `
                    <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Added to Wishlist</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700 mb-4">Equipment added to wishlist successfully!</p>
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
        } else {
            // Handle duplicate wishlist addition
            if (status === 400 && data.message.includes('already added')) {
                const button = event.target.closest('button');
                if (button) {
                    const heartIcon = button.querySelector('svg');
                    if (heartIcon) {
                        // Change to filled star icon in yellow and show "Already Added"
                        heartIcon.innerHTML = '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>';
                        heartIcon.style.fill = '#f59e0b'; // Amber/yellow
                        
                        // Update button styling for already added state (yellow)
                        button.className = 'wishlist-btn inline-flex items-center gap-1 px-2 py-1 bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-300 text-amber-700 rounded-lg cursor-not-allowed';
                        
                        const alreadyText = document.createElement('span');
                        alreadyText.textContent = 'Already Added';
                        alreadyText.className = 'text-xs font-medium';
                        
                        button.innerHTML = '';
                        button.appendChild(heartIcon);
                        button.appendChild(alreadyText);
                        button.disabled = true;
                    }
                }
                showErrorModal('Already Added', data.message);
            } else {
                showErrorModal('Error', data.message || 'Error adding to wishlist');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorModal('Error', 'Error adding to wishlist: ' + error.message);
    });
}

// Separate function: open Notify-When-Available modal (no wishlist add)
function notifyWhenAvailable(equipmentId, equipmentName, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    // Ensure function exists and is bound
    if (typeof showWishlistNotificationModal === 'function') {
        showWishlistNotificationModal(equipmentId, equipmentName);
    } else {
        // Fallback: basic modal
        showErrorModal('Error', 'Notification feature is unavailable at the moment.');
    }
}

// Show wishlist notification modal for unavailable equipment
function showWishlistNotificationModal(equipmentId, equipmentName) {
    Swal.fire({
        icon: false,
        buttonsStyling: false,
        html: `
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-2-2V11a6 6 0 10-12 0v4l-2 2h5a3 3 0 006 0z"/></svg>
                    <h2 class="text-base sm:text-lg font-bold">Get Notified When Available</h2>
                </div>
            </div>
            <div class="text-center">
                <div class="mb-4">
                    <div class="mx-auto w-16 h-16 bg-transparent flex items-center justify-center mb-3">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-2-2V11a6 6 0 10-12 0v4l-2 2h5a3 3 0 006 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">${equipmentName}</h3>
                    <p class="text-sm text-gray-600 mb-4">This equipment is currently unavailable. Enter your UB email to get notified when it becomes available.</p>
                </div>
                <div class="text-left space-y-4">
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                        <input type="text" id="wishlistEmail" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="12345678@s.ubaguio.edu">
                        <p id="wishlistEmailError" class="mt-1 text-xs text-red-600 hidden"></p>
                        <div class="mt-1 text-xs text-gray-500">Please use your University of Baguio email format</div>
                    </div>
                    
                </div>
                <div class="flex items-center justify-between mt-6">
                    <button type="button" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors" onclick="Swal.close()">Cancel</button>
                    <button type="button" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" id="subscribeNotifyBtn">Get Notified</button>
                </div>
            </div>
        `,
        showConfirmButton: false,
        customClass: { popup: 'swal-custom-popup' },
        didOpen: () => {
            const emailInput = document.getElementById('wishlistEmail');
            const emailError = document.getElementById('wishlistEmailError');
            const subscribeBtn = document.getElementById('subscribeNotifyBtn');

            const validateEmail = () => {
                const value = emailInput.value.trim();
                const ubPattern = /^[0-9]{8}@[se]\.ubaguio\.edu$/;
                if (!ubPattern.test(value)) {
                    emailError.textContent = 'Please use a valid UB email (e.g., 12345678@s.ubaguio.edu or 12345678@e.ubaguio.edu).';
                    emailError.classList.remove('hidden');
                    emailInput.classList.add('border-red-500');
                    return false;
                }
                emailError.textContent = '';
                emailError.classList.add('hidden');
                emailInput.classList.remove('border-red-500');
                return true;
            };

            emailInput.addEventListener('input', validateEmail);
            subscribeBtn.addEventListener('click', () => {
                if (!validateEmail()) return;
                subscribeToWishlistNotification(
                    equipmentId,
                    equipmentName,
                    null,
                    emailInput.value.trim(),
                    null
                );
            });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { name, email, contact } = result.value;
            subscribeToWishlistNotification(equipmentId, equipmentName, name, email, contact);
        }
    });
}

// Subscribe to wishlist notification
function subscribeToWishlistNotification(equipmentId, equipmentName, name, email, contact) {
    // Show loading (match reservation submission style)
    Swal.fire({
        title: 'Submitting...',
        text: 'Please wait while we process your request.',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        Swal.fire({
            icon: false,
            buttonsStyling: false,
            html: `
                <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                    <h2 class="text-xl font-bold text-center">Error</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700">CSRF token not found. Please refresh the page and try again.</p>
                </div>
                <div class="flex justify-center mt-6">
                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
        return;
    }
    
    // Make AJAX request to subscribe
    fetch(`/wishlist/${equipmentId}/notify`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            name: name,
            email: email,
            contact: contact || null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: false,
                buttonsStyling: false,
                html: `
                    <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Successfully Subscribed!</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700">You'll be notified at ${email} when ${equipmentName} becomes available.</p>
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
            Swal.fire({
                icon: false,
                buttonsStyling: false,
                html: `
                    <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Subscription Failed</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700">${data.message || 'Failed to subscribe to notifications. Please try again.'}</p>
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
    })
    .catch(error => {
        console.error('Error subscribing to wishlist notification:', error);
        Swal.fire({
            icon: false,
            buttonsStyling: false,
            html: `
                <div class="bg-red-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                    <h2 class="text-xl font-bold text-center">Subscription Failed</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700">An error occurred while subscribing. Please try again.</p>
                </div>
                <div class="flex justify-center mt-6">
                    <button type="button" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors transform hover:scale-105" onclick="Swal.close()">
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
}

// Equipment Details Modal
function showEquipmentDetails(equipmentId) {
    const modal = document.getElementById('equipmentDetailsModal');
    if (!modal) {
        console.error('Equipment details modal not found');
        return;
    }
    
    // Store equipment ID in modal for later use
    modal.dataset.equipmentId = equipmentId;
    
    // Show loading state
    const nameEl = document.getElementById('modalEquipmentName');
    const categoryEl = document.getElementById('modalEquipmentCategory');
    const typeEl = document.getElementById('modalEquipmentType');
    const conditionEl = document.getElementById('modalEquipmentCondition');
    const conditionProgress = document.getElementById('conditionProgress');
    const quantityEl = document.getElementById('modalEquipmentQuantity');
    const descriptionEl = document.getElementById('modalEquipmentDescription');
    const availabilityBadge = document.getElementById('availabilityBadge');
    
    if (nameEl) nameEl.textContent = 'Loading...';
    if (categoryEl) categoryEl.textContent = 'Loading...';
    if (typeEl) typeEl.textContent = 'Loading...';
    if (conditionEl) conditionEl.textContent = 'Loading...';
    if (quantityEl) quantityEl.textContent = 'Loading...';
    if (descriptionEl) descriptionEl.textContent = 'Loading...';
    
    // Show modal with animation
    showEquipmentDetailsModal();
    
    // Fetch equipment details via AJAX
    fetch(`/equipment/${equipmentId}/details?t=${Date.now()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const equipment = data.equipment;
                
                if (nameEl) nameEl.textContent = equipment.name;
                if (categoryEl) categoryEl.textContent = equipment.category.name;
                if (typeEl) typeEl.textContent = equipment.equipment_type ? equipment.equipment_type.name : 'Not specified';
                
                // Set condition with visual indicator
                if (conditionEl && conditionProgress) {
                    conditionEl.textContent = equipment.condition;
                    
                    // Set condition progress bar based on condition
                    let conditionPercentage = 100;
                    let conditionColor = 'bg-green-500';
                    
                    switch(equipment.condition.toLowerCase()) {
                        case 'excellent':
                            conditionPercentage = 100;
                            conditionColor = 'bg-green-500';
                            break;
                        case 'very good':
                            conditionPercentage = 80;
                            conditionColor = 'bg-green-400';
                            break;
                        case 'good':
                            conditionPercentage = 60;
                            conditionColor = 'bg-yellow-500';
                            break;
                        case 'fair':
                            conditionPercentage = 40;
                            conditionColor = 'bg-yellow-400';
                            break;
                        case 'poor':
                            conditionPercentage = 20;
                            conditionColor = 'bg-red-500';
                            break;
                        default:
                            conditionPercentage = 100;
                            conditionColor = 'bg-gray-300';
                    }
                    
                    conditionProgress.className = `h-2 rounded-full ${conditionColor}`;
                    conditionProgress.style.width = `${conditionPercentage}%`;
                }
                
                if (descriptionEl) {
                    descriptionEl.textContent = equipment.description || 'No description available';
                }

                const imagesContainer = document.getElementById('modalEquipmentImages');
                if (imagesContainer) {
                    imagesContainer.innerHTML = '';
                    if (equipment.images && equipment.images.length > 0) {
                        equipment.images.forEach(image => {
                            const imgElement = document.createElement('img');
                            imgElement.src = image.image_path;
                            imgElement.alt = equipment.name;
                            imgElement.className = 'w-full h-24 object-cover rounded-lg shadow-sm';
                            imagesContainer.appendChild(imgElement);
                        });
                    } else {
                        imagesContainer.innerHTML = '<p class="text-sm text-gray-500 col-span-2 text-center py-4">No images available.</p>';
                    }
                }

                // Fetch equipment instances
                return fetch(`/equipment/${equipmentId}/instances?t=${Date.now()}`);
            } else {
                throw new Error(data.message || 'Failed to fetch equipment details');
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Equipment instances data:', data);
            const instancesBody = document.getElementById('modalEquipmentInstancesBody');
            if (instancesBody) {
                instancesBody.innerHTML = '';
                
                if (data.instances && data.instances.length > 0) {
                    const availableCount = data.instances.filter(instance => instance.is_available).length;
                    const totalCount = data.instances.length;
                    
                    if (quantityEl) {
                        quantityEl.textContent = `${availableCount} of ${totalCount}`;
                    }
                    
                    // Set availability badge
                    if (availabilityBadge) {
                        let availabilityText = 'Limited';
                        let availabilityClass = 'bg-yellow-100 text-yellow-800';
                        
                        if (availableCount === totalCount) {
                            availabilityText = 'Available';
                            availabilityClass = 'bg-green-100 text-green-800';
                        } else if (availableCount === 0) {
                            availabilityText = 'Unavailable';
                            availabilityClass = 'bg-red-100 text-red-800';
                        }
                        
                        availabilityBadge.textContent = availabilityText;
                        availabilityBadge.className = `px-2 py-1 rounded-full text-xs font-medium ${availabilityClass}`;
                    }
                    

                    
                    data.instances.forEach(instance => {
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-50 transition-colors duration-150';
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <div class="text-sm font-bold text-gray-900">${instance.instance_code}</div>
                                ${instance.location ? `<div class="text-xs font-medium text-blue-600">${instance.location}</div>` : ''}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${instance.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                    ${instance.is_available ? 'Available' : 'Borrowed'}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ${getConditionStyle(instance.condition)}">${instance.condition}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                ${instance.notes || (instance.is_available ? 'Available for reservation' : 'Currently borrowed')}
                            </td>
                        `;
                        instancesBody.appendChild(row);
                    });
                } else {
                    if (quantityEl) quantityEl.textContent = '0 of 0';
                    
                    if (availabilityBadge) {
                        availabilityBadge.textContent = 'Unavailable';
                        availabilityBadge.className = 'px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                    }
                    

                    
                    instancesBody.innerHTML = '<tr><td colspan="4" class="px-6 py-8 whitespace-nowrap text-sm text-gray-500 text-center">No instances available for this equipment.</td></tr>';
                }
            }
        })
        .catch(error => {
            console.error('Error fetching equipment details:', error);
            showNotification('Error loading equipment details', 'error');
            closeEquipmentDetailsModal();
        });
}

// Helper function to get condition styling
function getConditionStyle(condition) {
    switch(condition.toLowerCase()) {
        case 'excellent':
            return 'bg-green-100 text-green-800';
        case 'very good':
            return 'bg-green-50 text-green-700';
        case 'good':
            return 'bg-yellow-100 text-yellow-800';
        case 'fair':
            return 'bg-orange-100 text-orange-800';
        case 'poor':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

// Function to show modal with animation
function showEquipmentDetailsModal() {
    const modal = document.getElementById('equipmentDetailsModal');
    if (!modal) return;
    
    modal.classList.remove('hidden');
    modal.setAttribute('data-show', 'true');
    
    // Add a slight delay for the animation to trigger properly
    setTimeout(() => {
        modal.classList.add('flex');
    }, 10);
}

// Function to close modal with animation
function closeEquipmentDetailsModal() {
    const modal = document.getElementById('equipmentDetailsModal');
    if (!modal) return;
    
    modal.setAttribute('data-show', 'false');
    
    // Wait for animation to complete before hiding
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}




// Handle pagination clicks for dynamic search
function loadPage(page) {
    performDynamicSearch(page);
}

function returnEquipmentInstance(instanceId) {
    if (!confirm('Are you sure you want to return this equipment instance?')) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        showNotification('Error: CSRF token not found', 'error');
        return;
    }

    fetch(`/equipment/instances/${instanceId}/return`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification('Equipment instance returned successfully!', 'success');
            const equipmentId = document.getElementById('equipmentDetailsModal')?.dataset.equipmentId;
            if (equipmentId) {
                showEquipmentDetails(equipmentId);
            }
        } else {
            showNotification(data.message || 'Error returning equipment instance', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error returning equipment instance: ' + error.message, 'error');
    });
}

// Make functions available globally for onclick handlers
window.addToReservation = addToReservation;
window.addToWishlist = addToWishlist;
window.notifyWhenAvailable = notifyWhenAvailable;
window.showEquipmentDetails = showEquipmentDetails;
window.closeEquipmentDetailsModal = closeEquipmentDetailsModal;
window.closeReservationModal = closeReservationModal;
window.removeFromReservation = removeFromReservation;
window.returnEquipmentInstance = returnEquipmentInstance;
window.showNotification = showNotification;
window.showEquipmentDetailsModal = showEquipmentDetailsModal;
window.getConditionStyle = getConditionStyle;
window.proceedToReservation = proceedToReservation;
window.removeFromModalReservation = removeFromModalReservation;
window.clearReservation = clearReservation;
window.submitReservationForm = submitReservationForm;

// Toggle custom reason field in modal
window.toggleCustomReasonModal = function() {
    const reasonType = document.getElementById('reason_type');
    const customReasonDiv = document.getElementById('custom_reason_div');
    const customReasonField = document.getElementById('custom_reason');
    
    if (reasonType && customReasonDiv && customReasonField) {
        if (reasonType.value === 'Other') {
            customReasonDiv.classList.remove('hidden');
            customReasonField.required = true;
        } else {
            customReasonDiv.classList.add('hidden');
            customReasonField.required = false;
            customReasonField.value = '';
        }
    }
};

// Show a one-time "How Reservation Works" guide on homepage load
try {
    document.addEventListener('DOMContentLoaded', function(){
        if (window.location.pathname === '/') {
            setTimeout(() => {
                if (window.Swal) {
                window.Swal.fire({
                    buttonsStyling: false,
                    width: '100rem',
                    html: `
                        <div class="bg-red-600 text-white p-4 -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;">
                            <h2 class="text-xl font-bold text-center">Welcome to SEMS</h2>
                            <p class="text-center text-white/90 text-sm mt-1">A quick guide to reserving sports equipment</p>
                        </div>
                        <div class="text-left space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">1</div>
                                <div>
                                    <p class="font-medium">Browse & Add</p>
                                    <p class="text-gray-600">Choose equipment and add quantities to your reservation. Availability updates in real time.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">2</div>
                                <div>
                                    <p class="font-medium">Submit Request</p>
                                    <p class="text-gray-600">Open "Complete Your Reservation" to set dates and details. You can reserve up to 7 days ahead.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">3</div>
                                <div>
                                    <p class="font-medium">Verify Email</p>
                                    <p class="text-gray-600">We will send a verification code to your email. You will enter it to continue.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">4</div>
                                <div>
                                    <p class="font-medium">Approval & Pickup</p>
                                    <p class="text-gray-600">You'll receive updates on your email. Pick up and return items on schedule to avoid penalties.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-green-600 text-white rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">5</div>
                                <div>
                                    <p class="font-medium">Keep in Mind</p>
                                    <ul class="text-gray-600 list-disc pl-5 space-y-1">
                                        <li>Use your U‑Baguio email (s./e. domains) for requests and notifications.</li>
                                        <li>Reservation and return times: 8:00 AM – 5:00 PM. Same‑day returns must be 30+ minutes after pickup.</li>
                                        <li>If an item is unavailable, tap the star icon to add it to your wishlist.</li>
                                        <li>Use the bell icon to receive an email when an unavailable item becomes available.</li>
                                        <li>During pickup, the PE Office may require a valid ID as collateral per borrowing policy.</li>
                                        <li>After pickup, you are responsible for the equipment until it is returned.</li>
                                        <li>Lost or damaged equipment may require replacement in line with policy.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button id="dismissGuideBtn" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">Got it</button>
                        </div>
                    `,
                    showConfirmButton: false,
                    customClass: { popup: 'swal-custom-popup swal-welcome-guide swal-welcome-guide-width' },
                    didOpen: () => {
                        try {
                            const popup = Swal.getPopup();
                            if (popup) popup.scrollTop = 0;
                        } catch(_){}
                    }
                });
                document.addEventListener('click', function guideDismissHandler(e){
                    if (e.target && e.target.id === 'dismissGuideBtn') {
                        if (window.Swal) window.Swal.close();
                        document.removeEventListener('click', guideDismissHandler);
                    }
                });
            }
        }, 300);
        }
    });
} catch (e) { console.warn('Guide modal setup failed:', e); }
