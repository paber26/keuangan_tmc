@extends('layouts.app')

@section('page-title', 'Total Kupas Kelapa')
@section('page-subtitle', 'Rekapitulasi Total Kelapa yang Dikupas Karyawan')

@section('content')
<div class="space-y-6">

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-wrap items-end gap-4">
        <form action="{{ route('kupas.index') }}" method="GET" class="flex flex-wrap items-end gap-4 w-full">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pilih Lokasi Kebun</label>
                <select name="lokasi" class="w-64 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" onchange="this.form.submit()">
                    <option value="Semua Kebun" {{ $selectedLokasi == 'Semua Kebun' ? 'selected' : '' }}>-- Semua Kebun (Total Keseluruhan) --</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi }}" {{ $selectedLokasi == $lokasi ? 'selected' : '' }}>{{ $lokasi }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pilih Bulan</label>
                <input type="month" name="month" value="{{ $selectedMonth }}" class="w-48 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" onchange="this.form.submit()">
            </div>
            
            <button type="submit" class="px-6 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition shadow-sm">
                Segarkan
            </button>
        </form>
    </div>

    <!-- Summary Banner -->
    <div class="bg-emerald-50 rounded-2xl p-5 border border-emerald-100 flex items-center justify-between shadow-sm">
        <div>
            <h3 class="text-lg font-bold text-emerald-800">
                @if($selectedMonth)
                    Bulan: {{ \Carbon\Carbon::parse($selectedMonth.'-01')->translatedFormat('F Y') }}
                @else
                    Data Akumulasi (Semua Periode)
                @endif
            </h3>
            <p class="text-sm text-emerald-600 mt-1">Total kelapa yang dikupas di <span class="font-bold">{{ $selectedLokasi == 'Semua Kebun' ? 'seluruh lokasi kebun' : 'kebun ' . $selectedLokasi }}</span>.</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">Total Butir</p>
            <p class="text-4xl font-black text-emerald-700 mt-1">{{ number_format($grandTotalButir, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Data Chart -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-6 sm:p-8">
        <div class="flex items-center gap-3 mb-8">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <h3 class="font-bold text-gray-800">Rincian Pekerja</h3>
        </div>
        
        <div class="relative max-w-4xl mx-auto">
            @if(count($dataRekap) > 0)
                <!-- Y-Axis Line -->
                <div class="absolute left-[150px] top-0 bottom-0 w-px bg-gray-400 z-0 hidden sm:block"></div>
                
                <div class="space-y-6 relative z-10">
                    @php 
                        $maxButir = 0;
                        foreach($dataRekap as $d) {
                            if($d['total_butir'] > $maxButir) $maxButir = $d['total_butir'];
                        }
                    @endphp

                    @foreach($dataRekap as $index => $data)
                        @php
                            $percentage = $maxButir > 0 ? ($data['total_butir'] / $maxButir) * 85 : 0; // Using 85% max width to leave room for the text
                            if ($percentage > 0 && $percentage < 1) $percentage = 1;
                        @endphp
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-0">
                            <div class="w-full sm:w-[150px] sm:pr-4 sm:text-right shrink-0">
                                <span class="text-sm text-gray-600">{{ $data['nama'] }}</span>
                            </div>
                            <div class="flex-grow flex items-center w-full">
                                <div class="bg-blue-500 h-8 rounded-sm hover:bg-blue-600 transition-colors shadow-sm" style="width: {{ $percentage }}%"></div>
                                <span class="ml-3 text-sm font-semibold text-gray-700">{{ number_format($data['total_butir'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-12 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <p>Tidak ada data kupas kelapa di kebun ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
