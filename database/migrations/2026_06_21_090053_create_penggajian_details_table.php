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
        Schema::create('penggajian_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penggajian_id');
            $table->unsignedBigInteger('karyawan_id');
            $table->string('nama_karyawan'); // denormalization to keep record even if karyawan name changes
            $table->string('tipe_pekerjaan'); // 'Harian' atau 'Kupas Kelapa'
            $table->integer('jumlah_hari_kerja')->default(0); // for Harian
            $table->decimal('jumlah_volume', 10, 2)->default(0); // for Kupas Kelapa
            $table->decimal('total_upah', 15, 2)->default(0);
            $table->json('rincian_harian')->nullable(); // to store days they worked e.g. {"2026-06-08": "V", ...}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajian_details');
    }
};
