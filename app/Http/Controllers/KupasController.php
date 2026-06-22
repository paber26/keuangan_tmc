<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kebun;
use App\Models\Absensi;

class KupasController extends Controller
{
    public function index(Request $request)
    {
        $lokasiList = Kebun::getVirtualLokasiList();
        
        // Session logic
        if (!$request->has('lokasi') && !$request->has('month')) {
            if (session()->has('kupas_last_lokasi') || session()->has('kupas_last_month')) {
                return redirect()->route('kupas.index', [
                    'lokasi' => session('kupas_last_lokasi', 'Semua Kebun'),
                    'month' => session('kupas_last_month', date('Y-m')),
                ]);
            }
        }

        if ($request->has('lokasi')) session(['kupas_last_lokasi' => $request->lokasi]);
        if ($request->has('month')) session(['kupas_last_month' => $request->month]);

        $selectedLokasi = $request->get('lokasi', 'Semua Kebun');
        $selectedMonth = $request->get('month', date('Y-m'));

        $query = Absensi::with('karyawan')->where('jabatan', 'Kupas Kelapa');
        
        if ($selectedLokasi !== 'Semua Kebun') {
            $query->where('lokasi', $selectedLokasi);
        }

        if (!empty($selectedMonth)) {
            $year = substr($selectedMonth, 0, 4);
            $month = substr($selectedMonth, 5, 2);
            $query->whereYear('tanggal', $year)->whereMonth('tanggal', $month);
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
            'lokasiList', 'selectedLokasi', 'selectedMonth',
            'dataRekap', 'grandTotalButir'
        ));
    }
}
