<?php

namespace App\Models;

use App\Traits\EncryptsRouteKey;
use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    use EncryptsRouteKey;

    protected $fillable = [
        'judul',
        'deskripsi',
        'content',
        'file',
        'link'
    ];
}
