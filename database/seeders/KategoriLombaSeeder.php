<?php

namespace Database\Seeders;

use App\Models\KategoriLomba;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class KategoriLombaSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        KategoriLomba::truncate();

        Schema::enableForeignKeyConstraints();

        $kategoris = [
            'Lomba Edukasi',
            'Lomba Kreativitas',
            'Lomba Poster',
            'Lomba Video',
            'Lomba Fotografi',
            'Lomba Esai',
            'Lomba Debat',
            'Lomba Desain Grafis',
            'Lomba Karya Tulis',
            'Lomba UMKM',
        ];

        foreach ($kategoris as $kategori) {
            KategoriLomba::create([
                'name' => $kategori
            ]);
        }
    }
}
