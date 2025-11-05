<?php

namespace App\Http\Requests\Reservations;

use Illuminate\Foundation\Http\FormRequest;

class ReservationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:approved,denied,picked_up,returned,completed',
            'remarks' => 'nullable|string|max:1000',
            'pickup_date' => ['nullable', 'date', 'after_or_equal:' . now()->toDateString()],
        ];
    }
}


