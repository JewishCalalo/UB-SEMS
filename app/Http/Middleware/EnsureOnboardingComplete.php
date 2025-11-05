<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return $next($request);
        }

        // If email not verified, let existing 'verified' middleware handle it
        // Enforce profile completion: password changed from default '1' and basic details present
        $needsPasswordChange = Hash::check('1', $user->password);
        $needsDetails = empty($user->department) || empty($user->contact_number);

        $isProfileRoute = $request->routeIs('profile.edit') || $request->routeIs('profile.update');
        $isVerificationRoutes = $request->routeIs('verification.*') || $request->routeIs('logout');

        if (($needsPasswordChange || $needsDetails) && !$isProfileRoute && !$isVerificationRoutes) {
            return redirect()->route('profile.edit')->with('status', 'please-complete-profile');
        }

        return $next($request);
    }
}


