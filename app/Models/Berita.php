<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    //
    protected $fillable = [
        'title',
        'content',
        'kategori_id',
        'image',
        'published_at'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class);
    }
}
