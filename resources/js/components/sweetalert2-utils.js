/**
 * SweetAlert2 Utility Functions with Custom Styling
 * Provides easy-to-use functions for common modal types
 */

class SweetAlertUtils {
    /**
     * Success Modal
     */
    static success(title, text = '', options = {}) {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'success',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-success-title',
                confirmButton: 'swal-custom-confirm'
            },
            confirmButtonText: options.confirmButtonText || 'OK',
            ...options
        });
    }

    /**
     * Error Modal
     */
    static error(title, text = '', options = {}) {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'error',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-error-title',
                confirmButton: 'swal-custom-danger'
            },
            confirmButtonText: options.confirmButtonText || 'OK',
            ...options
        });
    }

    /**
     * Warning Modal
     */
    static warning(title, text = '', options = {}) {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-warning-title',
                confirmButton: 'swal-custom-warning'
            },
            confirmButtonText: options.confirmButtonText || 'OK',
            ...options
        });
    }

    /**
     * Info Modal
     */
    static info(title, text = '', options = {}) {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'info',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-info-title',
                confirmButton: 'swal-custom-info'
            },
            confirmButtonText: options.confirmButtonText || 'OK',
            ...options
        });
    }

    /**
     * Question/Confirmation Modal
     */
    static question(title, text = '', options = {}) {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-question-title',
                confirmButton: 'swal-custom-confirm',
                cancelButton: 'swal-custom-cancel'
            },
            showCancelButton: true,
            confirmButtonText: options.confirmButtonText || 'Yes',
            cancelButtonText: options.cancelButtonText || 'Cancel',
            reverseButtons: true,
            ...options
        });
    }

    /**
     * Delete Confirmation Modal
     */
    static deleteConfirmation(title, text = '', options = {}) {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-warning-title',
                confirmButton: 'swal-custom-danger',
                cancelButton: 'swal-custom-cancel'
            },
            showCancelButton: true,
            confirmButtonText: options.confirmButtonText || 'Yes, Delete!',
            cancelButtonText: options.cancelButtonText || 'Cancel',
            reverseButtons: true,
            ...options
        });
    }

    /**
     * Loading Modal
     */
    static loading(title = 'Loading...', options = {}) {
        return Swal.fire({
            title: title,
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-info-title'
            },
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
            ...options
        });
    }

    /**
     * Input Modal
     */
    static input(title, text = '', inputType = 'text', options = {}) {
        return Swal.fire({
            title: title,
            text: text,
            input: inputType,
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal2-question-title',
                confirmButton: 'swal-custom-confirm',
                cancelButton: 'swal-custom-cancel'
            },
            showCancelButton: true,
            confirmButtonText: options.confirmButtonText || 'OK',
            cancelButtonText: options.cancelButtonText || 'Cancel',
            reverseButtons: true,
            inputValidator: options.inputValidator,
            ...options
        });
    }

    /**
     * Custom Modal with HTML
     */
    static custom(title, html, options = {}) {
        return Swal.fire({
            title: title,
            html: html,
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-custom-title',
                confirmButton: 'swal-custom-confirm',
                cancelButton: 'swal-custom-cancel'
            },
            showCancelButton: options.showCancelButton !== false,
            confirmButtonText: options.confirmButtonText || 'OK',
            cancelButtonText: options.cancelButtonText || 'Cancel',
            reverseButtons: true,
            ...options
        });
    }

    /**
     * Toast Notification
     */
    static toast(title, icon = 'success', options = {}) {
        return Swal.fire({
            title: title,
            icon: icon,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: options.timer || 3000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal2-toast',
                title: icon === 'success' ? 'swal2-success-title' : 
                       icon === 'error' ? 'swal2-error-title' :
                       icon === 'warning' ? 'swal2-warning-title' : 'swal2-info-title'
            },
            ...options
        });
    }

    /**
     * Success Toast
     */
    static successToast(title, options = {}) {
        return this.toast(title, 'success', options);
    }

    /**
     * Error Toast
     */
    static errorToast(title, options = {}) {
        return this.toast(title, 'error', options);
    }

    /**
     * Warning Toast
     */
    static warningToast(title, options = {}) {
        return this.toast(title, 'warning', options);
    }

    /**
     * Info Toast
     */
    static infoToast(title, options = {}) {
        return this.toast(title, 'info', options);
    }

    /**
     * Close any open modal
     */
    static close() {
        Swal.close();
    }

    /**
     * Check if modal is open
     */
    static isOpen() {
        return Swal.isVisible();
    }
}

// Make it globally available
window.SweetAlertUtils = SweetAlertUtils;

// Export for module usage
export default SweetAlertUtils;
