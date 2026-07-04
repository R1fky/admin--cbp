<?php

namespace App\Exports;

use App\Models\LombaRegistration;
use Maatwebsite\Excel\Concerns\FromCollection;

class LombaRegistrationExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        return LombaRegistration::all();
    }
}
