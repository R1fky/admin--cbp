<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    //
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'kategori_id',
        'author',
        'source',
        'image',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class);
    }
}
