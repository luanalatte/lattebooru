<?php

namespace App\Models\Traits;

use App\Enums\PostVisibility;
use App\Models\Scopes\VisibleScope;
use Illuminate\Database\Eloquent\Builder;

trait HasVisibility
{
    public function initializeHasVisibility()
    {
        if (! isset($this->casts['visibility'])) {
            $this->casts['visibility'] = PostVisibility::class;
        }
    }

    public static function booted()
    {
        static::addGlobalScope(new VisibleScope);
    }

    public function scopePublic(Builder $query)
    {
        return $query->withoutGlobalScope(VisibleScope::class)->where('visibility', PostVisibility::PUBLIC);
    }

    public function scopePrivate(Builder $query)
    {
        return $query->withoutGlobalScope(VisibleScope::class)->where('visibility', PostVisibility::PRIVATE);
    }

    public function scopeHidden(Builder $query)
    {
        return $query->withoutGlobalScope(VisibleScope::class)->where('visibility', PostVisibility::HIDDEN);
    }

    public function getIsPublicAttribute()
    {
        return $this->visibility == PostVisibility::PUBLIC;
    }

    public function getIsPrivateAttribute()
    {
        return $this->visibility == PostVisibility::PRIVATE;
    }

    public function getIsHiddenAttribute()
    {
        return $this->visibility == PostVisibility::HIDDEN;
    }
}
