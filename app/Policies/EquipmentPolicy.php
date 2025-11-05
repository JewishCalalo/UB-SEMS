<?php

namespace App\Policies;

use App\Models\Equipment;
use App\Models\User;

class EquipmentPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Equipment $equipment)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function update(User $user, Equipment $equipment)
    {
        return $user->isManager() || $user->isAdmin();
    }

    public function delete(User $user, Equipment $equipment)
    {
        return $user->isAdmin();
    }
}
