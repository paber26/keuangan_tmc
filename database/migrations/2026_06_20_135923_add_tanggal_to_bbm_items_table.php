<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemakaian_bbm_items', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('pemakaian_bbm_id');
        });

        Schema::table('pengajuan_bbm_items', function (Blueprint $table) {
            $table->date('tanggal')->nullable()->after('pengajuan_bbm_id');
        });
    }

    public function down(): void
    {
        Schema::table('pemakaian_bbm_items', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });

        Schema::table('pengajuan_bbm_items', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
