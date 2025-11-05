<?php

namespace App\Mail;

use App\Models\Equipment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public string $equipmentName;
    public ?string $categoryName;
    public ?string $typeName;

    public function __construct(public Equipment $equipment)
    {
        $this->equipmentName = $equipment->name;
        $this->categoryName = $equipment->category?->name;
        $this->typeName = $equipment->equipmentType?->name;
    }

    public function build(): self
    {
        return $this->subject('SEMS: We received your notification request')
            ->view('emails.notify-request-received');
    }
}


