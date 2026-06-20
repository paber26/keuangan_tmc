<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemakaian_bbm', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('judul_laporan');
            $table->text('keterangan')->nullable();
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemakaian_bbm');
    }
};
