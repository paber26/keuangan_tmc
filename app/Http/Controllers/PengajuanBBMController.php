<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBBM;
use App\Models\PengajuanBBMItem;
use App\Models\PemakaianBBM;
use App\Models\Kebun;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanBBMController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanBBM::with(['kebun', 'karyawan'])->orderBy('tanggal', 'desc')->get();
        return view('pengajuan-bbm.index', compact('pengajuan'));
    }

    public function create()
    {
        $kebun = Kebun::orderBy('lokasi')->get()->unique('lokasi');
        $karyawan = Karyawan::orderBy('nama')->get();
        
        $pemakaian_laporans = PemakaianBBM::with(['kebun', 'karyawan', 'items'])
            ->orderBy('tanggal', 'desc')
            ->limit(50)
            ->get();

        return view('pengajuan-bbm.create', compact('kebun', 'karyawan', 'pemakaian_laporans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kebun_id' => 'required|exists:kebuns,id',
            'departemen' => 'required|string',
            'perihal' => 'required|string',
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'uraian' => 'required|array|min:1',
            'uraian.*' => 'required|string|max:255',
            'total_harga' => 'required|array|min:1',
            'total_harga.*' => 'required|numeric|min:0',
            'keterangan_pengajuan' => 'required|array|min:1',
            'keterangan_pengajuan.*' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->uraian); $i++) {
                $grandTotal += $request->total_harga[$i];
            }

            $pengajuan = PengajuanBBM::create([
                'kebun_id' => $request->kebun_id,
                'departemen' => $request->departemen,
                'perihal' => $request->perihal,
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan ?? 'Pengajuan BBM',
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal,
                'status' => 'Pending'
            ]);

            foreach ($request->uraian as $index => $uraian) {
                PengajuanBBMItem::create([
                    'pengajuan_bbm_id' => $pengajuan->id,
                    'uraian' => $uraian,
                    'total_harga' => $request->total_harga[$index],
                    'keterangan_pengajuan' => $request->keterangan_pengajuan[$index] ?? '-',
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan-bbm.index')->with('success', 'Pengajuan BBM berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(PengajuanBBM $pengajuan_bbm)
    {
        $pengajuan_bbm->load(['items', 'kebun', 'karyawan']);
        return view('pengajuan-bbm.show', compact('pengajuan_bbm'));
    }

    public function updateStatus(Request $request, PengajuanBBM $pengajuan_bbm)
    {
        $request->validate(['status' => 'required|in:Pending,Disetujui,Ditolak']);
        $pengajuan_bbm->update(['status' => $request->status]);
        return back()->with('success', 'Status pengajuan BBM berhasil diperbarui!');
    }

    public function destroy(PengajuanBBM $pengajuan_bbm)
    {
        $pengajuan_bbm->delete();
        return redirect()->route('pengajuan-bbm.index')->with('success', 'Pengajuan BBM berhasil dihapus.');
    }

    public function print(PengajuanBBM $pengajuan_bbm)
    {
        $pengajuan_bbm->load('items', 'karyawan', 'kebun');
        
        $pdf = Pdf::loadView('pengajuan-bbm.print-pdf', compact('pengajuan_bbm'))
                  ->setPaper('a5', 'landscape');
        
        return $pdf->stream('Pengajuan-BBM-'.$pengajuan_bbm->id.'.pdf');
    }
}
