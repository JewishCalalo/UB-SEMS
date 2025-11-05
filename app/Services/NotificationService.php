<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\User;
use App\Mail\ReservationCreatedMail;
use App\Mail\ReservationStatusUpdatedMail;
use App\Mail\ReservationOverdueMail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    public static function createReservationCreatedNotification(Reservation $reservation)
    {
        // Send email notification
        $emailToSend = null;
        $userName = null;

        if ($reservation->user && $reservation->user->email) {
            // Authenticated user with email
            $emailToSend = $reservation->user->email;
            $userName = $reservation->user->name;
        } elseif ($reservation->email) {
            // Guest user with email
            $emailToSend = $reservation->email;
            $userName = $reservation->name;
        }

        if ($emailToSend) {
            self::sendReservationCreatedEmail($reservation, $emailToSend, $userName);
        }
    }

    public static function createReservationStatusNotification(Reservation $reservation, string $status, ?string $remarks = null)
    {
        // Skip sending email for completed status - completion should be handled separately
        if ($status === 'completed') {
            \Log::info("Skipping status update email for completed reservation {$reservation->reservation_code} - completion should be handled separately");
            return;
        }

        $statusMessages = [
            'approved' => 'Your reservation has been approved!',
            'denied' => 'Your reservation has been denied.',
            'picked_up' => 'Your equipment has been picked up.',
            'returned' => 'Your equipment has been returned.',
            'completed' => 'Your reservation has been completed.'
        ];

        $message = $statusMessages[$status] ?? "Your reservation status has been updated to: {$status}";
        
        if ($remarks) {
            $message .= "\n\nRemarks: {$remarks}";
        }

        // Send email notification to both authenticated users and guest users
        $emailToSend = null;
        $userName = null;

        if ($reservation->user && $reservation->user->email) {
            // Authenticated user with email
            $emailToSend = $reservation->user->email;
            $userName = $reservation->user->name;
            \Log::info("Sending notification to authenticated user: {$emailToSend} for reservation {$reservation->reservation_code}");
        } elseif ($reservation->email) {
            // Guest user with email
            $emailToSend = $reservation->email;
            $userName = $reservation->name;
            \Log::info("Sending notification to guest user: {$emailToSend} for reservation {$reservation->reservation_code}");
        } else {
            \Log::warning("No email found for reservation {$reservation->reservation_code} - user_id: {$reservation->user_id}, guest_email: {$reservation->email}");
        }

        if ($emailToSend) {
            \Log::info("Attempting to send status update email to {$emailToSend} for reservation {$reservation->reservation_code} with status: {$status}");
            self::sendReservationStatusEmail($reservation, $status, $remarks, $emailToSend, $userName);
        } else {
            \Log::warning("Cannot send email notification - no valid email address found for reservation {$reservation->reservation_code}");
        }
    }

    private static function sendReservationCreatedEmail(Reservation $reservation, string $email, ?string $userName = null)
    {
        $recipientName = $userName ?? ($reservation->user ? $reservation->user->name : $reservation->name);

        try {
            // Send email using the new Mailable class
            Mail::to($email)->send(new ReservationCreatedMail($reservation, $recipientName));

            // Log successful email sending
            \Log::info("Reservation created email sent successfully to {$email} for reservation {$reservation->reservation_code}");
        } catch (\Exception $e) {
            // Log email sending errors but don't break the application
            \Log::error('Failed to send reservation created email: ' . $e->getMessage(), [
                'reservation_id' => $reservation->id,
                'email' => $email
            ]);
        }
    }

    private static function sendReservationStatusEmail(Reservation $reservation, string $status, ?string $remarks = null, string $email = null, ?string $userName = null)
    {
        // Use provided email or fall back to user's email
        $emailToSend = $email ?? ($reservation->user ? $reservation->user->email : $reservation->email);
        $recipientName = $userName ?? ($reservation->user ? $reservation->user->name : $reservation->name);

        if (!$emailToSend) {
            \Log::warning("No email address provided for reservation status email");
            return;
        }

        \Log::info("Preparing to send reservation status email", [
            'reservation_id' => $reservation->id,
            'reservation_code' => $reservation->reservation_code,
            'email' => $emailToSend,
            'recipient_name' => $recipientName,
            'status' => $status,
            'remarks' => $remarks
        ]);

        try {
            // Send email using the new Mailable class
            Mail::to($emailToSend)->send(new ReservationStatusUpdatedMail($reservation, $status, $remarks, $recipientName));

            // Log successful email sending
            \Log::info("Reservation status email sent successfully to {$emailToSend} for reservation {$reservation->reservation_code}");
        } catch (\Exception $e) {
            // Log email sending errors but don't break the application
            \Log::error('Failed to send reservation status email: ' . $e->getMessage(), [
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'email' => $emailToSend,
                'status' => $status,
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Notify maintenance staff about overdue maintenance
     */
    public static function notifyMaintenanceOverdue(EquipmentInstance $instance): void
    {
        try {
            $equipment = $instance->equipment;
            $daysOverdue = $instance->getDaysUntilMaintenance() * -1; // Convert to positive number
            
            $subject = "🚨 MAINTENANCE OVERDUE: {$equipment->display_name} - {$instance->instance_code}";
            $message = "Equipment instance {$instance->instance_code} for {$equipment->display_name} is {$daysOverdue} days overdue for maintenance.\n\n";
            $message .= "Details:\n";
            $message .= "- Equipment: {$equipment->display_name}\n";
            $message .= "- Category: {$equipment->category->name}\n";
            $message .= "- Instance Code: {$instance->instance_code}\n";
            $message .= "- Last Maintenance: " . ($instance->last_maintenance_date ? $instance->last_maintenance_date->format('Y-m-d') : 'Never') . "\n";
            $message .= "- Days Overdue: {$daysOverdue}\n";
            $message .= "- Current Status: " . ($instance->is_available ? 'Available' : 'Unavailable') . "\n\n";
            $message .= "Please schedule maintenance immediately to prevent equipment failure.";

            // Send to all maintenance staff (managers and admins)
            $maintenanceStaff = User::whereIn('role', ['manager', 'admin'])->get();
            
            foreach ($maintenanceStaff as $staff) {
                if ($staff->email) {
                    Mail::raw($message, function($mail) use ($staff, $subject) {
                        $mail->to($staff->email)
                             ->subject($subject);
                    });
                }
            }

            \Log::info('Maintenance overdue notification sent', [
                'instance_id' => $instance->id,
                'equipment_name' => $equipment->display_name,
                'days_overdue' => $daysOverdue
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to send maintenance overdue notification', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Notify maintenance staff about upcoming maintenance
     */
    public static function notifyMaintenanceDueSoon(EquipmentInstance $instance): void
    {
        try {
            $equipment = $instance->equipment;
            $daysUntilMaintenance = $instance->getDaysUntilMaintenance();
            
            $subject = "🔔 MAINTENANCE DUE SOON: {$equipment->display_name} - {$instance->instance_code}";
            $message = "Equipment instance {$instance->instance_code} for {$equipment->display_name} will need maintenance in {$daysUntilMaintenance} days.\n\n";
            $message .= "Details:\n";
            $message .= "- Equipment: {$equipment->display_name}\n";
            $message .= "- Category: {$equipment->category->name}\n";
            $message .= "- Instance Code: {$instance->instance_code}\n";
            $message .= "- Last Maintenance: " . ($instance->last_maintenance_date ? $instance->last_maintenance_date->format('Y-m-d') : 'Never') . "\n";
            $message .= "- Next Maintenance Due: " . ($instance->getNextMaintenanceDate() ? $instance->getNextMaintenanceDate()->format('Y-m-d') : 'N/A') . "\n";
            $message .= "- Days Until Due: {$daysUntilMaintenance}\n\n";
            $message .= "Please schedule maintenance to prevent overdue status.";

            // Send to all maintenance staff (managers and admins)
            $maintenanceStaff = User::whereIn('role', ['manager', 'admin'])->get();
            
            foreach ($maintenanceStaff as $staff) {
                if ($staff->email) {
                    Mail::raw($message, function($mail) use ($staff, $subject) {
                        $mail->to($staff->email)
                             ->subject($subject);
                    });
                }
            }

            \Log::info('Maintenance due soon notification sent', [
                'instance_id' => $instance->id,
                'equipment_name' => $equipment->display_name,
                'days_until_maintenance' => $daysUntilMaintenance
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to send maintenance due soon notification', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public static function sendOverdueReservationEmail(Reservation $reservation)
    {
        try {
            $emailToSend = null;
            $userName = null;

            if ($reservation->user && $reservation->user->email) {
                // Authenticated user with email
                $emailToSend = $reservation->user->email;
                $userName = $reservation->user->name;
            } elseif ($reservation->email) {
                // Guest user with email
                $emailToSend = $reservation->email;
                $userName = $reservation->name;
            }

            if ($emailToSend) {
                Mail::to($emailToSend)->send(new ReservationOverdueMail($reservation));
                
                \Log::info('Overdue reservation email sent', [
                    'reservation_id' => $reservation->id,
                    'reservation_code' => $reservation->reservation_code,
                    'email' => $emailToSend,
                    'user_name' => $userName
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send overdue reservation email', [
                'reservation_id' => $reservation->id,
                'reservation_code' => $reservation->reservation_code,
                'error' => $e->getMessage()
            ]);
        }
    }
}
