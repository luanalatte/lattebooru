<?php

namespace App\Models;

use App\Enums\ImageType;
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

    public function regenerateThumbnail()
    {
        GenerateThumbnail::dispatch($this->image);
    }

    public function getIsAnimatedAttribute()
    {
        return $this->ext == 'gif' || $this->ext == 'apng';
    }

    public function toResource()
    {
        return new PostResource($this);
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function thumbnail()
    {
        return $this->hasOne(Image::class, 'parent_id', 'image_id')->where('type', ImageType::THUMBNAIL);
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
