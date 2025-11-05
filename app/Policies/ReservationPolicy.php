<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id || 
               $user->isManager() || 
               $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isUser();
    }

    public function update(User $user, Reservation $reservation)
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function delete(User $user, Reservation $reservation)
    {
        return $user->id === $reservation->user_id || $user->isAdmin();
    }

    public function approve(User $user, Reservation $reservation)
    {
        return $user->isManager() || $user->isAdmin();
    }
}
