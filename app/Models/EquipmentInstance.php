<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EquipmentInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'instance_code',
        'condition',
        'condition_notes',
        'location',
        'is_available',
        'is_active',
        'last_maintenance_date',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_active' => 'boolean',
        'last_maintenance_date' => 'date',
    ];

    protected $appends = ['has_reservation_history'];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function returnLogs(): HasMany
    {
        return $this->hasMany(ReturnLog::class);
    }

    // Custom relationship to get maintenance records where this instance is affected
    // Since maintenance records store affected instances in a JSON field, we need a custom query
    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class, 'equipment_id', 'equipment_id')
            ->where(function($query) {
                $instanceId = $this->id;
                $query->whereRaw("affected_instances LIKE ?", ['%"instance_id":' . $instanceId . '%'])
                      ->orWhereRaw("affected_instances LIKE ?", ['%"instance_id": "' . $instanceId . '"%'])
                      ->orWhereRaw("affected_instances LIKE ?", ["%\"instance_id\":{$instanceId}%"]);
            });
    }

    public function retirements(): HasMany
    {
        return $this->hasMany(InstanceRetirement::class);
    }

    public function reservationItemInstances()
    {
        return $this->hasMany(ReservationItemInstance::class);
    }

    public function getHasReservationHistoryAttribute(): bool
    {
        return $this->reservationItemInstances()->exists();
    }

    /**
     * Get all reservation dates for this instance (current and future)
     */
    public function getCurrentReservationDates()
    {
        // Include any active assignment (returned_at null) regardless of start/end dates to display accurate occupancy
        $rows = $this->reservationItemInstances()
            ->whereNull('returned_at')
            ->whereHas('reservationItem.reservation', function($query) {
                $query->whereIn('status', ['pending', 'approved', 'picked_up']);
            })
            ->with('reservationItem.reservation:id,borrow_date,return_date,borrow_time,return_time,status')
            ->get();

        return $rows->map(function($item) {
                $reservation = $item->reservationItem->reservation;
                return [
                    'borrow_date' => $reservation->borrow_date,
                    'return_date' => $reservation->return_date,
                    'borrow_time' => $reservation->borrow_time,
                    'return_time' => $reservation->return_time,
                    'status' => $reservation->status,
                    'is_current' => true,
                    'is_future' => false
                ];
            });
    }

    // Generate unique code without suffix, incrementing globally per category prefix
    public static function generateInstanceCode(Equipment $equipment): string
    {
        $categoryPrefix = strtoupper(substr($equipment->category->name, 0, 3));
        // Get all existing codes with this prefix (across all equipment)
        $existingCodes = static::where('instance_code', 'like', $categoryPrefix . '-%')
            ->pluck('instance_code');

        $maxNumber = 0;
        $pattern = '/^' . preg_quote($categoryPrefix, '/') . '-(\d{3})\b/';
        foreach ($existingCodes as $code) {
            if (preg_match($pattern, $code, $matches)) {
                $num = (int) $matches[1];
                if ($num > $maxNumber) {
                    $maxNumber = $num;
                }
            }
        }

        $nextNumber = $maxNumber + 1;
        return $categoryPrefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    // Check if instance needs maintenance (based on condition)
    public function needsMaintenance(): bool
    {
        return $this->condition === 'needs_repair' || $this->condition === 'maintenance';
    }

    // Get display condition (for UI purposes)
    public function getDisplayConditionAttribute(): string
    {
        if ($this->condition === 'needs_repair' && !$this->is_available) {
            return 'Under Maintenance';
        }
        return ucfirst(str_replace('_', ' ', $this->condition));
    }

    // Set instance to maintenance status
    public function setMaintenanceStatus(string $reason = 'Equipment returned with issues'): bool
    {
        $changes = [
            'is_available' => false,
            'condition' => 'needs_repair'
        ];

        $this->update($changes);
        
        // Create maintenance record
        \App\Models\MaintenanceRecord::create([
            'equipment_id' => $this->equipment_id,
            'maintenance_type' => 'status_based',
            'maintenance_date' => now(),
            'description' => $reason,
            'performed_by' => auth()->user()->name,
            'affected_instances' => [
                [
                    'instance_id' => $this->id,
                    'instance_code' => $this->instance_code,
                    'old_condition' => $this->getOriginal('condition'),
                    'new_condition' => 'needs_repair',
                    'location' => $this->location ?? 'Not specified',
                    'notes' => $reason
                ]
            ]
        ]);

        // Recalculate equipment counts
        $this->equipment->recalculateCounts();
        
        return true;
    }

    // Complete maintenance and restore availability
    public function completeMaintenance(string $description = 'Maintenance completed'): bool
    {
        $changes = [
            'is_available' => true,
            'condition' => 'good',
            'last_maintenance_date' => now()
        ];

        $this->update($changes);
        
        // Create maintenance completion record
        \App\Models\MaintenanceRecord::create([
            'equipment_id' => $this->equipment_id,
            'maintenance_type' => 'completion',
            'maintenance_date' => now(),
            'description' => $description,
            'performed_by' => auth()->user()->name,
            'affected_instances' => [
                [
                    'instance_id' => $this->id,
                    'instance_code' => $this->instance_code,
                    'old_condition' => $this->getOriginal('condition'),
                    'new_condition' => 'good',
                    'location' => $this->location ?? 'Not specified',
                    'notes' => $description
                ]
            ]
        ]);

        // Recalculate equipment counts
        $this->equipment->recalculateCounts();
        
        return true;
    }
}
