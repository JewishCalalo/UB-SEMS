<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentType extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
    ];

    /**
     * Get the category that owns the equipment type.
     */
    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    /**
     * Get the equipment for this type.
     */
    public function equipment()
    {
        return $this->hasMany(Equipment::class, 'equipment_type_id');
    }

    /**
     * Get equipment instances for this type.
     */
    public function equipmentInstances()
    {
        return $this->hasManyThrough(EquipmentInstance::class, Equipment::class);
    }
}
