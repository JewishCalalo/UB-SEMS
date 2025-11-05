# SweetAlert2 Upgrade Documentation

## Overview
All SweetAlert2 modals in the SEMS application have been upgraded with a beautiful, consistent design system. This includes colored headers, modern styling, and improved user experience.

## What's New

### 1. Global CSS Styling
- **File**: `resources/css/sweetalert2-custom.css`
- **Features**:
  - Colored headers with gradients for different modal types
  - Modern button styling with hover effects
  - Consistent spacing and typography
  - Enhanced input field styling
  - Professional shadows and borders

### 2. JavaScript Utility Functions
- **File**: `resources/js/components/sweetalert2-utils.js`
- **Features**:
  - Easy-to-use functions for common modal types
  - Consistent styling across all modals
  - Reduced code duplication
  - Better maintainability

## Usage Examples

### Basic Modals

```javascript
// Success Modal
SweetAlertUtils.success('Success!', 'Operation completed successfully.');

// Error Modal
SweetAlertUtils.error('Error!', 'Something went wrong.');

// Warning Modal
SweetAlertUtils.warning('Warning!', 'Please check your input.');

// Info Modal
SweetAlertUtils.info('Information', 'Here is some important information.');

// Question/Confirmation Modal
SweetAlertUtils.question('Confirm Action', 'Are you sure you want to proceed?');
```

### Specialized Modals

```javascript
// Delete Confirmation
SweetAlertUtils.deleteConfirmation('Delete Item', 'This action cannot be undone.');

// Loading Modal
SweetAlertUtils.loading('Processing...', {
    text: 'Please wait while we process your request.'
});

// Input Modal
SweetAlertUtils.input('Enter Name', 'Please enter your name:', 'text');

// Custom Modal with HTML
SweetAlertUtils.custom('Custom Title', `
    <div class="custom-content">
        <p>Your custom HTML content here</p>
    </div>
`, {
    showCancelButton: true,
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancel'
});
```

### Toast Notifications

```javascript
// Success Toast
SweetAlertUtils.successToast('Item added successfully!');

// Error Toast
SweetAlertUtils.errorToast('Failed to save changes');

// Warning Toast
SweetAlertUtils.warningToast('Please check your input');

// Info Toast
SweetAlertUtils.infoToast('New notification received');
```

## Modal Types and Colors

### Success Modals
- **Header**: Green gradient (`#10b981` to `#059669`)
- **Icon**: Checkmark (✓)
- **Button**: Green gradient with hover effects

### Error Modals
- **Header**: Red gradient (`#ef4444` to `#dc2626`)
- **Icon**: X mark (✕)
- **Button**: Red gradient with hover effects

### Warning Modals
- **Header**: Amber gradient (`#f59e0b` to `#d97706`)
- **Icon**: Warning triangle (⚠)
- **Button**: Amber gradient with hover effects

### Info Modals
- **Header**: Cyan gradient (`#06b6d4` to `#0891b2`)
- **Icon**: Information (ℹ)
- **Button**: Blue gradient with hover effects

### Question Modals
- **Header**: Blue gradient (`#3b82f6` to `#2563eb`)
- **Icon**: Question mark (?)
- **Button**: Blue gradient with hover effects

## Updated Files

### Core Files
- `resources/css/sweetalert2-custom.css` - Global styling
- `resources/js/components/sweetalert2-utils.js` - Utility functions
- `resources/views/layouts/app.blade.php` - CSS inclusion
- `vite.config.js` - Build configuration

### Updated View Files
- `resources/views/reservation-management/index.blade.php` - Approve reservation modal
- `resources/views/admin/equipment-management/index.blade.php` - Equipment modals
- `resources/views/admin/user-management/index.blade.php` - User management modals
- `resources/js/components/welcome.js` - Reservation and cart modals

## Migration Guide

### Before (Old Way)
```javascript
Swal.fire({
    title: 'Success!',
    text: 'Operation completed.',
    icon: 'success',
    confirmButtonText: 'OK'
});
```

### After (New Way)
```javascript
SweetAlertUtils.success('Success!', 'Operation completed.');
```

### Custom Modals
```javascript
// Before
Swal.fire({
    title: 'Custom Modal',
    html: '<div>Content</div>',
    customClass: {
        popup: 'swal-custom-popup',
        title: 'swal-custom-title'
    },
    showCancelButton: true,
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancel'
});

// After
SweetAlertUtils.custom('Custom Modal', '<div>Content</div>', {
    showCancelButton: true,
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancel'
});
```

## Benefits

1. **Consistency**: All modals now have the same professional appearance
2. **Maintainability**: Centralized styling and utility functions
3. **Developer Experience**: Easier to create and modify modals
4. **User Experience**: More visually appealing and modern interface
5. **Performance**: Reduced code duplication and better organization

## Future Updates

To add new modal types or modify existing ones:

1. **Add new utility functions** in `sweetalert2-utils.js`
2. **Add new CSS classes** in `sweetalert2-custom.css`
3. **Update existing modals** to use the new utilities
4. **Test thoroughly** across different browsers and devices

## Browser Support

The new styling uses modern CSS features that are supported in:
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Notes

- All existing functionality is preserved
- No breaking changes to existing modal behavior
- Enhanced visual appeal and user experience
- Better accessibility with improved contrast and focus states
