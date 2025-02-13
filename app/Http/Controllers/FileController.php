<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function image(Image $image)
    {
        if (!Storage::fileExists($image->path)) {
            dd($image->path);
            return response()->file(public_path('img/thumbnail.svg'));
        }

        Gate::authorize('view', $image);

        return response()->file($image->fullPath);
    }
}
