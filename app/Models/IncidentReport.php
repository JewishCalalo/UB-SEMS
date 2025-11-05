<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncidentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_code',
        'reservation_id',
        'equipment_id',
        'equipment_instance_id',
        'equipment_instances',
        'equipment_severities',
        'reported_by',
        'incident_type',
        'severity',
        'description',
        'student_involvement',
        'student_name',
        'student_email',
        'student_id',
        'students',
        'action_taken',
        'preventive_measures',
        'status',
        'resolution_notes',
        'resolved_by',
        'resolved_at',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
        'students' => 'array',
        'equipment_instances' => 'array',
        'equipment_severities' => 'array',
        'resolved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($incident) {
            if (empty($incident->incident_code)) {
                $incident->incident_code = 'INC-' . str_pad(IncidentReport::count() + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function equipmentInstance(): BelongsTo
    {
        return $this->belongsTo(EquipmentInstance::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function getSeverityColorAttribute(): string
    {
        return match($this->severity) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'reported' => 'blue',
            'investigating' => 'yellow',
            'resolved' => 'green',
            'closed' => 'gray',
            default => 'gray'
        };
    }
}
