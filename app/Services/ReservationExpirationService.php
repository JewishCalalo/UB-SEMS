<?php

namespace App\Services;

use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReservationExpirationService
{
    /**
     * Check and mark expired pending reservations in real-time
     */
    public static function checkAndMarkExpired(): array
    {
        $now = now();
        $expiredCount = 0;
        $expiredReservations = [];
        
        // Find pending reservations where return date has passed
        $expiredReservations = Reservation::where('status', 'pending')
            ->where(function ($query) use ($now) {
                $query->where('return_date', '<', $now->toDateString())
                      ->orWhere(function ($q) use ($now) {
                          $q->whereDate('return_date', '=', $now->toDateString())
                            ->whereTime('return_time', '<', $now->format('H:i:s'));
                      });
            })
            ->with(['user', 'items.equipment'])
            ->get();
        
        foreach ($expiredReservations as $reservation) {
            try {
                // Update status to cancelled (expired)
                $reservation->update([
                    'status' => 'cancelled',
                    'cancelled_at' => $now
                ]);
                
                // Send notification to user if they have an account
                if ($reservation->user_id) {
                    $borrowDate = $reservation->borrow_date->format('M d, Y');
                    $returnDate = $reservation->return_date->format('M d, Y');
                    
                    NotificationService::createReservationStatusNotification(
                        $reservation, 
                        'cancelled', 
                        "Your equipment reservation has been automatically cancelled because the return date ({$returnDate}) has passed. Please create a new reservation if you still need the equipment."
                    );
                    
                    Log::info("Expired reservation notification sent to user {$reservation->user->email} for reservation {$reservation->reservation_code}");
                } else {
                    // For guest reservations, just log the cancellation
                    Log::info("Guest reservation {$reservation->reservation_code} automatically cancelled due to expired return date (Email: {$reservation->email})");
                }
                
                $expiredCount++;
                
            } catch (\Exception $e) {
                Log::error("Failed to mark reservation {$reservation->reservation_code} as expired: " . $e->getMessage());
            }
        }
        
        if ($expiredCount > 0) {
            Log::info("Real-time expiration check completed: {$expiredCount} reservations marked as cancelled");
        }
        
        return [
            'expired_count' => $expiredCount,
            'expired_reservations' => $expiredReservations->pluck('reservation_code')->toArray()
        ];
    }

    /**
     * Check if a specific reservation is expired
     */
    public static function isExpired(Reservation $reservation): bool
    {
        if ($reservation->status !== 'pending') {
            return false;
        }

        $now = now();
        $returnDateTime = Carbon::parse($reservation->return_date->format('Y-m-d') . ' ' . $reservation->return_time->format('H:i:s'));
        
        return $now->gt($returnDateTime);
    }

    /**
     * Get expired pending reservations count
     */
    public static function getExpiredCount(): int
    {
        $now = now();
        
        return Reservation::where('status', 'pending')
            ->where(function ($query) use ($now) {
                $query->where('return_date', '<', $now->toDateString())
                      ->orWhere(function ($q) use ($now) {
                          $q->whereDate('return_date', '=', $now->toDateString())
                            ->whereTime('return_time', '<', $now->format('H:i:s'));
                      });
            })
            ->count();
    }
}
