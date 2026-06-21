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
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->string('lokasi_kebun')->nullable();
            $table->decimal('tarif_harian', 12, 2)->default(125000);
            $table->decimal('tarif_kupas', 12, 2)->default(200);
            $table->decimal('total_upah_harian', 15, 2)->default(0);
            $table->decimal('total_upah_kupas', 15, 2)->default(0);
            $table->decimal('total_keseluruhan', 15, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
