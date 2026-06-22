<?php

namespace App\Exports;

use App\Models\PengajuanPenggajian;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PengajuanPenggajianExport implements FromView, ShouldAutoSize, WithDrawings
{
    protected $pengajuan;

    public function __construct(PengajuanPenggajian $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function view(): View
    {
        return view('pengajuan-penggajian.export-excel', [
            'pengajuan_penggajian' => $this->pengajuan
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
        // We will put it in cell A1, and we should make row 1 high enough in the view
        $drawing->setCoordinates('A1');

        return [$drawing];
    }
}
