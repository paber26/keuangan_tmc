@extends('layouts.app')
@section('page-title', 'Dokumentasi Harian')

@section('content')
<div class="w-full pb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Dokumentasi Harian</h2>
            <p class="text-sm text-gray-500 mt-1">Galeri dan catatan dokumentasi pekerjaan harian.</p>
        </div>
        <div class="flex gap-2 items-center">
            <a href="{{ route('dokumentasi.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Dokumentasi
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($dokumentasi as $doc)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="aspect-video bg-gray-100 relative overflow-hidden">
                @if($doc->images->count() > 0)
                    <img src="{{ Storage::url($doc->images->first()->image_path) }}" alt="Thumbnail" class="w-full h-full object-cover">
                    @if($doc->images->count() > 1)
                    <div class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-md backdrop-blur-sm">
                        +{{ $doc->images->count() - 1 }} Foto
                    </div>
                    @endif
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>
            <div class="p-5">
                <div class="text-xs font-semibold text-emerald-600 mb-1">{{ \Carbon\Carbon::parse($doc->tanggal)->format('d M Y') }}</div>
                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1">{{ $doc->judul }}</h3>
                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $doc->keterangan ?: 'Tidak ada keterangan' }}</p>
                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
                    <a href="{{ route('dokumentasi.show', $doc->id) }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Detail &rarr;</a>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dokumentasi.edit', $doc->id) }}" class="text-gray-400 hover:text-amber-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('dokumentasi.destroy', $doc->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dokumentasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-12 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 text-gray-400 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada Dokumentasi</h3>
            <p class="mt-1 text-gray-500">Mulai catat pekerjaan harian dan unggah foto dokumentasinya.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
