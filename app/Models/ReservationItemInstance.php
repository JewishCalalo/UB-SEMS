<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationItemInstance extends Model
{
	use HasFactory;

	protected $fillable = [
		'reservation_item_id',
		'equipment_instance_id',
		'status',
		'picked_up_at',
		'returned_at',
		'pickup_condition',
		'pickup_notes',
		'returned_condition',
		'returned_notes',
	];

	protected $casts = [
		'picked_up_at' => 'datetime',
		'returned_at' => 'datetime',
	];

	public function reservationItem(): BelongsTo
	{
		return $this->belongsTo(ReservationItem::class);
	}

	public function equipmentInstance(): BelongsTo
	{
		return $this->belongsTo(EquipmentInstance::class);
	}
}


