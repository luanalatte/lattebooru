<?php

namespace App\Jobs;

use App\Enums\ImageType;
use App\Enums\Settings;
use App\Models\Image;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Imagick;

class GenerateImageSizes implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        #[WithoutRelations]
        public Image $image
    ) {}

    public function handle(): void
    {
        if ($this->image->parent_id !== null) {
            throw new Exception("Images with parents shouldn't have children. Instead, generate the new sizes as siblings.");
        }

        if (Storage::fileMissing($this->image->path)) {
            throw new Exception("Image not found.");
        }

        $imagick = new Imagick($this->image->fullPath);
        if ($this->image->isAnimated) {
            $imagick = $imagick->coalesceImages();
        }

        $imagick->setImageFormat(Settings::THUMBNAIL_FORMAT->get());
        $imagick->setCompressionQuality(Settings::THUMBNAIL_QUALITY->get());

        $dimensions = Settings::THUMBNAIL_DIMENSIONS->get();
        $imagick->thumbnailImage($dimensions, $dimensions, true);

        $thumbnail = $this->image->variants()->updateOrCreate([
            'type' => ImageType::THUMBNAIL
        ], [
            'ext' => strtolower($imagick->getImageFormat()),
            'md5' => md5($imagick->getImageBlob()),
            'filesize' => strlen($imagick->getImageBlob()),
            'width' => $dimensions,
            'height' => $dimensions
        ]);

        Storage::put($thumbnail->path, $imagick->getImageBlob());

        $thumbnail->save();

        try {
            $imagick->clear();
            $imagick->destroy();
        } catch (Exception $e) {
            report($e);
            return;
        }
    }
}
