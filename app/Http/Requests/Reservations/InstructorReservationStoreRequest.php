<?php

namespace App\Http\Requests\Reservations;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UbaguioEmail;
use App\Rules\NotBlacklistedEmail;
use App\Rules\NoOngoingReservation;
use App\Rules\NoUnreplacedMissingEquipment;
use Carbon\Carbon;

class InstructorReservationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $borrowDate = $this->input('borrow_date');
        $selectedDates = $this->input('selected_dates');
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

        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', new UbaguioEmail, new NotBlacklistedEmail],
            // Accept PH mobile either 09XXXXXXXXX or +639XXXXXXXXX
            'contact_number' => ['required', 'regex:/^(09\d{9}|\+639\d{9})$/'],
            'department' => 'required|string|max:255',
            'borrow_date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
            'return_date' => $returnDateRules,
            'borrow_time' => 'required|date_format:H:i',
            'return_time' => 'required|date_format:H:i|after:borrow_time',
            'reason_type' => 'required|string|in:PE Class,Sports Training,Tournament,Practice Session,Intramural Sports,Special Event,Research/Study,Other',
            'custom_reason' => 'required_if:reason_type,Other|nullable|string|max:1000',
            'additional_details' => 'nullable|string|max:1000',
            // id_image is not required for instructors
            'cart_data' => 'required|json',
        ];
    }

}
