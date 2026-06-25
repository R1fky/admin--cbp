<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriLomba extends Model
{
    protected $fillable = [
        'name'
    ];

    public function lombas()
    {
        return $this->hasMany(Lomba::class);
    }
}
