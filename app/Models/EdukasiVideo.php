<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EdukasiVideo extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'link',
    ];
}
