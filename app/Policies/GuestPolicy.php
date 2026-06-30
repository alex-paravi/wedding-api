<?php

namespace App\Policies;

use App\Models\Guest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GuestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Guest $guest): bool
    {
        // Администратор может смотреть любого гостя, 
        // а обычный юзер — только того, кого создал сам
        return $user->role === 'admin' || $user->id === $guest->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Guest $guest): bool
    {
        if ($user->role === 'admin') {
            return true;
        }
        return $user->id === $guest->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Guest $guest): bool
    {
        if ($user->role === 'admin') {
            return true;
        }
        return $user->id === $guest->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Guest $guest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Guest $guest): bool
    {
        return false;
    }
}
