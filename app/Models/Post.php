<?php

namespace App\Models;

use App\Enums\ImageType;
use App\Models\Traits\Commentable;
use App\Models\Traits\HasVisibility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasVisibility, Commentable;

    protected $fillable = [
        'source',
        'visibility'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function preview()
    {
        return $this->hasOne(Image::class, 'parent_id', 'image_id')->where('type', ImageType::IMAGE_PREVIEW);
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
