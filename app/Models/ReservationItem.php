<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'equipment_id',
        'quantity_requested',
        'quantity_approved',
    ];

    protected $casts = [
        'quantity_requested' => 'integer',
        'quantity_approved' => 'integer',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function instances()
    {
        return $this->hasMany(ReservationItemInstance::class);
    }

    public function reservationItemInstances()
    {
        return $this->hasMany(ReservationItemInstance::class);
    }
}
