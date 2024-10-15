<?php

namespace App\Models;

use App\Enums\PostVisibility;
use App\Jobs\GenerateThumbnail;
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

    public function scopePublic(Builder $query)
    {
        return $query->where('visibility', PostVisibility::PUBLIC);
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

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
