<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SecurityService
{
    /**
     * Log security event
     */
    public static function logSecurityEvent(string $event, array $data = []): void
    {
        $logData = array_merge([
            'event' => $event,
            'timestamp' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $data);

        if (Auth::check()) {
            $logData['user_id'] = Auth::id();
            $logData['user_email'] = Auth::user()->email;
        }

        Log::channel('security')->info('Security Event', $logData);
    }

    /**
     * Track user session
     */
    public static function trackSession(string $action): void
    {
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();
        $sessionKey = "user_session_{$userId}";
        
        $sessionData = [
            'user_id' => $userId,
            'last_activity' => now(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        Cache::put($sessionKey, $sessionData, now()->addMinutes(30));
    }

    /**
     * Validate session integrity
     */
    public static function validateSession(Request $request): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $userId = Auth::id();
        $sessionKey = "user_session_{$userId}";
        $sessionData = Cache::get($sessionKey);

        if (!$sessionData) {
            self::logSecurityEvent('session_not_found', ['user_id' => $userId]);
            return false;
        }

        // Check if IP address changed (potential session hijacking)
        if ($sessionData['ip_address'] !== $request->ip()) {
            self::logSecurityEvent('ip_address_mismatch', [
                'user_id' => $userId,
                'stored_ip' => $sessionData['ip_address'],
                'current_ip' => $request->ip()
            ]);
            return false;
        }

        // Update session activity
        self::trackSession('page_access');

        return true;
    }

    /**
     * Clear user session data
     */
    public static function clearSession(int $userId): void
    {
        $sessionKey = "user_session_{$userId}";
        Cache::forget($sessionKey);
        
        self::logSecurityEvent('session_cleared', ['user_id' => $userId]);
    }

    /**
     * Check for suspicious activity
     */
    public static function checkSuspiciousActivity(Request $request): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $userId = Auth::id();
        $key = "failed_attempts_{$userId}";
        $failedAttempts = Cache::get($key, 0);

        // If too many failed attempts, log as suspicious
        if ($failedAttempts > 5) {
            self::logSecurityEvent('suspicious_activity_detected', [
                'user_id' => $userId,
                'failed_attempts' => $failedAttempts,
                'ip_address' => $request->ip()
            ]);
            return true;
        }

        return false;
    }
}
