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
        Schema::table('bukti_bank_kebuns', function (Blueprint $table) {
            $table->string('ditransfer_ke')->nullable()->after('keterangan');
            $table->string('bank_rek_tujuan')->nullable()->after('ditransfer_ke');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukti_bank_kebuns', function (Blueprint $table) {
            $table->dropColumn(['ditransfer_ke', 'bank_rek_tujuan']);
        });
    }
};
