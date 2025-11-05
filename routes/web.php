<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\EquipmentManagementController;
use App\Http\Controllers\MaintenanceManagementController;
use App\Http\Controllers\ProfileUserManagementController;
use App\Http\Controllers\ReservationManagementController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\EquipmentReturnController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\Auth\AuthCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentTypeController;
use App\Http\Controllers\BlacklistController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/welcome/search', [WelcomeController::class, 'search'])->name('welcome.search');

// API route for authentication check
Route::get('/api/check-auth', [AuthCheckController::class, 'check'])->name('api.check-auth');

// Guest-accessible equipment routes (no login required)
Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
Route::get('/equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');
Route::get('/equipment/{equipment}/details', [EquipmentController::class, 'getDetails'])->name('equipment.details');
Route::get('/equipment/{equipment}/instances', [EquipmentController::class, 'getInstances'])->name('equipment.instances');

// Guest reservation submission (no login required)
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::post('/reservations/check-duplicate', [ReservationController::class, 'checkDuplicate'])->name('reservations.check-duplicate');
Route::post('/reservations/initiate', [ReservationController::class, 'initiate'])->name('reservations.initiate');
Route::get('/reservations/verify-guest', [ReservationController::class, 'verifyGuestForm'])->name('reservations.verify-guest');
Route::post('/reservations/verify-guest', [ReservationController::class, 'verifyGuestSubmit'])->name('reservations.verify-guest.submit');
Route::post('/reservations/verify-guest/resend', [ReservationController::class, 'resendGuestCode'])->name('reservations.verify-guest.resend');
Route::get('/reservations/complete', [ReservationController::class, 'completePending'])->name('reservations.complete');

// Guest reservation tracking (no login required)
Route::get('/reservations/track', [ReservationController::class, 'track'])->name('reservations.track');
Route::post('/reservations/{reservation}/items', [ReservationController::class, 'addItem'])->name('reservations.items.add');
Route::post('/reservations/{reservation}/items/{item}', [ReservationController::class, 'removeItem'])->name('reservations.items.remove');
Route::post('/reservations/{reservation}/items/{item}/quantity', [ReservationController::class, 'updateItemQuantity'])->name('reservations.items.quantity');
Route::post('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
Route::get('/reservations/{reservationId}/guest-confirmation', [ReservationController::class, 'guestConfirmation'])->name('reservations.guest-confirmation');
Route::get('/reservations/{reservation}/verify', [ReservationController::class, 'verifyForm'])->name('reservations.verify');
Route::post('/reservations/{reservation}/verify', [ReservationController::class, 'verifySubmit'])->name('reservations.verify.submit');
Route::get('/reservations/{reservation}/confirmation', [ReservationController::class, 'confirmation'])->name('reservations.confirmation');

// User reservation routes (require login)
Route::middleware(['auth', 'verified', 'onboarding.complete', 'cache.control'])->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
});

// Wishlist routes (no login required) - tracks popularity, not user-specific
Route::post('/wishlist/add/{equipment}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/{equipment}/notify', [WishlistController::class, 'notify'])->name('wishlist.notify');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'cache.control'])
    ->name('dashboard');

