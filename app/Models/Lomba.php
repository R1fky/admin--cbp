<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    //
    protected $fillable = [
        'title',
        'kategori_id',
        'description',
        'thumbnail',
        'release_date',
        'status'
    ];

    protected $casts = [
        'release_date' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLomba::class);
    }
}
