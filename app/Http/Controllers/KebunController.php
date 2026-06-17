<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use Illuminate\Http\Request;

class KebunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kebuns = Kebun::latest()->get();
        return view('kebun.index', compact('kebuns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kebun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'luas' => 'required|numeric|min:0',
            'jumlah_blok' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        Kebun::create($validated);

        return redirect()->route('kebun.index')->with('success', 'Data kebun berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kebun $kebun)
    {
        return view('kebun.edit', compact('kebun'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kebun $kebun)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'luas' => 'required|numeric|min:0',
            'jumlah_blok' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $kebun->update($validated);

        return redirect()->route('kebun.index')->with('success', 'Data kebun berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kebun $kebun)
    {
        $kebun->delete();

        return redirect()->route('kebun.index')->with('success', 'Data kebun berhasil dihapus!');
    }
}
