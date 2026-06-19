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
        // 1. Migrate existing data
        $karyawans = DB::table('karyawans')->get();
        
        $jabatansMap = [];
        
        // Find unique jabatans and insert them
        foreach ($karyawans as $karyawan) {
            if (!empty($karyawan->jabatan)) {
                $jabatanKey = strtolower(trim($karyawan->jabatan));
                if (!isset($jabatansMap[$jabatanKey])) {
                    $id = DB::table('jabatans')->insertGetId([
                        'nama' => trim($karyawan->jabatan),
                        'tipe_gaji' => $karyawan->tipe_gaji ?? 'Harian',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $jabatansMap[$jabatanKey] = $id;
                }
                
                // Link Karyawan with Jabatan in pivot table
                DB::table('jabatan_karyawan')->insert([
                    'karyawan_id' => $karyawan->id,
                    'jabatan_id' => $jabatansMap[$jabatanKey],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // 2. Drop columns from karyawans
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'tipe_gaji']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('jabatan')->nullable();
            $table->enum('tipe_gaji', ['Tetap', 'Harian', 'Borongan'])->default('Harian');
        });
        
        // Restore data (best effort)
        $pivots = DB::table('jabatan_karyawan')
            ->join('jabatans', 'jabatan_karyawan.jabatan_id', '=', 'jabatans.id')
            ->select('jabatan_karyawan.karyawan_id', 'jabatans.nama', 'jabatans.tipe_gaji')
            ->get();
            
        // Group by karyawan_id to take the first one (since we can only have one in the old schema)
        $restored = [];
        foreach ($pivots as $pivot) {
            if (!isset($restored[$pivot->karyawan_id])) {
                DB::table('karyawans')
                    ->where('id', $pivot->karyawan_id)
                    ->update([
                        'jabatan' => $pivot->nama,
                        'tipe_gaji' => $pivot->tipe_gaji
                    ]);
                $restored[$pivot->karyawan_id] = true;
            }
        }
    }
};
