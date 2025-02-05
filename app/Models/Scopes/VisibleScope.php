<?php

namespace App\Models\Scopes;

use App\Enums\PostVisibility;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class VisibleScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::id()) {
            /** @var User $user */
            $user = Auth::user();

            $visibility = [PostVisibility::PUBLIC];
            if ($user->hasPermissionTo('post_show_hidden')) {
                $visibility[] = PostVisibility::HIDDEN;
            }

            if ($user->hasPermissionTo('post_show_private')) {
                $visibility[] = PostVisibility::PRIVATE;
            }

            if (count($visibility) == 1) {
                $builder->where(function (Builder $q) use ($visibility) {
                    $q->where('user_id', Auth::id())->orWhere('visibility', $visibility[0]);
                });
            } else {
                $builder->where(function (Builder $q) use ($visibility) {
                    $q->where('user_id', Auth::id())->orWhereIn('visibility', $visibility);
                });
            }

        } else {
            $builder->where('visibility', PostVisibility::PUBLIC);
        }
    }
}
