<?php

namespace App\Providers;

use App\Models\Equipment;
use App\Models\Reservation;
use App\Policies\EquipmentPolicy;
use App\Policies\ReservationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Equipment::class => EquipmentPolicy::class,
        Reservation::class => ReservationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manager', function ($user) {
            return $user->isManager() || $user->isAdmin();
        });

        Gate::define('user', function ($user) {
            return $user->isUser() || $user->isManager() || $user->isAdmin();
        });

        Gate::define('instructor', function ($user) {
            // Instructors have user-level access plus any instructor-specific features
            return $user->isInstructor() || $user->isManager() || $user->isAdmin();
        });
    }
}
