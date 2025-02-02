<?php

namespace App\Policies;

use App\Models\User;

class TagPolicy
{
    public function index(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('tag_create');
    }
}
