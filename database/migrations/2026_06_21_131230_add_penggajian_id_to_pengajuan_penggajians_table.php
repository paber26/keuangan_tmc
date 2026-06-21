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
        Schema::table('pengajuan_penggajians', function (Blueprint $table) {
            $table->foreignId('penggajian_id')->nullable()->after('kebun_id')->constrained('penggajians')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_penggajians', function (Blueprint $table) {
            $table->dropForeign(['penggajian_id']);
            $table->dropColumn('penggajian_id');
        });
    }
};
