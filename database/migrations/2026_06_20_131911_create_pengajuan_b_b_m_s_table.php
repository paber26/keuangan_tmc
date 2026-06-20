<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_bbm', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('judul_pengajuan');
            $table->text('keterangan')->nullable();
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_bbm');
    }
};
