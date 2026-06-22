<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kebun;
use App\Models\Absensi;

class PanenController extends Controller
{
    public function index(Request $request)
    {
        $lokasiList = Kebun::getVirtualLokasiList();
        
        // Session logic
        if (!$request->has('lokasi') && !$request->has('month')) {
            if (session()->has('panen_last_lokasi') || session()->has('panen_last_month')) {
                return redirect()->route('panen.index', [
                    'lokasi' => session('panen_last_lokasi', 'Semua Kebun'),
                    'month' => session('panen_last_month', date('Y-m')),
                ]);
            }
        }

        if ($request->has('lokasi')) session(['panen_last_lokasi' => $request->lokasi]);
        if ($request->has('month')) session(['panen_last_month' => $request->month]);

        $selectedLokasi = $request->get('lokasi', 'Semua Kebun');
        $selectedMonth = $request->get('month', date('Y-m'));

        $query = Absensi::with('karyawan')->where('jabatan', 'Pemanjat Kelapa');
        
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
            'lokasiList', 'selectedLokasi', 'selectedMonth',
            'dataRekap', 'grandTotalPohon', 'grandTotalUpah'
        ));
    }
}
