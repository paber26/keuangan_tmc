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
        Schema::create('pengajuan_penggajian_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_penggajian_id')->constrained('pengajuan_penggajians')->cascadeOnDelete();
            $table->string('uraian');
            $table->decimal('banyak_unit', 10, 2)->nullable();
            $table->decimal('harga_satuan', 15, 2)->nullable();
            $table->decimal('total_harga', 15, 2)->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_penggajian_items');
    }
};
