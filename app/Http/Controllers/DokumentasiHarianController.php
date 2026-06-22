<?php

namespace App\Http\Controllers;

use App\Models\DokumentasiHarian;
use App\Models\DokumentasiHarianImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DokumentasiHarianController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumentasiHarian::with(['images', 'kebun', 'karyawans']);

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }
        if ($request->filled('lokasi')) {
            $matchingKebunIds = \App\Models\Kebun::all()->filter(function($k) use ($request) {
                return $k->virtual_lokasi === $request->lokasi;
            })->pluck('id');
            $query->whereIn('kebun_id', $matchingKebunIds);
        }

        $dokumentasi = $query->orderBy('tanggal', 'desc')->get();
        $lokasiList = \App\Models\Kebun::getVirtualKebunList();

        $viewMode = $request->get('view', 'table'); // default to table

        return view('dokumentasi.index', compact('dokumentasi', 'lokasiList', 'viewMode'));
    }

    public function create()
    {
        $kebun = \App\Models\Kebun::getVirtualKebunList();
        $karyawan = \App\Models\Karyawan::orderBy('nama', 'asc')->get();
        return view('dokumentasi.create', compact('kebun', 'karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'kebun_id' => 'required|exists:kebuns,id',
            'karyawan_ids' => 'required|array',
            'karyawan_ids.*' => 'exists:karyawans,id',
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
                'karyawan_id' => null, // Legacy column, can be removed later
            ]);

            $dokumentasi->karyawans()->sync($request->karyawan_ids);

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
        $dokumentasi = DokumentasiHarian::with(['images', 'karyawans'])->findOrFail($id);
        return view('dokumentasi.show', compact('dokumentasi'));
    }

    public function edit(string $id)
    {
        $dokumentasi = DokumentasiHarian::with(['images', 'karyawans'])->findOrFail($id);
        $kebun = \App\Models\Kebun::getVirtualKebunList();
        $karyawan = \App\Models\Karyawan::orderBy('nama', 'asc')->get();
        return view('dokumentasi.edit', compact('dokumentasi', 'kebun', 'karyawan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'judul' => 'required|string|max:255',
            'kebun_id' => 'required|exists:kebuns,id',
            'karyawan_ids' => 'required|array',
            'karyawan_ids.*' => 'exists:karyawans,id',
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
                'karyawan_id' => null, // Legacy column
            ]);

            $dokumentasi->karyawans()->sync($request->karyawan_ids);

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
