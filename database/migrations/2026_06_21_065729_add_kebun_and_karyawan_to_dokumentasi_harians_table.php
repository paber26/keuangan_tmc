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
        Schema::table('dokumentasi_harians', function (Blueprint $table) {
            $table->foreignId('kebun_id')->nullable()->constrained('kebuns')->nullOnDelete();
            $table->foreignId('karyawan_id')->nullable()->constrained('karyawans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumentasi_harians', function (Blueprint $table) {
            $table->dropForeign(['kebun_id']);
            $table->dropForeign(['karyawan_id']);
            $table->dropColumn(['kebun_id', 'karyawan_id']);
        });
    }
};
