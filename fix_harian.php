<?php
$details = App\Models\PenggajianDetail::where('tipe_pekerjaan', 'Harian')->get();
foreach($details as $detail) {
    $penggajian = $detail->penggajian;
    // Find absensi that is NOT Borongan
    $absensi = App\Models\Absensi::where('karyawan_id', $detail->karyawan_id)
        ->whereBetween('tanggal', [$penggajian->tanggal_mulai, $penggajian->tanggal_akhir])
        ->whereNotIn('jabatan', ['Kupas Kelapa', 'Pemanjat Kelapa', 'Pemetik Cengkeh'])
        ->whereNotNull('jabatan')
        ->first();
        
    if ($absensi) {
        $detail->jabatan = $absensi->jabatan;
        $detail->save();
        echo "Fixed Harian for " . $detail->nama_karyawan . " to " . $detail->jabatan . "\n";
    } elseif (in_array($detail->jabatan, ['Kupas Kelapa', 'Pemanjat Kelapa', 'Pemetik Cengkeh'])) {
        $detail->jabatan = 'Harian Kumpul'; // Fallback
        $detail->save();
        echo "Fixed Fallback Harian for " . $detail->nama_karyawan . " to Harian Kumpul\n";
    }
}
