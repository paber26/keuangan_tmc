<?php

use App\Models\Absensi;
use App\Models\Panen;
use App\Models\Karyawan;
use App\Models\Penggajian;

echo "Memperbarui Absensi...\n";
Absensi::where('lokasi', 'TOMBATU')->update(['lokasi' => 'TOMBATU - WINOR']);
Absensi::where('lokasi', 'RANOKETANG TUA')->update(['lokasi' => 'RANOKETANG TUA - KATUWISAN']);

echo "Memperbarui Panen...\n";
if (class_exists('App\Models\Panen')) {
    Panen::where('lokasi', 'TOMBATU')->update(['lokasi' => 'TOMBATU - WINOR']);
    Panen::where('lokasi', 'RANOKETANG TUA')->update(['lokasi' => 'RANOKETANG TUA - KATUWISAN']);
}

echo "Memperbarui Karyawan...\n";
Karyawan::where('lokasi_kerja', 'TOMBATU')->update(['lokasi_kerja' => 'TOMBATU - WINOR']);
Karyawan::where('lokasi_kerja', 'RANOKETANG TUA')->update(['lokasi_kerja' => 'RANOKETANG TUA - KATUWISAN']);

echo "Memperbarui Penggajian...\n";
Penggajian::where('lokasi_kebun', 'TOMBATU')->update(['lokasi_kebun' => 'TOMBATU - WINOR']);
Penggajian::where('lokasi_kebun', 'RANOKETANG TUA')->update(['lokasi_kebun' => 'RANOKETANG TUA - KATUWISAN']);

echo "Selesai.\n";
