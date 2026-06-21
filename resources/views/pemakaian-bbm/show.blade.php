@extends('layouts.app')
@section('title', 'Detail Pemakaian BBM - ' . $pemakaian_bbm->kategori)

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <a href="{{ route('pemakaian-bbm.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                Detail Pemakaian BBM - {{ $pemakaian_bbm->kategori }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">Ref: INV-BBM-{{ str_pad($pemakaian_bbm->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="printable-area">
        <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start gap-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo.jpg') }}" alt="TMC Logo" class="w-16 h-16 object-contain rounded bg-white p-1 border border-gray-100 shadow-sm">
                <div>
                    <h3 class="text-xl font-bold text-emerald-800 mb-1">PT. TRI MUSTIKA COCOMINAESA</h3>
                    <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">INVOICE PEMAKAIAN BBM {{ strtoupper($pemakaian_bbm->kategori) }}</p>
                </div>
            </div>
            <div class="md:ml-auto">
                <table class="text-sm text-left">
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Tanggal Laporan</td>
                        <td class="text-gray-500 pr-2 pb-1">:</td>
                        <td class="font-medium text-gray-800 pb-1">{{ \Carbon\Carbon::parse($pemakaian_bbm->tanggal)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Lokasi Kebun</td>
                        <td class="text-gray-500 pr-2 pb-1">:</td>
                        <td class="font-medium text-gray-800 pb-1">{{ $pemakaian_bbm->kebun ? $pemakaian_bbm->kebun->lokasi : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Nama Pengambil</td>
                        <td class="text-gray-500 pr-2 pb-1">:</td>
                        <td class="font-medium text-gray-800 pb-1">{{ $pemakaian_bbm->karyawan ? $pemakaian_bbm->karyawan->nama : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Judul Laporan</td>
                        <td class="text-gray-500 pr-2 pb-1">:</td>
                        <td class="font-medium text-gray-800 pb-1">{{ $pemakaian_bbm->judul_laporan }}</td>
                    </tr>
                </table>
            </div>
        </div>

        @if($pemakaian_bbm->keterangan)
        <div class="px-8 py-4 bg-gray-50/50 border-b border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Keterangan Tambahan</p>
            <p class="text-sm text-gray-700">{{ $pemakaian_bbm->keterangan }}</p>
        </div>
        @endif

        <div class="p-8">
            <div class="overflow-x-auto border border-gray-800">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#3B6653] text-white">
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[50px] text-center">No</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 text-center">Tanggal</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800">Tipe BBM</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800">Keterangan Pemakaian</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[120px] text-center">Liter</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[180px] text-center">Harga / Liter (Rp)</th>
                            <th class="py-2.5 px-4 text-sm font-semibold w-[200px] text-center">Total Harga (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 bg-white">
                        @php $totalLiter = 0; @endphp
                        @foreach($pemakaian_bbm->items as $index => $item)
                        @php $totalLiter += $item->jumlah_liter; @endphp
                        <tr>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-center border-r border-gray-800">{{ $index + 1 }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-center border-r border-gray-800">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 border-r border-gray-800">{{ $item->tipe_bbm }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 border-r border-gray-800">{{ $item->keterangan_pemakaian }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-center border-r border-gray-800">{{ number_format($item->jumlah_liter, 2, ',', '.') }} L</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-right border-r border-gray-800">{{ number_format($item->harga_per_liter, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-right">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 border-t border-gray-800">
                            <td colspan="4" class="py-3 px-4 text-sm font-bold text-gray-800 uppercase border-r border-gray-800 text-right">GRAND TOTAL</td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-center border-r border-gray-800">{{ number_format($totalLiter, 2, ',', '.') }} L</td>
                            <td class="py-3 px-4 border-r border-gray-800"></td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-right">{{ number_format($pemakaian_bbm->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @if($pemakaian_bbm->images->count() > 0)
        <div id="dokumentasi" class="px-8 py-6 border-t border-gray-100 bg-gray-50/30">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-widest mb-4">Dokumentasi / Bukti Lampiran</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($pemakaian_bbm->images as $img)
                <button type="button" onclick="openLightbox('{{ Storage::url($img->image_path) }}')" class="block w-full h-full focus:outline-none">
                    <img src="{{ Storage::url($img->image_path) }}" alt="Dokumentasi" class="w-full aspect-square object-cover rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                </button>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightbox" class="fixed inset-0 z-[100] hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 transition-opacity duration-300" onclick="closeLightbox(event)">
    <div class="relative w-full max-w-5xl flex items-center justify-center">
        <button type="button" onclick="closeLightbox(event, true)" class="absolute -top-12 right-0 text-white hover:text-gray-300 p-2 focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <img id="lightbox-img" src="" class="max-h-[85vh] max-w-full object-contain rounded shadow-2xl scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
    </div>
</div>

<style>
@media print {
    body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    body * {
        visibility: hidden;
    }
    #printable-area, #printable-area * {
        visibility: visible;
    }
    #printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        border: none;
        box-shadow: none;
    }
}
</style>

<script>
    function openLightbox(imageSrc) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        
        lightboxImg.src = imageSrc;
        lightbox.classList.remove('hidden');
        
        // Trigger animation
        setTimeout(() => {
            lightbox.classList.remove('opacity-0');
            lightboxImg.classList.remove('scale-95');
            lightboxImg.classList.add('scale-100');
        }, 10);
        
        // Prevent scrolling on body
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox(event, force = false) {
        // If force is true (close button clicked) or clicked outside the image
        if (force || event.target.id === 'lightbox') {
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            
            lightbox.classList.add('opacity-0');
            lightboxImg.classList.remove('scale-100');
            lightboxImg.classList.add('scale-95');
            
            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightboxImg.src = '';
                document.body.style.overflow = 'auto'; // Restore scrolling
            }, 300);
        }
    }

    // Close on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            const lightbox = document.getElementById('lightbox');
            if (!lightbox.classList.contains('hidden')) {
                closeLightbox(event, true);
            }
        }
    });
</script>
@endsection
