@extends('layouts.app')

@section('title', 'Tambah Kebun')
@section('page-title', 'Tambah Kebun')
@section('page-subtitle', 'Tambah data kebun baru')

@section('page-actions')
    <a href="#"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl transition shadow-sm border border-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
    <div class="max-w-4xl">
        <form action="#" method="POST">
            @csrf
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                {{-- Form Header --}}
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-800">Informasi Kebun</h3>
                    <p class="mt-1 text-sm text-gray-500">Lengkapi data kebun perkebunan yang akan ditambahkan.</p>
                </div>

                {{-- Form Fields --}}
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Kebun --}}
                        <div>
                            <label for="nama_kebun" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Kebun <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama_kebun" name="nama_kebun" placeholder="Contoh: Kebun Raya Utama"
                                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"
                                   required/>
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Lokasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lokasi" name="lokasi" placeholder="Contoh: Desa Sukamaju"
                                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"
                                   required/>
                        </div>

                        {{-- Luas --}}
                        <div>
                            <label for="luas" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Luas (Ha) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" step="0.1" id="luas" name="luas" placeholder="0.0"
                                       class="w-full px-4 py-2.5 pr-12 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"
                                       required/>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-sm text-gray-400">Ha</span>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Status
                            </label>
                            <select id="status" name="status"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition bg-white">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Keterangan
                        </label>
                        <textarea id="keterangan" name="keterangan" rows="4"
                                  placeholder="Catatan tambahan tentang kebun (opsional)..."
                                  class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition resize-none"></textarea>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 rounded-b-xl flex items-center justify-end gap-3">
                    <a href="#"
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition shadow-sm inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
