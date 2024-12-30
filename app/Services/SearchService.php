<?php

namespace App\Services;

class SearchService
{
    public function parseSearchString(string $search)
    {
        $search = strtolower(trim($search));
        $search = preg_replace('/\s+/', ' ', $search);
        $search = preg_replace('/-+/', '-', $search);

        $tags = [];
        $tagsExclude = [];
        foreach (explode(' ', $search) as $tag) {
            if (!str_starts_with($tag, '-')) {
                $tags[] = $tag;
            } else {
                $tagsExclude[] = substr($tag, 1);
            }
        }

        return [
            'tags' => $tags,
            'exclude' => $tagsExclude
        ];
    }
}
