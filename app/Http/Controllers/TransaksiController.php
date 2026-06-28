<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $kebun_id = $request->get('kebun_id');
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $kategori = $request->get('kategori');

        $query = Transaksi::with('kebun')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        if ($kebun_id) {
            $query->where('kebun_id', $kebun_id);
        }

        if ($kategori && $kategori !== 'Semua') {
            $query->where('kategori', $kategori);
        }

        $transaksis = $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc')->paginate(15);
        $all_transaksis_for_summary = $query->get();

        $total_masuk = $all_transaksis_for_summary->where('tipe', 'Pemasukan')->sum('jumlah');
        $total_keluar = $all_transaksis_for_summary->where('tipe', 'Pengeluaran')->sum('jumlah');
        $saldo = $total_masuk - $total_keluar;

        $count_masuk = $all_transaksis_for_summary->where('tipe', 'Pemasukan')->count();
        $count_keluar = $all_transaksis_for_summary->where('tipe', 'Pengeluaran')->count();

        $kebuns = Kebun::getVirtualKebunList();

        return view('transaksi.index', compact(
            'transaksis', 
            'kebuns',
            'bulan',
            'tahun',
            'kebun_id',
            'kategori',
            'total_masuk',
            'total_keluar',
            'saldo',
            'count_masuk',
            'count_keluar'
        ));
    }

    public function store(Request $request)
    {
        // Parse jumlah, removing formatting
        $jumlah = preg_replace('/[^0-9]/', '', $request->jumlah);
        $request->merge(['jumlah' => $jumlah]);

        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:Pemasukan,Pengeluaran',
            'kategori' => 'required|string|max:255',
            'kebun_id' => 'nullable|exists:kebuns,id',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        Transaksi::create($request->all());

        return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        // Parse jumlah, removing formatting
        $jumlah = preg_replace('/[^0-9]/', '', $request->jumlah);
        $request->merge(['jumlah' => $jumlah]);

        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:Pemasukan,Pengeluaran',
            'kategori' => 'required|string|max:255',
            'kebun_id' => 'nullable|exists:kebuns,id',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($request->all());

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
