<?php

namespace App\Models;

use App\Enums\PostVisibility;
use App\Jobs\GenerateThumbnail;
use App\Models\Scopes\VisibleScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'md5',
        'ext',
        'filename',
        'filesize',
        'width',
        'height',
        'source',
        'visibility'
    ];

    protected $casts = [
        'visibility' => PostVisibility::class
    ];

    public static function booted()
    {
        static::addGlobalScope(new VisibleScope);
    }

    public function scopeVisibility(Builder $query, PostVisibility $visibility = PostVisibility::PUBLIC)
    {
        return $query->withoutGlobalScope(VisibleScope::class)->where('visibility', $visibility);
    }

    public function scopePublic(Builder $query)
    {
        return $query->visibility(PostVisibility::PUBLIC);
    }

    public function regenerateThumbnail()
    {
        GenerateThumbnail::dispatch($this->md5);
    }

    public function getImagePathAttribute()
    {
        return Storage::path("images/$this->md5");
    }

    public function getThumbnailPathAttribute()
    {
        return Storage::path("thumbs/$this->md5");
    }

    public function getIsPrivateAttribute()
    {
        return $this->visibility == PostVisibility::PRIVATE;
    }

    public function getIsHiddenAttribute()
    {
        return $this->visibility == PostVisibility::HIDDEN;
    }

    public function getIsPublicAttribute()
    {
        return $this->visibility == PostVisibility::PUBLIC;
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
