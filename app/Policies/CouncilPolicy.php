<?php

namespace App\Policies;

use App\Models\Council;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CouncilPolicy
{

    public function before(User $user, $ability): ?bool
    {
        if ($user->admin) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Council $council): bool
    {
        return $user->councils->contains($council) || $user->admin;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Council $council): bool
    {
        return $user->councils->contains($council) || $user->admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Council $council): bool
    {
        return $user->admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Council $council): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Council $council): bool
    {
        //
    }
}