// Instructor routes
Route::middleware(['auth', 'verified', 'onboarding.complete', 'cache.control'])->group(function () {
    Route::middleware(['can:instructor'])->group(function () {
        Route::get('/instructor/dashboard', [\App\Http\Controllers\InstructorController::class, 'dashboard'])->name('instructor.dashboard');
        Route::get('/instructor/equipment', [\App\Http\Controllers\InstructorController::class, 'equipment'])->name('instructor.equipment');
        Route::get('/instructor/reservations', [\App\Http\Controllers\InstructorController::class, 'reservations'])->name('instructor.reservations');
        Route::get('/instructor/reservations/create', [\App\Http\Controllers\InstructorController::class, 'createReservation'])->name('instructor.reservations.create');
        Route::post('/instructor/reservations', [\App\Http\Controllers\InstructorController::class, 'storeReservation'])->name('instructor.reservations.store');
        Route::post('/instructor/reservations/check-conflicts', [\App\Http\Controllers\InstructorController::class, 'checkConflicts'])->name('instructor.reservations.check-conflicts');
        Route::post('/instructor/reservations/check-duplicate', [\App\Http\Controllers\InstructorController::class, 'checkDuplicate'])->name('instructor.reservations.check-duplicate');
        Route::post('/instructor/reservations/{reservation}/cancel', [\App\Http\Controllers\InstructorController::class, 'cancelReservation'])->name('instructor.reservations.cancel');
        Route::get('/instructor/reservations/{reservation}', [\App\Http\Controllers\InstructorController::class, 'showReservation'])->name('instructor.reservations.show');
        
    // Incident Reporting Routes
    Route::get('/instructor/incidents', [\App\Http\Controllers\InstructorController::class, 'incidents'])->name('instructor.incidents.index');
    Route::get('/instructor/incidents/create', [\App\Http\Controllers\InstructorController::class, 'createIncident'])->name('instructor.incidents.create');
    Route::post('/instructor/incidents', [\App\Http\Controllers\InstructorController::class, 'storeIncident'])->name('instructor.incidents.store');
    Route::get('/instructor/incidents/{incident}', [\App\Http\Controllers\InstructorController::class, 'showIncident'])->name('instructor.incidents.show');
    Route::delete('/instructor/incidents/{incident}', [\App\Http\Controllers\InstructorController::class, 'destroyIncident'])->name('instructor.incidents.destroy');
    
    // Instructor Reporting Routes
    Route::get('/instructor/reports', [\App\Http\Controllers\InstructorController::class, 'reports'])->name('instructor.reports.index');
    Route::get('/instructor/incidents/{incident}/export-pdf', [\App\Http\Controllers\InstructorController::class, 'exportIncidentPdf'])->name('instructor.incidents.export-pdf');
    
    // Instructor Notification Routes
    Route::get('/instructor/notifications', [\App\Http\Controllers\InstructorController::class, 'notifications'])->name('instructor.notifications.index');
    Route::post('/instructor/notifications/{notification}/read', [\App\Http\Controllers\InstructorController::class, 'markNotificationAsRead'])->name('instructor.notifications.read');
    Route::post('/instructor/notifications/read-all', [\App\Http\Controllers\InstructorController::class, 'markAllNotificationsAsRead'])->name('instructor.notifications.read-all');
    Route::get('/instructor/notifications/unread-count', [\App\Http\Controllers\InstructorController::class, 'getUnreadCount'])->name('instructor.notifications.unread-count');

    // Instructor: update reservation dates (pending only, owner only)
    Route::post('/instructor/reservations/{reservation}/dates', [\App\Http\Controllers\ReservationController::class, 'updateDates'])
        ->name('instructor.reservations.update-dates');
    Route::get('/instructor/reservations/{reservation}/edit-data', [\App\Http\Controllers\ReservationController::class, 'instructorEditData'])
        ->name('instructor.reservations.edit-data');
    });
});

