@extends('layouts.app')

@section('title', 'Edit Master Jabatan')
@section('page-title', 'Edit Jabatan')
@section('page-subtitle', 'Ubah data master jabatan')

@section('page-actions')
<a href="{{ route('jabatan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
    Kembali
</a>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
    <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Jabatan</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $jabatan->nama) }}" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                @error('nama') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="tipe_gaji" class="block text-sm font-medium text-gray-700 mb-1">Tipe Gaji</label>
                <select id="tipe_gaji" name="tipe_gaji" required class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                    <option value="Harian" {{ old('tipe_gaji', $jabatan->tipe_gaji) == 'Harian' ? 'selected' : '' }}>Upah Harian</option>
                    <option value="Borongan" {{ old('tipe_gaji', $jabatan->tipe_gaji) == 'Borongan' ? 'selected' : '' }}>Upah Borongan</option>
                    <option value="Tetap" {{ old('tipe_gaji', $jabatan->tipe_gaji) == 'Tetap' ? 'selected' : '' }}>Gaji Tetap</option>
                </select>
                @error('tipe_gaji') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
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
