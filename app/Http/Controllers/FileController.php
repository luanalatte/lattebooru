<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function image(string $hash)
    {
        $path = "images/$hash";

        if (!Storage::exists($path)) {
            return null;
        }

        $post = Post::where('md5', $hash)->firstOrFail();
        Gate::authorize('view', $post);

        return Storage::get($path);
    }

    public function thumb(string $hash)
    {
        $path = "thumbs/$hash";

        if (!Storage::exists($path)) {
            return null;
        }

        $post = Post::where('md5', $hash)->firstOrFail();
        Gate::authorize('view', $post);

        return Storage::get($path);
    }
}
