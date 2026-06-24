<?php

namespace App\Http\Controllers;

use App\Models\PengajuanKasGantung;
use App\Models\PengajuanKasGantungItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanKasGantungController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanKasGantung::orderBy('tanggal', 'desc')->get();
        return view('pengajuan-kas-gantung.index', compact('pengajuans'));
    }

    public function create()
    {
        return view('pengajuan-kas-gantung.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'required|string|max:255',
            'pengajuan_kebutuhan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
            'keterangan_pengajuan' => 'nullable|array',
            'keterangan_pengajuan.*' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $grandTotal += ($request->qty[$i] * $request->harga_satuan[$i]);
            }

            $pengajuan = PengajuanKasGantung::create([
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan,
                'pengajuan_kebutuhan' => $request->pengajuan_kebutuhan,
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal
            ]);

            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $totalHarga = $request->qty[$i] * $request->harga_satuan[$i];
                PengajuanKasGantungItem::create([
                    'pengajuan_kas_gantung_id' => $pengajuan->id,
                    'nama_barang' => $request->nama_barang[$i],
                    'qty' => $request->qty[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'total_harga' => $totalHarga,
                    'keterangan_pengajuan' => $request->keterangan_pengajuan[$i] ?? null
                ]);
            }

            DB::commit();

            return redirect()->route('pengajuan-kas-gantung.index')->with('success', 'Pengajuan Kas Gantung berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $pengajuan_kas_gantung = PengajuanKasGantung::with('items')->findOrFail($id);
        return view('pengajuan-kas-gantung.show', compact('pengajuan_kas_gantung'));
    }

    public function edit($id)
    {
        $pengajuan_kas_gantung = PengajuanKasGantung::with('items')->findOrFail($id);
        return view('pengajuan-kas-gantung.edit', compact('pengajuan_kas_gantung'));
    }

    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanKasGantung::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'required|string|max:255',
            'pengajuan_kebutuhan' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
            'keterangan_pengajuan' => 'nullable|array',
            'keterangan_pengajuan.*' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $grandTotal += ($request->qty[$i] * $request->harga_satuan[$i]);
            }

            $pengajuan->update([
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan,
                'pengajuan_kebutuhan' => $request->pengajuan_kebutuhan,
                'keterangan' => $request->keterangan,
                'grand_total' => $grandTotal
            ]);

            $pengajuan->items()->delete();

            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $totalHarga = $request->qty[$i] * $request->harga_satuan[$i];
                PengajuanKasGantungItem::create([
                    'pengajuan_kas_gantung_id' => $pengajuan->id,
                    'nama_barang' => $request->nama_barang[$i],
                    'qty' => $request->qty[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'total_harga' => $totalHarga,
                    'keterangan_pengajuan' => $request->keterangan_pengajuan[$i] ?? null
                ]);
            }

            DB::commit();

            return redirect()->route('pengajuan-kas-gantung.index')->with('success', 'Pengajuan Kas Gantung berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
        ]);

        $pengajuan = PengajuanKasGantung::findOrFail($id);
        $pengajuan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengajuan = PengajuanKasGantung::findOrFail($id);
        $pengajuan->delete();
        return redirect()->route('pengajuan-kas-gantung.index')->with('success', 'Pengajuan Kas Gantung berhasil dihapus.');
    }

    public function print($id)
    {
        $pengajuan_kas_gantung = PengajuanKasGantung::with('items')->findOrFail($id);
        
        $pdf = Pdf::loadView('pengajuan-kas-gantung.print-pdf', compact('pengajuan_kas_gantung'));
        
        // Use A5 landscape format
        $pdf->setPaper('a5', 'landscape');
        
        return $pdf->stream('Pengajuan-Kas-Gantung-'.$pengajuan_kas_gantung->id.'.pdf');
    }
}
