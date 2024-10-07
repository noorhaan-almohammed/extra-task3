<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'editor']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user)
    {
        return $user->hasAnyRole(['admin', 'editor'])
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return $user->hasAnyRole(['admin', 'editor'])
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user)
    {
        return $user->hasAnyRole(['admin', 'editor'])
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user)
    {
        return $user->hasAnyRole(['admin', 'editor'])
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user)
    {
        return $user->hasAnyRole(['admin', 'editor'])
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user)
    {
        return $user->hasRole('admin')
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }
}
