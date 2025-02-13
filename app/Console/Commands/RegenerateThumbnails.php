<?php

namespace App\Console\Commands;

use App\Jobs\GenerateImageSizes;
use App\Models\Image;
use Exception;
use Illuminate\Console\Command;

class RegenerateThumbnails extends Command
{
    protected $signature = 'app:regenerate-thumbnails';
    protected $description = 'Regenerates all thumbnails.';

    public function handle()
    {
        $count = Image::whereNull('parent_id')->count();

        if ($this->confirm("Are you sure you want to regenerate $count thumbnails?")) {
            foreach (Image::whereNull('parent_id')->lazy(100) as $image) {
                try {
                    GenerateImageSizes::dispatch($image);
                } catch (Exception) {
                    continue;
                }
            }
        }
    }
}
