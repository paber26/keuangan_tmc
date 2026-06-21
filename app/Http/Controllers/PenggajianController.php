<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kebun;
use App\Models\Absensi;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PenggajianController extends Controller
{
    public function index(Request $request)
    {
        $lokasiList = Kebun::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');

        $selectedLokasi = $request->get('lokasi', $lokasiList->first());
        
        $now = Carbon::now();
        $startDate = $request->get('start_date', $now->startOfWeek()->format('Y-m-d'));
        $endDate = $request->get('end_date', $now->endOfWeek()->subDay()->format('Y-m-d'));
        
        $tarifHarian = $request->get('tarif_harian', 125000);
        $tarifKupas = $request->get('tarif_kupas', 200);

        $period = [];
        $dataHarian = [];
        $dataKupas = [];
        
        $totalUpahHarian = 0;
        $totalUpahKupas = 0;

        if ($selectedLokasi && $startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $period = CarbonPeriod::create($start, $end);

            $absensis = Absensi::with('karyawan')
                ->where('lokasi', $selectedLokasi)
                ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->where('status', 'Hadir')
                ->get();

            foreach ($absensis as $absensi) {
                $jabatan = $absensi->jabatan ?: ($absensi->karyawan->jabatans->first()->nama ?? 'Tidak Diketahui');
                $karyawanId = $absensi->karyawan_id;
                $nama = $absensi->karyawan->nama ?? 'Tidak Diketahui';

                if ($jabatan === 'Kupas Kelapa') {
                    if (!isset($dataKupas[$karyawanId])) {
                        $dataKupas[$karyawanId] = [
                            'nama' => $nama,
                            'hari' => [],
                            'total_butir' => 0,
                            'total_upah' => 0
                        ];
                    }
                    $dataKupas[$karyawanId]['hari'][$absensi->tanggal] = $absensi->volume;
                    $dataKupas[$karyawanId]['total_butir'] += $absensi->volume;
                } else {
                    if (!isset($dataHarian[$karyawanId])) {
                        $dataHarian[$karyawanId] = [
                            'nama' => $nama,
                            'hari' => [],
                            'total_hari' => 0,
                            'total_upah' => 0
                        ];
                    }
                    $dataHarian[$karyawanId]['hari'][$absensi->tanggal] = 'V';
                    $dataHarian[$karyawanId]['total_hari'] += 1;
                }
            }

            // Calculate Upah
            foreach ($dataHarian as $id => &$data) {
                $data['total_upah'] = $data['total_hari'] * $tarifHarian;
                $totalUpahHarian += $data['total_upah'];
            }
            foreach ($dataKupas as $id => &$data) {
                $data['total_upah'] = $data['total_butir'] * $tarifKupas;
                $totalUpahKupas += $data['total_upah'];
            }
        }

        return view('penggajian.index', compact(
            'lokasiList',
            'selectedLokasi',
            'startDate',
            'endDate',
            'tarifHarian',
            'tarifKupas',
            'period',
            'dataHarian',
            'dataKupas',
            'totalUpahHarian',
            'totalUpahKupas'
        ));
    }

    public function print(Request $request)
    {
        $lokasiList = Kebun::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');

        $selectedLokasi = $request->get('lokasi', $lokasiList->first());
        
        $now = Carbon::now();
        $startDate = $request->get('start_date', $now->startOfWeek()->format('Y-m-d'));
        $endDate = $request->get('end_date', $now->endOfWeek()->subDay()->format('Y-m-d'));
        
        $tarifHarian = $request->get('tarif_harian', 125000);
        $tarifKupas = $request->get('tarif_kupas', 200);

        $period = [];
        $dataHarian = [];
        $dataKupas = [];
        
        $totalUpahHarian = 0;
        $totalUpahKupas = 0;

        if ($selectedLokasi && $startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $period = CarbonPeriod::create($start, $end);

            $absensis = Absensi::with('karyawan')
                ->where('lokasi', $selectedLokasi)
                ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->where('status', 'Hadir')
                ->get();

            foreach ($absensis as $absensi) {
                $jabatan = $absensi->jabatan ?: ($absensi->karyawan->jabatans->first()->nama ?? 'Tidak Diketahui');
                $karyawanId = $absensi->karyawan_id;
                $nama = $absensi->karyawan->nama ?? 'Tidak Diketahui';

                if ($jabatan === 'Kupas Kelapa') {
                    if (!isset($dataKupas[$karyawanId])) {
                        $dataKupas[$karyawanId] = [
                            'nama' => $nama,
                            'hari' => [],
                            'total_butir' => 0,
                            'total_upah' => 0
                        ];
                    }
                    $dataKupas[$karyawanId]['hari'][$absensi->tanggal] = $absensi->volume;
                    $dataKupas[$karyawanId]['total_butir'] += $absensi->volume;
                } else {
                    if (!isset($dataHarian[$karyawanId])) {
                        $dataHarian[$karyawanId] = [
                            'nama' => $nama,
                            'hari' => [],
                            'total_hari' => 0,
                            'total_upah' => 0
                        ];
                    }
                    $dataHarian[$karyawanId]['hari'][$absensi->tanggal] = 'V';
                    $dataHarian[$karyawanId]['total_hari'] += 1;
                }
            }

            foreach ($dataHarian as $id => &$data) {
                $data['total_upah'] = $data['total_hari'] * $tarifHarian;
                $totalUpahHarian += $data['total_upah'];
            }
            foreach ($dataKupas as $id => &$data) {
                $data['total_upah'] = $data['total_butir'] * $tarifKupas;
                $totalUpahKupas += $data['total_upah'];
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penggajian.print-pdf', compact(
            'selectedLokasi',
            'startDate',
            'endDate',
            'tarifHarian',
            'tarifKupas',
            'period',
            'dataHarian',
            'dataKupas',
            'totalUpahHarian',
            'totalUpahKupas'
        ));

        // Use portrait as requested
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->stream('Laporan-Penggajian-'.$selectedLokasi.'.pdf');
    }
}
