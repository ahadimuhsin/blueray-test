<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, $id): bool
    {
        return $user->role == User::ROLE_ADMIN || $id == $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, $id): bool
    {
        return $user->role == User::ROLE_ADMIN || $id == $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->role == User::ROLE_ADMIN;
    }

}
