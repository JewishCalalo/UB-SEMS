<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendOverdueReminders extends Command
{
    protected $signature = 'reservations:send-overdue-reminders';
    protected $description = 'Send reminder notifications to users with overdue reservations';

    public function handle(): int
    {
        $this->info('Sending overdue reminders...');
        
        // Find overdue reservations
        $overdueReservations = Reservation::where('status', 'overdue')
            ->with(['user', 'items.equipment'])
            ->get();
        
        $count = 0;
        
        foreach ($overdueReservations as $reservation) {
            try {
                // Calculate days overdue based on return date
                $returnDate = Carbon::parse($reservation->return_date);
                $daysOverdue = now()->diffInDays($returnDate, false);
                
                if ($daysOverdue > 0) {
                    // Send reminder notification to user
                    if ($reservation->user_id) {
                        $returnDateFormatted = $returnDate->format('M d, Y');
                        
                        $message = "REMINDER: Your equipment reservation is {$daysOverdue} day(s) overdue. ";
                        $message .= "The equipment was due for return by {$returnDateFormatted}. ";
                        $message .= "Please return the equipment immediately to avoid penalties and account restrictions.";
                        
                        // Send detailed overdue email
                        NotificationService::sendOverdueReservationEmail($reservation);
                        
                        // Also send in-app notification
                        NotificationService::createReservationStatusNotification(
                            $reservation, 
                            'overdue_reminder', 
                            $message
                        );
                        
                        Log::info("Overdue reminder sent to user {$reservation->user->email} for reservation {$reservation->reservation_code} ({$daysOverdue} days overdue)");
                    } else {
                        // For guest reservations, log the reminder
                        Log::info("Guest reservation {$reservation->reservation_code} overdue reminder ({$daysOverdue} days overdue, Email: {$reservation->email})");
                    }
                    
                    $count++;
                }
                
            } catch (\Exception $e) {
                Log::error("Failed to send overdue reminder for reservation {$reservation->reservation_code}: " . $e->getMessage());
                $this->error("Failed to process reservation {$reservation->reservation_code}: " . $e->getMessage());
            }
        }
        
        if ($count > 0) {
            $this->info("Successfully sent {$count} overdue reminders.");
            Log::info("Overdue reminders completed: {$count} reminders sent");
        } else {
            $this->info("No overdue reminders to send.");
        }
        
        return Command::SUCCESS;
    }
}
