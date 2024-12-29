<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagService
{
    public function sanitize(string $tag)
    {
        $tag = strtolower(trim($tag));

        $tag = preg_replace('/\s+/', '_', $tag);

        return $tag;
    }

    public function findTags(array $tags): Collection
    {
        $tags = array_map(fn ($tag) => $this->sanitize($tag), $tags);
        return Tag::whereIn('name', $tags)->get();
    }

    public function findOrCreateTags(array $tags): Collection
    {
        $tags = array_map(fn ($tag) => $this->sanitize($tag), $tags);
        $tagModels = Tag::whereIn('name', $tags)->get();

        $byName = $tagModels->keyBy->name;
        foreach ($tags as $tag) {
            if (!isset($byName[$tag])) {
                $tagModels[] = Tag::create(['name' => $tag]);
            }
        }

        return $tagModels;
    }
}
