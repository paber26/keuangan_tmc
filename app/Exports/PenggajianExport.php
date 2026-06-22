<?php

namespace App\Exports;

use App\Models\Penggajian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Carbon\Carbon;

class PenggajianExport implements FromView, ShouldAutoSize, WithDrawings
{
    protected $penggajian;

    public function __construct(Penggajian $penggajian)
    {
        $this->penggajian = $penggajian;
    }

    public function view(): View
    {
        $dataHarian = [];
        $dataKupas = [];
        $totalUpahHarian = 0;
        $totalUpahKupas = 0;

        foreach ($this->penggajian->details as $detail) {
            $karyawanId = $detail->karyawan_id;
            if ($detail->tipe_pekerjaan == 'Harian') {
                if (!isset($dataHarian[$karyawanId])) {
                    $dataHarian[$karyawanId] = [
                        'nama' => $detail->karyawan->nama,
                        'hari' => [],
                        'total_hari' => 0,
                        'total_upah' => 0,
                        'jabatan' => $detail->karyawan->jabatans->first()->nama ?? 'TIDAK DIKETAHUI'
                    ];
                }
                $dataHarian[$karyawanId]['hari'][$detail->tanggal] = true;
                $dataHarian[$karyawanId]['total_hari']++;
                $dataHarian[$karyawanId]['total_upah'] += $detail->upah_harian;
                $totalUpahHarian += $detail->upah_harian;
            } elseif ($detail->tipe_pekerjaan == 'Kupas Kelapa') {
                if (!isset($dataKupas[$karyawanId])) {
                    $dataKupas[$karyawanId] = [
                        'nama' => $detail->karyawan->nama,
                        'hari' => [],
                        'total_butir' => 0,
                        'total_upah' => 0,
                    ];
                }
                if (!isset($dataKupas[$karyawanId]['hari'][$detail->tanggal])) {
                    $dataKupas[$karyawanId]['hari'][$detail->tanggal] = 0;
                }
                $dataKupas[$karyawanId]['hari'][$detail->tanggal] += $detail->jumlah_volume;
                $dataKupas[$karyawanId]['total_butir'] += $detail->jumlah_volume;
                $dataKupas[$karyawanId]['total_upah'] += $detail->total_upah;
                $totalUpahKupas += $detail->total_upah;
            }
        }

        $startDate = Carbon::parse($this->penggajian->tanggal_mulai);
        $endDate = Carbon::parse($this->penggajian->tanggal_akhir);
        $period = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $period[] = $date->copy();
        }

        return view('penggajian.export-excel', [
            'penggajian' => $this->penggajian,
            'selectedLokasi' => $this->penggajian->lokasi_kebun,
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'period' => $period,
            'dataHarian' => $dataHarian,
            'dataKupas' => $dataKupas,
            'totalUpahHarian' => $totalUpahHarian,
            'totalUpahKupas' => $totalUpahKupas,
            'tarifHarian' => $this->penggajian->tarif_harian,
            'tarifKupas' => $this->penggajian->tarif_kupas,
        ]);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo TMC');
        $drawing->setDescription('Logo TMC');
        
        $path = public_path('logo.jpg');
        if (file_exists($path)) {
            $drawing->setPath($path);
        }
        
        $drawing->setHeight(60);
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
