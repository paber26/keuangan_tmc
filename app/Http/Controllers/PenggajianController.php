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
        $tarifMemaras = $request->get('tarif_memaras', 250000);
        $tarifKupas = $request->get('tarif_kupas', 200);
        $tarifPemanjat = $request->get('tarif_pemanjat', 10000);
        $tarifPemetik = $request->get('tarif_pemetik', 14000);

        $period = [];
        $dataHarian = [];
        $dataBorongan = [];
        
        $totalUpahHarian = 0;
        $totalUpahBorongan = 0;

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
                if (strtolower($jabatan) === 'momaras mesin') {
                    $jabatan = 'Memaras Mesin';
                }
                $karyawanId = $absensi->karyawan_id;
                $nama = $absensi->karyawan->nama ?? 'Tidak Diketahui';

                if (in_array($jabatan, ['Kupas Kelapa', 'Pemanjat Kelapa', 'Pemetik Cengkeh'])) {
                    if (!isset($dataBorongan[$karyawanId])) {
                        $dataBorongan[$karyawanId] = [
                            'karyawan_id' => $karyawanId,
                            'nama' => $nama,
                            'jabatan' => $jabatan,
                            'hari' => [],
                            'total_volume' => 0,
                            'total_upah' => 0
                        ];
                    }
                    $dataBorongan[$karyawanId]['hari'][$absensi->tanggal] = $absensi->volume;
                    $dataBorongan[$karyawanId]['total_volume'] += $absensi->volume;
                } else {
                    if (!isset($dataHarian[$karyawanId])) {
                        $dataHarian[$karyawanId] = [
                            'karyawan_id' => $karyawanId,
                            'nama' => $nama,
                            'jabatan' => $jabatan,
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
                $tarif = $data['jabatan'] === 'Memaras Mesin' ? $tarifMemaras : $tarifHarian;
                $data['total_upah'] = $data['total_hari'] * $tarif;
                $totalUpahHarian += $data['total_upah'];
            }
            foreach ($dataBorongan as $id => &$data) {
                $tarif = 0;
                if ($data['jabatan'] === 'Kupas Kelapa') $tarif = $tarifKupas;
                elseif ($data['jabatan'] === 'Pemanjat Kelapa') $tarif = $tarifPemanjat;
                elseif ($data['jabatan'] === 'Pemetik Cengkeh') $tarif = $tarifPemetik;
                
                $data['total_upah'] = $data['total_volume'] * $tarif;
                $totalUpahBorongan += $data['total_upah'];
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
                ->orderBy('tanggal', 'asc')
                ->get()
                ->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d');
                });
        }

        return view('penggajian.create', compact(
            'lokasiList',
            'selectedLokasi',
            'startDate',
            'endDate',
            'tarifHarian',
            'tarifMemaras',
            'tarifKupas',
            'tarifPemanjat',
            'tarifPemetik',
            'period',
            'dataHarian',
            'dataBorongan',
            'totalUpahHarian',
            'totalUpahBorongan',
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
            'tarif_pemanjat' => 'required|numeric',
            'tarif_pemetik' => 'required|numeric',
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
        $dataBorongan = [];
        $totalUpahHarian = 0;
        $totalUpahBorongan = 0;
        $totalUpahPemanjat = 0;
        $totalUpahPemetik = 0;
        $totalUpahKupas = 0;

        foreach ($absensis as $absensi) {
            $jabatan = $absensi->jabatan ?: ($absensi->karyawan->jabatans->first()->nama ?? 'Tidak Diketahui');
            if (strtolower($jabatan) === 'momaras mesin') {
                $jabatan = 'Memaras Mesin';
            }
            $karyawanId = $absensi->karyawan_id;
            $nama = $absensi->karyawan->nama ?? 'Tidak Diketahui';

            if (in_array($jabatan, ['Kupas Kelapa', 'Pemanjat Kelapa', 'Pemetik Cengkeh'])) {
                if (!isset($dataBorongan[$karyawanId])) {
                    $dataBorongan[$karyawanId] = [
                        'nama' => $nama,
                        'jabatan' => $jabatan,
                        'hari' => [],
                        'total_volume' => 0,
                        'total_upah' => 0
                    ];
                }
                $dataBorongan[$karyawanId]['hari'][$absensi->tanggal] = $absensi->volume;
                $dataBorongan[$karyawanId]['total_volume'] += $absensi->volume;
            } else {
                if (!isset($dataHarian[$karyawanId])) {
                    $dataHarian[$karyawanId] = [
                        'nama' => $nama,
                        'jabatan' => $jabatan,
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
            $tarif = $data['jabatan'] === 'Memaras Mesin' ? $request->tarif_memaras : $request->tarif_harian;
            $dataHarian[$id]['total_upah'] = $dataHarian[$id]['total_hari'] * $tarif;
            $totalUpahHarian += $dataHarian[$id]['total_upah'];
        }
        foreach ($dataBorongan as $id => $data) {
            $tarif = 0;
            if ($data['jabatan'] === 'Kupas Kelapa') $tarif = $request->tarif_kupas;
            elseif ($data['jabatan'] === 'Pemanjat Kelapa') $tarif = $request->tarif_pemanjat;
            elseif ($data['jabatan'] === 'Pemetik Cengkeh') $tarif = $request->tarif_pemetik;
            
            $dataBorongan[$id]['total_upah'] = $data['total_volume'] * $tarif;
            $totalUpahBorongan += $dataBorongan[$id]['total_upah'];

            if ($data['jabatan'] === 'Kupas Kelapa') $totalUpahKupas += $dataBorongan[$id]['total_upah'];
            elseif ($data['jabatan'] === 'Pemanjat Kelapa') $totalUpahPemanjat += $dataBorongan[$id]['total_upah'];
            elseif ($data['jabatan'] === 'Pemetik Cengkeh') $totalUpahPemetik += $dataBorongan[$id]['total_upah'];
        }

        // Create Penggajian
        $penggajian = Penggajian::create([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'lokasi_kebun' => $request->lokasi_kebun,
            'tarif_harian' => $request->tarif_harian,
            'tarif_memaras' => $request->tarif_memaras,
            'tarif_kupas' => $request->tarif_kupas,
            'tarif_pemanjat' => $request->tarif_pemanjat,
            'tarif_pemetik' => $request->tarif_pemetik,
            'total_upah_harian' => $totalUpahHarian,
            'total_upah_kupas' => $totalUpahKupas,
            'total_upah_pemanjat' => $totalUpahPemanjat,
            'total_upah_pemetik' => $totalUpahPemetik,
            'total_keseluruhan' => $totalUpahHarian + $totalUpahBorongan,
        ]);

        // Insert Details
        foreach ($dataHarian as $karyawanId => $data) {
            PenggajianDetail::create([
                'penggajian_id' => $penggajian->id,
                'karyawan_id' => $karyawanId,
                'nama_karyawan' => $data['nama'],
                'jabatan' => $data['jabatan'] ?? 'Harian',
                'tipe_pekerjaan' => 'Harian',
                'jumlah_hari_kerja' => $data['total_hari'],
                'jumlah_volume' => 0,
                'total_upah' => $data['total_upah'],
                'rincian_harian' => $data['hari']
            ]);
        }

        foreach ($dataBorongan as $karyawanId => $data) {
            PenggajianDetail::create([
                'penggajian_id' => $penggajian->id,
                'karyawan_id' => $karyawanId,
                'nama_karyawan' => $data['nama'],
                'jabatan' => $data['jabatan'] ?? 'Borongan',
                'tipe_pekerjaan' => 'Borongan',
                'jumlah_hari_kerja' => 0,
                'jumlah_volume' => $data['total_volume'],
                'total_upah' => $data['total_upah'],
                'rincian_harian' => $data['hari']
            ]);
        }

        return redirect()->route('penggajian.index')->with('success', 'Data penggajian berhasil disimpan.');
    }

    public function show($id)
    {
        $penggajian = Penggajian::with(['details.karyawan.jabatans'])->findOrFail($id);
        $period = CarbonPeriod::create(Carbon::parse($penggajian->tanggal_mulai), Carbon::parse($penggajian->tanggal_akhir));

        $dataHarian = $penggajian->details->where('tipe_pekerjaan', 'Harian');
        $dataBorongan = $penggajian->details->where('tipe_pekerjaan', 'Borongan');

        $dokumentasi = \App\Models\DokumentasiHarian::with(['images', 'karyawan', 'kebun'])
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

        return view('penggajian.show', compact('penggajian', 'period', 'dataHarian', 'dataBorongan', 'dokumentasi'));
    }

    public function edit($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        return view('penggajian.edit', compact('penggajian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tarif_harian' => 'required|numeric|min:0',
            'tarif_memaras' => 'required|numeric|min:0',
            'tarif_kupas' => 'required|numeric|min:0',
            'tarif_pemanjat' => 'required|numeric|min:0',
            'tarif_pemetik' => 'required|numeric|min:0',
        ]);

        $penggajian = Penggajian::with('details')->findOrFail($id);

        $penggajian->tarif_harian = $request->tarif_harian;
        $penggajian->tarif_memaras = $request->tarif_memaras;
        $penggajian->tarif_kupas = $request->tarif_kupas;
        $penggajian->tarif_pemanjat = $request->tarif_pemanjat;
        $penggajian->tarif_pemetik = $request->tarif_pemetik;

        $totalHarian = 0;
        $totalKupas = 0;
        $totalPemanjat = 0;
        $totalPemetik = 0;

        foreach ($penggajian->details as $detail) {
            if ($detail->tipe_pekerjaan === 'Harian') {
                $isMemaras = in_array(strtolower($detail->jabatan), ['memaras mesin', 'momaras mesin']);
                $tarif = $isMemaras ? $request->tarif_memaras : $request->tarif_harian;
                $detail->total_upah = $detail->jumlah_hari_kerja * $tarif;
                $totalHarian += $detail->total_upah;
                
                // Update jabatan typo to correct one if necessary
                if (strtolower($detail->jabatan) === 'momaras mesin') {
                    $detail->jabatan = 'Memaras Mesin';
                }
                
                $detail->save();
            } else if ($detail->tipe_pekerjaan === 'Borongan') {
                if ($detail->jabatan === 'Kupas Kelapa') {
                    $detail->total_upah = $detail->jumlah_volume * $request->tarif_kupas;
                    $totalKupas += $detail->total_upah;
                } else if ($detail->jabatan === 'Pemanjat Kelapa') {
                    $detail->total_upah = $detail->jumlah_volume * $request->tarif_pemanjat;
                    $totalPemanjat += $detail->total_upah;
                } else if ($detail->jabatan === 'Pemetik Cengkeh') {
                    $detail->total_upah = $detail->jumlah_volume * $request->tarif_pemetik;
                    $totalPemetik += $detail->total_upah;
                }
                $detail->save();
            }
        }

        $penggajian->total_upah_harian = $totalHarian;
        $penggajian->total_upah_kupas = $totalKupas;
        $penggajian->total_upah_pemanjat = $totalPemanjat;
        $penggajian->total_upah_pemetik = $totalPemetik;
        $penggajian->total_keseluruhan = $totalHarian + $totalKupas + $totalPemanjat + $totalPemetik;
        $penggajian->save();

        return redirect()->route('penggajian.show', $penggajian->id)->with('success', 'Tarif penggajian berhasil diperbarui dan total upah telah dihitung ulang.');
    }

    public function destroy($id)
    {
        $penggajian = Penggajian::findOrFail($id);
        $penggajian->delete();

        return redirect()->route('penggajian.index')->with('success', 'Riwayat penggajian berhasil dihapus.');
    }

    public function print($id)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(300);

        $penggajian = Penggajian::with(['details.karyawan.jabatans'])->findOrFail($id);
        $period = CarbonPeriod::create(Carbon::parse($penggajian->tanggal_mulai), Carbon::parse($penggajian->tanggal_akhir));

        $dataHarian = $penggajian->details->where('tipe_pekerjaan', 'Harian');
        $dataBorongan = $penggajian->details->where('tipe_pekerjaan', 'Borongan');

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

        return view('penggajian.print-pdf-saved', compact(
            'penggajian', 'period', 'dataHarian', 'dataBorongan', 'dokumentasi'
        ));
    }
}
