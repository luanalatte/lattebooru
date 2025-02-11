<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function image(Post $post)
    {
        $post->load('author');
        Gate::authorize('view', $post);

        $post->load('image');

        if (!Storage::exists($post->image->path)) {
            return response()->file(public_path('img/thumbnail.svg'));
        }

        return response()->file(Storage::path($post->image->path));
    }

    public function thumb(Post $post)
    {
        $post->load('author');

        Gate::authorize('view', $post);

        $post->load('thumbnail');

        if (!Storage::exists($post->thumbnail->path)) {
            return response()->file(public_path('img/thumbnail.svg'));
        }

        return response()->file(Storage::path($post->thumbnail->path));
    }
}
