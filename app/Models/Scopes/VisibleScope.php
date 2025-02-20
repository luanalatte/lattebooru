<?php

namespace App\Models\Scopes;

use App\Enums\Visibility;
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
            $visibility = [Visibility::PUBLIC];

            if (isset($builder->getModel()?->permissions) && is_array($builder->getModel()->permissions)) {
                /** @var User $user */
                $user = Auth::user();

                $showHidden = $model->permissions['hidden'] ?? null;
                if ($showHidden && $user->hasPermissionTo($showHidden)) {
                    $visibility[] = Visibility::HIDDEN;
                }

                $showPrivate = $model->permissions['private'] ?? null;
                if ($showPrivate && $user->hasPermissionTo($showPrivate)) {
                    $visibility[] = Visibility::PRIVATE;
                }
            }

            if (count($visibility) === 1) {
                $builder->where(function (Builder $q) {
                    $q->where('user_id', Auth::id())->orWhere('visibility', Visibility::PUBLIC);
                });
            } elseif (count($visibility) !== count(Visibility::cases())) {
                $builder->where(function (Builder $q) use ($visibility) {
                    $q->where('user_id', Auth::id())->orWhereIn('visibility', $visibility);
                });
            }
        } else {
            $builder->where('visibility', Visibility::PUBLIC);
        }
    }
}
