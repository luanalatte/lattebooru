<?php

namespace App\Models;

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
        'source',
        'visibility',
        'md5',
        'ext',
        'filename',
        'filesize',
        'width',
        'height',
    ];

    protected static function boot()
    {
        parent::boot();

        static::forceDeleting(function ($post) {
            Storage::delete([$post->imagePath, $post->thumbnailPath, $post->previewPath]);
        });
    }

    public function getMimeTypeAttribute()
    {
        return Storage::mimeType($this->imagePath);
    }

    public function getIsAnimatedAttribute()
    {
        return match($this->mimeType) {
            'image/gif', 'image/apng' => true,
            default => false,
        };
    }

    public function getImagePathAttribute()
    {
        return "images/$this->md5";
    }

    public function getImageUrlAttribute()
    {
        return route('_image', ['size' => 'full', 'post' => $this, 't' => $this->updated_at->timestamp]);
    }

    public function getThumbnailPathAttribute()
    {
        return "thumbs/$this->md5";
    }

    public function getThumbnailUrlAttribute()
    {
        return route('_image', ['size' => 'thumb', 'post' => $this, 't' => $this->updated_at->timestamp]);
    }

    public function getPreviewPathAttribute()
    {
        return "previews/$this->md5";
    }

    public function getPreviewUrlAttribute()
    {
        if (Storage::fileMissing($this->previewPath)) {
            return $this->imageUrl;
        }

        return route('_image', ['size' => 'preview', 'post' => $this, 't' => $this->updated_at->timestamp]);
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
