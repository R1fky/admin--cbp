<?php

namespace App\Models;


use App\Models\KategoriLomba;
use App\Models\LombaRegistration;
use Carbon\Carbon;
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
        'end_date',
        'location_type',
        'location'
    ];

    protected $casts = [
        'release_date' => 'date',
        'end_date' => 'date',
    ];

    // protected $appends = [
    //     'status',
    //     'status_label',
    //     'status_color',
    // ];

    public function kategori()
    {
        return $this->belongsTo(KategoriLomba::class);
    }


    /**
     * Status lomba
     */
    public function getStatusAttribute()
    {
        $today = Carbon::today();

        if ($today->lt($this->release_date)) {
            return 'upcoming';
        }

        if ($today->lte($this->end_date)) {
            return 'ongoing';
        }

        return 'closed';
    }

    /**
     * Label Status
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'upcoming' => 'Segera Dibuka',
            'ongoing'  => 'Sedang Berlangsung',
            default    => 'Ditutup',
        };
    }

    /**
     * Warna Badge
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'upcoming' => 'bg-yellow-100 text-yellow-700',
            'ongoing'  => 'bg-green-100 text-green-700',
            default    => 'bg-red-100 text-red-700',
        };
    }

    public function registrations()
    {
        return $this->hasMany(LombaRegistration::class);
    }
}
