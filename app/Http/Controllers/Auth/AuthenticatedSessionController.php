<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\SecurityService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Log successful login
        if (Auth::check()) {
            $userId = Auth::id();
            $userEmail = Auth::user()->email;
            
            // Log security event
            SecurityService::logSecurityEvent('user_login', [
                'user_id' => $userId,
                'email' => $userEmail,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'remember_me' => $request->boolean('remember'),
            ]);
        }

        // Always redirect to dashboard - role-based routing is handled by DashboardController
        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log the logout event for security tracking
        if (Auth::check()) {
            $userId = Auth::id();
            $userEmail = Auth::user()->email;
            
            // Log security event
            SecurityService::logSecurityEvent('user_logout', [
                'user_id' => $userId,
                'email' => $userEmail,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Clear session tracking data
            SecurityService::clearSession($userId);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Clear any cached data
        $request->session()->flush();

        // Create a response with cache control headers
        $response = redirect('/');
        
        // Add headers to prevent caching of the logout page
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->headers->set('Clear-Site-Data', '"cache", "cookies", "storage"');

        return $response;
    }
}
