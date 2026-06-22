<?php

use App\Models\Absensi;
use App\Models\Panen;
use App\Models\Karyawan;
use App\Models\Penggajian;

echo "Memperbarui Karyawan...\n";
Karyawan::where('lokasi', 'TOMBATU')->update(['lokasi' => 'TOMBATU - WINOR']);
Karyawan::where('lokasi', 'RANOKETANG TUA')->update(['lokasi' => 'RANOKETANG TUA - KATUWISAN']);

echo "Memperbarui Penggajian...\n";
Penggajian::where('lokasi_kebun', 'TOMBATU')->update(['lokasi_kebun' => 'TOMBATU - WINOR']);
Penggajian::where('lokasi_kebun', 'RANOKETANG TUA')->update(['lokasi_kebun' => 'RANOKETANG TUA - KATUWISAN']);

echo "Selesai.\n";
