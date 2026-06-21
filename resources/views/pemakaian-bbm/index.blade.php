@extends('layouts.app')
@section('page-title', 'Data Pemakaian BBM')

@section('content')
<div class="w-full pb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Data Pemakaian BBM</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola pencatatan histori pemakaian BBM harian.</p>
        </div>
        <div class="flex gap-2 items-center">
            <form action="{{ route('pemakaian-bbm.index') }}" method="GET" class="flex gap-2">
                <select name="kategori" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                    <option value="">Semua Kategori</option>
                    <option value="Kebun" {{ request('kategori') == 'Kebun' ? 'selected' : '' }}>Kebun</option>
                    <option value="Sopir" {{ request('kategori') == 'Sopir' ? 'selected' : '' }}>Sopir</option>
                </select>
            </form>
            <a href="{{ route('pemakaian-bbm.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Laporan
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi Kebun</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Karyawan</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Laporan</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Liter</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total (Rp)</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pemakaian as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 text-sm text-gray-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            @if($item->kategori == 'Kebun')
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">Kebun</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">Sopir</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm font-semibold text-emerald-600">
                            {{ $item->kebun ? $item->kebun->lokasi : '-' }}
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-800">{{ $item->karyawan ? $item->karyawan->nama : '-' }}</td>
                        <td class="py-4 px-6">
                            <p class="text-sm font-medium text-gray-800">{{ $item->judul_laporan }}</p>
                            @if($item->keterangan)
                            <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $item->keterangan }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-800 text-right whitespace-nowrap">
                            @php
                                $totalSolar = $item->items->where('tipe_bbm', 'Solar')->sum('jumlah_liter');
                                $totalPertalite = $item->items->where('tipe_bbm', 'Pertalite')->sum('jumlah_liter');
                            @endphp
                            @if($totalSolar > 0)
                                <div><span class="font-medium text-gray-500">Solar:</span> {{ $totalSolar }} L</div>
                            @endif
                            @if($totalPertalite > 0)
                                <div><span class="font-medium text-gray-500">Pertalite:</span> {{ $totalPertalite }} L</div>
                            @endif
                            @if($totalSolar == 0 && $totalPertalite == 0)
                                -
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm font-bold text-gray-800 text-right whitespace-nowrap">Rp {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                @if($item->images && $item->images->count() > 0)
                                <button type="button" 
                                        onclick="openDocsModal('{{ $item->judul_laporan }}', {{ json_encode($item->images->map(fn($img) => Storage::url($img->image_path))) }})" 
                                        class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" 
                                        title="Lihat Dokumentasi (Ada Foto)">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </button>
                                @endif
                                <a href="{{ route('pemakaian-bbm.show', $item->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('pemakaian-bbm.edit', $item->id) }}" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded transition-colors" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('pemakaian-bbm.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirmMath(event);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-sm text-gray-500">
                            Belum ada laporan pemakaian BBM.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Documentation Modal -->
<div id="docsModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" onclick="closeDocsModal(event)">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-4">
                <h3 class="text-lg font-bold text-gray-900" id="docs-modal-title">Dokumentasi / Bukti Lampiran</h3>
                <button type="button" onclick="closeDocsModal(event, true)" class="text-gray-400 hover:text-gray-500">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div id="docs-container" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Images will be injected here via JS -->
            </div>
            
            <div class="mt-6 sm:flex sm:flex-row-reverse border-t border-gray-100 pt-4">
                <button type="button" onclick="closeDocsModal(event, true)" class="w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal for Full Image -->
<div id="lightbox" class="fixed inset-0 z-[100] hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 transition-opacity duration-300" onclick="closeLightbox(event)">
    <div class="relative w-full max-w-5xl flex items-center justify-center">
        <button type="button" onclick="closeLightbox(event, true)" class="absolute -top-12 right-0 text-white hover:text-gray-300 p-2 focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <img id="lightbox-img" src="" class="max-h-[85vh] max-w-full object-contain rounded shadow-2xl scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
    </div>
</div>

<script>
function openDocsModal(title, images) {
    const modal = document.getElementById('docsModal');
    const container = document.getElementById('docs-container');
    const titleEl = document.getElementById('docs-modal-title');
    
    titleEl.textContent = 'Dokumentasi: ' + title;
    container.innerHTML = '';
    
    images.forEach(imgUrl => {
        const wrapper = document.createElement('div');
        wrapper.className = 'relative aspect-square bg-gray-100 rounded-xl overflow-hidden border border-gray-200 shadow-sm group';
        
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'block w-full h-full focus:outline-none';
        btn.onclick = function() { openLightbox(imgUrl); };
        
        const img = document.createElement('img');
        img.src = imgUrl;
        img.className = 'w-full h-full object-cover transition-transform duration-300 group-hover:scale-105';
        
        const overlay = document.createElement('div');
        overlay.className = 'absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center';
        overlay.innerHTML = '<svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>';
        
        btn.appendChild(img);
        btn.appendChild(overlay);
        wrapper.appendChild(btn);
        container.appendChild(wrapper);
    });
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDocsModal(event, force = false) {
    if (force || (event && event.target.id === 'docsModal')) {
        document.getElementById('docsModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

function openLightbox(imageSrc) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    
    lightboxImg.src = imageSrc;
    lightbox.classList.remove('hidden');
    
    setTimeout(() => {
        lightbox.classList.remove('opacity-0');
        lightboxImg.classList.remove('scale-95');
        lightboxImg.classList.add('scale-100');
    }, 10);
}

function closeLightbox(event, force = false) {
    if (force || (event && event.target.id === 'lightbox')) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        
        lightbox.classList.add('opacity-0');
        lightboxImg.classList.remove('scale-100');
        lightboxImg.classList.add('scale-95');
        
        setTimeout(() => {
            lightbox.classList.add('hidden');
            lightboxImg.src = '';
            // We don't restore body overflow because docsModal might still be open
        }, 300);
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        const lightbox = document.getElementById('lightbox');
        const docsModal = document.getElementById('docsModal');
        
        if (!lightbox.classList.contains('hidden')) {
            closeLightbox(null, true);
        } else if (!docsModal.classList.contains('hidden')) {
            closeDocsModal(null, true);
        }
    }
});

function confirmMath(event) {
    event.preventDefault();
    const form = event.target;
    const num1 = Math.floor(Math.random() * 10) + 1;
    const num2 = Math.floor(Math.random() * 10) + 1;
    
    Swal.fire({
        title: 'Konfirmasi Penghapusan',
        html: `Anda akan menghapus data ini secara permanen.<br><br>Untuk memvalidasi, ketikkan hasil dari: <b>${num1} + ${num2}</b>`,
        icon: 'warning',
        input: 'number',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus Data',
        cancelButtonText: 'Batal',
        preConfirm: (answer) => {
            if (!answer || parseInt(answer) !== (num1 + num2)) {
                Swal.showValidationMessage('Jawaban salah! Penghapusan dibatalkan.');
                return false;
            }
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection
