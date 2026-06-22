<?php
$details = App\Models\PenggajianDetail::whereNull('jabatan')->get();
foreach($details as $detail) {
    if($detail->tipe_pekerjaan === 'Borongan') {
        $penggajian = $detail->penggajian;
        if($penggajian->tarif_kupas > 0 && $detail->total_upah == $detail->jumlah_volume * $penggajian->tarif_kupas) {
            $detail->jabatan = 'Kupas Kelapa';
        } elseif($penggajian->tarif_pemanjat > 0 && $detail->total_upah == $detail->jumlah_volume * $penggajian->tarif_pemanjat) {
            $detail->jabatan = 'Pemanjat Kelapa';
        } elseif($penggajian->tarif_pemetik > 0 && $detail->total_upah == $detail->jumlah_volume * $penggajian->tarif_pemetik) {
            $detail->jabatan = 'Pemetik Cengkeh';
        } else {
            $detail->jabatan = 'Borongan';
        }
        $detail->save();
        echo "Fixed Borongan for " . $detail->nama_karyawan . " to " . $detail->jabatan . "\n";
    } else {
        // Harian
        $isMemaras = false;
        $penggajian = $detail->penggajian;
        if ($penggajian->tarif_memaras > 0 && $detail->total_upah == $detail->jumlah_hari_kerja * $penggajian->tarif_memaras) {
            $isMemaras = true;
            $detail->jabatan = 'Memaras Mesin';
        } else {
            // try to get from absensi
            $absensi = App\Models\Absensi::where('karyawan_id', $detail->karyawan_id)
                ->whereBetween('tanggal', [$penggajian->tanggal_mulai, $penggajian->tanggal_akhir])
                ->whereNotNull('jabatan')
                ->first();
            if($absensi && !in_array($absensi->jabatan, ['Kupas Kelapa', 'Pemanjat Kelapa', 'Pemetik Cengkeh'])) {
                $detail->jabatan = $absensi->jabatan;
            } else {
                $detail->jabatan = $detail->karyawan->jabatans->first()->nama ?? 'Harian';
            }
        }
        $detail->save();
        echo "Fixed Harian for " . $detail->nama_karyawan . " to " . $detail->jabatan . "\n";
    }
}
