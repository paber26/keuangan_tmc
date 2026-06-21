@extends('layouts.app')

@section('title', 'Edit Tarif Penggajian')

@section('content')
<div class="px-6 py-8 md:py-10 max-w-3xl mx-auto min-h-screen">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Tarif Penggajian</h1>
        <p class="mt-2 text-sm text-gray-500">
            Ubah tarif untuk penggajian periode {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->format('d M Y') }} (Lokasi: {{ $penggajian->lokasi_kebun }})
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('penggajian.update', $penggajian->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tarif Harian (Rp)</label>
                        <input type="number" name="tarif_harian" value="{{ old('tarif_harian', round($penggajian->tarif_harian)) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 font-medium text-gray-900" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tarif Kupas / Butir (Rp)</label>
                        <input type="number" name="tarif_kupas" value="{{ old('tarif_kupas', round($penggajian->tarif_kupas)) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 font-medium text-gray-900" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tarif Pemanjat / Pohon (Rp)</label>
                        <input type="number" name="tarif_pemanjat" value="{{ old('tarif_pemanjat', round($penggajian->tarif_pemanjat)) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 font-medium text-gray-900" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tarif Pemetik / Kg (Rp)</label>
                        <input type="number" name="tarif_pemetik" value="{{ old('tarif_pemetik', round($penggajian->tarif_pemetik)) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 font-medium text-gray-900" required>
                    </div>
                </div>

                <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-yellow-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm text-yellow-800">
                            Mengubah tarif akan secara otomatis menghitung ulang seluruh total upah karyawan (Harian & Borongan) berdasarkan jumlah hari kerja dan volume yang sudah tercatat pada penggajian ini.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('penggajian.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Simpan Perubahan Tarif
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
