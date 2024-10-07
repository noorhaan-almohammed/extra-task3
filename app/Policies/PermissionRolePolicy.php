<?php

namespace App\Policies;

use App\Models\PermissionRole;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionRolePolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not have permission.');
    }
}
