<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\UbaguioEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->user();
        $isFirstTimeLogin = !$user->first_name || !$user->last_name || !$user->contact_number;
        
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
                new UbaguioEmail,
            ],
            'contact_number' => [
                'required',
                'string',
                // Philippines mobile format: 11 digits starting with 09
                'regex:/^09\d{9}$/',
                // Unique across users, ignoring current user
                Rule::unique(User::class, 'contact_number')->ignore($user->id),
            ],
            'password' => $isFirstTimeLogin ? ['required', 'string', 'min:8', 'confirmed'] : ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }
}
