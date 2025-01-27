<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Post $post): bool
    {
        if ($post->is_public) {
            return true;
        }

        if ($user === null) {
            return false;
        }

        if ($post->author->is($user)) {
            return true;
        }

        return ($post->is_hidden && $user->hasPermissionTo('post_show_hidden')) || ($post->is_private && $user->hasPermissionTo('post_show_private'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('post_create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $post->author->is($user) || $user->hasPermissionTo('post_update_others');
    }

    public function editTags(User $user, Post $post): bool
    {
        return $post->author->is($user) || $user->hasPermissionTo('post_edit_tags');
    }

    public function comment(User $user): bool
    {
        return $user->can('create', Comment::class);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $post->author->is($user) || $user->hasPermissionTo('post_delete_others');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return $post->author->is($user) || $user->hasPermissionTo('post_delete_others');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return $post->author->is($user) || $user->hasPermissionTo('post_force_delete');
    }
}
