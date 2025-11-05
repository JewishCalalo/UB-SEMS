<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Wishlist;
use App\Models\WishlistNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotifyRequestReceived;
use Illuminate\Support\Facades\Cache;

class WishlistController extends Controller
{
    /**
     * Add equipment to wishlist (increments popularity count, prevents duplicates for all users)
     */
    public function add(Request $request, Equipment $equipment)
    {
        try {
            // Check if user has already added this equipment to wishlist
            if (auth()->check()) {
                // For authenticated users, check if they've already added this equipment
                $userId = auth()->id();
                $sessionKey = 'user_wishlist_' . $userId . '_' . $equipment->id;
                
                if (session()->has($sessionKey)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already added this equipment to your wishlist'
                    ], 400);
                }
                
                // Mark this equipment as wishlisted for this user session
                session()->put($sessionKey, true);
            } else {
                // For guests, check if they've already added this equipment to wishlist in this session
                $sessionKey = 'guest_wishlist_' . $equipment->id;
                
                if (session()->has($sessionKey)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already added this equipment to your wishlist'
                    ], 400);
                }
                
                // Mark this equipment as wishlisted for this guest session
                session()->put($sessionKey, true);
            }
            
            // Increment the wishlist count for this equipment
            Wishlist::incrementCount($equipment->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Equipment added to wishlist',
                'wishlist_count' => Wishlist::getCount($equipment->id)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add to wishlist'
            ], 500);
        }
    }

    /**
     * Get wishlist count for equipment
     */
    public function getCount(Equipment $equipment)
    {
        $count = Wishlist::getCount($equipment->id);
        
        return response()->json([
            'equipment_id' => $equipment->id,
            'wishlist_count' => $count
        ]);
    }

    /**
     * Subscribe to email notifications when equipment becomes available
     */
    public function notify(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', new \App\Rules\UbaguioEmail],
            'name' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
        ]);

        try {
            // Prevent duplicate notification requests for same equipment + email for 30 days (no DB storage)
            $email = $validated['email'];
            $cacheKey = 'notify_request:' . $equipment->id . ':' . strtolower($email);
            if (Cache::has($cacheKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email is already subscribed for notifications for this equipment. Please try a different email or check back later.'
                ], 400);
            }

            // Mail-only flow: send a branded acknowledgement email
            Mail::to($email)->send(new NotifyRequestReceived($equipment));

            // Mark this email+equipment as recently requested for 30 days
            Cache::put($cacheKey, true, now()->addDays(30));

            // Optionally increment wishlist interest count (no identity stored)
            Wishlist::incrementCount($equipment->id);

            return response()->json([
                'success' => true,
                'message' => 'We sent a confirmation to your email. We do not store your email.',
                'wishlist_count' => Wishlist::getCount($equipment->id)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to subscribe to notifications: ' . $e->getMessage()
            ], 500);
        }
    }
}
