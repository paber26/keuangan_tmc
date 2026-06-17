@extends('layouts.app')

@section('title', 'Rekap Mingguan')
@section('page-title', 'Rekap Mingguan')
@section('page-subtitle', 'Rangkuman aktivitas per minggu')

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

    {{-- Week Selector --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-wrap items-end gap-4">
            <div class="min-w-[140px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Minggu</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option>Minggu 1 (1-7)</option>
                    <option selected>Minggu 2 (8-14)</option>
                    <option>Minggu 3 (15-21)</option>
                    <option>Minggu 4 (22-30)</option>
                </select>
            </div>
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
                    <option>Semua Kebun</option>
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

    {{-- Summary Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        {{-- Total Hari Kerja --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Hari Kerja</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">36</p>
                    <p class="text-xs text-gray-400 mt-1">dari 6 karyawan</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>
        {{-- Total Hasil Kupas --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Hasil Kupas</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">3.250</p>
                    <p class="text-xs text-gray-400 mt-1">butir kelapa</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
            </div>
        </div>
        {{-- Total Panen --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Panen</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">1.800</p>
                    <p class="text-xs text-gray-400 mt-1">butir dipanen</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
            </div>
        </div>
        {{-- Total Pengeluaran --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">Rp 4.250.000</p>
                    <p class="text-xs text-gray-400 mt-1">minggu ini</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Section: Rekap Absensi --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Rekap Absensi
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">8 - 14 Juni 2026</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sen</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sel</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rab</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kam</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jum</th>
                        <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Sab</th>
                        <th class="text-center px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-gray-700 font-medium">Ahmad Hidayat</td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-5 py-3 text-center font-bold text-gray-800">6</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-gray-700 font-medium">Siti Aminah</td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-blue-50 text-blue-600 font-bold text-xs">I</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-5 py-3 text-center font-bold text-gray-800">5</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-gray-700 font-medium">Budi Santoso</td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-5 py-3 text-center font-bold text-gray-800">6</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-gray-700 font-medium">Rohman</td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-yellow-50 text-yellow-600 font-bold text-xs">S</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-yellow-50 text-yellow-600 font-bold text-xs">S</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-5 py-3 text-center font-bold text-gray-800">4</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-gray-700 font-medium">Dewi Lestari</td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-50 text-red-500 font-bold text-xs">A</span></td>
                        <td class="px-5 py-3 text-center font-bold text-gray-800">5</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-gray-700 font-medium">Ujang Supriatna</td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-3 py-3 text-center"><span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 font-bold text-xs">✓</span></td>
                        <td class="px-5 py-3 text-center font-bold text-gray-800">6</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50/80 border-t-2 border-gray-200">
                        <td class="px-5 py-3 text-sm font-bold text-gray-700">Total</td>
                        <td class="px-3 py-3 text-center text-xs font-bold text-gray-600">6</td>
                        <td class="px-3 py-3 text-center text-xs font-bold text-gray-600">5</td>
                        <td class="px-3 py-3 text-center text-xs font-bold text-gray-600">4</td>
                        <td class="px-3 py-3 text-center text-xs font-bold text-gray-600">6</td>
                        <td class="px-3 py-3 text-center text-xs font-bold text-gray-600">6</td>
                        <td class="px-3 py-3 text-center text-xs font-bold text-gray-600">5</td>
                        <td class="px-5 py-3 text-center font-bold text-emerald-600">32</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        {{-- Legend --}}
        <div class="px-5 py-3 border-t border-gray-100 flex flex-wrap items-center gap-4">
            <span class="text-xs text-gray-400 font-medium">Keterangan:</span>
            <span class="inline-flex items-center gap-1.5 text-xs text-gray-600"><span class="w-5 h-5 rounded-full bg-emerald-50 text-emerald-600 font-bold text-[10px] flex items-center justify-center">✓</span> Hadir</span>
            <span class="inline-flex items-center gap-1.5 text-xs text-gray-600"><span class="w-5 h-5 rounded-full bg-blue-50 text-blue-600 font-bold text-[10px] flex items-center justify-center">I</span> Izin</span>
            <span class="inline-flex items-center gap-1.5 text-xs text-gray-600"><span class="w-5 h-5 rounded-full bg-yellow-50 text-yellow-600 font-bold text-[10px] flex items-center justify-center">S</span> Sakit</span>
            <span class="inline-flex items-center gap-1.5 text-xs text-gray-600"><span class="w-5 h-5 rounded-full bg-red-50 text-red-500 font-bold text-[10px] flex items-center justify-center">A</span> Alpha</span>
        </div>
    </div>

    {{-- Section: Rekap Hasil Kupas --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Rekap Hasil Kupas
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Minggu 2 — Juni 2026</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Kupas</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tarif</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Upah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Siti Aminah</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Kupas Sabut</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">850 butir</td>
                        <td class="px-5 py-3.5 text-right text-gray-500">Rp 500</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 425.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Rohman</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Kupas Sabut</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">720 butir</td>
                        <td class="px-5 py-3.5 text-right text-gray-500">Rp 500</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 360.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Dewi Lestari</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700">Kupas Tempurung</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">600 butir</td>
                        <td class="px-5 py-3.5 text-right text-gray-500">Rp 800</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 480.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Ujang Supriatna</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">Kupas Sabut</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">680 butir</td>
                        <td class="px-5 py-3.5 text-right text-gray-500">Rp 500</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 340.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Ahmad Hidayat</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700">Kupas Tempurung</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">400 butir</td>
                        <td class="px-5 py-3.5 text-right text-gray-500">Rp 800</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 320.000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50/80 border-t-2 border-gray-200">
                        <td colspan="2" class="px-5 py-3 text-sm font-bold text-gray-700">Total</td>
                        <td class="px-5 py-3 text-right font-bold text-gray-700">3.250 butir</td>
                        <td class="px-5 py-3"></td>
                        <td class="px-5 py-3 text-right font-bold text-emerald-600">Rp 1.925.000</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Section: Rekap Panen --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                Rekap Panen
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Minggu 2 — Juni 2026</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kebun</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Komoditas</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nilai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">08 Jun 2026</td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Kebun Cikaret</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Kelapa Butiran</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">450 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 6.750.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">09 Jun 2026</td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Kebun Sukamaju</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Kopra</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">120 kg</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 2.880.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">10 Jun 2026</td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Kebun Ciomas</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Kelapa Muda</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">300 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 6.000.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">12 Jun 2026</td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Kebun Cikaret</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Kelapa Butiran</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">380 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 5.700.000</td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">14 Jun 2026</td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">Kebun Sukamaju</td>
                        <td class="px-5 py-3.5"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">Kopra</span></td>
                        <td class="px-5 py-3.5 text-right text-gray-700">150 kg</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800">Rp 3.600.000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50/80 border-t-2 border-gray-200">
                        <td colspan="3" class="px-5 py-3 text-sm font-bold text-gray-700">Total</td>
                        <td class="px-5 py-3 text-right font-bold text-gray-700">1.800 unit</td>
                        <td class="px-5 py-3 text-right font-bold text-emerald-600">Rp 24.930.000</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Section: Foto Bukti Kerja --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Foto Bukti Kerja
            </h3>
            <p class="text-xs text-gray-400 mt-0.5">Dokumentasi kegiatan minggu ini</p>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Photo 1 --}}
                <div class="group relative bg-gray-100 rounded-xl aspect-[4/3] flex flex-col items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border-2 border-dashed border-gray-200 hover:border-gray-300">
                    <svg class="w-10 h-10 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs text-gray-400 mt-2 font-medium">08 Jun 2026</span>
                    <span class="text-[10px] text-gray-400">Proses kupas Kebun Cikaret</span>
                </div>
                {{-- Photo 2 --}}
                <div class="group relative bg-gray-100 rounded-xl aspect-[4/3] flex flex-col items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border-2 border-dashed border-gray-200 hover:border-gray-300">
                    <svg class="w-10 h-10 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs text-gray-400 mt-2 font-medium">09 Jun 2026</span>
                    <span class="text-[10px] text-gray-400">Panen kopra Sukamaju</span>
                </div>
                {{-- Photo 3 --}}
                <div class="group relative bg-gray-100 rounded-xl aspect-[4/3] flex flex-col items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border-2 border-dashed border-gray-200 hover:border-gray-300">
                    <svg class="w-10 h-10 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs text-gray-400 mt-2 font-medium">10 Jun 2026</span>
                    <span class="text-[10px] text-gray-400">Perawatan Kebun Ciomas</span>
                </div>
                {{-- Photo 4 --}}
                <div class="group relative bg-gray-100 rounded-xl aspect-[4/3] flex flex-col items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border-2 border-dashed border-gray-200 hover:border-gray-300">
                    <svg class="w-10 h-10 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs text-gray-400 mt-2 font-medium">11 Jun 2026</span>
                    <span class="text-[10px] text-gray-400">Penyemprotan hama</span>
                </div>
                {{-- Photo 5 --}}
                <div class="group relative bg-gray-100 rounded-xl aspect-[4/3] flex flex-col items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border-2 border-dashed border-gray-200 hover:border-gray-300">
                    <svg class="w-10 h-10 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs text-gray-400 mt-2 font-medium">12 Jun 2026</span>
                    <span class="text-[10px] text-gray-400">Pengangkutan kelapa</span>
                </div>
                {{-- Photo 6 --}}
                <div class="group relative bg-gray-100 rounded-xl aspect-[4/3] flex flex-col items-center justify-center cursor-pointer hover:bg-gray-200 transition-colors border-2 border-dashed border-gray-200 hover:border-gray-300">
                    <svg class="w-10 h-10 text-gray-300 group-hover:text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-xs text-gray-400 mt-2 font-medium">14 Jun 2026</span>
                    <span class="text-[10px] text-gray-400">Penjemuran kopra</span>
                </div>
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
