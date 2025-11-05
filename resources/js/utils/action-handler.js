/**
 * Action Handler Utility
 * Provides consistent loading states and notifications for action buttons throughout the system
 */

// Global action state tracking
const actionStates = new Map();

/**
 * Show loading state for an action button
 * @param {string} buttonId - The ID of the button
 * @param {string} loadingText - Text to show while loading
 * @param {string} originalText - Original button text to restore later
 */
function showButtonLoading(buttonId, loadingText = 'Processing...', originalText = null) {
    const button = document.getElementById(buttonId);
    if (!button) return;

    // Store original state if not already stored
    if (!actionStates.has(buttonId)) {
        actionStates.set(buttonId, {
            originalText: originalText || button.innerHTML,
            originalDisabled: button.disabled,
            originalClasses: button.className
        });
    }

    // Show loading state
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        ${loadingText}
    `;
    
    // Add loading classes
    button.classList.add('opacity-75', 'cursor-not-allowed');
}

/**
 * Show loading state for small action buttons (icons only)
 * @param {string} buttonId - The ID of the button
 * @param {string} originalText - Original button text to restore later
 */
function showSmallButtonLoading(buttonId, originalText = null) {
    const button = document.getElementById(buttonId);
    if (!button) return;

    // Store original state if not already stored
    if (!actionStates.has(buttonId)) {
        actionStates.set(buttonId, {
            originalText: originalText || button.innerHTML,
            originalDisabled: button.disabled,
            originalClasses: button.className
        });
    }

    // Show loading state with spinner only (no text)
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    
    // Add loading classes
    button.classList.add('opacity-75', 'cursor-not-allowed');
}

/**
 * Restore button to original state
 * @param {string} buttonId - The ID of the button
 */
function restoreButtonState(buttonId) {
    const button = document.getElementById(buttonId);
    if (!button || !actionStates.has(buttonId)) return;

    const state = actionStates.get(buttonId);
    
    button.disabled = state.originalDisabled;
    button.innerHTML = state.originalText;
    button.className = state.originalClasses;
    
    actionStates.delete(buttonId);
}

/**
 * Show success notification (themeable)
 * @param {string} title - Notification title
 * @param {string} message - Notification message
 * @param {Function|null} callback - Optional callback after user clicks OK
 * @param {{color?: string}} options - Optional styling options (e.g., { color: '#f59e0b' })
 */
function showSuccessNotification(title, message, callback = null, options = {}) {
    const color = options && options.color ? options.color : '#22c55e'; // default green-500
    const lightBg = 'rgba(34,197,94,0.12)';
    const iconColor = color;
    const headerHtml = `
        <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:${color};">
            <h2 class="text-xl font-bold text-center">${title}</h2>
        </div>`;
    const bodyHtml = `
        <div class="text-center">
            <div class="mb-4">
                <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-3" style="background:${lightBg}">
                    <svg class="w-8 h-8" style="color:${iconColor}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
            <p class="text-gray-700">${message}</p>
        </div>`;
    const footerHtml = `
        <div class="flex justify-center mt-6">
            <button type="button" class="px-6 py-2 text-white rounded-lg transition-transform" style="background:${color}" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" onclick="Swal.close()">OK</button>
        </div>`;

    Swal.fire({
        icon: false,
        buttonsStyling: false,
        html: headerHtml + bodyHtml + footerHtml,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'swal-custom-popup'
        }
    }).then((result) => {
        if (callback && typeof callback === 'function') {
            callback(result);
        }
    });
}

/**
 * Show error notification (custom red-themed modal)
 * @param {string} title - Notification title
 * @param {string} message - Notification message
 * @param {Function} callback - Optional callback after user clicks OK
 */
function showErrorNotification(title, message, callback = null) {
    const color = '#ef4444'; // red-500
    const lightBg = 'rgba(239,68,68,0.12)';
    const iconColor = color;
    const headerHtml = `
        <div class="text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left:-24px;margin-right:-24px;margin-top:-24px;background:${color};">
            <h2 class="text-xl font-bold text-center">${title}</h2>
        </div>`;
    const bodyHtml = `
        <div class="text-center">
            <div class="mb-4">
                <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-3" style="background:${lightBg}">
                    <svg class="w-8 h-8" style="color:${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-gray-700">${message}</p>
        </div>`;
    const footerHtml = `
        <div class="flex justify-center mt-6">
            <button type="button" class="px-6 py-2 text-white rounded-lg transition-transform" style="background:${color}" onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" onclick="Swal.close()">OK</button>
        </div>`;

    Swal.fire({
        icon: false,
        buttonsStyling: false,
        html: headerHtml + bodyHtml + footerHtml,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'swal-custom-popup'
        }
    }).then((result) => {
        if (callback && typeof callback === 'function') {
            callback(result);
        }
    });
}

/**
 * Show warning notification
 * @param {string} title - Notification title
 * @param {string} message - Notification message
 * @param {Function} callback - Optional callback after user clicks OK
 */
function showWarningNotification(title, message, callback = null) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        confirmButtonColor: '#f59e0b',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'swal-custom-popup'
        }
    }).then((result) => {
        if (callback && typeof callback === 'function') {
            callback(result);
        }
    });
}

/**
 * Show info notification
 * @param {string} title - Notification title
 * @param {string} message - Notification message
 * @param {Function} callback - Optional callback after user clicks OK
 */
function showInfoNotification(title, message, callback = null) {
    Swal.fire({
        title: title,
        text: message,
        icon: 'info',
        confirmButtonColor: '#3b82f6',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'swal-custom-popup'
        }
    }).then((result) => {
        if (callback && typeof callback === 'function') {
            callback(result);
        }
    });
}

/**
 * Show full-screen loading modal
 * @param {string} loadingText - Text to show while loading
 */
function showLoadingModal(loadingText = 'Processing...') {
    Swal.fire({
        title: loadingText,
        html: `
            <div class="flex flex-col items-center justify-center py-8">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mb-4"></div>
                <p class="text-gray-600 text-lg">Please wait...</p>
            </div>
        `,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        showCancelButton: false,
        showCloseButton: false,
        width: '400px',
        customClass: {
            popup: 'swal-loading-popup'
        },
        didOpen: () => {
            // Add custom styles for the loading modal
            const popup = document.querySelector('.swal-loading-popup');
            if (popup) {
                popup.style.background = 'rgba(255, 255, 255, 0.95)';
                popup.style.backdropFilter = 'blur(5px)';
            }
        }
    });
}

/**
 * Close loading modal
 */
function closeLoadingModal() {
    Swal.close();
}

/**
 * Handle form submission with loading state and notifications
 * @param {string} buttonId - The ID of the button to show loading state
 * @param {HTMLFormElement} form - The form to submit
 * @param {Object} options - Configuration options
 */
function handleFormSubmission(buttonId, form, options = {}) {
    const {
        loadingText = 'Processing...',
        successTitle = 'Success!',
        successMessage = 'Action completed successfully.',
        errorTitle = 'Error',
        errorMessage = 'An error occurred. Please try again.',
        onSuccess = null,
        onError = null,
        onComplete = null
    } = options;

    // Submit form
    fetch(form.action, {
        method: form.method,
        body: new FormData(form),
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccessNotification(successTitle, successMessage, () => {
                if (onSuccess && typeof onSuccess === 'function') {
                    onSuccess(data);
                }
            });
        } else {
            showErrorNotification(errorTitle, data.message || errorMessage, () => {
                if (onError && typeof onError === 'function') {
                    onError(data);
                }
            });
        }
    })
    .catch(error => {
        console.error('Form submission error:', error);
        showErrorNotification(errorTitle, errorMessage, () => {
            if (onError && typeof onError === 'function') {
                onError(error);
            }
        });
    })

}

/**
 * Handle AJAX action with loading state and notifications
 * @param {string} buttonId - The ID of the button to show loading state
 * @param {string} url - The URL to make the request to
 * @param {Object} options - Configuration options
 */
function handleAjaxAction(buttonId, url, options = {}) {
    const {
        method = 'POST',
        data = {},
        loadingText = 'Processing...',
        successTitle = 'Success!',
        successMessage = 'Action completed successfully.',
        errorTitle = 'Error',
        errorMessage = 'An error occurred. Please try again.',
        onSuccess = null,
        onError = null,
        onComplete = null
    } = options;

    // Show full-screen loading modal
    showLoadingModal(loadingText);

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // Prepare headers for form submission (not JSON)
    const headers = {
        'X-Requested-With': 'XMLHttpRequest'
    };

    if (csrfToken) {
        headers['X-CSRF-TOKEN'] = csrfToken;
    }

    // Convert data to FormData for proper form submission
    const formData = new FormData();
    Object.keys(data).forEach(key => {
        formData.append(key, data[key]);
    });

    // Make request
    fetch(url, {
        method: method,
        headers: headers,
        body: formData
    })
    .then(response => {
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json();
        } else {
            // Handle non-JSON responses (like redirects or HTML)
            throw new Error('Expected JSON response but received: ' + contentType);
        }
    })
    .then(data => {
        // Close loading modal
        closeLoadingModal();
        
        if (data.success) {
            showSuccessNotification(successTitle, successMessage, () => {
                // Auto-refresh page after successful delete operations immediately
                console.log('Success message:', data.message);
                if (data.message && (data.message.includes('deleted successfully') || data.message.includes('deleted') || data.message.includes('User deleted'))) {
                    console.log('Auto-refreshing page after delete operation');
                    window.location.reload();
                }
                
                if (onSuccess && typeof onSuccess === 'function') {
                    onSuccess(data);
                }
            });
        } else {
            showErrorNotification(errorTitle, data.message || errorMessage, () => {
                if (onError && typeof onError === 'function') {
                    onError(data);
                }
            });
        }
    })
    .catch(error => {
        console.error('AJAX action error:', error);
        
        // Close loading modal
        closeLoadingModal();
        
        // Show a more specific error message for non-JSON responses
        let displayError = errorMessage;
        if (error.message && error.message.includes('Expected JSON response')) {
            displayError = 'Server returned an unexpected response format. Please try again.';
        }
        
        showErrorNotification(errorTitle, displayError, () => {
            if (onError && typeof onError === 'function') {
                onError(error);
            }
        });
    });
}

/**
 * Create a loading button with consistent styling
 * @param {string} buttonId - The ID for the button
 * @param {string} text - Button text
 * @param {string} type - Button type (primary, secondary, danger, success, warning)
 * @param {Function} onClick - Click handler function
 * @param {Object} additionalClasses - Additional CSS classes
 * @returns {string} HTML string for the button
 */
function createLoadingButton(buttonId, text, type = 'primary', onClick = '', additionalClasses = '') {
    const baseClasses = 'inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    const typeClasses = {
        primary: 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        secondary: 'text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-gray-500',
        danger: 'text-white bg-red-600 hover:bg-red-700 focus:ring-red-500',
        success: 'text-white bg-green-600 hover:bg-green-700 focus:ring-green-500',
        warning: 'text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500'
    };

    const classes = `${baseClasses} ${typeClasses[type]} ${additionalClasses}`;
    const onclickAttr = onClick ? `onclick="${onClick}"` : '';

    return `<button id="${buttonId}" type="button" class="${classes}" ${onclickAttr}>${text}</button>`;
}

// Export functions for global use
window.ActionHandler = {
    showButtonLoading,
    showSmallButtonLoading,
    restoreButtonState,
    showSuccessNotification,
    showErrorNotification,
    showWarningNotification,
    showInfoNotification,
    showLoadingModal,
    closeLoadingModal,
    handleFormSubmission,
    handleAjaxAction,
    createLoadingButton
};
