<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function image(string $hash)
    {
        $path = "images/$hash";

        if (!Storage::exists($path)) {
            return null;
        }

        return Storage::get($path);
    }

    public function thumb(string $hash)
    {
        $path = "thumbs/$hash";

        if (!Storage::exists($path)) {
            return null;
        }

        return Storage::get($path);
    }
}
