<?php

namespace App\Http\Requests\Maintenance;

use Illuminate\Foundation\Http\FormRequest;

class MaintenanceRecordStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'maintenance_type' => 'required|in:routine,repair,upgrade,inspection',
            'description' => 'nullable|string|max:1000',
            'cost' => 'nullable|numeric|min:0',
            'performed_by' => 'required|string|max:255',
            'performed_date' => 'required|date|before_or_equal:today',

            'notes' => 'nullable|string|max:1000',
        ];
    }
}


