@extends('layouts.app')

@section('title', 'Rekap Bulanan')
@section('page-title', 'Rekap Bulanan')
@section('page-subtitle', 'Rangkuman keuangan per bulan')

@section('page-actions')
    <div class="flex items-center gap-2">
        <button class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Word
        </button>
        <button class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export PDF
        </button>
    </div>
@endsection

@section('content')

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-wrap items-end gap-4">
            <div class="min-w-[130px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Bulan</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                    <option>April</option>
                    <option>Mei</option>
                    <option selected>Juni</option>
                    <option>Juli</option>
                    <option>Agustus</option>
                    <option>September</option>
                    <option>Oktober</option>
                    <option>November</option>
                    <option>Desember</option>
                </select>
            </div>
            <div class="min-w-[100px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tahun</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option>2024</option>
                    <option>2025</option>
                    <option selected>2026</option>
                </select>
            </div>
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kebun</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option selected>Semua Kebun</option>
                    <option>Kebun Cikaret</option>
                    <option>Kebun Sukamaju</option>
                    <option>Kebun Ciomas</option>
                </select>
            </div>
            <button class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Tampilkan
            </button>
        </div>
    </div>

    {{-- Laba Rugi Summary Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <h3 class="text-sm font-bold text-gray-800">Laba Rugi — Juni 2026</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Left: Numbers --}}
                <div class="space-y-5">
                    {{-- Pemasukan --}}
                    <div class="flex items-center justify-between p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Pemasukan Total</p>
                                <p class="text-xl font-bold text-emerald-600">Rp 45.800.000</p>
                            </div>
                        </div>
                    </div>

                    {{-- Pengeluaran --}}
                    <div class="flex items-center justify-between p-4 bg-red-50/50 rounded-xl border border-red-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase">Pengeluaran Total</p>
                                <p class="text-xl font-bold text-red-500">Rp 28.350.000</p>
                            </div>
                        </div>
                    </div>

                    {{-- Laba Bersih --}}
                    <div class="p-5 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-lg shadow-emerald-500/20">
                        <p class="text-xs font-semibold text-emerald-100 uppercase tracking-wide">Laba Bersih</p>
                        <p class="text-3xl font-extrabold text-white mt-1">Rp 17.450.000</p>
                        <div class="flex items-center gap-2 mt-2">
                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            <span class="text-sm text-emerald-100 font-medium">+12.5% dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Bar Chart Visual --}}
                <div class="flex flex-col justify-center">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4">Perbandingan Pemasukan vs Pengeluaran</p>

                    {{-- Pemasukan Bar --}}
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-medium text-gray-600">Pemasukan</span>
                            <span class="text-sm font-bold text-emerald-600">Rp 45.800.000</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-5 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 h-5 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-2" style="width: 100%">
                                <span class="text-[10px] font-bold text-white">100%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Pengeluaran Bar --}}
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-medium text-gray-600">Pengeluaran</span>
                            <span class="text-sm font-bold text-red-500">Rp 28.350.000</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-5 overflow-hidden">
                            <div class="bg-gradient-to-r from-red-400 to-red-500 h-5 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-2" style="width: 61.9%">
                                <span class="text-[10px] font-bold text-white">61.9%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Laba Bar --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-medium text-gray-600">Laba Bersih</span>
                            <span class="text-sm font-bold text-blue-600">Rp 17.450.000</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-5 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-400 to-blue-500 h-5 rounded-full transition-all duration-1000 ease-out flex items-center justify-end pr-2" style="width: 38.1%">
                                <span class="text-[10px] font-bold text-white">38.1%</span>
                            </div>
                        </div>
                    </div>

                    {{-- Ratio info --}}
                    <div class="mt-5 p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <p class="text-xs text-gray-500">Rasio Pengeluaran: <span class="font-bold text-gray-700">61.9%</span> dari pemasukan</p>
                        <p class="text-xs text-gray-500 mt-1">Margin Laba: <span class="font-bold text-emerald-600">38.1%</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rincian Pemasukan & Pengeluaran --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        {{-- Rincian Pemasukan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                    Rincian Pemasukan
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Penjualan Kelapa Butiran</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600">Rp 24.200.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Penjualan Kopra</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600">Rp 8.400.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Penjualan Kelapa Muda</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600">Rp 9.000.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Penjualan Nira / Gula Aren</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600">Rp 4.200.000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-emerald-50/50 border-t-2 border-emerald-200">
                            <td class="px-5 py-3.5 text-sm font-bold text-gray-700">Total Pemasukan</td>
                            <td class="px-5 py-3.5 text-right font-bold text-emerald-600 text-base">Rp 45.800.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Rincian Pengeluaran --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    Rincian Pengeluaran
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Gaji Tetap</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500">Rp 10.700.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-orange-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Upah Harian</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500">Rp 5.400.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-purple-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Upah Borongan</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500">Rp 4.900.000</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                    <span class="text-gray-700 font-medium">Operasional</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500">Rp 7.350.000</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-red-50/50 border-t-2 border-red-200">
                            <td class="px-5 py-3.5 text-sm font-bold text-gray-700">Total Pengeluaran</td>
                            <td class="px-5 py-3.5 text-right font-bold text-red-500 text-base">Rp 28.350.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Per-Kebun Comparison --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Perbandingan Laba Rugi Per Kebun
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Juni 2026</p>
        </div>
        <div class="p-6">
            {{-- Chart --}}
            <div id="chart-per-kebun" class="w-full" style="min-height: 320px;"></div>

            {{-- Table Summary Below Chart --}}
            <div class="mt-6 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kebun</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemasukan</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengeluaran</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Laba/Rugi</th>
                            <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Margin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-emerald-500 rounded-sm"></span>
                                    <span class="text-gray-700 font-medium">Kebun Cikaret</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600">Rp 21.400.000</td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500">Rp 12.800.000</td>
                            <td class="px-5 py-3.5 text-right font-bold text-emerald-600">Rp 8.600.000</td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">40.2%</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-blue-500 rounded-sm"></span>
                                    <span class="text-gray-700 font-medium">Kebun Sukamaju</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600">Rp 12.400.000</td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500">Rp 8.250.000</td>
                            <td class="px-5 py-3.5 text-right font-bold text-emerald-600">Rp 4.150.000</td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">33.5%</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-amber-500 rounded-sm"></span>
                                    <span class="text-gray-700 font-medium">Kebun Ciomas</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600">Rp 12.000.000</td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500">Rp 7.300.000</td>
                            <td class="px-5 py-3.5 text-right font-bold text-emerald-600">Rp 4.700.000</td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">39.2%</span>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50/80 border-t-2 border-gray-200">
                            <td class="px-5 py-3.5 text-sm font-bold text-gray-700">Total</td>
                            <td class="px-5 py-3.5 text-right font-bold text-emerald-600">Rp 45.800.000</td>
                            <td class="px-5 py-3.5 text-right font-bold text-red-500">Rp 28.350.000</td>
                            <td class="px-5 py-3.5 text-right font-bold text-blue-600">Rp 17.450.000</td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">38.1%</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Bottom Export Buttons --}}
    <div class="flex items-center justify-center gap-4 mt-6">
        <button class="inline-flex items-center gap-2.5 bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all duration-200 shadow-lg shadow-blue-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export ke Word
        </button>
        <button class="inline-flex items-center gap-2.5 bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl text-sm font-bold transition-all duration-200 shadow-lg shadow-red-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export ke PDF
        </button>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var options = {
            series: [
                {
                    name: 'Pemasukan',
                    data: [21400000, 12400000, 12000000]
                },
                {
                    name: 'Pengeluaran',
                    data: [12800000, 8250000, 7300000]
                },
                {
                    name: 'Laba Bersih',
                    data: [8600000, 4150000, 4700000]
                }
            ],
            chart: {
                type: 'bar',
                height: 320,
                fontFamily: 'Inter, system-ui, sans-serif',
                toolbar: { show: false },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 6,
                    borderRadiusApplication: 'end',
                },
            },
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: ['Kebun Cikaret', 'Kebun Sukamaju', 'Kebun Ciomas'],
                labels: {
                    style: { fontSize: '12px', fontWeight: 500, colors: '#6b7280' }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return 'Rp ' + (val / 1000000).toFixed(1) + ' jt';
                    },
                    style: { fontSize: '11px', colors: '#9ca3af' }
                }
            },
            colors: ['#10b981', '#ef4444', '#3b82f6'],
            fill: { opacity: 1 },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontSize: '12px',
                fontWeight: 500,
                markers: { radius: 3 }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-per-kebun"), options);
        chart.render();
    });
</script>
@endpush
