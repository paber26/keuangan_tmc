<?php

namespace App\Http\Controllers;

use App\Models\PemakaianBBM;
use App\Models\PemakaianBBMItem;
use App\Models\Kebun;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemakaianBBMController extends Controller
{
    public function index()
    {
        $pemakaian = PemakaianBBM::with(['kebun', 'karyawan'])->orderBy('tanggal', 'desc')->get();
        return view('pemakaian-bbm.index', compact('pemakaian'));
    }

    public function create()
    {
        $kebun = Kebun::orderBy('lokasi')->get()->unique('lokasi');
        $karyawan = Karyawan::orderBy('nama')->get();
        return view('pemakaian-bbm.create', compact('kebun', 'karyawan'));
    }

    public function edit(string $id)
    {
        $pemakaian_bbm = PemakaianBBM::with('items')->findOrFail($id);
        $kebun = Kebun::orderBy('lokasi')->get()->unique('lokasi');
        $karyawan = Karyawan::orderBy('nama')->get();
        return view('pemakaian-bbm.edit', compact('pemakaian_bbm', 'kebun', 'karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kebun_id' => 'required|exists:kebuns,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'judul_laporan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'keterangan_pemakaian' => 'required|array|min:1',
            'keterangan_pemakaian.*' => 'required|string|max:255',
            'tanggal_pemakaian' => 'required|array|min:1',
            'tanggal_pemakaian.*' => 'required|date',
            'tipe_bbm' => 'required|array|min:1',
            'tipe_bbm.*' => 'required|in:Solar,Pertalite',
            'jumlah_liter' => 'required|array|min:1',
            'jumlah_liter.*' => 'required|numeric|min:0.01',
            'harga_per_liter' => 'required|array',
            'harga_per_liter.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $pemakaian = PemakaianBBM::findOrFail($id);
            $pemakaian->update([
                'kebun_id' => $request->kebun_id,
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'judul_laporan' => $request->judul_laporan,
                'keterangan' => $request->keterangan,
            ]);

            // Delete existing items
            $pemakaian->items()->delete();

            $grandTotal = 0;
            foreach ($request->keterangan_pemakaian as $index => $ket) {
                $liter = $request->jumlah_liter[$index];
                $harga = $request->harga_per_liter[$index];
                $total = $liter * $harga;
                $grandTotal += $total;

                PemakaianBBMItem::create([
                    'pemakaian_bbm_id' => $pemakaian->id,
                    'tanggal' => $request->tanggal_pemakaian[$index],
                    'tipe_bbm' => $request->tipe_bbm[$index],
                    'keterangan_pemakaian' => $ket,
                    'jumlah_liter' => $liter,
                    'harga_per_liter' => $harga,
                    'total_harga' => $total,
                ]);
            }

            $pemakaian->update(['grand_total' => $grandTotal]);

            DB::commit();
            return redirect()->route('pemakaian-bbm.index')->with('success', 'Laporan pemakaian BBM berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'kebun_id' => 'required|exists:kebuns,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal' => 'required|date',
            'judul_laporan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'keterangan_pemakaian' => 'required|array|min:1',
            'keterangan_pemakaian.*' => 'required|string|max:255',
            'tanggal_pemakaian' => 'required|array|min:1',
            'tanggal_pemakaian.*' => 'required|date',
            'tipe_bbm' => 'required|array|min:1',
            'tipe_bbm.*' => 'required|in:Solar,Pertalite',
            'jumlah_liter' => 'required|array|min:1',
            'jumlah_liter.*' => 'required|numeric|min:0.01',
            'harga_per_liter' => 'required|array',
            'harga_per_liter.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;

            $pemakaian = PemakaianBBM::create([
                'kebun_id' => $request->kebun_id,
                'karyawan_id' => $request->karyawan_id,
                'tanggal' => $request->tanggal,
                'judul_laporan' => $request->judul_laporan,
                'keterangan' => $request->keterangan,
                'grand_total' => 0
            ]);

            foreach ($request->keterangan_pemakaian as $index => $ket) {
                $liter = $request->jumlah_liter[$index];
                $harga = $request->harga_per_liter[$index];
                $total = $liter * $harga;
                $grandTotal += $total;

                PemakaianBBMItem::create([
                    'pemakaian_bbm_id' => $pemakaian->id,
                    'tanggal' => $request->tanggal_pemakaian[$index],
                    'tipe_bbm' => $request->tipe_bbm[$index],
                    'keterangan_pemakaian' => $ket,
                    'jumlah_liter' => $liter,
                    'harga_per_liter' => $harga,
                    'total_harga' => $total,
                ]);
            }

            $pemakaian->update(['grand_total' => $grandTotal]);

            DB::commit();
            return redirect()->route('pemakaian-bbm.index')->with('success', 'Laporan pemakaian BBM berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(PemakaianBBM $pemakaian_bbm)
    {
        $pemakaian_bbm->load(['items', 'kebun', 'karyawan']);
        return view('pemakaian-bbm.show', compact('pemakaian_bbm'));
    }

    public function destroy(PemakaianBBM $pemakaian_bbm)
    {
        $pemakaian_bbm->delete();
        return redirect()->route('pemakaian-bbm.index')->with('success', 'Data pemakaian BBM berhasil dihapus.');
    }
}
