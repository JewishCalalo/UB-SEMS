<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'model_name',
        'old_values',
        'new_values',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the model instance that was affected
     */
    public function model()
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }
        return null;
    }

    /**
     * Get a human-readable action description
     */
    public function getActionDescriptionAttribute(): string
    {
        $actions = [
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'retired' => 'Retired',
            'restored' => 'Restored',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'picked_up' => 'Picked Up',
            'returned' => 'Returned',
            'maintenance_completed' => 'Completed Maintenance',
            'maintenance_scheduled' => 'Scheduled Maintenance',
            'bulk_added' => 'Bulk Added',
            'bulk_deleted' => 'Bulk Deleted',
            'bulk_retired' => 'Bulk Retired',
        ];

        return $actions[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get the icon for the action
     */
    public function getActionIconAttribute(): string
    {
        $icons = [
            'created' => 'M12 4v16m8-8H4',
            'updated' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            'deleted' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
            'retired' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'restored' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
            'approved' => 'M5 13l4 4L19 7',
            'rejected' => 'M6 18L18 6M6 6l12 12',
            'picked_up' => 'M7 16l-4-4m0 0l4-4m-4 4h18',
            'returned' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'maintenance_completed' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'maintenance_scheduled' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
            'bulk_added' => 'M12 4v16m8-8H4',
            'bulk_deleted' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
            'bulk_retired' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ];

        return $icons[$this->action] ?? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
    }

    /**
     * Get the color for the action
     */
    public function getActionColorAttribute(): string
    {
        $colors = [
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            'retired' => 'yellow',
            'restored' => 'green',
            'approved' => 'green',
            'rejected' => 'red',
            'picked_up' => 'blue',
            'returned' => 'gray',
            'maintenance_completed' => 'green',
            'maintenance_scheduled' => 'blue',
            'bulk_added' => 'green',
            'bulk_deleted' => 'red',
            'bulk_retired' => 'yellow',
        ];

        return $colors[$this->action] ?? 'gray';
    }
}