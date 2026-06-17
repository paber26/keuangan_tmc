@extends('layouts.app')

@section('title', 'Data Panen')
@section('page-title', 'Pencatatan Panen')
@section('page-subtitle', 'Data hasil panen per kebun')

@section('page-actions')
<a href="{{ route('panen.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-600/20">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Tambah Panen
</a>
@endsection

@section('content')
<div class="space-y-6">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex flex-col lg:flex-row items-start lg:items-end gap-4">
            <div class="flex-1 min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Dari Tanggal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <input type="date" value="2026-06-01" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Sampai Tanggal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <input type="date" value="2026-06-17" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Kebun</label>
                <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition-colors">
                    <option value="">Semua Kebun</option>
                    <option value="1">Kebun Sawit Lestari</option>
                    <option value="2">Kebun Kelapa Makmur</option>
                    <option value="3">Kebun Karet Sejahtera</option>
                </select>
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Komoditas</label>
                <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition-colors">
                    <option value="">Semua Komoditas</option>
                    <option value="1">Kelapa Sawit</option>
                    <option value="2">Kelapa</option>
                    <option value="3">Karet</option>
                </select>
            </div>
            <button class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm shadow-emerald-600/20 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
        </div>
    </div>

    {{-- 3 Mini Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        {{-- Total Panen --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium">Total Panen</p>
                    <p class="text-2xl font-bold text-gray-800">12.500 <span class="text-sm font-medium text-gray-400">butir</span></p>
                </div>
            </div>
        </div>
        {{-- Total Nilai --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium">Total Nilai</p>
                    <p class="text-2xl font-bold text-gray-800">Rp 25.000.000</p>
                </div>
            </div>
        </div>
        {{-- Rata-rata / Hari --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-400 font-medium">Rata-rata/Hari</p>
                    <p class="text-2xl font-bold text-gray-800">420 <span class="text-sm font-medium text-gray-400">butir</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800">Riwayat Panen</h3>
                <span class="text-sm text-gray-400">Menampilkan 8 dari 42 data</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Kebun</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Blok</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600 text-xs uppercase tracking-wider">Komoditas</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600 text-xs uppercase tracking-wider">Jumlah</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600 text-xs uppercase tracking-wider">Harga Satuan</th>
                        <th class="px-4 py-3 text-right font-semibold text-gray-600 text-xs uppercase tracking-wider">Total Nilai</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600 text-xs uppercase tracking-wider">Foto</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Row 1 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">17 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Sawit Lestari</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded-md font-medium">Blok A1</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Kelapa Sawit</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">2.350 butir</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 2.000</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 4.700.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                3
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 2 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">16 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Sawit Lestari</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded-md font-medium">Blok A2</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Kelapa Sawit</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">1.800 butir</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 2.000</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 3.600.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                2
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 3 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">15 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Kelapa Makmur</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-sky-50 text-sky-700 px-2 py-1 rounded-md font-medium">Blok B1</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Kelapa</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">950 butir</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 3.500</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 3.325.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 text-gray-400 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                0
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 4 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">14 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Sawit Lestari</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded-md font-medium">Blok A3</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Kelapa Sawit</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">2.100 butir</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 2.000</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 4.200.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                1
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 5 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">13 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Karet Sejahtera</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-amber-50 text-amber-700 px-2 py-1 rounded-md font-medium">Blok C1</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Karet</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">450 kg</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 8.000</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 3.600.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                2
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 6 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">12 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Kelapa Makmur</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-sky-50 text-sky-700 px-2 py-1 rounded-md font-medium">Blok B2</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Kelapa</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">1.200 butir</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 3.500</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 4.200.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                4
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 7 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">11 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Sawit Lestari</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded-md font-medium">Blok A1</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Kelapa Sawit</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">1.950 butir</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 2.000</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 3.900.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-100 text-gray-400 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                0
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Row 8 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3.5 text-gray-700 font-medium">10 Jun 2026</td>
                        <td class="px-4 py-3.5 text-gray-700">Kebun Sawit Lestari</td>
                        <td class="px-4 py-3.5"><span class="text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded-md font-medium">Blok A2</span></td>
                        <td class="px-4 py-3.5 text-gray-700">Kelapa Sawit</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-gray-800">1.700 butir</td>
                        <td class="px-4 py-3.5 text-right text-gray-600">Rp 2.000</td>
                        <td class="px-4 py-3.5 text-right font-semibold text-emerald-600">Rp 3.400.000</td>
                        <td class="px-4 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-xs font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                1
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            <div class="flex items-center justify-center gap-1">
                                <button class="p-1.5 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-700">1</span> sampai <span class="font-medium text-gray-700">8</span> dari <span class="font-medium text-gray-700">42</span> data</p>
                <nav class="flex items-center gap-1">
                    <button class="px-3 py-1.5 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed" disabled>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button class="px-3 py-1.5 text-sm font-medium text-white bg-emerald-600 rounded-lg shadow-sm">1</button>
                    <button class="px-3 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">2</button>
                    <button class="px-3 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">3</button>
                    <button class="px-3 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">4</button>
                    <span class="px-2 text-gray-400">...</span>
                    <button class="px-3 py-1.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">6</button>
                    <button class="px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </nav>
            </div>
        </div>
    </div>

</div>
@endsection
