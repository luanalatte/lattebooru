<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class RegenerateThumbnails extends Command
{
    protected $signature = 'app:regenerate-thumbnails';
    protected $description = 'Regenerates all thumbnails.';

    public function handle()
    {
        $count = Post::count();

        if ($this->confirm("Are you sure you want to regenerate $count thumbnails?")) {
            foreach (Post::select('md5')->lazy(100) as $post) {
                $post->regenerateThumbnail();
            }
        }
    }
}
