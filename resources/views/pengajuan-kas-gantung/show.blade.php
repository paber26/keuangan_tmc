@extends('layouts.app')
@section('page-title', 'Detail Pengajuan Kas Gantung (A5)')

@section('content')
@php
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tgl = \Carbon\Carbon::parse($pengajuan_kas_gantung->tanggal);
    $nama_hari = $hari[$tgl->dayOfWeek];
    $nama_bulan = $bulan[$tgl->month];
    $tanggal_indo = $nama_hari . ', ' . $tgl->day . ' ' . $nama_bulan . ' ' . $tgl->year;
@endphp

<div class="w-full pb-10">
    <div class="mb-8 print:hidden">
        <a href="{{ route('pengajuan-kas-gantung.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Cetak Form Pengajuan Dana</h2>
            <a href="{{ route('pengajuan-kas-gantung.print', $pengajuan_kas_gantung->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Pengajuan
            </a>
        </div>
    </div>

    <!-- Paper Container -->
    <div class="w-full max-w-5xl mx-auto bg-white p-8 md:p-12 shadow-xl rounded-sm print:p-0 print:shadow-none print:m-0">
        
        <!-- Printable Area -->
        <div id="printable-area" class="w-full font-sans text-black border-2 border-black">
            
            <!-- Header -->
            <div class="flex items-center border-b-2 border-black p-4">
                <div class="w-1/6 flex justify-center">
                    <img src="{{ asset('logo.jpg') }}" alt="TMC Logo" class="w-16 h-16 object-contain">
                </div>
                <div class="w-5/6 text-center pr-16">
                    <h1 class="text-xl md:text-2xl font-bold uppercase tracking-wide mb-1" style="font-family: 'Arial', sans-serif;">PT. TRI MUSTIKA COCOMINAESA</h1>
                    <p class="text-[11px] md:text-xs font-semibold">Jl. Raya A.K.D. Km. 90, Teep Kec. Amurang Barat Kab. Minahasa Selatan, Sulawesi Utara 95955, Indonesia</p>
                </div>
            </div>

            <!-- Form Title -->
            <div class="border-b-2 border-black py-2 text-center">
                <h2 class="text-lg md:text-xl font-bold" style="font-family: 'Arial', sans-serif;">Form Pengajuan Dana</h2>
            </div>

            <!-- Info Section -->
            <div class="border-b-2 border-black p-3">
                <table class="w-full text-sm font-bold">
                    <tbody>
                        <tr>
                            <td class="w-64 pb-1">Departemen</td>
                            <td class="pb-1">: {{ strtoupper($pengajuan_kas_gantung->departemen ?? 'PERKEBUNAN') }}</td>
                        </tr>
                        <tr>
                            <td class="pb-1">Pengajuan Untuk Kebutuhan</td>
                            <td class="pb-1">: {{ strtoupper($pengajuan_kas_gantung->pengajuan_kebutuhan ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td class="pb-1">Perihal</td>
                            <td class="pb-1">: {{ $pengajuan_kas_gantung->judul_pengajuan ?? 'Pengajuan Kas Gantung' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pengajuan</td>
                            <td>: {{ $tanggal_indo }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table -->
            <table class="w-full text-sm border-collapse border-b-2 border-black">
                <thead>
                    <tr class="border-b-2 border-black text-center font-bold">
                        <th class="border-r-2 border-black p-2 w-12">NO.</th>
                        <th class="border-r-2 border-black p-2">URAIAN</th>
                        <th class="border-r-2 border-black p-2 w-48">TOTAL HARGA</th>
                        <th class="p-2 w-72">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan_kas_gantung->items as $index => $item)
                    <tr class="border-b-2 border-black">
                        <td class="border-r-2 border-black p-2 text-center font-bold">{{ $index + 1 }}</td>
                        <td class="border-r-2 border-black p-2 font-bold">{{ strtoupper($item->nama_barang) }}</td>
                        <td class="border-r-2 border-black p-2 font-bold">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="p-2 font-bold">{{ strtoupper($item->keterangan_pengajuan) }}</td>
                    </tr>
                    @endforeach

                    <!-- Fill empty rows up to 5 -->
                    @for($i = count($pengajuan_kas_gantung->items) + 1; $i <= 5; $i++)
                    <tr class="border-b-2 border-black h-10">
                        <td class="border-r-2 border-black p-2 text-center font-bold">{{ $i }}</td>
                        <td class="border-r-2 border-black p-2"></td>
                        <td class="border-r-2 border-black p-2"></td>
                        <td class="p-2"></td>
                    </tr>
                    @endfor

                    <!-- Total Row -->
                    <tr class="font-bold border-black">
                        <td colspan="2" class="border-r-2 border-black p-2 text-center">TOTAL PENGAJUAN DANA</td>
                        <td class="border-r-2 border-black p-2">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($pengajuan_kas_gantung->grand_total, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="p-2"></td>
                    </tr>
                </tbody>
            </table>

            <!-- Signatures Header -->
            <div class="grid grid-cols-5 text-center text-sm font-bold border-t-2 border-b-2 border-black">
                <div class="border-r-2 border-black p-2">Dibuat Oleh</div>
                <div class="border-r-2 border-black p-2">Diketahui Oleh</div>
                <div class="border-r-2 border-black p-2">Disetujui Oleh</div>
                <div class="border-r-2 border-black p-2">Dibayar Oleh</div>
                <div class="p-2">Diterima Oleh</div>
            </div>

            <!-- Signatures Names -->
            <div class="grid grid-cols-5 text-center text-sm font-bold h-28">
                <div class="border-r-2 border-black p-2 flex flex-col justify-end">
                    <span class="border-b-2 border-black mx-2 pb-1">ALDO</span>
                </div>
                <div class="border-r-2 border-black p-2 flex flex-col justify-end">
                    <span class="border-b-2 border-black mx-2 pb-1">DAVID</span>
                </div>
                <div class="border-r-2 border-black p-2 flex flex-col justify-end">
                    <span class="border-b-2 border-black mx-2 pb-1">STANLY</span>
                </div>
                <div class="border-r-2 border-black p-2 flex flex-col justify-end">
                    <span class="border-b-2 border-black mx-2 pb-1">PRISILLIA</span>
                </div>
                <div class="p-2 flex flex-col justify-end">
                    <span class="border-b-2 border-black mx-2 pb-1 text-transparent select-none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
            </div>

        </div>
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

@push('styles')
<style>
    @media print {
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
            border: 2px solid black !important;
        }
        .border-black {
            border-color: black !important;
        }
        .border-2 {
            border-width: 2px !important;
        }
        .border-b-2 {
            border-bottom-width: 2px !important;
        }
        .border-t-2 {
            border-top-width: 2px !important;
        }
        .border-r-2 {
            border-right-width: 2px !important;
        }
        .border-l-2 {
            border-left-width: 2px !important;
        }
    }
</style>
@endpush
@endsection
