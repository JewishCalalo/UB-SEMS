<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, CanResetPasswordTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'contact_number',
        'department',
        'is_verified',
        'two_factor_enabled',
        'two_factor_secret',
        'last_activity',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'last_activity' => 'datetime',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function approvedReservations()
    {
        return $this->hasMany(Reservation::class, 'approved_by');
    }

    public function createdEquipment()
    {
        return $this->hasMany(Equipment::class, 'created_by');
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class, 'performed_by', 'name');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isInstructor()
    {
        return $this->role === 'instructor';
    }

    public function isUser()
    {
        // Backward compatibility: treat instructors as general users for user-level permissions
        return $this->isInstructor() || (!$this->isAdmin() && !$this->isManager());
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function hasAnyRole($roles)
    {
        return in_array($this->role, $roles);
    }

    public function getActiveReservationsCount()
    {
        return $this->reservations()
            ->whereIn('status', ['pending', 'approved', 'picked_up'])
            ->count();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

}
