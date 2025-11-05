<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;

class ReservationStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;
    public $remarks;
    public $recipientName;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation, string $status, ?string $remarks = null, string $recipientName = null)
    {
        // Load the reservation with all necessary relationships for email display
        $this->reservation = $reservation->load([
            'items.equipment.category',
            'items.equipment.equipmentType',
            'items.reservationItemInstances.equipmentInstance',
            'user',
            'approvedBy'
        ]);
        $this->status = $status;
        $this->remarks = $remarks;
        $this->recipientName = $recipientName ?? $reservation->name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = ucfirst(str_replace('_', ' ', $this->status));
        
        return new Envelope(
            subject: "Reservation Status Updated - {$statusText}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-status-updated',
            with: [
                'reservation' => $this->reservation,
                'status' => $this->status,
                'remarks' => $this->remarks,
                'recipientName' => $this->recipientName,
            ],
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
