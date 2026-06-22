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
        $dataHarian = $this->penggajian->details->where('tipe_pekerjaan', 'Harian');
        $dataBorongan = $this->penggajian->details->where('tipe_pekerjaan', 'Borongan');

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
            'dataBorongan' => $dataBorongan,
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
