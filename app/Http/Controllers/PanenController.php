<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kebun;
use App\Models\Absensi;

class PanenController extends Controller
{
    public function index(Request $request)
    {
        $lokasiList = Kebun::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');
        
        // Session logic
        if (!$request->has('lokasi')) {
            if (session()->has('panen_last_lokasi')) {
                return redirect()->route('panen.index', [
                    'lokasi' => session('panen_last_lokasi', $lokasiList->first()),
                ]);
            }
        }

        if ($request->has('lokasi')) session(['panen_last_lokasi' => $request->lokasi]);

        $selectedLokasi = $request->get('lokasi', $lokasiList->first());

        $absensis = Absensi::with('karyawan')
            ->where('lokasi', $selectedLokasi)
            ->where('jabatan', 'Pemanjat Kelapa')
            ->get();

        $dataRekap = [];
        $grandTotalPohon = 0;
        $grandTotalUpah = 0;

        foreach ($absensis as $absensi) {
            $id = $absensi->karyawan_id;
            if (!isset($dataRekap[$id])) {
                $dataRekap[$id] = [
                    'nama' => $absensi->karyawan->nama ?? 'Tidak Diketahui',
                    'total_pohon' => 0,
                    'total_upah' => 0
                ];
            }
            $dataRekap[$id]['total_pohon'] += $absensi->volume;
            $dataRekap[$id]['total_upah'] += $absensi->upah;
            $grandTotalPohon += $absensi->volume;
            $grandTotalUpah += $absensi->upah;
        }

        // Sort by total pohon desc
        usort($dataRekap, function($a, $b) {
            return $b['total_pohon'] <=> $a['total_pohon'];
        });

        return view('panen.index', compact(
            'lokasiList', 'selectedLokasi',
            'dataRekap', 'grandTotalPohon', 'grandTotalUpah'
        ));
    }
}
