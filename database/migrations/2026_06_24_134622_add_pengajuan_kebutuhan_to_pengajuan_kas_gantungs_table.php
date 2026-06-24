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
        Schema::table('pengajuan_kas_gantungs', function (Blueprint $table) {
            $table->string('pengajuan_kebutuhan')->nullable()->after('judul_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_kas_gantungs', function (Blueprint $table) {
            $table->dropColumn('pengajuan_kebutuhan');
        });
    }
};
