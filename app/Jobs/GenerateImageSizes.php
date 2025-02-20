<?php

namespace App\Jobs;

use App\Enums\Settings;
use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class GenerateImageSizes implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $path
    ) {}

    public function handle(ImageManager $imageManager): void
    {
        if (Storage::fileMissing($this->path)) {
            logger()->warning('Image not found.', [$this->path]);
            $this->fail("Image not found.");
        }

        logger('Generating image sizes', [$this->path]);

        $format = Settings::THUMBNAIL_FORMAT->get();
        $quality = Settings::THUMBNAIL_QUALITY->get();
        $dimensions = Settings::THUMBNAIL_DIMENSIONS->get();

        $image = $imageManager->read(Storage::path($this->path));
        if ($image->width() <= $dimensions && $image->height() <= $dimensions) {
            $generatePreview = false;
        }

        $image->scaleDown($dimensions, $dimensions);

        Storage::put(
            'thumbs/' . basename($this->path),
            $image->encodeByExtension($format, quality: $quality)
        );

        if ($generatePreview ?? true) {
            $format = Settings::PREVIEW_FORMAT->get();
            $quality = Settings::PREVIEW_QUALITY->get();
            $dimensions = Settings::PREVIEW_DIMENSIONS->get();

            $image = $imageManager->read(Storage::path($this->path));
            $image->scaleDown($dimensions, $dimensions);

            Storage::put(
                'previews/' . basename($this->path),
                $image->encodeByExtension($format, quality: $quality)
            );
        }

        Post::where('md5', md5_file(Storage::path($this->path)))->touch();
    }
}
