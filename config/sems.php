<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SEMS System Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the Sports Equipment
    | Management System (SEMS).
    |
    */

    // Reservation Settings
    'max_reservation_days' => env('SEMS_MAX_RESERVATION_DAYS', 7),
    'max_items_per_reservation' => env('SEMS_MAX_ITEMS_PER_RESERVATION', 10),
    'auto_approval' => env('SEMS_AUTO_APPROVAL', false),
    'reservation_advance_days' => env('SEMS_RESERVATION_ADVANCE_DAYS', 30),

    // Maintenance Settings
    'maintenance_reminder_days' => env('SEMS_MAINTENANCE_REMINDER_DAYS', 7),
    'maintenance_check_interval' => env('SEMS_MAINTENANCE_CHECK_INTERVAL', 90), // days

    // Equipment Settings
    'max_images_per_equipment' => env('SEMS_MAX_IMAGES_PER_EQUIPMENT', 5),
    'image_max_size' => env('SEMS_IMAGE_MAX_SIZE', 2048), // KB
    'allowed_image_types' => ['jpg', 'jpeg', 'png', 'gif'],

    // Notification Settings
    'email_notifications' => env('SEMS_EMAIL_NOTIFICATIONS', true),
    'in_app_notifications' => env('SEMS_IN_APP_NOTIFICATIONS', true),
    'notification_retention_days' => env('SEMS_NOTIFICATION_RETENTION_DAYS', 90),

    // Security Settings
    'session_timeout_minutes' => env('SEMS_SESSION_TIMEOUT_MINUTES', 120),
    'max_login_attempts' => env('SEMS_MAX_LOGIN_ATTEMPTS', 5),
    'lockout_duration_minutes' => env('SEMS_LOCKOUT_DURATION_MINUTES', 15),

    // Backup Settings
    'auto_backup_enabled' => env('SEMS_AUTO_BACKUP_ENABLED', true),
    'backup_retention_days' => env('SEMS_BACKUP_RETENTION_DAYS', 30),
    'backup_time' => env('SEMS_BACKUP_TIME', '02:00'),

    // University Settings
    'university_name' => env('SEMS_UNIVERSITY_NAME', 'University of Baguio'),
    'department_name' => env('SEMS_DEPARTMENT_NAME', 'Physical Education Office'),
    'allowed_email_domains' => ['ubaguio.edu'],

    // Pagination Settings
    'items_per_page' => [
        'equipment' => 12,
        'reservations' => 15,
        'users' => 20,
        'notifications' => 25,
    ],

    // File Storage Settings
    'storage_disk' => env('SEMS_STORAGE_DISK', 'public'),
    'equipment_images_path' => 'equipment/images',
    'maintenance_documents_path' => 'maintenance/documents',
];
