<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MarkExpiredReservations extends Command
{
    protected $signature = 'reservations:mark-expired';
    protected $description = 'Mark pending reservations as expired when their return date has passed';

    public function handle(): int
    {
        $this->info('Checking for expired pending reservations...');
        
        $now = now();
        
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
        
        $count = 0;
        
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
                
                $count++;
                
            } catch (\Exception $e) {
                Log::error("Failed to mark reservation {$reservation->reservation_code} as expired: " . $e->getMessage());
                $this->error("Failed to process reservation {$reservation->reservation_code}: " . $e->getMessage());
            }
        }
        
        if ($count > 0) {
            $this->info("Successfully marked {$count} pending reservations as expired.");
            Log::info("Expired reservation check completed: {$count} reservations marked as cancelled");
        } else {
            $this->info("No expired pending reservations found.");
        }
        
        return Command::SUCCESS;
    }
}
