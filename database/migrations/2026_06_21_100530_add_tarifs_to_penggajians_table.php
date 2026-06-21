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
        Schema::table('penggajians', function (Blueprint $table) {
            $table->decimal('tarif_pemanjat', 12, 2)->default(10000)->after('tarif_kupas');
            $table->decimal('tarif_pemetik', 12, 2)->default(14000)->after('tarif_pemanjat');
            $table->decimal('total_upah_pemanjat', 15, 2)->default(0)->after('total_upah_kupas');
            $table->decimal('total_upah_pemetik', 15, 2)->default(0)->after('total_upah_pemanjat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penggajians', function (Blueprint $table) {
            $table->dropColumn(['tarif_pemanjat', 'tarif_pemetik', 'total_upah_pemanjat', 'total_upah_pemetik']);
        });
    }
};
