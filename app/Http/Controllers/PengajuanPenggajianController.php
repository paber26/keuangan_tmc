<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPenggajian;
use App\Models\PengajuanPenggajianItem;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PengajuanPenggajianController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanPenggajian::with('kebun')->orderBy('tanggal', 'desc')->get();
        return view('pengajuan-penggajian.index', compact('pengajuans'));
    }

    public function create()
    {
        $lokasiList = \App\Models\Penggajian::select('lokasi_kebun')->distinct()->pluck('lokasi_kebun');
        $kebuns = Kebun::whereIn('lokasi', $lokasiList)->orderBy('lokasi', 'asc')->get()->unique('lokasi');
        $penggajians = \App\Models\Penggajian::with(['details.karyawan.jabatans'])->orderBy('tanggal_mulai', 'desc')->get();
        
        $penggajians->transform(function ($penggajian) {
            $types = [];
            foreach ($penggajian->details as $detail) {
                $tipe = $detail->tipe_pekerjaan;
                $jabatan = $detail->karyawan->jabatans->first()->nama ?? 'TIDAK DIKETAHUI';
                $name = $tipe . ' - ' . $jabatan;
                if (!in_array($name, $types)) {
                    $types[] = $name;
                }
            }
            $keterangan = count($types) > 0 ? 'Upah ' . implode(', Upah ', array_map(function($t) { return ucwords(strtolower($t)); }, $types)) : ($penggajian->keterangan ?? '');
            $penggajian->generated_keterangan = $keterangan;
            return $penggajian;
        });

        return view('pengajuan-penggajian.create', compact('kebuns', 'penggajians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'no_dokumen' => 'nullable|string',
            'disahkan_tgl' => 'nullable|date',
            'berlaku_tgl' => 'nullable|date',
            'revisi' => 'nullable|string',
            'kebun_id' => 'required|exists:kebuns,id',
            'penggajian_id' => 'nullable|exists:penggajians,id',
            'perihal' => 'required|string',
            
            'uraian' => 'required|array',
            'uraian.*' => 'required|string',
            'banyak_unit' => 'nullable|array',
            'banyak_unit.*' => 'nullable|numeric',
            'harga_satuan' => 'nullable|array',
            'harga_satuan.*' => 'nullable|numeric',
            'total_harga' => 'required|array',
            'total_harga.*' => 'required|numeric',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            if (isset($request->total_harga)) {
                foreach ($request->total_harga as $th) {
                    $grandTotal += (float) $th;
                }
            }

            $pengajuan = PengajuanPenggajian::create([
                'tanggal' => $request->tanggal,
                'no_dokumen' => $request->no_dokumen,
                'disahkan_tgl' => $request->disahkan_tgl,
                'berlaku_tgl' => $request->berlaku_tgl,
                'revisi' => $request->revisi,
                'kebun_id' => $request->kebun_id,
                'penggajian_id' => $request->penggajian_id,
                'perihal' => $request->perihal,
                'grand_total' => $grandTotal,
                'status' => 'Menunggu'
            ]);

            for ($i = 0; $i < count($request->uraian); $i++) {
                PengajuanPenggajianItem::create([
                    'pengajuan_penggajian_id' => $pengajuan->id,
                    'uraian' => $request->uraian[$i],
                    'banyak_unit' => isset($request->banyak_unit[$i]) ? $request->banyak_unit[$i] : null,
                    'harga_satuan' => isset($request->harga_satuan[$i]) ? $request->harga_satuan[$i] : null,
                    'total_harga' => $request->total_harga[$i],
                    'keterangan' => isset($request->keterangan[$i]) ? $request->keterangan[$i] : null,
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan-penggajian.index')->with('success', 'Form Pengajuan Penggajian berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(PengajuanPenggajian $pengajuan_penggajian)
    {
        $pengajuan_penggajian->load(['items', 'kebun']);
        return view('pengajuan-penggajian.show', compact('pengajuan_penggajian'));
    }

    public function edit(PengajuanPenggajian $pengajuan_penggajian)
    {
        if ($pengajuan_penggajian->status !== 'Menunggu') {
            return redirect()->route('pengajuan-penggajian.index')->with('error', 'Hanya pengajuan dengan status Menunggu yang dapat diedit.');
        }
        $pengajuan_penggajian->load('items');
        
        $lokasiList = \App\Models\Penggajian::select('lokasi_kebun')->distinct()->pluck('lokasi_kebun');
        $kebuns = Kebun::whereIn('lokasi', $lokasiList)->orderBy('lokasi', 'asc')->get()->unique('lokasi');
        
        // Ensure the currently selected kebun is in the list even if no report exists for it
        if ($pengajuan_penggajian->kebun && !$kebuns->contains('id', $pengajuan_penggajian->kebun_id)) {
            $kebuns->push($pengajuan_penggajian->kebun);
        }
        
        $penggajians = \App\Models\Penggajian::with(['details.karyawan.jabatans'])->orderBy('tanggal_mulai', 'desc')->get();
        
        $penggajians->transform(function ($penggajian) {
            $types = [];
            foreach ($penggajian->details as $detail) {
                $tipe = $detail->tipe_pekerjaan;
                $jabatan = $detail->karyawan->jabatans->first()->nama ?? 'TIDAK DIKETAHUI';
                $name = $tipe . ' - ' . $jabatan;
                if (!in_array($name, $types)) {
                    $types[] = $name;
                }
            }
            $keterangan = count($types) > 0 ? 'Upah ' . implode(', Upah ', array_map(function($t) { return ucwords(strtolower($t)); }, $types)) : ($penggajian->keterangan ?? '');
            $penggajian->generated_keterangan = $keterangan;
            return $penggajian;
        });
        
        return view('pengajuan-penggajian.edit', compact('pengajuan_penggajian', 'kebuns', 'penggajians'));
    }

    public function update(Request $request, PengajuanPenggajian $pengajuan_penggajian)
    {
        if ($pengajuan_penggajian->status !== 'Menunggu') {
            return redirect()->route('pengajuan-penggajian.index')->with('error', 'Hanya pengajuan dengan status Menunggu yang dapat diedit.');
        }

        $request->validate([
            'tanggal' => 'required|date',
            'no_dokumen' => 'nullable|string',
            'disahkan_tgl' => 'nullable|date',
            'berlaku_tgl' => 'nullable|date',
            'revisi' => 'nullable|string',
            'kebun_id' => 'required|exists:kebuns,id',
            'penggajian_id' => 'nullable|exists:penggajians,id',
            'perihal' => 'required|string',
            
            'uraian' => 'required|array',
            'uraian.*' => 'required|string',
            'banyak_unit' => 'nullable|array',
            'banyak_unit.*' => 'nullable|numeric',
            'harga_satuan' => 'nullable|array',
            'harga_satuan.*' => 'nullable|numeric',
            'total_harga' => 'required|array',
            'total_harga.*' => 'required|numeric',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $grandTotal = 0;
            if (isset($request->total_harga)) {
                foreach ($request->total_harga as $th) {
                    $grandTotal += (float) $th;
                }
            }

            $pengajuan_penggajian->update([
                'tanggal' => $request->tanggal,
                'no_dokumen' => $request->no_dokumen,
                'disahkan_tgl' => $request->disahkan_tgl,
                'berlaku_tgl' => $request->berlaku_tgl,
                'revisi' => $request->revisi,
                'kebun_id' => $request->kebun_id,
                'penggajian_id' => $request->penggajian_id,
                'perihal' => $request->perihal,
                'grand_total' => $grandTotal
            ]);

            $pengajuan_penggajian->items()->delete();

            for ($i = 0; $i < count($request->uraian); $i++) {
                PengajuanPenggajianItem::create([
                    'pengajuan_penggajian_id' => $pengajuan_penggajian->id,
                    'uraian' => $request->uraian[$i],
                    'banyak_unit' => isset($request->banyak_unit[$i]) ? $request->banyak_unit[$i] : null,
                    'harga_satuan' => isset($request->harga_satuan[$i]) ? $request->harga_satuan[$i] : null,
                    'total_harga' => $request->total_harga[$i],
                    'keterangan' => isset($request->keterangan[$i]) ? $request->keterangan[$i] : null,
                ]);
            }

            DB::commit();
            return redirect()->route('pengajuan-penggajian.index')->with('success', 'Form Pengajuan Penggajian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, PengajuanPenggajian $pengajuan_penggajian)
    {
        $request->validate(['status' => 'required|in:Menunggu,Disetujui,Ditolak']);
        $pengajuan_penggajian->update(['status' => $request->status]);
        return back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    public function destroy(PengajuanPenggajian $pengajuan_penggajian)
    {
        $pengajuan_penggajian->delete();
        return redirect()->route('pengajuan-penggajian.index')->with('success', 'Pengajuan berhasil dihapus.');
    }

    public function print(PengajuanPenggajian $pengajuan_penggajian)
    {
        $pengajuan_penggajian->load(['items', 'kebun']);
        
        $pdf = Pdf::loadView('pengajuan-penggajian.print-pdf', compact('pengajuan_penggajian'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->stream('Form_Pengajuan_Dana_'.$pengajuan_penggajian->id.'.pdf');
    }
}
