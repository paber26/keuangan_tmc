<?php

namespace Database\Seeders;

use App\Models\Kebun;
use Illuminate\Database\Seeder;

class KebunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kebuns = [
            ['nama' => 'RANOKETANG B', 'lokasi' => 'RANOKETANG TUA', 'luas' => 3000.00, 'status' => 'Aktif'],
            ['nama' => 'RANOKETANG A', 'lokasi' => 'RANOKETANG TUA', 'luas' => 4000.00, 'status' => 'Aktif'],
            ['nama' => 'LANSOT', 'lokasi' => 'SAPA', 'luas' => 1000.00, 'status' => 'Aktif'],
            ['nama' => 'KAYU WOLO', 'lokasi' => 'SAPA', 'luas' => 2400.00, 'status' => 'Aktif'],
            ['nama' => 'GUNUNG KAPAS', 'lokasi' => 'SAPA', 'luas' => 1000.00, 'status' => 'Aktif'],
            ['nama' => 'BATU KAPAL', 'lokasi' => 'SAPA', 'luas' => 2500.00, 'status' => 'Aktif'],
        ];

        foreach ($kebuns as $data) {
            Kebun::updateOrCreate(
                ['nama' => $data['nama']], // Cegah duplikasi
                $data
            );
        }
    }
}
