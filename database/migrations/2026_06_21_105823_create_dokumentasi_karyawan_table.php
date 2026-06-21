<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dokumentasi_karyawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumentasi_harian_id')->constrained('dokumentasi_harians')->cascadeOnDelete();
            $table->foreignId('karyawan_id')->constrained('karyawans')->cascadeOnDelete();
            $table->timestamps();
        });

        // Migrate existing data
        $existingRecords = DB::table('dokumentasi_harians')->whereNotNull('karyawan_id')->get();
        foreach ($existingRecords as $record) {
            DB::table('dokumentasi_karyawan')->insert([
                'dokumentasi_harian_id' => $record->id,
                'karyawan_id' => $record->karyawan_id,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_karyawan');
    }
};
