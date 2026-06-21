<?php

namespace App\Http\Controllers;

use App\Models\BuktiKasKebun;
use App\Models\PengajuanPenggajian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BuktiKasKebunController extends Controller
{
    public function index()
    {
        $bukti_kas_kebuns = BuktiKasKebun::with('pengajuan_penggajian')->orderBy('created_at', 'desc')->get();
        return view('bukti-kas-kebun.index', compact('bukti_kas_kebuns'));
    }

    public function create()
    {
        // Only get Pengajuan that are 'Disetujui', have penggajian_id, and do not already have a BuktiKasKebun
        $pengajuans = PengajuanPenggajian::where('status', 'Disetujui')
            ->doesntHave('bukti_kas_kebun')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bukti-kas-kebun.create', compact('pengajuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_penggajian_id' => 'required|exists:pengajuan_penggajians,id',
            'no_bukti' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $pengajuan = PengajuanPenggajian::findOrFail($request->pengajuan_penggajian_id);

        if ($pengajuan->status !== 'Disetujui') {
            return redirect()->back()->with('error', 'Pengajuan ini belum disetujui.');
        }

        BuktiKasKebun::create([
            'pengajuan_penggajian_id' => $request->pengajuan_penggajian_id,
            'no_bukti' => $request->no_bukti,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('bukti-kas-kebun.index')->with('success', 'Bukti Pengeluaran Kas Kebun berhasil dibuat!');
    }

    public function show(BuktiKasKebun $bukti_kas_kebun)
    {
        $bukti_kas_kebun->load(['pengajuan_penggajian.penggajian.details.karyawan.jabatans']);
        return view('bukti-kas-kebun.show', compact('bukti_kas_kebun'));
    }

    public function edit(BuktiKasKebun $bukti_kas_kebun)
    {
        $pengajuans = PengajuanPenggajian::where('status', 'Disetujui')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bukti-kas-kebun.edit', compact('bukti_kas_kebun', 'pengajuans'));
    }

    public function update(Request $request, BuktiKasKebun $bukti_kas_kebun)
    {
        $request->validate([
            'pengajuan_penggajian_id' => 'required|exists:pengajuan_penggajians,id',
            'no_bukti' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $bukti_kas_kebun->update([
            'pengajuan_penggajian_id' => $request->pengajuan_penggajian_id,
            'no_bukti' => $request->no_bukti,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('bukti-kas-kebun.index')->with('success', 'Bukti Pengeluaran Kas Kebun berhasil diperbarui!');
    }

    public function destroy(BuktiKasKebun $bukti_kas_kebun)
    {
        $bukti_kas_kebun->delete();
        return redirect()->route('bukti-kas-kebun.index')->with('success', 'Bukti Pengeluaran Kas Kebun berhasil dihapus!');
    }

    public function print(BuktiKasKebun $bukti_kas_kebun)
    {
        $bukti_kas_kebun->load(['pengajuan_penggajian.penggajian.details.karyawan.jabatans']);
        
        $pdf = Pdf::loadView('bukti-kas-kebun.print-pdf', compact('bukti_kas_kebun'));
        $pdf->setPaper('a5', 'landscape');
        
        return $pdf->stream('Bukti_Kas_Kebun_'.$bukti_kas_kebun->id.'.pdf');
    }
}
