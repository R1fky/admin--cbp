<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LombaResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'release_date' => $this->release_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'location_type' => $this->location_type,

            'status' => $this->status,
            'status_label' => $this->status_label,
            'status_color' => $this->status_color,

            'current_participants' => $this->current_participants,
            'max_participants' => $this->max_participants,
            'remaining_quota' => $this->remaining_quota,
            'is_full' => $this->is_full,
        ];
    }
}
