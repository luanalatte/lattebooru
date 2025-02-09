<?php

namespace App\Jobs;

use App\Enums\Settings;
use App\Models\Post;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Imagick;

class GenerateThumbnail implements ShouldQueue
{
    use Queueable;

    public function __construct(private string $filename) {}

    public function handle(): void
    {
        if (!Storage::exists("images/$this->filename")) {
            $this->delete();
            return;
        }

        $imagick = new Imagick(Storage::path("images/$this->filename"));
        if (Storage::mimeType("images/$this->filename") == 'image/gif') {
            $imagick = $imagick->coalesceImages();
        }

        $imagick->setImageFormat(Settings::THUMBNAIL_FORMAT->get());
        $imagick->setCompressionQuality(Settings::THUMBNAIL_QUALITY->get());

        $dimensions = Settings::THUMBNAIL_DIMENSIONS->get();
        $imagick->thumbnailImage($dimensions, $dimensions, true);

        Storage::put('thumbs/' . basename($this->filename), $imagick->getImageBlob());

        Post::where('md5', $this->filename)->touch();

        try {
            $imagick->clear();
            $imagick->destroy();
        } catch (Exception $e) {
            report($e);
            return;
        }
    }
}
