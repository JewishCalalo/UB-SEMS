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

class ReservationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $recipientName;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation, string $recipientName = null)
    {
        // Load the reservation with all necessary relationships for email display
        $this->reservation = $reservation->load([
            'items.equipment.category',
            'items.equipment.equipmentType',
            'items.reservationItemInstances.equipmentInstance',
            'user',
            'approvedBy'
        ]);
        $this->recipientName = $recipientName ?? $reservation->name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservation Created - SEMS System',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-created',
            with: [
                'reservation' => $this->reservation,
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
     * Add headers to help email clients thread messages by reservation.
     */
    // Using default headers (no threading) for individual emails
}
