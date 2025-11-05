<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestReservation extends Model
{
    protected $fillable = [
        'email',
        'token',
        'verification_code',
        'is_verified',
        'expires_at',
        // Add other fields as needed
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at' => 'datetime',
    ];
}