Route::middleware(['auth', 'cache.control'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'cache.control'])->group(function () {
    // Manager/Admin routes (require manager or admin role)
    Route::middleware(['can:manager,admin', 'cache.control'])->group(function () {
        // Equipment Category Management
        Route::get('/equipment-categories', [EquipmentCategoryController::class, 'index'])->name('equipment-categories.index');
        Route::get('/equipment-categories/create', [EquipmentCategoryController::class, 'create'])->name('equipment-categories.create');
        Route::post('/equipment-categories', [EquipmentCategoryController::class, 'store'])->name('equipment-categories.store');
        Route::get('/equipment-categories/{category}', [EquipmentCategoryController::class, 'show'])->name('equipment-categories.show');
        Route::get('/equipment-categories/{category}/edit', [EquipmentCategoryController::class, 'edit'])->name('equipment-categories.edit');
        Route::put('/equipment-categories/{category}', [EquipmentCategoryController::class, 'update'])->name('equipment-categories.update');
        Route::delete('/equipment-categories/{id}', [EquipmentCategoryController::class, 'destroy'])->name('equipment-categories.destroy');
        Route::post('/equipment-categories/check-duplicate', [EquipmentCategoryController::class, 'checkDuplicate'])->name('equipment-categories.check-duplicate');
        
        // Equipment Management
        Route::get('/equipment-management', [EquipmentManagementController::class, 'index'])->name('equipment-management.index');
        Route::get('/equipment-management/wishlisted', [EquipmentManagementController::class, 'wishlisted'])->name('equipment-management.wishlisted');
        Route::get('/equipment-management/wishlisted-pdf', [EquipmentManagementController::class, 'wishlistedPDF'])->name('equipment-management.wishlisted-pdf');
        Route::get('/equipment-management/wishlisted/export/excel', [EquipmentManagementController::class, 'wishlistedExcel'])->name('equipment-management.wishlisted.export-excel');
        Route::get('/equipment-management/create', [EquipmentManagementController::class, 'create'])->name('equipment-management.create');
        Route::post('/equipment-management', [EquipmentManagementController::class, 'store'])->name('equipment-management.store');
        Route::get('/equipment-management/generate-pdf', [EquipmentManagementController::class, 'generatePDF'])->name('equipment-management.generate-pdf');
        Route::get('/equipment-management/reports', [EquipmentManagementController::class, 'reports'])->name('equipment-management.reports');
        Route::get('/equipment-management/export/excel', [EquipmentManagementController::class, 'exportExcel'])->name('equipment-management.export-excel');
        Route::get('/equipment-management/export/csv', [EquipmentManagementController::class, 'exportCSV'])->name('equipment-management.export-csv');
        Route::get('/equipment-management/{equipment}', [EquipmentManagementController::class, 'show'])->name('equipment-management.show');
        Route::get('/equipment-management/{equipment}/edit', [EquipmentManagementController::class, 'edit'])->name('equipment-management.edit');
        Route::put('/equipment-management/{equipment}', [EquipmentManagementController::class, 'update'])->name('equipment-management.update');
        Route::delete('/equipment-management/{equipment}', [EquipmentManagementController::class, 'destroy'])->name('equipment-management.destroy');
        Route::get('/equipment-management/{equipment}/maintenance', [EquipmentManagementController::class, 'maintenance'])->name('equipment-management.maintenance');
        Route::post('/equipment-management/{equipment}/maintenance', [EquipmentManagementController::class, 'addMaintenanceRecord'])->name('equipment-management.maintenance.store');
        Route::delete('/equipment-management/{equipment}/images/{image}', [EquipmentManagementController::class, 'deleteImage'])->name('equipment-management.images.destroy');
        
        // Activity Logging routes
        Route::get('/activity-logs', [App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::post('/activity-log/bulk-delete', [App\Http\Controllers\ActivityLogController::class, 'logBulkDelete'])->name('activity-log.bulk-delete');
        Route::post('/activity-log/bulk-retire', [App\Http\Controllers\ActivityLogController::class, 'logBulkRetire'])->name('activity-log.bulk-retire');
        Route::get('/reservation-management/generate-pdf', [ReservationManagementController::class, 'generatePDF'])->name('reservation-management.generate-pdf');
        Route::get('/reservation-management/reports', [ReservationManagementController::class, 'reports'])->name('reservation-management.reports');
        // Excel export routes
        Route::get('/reservation-management/export/excel', [ReservationManagementController::class, 'exportReservations'])->name('reservation-management.export-excel');
        
        // Maintenance Management
        Route::get('/maintenance-management', [MaintenanceManagementController::class, 'index'])->name('maintenance-management.index');
        Route::get('/maintenance-management/discarded', [MaintenanceManagementController::class, 'discarded'])->name('maintenance-management.discarded');
        Route::get('/maintenance-management/generate-discarded-report', [MaintenanceManagementController::class, 'generateDiscardedReport'])->name('maintenance-management.generate-discarded-report');
        Route::get('/maintenance-management/generate-pdf', [MaintenanceManagementController::class, 'generatePDF'])->name('maintenance-management.generate-pdf');
        Route::get('/maintenance-management/reports', [MaintenanceManagementController::class, 'reports'])->name('maintenance-management.reports');
        Route::get('/maintenance-management/export/excel', [MaintenanceManagementController::class, 'exportExcel'])->name('maintenance-management.export-excel');
        Route::get('/maintenance-management/discarded/export/excel', [MaintenanceManagementController::class, 'exportDiscardedExcel'])->name('maintenance-management.discarded.export-excel');
        Route::post('/maintenance-management/bulk-update', [MaintenanceManagementController::class, 'bulkUpdate'])->name('maintenance-management.bulk-update');
        Route::post('/maintenance-management/routine-maintenance', [MaintenanceManagementController::class, 'routineMaintenance'])->name('maintenance-management.routine-maintenance');
        Route::post('/maintenance-management/discard-damaged', [MaintenanceManagementController::class, 'discardDamaged'])->name('maintenance-management.discard-damaged');
        Route::get('/maintenance-management/{equipment}', [MaintenanceManagementController::class, 'show'])->name('maintenance-management.show');
        Route::get('/maintenance-management/{equipment}/create-record', [MaintenanceManagementController::class, 'createRecord'])->name('maintenance-management.create-record');
        Route::post('/maintenance-management/{equipment}/store-record', [MaintenanceManagementController::class, 'storeRecord'])->name('maintenance-management.store-record');
        Route::get('/maintenance-management/records/{maintenanceRecord}/edit', [MaintenanceManagementController::class, 'editRecord'])->name('maintenance-management.edit-record');
        Route::put('/maintenance-management/records/{maintenanceRecord}', [MaintenanceManagementController::class, 'updateRecord'])->name('maintenance-management.update-record');
        Route::delete('/maintenance-management/records/{maintenanceRecord}', [MaintenanceManagementController::class, 'deleteRecord'])->name('maintenance-management.delete-record');
        
        // Reservation Management
        Route::get('/reservation-management', [ReservationManagementController::class, 'index'])->name('reservation-management.index');
        Route::get('/reservation-management/create', [ReservationManagementController::class, 'create'])->name('reservation-management.create');
        Route::post('/reservation-management', [ReservationManagementController::class, 'store'])->name('reservation-management.store');
        Route::get('/reservation-management/{reservation}', [ReservationManagementController::class, 'show'])->name('reservation-management.show');
        Route::get('/reservation-management/{reservation}/edit', [ReservationManagementController::class, 'edit'])->name('reservation-management.edit');
        Route::put('/reservation-management/{reservation}', [ReservationManagementController::class, 'update'])->name('reservation-management.update');
        Route::delete('/reservation-management/{reservation}', [ReservationManagementController::class, 'destroy'])->name('reservation-management.destroy');
        Route::post('/reservation-management/bulk-update', [ReservationManagementController::class, 'bulkUpdate'])->name('reservation-management.bulk-update');
        Route::get('/reservation-management/calendar', [ReservationManagementController::class, 'calendar'])->name('reservation-management.calendar');
        Route::get('/reservation-management/pending', [ReservationManagementController::class, 'pendingApprovals'])->name('reservation-management.pending');
        Route::get('/reservation-management/overdue', [ReservationManagementController::class, 'overdueReservations'])->name('reservation-management.overdue');
        Route::post('/reservation-management/check-overdue', [ReservationManagementController::class, 'checkOverdueStatus'])->name('reservation-management.check-overdue');
        Route::get('/reservation-management/reports', [ReservationManagementController::class, 'reports'])->name('reservation-management.reports');
        Route::post('/reservation-management/{reservation}/fix-picked-up', [ReservationManagementController::class, 'fixPickedUpReservation'])->name('reservation-management.fix-picked-up');
        Route::post('/reservation-management/{reservation}/mark-picked-up', [ReservationManagementController::class, 'markAsPickedUp'])->name('reservation-management.mark-picked-up');
        Route::post('/reservation-management/{reservation}/approve', [ReservationManagementController::class, 'approveReservation'])->name('reservation-management.approve');
        Route::get('/reservation-management/{reservation}/equipment-data', [ReservationManagementController::class, 'getReservationEquipmentData'])->name('reservation-management.equipment-data');
        Route::get('/reservation-management/{reservation}/approval-data', [ReservationManagementController::class, 'getApprovalData'])->name('reservation-management.approval-data');
        Route::post('/api/check-email-reservation', [ReservationManagementController::class, 'checkEmailReservation'])->name('api.check-email-reservation');
        // Date-aware availability for equipment
        Route::get('/api/equipment/{equipment}/availability', function(\App\Models\Equipment $equipment, \Illuminate\Http\Request $request){
            $request->validate([
                'borrow_date' => 'required|date',
                'return_date' => 'required|date|after_or_equal:borrow_date',
            ]);
            $count = $equipment->getBookableCount($request->borrow_date, $request->return_date);
            return response()->json(['bookable_count' => $count]);
        })->name('api.equipment.availability');
        Route::post('/reservation-management/{reservation}/decline', [ReservationManagementController::class, 'declineReservation'])->name('reservation-management.decline');
        Route::post('/reservation-management/{reservation}/cancel', [ReservationManagementController::class, 'cancelReservation'])->name('reservation-management.cancel');
        Route::post('/reservation-management/{reservation}/mark-completed', [ReservationManagementController::class, 'markCompleted'])->name('reservation-management.mark-completed');
        
        // Equipment Returns Management
        Route::get('/equipment-returns/{reservation}/return-form', [EquipmentReturnController::class, 'showReturnForm'])->name('equipment-returns.return-form');
        Route::post('/equipment-returns/{reservation}/process', [EquipmentReturnController::class, 'processReturn'])->name('equipment-returns.process');
        Route::get('/equipment-returns/history', [EquipmentReturnController::class, 'showReturnHistory'])->name('equipment-returns.history');
        Route::get('/equipment-returns/instance/{instance}/history', [EquipmentReturnController::class, 'showInstanceHistory'])->name('equipment-returns.instance-history');
        
        // Equipment Pickup Management
        Route::get('/equipment-pickup/{reservation}/pickup-form', [ReservationManagementController::class, 'showPickupForm'])->name('equipment-pickup.pickup-form');
        Route::post('/equipment-pickup/{reservation}/process', [ReservationManagementController::class, 'processPickup'])->name('equipment-pickup.process');
        Route::post('/equipment-pickup/update-instance-status', [ReservationManagementController::class, 'updateInstanceStatus'])->name('equipment-pickup.update-instance-status');
        Route::get('/equipment-pickup/get-available-instances', [ReservationManagementController::class, 'getAvailableInstances'])->name('equipment-pickup.get-available-instances');
        
        // Maintenance Management
        Route::post('/maintenance-management/set-routine', [App\Http\Controllers\MaintenanceManagementController::class, 'setRoutineMaintenance'])->name('maintenance-management.set-routine');
        Route::post('/maintenance-management/emergency-enforcement', [MaintenanceManagementController::class, 'emergencyEnforcement'])->name('maintenance-management.emergency-enforcement');
        Route::post('/maintenance-management/complete-maintenance', [MaintenanceManagementController::class, 'completeMaintenance'])->name('maintenance-management.complete-maintenance');
        Route::get('/maintenance-management/reports', [MaintenanceManagementController::class, 'reports'])->name('maintenance-management.reports');
        Route::get('/maintenance-management/generate-pdf', [MaintenanceManagementController::class, 'generatePDF'])->name('maintenance-management.generate-pdf');
        Route::get('/maintenance-management/generate-discarded-report', [MaintenanceManagementController::class, 'generateDiscardedReport'])->name('maintenance-management.generate-discarded-report');

        // Instance management helpers
        Route::post('/instances/{equipment}/add', [InstanceController::class, 'add'])->name('instances.add');
        Route::post('/instances/{instance}/restore', [InstanceController::class, 'restore'])->name('instances.restore');
        Route::post('/instances/{instance}/retire', [InstanceController::class, 'retire'])->name('instances.retire');
        Route::delete('/instances/{instance}', [InstanceController::class, 'destroy'])->name('instances.destroy');
        
        // Missing Equipment Management (formerly Stolen/Lost Equipment)
        Route::get('/missing-equipment', [App\Http\Controllers\MissingEquipmentController::class, 'index'])->name('missing-equipment.index');
        Route::get('/missing-equipment/create', [App\Http\Controllers\MissingEquipmentController::class, 'create'])->name('missing-equipment.create');
        Route::post('/missing-equipment', [App\Http\Controllers\MissingEquipmentController::class, 'store'])->name('missing-equipment.store');
        Route::get('/missing-equipment/generate-pdf', [App\Http\Controllers\MissingEquipmentController::class, 'generatePDF'])->name('missing-equipment.generate-pdf');
        Route::get('/missing-equipment/export/excel', [App\Http\Controllers\MissingEquipmentController::class, 'exportExcel'])->name('missing-equipment.export-excel');
        // Route removed - reports functionality moved to modal on index page
        Route::get('/missing-equipment/{stolenLostEquipment}', [App\Http\Controllers\MissingEquipmentController::class, 'show'])->name('missing-equipment.show');
        Route::get('/missing-equipment/{stolenLostEquipment}/edit', [App\Http\Controllers\MissingEquipmentController::class, 'edit'])->name('missing-equipment.edit');
        Route::put('/missing-equipment/{stolenLostEquipment}', [App\Http\Controllers\MissingEquipmentController::class, 'update'])->name('missing-equipment.update');
        Route::delete('/missing-equipment/{stolenLostEquipment}', [App\Http\Controllers\MissingEquipmentController::class, 'destroy'])->name('missing-equipment.destroy');
        Route::post('/missing-equipment/{stolenLostEquipment}/mark-replaced', [App\Http\Controllers\MissingEquipmentController::class, 'markAsReplaced'])->name('missing-equipment.mark-replaced');
        Route::post('/missing-equipment/{stolenLostEquipment}/mark-not-replaced', [App\Http\Controllers\MissingEquipmentController::class, 'markAsNotReplaced'])->name('missing-equipment.mark-not-replaced');
        // Blacklist pages
        Route::get('/blacklist', [BlacklistController::class, 'index'])->name('blacklist.index');
        Route::post('/blacklist/release', [BlacklistController::class, 'release'])->name('blacklist.release');
    });
    
    // Equipment Types Management (Admin and Manager)
    Route::get('/equipment-types', [EquipmentTypeController::class, 'index'])->name('equipment-types.index');
    Route::get('/equipment-types/create', [EquipmentTypeController::class, 'create'])->name('equipment-types.create');
    Route::post('/equipment-types', [EquipmentTypeController::class, 'store'])->name('equipment-types.store');
    Route::get('/equipment-types/{equipmentType}', [EquipmentTypeController::class, 'show'])->name('equipment-types.show');
    Route::get('/equipment-types/{equipmentType}/edit', [EquipmentTypeController::class, 'edit'])->name('equipment-types.edit');
    Route::put('/equipment-types/{equipmentType}', [EquipmentTypeController::class, 'update'])->name('equipment-types.update');
    Route::delete('/equipment-types/{id}', [EquipmentTypeController::class, 'destroy'])->name('equipment-types.destroy');
    Route::get('/equipment-types/by-category/{category}', [EquipmentTypeController::class, 'getByCategory'])->name('equipment-types.by-category');
    Route::post('/equipment-types/check-duplicate', [EquipmentTypeController::class, 'checkDuplicate'])->name('equipment-types.check-duplicate');
    
    // Admin-only routes
    Route::middleware(['can:admin'])->group(function () {
        
        // Database Backup Management (Admin only)
        Route::get('/admin/database-backup', [DatabaseBackupController::class, 'index'])->name('admin.database-backup.index');
        Route::post('/admin/database-backup', [DatabaseBackupController::class, 'createBackup'])->name('admin.database-backup.create');
        Route::post('/admin/database-backup/{filename}/restore', [DatabaseBackupController::class, 'restoreBackup'])->name('admin.database-backup.restore');
        Route::delete('/admin/database-backup/{filename}', [DatabaseBackupController::class, 'deleteBackup'])->name('admin.database-backup.delete');
        
        // Profile User Management (Admin only)
        Route::get('/profile-user-management', [ProfileUserManagementController::class, 'index'])->name('profile-user-management.index');
        Route::get('/profile-user-management/create', [ProfileUserManagementController::class, 'create'])->name('profile-user-management.create');
        Route::post('/profile-user-management', [ProfileUserManagementController::class, 'store'])->name('profile-user-management.store');
        Route::get('/profile-user-management/{user}', [ProfileUserManagementController::class, 'show'])->name('profile-user-management.show');
        Route::get('/profile-user-management/{user}/edit', [ProfileUserManagementController::class, 'edit'])->name('profile-user-management.edit');
        Route::put('/profile-user-management/{user}', [ProfileUserManagementController::class, 'update'])->name('profile-user-management.update');
        Route::put('/profile-user-management/{user}/password', [ProfileUserManagementController::class, 'updatePassword'])->name('profile-user-management.password');
        Route::put('/profile-user-management/{user}/role', [ProfileUserManagementController::class, 'updateRole'])->name('profile-user-management.role');
        Route::patch('/profile-user-management/{user}/toggle-status', [ProfileUserManagementController::class, 'toggleStatus'])->name('profile-user-management.toggle-status');
        Route::delete('/profile-user-management/{user}', [ProfileUserManagementController::class, 'destroy'])->name('profile-user-management.destroy');
        Route::post('/profile-user-management/bulk-actions', [ProfileUserManagementController::class, 'bulkActions'])->name('profile-user-management.bulk-actions');
        Route::get('/profile-user-management/export', [ProfileUserManagementController::class, 'exportUsers'])->name('profile-user-management.export');
        Route::get('/profile-user-management/{user}/activity', [ProfileUserManagementController::class, 'userActivity'])->name('profile-user-management.activity');
        Route::post('/profile-user-management/check-email', [ProfileUserManagementController::class, 'checkEmail'])->name('profile-user-management.check-email');
        
        // Admin Reservation Management Routes (using shared views with manager)
        Route::get('/admin/reservations', function () {
            return redirect()->route('reservation-management.index');
        })->name('admin.reservations');
        Route::get('/admin/reservations/{reservation}', function ($reservation) {
            return redirect()->route('reservation-management.show', $reservation);
        })->name('admin.reservations.show');
        Route::get('/admin/reservations/{reservation}/edit', function ($reservation) {
            return redirect()->route('reservation-management.edit', $reservation);
        })->name('admin.reservations.edit');
        Route::put('/admin/reservations/{reservation}', [ReservationManagementController::class, 'update'])->name('admin.reservations.update');
        Route::delete('/admin/reservations/{reservation}', [ReservationManagementController::class, 'destroy'])->name('admin.reservations.destroy');
        Route::post('/admin/reservations/bulk-update', [ReservationManagementController::class, 'bulkUpdate'])->name('admin.reservations.bulk-update');
        Route::post('/admin/reservations/{reservation}/mark-picked-up', [ReservationManagementController::class, 'markAsPickedUp'])->name('admin.reservations.mark-picked-up');
        Route::post('/admin/reservations/{reservation}/fix-picked-up', [ReservationManagementController::class, 'fixPickedUpReservation'])->name('admin.reservations.fix-picked-up');
        Route::post('/admin/reservations/{reservation}/approve', [ReservationManagementController::class, 'approveReservation'])->name('admin.reservations.approve');
        Route::get('/admin/reservations/{reservation}/equipment-data', [ReservationManagementController::class, 'getReservationEquipmentData'])->name('admin.reservations.equipment-data');
        Route::get('/admin/reservations/{reservation}/approval-data', [ReservationManagementController::class, 'getApprovalData'])->name('admin.reservations.approval-data');
        Route::post('/admin/reservations/{reservation}/decline', [ReservationManagementController::class, 'declineReservation'])->name('admin.reservations.decline');
        Route::post('/admin/reservations/{reservation}/cancel', [ReservationManagementController::class, 'cancelReservation'])->name('admin.reservations.cancel');
        Route::post('/admin/reservations/{reservation}/mark-completed', [ReservationManagementController::class, 'markCompleted'])->name('admin.reservations.mark-completed');
        Route::get('/admin/reservations/generate-pdf', [ReservationManagementController::class, 'generatePDF'])->name('admin.reservations.generate-pdf');
        
        // Admin Equipment Pickup Management
        Route::get('/admin/equipment-pickup/{reservation}/pickup-form', [ReservationManagementController::class, 'showPickupForm'])->name('admin.equipment-pickup.pickup-form');
        Route::post('/admin/equipment-pickup/{reservation}/process', [ReservationManagementController::class, 'processPickup'])->name('admin.equipment-pickup.process');
    });
});






require __DIR__.'/auth.php';
