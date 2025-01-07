<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function getPostWithRelations(Post $post)
    {
        return $post->load([
            'tags',
            'author',
            'comments.author'
        ]);
    }
}
