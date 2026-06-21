<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiHarian;
use App\Models\DokumentasiHarianImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DokumentasiHarianController extends Controller
{
    public function index()
    {
        $dokumentasi = DokumentasiHarian::with('images')->orderBy('tanggal', 'desc')->get();
        return view('dokumentasi.index', compact('dokumentasi'));
    }

    public function create()
    {
        $kebun = \App\Models\Kebun::orderBy('lokasi', 'asc')->get()->unique('lokasi');
        $karyawan = \App\Models\Karyawan::orderBy('nama', 'asc')->get();
        return view('dokumentasi.create', compact('kebun', 'karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'kebun_id' => 'required|exists:kebuns,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'keterangan' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120' // max 5MB
        ]);

        try {
            DB::beginTransaction();

            $dokumentasi = DokumentasiHarian::create([
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'keterangan' => $request->keterangan,
                'kebun_id' => $request->kebun_id,
                'karyawan_id' => $request->karyawan_id,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('dokumentasi', 'public');
                    DokumentasiHarianImage::create([
                        'dokumentasi_harian_id' => $dokumentasi->id,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        $dokumentasi = DokumentasiHarian::with('images')->findOrFail($id);
        return view('dokumentasi.show', compact('dokumentasi'));
    }

    public function edit(string $id)
    {
        $dokumentasi = DokumentasiHarian::with('images')->findOrFail($id);
        $kebun = \App\Models\Kebun::orderBy('lokasi', 'asc')->get()->unique('lokasi');
        $karyawan = \App\Models\Karyawan::orderBy('nama', 'asc')->get();
        return view('dokumentasi.edit', compact('dokumentasi', 'kebun', 'karyawan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'kebun_id' => 'required|exists:kebuns,id',
            'karyawan_id' => 'required|exists:karyawans,id',
            'keterangan' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            DB::beginTransaction();

            $dokumentasi = DokumentasiHarian::findOrFail($id);
            $dokumentasi->update([
                'tanggal' => $request->tanggal,
                'judul' => $request->judul,
                'keterangan' => $request->keterangan,
                'kebun_id' => $request->kebun_id,
                'karyawan_id' => $request->karyawan_id,
            ]);

            // Handle deleted images if any
            if ($request->has('deleted_images')) {
                foreach ($request->deleted_images as $imageId) {
                    $image = DokumentasiHarianImage::find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->image_path);
                        $image->delete();
                    }
                }
            }

            // Handle new images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('dokumentasi', 'public');
                    DokumentasiHarianImage::create([
                        'dokumentasi_harian_id' => $dokumentasi->id,
                        'image_path' => $path,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $dokumentasi = DokumentasiHarian::findOrFail($id);
            
            foreach ($dokumentasi->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            
            $dokumentasi->delete();
            
            DB::commit();
            return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
