<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('kebun_id');
            // Make kebun_id nullable since we will rely on lokasi
            $table->foreignId('kebun_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn('lokasi');
            $table->foreignId('kebun_id')->nullable(false)->change();
        });
    }
};
