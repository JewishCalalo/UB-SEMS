<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'equipment_instance_id',
        'returned_condition',
        'condition_notes',
        'quantity_returned',
        'quantity_damaged',
        'quantity_lost',
        'damage_description',

        'processed_by',
        'returned_at',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function equipmentInstance(): BelongsTo
    {
        return $this->belongsTo(EquipmentInstance::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    // Calculate total penalty for this return
    public function getTotalPenaltyAttribute(): float
    {
        $basePenalty = 0;
        
        // Additional penalties for damaged/lost items
        if ($this->quantity_damaged > 0) {
            $basePenalty += ($this->quantity_damaged * 50); // $50 penalty per damaged item
        }
        
        if ($this->quantity_lost > 0) {
            $basePenalty += ($this->quantity_lost * 100); // $100 penalty per lost item
        }
        
        return $basePenalty;
    }
}
