<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_bbm_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_bbm_id')->constrained('pengajuan_bbm')->onDelete('cascade');
            $table->string('keterangan_pengajuan');
            $table->decimal('jumlah_liter', 8, 2);
            $table->decimal('harga_per_liter', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_bbm_items');
    }
};
