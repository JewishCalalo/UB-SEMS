<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthCheckController extends Controller
{
    /**
     * Check if the user is still authenticated.
     */
    public function check(Request $request): JsonResponse
    {
        if (Auth::check()) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => Auth::id(),
                    'email' => Auth::user()->email,
                    'name' => Auth::user()->name
                ]
            ]);
        }

        return response()->json([
            'authenticated' => false
        ], 401);
    }
}
