@extends('layouts.app')
@section('page-title', 'Dokumentasi Harian')

@section('content')
<div class="w-full pb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
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

    {{-- Filter Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <form method="GET" action="{{ route('dokumentasi.index') }}" class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Lokasi Kebun</label>
                    <select name="lokasi" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                        <option value="">Semua Lokasi</option>
                        @foreach($lokasiList as $loc)
                            <option value="{{ $loc->lokasi }}" {{ request('lokasi') == $loc->lokasi ? 'selected' : '' }}>
                                {{ $loc->lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-2">Tampilan</label>
                    <select name="view" class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm transition-colors">
                        <option value="grid" {{ $viewMode == 'grid' ? 'selected' : '' }}>Grid</option>
                        <option value="table" {{ $viewMode == 'table' ? 'selected' : '' }}>Tabel</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter
                    </button>
                    <a href="{{ route('dokumentasi.index') }}" class="flex-none inline-flex justify-center items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors" title="Reset Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($viewMode == 'grid')
        {{-- GRID VIEW --}}
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
                    <div class="flex justify-between items-start mb-1">
                        <div class="text-xs font-semibold text-emerald-600">{{ \Carbon\Carbon::parse($doc->tanggal)->format('d M Y') }}</div>
                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $doc->kebun->lokasi ?? '-' }}</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-1 line-clamp-1">{{ $doc->judul }}</h3>
                    <div class="text-xs text-emerald-600 font-medium mb-2 truncate" title="{{ $doc->karyawans->count() > 0 ? $doc->karyawans->pluck('nama')->join(', ') : 'Tidak ada karyawan' }}">
                        {{ $doc->karyawans->count() > 0 ? $doc->karyawans->pluck('nama')->join(', ') : 'Tidak ada karyawan' }}
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $doc->keterangan ?: 'Tidak ada keterangan' }}</p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
                        <button type="button" onclick="openModal({{ $doc->id }})" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Detail &rarr;</button>
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
    @else
        {{-- TABLE VIEW --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Tanggal</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Kebun</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Karyawan</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Judul</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Foto</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($dokumentasi as $doc)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                {{ \Carbon\Carbon::parse($doc->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                    {{ $doc->kebun->lokasi ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div class="text-xs font-medium mb-1 truncate max-w-[150px]" title="{{ $doc->karyawans->count() > 0 ? $doc->karyawans->pluck('nama')->join(', ') : 'Tidak ada karyawan' }}">
                                    {{ $doc->karyawans->count() > 0 ? $doc->karyawans->pluck('nama')->join(', ') : '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                <div class="font-medium text-gray-900">{{ $doc->judul }}</div>
                                <div class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $doc->keterangan ?: 'Tidak ada keterangan' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex -space-x-2 overflow-hidden">
                                    @php $limit = 3; @endphp
                                    @foreach($doc->images->take($limit) as $img)
                                        <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover" src="{{ Storage::url($img->image_path) }}" alt="Foto">
                                    @endforeach
                                    @if($doc->images->count() > $limit)
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full ring-2 ring-white bg-gray-100 text-xs font-medium text-gray-500 z-10 relative">
                                            +{{ $doc->images->count() - $limit }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <button type="button" onclick="openModal({{ $doc->id }})" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-lg transition-colors" title="Lihat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <a href="{{ route('dokumentasi.edit', $doc->id) }}" class="text-amber-600 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 p-1.5 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('dokumentasi.destroy', $doc->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus dokumentasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p>Belum ada dokumentasi yang sesuai filter.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" aria-hidden="true" onclick="closeModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl w-full border border-gray-100">
                <div class="bg-white px-6 pt-6 pb-6">
                    <div class="flex justify-between items-start mb-5 border-b border-gray-100 pb-5">
                        <div>
                            <h3 class="text-xl leading-6 font-bold text-gray-900 tracking-tight" id="modal-judul">Judul</h3>
                            <p class="text-sm text-gray-500 mt-1.5 flex items-center gap-2" id="modal-tanggal">Tanggal</p>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 p-2 rounded-full transition-colors" onclick="closeModal()">
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-2">
                        <h4 class="text-sm font-bold text-gray-800 mb-2">Keterangan</h4>
                        <div class="text-sm text-gray-600 bg-gray-50/50 p-4 rounded-xl border border-gray-100/50 leading-relaxed" id="modal-keterangan">Keterangan</div>
                    </div>
                    <div class="mt-6">
                        <h4 class="text-sm font-bold text-gray-800 mb-3" id="modal-galeri-title">Galeri Foto</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="modal-galeri">
                            <!-- Images appended here by JS -->
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end">
                    <button type="button" class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-5 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors" onclick="closeModal()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const docsData = @json($dokumentasi);
    const storageUrl = "{{ Storage::url('') }}";

    function openModal(id) {
        const doc = docsData.find(d => d.id === id);
        if (!doc) return;

        document.getElementById('modal-judul').innerText = doc.judul;
        
        const dateObj = new Date(doc.tanggal);
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        const formattedDate = dateObj.toLocaleDateString('id-ID', options);
        const location = doc.kebun ? doc.kebun.lokasi : '-';
        const employee = doc.karyawans && doc.karyawans.length > 0 ? doc.karyawans.map(k => k.nama).join(', ') : '-';
        
        document.getElementById('modal-tanggal').innerHTML = `
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            ${formattedDate} 
            <span class="mx-1 text-gray-300">•</span>
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            ${location}
            <span class="mx-1 text-gray-300">•</span>
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            ${employee}
        `;

        document.getElementById('modal-keterangan').innerText = doc.keterangan || 'Tidak ada keterangan.';

        const galeriContainer = document.getElementById('modal-galeri');
        galeriContainer.innerHTML = '';
        
        if (doc.images && doc.images.length > 0) {
            document.getElementById('modal-galeri-title').innerText = `Galeri Foto (${doc.images.length})`;
            doc.images.forEach(img => {
                const wrapper = document.createElement('a');
                wrapper.href = storageUrl + img.image_path;
                wrapper.target = '_blank';
                wrapper.className = 'block rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md hover:ring-2 hover:ring-emerald-500 transition-all';
                
                const imgEl = document.createElement('img');
                imgEl.src = storageUrl + img.image_path;
                imgEl.className = 'w-full h-32 object-cover hover:scale-105 transition-transform duration-300';
                
                wrapper.appendChild(imgEl);
                galeriContainer.appendChild(wrapper);
            });
        } else {
            document.getElementById('modal-galeri-title').innerText = 'Galeri Foto (0)';
            galeriContainer.innerHTML = '<p class="text-sm text-gray-400 col-span-full italic">Tidak ada foto dokumentasi.</p>';
        }

        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection
