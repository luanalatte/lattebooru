<?php

namespace App\Jobs;

use App\Enums\ImageType;
use App\Enums\Settings;
use App\Models\Image;
use App\Models\Post;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Imagick;

class GenerateThumbnail implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        #[WithoutRelations]
        public Image $image
    ) {}

    public function handle(): void
    {
        $path = 'images/' . $this->image->md5;
        if (!Storage::fileExists($path)) {
            $this->delete();
            return;
        }

        $path = Storage::path($path);

        $imagick = new Imagick($path);
        if (Storage::mimeType($path) == 'image/gif') {
            $imagick = $imagick->coalesceImages();
        }

        $imagick->setImageFormat(Settings::THUMBNAIL_FORMAT->get());
        $imagick->setCompressionQuality(Settings::THUMBNAIL_QUALITY->get());

        $dimensions = Settings::THUMBNAIL_DIMENSIONS->get();
        $imagick->thumbnailImage($dimensions, $dimensions, true);

        if (($thumbnail = $this->image->thumbnail) === null) {
            $thumbnail = $this->image->thumbnail()->make();
        }

        $thumbnail->fill([
            'type' => ImageType::THUMBNAIL,
            'ext' => strtolower($imagick->getImageFormat()),
            'md5' => md5($imagick->getImageBlob()),
            'filesize' => strlen($imagick->getImageBlob()),
            'width' => $dimensions,
            'height' => $dimensions,
        ]);

        Storage::put('thumbs/' . $thumbnail->md5, $imagick->getImageBlob());

        $thumbnail->save();
        Post::where('image_id', $this->image->id)->touch();

        try {
            $imagick->clear();
            $imagick->destroy();
        } catch (Exception $e) {
            report($e);
            return;
        }
    }
}
