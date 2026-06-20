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
        $kebun = Kebun::orderBy('lokasi')->get()->unique('lokasi');
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
            'keterangan_pengajuan' => 'required|array|min:1',
            'keterangan_pengajuan.*' => 'required|string|max:255',
            'tanggal_pengajuan' => 'required|array|min:1',
            'tanggal_pengajuan.*' => 'required|date',
            'jumlah_liter' => 'required|array|min:1',
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

            foreach ($request->keterangan_pengajuan as $index => $ket) {
                $liter = $request->jumlah_liter[$index];
                $harga = $request->harga_per_liter[$index];
                $total = $liter * $harga;

                PengajuanBBMItem::create([
                    'pengajuan_bbm_id' => $pengajuan->id,
                    'tanggal' => $request->tanggal_pengajuan[$index],
                    'keterangan_pengajuan' => $ket,
                    'jumlah_liter' => $liter,
                    'harga_per_liter' => $harga,
                    'total_harga' => $total,
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
