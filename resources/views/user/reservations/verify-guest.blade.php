<?php

namespace App\Http\Controllers;

use App\Mail\VerifyGuestReservation;
use App\Models\GuestReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GuestVerificationController extends Controller
{
    /**
     * Create a guest reservation and send verification code.
     */
    public function create(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            // Add other reservation fields as needed
        ]);

        $code = random_int(100000, 999999);
        $token = Str::uuid();

        $reservation = GuestReservation::create([
            'email' => $request->email,
            'verification_code' => $code,
            'token' => $token,
            'is_verified' => false,
            'expires_at' => now()->addMinutes(15),
            // Add other fields here
        ]);

        Log::info('Sending verification email to: ' . $reservation->email);
        Mail::to($reservation->email)->send(new VerifyGuestReservation($reservation));

        return redirect()->route('reservations.verify-guest.page', ['token' => $token]);
    }

    /**
     * Resend verification code.
     */
    public function resend(Request $request)
    {
        $request->validate(['token' => 'required']);

        $reservation = GuestReservation::where('token', $request->token)->first();

        if (! $reservation || $reservation->is_verified) {
            return response()->json(['success' => false, 'message' => 'Invalid or already verified.']);
        }

        if (RateLimiter::tooManyAttempts('resend:' . $reservation->email, 3)) {
            return response()->json(['success' => false, 'message' => 'Please wait before resending.']);
        }

        RateLimiter::hit('resend:' . $reservation->email);

        $code = random_int(100000, 999999);
        $reservation->update([
            'verification_code' => $code,
            'expires_at' => now()->addMinutes(15),
        ]);

        Log::info('Resending verification email to: ' . $reservation->email);
        Mail::to($reservation->email)->send(new VerifyGuestReservation($reservation));

        return response()->json(['success' => true]);
    }

    /**
     * Submit verification code.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'code' => 'required|digits:6',
        ]);

        $reservation = GuestReservation::where('token', $request->token)
            ->where('verification_code', $request->code)
            ->where('expires_at', '>', now())
            ->first();

        if (! $reservation) {
            return back()->withErrors(['code' => 'Invalid or expired code.']);
        }

        $reservation->update(['is_verified' => true]);

        return redirect()->route('reservation.success');
    }
}