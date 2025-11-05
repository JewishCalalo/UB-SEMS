<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'wishlist_count',
    ];

    protected $casts = [
        'wishlist_count' => 'integer',
    ];

    /**
     * Get the equipment that this wishlist entry belongs to.
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }


    /**
     * Increment the wishlist count for an equipment item.
     */
    public static function incrementCount($equipmentId)
    {
        $wishlist = self::firstOrCreate(
            ['equipment_id' => $equipmentId],
            ['wishlist_count' => 0]
        );
        
        $wishlist->increment('wishlist_count');
        return $wishlist;
    }

    /**
     * Get the wishlist count for an equipment item.
     */
    public static function getCount($equipmentId)
    {
        $wishlist = self::where('equipment_id', $equipmentId)->first();
        return $wishlist ? $wishlist->wishlist_count : 0;
    }

    /**
     * Get popular equipment (most wishlisted)
     */
    public static function getPopularEquipment($limit = 10)
    {
        return self::with('equipment')
            ->orderBy('wishlist_count', 'desc')
            ->limit($limit)
            ->get();
    }

}
