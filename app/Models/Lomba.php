<?php

namespace App\Models;


use App\Models\KategoriLomba;
use App\Models\LombaRegistration;
use App\Traits\EncryptsRouteKey;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use EncryptsRouteKey;

    protected $fillable = [
        'title',
        'kategori_id',
        'description',
        'thumbnail',
        'release_date',
        'end_date',
        'location_type',
        'location',
        'max_participants',
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

    /**
     * Maximum Peserta
     */

    public function getCurrentParticipantsAttribute()
    {
        return $this->registrations_count
            ?? $this->registrations()->count();
    }


    public function getRemainingQuotaAttribute()
    {
        return max(
            $this->max_participants - $this->current_participants,
            0
        );
    }

    public function getIsFullAttribute()
    {
        return $this->current_participants >= $this->max_participants;
    }

    // relation to registrasi lomba model
    public function registrations()
    {
        return $this->hasMany(LombaRegistration::class);
    }
}
