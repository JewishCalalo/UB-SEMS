<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    /**
     * Log an activity
     */
    public static function log(
        string $action,
        string $modelType,
        ?int $modelId = null,
        ?string $modelName = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null,
        ?Request $request = null
    ): ActivityLog {
        $user = auth()->user();
        
        if (!$user) {
            throw new \Exception('No authenticated user found for activity logging');
        }

        $log = ActivityLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'model_name' => $modelName,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description ?: self::generateDescription($action, $modelType, $modelName),
        ]);

        return $log;
    }

    /**
     * Log equipment creation
     */
    public static function logEquipmentCreated(Model $equipment, Request $request = null): ActivityLog
    {
        return self::log(
            'created',
            'App\Models\Equipment',
            $equipment->id,
            $equipment->display_name,
            null,
            $equipment->toArray(),
            "Created equipment: {$equipment->display_name}",
            $request
        );
    }

    /**
     * Log equipment update
     */
    public static function logEquipmentUpdated(Model $equipment, array $oldValues, Request $request = null): ActivityLog
    {
        return self::log(
            'updated',
            'App\Models\Equipment',
            $equipment->id,
            $equipment->display_name,
            $oldValues,
            $equipment->toArray(),
            "Updated equipment: {$equipment->display_name}",
            $request
        );
    }

    /**
     * Log equipment deletion
     */
    public static function logEquipmentDeleted(string $equipmentName, array $equipmentData, Request $request = null): ActivityLog
    {
        return self::log(
            'deleted',
            'App\Models\Equipment',
            null,
            $equipmentName,
            $equipmentData,
            null,
            "Deleted equipment: {$equipmentName}",
            $request
        );
    }

    /**
     * Log instance creation
     */
    public static function logInstanceCreated(Model $instance, Request $request = null): ActivityLog
    {
        return self::log(
            'created',
            'App\Models\EquipmentInstance',
            $instance->id,
            $instance->instance_code,
            null,
            $instance->toArray(),
            "Created instance: {$instance->instance_code}",
            $request
        );
    }

    /**
     * Log bulk instance creation
     */
    public static function logBulkInstancesCreated(int $count, string $equipmentName, Request $request = null): ActivityLog
    {
        return self::log(
            'bulk_added',
            'App\Models\EquipmentInstance',
            null,
            $equipmentName,
            null,
            ['count' => $count],
            "Bulk added {$count} instances for equipment: {$equipmentName}",
            $request
        );
    }

    /**
     * Log instance deletion
     */
    public static function logInstanceDeleted(string $instanceCode, array $instanceData, Request $request = null): ActivityLog
    {
        return self::log(
            'deleted',
            'App\Models\EquipmentInstance',
            null,
            $instanceCode,
            $instanceData,
            null,
            "Deleted instance: {$instanceCode}",
            $request
        );
    }

    /**
     * Log bulk instance deletion
     */
    public static function logBulkInstancesDeleted(int $count, string $equipmentName, Request $request = null): ActivityLog
    {
        return self::log(
            'bulk_deleted',
            'App\Models\EquipmentInstance',
            null,
            $equipmentName,
            null,
            ['count' => $count],
            "Bulk deleted {$count} instances for equipment: {$equipmentName}",
            $request
        );
    }

    /**
     * Log instance retirement
     */
    public static function logInstanceRetired(Model $instance, Request $request = null): ActivityLog
    {
        return self::log(
            'retired',
            'App\Models\EquipmentInstance',
            $instance->id,
            $instance->instance_code,
            $instance->toArray(),
            ['is_active' => false, 'is_available' => false],
            "Retired instance: {$instance->instance_code}",
            $request
        );
    }

    /**
     * Log bulk instance retirement
     */
    public static function logBulkInstancesRetired(int $count, string $equipmentName, Request $request = null): ActivityLog
    {
        return self::log(
            'bulk_retired',
            'App\Models\EquipmentInstance',
            null,
            $equipmentName,
            null,
            ['count' => $count],
            "Bulk retired {$count} instances for equipment: {$equipmentName}",
            $request
        );
    }

    /**
     * Log maintenance completion
     */
    public static function logMaintenanceCompleted(Model $maintenanceRecord, Request $request = null): ActivityLog
    {
        return self::log(
            'maintenance_completed',
            'App\Models\MaintenanceRecord',
            $maintenanceRecord->id,
            $maintenanceRecord->equipment->display_name ?? 'Unknown Equipment',
            null,
            $maintenanceRecord->toArray(),
            "Completed maintenance: {$maintenanceRecord->maintenance_type} for {$maintenanceRecord->equipment->display_name}",
            $request
        );
    }

    /**
     * Log maintenance scheduling
     */
    public static function logMaintenanceScheduled(Model $maintenanceRecord, Request $request = null): ActivityLog
    {
        return self::log(
            'maintenance_scheduled',
            'App\Models\MaintenanceRecord',
            $maintenanceRecord->id,
            $maintenanceRecord->equipment->display_name ?? 'Unknown Equipment',
            null,
            $maintenanceRecord->toArray(),
            "Scheduled maintenance: {$maintenanceRecord->maintenance_type} for {$maintenanceRecord->equipment->display_name}",
            $request
        );
    }

    /**
     * Log reservation status changes
     */
    public static function logReservationStatusChange(Model $reservation, string $oldStatus, string $newStatus, Request $request = null): ActivityLog
    {
        return self::log(
            $newStatus,
            'App\Models\Reservation',
            $reservation->id,
            $reservation->reservation_code,
            ['status' => $oldStatus],
            ['status' => $newStatus],
            "Changed reservation status from {$oldStatus} to {$newStatus}: {$reservation->reservation_code}",
            $request
        );
    }

    /**
     * Generate a description based on action and model
     */
    private static function generateDescription(string $action, string $modelType, ?string $modelName): string
    {
        $modelName = $modelName ?: 'Unknown';
        
        return match($action) {
            'created' => "Created {$modelType}: {$modelName}",
            'updated' => "Updated {$modelType}: {$modelName}",
            'deleted' => "Deleted {$modelType}: {$modelName}",
            'retired' => "Retired {$modelType}: {$modelName}",
            'restored' => "Restored {$modelType}: {$modelName}",
            'approved' => "Approved {$modelType}: {$modelName}",
            'rejected' => "Rejected {$modelType}: {$modelName}",
            'picked_up' => "Picked up {$modelType}: {$modelName}",
            'returned' => "Returned {$modelType}: {$modelName}",
            'maintenance_completed' => "Completed maintenance for {$modelName}",
            'maintenance_scheduled' => "Scheduled maintenance for {$modelName}",
            'bulk_added' => "Bulk added instances for {$modelName}",
            'bulk_deleted' => "Bulk deleted instances for {$modelName}",
            'bulk_retired' => "Bulk retired instances for {$modelName}",
            default => "Performed {$action} on {$modelType}: {$modelName}",
        };
    }
}
