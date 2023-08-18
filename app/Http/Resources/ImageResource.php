<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'imagePath' => url($this->filename),
            'title' => $this->title,
            'description' => $this->description,
            'favourite' => (bool) $this->favourite,
            'height' => $this->height ?? null,
            'width' => $this->width ?? null,
            'filesize' => $this->filesize ?? null,
            'createdAt' => $this->created_at,
        ];
    }
}
