@extends('layouts.app')
@section('page-title', 'Edit Dokumentasi Harian')

@section('content')
<div class="w-full max-w-4xl pb-10">
    <div class="mb-8">
        <a href="{{ route('dokumentasi.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Dokumentasi Harian</h2>
    </div>

    <form action="{{ route('dokumentasi.update', $dokumentasi->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf
        @method('PUT')
        
        <div class="p-6 md:p-8 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pekerjaan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ \Carbon\Carbon::parse($dokumentasi->tanggal)->format('Y-m-d') }}" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Laporan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ $dokumentasi->judul }}" required placeholder="Contoh: Pembersihan Blok A" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Tambahan</label>
                <textarea name="keterangan" rows="4" placeholder="Tuliskan detail pekerjaan..." class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">{{ $dokumentasi->keterangan }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-4">Foto-foto Saat Ini</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    @foreach($dokumentasi->images as $img)
                    <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm group">
                        <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <label class="cursor-pointer text-white flex items-center gap-2 bg-red-500 px-3 py-1.5 rounded-md hover:bg-red-600">
                                <input type="checkbox" name="deleted_images[]" value="{{ $img->id }}" class="w-4 h-4 rounded text-red-600 focus:ring-red-500">
                                <span class="text-sm font-medium">Hapus</span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <hr class="border-gray-100">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tambahkan Foto Baru (Opsional)</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition-colors relative cursor-pointer" id="drop-zone">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                <span>Pilih banyak file sekaligus</span>
                                <input id="file-upload" name="images[]" type="file" multiple class="sr-only" accept="image/*">
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 5MB</p>
                        <div class="mt-4">
                            <button type="button" onclick="pasteFromClipboard()" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-sm font-medium rounded-lg transition-colors border border-amber-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Paste dari Clipboard
                            </button>
                        </div>
                    </div>
                </div>
                <div id="preview-container" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

        </div>
        <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                Perbarui Dokumentasi
            </button>
        </div>
    </form>
</div>

<script>
    const fileUpload = document.getElementById('file-upload');
    const previewContainer = document.getElementById('preview-container');
    let filesArray = [];

    function renderPreviews() {
        previewContainer.innerHTML = '';
        const dt = new DataTransfer();
        
        filesArray.forEach((file, index) => {
            dt.items.add(file);
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-square rounded-lg overflow-hidden border border-gray-200 shadow-sm group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <button type="button" onclick="removeFile(${index})" class="text-white flex items-center gap-2 bg-red-500 px-3 py-1.5 rounded-md hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                `;
                previewContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
        
        fileUpload.files = dt.files;
    }

    window.removeFile = function(index) {
        filesArray.splice(index, 1);
        renderPreviews();
    }

    // Handle normal file selection
    fileUpload.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        files.forEach(file => {
            if (file.type.startsWith('image/')) {
                filesArray.push(file);
            }
        });
        renderPreviews();
    });

    // Handle paste from clipboard
    document.addEventListener('paste', function(e) {
        if (e.clipboardData && e.clipboardData.files.length > 0) {
            e.preventDefault();
            let added = false;
            for (let i = 0; i < e.clipboardData.files.length; i++) {
                let file = e.clipboardData.files[i];
                if (file.type.startsWith('image/')) {
                    filesArray.push(file);
                    added = true;
                }
            }
            if (added) {
                renderPreviews();
                
                // Optional: visual feedback
                const dropZone = document.getElementById('drop-zone');
                dropZone.classList.add('bg-amber-50', 'border-amber-300');
                setTimeout(() => dropZone.classList.remove('bg-amber-50', 'border-amber-300'), 500);
            }
        }
    });

    async function pasteFromClipboard() {
        try {
            const clipboardItems = await navigator.clipboard.read();
            let added = false;
            for (const item of clipboardItems) {
                const imageTypes = item.types.filter(type => type.startsWith('image/'));
                for (const type of imageTypes) {
                    const blob = await item.getType(type);
                    const file = new File([blob], "pasted-" + Date.now() + "." + type.split('/')[1], { type: type });
                    filesArray.push(file);
                    added = true;
                }
            }
            if (added) {
                renderPreviews();
                const dropZone = document.getElementById('drop-zone');
                dropZone.classList.add('bg-amber-50', 'border-amber-300');
                setTimeout(() => dropZone.classList.remove('bg-amber-50', 'border-amber-300'), 500);
            } else {
                alert('Tidak ada gambar di clipboard Anda. Copy gambar terlebih dahulu.');
            }
        } catch (err) {
            console.error('Failed to read clipboard contents: ', err);
            alert('Gagal membaca clipboard. Pastikan browser memberikan izin clipboard.');
        }
    }
</script>
@endsection
