<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishlistNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'email',
        'name',
        'contact',
        'status',
        'notified_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
    ];

    const STATUSES = [
        'active' => 'Active',
        'notified' => 'Notified',
        'cancelled' => 'Cancelled',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public static function getActiveSubscriptions($equipmentId)
    {
        return static::where('equipment_id', $equipmentId)
            ->where('status', 'active')
            ->get();
    }

    public function markAsNotified()
    {
        $this->update([
            'status' => 'notified',
            'notified_at' => now(),
        ]);
    }
}
