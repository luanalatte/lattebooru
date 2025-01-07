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
