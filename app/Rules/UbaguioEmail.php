<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UbaguioEmail implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Accept any local part as long as the domain is s.ubaguio.edu, e.ubaguio.edu, or ubaguio.edu
        $pattern = '/^[A-Za-z0-9._%+-]+@(s\.ubaguio\.edu|e\.ubaguio\.edu|ubaguio\.edu)$/i';
        
        if (!preg_match($pattern, $value)) {
            $fail('The :attribute must end with @s.ubaguio.edu, @e.ubaguio.edu, or @ubaguio.edu.');
        }
    }
}
