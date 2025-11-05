<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\MissingEquipment;

class NoUnreplacedMissingEquipment implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $hasOutstanding = MissingEquipment::where('borrower_email', $value)
            ->whereIn('replacement_status', ['pending', 'not_replaced'])
            ->exists();

        if ($hasOutstanding) {
            $fail('You have unresolved missing/lost equipment. Please settle the replacement before making a new reservation.');
        }
    }
}


