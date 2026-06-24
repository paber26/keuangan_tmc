<?php

namespace App\Http\Controllers;

use App\Models\BuktiBankKebun;
use App\Models\BuktiBankKebunItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class BuktiBankKebunController extends Controller
{
    public function index()
    {
        $bukti_bank_kebuns = BuktiBankKebun::orderBy('tanggal', 'desc')->get();
        return view('bukti-bank-kebun.index', compact('bukti_bank_kebuns'));
    }

    public function create()
    {
        return view('bukti-bank-kebun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_bukti' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
            'ditransfer_ke' => 'nullable|string|max:255',
            'bank_rek_tujuan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Calculate grand total
            $grandTotal = 0;
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $grandTotal += ($request->qty[$i] * $request->harga_satuan[$i]);
            }

            // Create Master
            $bukti = BuktiBankKebun::create([
                'no_bukti' => $request->no_bukti,
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan,
                'keterangan' => $request->keterangan,
                'ditransfer_ke' => $request->ditransfer_ke,
                'bank_rek_tujuan' => $request->bank_rek_tujuan,
                'grand_total' => $grandTotal
            ]);

            // Create Detail Items
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $totalHarga = $request->qty[$i] * $request->harga_satuan[$i];
                BuktiBankKebunItem::create([
                    'bukti_bank_kebun_id' => $bukti->id,
                    'nama_barang' => $request->nama_barang[$i],
                    'qty' => $request->qty[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'total_harga' => $totalHarga
                ]);
            }

            DB::commit();

            return redirect()->route('bukti-bank-kebun.index')->with('success', 'Bukti Bank Kebun berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $bukti_bank_kebun = BuktiBankKebun::with('items')->findOrFail($id);
        return view('bukti-bank-kebun.show', compact('bukti_bank_kebun'));
    }

    public function edit($id)
    {
        $bukti_bank_kebun = BuktiBankKebun::with('items')->findOrFail($id);
        return view('bukti-bank-kebun.edit', compact('bukti_bank_kebun'));
    }

    public function update(Request $request, $id)
    {
        $bukti = BuktiBankKebun::findOrFail($id);

        $request->validate([
            'no_bukti' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'judul_pengajuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'nama_barang' => 'required|array',
            'nama_barang.*' => 'required|string',
            'qty' => 'required|array',
            'qty.*' => 'required|integer|min:1',
            'harga_satuan' => 'required|array',
            'harga_satuan.*' => 'required|numeric|min:0',
            'ditransfer_ke' => 'nullable|string|max:255',
            'bank_rek_tujuan' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $grandTotal += ($request->qty[$i] * $request->harga_satuan[$i]);
            }

            $bukti->update([
                'no_bukti' => $request->no_bukti,
                'tanggal' => $request->tanggal,
                'judul_pengajuan' => $request->judul_pengajuan,
                'keterangan' => $request->keterangan,
                'ditransfer_ke' => $request->ditransfer_ke,
                'bank_rek_tujuan' => $request->bank_rek_tujuan,
                'grand_total' => $grandTotal
            ]);

            $bukti->items()->delete();

            for ($i = 0; $i < count($request->nama_barang); $i++) {
                $totalHarga = $request->qty[$i] * $request->harga_satuan[$i];
                BuktiBankKebunItem::create([
                    'bukti_bank_kebun_id' => $bukti->id,
                    'nama_barang' => $request->nama_barang[$i],
                    'qty' => $request->qty[$i],
                    'harga_satuan' => $request->harga_satuan[$i],
                    'total_harga' => $totalHarga
                ]);
            }

            DB::commit();

            return redirect()->route('bukti-bank-kebun.index')->with('success', 'Bukti Bank Kebun berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        $bukti = BuktiBankKebun::findOrFail($id);
        $bukti->delete();
        return redirect()->route('bukti-bank-kebun.index')->with('success', 'Bukti Bank Kebun berhasil dihapus.');
    }

    public function print($id)
    {
        $bukti_bank_kebun = BuktiBankKebun::with('items')->findOrFail($id);
        
        $pdf = Pdf::loadView('bukti-bank-kebun.print-pdf', compact('bukti_bank_kebun'));
        
        // Use A5 landscape to match Bukti Kas Kebun A5 format
        $pdf->setPaper('a5', 'landscape');
        
        return $pdf->stream('Bukti-Bank-Kebun-'.$bukti_bank_kebun->id.'.pdf');
    }
}
