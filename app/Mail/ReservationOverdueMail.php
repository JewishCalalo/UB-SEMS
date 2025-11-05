<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationOverdueMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $daysOverdue;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        // Load the reservation with all necessary relationships for email display
        $this->reservation = $reservation->load([
            'items.equipment.category',
            'items.equipment.equipmentType',
            'items.reservationItemInstances.equipmentInstance',
            'user',
            'approvedBy'
        ]);
        
        // Calculate days overdue based on return date
        $returnDate = Carbon::parse($reservation->return_date);
        $this->daysOverdue = now()->diffInDays($returnDate, false);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "URGENT: Equipment Reservation Overdue - {$this->reservation->reservation_code}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-overdue',
            with: [
                'reservation' => $this->reservation,
                'daysOverdue' => $this->daysOverdue,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Threading headers for conversation grouping.
     */
    // Using default headers (no threading)
}
