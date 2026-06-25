<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'release_date',
        'status'
    ];
}
