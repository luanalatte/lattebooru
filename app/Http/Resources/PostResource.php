<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'author' => $this->user_id,
            'hash' => $this->md5,
            'filename' => $this->filename,
            'filesize' => $this->filesize,
            'width' => $this->width,
            'height' => $this->height,
            'source' => $this->source,
            'visibility' => [
                'id' => $this->visibility,
                'name' => $this->visibility->toString()
            ],
            'tags' => TagResource::collection($this->tags)
        ];
    }
}
