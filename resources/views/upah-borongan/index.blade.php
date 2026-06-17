@extends('layouts.app')

@section('title', 'Upah Borongan')
@section('page-title', 'Upah Borongan — Kupas Kelapa')
@section('page-subtitle', 'Pencatatan upah per satuan hasil kupas dan upload foto')

@section('content')
<!-- Tabs -->
<div class="flex space-x-1 bg-gray-200/50 p-1 rounded-xl mb-6 w-max">
    <a href="#" class="px-4 py-2 text-sm font-bold rounded-lg bg-white shadow-sm text-emerald-700">Input Harian</a>
    <a href="#" class="px-4 py-2 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-800 hover:bg-white/50">Rekap Mingguan</a>
    <a href="#" class="px-4 py-2 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-800 hover:bg-white/50">Rekap Bulanan</a>
</div>

<!-- Date & Filter Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
    <div class="flex flex-col md:flex-row gap-4 items-end">
        <div class="flex-1 w-full">
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal</label>
            <input type="date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
        </div>
        <div class="flex-1 w-full">
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kebun</label>
            <select class="w-full px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all appearance-none">
                <option>Kebun Raya Utama</option>
            </select>
        </div>
    </div>
</div>

<!-- Input Upah Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-emerald-50/50">
        <h3 class="text-lg font-bold text-gray-800">Form Hasil Kupas Harian</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-4">Nama Pekerja</th>
                    <th class="px-6 py-4">Jenis Kupas</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Tarif (Rp)</th>
                    <th class="px-6 py-4 text-right">Total Upah</th>
                    <th class="px-6 py-4 text-center">Foto Bukti (WA)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-800">Ahmad Sutoyo</td>
                    <td class="px-6 py-4">
                        <select class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none">
                            <option>Kupas Sabut Kelapa</option>
                            <option>Kupas Batok Kelapa</option>
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <input type="number" value="500" class="px-3 py-1.5 border border-gray-200 rounded-l-lg text-sm w-24 text-right">
                            <span class="px-3 py-1.5 bg-gray-100 border border-l-0 border-gray-200 rounded-r-lg text-sm text-gray-500">butir</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><input type="text" value="200" readonly class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm w-20 text-gray-500"></td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600 text-base">Rp 100.000</td>
                    <td class="px-6 py-4 text-center">
                        <label class="cursor-pointer inline-flex items-center justify-center w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors" title="Upload Foto dari WA">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input type="file" class="hidden" accept="image/*">
                        </label>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-800">Dedi Kusuma</td>
                    <td class="px-6 py-4">
                        <select class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none">
                            <option>Kupas Sabut Kelapa</option>
                            <option>Kupas Batok Kelapa</option>
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <input type="number" value="420" class="px-3 py-1.5 border border-gray-200 rounded-l-lg text-sm w-24 text-right">
                            <span class="px-3 py-1.5 bg-gray-100 border border-l-0 border-gray-200 rounded-r-lg text-sm text-gray-500">butir</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><input type="text" value="200" readonly class="px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg text-sm w-20 text-gray-500"></td>
                    <td class="px-6 py-4 text-right font-bold text-emerald-600 text-base">Rp 84.000</td>
                    <td class="px-6 py-4 text-center">
                        <label class="cursor-pointer inline-flex items-center justify-center w-10 h-10 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500 text-[8px] text-white flex items-center justify-center">1</span>
                            </span>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Submit -->
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
        <button class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition shadow-sm shadow-emerald-500/30">
            Simpan Hasil & Hitung Upah
        </button>
    </div>
</div>
@endsection
