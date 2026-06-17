@extends('layouts.app')

@section('title', 'Buku Kas')
@section('page-title', 'Buku Kas')
@section('page-subtitle', 'Catatan transaksi keuangan')

@section('page-actions')
    <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/20 transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Transaksi
    </button>
@endsection

@section('content')
<div x-data="{ showModal: false }">

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kebun</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option>Semua Kebun</option>
                    <option>Kebun Cikaret</option>
                    <option>Kebun Sukamaju</option>
                    <option>Kebun Ciomas</option>
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
            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kategori</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option selected>Semua</option>
                    <option>Penjualan</option>
                    <option>Gaji</option>
                    <option>Upah Harian</option>
                    <option>Upah Borongan</option>
                    <option>Operasional</option>
                </select>
            </div>
            <button class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        {{-- Total Masuk --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Masuk</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">Rp 45.800.000</p>
                    <p class="text-xs text-gray-400 mt-1">8 transaksi pemasukan</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                </div>
            </div>
        </div>

        {{-- Total Keluar --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Keluar</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">Rp 28.350.000</p>
                    <p class="text-xs text-gray-400 mt-1">7 transaksi pengeluaran</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                </div>
            </div>
        </div>

        {{-- Saldo --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Saldo</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">Rp 17.450.000</p>
                    <p class="text-xs text-gray-400 mt-1">Per 30 Juni 2026</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Daftar Transaksi</h3>
                <p class="text-xs text-gray-400 mt-0.5">Juni 2026 — Semua Kebun</p>
            </div>
            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full font-medium">15 transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Masuk</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keluar</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Saldo Berjalan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    {{-- Row 1 - Pemasukan --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">01 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Penjualan Panen</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Penjualan kelapa Kebun Cikaret — 500 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp 7.500.000</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 7.500.000</td>
                    </tr>
                    {{-- Row 2 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">02 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700">Upah Harian</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Upah harian 5 pekerja — perawatan kebun</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 750.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 6.750.000</td>
                    </tr>
                    {{-- Row 3 - Pemasukan --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">03 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Penjualan Panen</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Penjualan kopra Kebun Sukamaju — 200 kg</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp 4.800.000</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 11.550.000</td>
                    </tr>
                    {{-- Row 4 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">04 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700">Upah Borongan</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Upah kupas kelapa — Siti Aminah dkk (350 butir)</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 1.050.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 10.500.000</td>
                    </tr>
                    {{-- Row 5 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">05 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Operasional</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Pembelian pupuk NPK — 10 karung</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 2.500.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 8.000.000</td>
                    </tr>
                    {{-- Row 6 - Pemasukan --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">07 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Penjualan Panen</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Penjualan kelapa muda Kebun Ciomas — 300 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp 6.000.000</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 14.000.000</td>
                    </tr>
                    {{-- Row 7 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">08 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-50 text-orange-700">Upah Harian</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Upah harian 4 pekerja — penyemprotan hama</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 600.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 13.400.000</td>
                    </tr>
                    {{-- Row 8 - Pemasukan --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">10 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Penjualan Panen</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Penjualan kelapa Kebun Cikaret — 400 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp 6.000.000</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 19.400.000</td>
                    </tr>
                    {{-- Row 9 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">12 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">Operasional</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Pembelian alat semprot dan tali rafia</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 850.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 18.550.000</td>
                    </tr>
                    {{-- Row 10 - Pemasukan --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">14 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Penjualan Panen</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Penjualan kopra Kebun Sukamaju — 150 kg</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp 3.600.000</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 22.150.000</td>
                    </tr>
                    {{-- Row 11 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">15 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Gaji Bulanan</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Gaji tetap bulan Juni — Ahmad Hidayat (Mandor)</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 3.500.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 18.650.000</td>
                    </tr>
                    {{-- Row 12 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">15 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Gaji Bulanan</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Gaji tetap bulan Juni — Budi Santoso (Mandor)</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 3.200.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 15.450.000</td>
                    </tr>
                    {{-- Row 13 - Pemasukan --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">18 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Penjualan Panen</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Penjualan kelapa Kebun Ciomas — 600 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp 9.000.000</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 24.450.000</td>
                    </tr>
                    {{-- Row 14 - Pengeluaran --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">20 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700">Upah Borongan</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Upah kupas kelapa — Rohman dkk (450 butir)</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp 1.350.000</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 23.100.000</td>
                    </tr>
                    {{-- Row 15 - Pemasukan --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">22 Jun 2026</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Penjualan Panen</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">Penjualan kelapa muda Kebun Cikaret — 580 butir</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp 8.900.000</td>
                        <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        <td class="px-5 py-3.5 text-right font-semibold text-gray-800 whitespace-nowrap">Rp 32.000.000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-gray-50/80 border-t-2 border-gray-200">
                        <td colspan="3" class="px-5 py-3.5 text-sm font-bold text-gray-700">TOTAL</td>
                        <td class="px-5 py-3.5 text-right font-bold text-emerald-600 whitespace-nowrap">+ Rp 45.800.000</td>
                        <td class="px-5 py-3.5 text-right font-bold text-red-500 whitespace-nowrap">- Rp 28.350.000</td>
                        <td class="px-5 py-3.5 text-right font-bold text-blue-600 whitespace-nowrap">Rp 17.450.000</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-400">Menampilkan 1-15 dari 42 transaksi</p>
            <div class="flex items-center gap-1">
                <button class="px-3 py-1.5 text-xs font-medium text-gray-400 bg-gray-50 rounded-lg cursor-not-allowed" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button class="px-3 py-1.5 text-xs font-semibold text-white bg-emerald-600 rounded-lg">1</button>
                <button class="px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">2</button>
                <button class="px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">3</button>
                <button class="px-3 py-1.5 text-xs font-medium text-gray-400 rounded-lg">...</button>
                <button class="px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Export Buttons --}}
    <div class="flex items-center justify-end gap-3 mt-6">
        <button class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Word
        </button>
        <button class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export PDF
        </button>
    </div>

    {{-- Add Transaction Modal --}}
    <div id="modalTambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="document.getElementById('modalTambah').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 z-10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-800">Tambah Transaksi Operasional</h3>
                <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal</label>
                    <input type="date" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                    <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                        <option>Pengeluaran</option>
                        <option>Pemasukan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kebun</label>
                    <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                        <option>Kebun Cikaret</option>
                        <option>Kebun Sukamaju</option>
                        <option>Kebun Ciomas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah (Rp)</label>
                    <input type="text" placeholder="0" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea rows="3" placeholder="Deskripsi transaksi..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 resize-none"></textarea>
                </div>
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-200">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
