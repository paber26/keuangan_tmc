<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        // Kita menggunakan view blade yang khusus excel (tabel murni)
        return view('laporan.export.rekap-mingguan-excel');
    }
}
