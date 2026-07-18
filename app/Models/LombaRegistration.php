<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LombaRegistration extends Model
{
    //
    protected $fillable = [

        'lomba_id',

        'name',
        'email',
        'domicile',
        'phone',
        'address',
        
        'file',
        'link',

        'status'
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}
