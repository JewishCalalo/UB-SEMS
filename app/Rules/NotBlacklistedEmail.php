<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\BlacklistedEmail;

class NotBlacklistedEmail implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value) {
            return;
        }
        $exists = BlacklistedEmail::where('email', strtolower(trim($value)))->exists();
        // Allow admins/managers/instructors to bypass blacklist
        if ($exists && auth()->check() && method_exists(auth()->user(), 'role')) {
            $role = auth()->user()->role;
            if (in_array($role, ['admin','manager','instructor'], true)) {
                return;
            }
        }
        if ($exists) {
            $fail('This email is currently blacklisted and cannot make reservations.');
        }
    }
}


