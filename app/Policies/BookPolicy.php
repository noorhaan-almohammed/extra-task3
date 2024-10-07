<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
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
    public function update(User $user, Book $model)
    {
        return $user->id === $model->created_by || $user->hasAnyRole(['admin', 'editor'])
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Book $model)
    {
        return $user->id === $model->created_by || $user->hasAnyRole(['admin', 'editor'])
        ? Response::allow()
        : Response::deny('You do not have permission.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Book $model)
    {
        return $user->id === $model->created_by || $user->hasAnyRole(['admin', 'editor'])
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
