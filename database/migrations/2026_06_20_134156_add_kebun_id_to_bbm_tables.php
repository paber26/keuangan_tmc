<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemakaian_bbm', function (Blueprint $table) {
            $table->foreignId('kebun_id')->nullable()->after('id')->constrained('kebuns')->nullOnDelete();
        });

        Schema::table('pengajuan_bbm', function (Blueprint $table) {
            $table->foreignId('kebun_id')->nullable()->after('id')->constrained('kebuns')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pemakaian_bbm', function (Blueprint $table) {
            $table->dropForeign(['kebun_id']);
            $table->dropColumn('kebun_id');
        });

        Schema::table('pengajuan_bbm', function (Blueprint $table) {
            $table->dropForeign(['kebun_id']);
            $table->dropColumn('kebun_id');
        });
    }
};
