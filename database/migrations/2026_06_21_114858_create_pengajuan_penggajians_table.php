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
        Schema::create('pengajuan_penggajians', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('no_dokumen')->nullable();
            $table->date('disahkan_tgl')->nullable();
            $table->date('berlaku_tgl')->nullable();
            $table->string('revisi')->nullable()->default('0');
            $table->foreignId('kebun_id')->nullable()->constrained('kebuns')->nullOnDelete();
            $table->string('perihal')->nullable();
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_penggajians');
    }
};
