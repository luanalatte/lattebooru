<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class ImagePolicy
{
    public function view(?User $user, Image $image): bool
    {
        $posts = Post::where('image_id', $image->id);

        if ($image->parent_id !== null) {
            $posts->orWhere('image_id', $image->parent_id);
        }

        foreach ($posts->get() as $post) {
            if (Gate::allows('view', $post)) {
                return true;
            }
        }

        return false;
    }
}
