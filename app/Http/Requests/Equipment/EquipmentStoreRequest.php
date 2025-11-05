<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'category_id' => 'required|exists:equipment_categories,id',
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'description' => 'nullable|string|max:1000',
            'quantity_total' => 'required|integer|min:1',
            'quantity_available' => 'nullable|integer|min:0',
            'condition' => 'required|in:excellent,good,fair',
            'location' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}


