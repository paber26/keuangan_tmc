<?php

namespace App\Http\Controllers;

use App\Models\PemakaianBBM;
use App\Models\PemakaianBBMItem;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemakaianBBMController extends Controller
{
    public function index()
    {
        $pemakaian = PemakaianBBM::with('kebun')->orderBy('tanggal', 'desc')->get();
        return view('pemakaian-bbm.index', compact('pemakaian'));
    }

    public function create()
    {
        $kebun = Kebun::orderBy('nama')->get();
        return view('pemakaian-bbm.create', compact('kebun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kebun_id' => 'required|exists:kebuns,id',
            'tanggal' => 'required|date',
            'judul_laporan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'keterangan_pemakaian' => 'required|array',
            'keterangan_pemakaian.*' => 'required|string',
            'jumlah_liter' => 'required|array',
            'jumlah_liter.*' => 'required|numeric|min:0.01',
            'harga_per_liter' => 'required|array',
            'harga_per_liter.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->keterangan_pemakaian); $i++) {
                $grandTotal += ($request->jumlah_liter[$i] * $request->harga_per_liter[$i]);
            }

            $pemakaian = PemakaianBBM::create([
                'kebun_id' => $request->kebun_id,
                'tanggal' => $request->tanggal,
                'judul_laporan' => $request->judul_laporan,
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal
            ]);

            for ($i = 0; $i < count($request->keterangan_pemakaian); $i++) {
                $totalHarga = $request->jumlah_liter[$i] * $request->harga_per_liter[$i];
                PemakaianBBMItem::create([
                    'pemakaian_bbm_id' => $pemakaian->id,
                    'keterangan_pemakaian' => $request->keterangan_pemakaian[$i],
                    'jumlah_liter' => $request->jumlah_liter[$i],
                    'harga_per_liter' => $request->harga_per_liter[$i],
                    'total_harga' => $totalHarga
                ]);
            }

            DB::commit();
            return redirect()->route('pemakaian-bbm.index')->with('success', 'Laporan pemakaian BBM berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(PemakaianBBM $pemakaian_bbm)
    {
        $pemakaian_bbm->load(['items', 'kebun']);
        return view('pemakaian-bbm.show', compact('pemakaian_bbm'));
    }

    public function destroy(PemakaianBBM $pemakaian_bbm)
    {
        $pemakaian_bbm->delete();
        return redirect()->route('pemakaian-bbm.index')->with('success', 'Data pemakaian BBM berhasil dihapus.');
    }
}
