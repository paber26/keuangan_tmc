<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBBM;
use App\Models\PengajuanBBMItem;
use App\Models\Kebun;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanBBMController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanBBM::with(['kebun', 'karyawan'])->orderBy('tanggal', 'desc')->get();
        return view('pengajuan-bbm.index', compact('pengajuan'));
    }

    public function create()
    {
        $kebun = Kebun::orderBy('nama')->get();
        $karyawan = Karyawan::orderBy('nama')->get();
        return view('pengajuan-bbm.create', compact('kebun', 'karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kebun_id' => 'required|exists:kebuns,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'keterangan_pengajuan' => 'required|array',
            'keterangan_pengajuan.*' => 'required|string',
            'jumlah_liter' => 'required|array',
            'jumlah_liter.*' => 'required|numeric|min:0.01',
            'harga_per_liter' => 'required|array',
            'harga_per_liter.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->keterangan_pengajuan); $i++) {
                $grandTotal += ($request->jumlah_liter[$i] * $request->harga_per_liter[$i]);
            }

            $pengajuan = PengajuanBBM::create([
                'kebun_id' => $request->kebun_id,
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan,
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal,
                'status' => 'Pending'
            ]);

            for ($i = 0; $i < count($request->keterangan_pengajuan); $i++) {
                $totalHarga = $request->jumlah_liter[$i] * $request->harga_per_liter[$i];
                PengajuanBBMItem::create([
                    'pengajuan_bbm_id' => $pengajuan->id,
                    'keterangan_pengajuan' => $request->keterangan_pengajuan[$i],
                    'jumlah_liter' => $request->jumlah_liter[$i],
                    'harga_per_liter' => $request->harga_per_liter[$i],
                    'total_harga' => $totalHarga
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
}
