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

    public function edit(PengajuanBBM $pengajuan_bbm)
    {
        $kebun = Kebun::orderBy('lokasi')->get()->unique('lokasi');
        $karyawan = Karyawan::orderBy('nama')->get();
        
        $pemakaian_laporans = PemakaianBBM::with(['kebun', 'karyawan', 'items'])
            ->orderBy('tanggal', 'desc')
            ->limit(50)
            ->get();
            
        $pengajuan_bbm->load('items');

        return view('pengajuan-bbm.edit', compact('pengajuan_bbm', 'kebun', 'karyawan', 'pemakaian_laporans'));
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
            'tipe_bbm' => 'required|array|min:1',
            'tipe_bbm.*' => 'required|string|in:Solar,Pertalite',
            'jumlah_liter' => 'required|array|min:1',
            'jumlah_liter.*' => 'required|numeric|min:0',
            'harga_per_liter' => 'required|array|min:1',
            'harga_per_liter.*' => 'required|numeric|min:0',
            'total_harga' => 'required|array|min:1',
            'total_harga.*' => 'required|numeric|min:0',
            'keterangan_pengajuan' => 'required|array|min:1',
            'keterangan_pengajuan.*' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->total_harga); $i++) {
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

            foreach ($request->tipe_bbm as $index => $tipe) {
                PengajuanBBMItem::create([
                    'pengajuan_bbm_id' => $pengajuan->id,
                    'tipe_bbm' => $tipe,
                    'jumlah_liter' => $request->jumlah_liter[$index],
                    'harga_per_liter' => $request->harga_per_liter[$index],
                    'uraian' => strtoupper($tipe) . ' ' . $request->jumlah_liter[$index] . ' L',
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

    public function update(Request $request, PengajuanBBM $pengajuan_bbm)
    {
        $request->validate([
            'kebun_id' => 'required|exists:kebuns,id',
            'departemen' => 'required|string',
            'perihal' => 'required|string',
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tipe_bbm' => 'required|array|min:1',
            'tipe_bbm.*' => 'required|string|in:Solar,Pertalite',
            'jumlah_liter' => 'required|array|min:1',
            'jumlah_liter.*' => 'required|numeric|min:0',
            'harga_per_liter' => 'required|array|min:1',
            'harga_per_liter.*' => 'required|numeric|min:0',
            'total_harga' => 'required|array|min:1',
            'total_harga.*' => 'required|numeric|min:0',
            'keterangan_pengajuan' => 'required|array|min:1',
            'keterangan_pengajuan.*' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->total_harga); $i++) {
                $grandTotal += $request->total_harga[$i];
            }

            $pengajuan_bbm->update([
                'kebun_id' => $request->kebun_id,
                'departemen' => $request->departemen,
                'perihal' => $request->perihal,
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan ?? 'Pengajuan BBM',
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal,
            ]);

            $pengajuan_bbm->items()->delete();

            foreach ($request->tipe_bbm as $index => $tipe) {
                PengajuanBBMItem::create([
                    'pengajuan_bbm_id' => $pengajuan_bbm->id,
                    'tipe_bbm' => $tipe,
                    'jumlah_liter' => $request->jumlah_liter[$index],
                    'harga_per_liter' => $request->harga_per_liter[$index],
                    'uraian' => strtoupper($tipe) . ' ' . $request->jumlah_liter[$index] . ' L',
                    'total_harga' => $request->total_harga[$index],
                    'keterangan_pengajuan' => $request->keterangan_pengajuan[$index] ?? '-',
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan-bbm.index')->with('success', 'Pengajuan BBM berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
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
