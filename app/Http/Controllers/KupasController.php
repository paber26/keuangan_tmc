<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kebun;
use App\Models\Absensi;

class KupasController extends Controller
{
    public function index(Request $request)
    {
        $lokasiList = Kebun::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');
        
        // Session logic
        if (!$request->has('lokasi')) {
            if (session()->has('kupas_last_lokasi')) {
                return redirect()->route('kupas.index', [
                    'lokasi' => session('kupas_last_lokasi', 'Semua Kebun'),
                ]);
            }
        }

        if ($request->has('lokasi')) session(['kupas_last_lokasi' => $request->lokasi]);

        $selectedLokasi = $request->get('lokasi', 'Semua Kebun');

        $query = Absensi::with('karyawan')->where('jabatan', 'Kupas Kelapa');
        
        if ($selectedLokasi !== 'Semua Kebun') {
            $query->where('lokasi', $selectedLokasi);
        }

        $absensis = $query->get();

        $dataRekap = [];
        $grandTotalButir = 0;

        foreach ($absensis as $absensi) {
            $id = $absensi->karyawan_id;
            if (!isset($dataRekap[$id])) {
                $dataRekap[$id] = [
                    'nama' => $absensi->karyawan->nama ?? 'Tidak Diketahui',
                    'total_butir' => 0
                ];
            }
            $dataRekap[$id]['total_butir'] += $absensi->volume;
            $grandTotalButir += $absensi->volume;
        }

        // Sort by total butir desc
        usort($dataRekap, function($a, $b) {
            return $b['total_butir'] <=> $a['total_butir'];
        });

        return view('kupas.index', compact(
            'lokasiList', 'selectedLokasi', 
            'dataRekap', 'grandTotalButir'
        ));
    }
}
