<?php

namespace App\Models;

use App\Http\Resources\PostResource;
use App\Jobs\GenerateThumbnail;
use App\Models\Traits\Commentable;
use App\Models\Traits\HasVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasVisibility, Commentable;

    protected $fillable = [
        'md5',
        'ext',
        'filename',
        'filesize',
        'width',
        'height',
        'source',
        'visibility'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            Storage::delete($post->imagePath);
            Storage::delete($post->thumbnailpath);
        });
    }

    public function getThumbnailUrlAttribute()
    {
        return route('_thumb', [$this->md5, 'v=' . $this->updated_at->timestamp]);
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

    public function getIsAnimatedAttribute()
    {
        return $this->ext == 'gif' || $this->ext == 'apng';
    }

    public function toResource()
    {
        return new PostResource($this);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->orderBy('name', 'asc');
    }
}
