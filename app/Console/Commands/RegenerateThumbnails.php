<?php

namespace App\Console\Commands;

use App\Jobs\GenerateImageSizes;
use App\Models\Post;
use Exception;
use Illuminate\Console\Command;

class RegenerateThumbnails extends Command
{
    protected $signature = 'app:regenerate-thumbnails';
    protected $description = 'Regenerates all thumbnails.';

    public function handle()
    {
        $count = Post::anyVisibility()->count();

        if ($this->confirm("Are you sure you want to regenerate $count thumbnails?")) {
            foreach (Post::anyVisibility()->select('md5')->lazy(100) as $post) {
                try {
                    GenerateImageSizes::dispatch($post->imagePath);
                } catch (Exception) {
                    continue;
                }
            }
        }
    }
}
