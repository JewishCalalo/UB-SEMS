<?php

namespace App\Http\Requests\Reservations;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UbaguioEmail;
use App\Rules\NotBlacklistedEmail;
use App\Rules\NoOngoingReservation;
use App\Rules\NoUnreplacedMissingEquipment;
use Carbon\Carbon;

class ReservationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $borrowDate = $this->input('borrow_date');
        $maxReturnDate = null;
        if ($borrowDate) {
            try {
                // Allow users to request up to 7 days from borrow date
                // This ensures equipment is returned within a reasonable timeframe
                $maxReturnDate = Carbon::parse($borrowDate)->addDays(7)->toDateString();
            } catch (\Exception $e) {
                $maxReturnDate = null;
            }
        }

        $returnDateRules = ['required', 'date', 'after_or_equal:borrow_date'];
        if ($maxReturnDate) {
            $returnDateRules[] = 'before_or_equal:' . $maxReturnDate;
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', new UbaguioEmail, new NotBlacklistedEmail, new NoUnreplacedMissingEquipment],
            // Accept PH mobile either 09XXXXXXXXX or +639XXXXXXXXX
            'contact_number' => ['required', 'regex:/^(09\d{9}|\+639\d{9})$/'],
            'department' => 'required|string|max:255',
            'department_other' => 'nullable|required_if:department,Other|string|max:255',
            // Allow selecting today (no minimum of tomorrow)
            'borrow_date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
            'return_date' => $returnDateRules,
            'borrow_time' => ['nullable', 'date_format:H:i'],
            'return_time' => ['nullable', 'date_format:H:i'],
            'reason' => 'required|string|max:1000',
            'additional_details' => 'nullable|string|max:1000',
            'cart_data' => 'required|json',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $borrowDate = $this->input('borrow_date');
        $validator->after(function ($validator) use ($borrowDate) {
            $borrowTime = $this->input('borrow_time');
            $returnTime = $this->input('return_time');
            if ($borrowTime) {
                [$h,$m] = array_map('intval', explode(':', $borrowTime));
                $mins = $h * 60 + $m;
                if ($mins < 480 || $mins > 1020) { // 08:00 to 17:00
                    $validator->errors()->add('borrow_time', 'Borrow time must be between 8:00 AM and 5:00 PM.');
                }
            }
            if ($returnTime) {
                [$h2,$m2] = array_map('intval', explode(':', $returnTime));
                $mins2 = $h2 * 60 + $m2;
                if ($mins2 < 480 || $mins2 > 1020) {
                    $validator->errors()->add('return_time', 'Return time must be between 8:00 AM and 5:00 PM.');
                }
            }
            if ($borrowDate && $borrowTime && $returnTime) {
                try {
                    $b = Carbon::parse($borrowDate);
                    $r = Carbon::parse($this->input('return_date'));
                    if ($b->isSameDay($r)) {
                        $diff = Carbon::parse($borrowTime)->diffInMinutes(Carbon::parse($returnTime), false);
                        if ($diff < 30) {
                            $validator->errors()->add('return_time', 'For same-day reservations, there must be at least 30 minutes between times.');
                        }
                    }
                } catch (\Exception $e) {}
            }
        });
    }
}


