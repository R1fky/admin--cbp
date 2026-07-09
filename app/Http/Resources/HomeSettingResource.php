<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSettingResource extends JsonResource
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
            'hero_title' => $this->hero_title,
            'hero_description' => $this->hero_description,
            'hero_image' => $this->hero_image
                ? asset('storage/' . $this->hero_image)
                : null,

            'youtube_url' => $this->youtube_url,
            'created_at' => $this->created_at,
        ];
    }
}
