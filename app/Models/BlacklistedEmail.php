<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistedEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'missing_equipment_id',
        'reason',
        'added_by',
        'added_at',
    ];
}


