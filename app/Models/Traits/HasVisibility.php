<?php

namespace App\Models\Traits;

use App\Enums\Visibility;
use App\Models\Scopes\VisibleScope;
use Illuminate\Database\Eloquent\Builder;

trait HasVisibility
{
    public function initializeHasVisibility()
    {
        $this->casts['visibility'] = Visibility::class;
    }

    public static function booted()
    {
        static::addGlobalScope(new VisibleScope);
    }

    public function scopeAnyVisibility(Builder $query)
    {
        return $query->withoutGlobalScope(VisibleScope::class);
    }

    public function scopePublic(Builder $query)
    {
        return $query->withoutGlobalScope(VisibleScope::class)->where('visibility', Visibility::PUBLIC);
    }

    public function scopePrivate(Builder $query)
    {
        return $query->withoutGlobalScope(VisibleScope::class)->where('visibility', Visibility::PRIVATE);
    }

    public function scopeHidden(Builder $query)
    {
        return $query->withoutGlobalScope(VisibleScope::class)->where('visibility', Visibility::HIDDEN);
    }

    public function getIsPublicAttribute()
    {
        return $this->visibility == Visibility::PUBLIC;
    }

    public function getIsPrivateAttribute()
    {
        return $this->visibility == Visibility::PRIVATE;
    }

    public function getIsHiddenAttribute()
    {
        return $this->visibility == Visibility::HIDDEN;
    }
}
