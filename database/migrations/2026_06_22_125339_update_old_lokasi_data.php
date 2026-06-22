<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update Absensi
        DB::table('absensis')->where('lokasi', 'TOMBATU')->update(['lokasi' => 'TOMBATU - WINOR']);
        DB::table('absensis')->where('lokasi', 'RANOKETANG TUA')->update(['lokasi' => 'RANOKETANG TUA - KATUWISAN']);

        // Update Panen
        if (Schema::hasTable('panens')) {
            DB::table('panens')->where('lokasi', 'TOMBATU')->update(['lokasi' => 'TOMBATU - WINOR']);
            DB::table('panens')->where('lokasi', 'RANOKETANG TUA')->update(['lokasi' => 'RANOKETANG TUA - KATUWISAN']);
        }

        // Update Karyawan
        DB::table('karyawans')->where('lokasi', 'TOMBATU')->update(['lokasi' => 'TOMBATU - WINOR']);
        DB::table('karyawans')->where('lokasi', 'RANOKETANG TUA')->update(['lokasi' => 'RANOKETANG TUA - KATUWISAN']);

        // Update Penggajian
        DB::table('penggajians')->where('lokasi_kebun', 'TOMBATU')->update(['lokasi_kebun' => 'TOMBATU - WINOR']);
        DB::table('penggajians')->where('lokasi_kebun', 'RANOKETANG TUA')->update(['lokasi_kebun' => 'RANOKETANG TUA - KATUWISAN']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse updates
        DB::table('absensis')->where('lokasi', 'TOMBATU - WINOR')->update(['lokasi' => 'TOMBATU']);
        DB::table('absensis')->where('lokasi', 'RANOKETANG TUA - KATUWISAN')->update(['lokasi' => 'RANOKETANG TUA']);

        if (Schema::hasTable('panens')) {
            DB::table('panens')->where('lokasi', 'TOMBATU - WINOR')->update(['lokasi' => 'TOMBATU']);
            DB::table('panens')->where('lokasi', 'RANOKETANG TUA - KATUWISAN')->update(['lokasi' => 'RANOKETANG TUA']);
        }

        DB::table('karyawans')->where('lokasi', 'TOMBATU - WINOR')->update(['lokasi' => 'TOMBATU']);
        DB::table('karyawans')->where('lokasi', 'RANOKETANG TUA - KATUWISAN')->update(['lokasi' => 'RANOKETANG TUA']);

        DB::table('penggajians')->where('lokasi_kebun', 'TOMBATU - WINOR')->update(['lokasi_kebun' => 'TOMBATU']);
        DB::table('penggajians')->where('lokasi_kebun', 'RANOKETANG TUA - KATUWISAN')->update(['lokasi_kebun' => 'RANOKETANG TUA']);
    }
};
