<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EquipmentImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'image_path',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        // Check if image_path is a base64 data URL
        if (str_starts_with($this->image_path, 'data:')) {
            return $this->image_path;
        }
        
        // Check if file exists in storage
        if (Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }
        
        // Fallback to placeholder image
        return asset('images/placeholder.jpg');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
