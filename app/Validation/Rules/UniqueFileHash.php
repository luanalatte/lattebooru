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
            $fail(__("There was an error processing your file."));
        }

        $hash = md5_file($value->path());
        if (Post::whereRelation('image', 'md5', $hash)->exists()) {
            $fail(__("A post with the same file already exists."));
        }
    }
}
