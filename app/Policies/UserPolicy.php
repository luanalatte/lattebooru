<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function index(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        if ($user === null) {
            return config('auth.enable_account_creation');
        }

        return $user->hasPermissionTo('user_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $model->is($user);
    }
}
