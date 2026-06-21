@extends('layouts.app')
@section('page-title', 'Detail Pengajuan BBM')

@section('content')
@php
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tgl = \Carbon\Carbon::parse($pengajuan_bbm->tanggal);
    $nama_hari = $hari[$tgl->dayOfWeek];
    $nama_bulan = $bulan[$tgl->month];
    $tanggal_indo = $nama_hari . ', ' . $tgl->day . ' ' . $nama_bulan . ' ' . $tgl->year;
@endphp

<div class="w-full pb-10">
    <div class="mb-8 print:hidden">
        <a href="{{ route('pengajuan-bbm.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Cetak Form Pengajuan Dana</h2>
            <a href="{{ route('pengajuan-bbm.print', $pengajuan_bbm->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all">
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
                            <td class="pb-1">: {{ strtoupper($pengajuan_bbm->departemen ?? 'PERKEBUNAN') }}</td>
                        </tr>
                        <tr>
                            <td class="pb-1">Pengajuan Untuk Kebutuhan</td>
                            <td class="pb-1">: {{ $pengajuan_bbm->kebun ? $pengajuan_bbm->kebun->lokasi : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="pb-1">Perihal</td>
                            <td class="pb-1">: {{ $pengajuan_bbm->perihal ?? 'Kebutuhan Biaya BBM' }}</td>
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
                    @foreach($pengajuan_bbm->items as $index => $item)
                    <tr class="border-b-2 border-black">
                        <td class="border-r-2 border-black p-2 text-center font-bold">{{ $index + 1 }}</td>
                        <td class="border-r-2 border-black p-2 font-bold">{{ strtoupper($item->uraian) }}</td>
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
                    @for($i = count($pengajuan_bbm->items) + 1; $i <= 5; $i++)
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
                                <span>{{ number_format($pengajuan_bbm->grand_total, 0, ',', '.') }}</span>
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
                <div class="p-2">Dibukukan Oleh</div>
            </div>

            <!-- Signatures Names -->
            <div class="grid grid-cols-5 text-center text-sm font-bold h-28">
                <div class="border-r-2 border-black p-2 flex flex-col justify-end">
                    <span class="border-b-2 border-black mx-2 pb-1">{{ strtoupper($pengajuan_bbm->karyawan ? $pengajuan_bbm->karyawan->nama : 'ALDO') }}</span>
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
                    <span class="border-b-2 border-black mx-2 pb-1">EDMON</span>
                </div>
            </div>

        </div>
    </div>

    @if($pengajuan_bbm->images && $pengajuan_bbm->images->count() > 0)
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Dokumentasi / Bukti ({{ $pengajuan_bbm->images->count() }})</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($pengajuan_bbm->images as $img)
            <div class="relative aspect-square bg-gray-100 rounded-xl overflow-hidden border border-gray-200 shadow-sm group">
                <a href="{{ Storage::url($img->image_path) }}" target="_blank" class="block w-full h-full">
                    <img src="{{ Storage::url($img->image_path) }}" alt="Dokumentasi" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

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
