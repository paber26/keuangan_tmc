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
        Schema::table('pengajuan_bbm', function (Blueprint $table) {
            $table->unsignedBigInteger('karyawan_id')->nullable()->change();
            $table->string('departemen')->default('PERKEBUNAN');
            $table->string('perihal')->default('Kebutuhan Biaya BBM');
        });

        Schema::table('pengajuan_bbm_items', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->change();
            $table->string('tipe_bbm')->nullable()->change();
            $table->decimal('jumlah_liter', 10, 2)->nullable()->change();
            $table->decimal('harga_per_liter', 15, 2)->nullable()->change();
            
            $table->string('uraian')->nullable()->after('tipe_bbm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_bbm', function (Blueprint $table) {
            $table->unsignedBigInteger('karyawan_id')->nullable(false)->change();
            $table->dropColumn('departemen');
            $table->dropColumn('perihal');
        });

        Schema::table('pengajuan_bbm_items', function (Blueprint $table) {
            $table->date('tanggal')->nullable(false)->change();
            $table->string('tipe_bbm')->nullable(false)->change();
            $table->decimal('jumlah_liter', 10, 2)->nullable(false)->change();
            $table->decimal('harga_per_liter', 15, 2)->nullable(false)->change();
            $table->dropColumn('uraian');
        });
    }
};
