@extends('layouts.app')

@section('page-title', 'Total Panjat Pohon')
@section('page-subtitle', 'Rekapitulasi Total Pohon Kelapa yang Dipanjat Karyawan (Semua Periode)')

@section('content')
<div class="space-y-6">

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-wrap items-end gap-4">
        <form action="{{ route('panen.index') }}" method="GET" class="flex flex-wrap items-end gap-4 w-full">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pilih Lokasi Kebun</label>
                <select name="lokasi" class="w-64 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500" onchange="this.form.submit()">
                    <option value="Semua Kebun" {{ $selectedLokasi == 'Semua Kebun' ? 'selected' : '' }}>-- Semua Kebun (Total Keseluruhan) --</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi }}" {{ $selectedLokasi == $lokasi ? 'selected' : '' }}>{{ $lokasi }}</option>
                    @endforeach
                </select>
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
                Data Akumulasi
            </h3>
            <p class="text-sm text-emerald-600 mt-1">Total pohon kelapa yang dipanjat di <span class="font-bold">{{ $selectedLokasi == 'Semua Kebun' ? 'seluruh lokasi kebun' : 'kebun ' . $selectedLokasi }}</span>.</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">Total Pohon</p>
            <p class="text-4xl font-black text-emerald-700 mt-1">{{ number_format($grandTotalPohon, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <h3 class="font-bold text-gray-800">Rincian Pemanjat</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-600 uppercase bg-gray-50 border-b border-gray-200 font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Nama Karyawan</th>
                        <th class="px-6 py-4 text-center">Total Pohon</th>
                        <th class="px-6 py-4 text-right">Estimasi Upah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($dataRekap as $index => $data)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $data['nama'] }}</td>
                        <td class="px-6 py-4 text-center font-bold text-emerald-600 text-lg">{{ number_format($data['total_pohon'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right text-gray-600">Rp {{ number_format($data['total_upah'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            <p>Tidak ada data pemanjat kelapa di kebun ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if(count($dataRekap) > 0)
                <tfoot class="bg-gray-50 border-t border-gray-200 font-bold">
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-right text-gray-700 uppercase tracking-wider text-xs">Grand Total</td>
                        <td class="px-6 py-4 text-center text-emerald-700 text-xl">{{ number_format($grandTotalPohon, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right text-gray-800">Rp {{ number_format($grandTotalUpah, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection
