<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Rules\UbaguioEmail;

class ProfileUserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:admin');
    }

    public function index(Request $request)
    {
        $query = User::withCount(['reservations']);

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_verified', true);
                    break;
                case 'inactive':
                    $query->where('is_verified', false);
                    break;
                case 'verified':
                    $query->whereNotNull('email_verified_at');
                    break;
                case 'unverified':
                    $query->whereNull('email_verified_at');
                    break;
            }
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Sorting (default latest; allow created_at asc/desc)
        $sort = $request->get('sort');
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        if ($sort === 'created_at') {
            $query->orderBy('created_at', $direction);
        } else {
            $query->latest();
        }

        $perPage = max(5, min((int) $request->get('per_page', 15), 100));
        $users = $query->paginate($perPage)->appends($request->query());
        $departments = User::whereNotNull('department')->distinct()->pluck('department');
        $roles = ['instructor', 'manager', 'admin'];

        // Handle AJAX requests - return only table content
        if ($request->ajax()) {
            return view('admin.user-management.partials.table', compact('users'));
        }

        return view('admin.user-management.index', compact('users', 'departments', 'roles'));
    }

    public function show(User $user)
    {
        $user->load(['reservations.items.equipment']);
        
        $recentReservations = $user->reservations()->with('items.equipment')->latest()->limit(10)->get();
        
        // Get recent activity logs
        $recentActivities = \App\Models\ActivityLog::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->limit(20)
            ->get();
        
        $totalReservations = $user->reservations()->count();
        $pendingReservations = $user->reservations()->where('status', 'pending')->count();
        $approvedReservations = $user->reservations()->where('status', 'approved')->count();
        $lastActivity = $user->reservations()->latest()->first()?->created_at ?? $user->created_at;

        return view('admin.user-management.show', compact(
            'user', 
            'recentReservations', 
            'recentActivities',
            'totalReservations',
            'pendingReservations',
            'approvedReservations',
            'lastActivity'
        ));
    }

    public function create()
    {
        $roles = ['instructor', 'manager', 'admin'];
        $defaultRole = request('role', 'instructor');
        return view('admin.user-management.create', compact('roles', 'defaultRole'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => ['required', 'email', 'max:255', 'unique:users', new UbaguioEmail],
                'password' => 'nullable|string',
                'role' => ['required', 'string', Rule::in(['instructor', 'manager', 'admin'])],
            ]);

            // Additional validation for instructor role - only allow @e.ubaguio.edu or @ubaguio.edu
            if ($validated['role'] === 'instructor') {
                $instructorEmailPattern = '/^[A-Za-z0-9._%+-]+@(e\.ubaguio\.edu|ubaguio\.edu)$/i';
                if (!preg_match($instructorEmailPattern, $validated['email'])) {
                    return back()->withErrors(['email' => 'Instructor accounts must use @e.ubaguio.edu or @ubaguio.edu email addresses.']);
                }
            }

            $password = !empty($validated['password']) ? $validated['password'] : '1';
            $nameFromEmail = strstr($validated['email'], '@', true);
            if (!$nameFromEmail) {
                $nameFromEmail = $validated['email'];
            }

            // Ensure role is valid
            $allowedRoles = ['instructor', 'manager', 'admin'];
            $role = in_array($validated['role'], $allowedRoles) ? $validated['role'] : 'instructor';

            // Log the data we're trying to create
            \Log::info('Creating user with data:', [
                'name' => $nameFromEmail,
                'email' => $validated['email'],
                'password_provided' => !empty($validated['password']),
                'password_value' => $validated['password'],
                'final_password' => $password,
                'role' => $role,
                'is_verified' => true,
                'email_verified_at' => 'now()',
            ]);

            // Create user with explicit verification values
            $user = new User();
            $user->name = $nameFromEmail;
            $user->email = $validated['email'];
            $user->password = Hash::make($password);
            $user->role = $role;
            $user->is_verified = true; // Auto-verify admin-created users
            $user->email_verified_at = now(); // Auto-verify email for admin-created users
            $user->save();

            // Debug: Log the created user to verify the values
            \Log::info('User created successfully:', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_verified' => $user->is_verified,
                'email_verified_at' => $user->email_verified_at,
                'role' => $user->role,
            ]);

            // Auto-assign department for instructors
            if ($user->role === 'instructor') {
                $user->update(['department' => 'PE Office']);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'User created successfully']);
            }

            return redirect()->route('profile-user-management.index')
                ->with('success', 'User created successfully');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in user creation:', $e->errors());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error creating user:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'An error occurred while creating the user'], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while creating the user: ' . $e->getMessage()]);
        }
    }

    public function edit(User $user)
    {
        $roles = ['instructor', 'manager', 'admin'];
        $departments = User::whereNotNull('department')->distinct()->pluck('department');
        
        return view('admin.user-management.edit', compact('user', 'roles', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id), new UbaguioEmail],
                'role' => ['required', Rule::in(['instructor', 'manager', 'admin'])],
                'department' => 'nullable|string|max:255',
                'contact_number' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'is_verified' => 'boolean',
                'email_verified_at' => 'nullable|date',
            ]);

            $validated['is_verified'] = $request->has('is_verified') ? true : false;
            
            // Handle email verification logic
            $oldEmail = $user->email;
            $newEmail = $validated['email'];
            $emailChanged = $oldEmail !== $newEmail;
            
            if ($request->has('is_verified')) {
                // Admin manually verified the email
                $validated['email_verified_at'] = now();
            } else {
                // Admin manually unverified the email
                $validated['email_verified_at'] = null;
            }

            $user->update($validated);

            // Send verification email if email was changed
            if ($emailChanged) {
                $user->sendEmailVerificationNotification();
            }

            if ($request->ajax()) {
                $message = $emailChanged ? 
                    'User updated successfully. A verification email has been sent to the new email address.' : 
                    'User updated successfully';
                return response()->json(['success' => true, 'message' => $message]);
            }

            $successMessage = $emailChanged ? 
                'User updated successfully. A verification email has been sent to the new email address.' : 
                'User updated successfully';

            return redirect()->route('profile-user-management.show', $user)
                ->with('success', $successMessage);
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'An error occurred while updating the user'], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while updating the user']);
        }
    }

    public function updatePassword(Request $request, User $user)
    {
        try {
            // Match the form field names: new_password and new_password_confirmation
            $validated = $request->validate([
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user->update(['password' => Hash::make($validated['new_password'])]);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'User password updated successfully']);
            }

            return redirect()->route('profile-user-management.show', $user)
                ->with('success', 'User password updated successfully');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'An error occurred while updating the password'], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while updating the password']);
        }
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in(['instructor', 'manager', 'admin'])],
        ]);

        // Prevent admin from changing their own role
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot change your own role']);
        }

        $user->update($validated);

        return redirect()->route('profile-user-management.show', $user)
            ->with('success', 'User role updated successfully');
    }

    public function toggleStatus(User $user)
    {
        // Prevent admin from deactivating themselves
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot deactivate your own account']);
        }

        $user->update(['is_verified' => !$user->is_verified]);

        $status = $user->is_verified ? 'activated' : 'deactivated';
        return redirect()->route('profile-user-management.show', $user)
            ->with('success', "User account {$status} successfully");
    }


    public function destroy(Request $request, User $user)
    {
        try {
            // Prevent admin from deleting themselves
            if ($user->id === auth()->id()) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'You cannot delete your own account'], 422);
                }
                return back()->withErrors(['error' => 'You cannot delete your own account']);
            }

            // Check if user has active reservations (as the user who made the reservations)
            // Note: This only checks reservations where user_id = this user, not where approved_by = this user
            if ($user->reservations()->whereIn('status', ['pending', 'approved', 'picked_up'])->exists()) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'This user has active reservations that must be completed or cancelled before deletion.'], 422);
                }
                return back()->withErrors(['error' => 'This user has active reservations that must be completed or cancelled before deletion.']);
            }

            // Validate admin password for confirmation
            $request->validate(['password' => 'required|string']);
            if (!\Hash::check($request->password, $request->user()->password)) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Incorrect password'], 422);
                }
                return back()->withErrors(['error' => 'Incorrect password']);
            }

            // Delete user's profile picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Keep historical references: do not delete reservations or approvals
            // We only soft-delete the user to preserve relational integrity if SoftDeletes is enabled.
            // Otherwise proceed with delete but leave related records untouched.
            $user->delete();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'User deleted successfully']);
            }

            return redirect()->route('profile-user-management.index')
                ->with('success', 'User deleted successfully');
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'An error occurred while deleting the user'], 500);
            }
            return back()->withErrors(['error' => 'An error occurred while deleting the user']);
        }
    }

    public function bulkActions(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'action' => 'required|in:activate,deactivate,delete,change_role,verify_email',
            'role' => 'required_if:action,change_role|in:instructor,manager,admin',
        ]);

        $userIds = $validated['user_ids'];
        $action = $validated['action'];

        // Prevent admin from affecting themselves
        $userIds = array_filter($userIds, function($id) {
            return $id != auth()->id();
        });

        switch ($action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['is_verified' => true]);
                $message = 'Users activated successfully';
                break;
                
            case 'deactivate':
                User::whereIn('id', $userIds)->update(['is_verified' => false]);
                $message = 'Users deactivated successfully';
                break;
                
            case 'change_role':
                User::whereIn('id', $userIds)->update(['role' => $validated['role']]);
                $message = 'User roles updated successfully';
                break;
                
            case 'verify_email':
                User::whereIn('id', $userIds)->update(['email_verified_at' => now()]);
                $message = 'User emails verified successfully';
                break;
                
            case 'delete':
                // Check for active reservations
                $usersWithReservations = User::whereIn('id', $userIds)
                    ->whereHas('reservations', function($q) {
                        $q->whereIn('status', ['pending', 'approved', 'picked_up']);
                    })
                    ->pluck('name');
                
                if ($usersWithReservations->count() > 0) {
                    return back()->withErrors(['error' => 'Cannot delete users with active reservations: ' . $usersWithReservations->implode(', ')]);
                }
                
                User::whereIn('id', $userIds)->delete();
                $message = 'Users deleted successfully';
                break;
        }

        return redirect()->route('profile-user-management.index')
            ->with('success', $message);
    }

    public function exportUsers(Request $request)
    {
        $users = User::withCount(['reservations'])
            ->when($request->filled('role'), function($q) use ($request) {
                $q->where('role', $request->role);
            })
            ->when($request->filled('department'), function($q) use ($request) {
                $q->where('department', $request->department);
            })
            ->get();

        $filename = 'users-export-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'Name', 'Email', 'Role', 'Department', 'Contact Number', 'Address', 'Reservations Count', 'Status', 'Email Verified', 'Created At']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->department,
                    $user->contact_number,
                    $user->address,
                    $user->reservations_count,
    
                    $user->is_verified ? 'Active' : 'Inactive',
                    $user->email_verified_at ? 'Yes' : 'No',
                    $user->created_at
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function userActivity(User $user)
    {
        $reservations = $user->reservations()->with('items.equipment')->latest()->paginate(15);

        
        $monthlyActivity = $user->reservations()
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        return view('admin.user-management.activity', compact('user', 'reservations', 'monthlyActivity'));
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $exists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }
}
