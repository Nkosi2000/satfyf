<?php

namespace App\Http\Resources;

use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin GalleryImage
 */
class GalleryImageResource extends JsonResource
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
            'caption' => $this->caption,
            'category' => $this->category,
            'image_url' => storage_url($this->image_path),
        ];
    }
}
