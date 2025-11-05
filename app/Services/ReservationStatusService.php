<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\EquipmentInstance;
use App\Models\EquipmentType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationStatusService
{
    /**
     * Allowed status transitions
     */
    private static $allowedTransitions = [
        'pending' => ['approved', 'denied', 'cancelled'],
        'approved' => ['picked_up', 'denied', 'cancelled'],
        'picked_up' => ['returned', 'overdue'],
        'returned' => ['completed'],
        'overdue' => ['returned'], // Allow overdue to go back to returned
        'denied' => [], // No further transitions allowed
        'completed' => [], // No further transitions allowed
        'cancelled' => [], // No further transitions allowed
    ];

    /**
     * Update reservation status with centralized logic
     */
    public static function updateStatus(Reservation $reservation, string $newStatus, array $data = [], $userId = null)
    {
        $oldStatus = $reservation->status;
        
        // Validate status transition
        if (!self::isValidTransition($oldStatus, $newStatus)) {
            throw new \InvalidArgumentException(
                "Cannot update reservation {$reservation->reservation_code} from '{$oldStatus}' to '{$newStatus}'. " .
                "Allowed transitions: " . implode(', ', self::$allowedTransitions[$oldStatus] ?? [])
            );
        }

        // Prevent reverting from terminal states
        if (in_array($oldStatus, ['denied', 'completed', 'cancelled'])) {
            throw new \InvalidArgumentException(
                "Cannot update reservation {$reservation->reservation_code} from terminal state '{$oldStatus}'"
            );
        }

        DB::beginTransaction();
        try {
            // Prepare update data
            $updateData = [
                'status' => $newStatus,
                'approved_by' => $userId ?? auth()->id(),
            ];

            // Add optional fields
            if (isset($data['remarks'])) {
                $updateData['remarks'] = $data['remarks'];
            }
            if (isset($data['pickup_date'])) {
                $updateData['pickup_date'] = $data['pickup_date'];
            }

            // Set appropriate timestamp based on status
            $updateData = array_merge($updateData, self::getStatusTimestamp($newStatus));

            // Update reservation
            $reservation->update($updateData);

            // Update approved quantities if provided
            if (isset($data['approved_quantity']) && is_array($data['approved_quantity'])) {
                foreach ($data['approved_quantity'] as $itemId => $quantity) {
                    $item = $reservation->items()->find($itemId);
                    if ($item) {
                        $item->update(['quantity_approved' => $quantity]);
                    }
                }
            }

            // Handle status-specific logic
            self::handleStatusSpecificLogic($reservation, $newStatus, $oldStatus);

            // Create notification if status changed
            if ($oldStatus !== $newStatus) {
                NotificationService::createReservationStatusNotification(
                    $reservation, 
                    $newStatus, 
                    $data['remarks'] ?? null
                );
            }

            DB::commit();

            Log::info("Reservation status updated successfully", [
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'user_id' => $userId ?? auth()->id()
            ]);

            return [
                'success' => true,
                'message' => self::getStatusMessage($newStatus),
                'reservation_id' => $reservation->id,
                'new_status' => $newStatus
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to update reservation status", [
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Check if status transition is valid
     */
    private static function isValidTransition(string $fromStatus, string $toStatus): bool
    {
        return in_array($toStatus, self::$allowedTransitions[$fromStatus] ?? []);
    }

    /**
     * Get timestamp field based on status
     */
    private static function getStatusTimestamp(string $status): array
    {
        switch ($status) {
            case 'approved':
            case 'denied':
            case 'picked_up':
            case 'returned':
            case 'overdue':
                return ['approved_at' => now()];
            case 'cancelled':
                return ['cancelled_at' => now()];
            case 'completed':
                return ['completed_at' => now()];
            default:
                return [];
        }
    }

    /**
     * Handle status-specific business logic
     */
    private static function handleStatusSpecificLogic(Reservation $reservation, string $newStatus, string $oldStatus)
    {
        switch ($newStatus) {
            case 'approved':
                self::handleApprovedStatus($reservation);
                break;
            case 'denied':
                self::handleDeniedStatus($reservation);
                break;
            case 'picked_up':
                self::handlePickedUpStatus($reservation);
                break;
            case 'returned':
                self::handleReturnedStatus($reservation);
                break;
            case 'completed':
                self::handleCompletedStatus($reservation);
                break;
            case 'cancelled':
                self::handleCancelledStatus($reservation);
                break;
            case 'overdue':
                self::handleOverdueStatus($reservation);
                break;
        }
    }

    /**
     * Handle approved status
     */
    private static function handleApprovedStatus(Reservation $reservation)
    {
        // Check availability for all items before approving
        foreach ($reservation->items as $item) {
            $equipment = $item->equipment;
            $approvedQuantity = $item->quantity_approved ?? $item->quantity_requested;
            
            // Check if enough instances are actually available before approval
            $availabilityCheck = $equipment->hasAvailableInstances($approvedQuantity);
            if (!$availabilityCheck['available']) {
                throw new \InvalidArgumentException(
                    "Cannot approve reservation for {$equipment->display_name}. Only {$availabilityCheck['available_count']} instances available, but {$approvedQuantity} requested."
                );
            }
        }
    }

    /**
     * Handle denied status
     */
    private static function handleDeniedStatus(Reservation $reservation)
    {
        // If denying an approved or picked_up reservation, restore any reserved instances
        if (in_array($reservation->status, ['approved', 'picked_up'])) {
            foreach ($reservation->items as $item) {
                // Get all reservation item instances for this item
                $reservationItemInstances = $item->reservationItemInstances;
                
                if ($reservationItemInstances->count() > 0) {
                    foreach ($reservationItemInstances as $reservationItemInstance) {
                        // Get the actual equipment instance
                        $equipmentInstance = $reservationItemInstance->equipmentInstance;
                        
                        if ($equipmentInstance) {
                            // Mark equipment instance as available again
                            $equipmentInstance->update(['is_available' => true]);
                        }
                    }
                    
                    // Remove the reservation-instance links
                    $item->reservationItemInstances()->delete();
                }
            }
        }
    }

    /**
     * Handle picked up status
     */
    private static function handlePickedUpStatus(Reservation $reservation)
    {
        // Assign instances and mark them as picked up
        foreach ($reservation->items as $item) {
            $quantityToAssign = $item->quantity_approved ?? $item->quantity_requested;
            
            // Use helper method for atomic instance reservation
            $reservationResult = $item->equipment->reserveInstances($quantityToAssign);
            
            if (!$reservationResult['success']) {
                throw new \InvalidArgumentException($reservationResult['message']);
            }
            
            // Create the reservation-instance links
            foreach ($reservationResult['instances'] as $instance) {
                \App\Models\ReservationItemInstance::create([
                    'reservation_item_id' => $item->id,
                    'equipment_instance_id' => $instance->id,
                    'status' => 'picked_up',
                    'picked_up_at' => now(),
                ]);
                
                // Mark instance as unavailable
                $instance->update(['is_available' => false]);
            }
        }
        
        $reservation->update(['picked_up_at' => now()]);
    }

    /**
     * Handle returned status
     */
    private static function handleReturnedStatus(Reservation $reservation)
    {
        // Mark as returned but keep equipment instances reserved until completion
        $reservation->update(['returned_at' => now()]);
    }

    /**
     * Handle completed status
     */
    private static function handleCompletedStatus(Reservation $reservation)
    {
        // Mark completion timestamp
        $reservation->update(['completed_at' => now()]);
        
        // Restore equipment availability for completed reservations
        foreach ($reservation->items as $item) {
            foreach ($item->reservationItemInstances as $reservationItemInstance) {
                $equipmentInstance = $reservationItemInstance->equipmentInstance;
                if ($equipmentInstance) {
                    // Only restore availability if the instance is not damaged/needs repair
                    if (!in_array($equipmentInstance->condition, ['damaged', 'needs_repair'])) {
                        $equipmentInstance->update(['is_available' => true]);
                    }
                }
            }
        }
    }

    /**
     * Handle cancelled status
     */
    private static function handleCancelledStatus(Reservation $reservation)
    {
        // If cancelling an approved or picked_up reservation, restore any reserved instances
        if (in_array($reservation->status, ['approved', 'picked_up'])) {
            foreach ($reservation->items as $item) {
                // Get all reservation item instances for this item
                $reservationItemInstances = $item->reservationItemInstances;
                
                if ($reservationItemInstances->count() > 0) {
                    foreach ($reservationItemInstances as $reservationItemInstance) {
                        // Get the actual equipment instance
                        $equipmentInstance = $reservationItemInstance->equipmentInstance;
                        
                        if ($equipmentInstance) {
                            // Mark equipment instance as available again
                            $equipmentInstance->update(['is_available' => true]);
                        }
                    }
                    
                    // Remove the reservation-instance links
                    $item->reservationItemInstances()->delete();
                }
            }
        }
    }

    /**
     * Handle overdue status
     */
    private static function handleOverdueStatus(Reservation $reservation)
    {
        // Instances remain in use, but reservation is marked as overdue
        // This allows for overdue tracking and notifications
    }

    /**
     * Get status message
     */
    private static function getStatusMessage(string $status): string
    {
        $message = 'Reservation ' . $status . ' successfully';
        
        if (in_array($status, ['approved', 'denied', 'returned', 'completed', 'cancelled'])) {
            $message .= '. Equipment availability has been updated.';
        }
        
        return $message;
    }

    /**
     * Get allowed transitions for a status
     */
    public static function getAllowedTransitions(string $status): array
    {
        return self::$allowedTransitions[$status] ?? [];
    }

    /**
     * Get all allowed transitions
     */
    public static function getAllTransitions(): array
    {
        return self::$allowedTransitions;
    }
}
