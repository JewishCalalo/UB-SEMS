<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Reservation;

class NoOngoingReservation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if there's an ongoing reservation for this email
        $ongoingReservation = Reservation::where('email', $value)
            ->whereIn('status', ['pending', 'approved', 'picked_up'])
            ->first();

        if ($ongoingReservation) {
            $fail('You already have an ongoing reservation with this email address. Please complete or cancel your existing reservation before making a new one.');
        }
    }
}
