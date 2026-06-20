<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemakaian_bbm', function (Blueprint $table) {
            $table->foreignId('karyawan_id')->nullable()->after('kebun_id')->constrained('karyawans')->nullOnDelete();
        });

        Schema::table('pengajuan_bbm', function (Blueprint $table) {
            $table->foreignId('karyawan_id')->nullable()->after('kebun_id')->constrained('karyawans')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pemakaian_bbm', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropColumn('karyawan_id');
        });

        Schema::table('pengajuan_bbm', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->dropColumn('karyawan_id');
        });
    }
};
