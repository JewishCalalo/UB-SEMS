<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_code',
        'user_id',
        'name',
        'email',
        'contact_number',
        'department',
        'borrow_date',
        'return_date',
        'borrow_time',
        'return_time',
        'status',
        'reason',
        'additional_details',
        'id_image_path',
        'remarks',
        'approved_by',
        'approved_at',
        'pickup_date',
        'picked_up_at',
        'pickup_condition',
        'pickup_notes',
        'returned_at',
        'cancelled_at',
        'created_by',
        'signature',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'borrow_time' => 'datetime:H:i',
        'return_time' => 'datetime:H:i',
        'pickup_date' => 'date',
        'approved_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'returned_at' => 'datetime',
        'cancelled_at' => 'datetime',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function equipment()
    {
        return $this->belongsToMany(Equipment::class, 'reservation_items')
            ->withPivot('quantity_requested', 'quantity_approved');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'denied' => 'red',
            'picked_up' => 'blue',
            'returned' => 'gray',
            'overdue' => 'red',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    public function getStatusTextAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Check if reservation is overdue based on return_time
     */
    public function isOverdue()
    {
        // Only check for overdue if status is 'picked_up'
        if ($this->status !== 'picked_up') {
            return false;
        }

        // Combine return_date and return_time to get the exact return datetime
        $returnDateTime = $this->return_date->format('Y-m-d') . ' ' . $this->return_time->format('H:i:s');
        $returnDateTime = \Carbon\Carbon::parse($returnDateTime);

        // Check if current time is past the return datetime
        return now()->gt($returnDateTime);
    }

    /**
     * Get the exact return datetime
     */
    public function getReturnDateTimeAttribute()
    {
        return $this->return_date->format('Y-m-d') . ' ' . $this->return_time->format('H:i:s');
    }

    /**
     * Get days overdue
     */
    public function getDaysOverdueAttribute()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $returnDateTime = $this->return_date->format('Y-m-d') . ' ' . $this->return_time->format('H:i:s');
        $returnDateTime = \Carbon\Carbon::parse($returnDateTime);

        return now()->diffInDays($returnDateTime, false);
    }

    /**
     * Get overdue status with real-time calculation
     */
    public function getOverdueStatusAttribute()
    {
        if ($this->status === 'overdue') {
            return true;
        }

        return $this->isOverdue();
    }
}
