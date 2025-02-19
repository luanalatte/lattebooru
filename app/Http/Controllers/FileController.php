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

        return response()->file(Storage::path(match ($size) {
            'thumb' => $post->thumbnailpath,
            'preview' => $post->previewPath,
            default => $post->imagePath
        }));
    }
}
