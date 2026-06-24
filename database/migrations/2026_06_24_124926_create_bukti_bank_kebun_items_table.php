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
        Schema::create('bukti_bank_kebun_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bukti_bank_kebun_id')->constrained('bukti_bank_kebuns')->onDelete('cascade');
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
        Schema::dropIfExists('bukti_bank_kebun_items');
    }
};
