<?php

namespace App\Models;

use App\Enums\ImageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'parent_id',
        'md5',
        'ext',
        'filename',
        'filesize',
        'width',
        'height',
    ];

    protected $casts = [
        'type' => ImageType::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($image) {
            Storage::delete($image->path);

            $image->variants()->get()->each(function ($variant) {
                $variant->delete();
            });
        });
    }

    public function getUrlAttribute()
    {
        return match ($this->type) {
            ImageType::THUMBNAIL => route('_thumb', [$this->md5]),
            default => route('_image', [$this->md5])
        };
    }

    public function getDirectoryPathAttribute()
    {
        return match ($this->type) {
            ImageType::IMAGE => 'images/',
            ImageType::THUMBNAIL => 'thumbs/',
            ImageType::IMAGE_PREVIEW => 'previews/',
            default => 'files/'
        };
    }

    public function getPathAttribute()
    {
        return $this->directoryPath . $this->md5;
    }

    public function parent()
    {
        return $this->belongsTo(Image::class, 'parent_id');
    }

    public function variants()
    {
        return $this->hasMany(Image::class, 'parent_id');
    }

    public function thumbnail(): HasOne
    {
        return $this->variants()->where('type', ImageType::THUMBNAIL)->one()->ofMany();
    }

    public function preview(): HasOne
    {
        return $this->variants()->where('type', ImageType::IMAGE_PREVIEW)->one()->ofMany();
    }
}
