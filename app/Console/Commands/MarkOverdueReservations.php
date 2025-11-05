<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class MarkOverdueReservations extends Command
{
    protected $signature = 'reservations:mark-overdue';
    protected $description = 'Mark picked_up reservations past return_date as overdue and notify users';

    public function handle(): int
    {
        $this->info('Checking for overdue reservations...');
        
        // Find reservations that are picked up and past their return date
        // New logic: overdue if current date > return_date
        $overdueReservations = Reservation::where('status', 'picked_up')
            ->where('return_date', '<', now()->toDateString())
            ->with(['user', 'items.equipment'])
            ->get();
        
        $count = 0;
        
        foreach ($overdueReservations as $reservation) {
            try {
                // Update status to overdue
                $reservation->update(['status' => 'overdue']);
                
                // Send notification to user
                if ($reservation->user_id) {
                    $pickupDate = $reservation->pickup_date ? $reservation->pickup_date->format('M d, Y') : 'N/A';
                    $returnDate = $reservation->return_date->format('M d, Y');
                    
                    NotificationService::createReservationStatusNotification(
                        $reservation, 
                        'overdue', 
                        "Your equipment reservation is overdue. The equipment was due for return by {$returnDate}. Please return the equipment immediately to avoid further penalties."
                    );
                    
                    Log::info("Overdue notification sent to user {$reservation->user->email} for reservation {$reservation->reservation_code}");
                } else {
                    // For guest reservations, log the overdue status
                    Log::info("Guest reservation {$reservation->reservation_code} marked as overdue (Email: {$reservation->email})");
                }
                
                $count++;
                
            } catch (\Exception $e) {
                Log::error("Failed to mark reservation {$reservation->reservation_code} as overdue: " . $e->getMessage());
                $this->error("Failed to process reservation {$reservation->reservation_code}: " . $e->getMessage());
            }
        }
        
        if ($count > 0) {
            $this->info("Successfully marked {$count} reservations as overdue.");
            Log::info("Overdue check completed: {$count} reservations marked as overdue");
        } else {
            $this->info("No overdue reservations found.");
        }
        
        return Command::SUCCESS;
    }
}


