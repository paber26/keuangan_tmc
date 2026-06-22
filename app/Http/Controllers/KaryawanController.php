<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kebun;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::with('jabatans')->latest()->get();
        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lokasiKebuns = Kebun::getVirtualLokasiList();
        $jabatans = Jabatan::orderBy('nama')->get();
        return view('karyawan.create', compact('lokasiKebuns', 'jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:Aktif,Nonaktif',
            'jabatans' => 'nullable|array',
            'jabatans.*' => 'exists:jabatans,id',
        ]);

        $karyawan = Karyawan::create($validated);
        
        if (!empty($validated['jabatans'])) {
            $karyawan->jabatans()->sync($validated['jabatans']);
        }

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $lokasiKebuns = Kebun::getVirtualLokasiList();
        $jabatans = Jabatan::orderBy('nama')->get();
        return view('karyawan.edit', compact('karyawan', 'lokasiKebuns', 'jabatans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'status' => 'required|in:Aktif,Nonaktif',
            'jabatans' => 'nullable|array',
            'jabatans.*' => 'exists:jabatans,id',
        ]);

        $karyawan->update($validated);
        
        if (isset($validated['jabatans'])) {
            $karyawan->jabatans()->sync($validated['jabatans']);
        } else {
            $karyawan->jabatans()->detach();
        }

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
