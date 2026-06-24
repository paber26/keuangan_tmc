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
        Schema::create('pengajuan_kas_gantungs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('judul_pengajuan');
            $table->text('keterangan')->nullable();
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('pengajuan_kas_gantung_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_kas_gantung_id')->constrained('pengajuan_kas_gantungs')->onDelete('cascade');
            $table->string('nama_barang');
            $table->integer('qty');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total_harga', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kas_gantung_items');
        Schema::dropIfExists('pengajuan_kas_gantungs');
    }
};
