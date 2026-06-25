<?php

namespace Database\Seeders;

use App\Models\KategoriBerita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'CBP Rupiah',
            'Edukasi',
            'Lomba',
            'Event',
            'Pengumuman',
            'Bank Indonesia',
            'UMKM',
            'Digitalisasi',
            'QRIS',
            'Literasi Keuangan'
        ];

        foreach ($kategoris as $kategori) {
            KategoriBerita::firstOrCreate([
                'name' => $kategori
            ]);
        }
    }
}
