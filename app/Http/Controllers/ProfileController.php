<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $isCompleted = $user->first_name && $user->last_name && $user->contact_number;
        return view('admin-manager.profile.edit', [
            'user' => $user,
            'completed' => $isCompleted,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $oldEmail = $user->email;
        $newEmail = $request->validated()['email'];
        $validated = $request->validated();
        
        // Check if this is a first-time login (incomplete profile)
        $isFirstTimeLogin = !$user->first_name || !$user->last_name || !$user->contact_number;
        
        // Handle password update if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        $user->fill($validated);

        // If email is being changed, unverify it and send verification email
        if ($oldEmail !== $newEmail) {
            $user->email_verified_at = null;
            $user->save();
            
            $user->sendEmailVerificationNotification();
            
            // Log out the user when email is changed for security
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return Redirect::route('login')->with('status', 'email-verification-sent-logout');
        }

        $user->save();

        // Redirect to dashboard if this was a first-time login profile completion
        if ($isFirstTimeLogin) {
            return Redirect::route('dashboard')->with('status', 'profile-completed');
        }

        // Use global success modal (green header) with clear title
        return Redirect::route('profile.edit')
            ->with('success', 'Profile updated successfully!')
            ->with('success_title', 'Profile Updated')
            ->with('success_variant', 'banner');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Prevent admin from deleting their own account
        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Admin accounts cannot be deleted for security reasons.']);
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
