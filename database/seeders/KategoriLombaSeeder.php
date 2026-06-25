<?php

namespace Database\Seeders;

use App\Models\KategoriLomba;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriLombaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Aceh',
            'Bireun',
            'Aceh Tengah',
            'Lhokseumawe',
            'Aceh Timur',
        ];

        foreach ($kategoris as $kategori) {
            KategoriLomba::firstOrCreate([
                'name' => $kategori
            ]);
        }
    }
}
