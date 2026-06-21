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
        Schema::table('pemakaian_bbm', function (Blueprint $table) {
            $table->enum('kategori', ['Kebun', 'Sopir'])->default('Kebun')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemakaian_bbm', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
