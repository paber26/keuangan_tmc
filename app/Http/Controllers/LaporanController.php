<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.rekap-mingguan');
    }

    public function exportWord()
    {
        // For Word, we use a neat trick by outputting an HTML document with the MS Word content type
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=Rekap-Mingguan-TMC.doc");
        header("Pragma: no-cache");
        header("Expires: 0");

        return view('laporan.export.rekap-mingguan-word');
    }

    public function exportPdf()
    {
        $pdf = Pdf::loadView('laporan.export.rekap-mingguan-pdf');
        
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->stream('Rekap-Mingguan-TMC.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new LaporanExport, 'Rekap-Mingguan-TMC.xlsx');
    }
}
