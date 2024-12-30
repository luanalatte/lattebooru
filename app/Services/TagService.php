<?php

namespace App\Services;

class TagService
{
    public function sanitize(string $tag)
    {
        $tag = strtolower(trim($tag));

        $tag = preg_replace('/\s+/', '_', $tag);

        return $tag;
    }

    /** @var string[] $tagNames */
    public function sanitizeMany(array $tagNames)
    {
        return array_map(fn ($tag) => $this->sanitize($tag), $tagNames);
    }
}
