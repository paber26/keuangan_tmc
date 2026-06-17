<?php

namespace Database\Seeders;

use App\Models\Karyawan;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawans = [
            ['nama' => 'Jhon Bantu', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Juanda Durandt', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Adriana Maligoge', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Ivon Purnama', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Maxi Tenda', 'jabatan' => 'Momaras Mesin', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Anton Ambalao', 'jabatan' => 'Momaras Mesin', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Maykel Martin', 'jabatan' => 'Momaras Mesin', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Frendy Bantu', 'jabatan' => 'Kupas Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Noval Durandt', 'jabatan' => 'Kupas Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Alfa Durandt', 'jabatan' => 'Kupas Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Ruslan Latupo', 'jabatan' => 'Kupas Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Freddy Ottay', 'jabatan' => 'Pemanjat Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Jolly Engkol', 'jabatan' => 'Pemanjat Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Simon Sasela', 'jabatan' => 'Pemanjat Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Rinaldy Lohodandel', 'jabatan' => 'Pemanjat Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Fanly Palit', 'jabatan' => 'Pemanjat Kelapa', 'lokasi' => 'Sapa', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Riski Panigoro', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Ranoketang', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Niko Labulango', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Ranoketang', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Flandi Rembet', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Ranoketang', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Marlo Rembet', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Ranoketang', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Juan Rembet', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Ranoketang', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Yanto Runtuwene', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Ranoketang', 'tipe_gaji' => 'Harian'],
            ['nama' => 'Herman Nayoan', 'jabatan' => 'Momaras Mesin', 'lokasi' => 'Tombatu', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Freddy Runturambi', 'jabatan' => 'Momaras Mesin', 'lokasi' => 'Tombatu', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Fredi Lamia', 'jabatan' => 'Momaras Mesin', 'lokasi' => 'Tombatu', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Reince Mogogibung', 'jabatan' => 'Momaras Mesin', 'lokasi' => 'Tombatu', 'tipe_gaji' => 'Borongan'],
            ['nama' => 'Marsel Suot', 'jabatan' => 'Harian Kumpul', 'lokasi' => 'Tombatu', 'tipe_gaji' => 'Harian'],
        ];

        foreach ($karyawans as $data) {
            Karyawan::updateOrCreate(
                ['nama' => $data['nama']], // Check if this name already exists
                $data // If not, create it with all data. If yes, update it.
            );
        }
    }
}
