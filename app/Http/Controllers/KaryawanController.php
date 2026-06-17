<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kebun;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::latest()->get();
        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lokasiKebuns = Kebun::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');
        return view('karyawan.create', compact('lokasiKebuns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'tipe_gaji' => 'required|in:Tetap,Harian,Borongan',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $lokasiKebuns = Kebun::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');
        return view('karyawan.edit', compact('karyawan', 'lokasiKebuns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'tipe_gaji' => 'required|in:Tetap,Harian,Borongan',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }
}
