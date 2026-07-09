<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EdukasiResource extends JsonResource
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
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'content' => $this->content,
            'file' => $this->file ? route('api.edukasis.pdf', $this->id) : null,
            'file_name' => $this->file ? basename($this->file) : null,
            'file_extension' => $this->file ? strtolower(pathinfo($this->file, PATHINFO_EXTENSION)) : null,
            'link' => $this->link,
            'created_at' => $this->created_at,
        ];
    }
}
