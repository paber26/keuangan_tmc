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
        Schema::create('bukti_kas_kebuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_penggajian_id')->constrained('pengajuan_penggajians')->cascadeOnDelete();
            $table->string('no_bukti')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_kas_kebuns');
    }
};
