<?php

namespace App\Exports;

use App\Models\Pengajuan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PengajuanExport implements FromView, ShouldAutoSize
{
    protected $pengajuan;

    public function __construct(Pengajuan $pengajuan)
    {
        $this->pengajuan = $pengajuan;
    }

    public function view(): View
    {
        // Kita pakai view khusus excel yang hanya berisi tag <table> murni
        return view('pengajuan.export-excel', [
            'pengajuan' => $this->pengajuan
        ]);
    }
}
