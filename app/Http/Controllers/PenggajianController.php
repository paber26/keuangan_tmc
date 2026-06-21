<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kebun;
use App\Models\Absensi;
use App\Models\Penggajian;
use App\Models\PenggajianDetail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PenggajianController extends Controller
{
    public function index()
    {
        $penggajians = Penggajian::orderBy('tanggal_mulai', 'desc')->get();
        return view('penggajian.index', compact('penggajians'));
    }

    public function create(Request $request)
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
                            'karyawan_id' => $karyawanId,
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
                            'karyawan_id' => $karyawanId,
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

        $dokumentasi = [];
        if ($startDate && $endDate && $selectedLokasi) {
            $dokumentasi = \App\Models\DokumentasiHarian::with(['images', 'karyawan', 'kebun'])
                ->whereDate('tanggal', '>=', $startDate)
                ->whereDate('tanggal', '<=', $endDate)
                ->whereHas('kebun', function($q) use ($selectedLokasi) {
                    $q->where('lokasi', $selectedLokasi);
                })
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('penggajian.create', compact(
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
            'totalUpahKupas',
            'dokumentasi'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'lokasi_kebun' => 'required|string',
            'tarif_harian' => 'required|numeric',
            'tarif_kupas' => 'required|numeric',
        ]);

        // Re-calculate to ensure data integrity before saving
        $start = Carbon::parse($request->tanggal_mulai);
        $end = Carbon::parse($request->tanggal_akhir);
        
        $absensis = Absensi::with('karyawan')
            ->where('lokasi', $request->lokasi_kebun)
            ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->where('status', 'Hadir')
            ->get();

        $dataHarian = [];
        $dataKupas = [];
        $totalUpahHarian = 0;
        $totalUpahKupas = 0;

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

        foreach ($dataHarian as $id => $data) {
            $dataHarian[$id]['total_upah'] = $dataHarian[$id]['total_hari'] * $request->tarif_harian;
            $totalUpahHarian += $dataHarian[$id]['total_upah'];
        }
        foreach ($dataKupas as $id => $data) {
            $dataKupas[$id]['total_upah'] = $dataKupas[$id]['total_butir'] * $request->tarif_kupas;
            $totalUpahKupas += $dataKupas[$id]['total_upah'];
        }

        // Create Penggajian
        $penggajian = Penggajian::create([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'lokasi_kebun' => $request->lokasi_kebun,
            'tarif_harian' => $request->tarif_harian,
            'tarif_kupas' => $request->tarif_kupas,
            'total_upah_harian' => $totalUpahHarian,
            'total_upah_kupas' => $totalUpahKupas,
            'total_keseluruhan' => $totalUpahHarian + $totalUpahKupas,
        ]);

        // Insert Details
        foreach ($dataHarian as $karyawanId => $data) {
            PenggajianDetail::create([
                'penggajian_id' => $penggajian->id,
                'karyawan_id' => $karyawanId,
                'nama_karyawan' => $data['nama'],
                'tipe_pekerjaan' => 'Harian',
                'jumlah_hari_kerja' => $data['total_hari'],
                'jumlah_volume' => 0,
                'total_upah' => $data['total_upah'],
                'rincian_harian' => $data['hari']
            ]);
        }

        foreach ($dataKupas as $karyawanId => $data) {
            PenggajianDetail::create([
                'penggajian_id' => $penggajian->id,
                'karyawan_id' => $karyawanId,
                'nama_karyawan' => $data['nama'],
                'tipe_pekerjaan' => 'Kupas Kelapa',
                'jumlah_hari_kerja' => 0,
                'jumlah_volume' => $data['total_butir'],
                'total_upah' => $data['total_upah'],
                'rincian_harian' => $data['hari']
            ]);
        }

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil disimpan.');
    }

    public function show($id)
    {
        $penggajian = Penggajian::with('details')->findOrFail($id);
        $period = CarbonPeriod::create(Carbon::parse($penggajian->tanggal_mulai), Carbon::parse($penggajian->tanggal_akhir));

        $dataHarian = $penggajian->details->where('tipe_pekerjaan', 'Harian');
        $dataKupas = $penggajian->details->where('tipe_pekerjaan', 'Kupas Kelapa');

        $dokumentasi = \App\Models\DokumentasiHarian::with(['images', 'karyawan', 'kebun'])
            ->whereDate('tanggal', '>=', $penggajian->tanggal_mulai)
            ->whereDate('tanggal', '<=', $penggajian->tanggal_akhir)
            ->whereHas('kebun', function($q) use ($penggajian) {
                $q->where('lokasi', $penggajian->lokasi_kebun);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('penggajian.show', compact('penggajian', 'period', 'dataHarian', 'dataKupas', 'dokumentasi'));
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->delete();

        return redirect()->route('penggajian.index')->with('success', 'Riwayat penggajian berhasil dihapus.');
    }

    public function print($id)
    {
        $penggajian = Penggajian::with('details')->findOrFail($id);
        $period = CarbonPeriod::create(Carbon::parse($penggajian->tanggal_mulai), Carbon::parse($penggajian->tanggal_akhir));

        $dataHarian = $penggajian->details->where('tipe_pekerjaan', 'Harian');
        $dataKupas = $penggajian->details->where('tipe_pekerjaan', 'Kupas Kelapa');

        $dokumentasi = \App\Models\DokumentasiHarian::with(['images'])
            ->whereDate('tanggal', '>=', $penggajian->tanggal_mulai)
            ->whereDate('tanggal', '<=', $penggajian->tanggal_akhir)
            ->whereHas('kebun', function($q) use ($penggajian) {
                $q->where('lokasi', $penggajian->lokasi_kebun);
            })
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy(function($item) {
                return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
            });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penggajian.print-pdf-saved', compact(
            'penggajian',
            'period',
            'dataHarian',
            'dataKupas',
            'dokumentasi'
        ));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('Laporan_Penggajian_' . $penggajian->lokasi_kebun . '.pdf');
    }
}
