@extends('layouts.app')

@section('title', 'Gaji Bulanan')
@section('page-title', 'Gaji Bulanan')
@section('page-subtitle', 'Penggajian karyawan tetap')

@section('content')
<div class="space-y-6">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex flex-wrap items-end gap-4">
            <div class="min-w-[160px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
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
            <div class="min-w-[120px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option>2024</option>
                    <option>2025</option>
                    <option selected>2026</option>
                </select>
            </div>
            <div class="min-w-[180px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kebun</label>
                <select class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">Semua Kebun</option>
                    <option>Kebun Sawit Sejahtera</option>
                    <option>Kebun Kelapa Makmur</option>
                    <option>Kebun Karet Jaya</option>
                </select>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Generate Gaji
                </button>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        {{-- Total Karyawan --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Karyawan</p>
                    <p class="text-2xl font-bold text-gray-900">8 <span class="text-base font-normal text-gray-500">orang</span></p>
                </div>
            </div>
        </div>
        {{-- Total Gaji --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Gaji</p>
                    <p class="text-2xl font-bold text-gray-900">Rp 28.000.000</p>
                </div>
            </div>
        </div>
        {{-- Sudah Dibayar --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Sudah Dibayar</p>
                    <p class="text-2xl font-bold text-gray-900">5 <span class="text-base font-normal text-gray-500">orang</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- Payroll Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Gaji Karyawan — Juni 2026</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center w-12">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Kebun</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Hadir</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Izin</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Sakit</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Alpha</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Gaji Pokok</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Tunjangan</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Potongan</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Total</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Status</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Row 1 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">1</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Budi Santoso</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Sawit Sejahtera</td>
                        <td class="px-4 py-3 text-center text-gray-700">24</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 3.000.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 500.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 150.000</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 3.350.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Dibayar</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                    {{-- Row 2 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">2</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Siti Aminah</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Kelapa Makmur</td>
                        <td class="px-4 py-3 text-center text-gray-700">26</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 3.500.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 600.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 0</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 4.100.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Dibayar</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                    {{-- Row 3 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">3</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Agus Prabowo</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Sawit Sejahtera</td>
                        <td class="px-4 py-3 text-center text-gray-700">22</td>
                        <td class="px-4 py-3 text-center text-gray-700">2</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 3.000.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 400.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 200.000</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 3.200.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Dibayar</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                    {{-- Row 4 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">4</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Dewi Lestari</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Karet Jaya</td>
                        <td class="px-4 py-3 text-center text-gray-700">25</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 3.200.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 500.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 100.000</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 3.600.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Bayar
                                </button>
                                <a href="#" class="text-emerald-600 hover:text-emerald-800 text-xs font-medium hover:underline">Detail</a>
                            </div>
                        </td>
                    </tr>
                    {{-- Row 5 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">5</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Hendra Wijaya</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Kelapa Makmur</td>
                        <td class="px-4 py-3 text-center text-gray-700">23</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-center text-gray-700">2</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 3.000.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 500.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 250.000</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 3.250.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Dibayar</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                    {{-- Row 6 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">6</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Ratna Sari</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Sawit Sejahtera</td>
                        <td class="px-4 py-3 text-center text-gray-700">26</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 3.500.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 500.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 0</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 4.000.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Bayar
                                </button>
                                <a href="#" class="text-emerald-600 hover:text-emerald-800 text-xs font-medium hover:underline">Detail</a>
                            </div>
                        </td>
                    </tr>
                    {{-- Row 7 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">7</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Eko Prasetyo</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Karet Jaya</td>
                        <td class="px-4 py-3 text-center text-gray-700">24</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-center text-gray-700">0</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 3.000.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 400.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 100.000</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 3.300.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Dibayar</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                    {{-- Row 8 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">8</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Joko Susilo</td>
                        <td class="px-4 py-3 text-gray-600">Kebun Kelapa Makmur</td>
                        <td class="px-4 py-3 text-center text-gray-700">20</td>
                        <td class="px-4 py-3 text-center text-gray-700">2</td>
                        <td class="px-4 py-3 text-center text-gray-700">1</td>
                        <td class="px-4 py-3 text-center text-gray-700">3</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 2.800.000</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 400.000</td>
                        <td class="px-4 py-3 text-right text-red-600">Rp 400.000</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 3.200.000</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-medium rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Bayar
                                </button>
                                <a href="#" class="text-emerald-600 hover:text-emerald-800 text-xs font-medium hover:underline">Detail</a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Bottom Actions --}}
    <div class="flex flex-wrap items-center justify-between gap-4">
        <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Bayar Semua Pending (3)
        </button>
        <div class="flex items-center gap-3">
            <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Word
            </button>
            <button class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Export PDF
            </button>
        </div>
    </div>

</div>
@endsection
