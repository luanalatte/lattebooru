<?php

namespace App\Jobs;

use App\Enums\Settings;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Imagick;

class GenerateImageSizes implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $path
    ) {}

    public function handle(): void
    {
        if (Storage::fileMissing($this->path)) {
            throw new Exception("Image not found.");
        }

        $imagick = new Imagick(Storage::path($this->path));
        if (Storage::mimeType($this->path) == 'image/gif') {
            $imagick = $imagick->coalesceImages();
        }

        $imagick->setImageFormat(Settings::THUMBNAIL_FORMAT->get());
        $imagick->setCompressionQuality(Settings::THUMBNAIL_QUALITY->get());

        $dimensions = Settings::THUMBNAIL_DIMENSIONS->get();
        $imagick->thumbnailImage($dimensions, $dimensions, true);

        Storage::put('thumbs/' . basename($this->path), $imagick->getImageBlob());

        try {
            $imagick->clear();
            $imagick->destroy();
        } catch (Exception $e) {
            report($e);
        }

        $imagick = new Imagick(Storage::path($this->path));
        if (Storage::mimeType($this->path) == 'image/gif') {
            $imagick = $imagick->coalesceImages();
        }

        $imagick->setImageFormat('webp');
        $imagick->setCompressionQuality(90);

        $imagick->thumbnailImage(1000, 1000, true);

        Storage::put('previews/' . basename($this->path), $imagick->getImageBlob());

        try {
            $imagick->clear();
            $imagick->destroy();
        } catch (Exception $e) {
            report($e);
        }
    }
}
