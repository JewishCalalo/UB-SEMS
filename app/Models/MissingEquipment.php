<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MissingEquipment extends Model
{
    use HasFactory;

    protected $table = 'missing_equipment';

    protected $fillable = [
        'equipment_instance_id',
        'reservation_id',
        'incident_id',
        'borrower_name',
        'borrower_email',
        'borrower_contact_number',
        'borrower_department',
        'incident_date',
        'incident_type',
        'incident_description',
        'replacement_status',
        'replacement_date',
        'acted_by',
        'acted_at',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'replacement_date' => 'date',
        'acted_at' => 'datetime',
    ];

    // Relationships
    public function equipmentInstance(): BelongsTo
    {
        return $this->belongsTo(EquipmentInstance::class);
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function actedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'acted_by');
    }

    public function incidentReport(): BelongsTo
    {
        return $this->belongsTo(IncidentReport::class, 'incident_id');
    }

    // Accessors
    public function getIncidentTypeTextAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->incident_type));
    }

    public function getReplacementStatusTextAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->replacement_status));
    }

    public function getReplacementStatusColorAttribute(): string
    {
        return match($this->replacement_status) {
            'pending' => 'yellow',
            'replaced' => 'green',
            'not_replaced' => 'red',
            default => 'gray',
        };
    }

    public function getIncidentTypeColorAttribute(): string
    {
        return match($this->incident_type) {
            'stolen' => 'red',
            'lost' => 'orange',
            'damaged' => 'blue',
            'not_returned' => 'yellow',
            default => 'gray',
        };
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('replacement_status', 'pending');
    }

    public function scopeReplaced($query)
    {
        return $query->where('replacement_status', 'replaced');
    }

    public function scopeNotReplaced($query)
    {
        return $query->where('replacement_status', 'not_replaced');
    }

    public function scopeByIncidentType($query, $type)
    {
        return $query->where('incident_type', $type);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('incident_date', [$startDate, $endDate]);
    }

    // Methods
    public function markAsReplaced($replacementDate = null): bool
    {
        try {
            DB::beginTransaction();
            
            // Update the stolen/lost equipment record
            $this->update([
                'replacement_status' => 'replaced',
                'replacement_date' => $replacementDate ?? now(),
            ]);

            // Option B: Restore the original equipment instance
            if ($this->equipmentInstance) {
                $this->equipmentInstance->update([
                    'condition' => 'good',
                    'is_available' => true,
                    'condition_notes' => 'Equipment restored - marked as replaced on ' . ($replacementDate ?? now())->format('Y-m-d'),
                ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to mark equipment as replaced: ' . $e->getMessage());
            throw $e;
        }
    }

    public function markAsNotReplaced(): bool
    {
        $this->update([
            'replacement_status' => 'not_replaced',
        ]);

        return true;
    }

    // Static methods for creating records
    public static function createFromReturnLog(ReturnLog $returnLog, $incidentType, $description = null): self
    {
        $reservation = $returnLog->reservation;
        
        return self::create([
            'equipment_instance_id' => $returnLog->equipment_instance_id,
            'reservation_id' => $reservation->id,
            'borrower_name' => $reservation->name,
            'borrower_email' => $reservation->email,
            'borrower_contact_number' => $reservation->contact_number,
            'borrower_department' => $reservation->department,
            'incident_date' => $returnLog->returned_at->toDateString(),
            'incident_type' => $incidentType,
            'incident_description' => $description,
            'acted_by' => auth()->id(),
            'acted_at' => now(),
        ]);
    }
}
