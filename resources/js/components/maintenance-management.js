/**
 * Maintenance Management Specific Functions
 * Functions specific to maintenance management views
 */

/**
 * Open routine maintenance modal
 */
function openRoutineMaintenanceModal() {
    Swal.fire({
        title: '',
        html: `
            <div class="text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="background:#1d4ed8; margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                <h2 class="text-xl font-bold text-center">Set Routine Maintenance</h2>
            </div>
            <div class="space-y-4 text-left">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-1 bg-blue-100 rounded">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-blue-800 mb-2">Routine Maintenance Mode Guide</h3>
                            <p class="text-blue-700 text-sm">This feature allows administrators and managers to set all available equipment to maintenance mode. Equipment currently marked as "picked up" will be excluded from this process. Use this when you need to perform system-wide maintenance or updates.</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <h4 class="font-semibold text-slate-800 text-left">What will happen:</h4>
                    <ul class="space-y-2 text-sm text-slate-600 text-left">
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>All available equipment will be set to under maintenance</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Equipment currently marked as "picked up" will be excluded</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Equipment status will be set to "under_maintenance" temporarily</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Equipment will be labeled as "under maintenance" in the reservation page</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Users can still wishlist equipment during maintenance</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Maintenance records will be created for each instance</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Equipment will be available again after maintenance completion</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-1 bg-amber-100 rounded">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-amber-800 mb-1">Confirmation Required</h4>
                            <p class="text-amber-700 text-sm">Enter your current password to proceed with setting routine maintenance.</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Enter your current password:</label>
                    <input type="password" id="confirmInput" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-sm font-medium transition-all"
                           placeholder="Enter your current password...">
                </div>
                
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                        Cancel
                    </button>
                    <button type="button" class="px-6 py-2 text-white rounded-lg transition-transform" style="background:#1d4ed8; border:none;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" onclick="scheduleRoutineMaintenance()">
                        Set Routine Maintenance
                    </button>
                </div>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        width: '600px',
        customClass: {
            popup: 'swal-custom-popup'
        },
        didOpen: () => {
            const input = document.getElementById('confirmInput');
            if (input) {
                input.focus();
            }
        }
    });
}

/**
 * Schedule routine maintenance
 */
function scheduleRoutineMaintenance() {
    const input = document.getElementById('confirmInput');
    if (!input.value) {
        Swal.showValidationMessage('Password is required');
        return;
    }
    
    // Show loading state
    Swal.fire({
        title: 'Verifying Password...',
        text: 'Please wait while we verify your password.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Make AJAX call to enforce maintenance
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');
    formData.append('password', input.value);
    
    fetch(window.routes?.maintenanceManagement?.routineMaintenance || '/maintenance-management/routine-maintenance', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Success!</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700 text-lg font-medium">Routine maintenance has been successfully set for all available equipment.</p>
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.reload();">
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
            // Show error message based on password validation
            if (data.message && data.message.includes('password')) {
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Failed Routine Maintenance</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg font-medium">Failed Routine Maintenance because of wrong password. Please check your password and try again.</p>
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
            } else {
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
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
                            <p class="text-gray-700 text-lg font-medium">${data.message || 'Failed to set routine maintenance. Please try again.'}</p>
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
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            title: '',
            html: `
                <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                    <h2 class="text-xl font-bold text-center">Maintenance Scheduling Failed</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700 text-lg font-medium">Failed to schedule routine maintenance. Please try again.</p>
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

/**
 * Complete maintenance for equipment
 */
function completeMaintenance(equipmentId, equipmentName) {
    Swal.fire({
        title: '',
        html: `
            <div class="text-white p-4 -m-6 mb-4 rounded-t-lg" style="background:#f59e0b;">
                <h2 class="text-xl font-bold">Complete Maintenance</h2>
            </div>
            <div class="space-y-4 text-left">
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-1 bg-amber-100 rounded">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-800 mb-2">Confirm completion for <span class="font-bold">${equipmentName}</span></h3>
                            <p class="text-slate-700 text-sm">This will finish maintenance and make all affected instances available again.</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="font-semibold text-slate-800">What will happen:</h4>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><div class="w-2 h-2 bg-amber-500 rounded-full"></div>Set all "under maintenance" instances to "good" condition</li>
                        <li class="flex items-center gap-2"><div class="w-2 h-2 bg-amber-500 rounded-full"></div>Make all instances available for new reservations</li>
                        <li class="flex items-center gap-2"><div class="w-2 h-2 bg-amber-500 rounded-full"></div>Create a maintenance completion record</li>
                        <li class="flex items-center gap-2"><div class="w-2 h-2 bg-amber-500 rounded-full"></div>Update equipment availability counts</li>
                        <li class="flex items-center gap-2"><div class="w-2 h-2 bg-amber-500 rounded-full"></div>Remove the "under maintenance" status from the equipment</li>
                    </ul>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">Cancel</button>
                    <button type="button" class="px-6 py-2 text-white rounded-lg transition-transform" style="background:#f59e0b; border:none;" data-eq="${encodeURIComponent(equipmentName)}" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'" onclick="completeMaintenanceConfirm(${equipmentId}, decodeURIComponent(this.getAttribute('data-eq')))">Complete Maintenance</button>
                </div>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        width: '560px',
        customClass: { popup: 'swal-custom-popup' }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Completing Maintenance...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Make AJAX call to complete maintenance
            fetch(window.routes?.maintenanceManagement?.completeMaintenance || '/maintenance-management/complete-maintenance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    equipment_id: equipmentId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message and refresh page
                    if (window.ActionHandler && window.ActionHandler.showSuccessNotification) {
                        window.ActionHandler.showSuccessNotification(
                            'Maintenance Completed',
                            `Maintenance for ${equipmentName} has been completed successfully.`,
                            () => { window.location.reload(); },
                            { color: '#f59e0b' }
                        );
                    } else {
                        Swal.fire({ icon: 'success', title: 'Maintenance Completed', confirmButtonColor: '#f59e0b' })
                            .then(() => window.location.reload());
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Completion Failed',
                        text: data.message || 'Failed to complete maintenance',
                        confirmButtonColor: '#dc2626'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Completion Failed',
                    text: 'Failed to complete maintenance. Please try again.',
                    confirmButtonColor: '#dc2626'
                });
            });
        }
    });
}

// Internal confirm handler used by the amber-styled modal
function completeMaintenanceConfirm(equipmentId, equipmentName) {
    // Mimic the confirmed branch of completeMaintenance
    Swal.fire({
        title: 'Completing Maintenance...',
        text: 'Please wait while we process your request.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    fetch(window.routes?.maintenanceManagement?.completeMaintenance || '/maintenance-management/complete-maintenance', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({ equipment_id: equipmentId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (window.ActionHandler && window.ActionHandler.showSuccessNotification) {
                window.ActionHandler.showSuccessNotification(
                    'Maintenance Completed',
                    `Maintenance for ${equipmentName} has been completed successfully.`,
                    () => { window.location.reload(); },
                    { color: '#f59e0b' }
                );
            } else {
                Swal.fire({ icon: 'success', title: 'Maintenance Completed', confirmButtonColor: '#f59e0b' })
                    .then(() => window.location.reload());
            }
        } else {
            Swal.fire({ icon: 'error', title: 'Completion Failed', text: data.message || 'Failed to complete maintenance', confirmButtonColor: '#dc2626' });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Completion Failed', text: 'Failed to complete maintenance. Please try again.', confirmButtonColor: '#dc2626' });
    });
}

// Expose confirm handler globally for inline onclick usage
if (typeof window !== 'undefined') {
    window.completeMaintenanceConfirm = completeMaintenanceConfirm;
}

/**
 * Open discard modal for damaged equipment
 */
function openDiscardModal(equipmentId, equipmentName, instanceCount) {
    Swal.fire({
        title: '',
        html: `
            <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                <h2 class="text-xl font-bold text-center">Retire Damaged/Needs Repair Equipment</h2>
            </div>
            <form id="discardForm" method="POST" action="${window.routes?.maintenanceManagement?.discardDamaged || '/maintenance-management/discard-damaged'}" class="space-y-4">
                <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]')?.content || ''}">
                <input type="hidden" name="equipment_id" value="${equipmentId}">
                
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-1 bg-red-100 rounded">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-red-800 mb-2">Permanent Action Warning</h3>
                            <p class="text-red-700 text-sm">This action will permanently discard instances with damaged and needs_repair status for <strong>${equipmentName}</strong>. This cannot be undone.</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <h4 class="font-semibold text-slate-800 text-left">What will happen:</h4>
                    <ul class="space-y-2 text-sm text-slate-600 text-left">
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>All damaged and needs_repair instances will be set to retired status</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Equipment total quantity will be reduced by the number of retired instances</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Retired instance codes will no longer be available for new reservations</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <div class="w-2 h-2 bg-red-500 rounded-full mt-2 flex-shrink-0"></div>
                            <span>Retired items will be moved to retirement records for tracking</span>
                        </li>
                    </ul>
                </div>
                
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <div class="p-1 bg-amber-100 rounded">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-amber-800 mb-1">Confirmation Required</h4>
                            <p class="text-amber-700 text-sm">Enter your password to proceed with retiring the damaged/repair equipment.</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Enter your password:</label>
                    <input type="password" id="discardConfirmInput" 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                           placeholder="Enter your password...">
                </div>
                
                <div class="flex justify-between mt-6">
                    <button type="button" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors" onclick="Swal.close()">
                        Cancel
                    </button>
                    <button type="button" class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-lg hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105" onclick="discardDamagedEquipment('${equipmentId}')">
                        Discard Equipment
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
        buttonsStyling: false,
        didOpen: () => {
            const input = document.getElementById('discardConfirmInput');
            if (input) {
                input.focus();
            }
        }
    });
}

/**
 * Discard damaged equipment
 */
function discardDamagedEquipment(equipmentId) {
    const input = document.getElementById('discardConfirmInput');
    if (!input.value) {
        Swal.showValidationMessage('Password is required');
        return;
    }
    
    const form = document.getElementById('discardForm');
    if (!form) {
        Swal.fire({ icon: 'error', title: 'Form not found', confirmButtonColor: '#dc2626' });
        return;
    }
    
    // Show loading
    Swal.fire({
        title: 'Verifying Password...',
        text: 'Please wait while we verify your password.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    const formData = new FormData(form);
    formData.append('password', input.value);
    const actionUrl = form.getAttribute('action');
    
    fetch(actionUrl, {
        method: 'POST',
        body: formData,
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success === false) {
            // Show error message based on password validation
            if (data.message && data.message.includes('password')) {
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Failed Equipment Retirement</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg font-medium">Failed Equipment Retirement because of wrong password. Please check your password and try again.</p>
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
            } else {
                Swal.fire({
                    title: '',
                    html: `
                        <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">Retirement Failed</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700 text-lg font-medium">${data.message || 'Failed to retire equipment.'}</p>
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
            return;
        }
        
        // Handle success case
        if (data.success === true) {
            // Show success message
            Swal.fire({
                title: '',
                html: `
                    <div class="bg-green-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                        <h2 class="text-xl font-bold text-center">Success!</h2>
                    </div>
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-gray-700 text-lg font-medium">${data.message || 'Equipment has been successfully retired.'}</p>
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" onclick="Swal.close(); window.location.reload();">
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
        
        // Fallback for unexpected responses
        Swal.fire({
            title: 'Unexpected Response',
            text: 'The server returned an unexpected response. Please try again.',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc2626'
        });
    })
    .catch((error) => {
        console.error('Retirement error:', error);
        Swal.fire({
            title: '',
            html: `
                <div class="bg-red-500 text-white p-4 -m-6 -mt-6 mb-4 rounded-t-lg" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                    <h2 class="text-xl font-bold text-center">Retirement Failed</h2>
                </div>
                <div class="text-center">
                    <div class="mb-4">
                        <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-700 text-lg font-medium">An unexpected error occurred.</p>
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

// Export functions for global use
window.MaintenanceManagement = {
    openRoutineMaintenanceModal,
    scheduleRoutineMaintenance,
    completeMaintenance,
    openDiscardModal,
    discardDamagedEquipment
};

// Also expose functions directly on window for backward compatibility
window.openRoutineMaintenanceModal = openRoutineMaintenanceModal;
window.scheduleRoutineMaintenance = scheduleRoutineMaintenance;
window.completeMaintenance = completeMaintenance;
window.openDiscardModal = openDiscardModal;
window.discardDamagedEquipment = discardDamagedEquipment;
