<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $withCount = ['posts'];

    protected $fillable = [
        'name',
    ];

    public function scopeWithBasicInfo(Builder $query)
    {
        $query->select('tags.id', 'tags.name')->withCount('posts');
    }

    public function scopePopular(Builder $query)
    {
        $query->orderBy('posts_count', 'desc');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
