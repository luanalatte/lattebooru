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
            $path = public_path('img/image.svg');
            return response(file_get_contents($path))->header('Content-Type', mime_content_type($path));
        }

        $post = Post::where('md5', $hash)->firstOrFail();
        Gate::authorize('view', $post);

        return response()->file(Storage::path($path));
    }

    public function thumb(string $hash)
    {
        $path = "thumbs/$hash";

        if (!Storage::exists($path)) {
            $path = public_path('img/thumbnail.svg');
            return response(file_get_contents($path))->header('Content-Type', mime_content_type($path));
        }

        $post = Post::where('md5', $hash)->firstOrFail();
        Gate::authorize('view', $post);

        return response()->file(Storage::path($path));
    }
}
