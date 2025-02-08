<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostService
{
    /** @var string[] $tagNames */
    public function removeTags(Post $post, array $tagNames)
    {
        $ids = DB::table('tags')->whereIn('name', $tagNames)->get('id')->pluck('id');

        $post->tags()->detach($ids);
    }

    /** @var string[] $tagNames */
    public function addTags(Post $post, array $tagNames)
    {
        $tags = DB::table('tags')->whereIn('name', $tagNames)->get(['id', 'name', 'deleted_at'])->keyBy->name;

        if (Gate::allows('tag_create')) {
            $newTags = collect($tagNames)->filter(fn ($tag) => !isset($tags[$tag]))->unique()->map(fn ($tag) => ['name' => $tag, 'created_at' => now()])->all();
            DB::table('tags')->insert($newTags);

            $tags = $tags->concat(DB::table('tags')->whereIn('name', $newTags)->get(['id', 'name'])->keyBy->name);
        }

        $post->tags()->syncWithoutDetaching($tags->whereNull('deleted_at')->pluck('id'));
    }
}
