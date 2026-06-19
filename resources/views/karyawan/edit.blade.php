@extends('layouts.app')

@section('title', 'Edit Data Karyawan')
@section('page-title', 'Edit Karyawan')
@section('page-subtitle', 'Ubah data karyawan')

@section('page-actions')
<a href="{{ route('karyawan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    Kembali
</a>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $karyawan->nama) }}" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                @error('nama') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role Jabatan</label>
                    <div class="space-y-2 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        @php
                            $selectedJabatans = old('jabatans', $karyawan->jabatans->pluck('id')->toArray());
                        @endphp
                        @forelse($jabatans as $jabatan)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="jabatans[]" value="{{ $jabatan->id }}" class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500" {{ (is_array($selectedJabatans) && in_array($jabatan->id, $selectedJabatans)) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $jabatan->nama }} <span class="text-xs text-gray-400">({{ $jabatan->tipe_gaji }})</span></span>
                            </label>
                        @empty
                            <p class="text-sm text-gray-500">Belum ada master jabatan.</p>
                        @endforelse
                    </div>
                    @error('jabatans') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kebun</label>
                        <select id="lokasi" name="lokasi" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach($lokasiKebuns as $lokasi)
                                <option value="{{ $lokasi }}" {{ old('lokasi', $karyawan->lokasi) == $lokasi ? 'selected' : '' }}>{{ $lokasi }}</option>
                            @endforeach
                        </select>
                        @error('lokasi') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP / WhatsApp</label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                        @error('no_hp') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Karyawan</label>
                        <select id="status" name="status" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                            <option value="Aktif" {{ old('status', $karyawan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $karyawan->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg transition shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
