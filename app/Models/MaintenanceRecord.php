<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'performed_by',
        'maintenance_date',
        'maintenance_type',
        'description',
        'notes',
        'affected_instances',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'affected_instances' => 'array',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    // performed_by is now a string field, not a foreign key
}
