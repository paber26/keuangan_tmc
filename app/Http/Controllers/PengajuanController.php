<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\PengajuanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function index()
    {
        $pengajuans = Pengajuan::orderBy('tanggal', 'desc')->get();
        return view('pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate grand total
            $grandTotal = 0;
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $grandTotal += ($request->qty[$i] * $request->harga_satuan[$i]);
            }

            // Create Master Pengajuan
            $pengajuan = Pengajuan::create([
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan,
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal,
                'status' => 'Menunggu'
            ]);

            // Create Detail Items
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $totalHarga = $request->qty[$i] * $request->harga_satuan[$i];
                PengajuanItem::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $request->nama_barang[$i],
                    'qty' => $request->qty[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'total_harga' => $totalHarga
                ]);
            }

            DB::commit();

            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan barang berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load('items');
        return view('pengajuan.show', compact('pengajuan'));
    }

    public function edit(Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'Menunggu') {
            return redirect()->route('pengajuan.index')->with('error', 'Hanya pengajuan dengan status Menunggu yang dapat diedit.');
        }
        $pengajuan->load('items');
        return view('pengajuan.edit', compact('pengajuan'));
    }

    public function print(Pengajuan $pengajuan)
    {
        $pengajuan->load('items');
        return view('pengajuan.print', compact('pengajuan'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        if ($pengajuan->status !== 'Menunggu') {
            return redirect()->route('pengajuan.index')->with('error', 'Hanya pengajuan dengan status Menunggu yang dapat diedit.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate grand total
            $grandTotal = 0;
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $grandTotal += ($request->qty[$i] * $request->harga_satuan[$i]);
            }

            // Update Master
            $pengajuan->update([
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan,
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal
            ]);

            // Delete old items
            $pengajuan->items()->delete();

            // Create new items
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $totalHarga = $request->qty[$i] * $request->harga_satuan[$i];
                PengajuanItem::create([
                    'pengajuan_id' => $pengajuan->id,
                    'nama_barang' => $request->nama_barang[$i],
                    'qty' => $request->qty[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'total_harga' => $totalHarga
                ]);
            }

            DB::commit();

            return redirect()->route('pengajuan.index')->with('success', 'Pengajuan barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function approve(Pengajuan $pengajuan)
    {
        $pengajuan->update(['status' => 'Disetujui']);
        return back()->with('success', 'Pengajuan berhasil disetujui!');
    }

    public function destroy(Pengajuan $pengajuan)
    {
        $pengajuan->delete();
        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
