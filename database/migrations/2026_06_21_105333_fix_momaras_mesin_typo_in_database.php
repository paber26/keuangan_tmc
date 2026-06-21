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
        DB::table('absensis')->where('jabatan', 'Momaras Mesin')->update(['jabatan' => 'Memaras Mesin']);
        DB::table('absensis')->where('jabatan', 'MOMARAS MESIN')->update(['jabatan' => 'Memaras Mesin']);
        DB::table('penggajian_details')->where('jabatan', 'Momaras Mesin')->update(['jabatan' => 'Memaras Mesin']);
        DB::table('penggajian_details')->where('jabatan', 'MOMARAS MESIN')->update(['jabatan' => 'Memaras Mesin']);
        DB::table('jabatans')->where('nama', 'Momaras Mesin')->update(['nama' => 'Memaras Mesin']);
        DB::table('jabatans')->where('nama', 'MOMARAS MESIN')->update(['nama' => 'Memaras Mesin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('database', function (Blueprint $table) {
            //
        });
    }
};
