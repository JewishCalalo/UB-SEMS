<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReservationItem;
use App\Models\ReservationItemInstance;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'equipment_type_id',
        'description',
        'brand',
        'model',
        'quantity_total',
        'quantity_available',
        'wishlist_count',
        'condition',
        'location',
        'purchase_date',
        'last_maintenance_date',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'last_maintenance_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Computed properties to replace the removed fields
    protected $appends = ['quantity_total', 'quantity_available', 'display_name'];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function equipmentType()
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function images()
    {
        return $this->hasMany(EquipmentImage::class);
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function reservationItems()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function instances()
    {
        return $this->hasMany(EquipmentInstance::class);
    }

    public function availableInstances()
    {
        return $this->instances()
            ->where('is_available', true)
            ->where('is_active', true)
            ->whereNotIn('condition', ['lost', 'damaged', 'needs_repair', 'under_maintenance']);
    }

    /**
     * Get total quantity (computed from instances)
     */
    public function getQuantityTotalAttribute()
    {
        return $this->instances()->where('is_active', true)->count();
    }

    /**
     * Get available quantity (computed from instances)
     * Now considers current reservations to show true availability
     */
    public function getQuantityAvailableAttribute()
    {
        // Real-time physical availability based on instance flags
        return $this->instances()
            ->where('is_active', true)
            ->where('is_available', true)
            ->whereNotIn('condition', ['lost', 'damaged', 'needs_repair', 'under_maintenance'])
            ->count();
    }

    /**
     * Get display name (brand + model)
     */
    public function getDisplayNameAttribute()
    {
        $parts = array_filter([$this->brand, $this->model]);
        return implode(' ', $parts) ?: 'Unnamed Equipment';
    }

    /**
     * Recalculate and persist quantity_total and quantity_available based on instances.
     * This method is kept for backward compatibility but now uses computed properties.
     */
    public function recalculateCounts(): void
    {
        // No longer needed since we use computed properties
        // The quantities are now calculated dynamically from instances
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first() ?? $this->images()->first();
    }

    public function getAvailabilityStatusAttribute()
    {
        if ($this->quantity_available <= 0) {
            return 'unavailable';
        } elseif ($this->quantity_available < $this->quantity_total) {
            return 'limited';
        } else {
            return 'available';
        }
    }

    // Get available instances count
    public function getAvailableInstancesCountAttribute()
    {
        return $this->instances()->where('is_available', true)->where('is_active', true)->count();
    }



    /**
     * Check if enough instances are available for reservation (with double booking prevention)
     */
    public function hasAvailableInstances(int $requestedQuantity): array
    {
        $actualAvailableCount = $this->availableInstances()->count();
        
        return [
            'available' => $actualAvailableCount >= $requestedQuantity,
            'available_count' => $actualAvailableCount,
            'requested_count' => $requestedQuantity,
            'shortage' => max(0, $requestedQuantity - $actualAvailableCount)
        ];
    }

    /**
     * Get number of instances that can be booked for the given date range.
     * Uses logical (date-window) availability instead of current physical availability.
     */
    public function getBookableCount($borrowDate, $returnDate, $excludeReservationId = null): int
    {
        // Total usable instances (ignore current is_available; we are planning future booking)
        $totalGood = $this->instances()
            ->where('is_active', true)
            ->whereNotIn('condition', ['lost', 'damaged', 'needs_repair', 'under_maintenance'])
            ->count();

        // Sum quantity already reserved for overlapping windows
        // Count both actual reserved instances and pending reservation quantities
        $reservedInstances = ReservationItemInstance::whereHas('reservationItem', function ($q) {
                $q->where('equipment_id', $this->id);
            })
            ->whereHas('reservationItem.reservation', function ($q) use ($borrowDate, $returnDate) {
                $q->whereIn('status', ['approved', 'picked_up'])
                  ->where(function ($w) use ($borrowDate, $returnDate) {
                      // Overlap if NOT (new start >= existing end OR new end <= existing start)
                      // This allows same-day return and pickup
                      $w->whereDate('borrow_date', '<', $returnDate)
                        ->whereDate('return_date', '>', $borrowDate);
                  });
            })
            ->count();

        // Also count pending reservations that don't have instances assigned yet
        $pendingQuantities = ReservationItem::where('equipment_id', $this->id)
            ->whereHas('reservation', function ($q) use ($borrowDate, $returnDate, $excludeReservationId) {
                $q->where('status', 'pending')
                  ->when($excludeReservationId, function($query) use ($excludeReservationId) {
                      $query->where('id', '!=', $excludeReservationId);
                  })
                  ->where(function ($w) use ($borrowDate, $returnDate) {
                      // Overlap if NOT (new start >= existing end OR new end <= existing start)
                      // This allows same-day return and pickup
                      $w->whereDate('borrow_date', '<', $returnDate)
                        ->whereDate('return_date', '>', $borrowDate);
                  });
            })
            ->sum('quantity_requested');

        $overlapQty = $reservedInstances + $pendingQuantities;

        return max($totalGood - (int)$overlapQty, 0);
    }

    /**
     * Date-aware availability check. If dates are provided, use bookable count;
     * otherwise, fall back to current physical availability.
     */
    public function hasAvailableInstancesForDates(int $requestedQuantity, $borrowDate, $returnDate, $excludeReservationId = null): array
    {
        $bookable = $this->getBookableCount($borrowDate, $returnDate, $excludeReservationId);
        return [
            'available' => $bookable >= $requestedQuantity,
            'available_count' => $bookable,
            'requested_count' => $requestedQuantity,
            'shortage' => max(0, $requestedQuantity - $bookable)
        ];
    }

    /**
     * Atomically reserve instances for a reservation (prevents double booking)
     */
    public function reserveInstances(int $quantity): array
    {
        try {
            // Lock available instances to prevent race conditions
            $availableInstances = $this->availableInstances()
                ->lockForUpdate()
                ->limit($quantity)
                ->get();

            if ($availableInstances->count() < $quantity) {
                return [
                    'success' => false,
                    'message' => "Only {$availableInstances->count()} instances available for {$this->name}, but {$quantity} requested.",
                    'available_count' => $availableInstances->count(),
                    'instances' => collect()
                ];
            }

            return [
                'success' => true,
                'message' => "Successfully reserved {$quantity} instances of {$this->name}",
                'available_count' => $availableInstances->count(),
                'instances' => $availableInstances
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => "Failed to reserve instances: " . $e->getMessage(),
                'available_count' => 0,
                'instances' => collect()
            ];
        }
    }

    /**
     * Get the current reservation status of an equipment instance
     */
    public function getInstanceReservationStatus($instanceId)
    {
        $instance = EquipmentInstance::find($instanceId);
        
        if (!$instance) {
            return 'Unknown';
        }
        
        // If instance is damaged, needs repair, lost, or under maintenance, it's unavailable regardless of reservation status
        if (in_array($instance->condition, ['damaged', 'needs_repair', 'lost', 'under_maintenance'])) {
            return 'Unavailable';
        }
        
        // More robust: treat as engaged if there is an active assignment row not yet returned
        $reservationItemInstance = ReservationItemInstance::where('equipment_instance_id', $instanceId)
            ->whereNull('returned_at')
            ->whereHas('reservationItem.reservation', function($query) {
                $query->whereIn('status', ['pending', 'approved', 'picked_up']);
            })
            ->orderByDesc('picked_up_at')
            ->first();
            
        if ($reservationItemInstance) {
            $reservation = $reservationItemInstance->reservationItem->reservation;
            
            switch ($reservation->status) {
                case 'pending':
                case 'approved':
                    return 'Reserved';
                case 'picked_up':
                    return 'Borrowed';
                case 'returned':
                    return 'Reserved'; // Still reserved until completed
                default:
                    return 'Available';
            }
        }
        
        return 'Available';
    }

    /**
     * Clear equipment instances cache
     */
    public function clearInstancesCache()
    {
        $cacheKey = "equipment_instances_{$this->id}";
        cache()->forget($cacheKey);
    }
}
