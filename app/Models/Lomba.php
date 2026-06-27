<?php

namespace App\Models;


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
            return 'akan_dibuka';
        }

        if ($today->lte($this->end_date)) {
            return 'sedang_berlangsung';
        }

        return 'pendaftaran_selesai';
    }

    /**
     * Label status
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'akan_dibuka' => 'Akan Dibuka',
            'sedang_berlangsung' => 'Sedang Berlangsung',
            default => 'Pendaftaran Selesai',
        };
    }

    /**
     * Warna badge
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'akan_dibuka' => 'bg-yellow-100 text-yellow-700',
            'sedang_berlangsung' => 'bg-green-100 text-green-700',
            default => 'bg-red-100 text-red-700',
        };
    }
}
