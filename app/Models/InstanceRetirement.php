<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstanceRetirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_instance_id',
        'reason',
        'notes',
        'acted_by',
        'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
    ];

    public function equipmentInstance(): BelongsTo
    {
        return $this->belongsTo(EquipmentInstance::class);
    }

    public function actedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acted_by');
    }
}


