<?php

namespace App\Models\Scopes;

use App\Enums\PostVisibility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class VisibleScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (Auth::id()) {
            $builder->where(function (Builder $q) {
                $q->where('visibility', PostVisibility::PUBLIC)
                    ->orWhere('user_id', Auth::id());
            });
        } else {
            $builder->where('visibility', PostVisibility::PUBLIC);
        }
    }
}
