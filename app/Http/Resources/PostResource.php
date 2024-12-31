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
            'author' => new UserResource($this->author),
            'hash' => $this->md5,
            'filename' => $this->filename,
            'filesize' => $this->filesize,
            'width' => $this->width,
            'height' => $this->height,
            'source' => $this->source,
            'created_at' => $this->created_at,
            'visibility' => $this->visibility->toArray(),
            'tags' => TagResource::collection($this->whenLoaded('tags'))
        ];
    }
}
