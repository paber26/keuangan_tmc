@extends('layouts.app')
@section('page-title', 'Detail Dokumentasi Harian')

@section('content')
<div class="w-full pb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('dokumentasi.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">{{ $dokumentasi->judul }}</h2>
            <p class="text-sm font-semibold text-emerald-600 mt-1">{{ \Carbon\Carbon::parse($dokumentasi->tanggal)->format('d F Y') }}</p>
        </div>
        <div class="flex gap-2 items-center">
            <a href="{{ route('dokumentasi.edit', $dokumentasi->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <form action="{{ route('dokumentasi.destroy', $dokumentasi->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dokumentasi ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Keterangan</h3>
        <p class="text-gray-600 whitespace-pre-line">{{ $dokumentasi->keterangan ?: 'Tidak ada keterangan yang ditambahkan.' }}</p>
    </div>

    <h3 class="text-xl font-bold text-gray-800 mb-6">Galeri Foto ({{ $dokumentasi->images->count() }})</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($dokumentasi->images as $img)
        <div class="relative aspect-square bg-gray-100 rounded-xl overflow-hidden border border-gray-200 shadow-sm group">
                <button type="button" onclick="openLightbox('{{ Storage::url($img->image_path) }}')" class="block w-full h-full focus:outline-none">
                    <img src="{{ Storage::url($img->image_path) }}" alt="Dokumentasi" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </button>
        </div>
        @endforeach
        
        @if($dokumentasi->images->count() == 0)
        <div class="col-span-full py-10 text-center text-gray-500">
            Tidak ada foto yang diunggah.
        </div>
        @endif
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-[100] hidden bg-black/90 flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="closeLightbox()">
    <button type="button" class="absolute top-4 right-4 text-white hover:text-gray-300 focus:outline-none" onclick="closeLightbox()">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <img id="lightbox-img" src="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl transition-transform duration-300 scale-95" onclick="event.stopPropagation()">
</div>

@push('scripts')
<script>
    function openLightbox(imageSrc) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        
        lightboxImg.src = imageSrc;
        lightbox.classList.remove('hidden');
        
        // Trigger reflow for transition
        void lightbox.offsetWidth;
        
        lightbox.classList.remove('opacity-0');
        lightboxImg.classList.remove('scale-95');
        lightboxImg.classList.add('scale-100');
        
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        
        lightbox.classList.add('opacity-0');
        lightboxImg.classList.remove('scale-100');
        lightboxImg.classList.add('scale-95');
        
        setTimeout(() => {
            lightbox.classList.add('hidden');
            lightboxImg.src = '';
            document.body.style.overflow = ''; // Restore scrolling
        }, 300);
    }
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('lightbox').classList.contains('hidden')) {
            closeLightbox();
        }
    });
</script>
@endpush
@endsection
