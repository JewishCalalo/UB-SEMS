<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestReservation extends Model
{
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'department',
        'department_other',
        'borrow_date',
        'return_date',
        'borrow_time',
        'return_time',
        'reason_type',
        'reason',
        'additional_details',
        'cart_data',
        'token',
        'verification_code',
        'is_verified',
        'expires_at',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at' => 'datetime',
    ];
}