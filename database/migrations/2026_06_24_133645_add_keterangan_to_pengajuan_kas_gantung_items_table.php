<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengajuan_kas_gantung_items', function (Blueprint $table) {
            $table->string('keterangan_pengajuan')->nullable()->after('total_harga');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kas_gantung_items', function (Blueprint $table) {
            $table->dropColumn('keterangan_pengajuan');
        });
    }
};
