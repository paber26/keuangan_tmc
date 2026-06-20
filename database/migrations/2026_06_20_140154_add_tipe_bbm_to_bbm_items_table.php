<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemakaian_bbm_items', function (Blueprint $table) {
            $table->enum('tipe_bbm', ['Solar', 'Pertalite'])->default('Solar')->after('keterangan_pemakaian');
        });

        Schema::table('pengajuan_bbm_items', function (Blueprint $table) {
            $table->enum('tipe_bbm', ['Solar', 'Pertalite'])->default('Solar')->after('keterangan_pengajuan');
        });
    }

    public function down(): void
    {
        Schema::table('pemakaian_bbm_items', function (Blueprint $table) {
            $table->dropColumn('tipe_bbm');
        });

        Schema::table('pengajuan_bbm_items', function (Blueprint $table) {
            $table->dropColumn('tipe_bbm');
        });
    }
};
