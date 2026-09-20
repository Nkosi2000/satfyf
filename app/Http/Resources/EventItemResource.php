<?php

namespace App\Http\Resources;

use App\Models\EventItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin EventItem
 */
class EventItemResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'starts_at' => $this->starts_at?->toIso8601String(),
            'ends_at' => $this->ends_at?->toIso8601String(),
            'is_upcoming' => $this->isUpcoming(),
            'is_featured' => $this->is_featured,
            'cover_image_url' => storage_url($this->cover_image_path),
        ];
    }
}
