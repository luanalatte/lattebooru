<?php

namespace App\Validation\Rules;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class UniqueFileHash implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$value instanceof UploadedFile) {
            $fail(trans('upload.bad_file'));
        }

        $hash = md5_file($value->path());
        if (Post::where('md5', $hash)->exists()) {
            $fail(trans('upload.duplicate'));
        }
    }
}
