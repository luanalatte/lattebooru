<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function image(string $size, Post $post)
    {
        $size = strtolower($size);

        if (Storage::fileMissing($post->imagePath)) {
            if ($size == 'thumb') {
                return response()->file(public_path('img/thumbnail.svg'));
            }

            return response()->file(public_path('img/image.svg'));
        }

        Gate::authorize('view', $post);

        if ($size == 'thumb') {
            if (Storage::fileMissing($post->thumbnailPath)) {
                return response()->file(public_path('img/thumbnail.svg'));
            }

            return response()->file(Storage::path($post->thumbnailPath));
        }

        if ($size == 'preview') {
            if (Storage::fileMissing($post->previewPath)) {
                return response()->file(public_path('img/image.svg'));
            }

            return response()->file(Storage::path($post->previewPath));
        }

        if (Storage::fileMissing($post->imagePath)) {
            return response()->file(public_path('img/image.svg'));
        }

        return response()->file(Storage::path($post->imagePath));
    }
}
