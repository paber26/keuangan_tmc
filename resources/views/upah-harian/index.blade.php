@extends('layouts.app')

@section('title', 'Upah Harian')
@section('page-title', 'Upah Harian')
@section('page-subtitle', 'Pencatatan upah pekerja harian')

@section('content')
<div class="space-y-6">

    {{-- Tab Navigation --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 inline-flex gap-1">
        <button class="px-5 py-2 text-sm font-semibold rounded-lg bg-emerald-600 text-white shadow-sm transition-colors">
            Input Harian
        </button>
        <button class="px-5 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors">
            Rekap Mingguan
        </button>
        <button class="px-5 py-2 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-colors">
            Rekap Bulanan
        </button>
    </div>

    {{-- Input Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <div class="flex flex-wrap items-end gap-4">
                <div class="min-w-[180px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" value="2026-06-17" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kebun</label>
                    <select class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Semua Kebun</option>
                        <option selected>Kebun Kelapa Makmur</option>
                        <option>Kebun Sawit Sejahtera</option>
                        <option>Kebun Karet Jaya</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center w-12">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right w-36">Upah/Hari</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 w-64">Pekerjaan</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center w-36">Upload Foto</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center w-28">Sudah Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Row 1 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">1</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Tarjo</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 100.000</td>
                        <td class="px-4 py-3">
                            <input type="text" value="Pembersihan lahan blok A" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Jenis pekerjaan...">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-lg cursor-pointer transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Foto
                                <input type="file" class="hidden" accept="image/*">
                            </label>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </td>
                    </tr>
                    {{-- Row 2 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">2</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Maman</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 100.000</td>
                        <td class="px-4 py-3">
                            <input type="text" value="Penyemprotan pestisida blok B" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Jenis pekerjaan...">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-lg cursor-pointer transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Foto
                                <input type="file" class="hidden" accept="image/*">
                            </label>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </td>
                    </tr>
                    {{-- Row 3 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">3</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Suparman</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 120.000</td>
                        <td class="px-4 py-3">
                            <input type="text" value="Pemupukan blok C" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Jenis pekerjaan...">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-medium rounded-lg cursor-pointer transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                foto_001.jpg
                                <input type="file" class="hidden" accept="image/*">
                            </label>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </td>
                    </tr>
                    {{-- Row 4 --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-center text-gray-500">4</td>
                        <td class="px-4 py-3 font-medium text-gray-900">Karno</td>
                        <td class="px-4 py-3 text-right text-gray-700">Rp 100.000</td>
                        <td class="px-4 py-3">
                            <input type="text" value="Perbaikan saluran air" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Jenis pekerjaan...">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-medium rounded-lg cursor-pointer transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Pilih Foto
                                <input type="file" class="hidden" accept="image/*">
                            </label>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
            <button class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan
            </button>
        </div>
    </div>

    {{-- Rekap Minggu Ini --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Rekap Minggu Ini</h3>
            <p class="text-sm text-gray-500 mt-0.5">Periode: 15 Juni — 20 Juni 2026</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Sen</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Sel</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Rab</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Kam</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Jum</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Sab</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-center">Total Hari</th>
                        <th class="px-4 py-3 font-semibold text-gray-600 text-right">Total Upah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Tarjo --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900">Tarjo</td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-gray-300">—</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center font-semibold text-gray-900">5</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 500.000</td>
                    </tr>
                    {{-- Maman --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900">Maman</td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center font-semibold text-gray-900">6</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 600.000</td>
                    </tr>
                    {{-- Suparman --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900">Suparman</td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-gray-300">—</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-gray-300">—</span></td>
                        <td class="px-4 py-3 text-center font-semibold text-gray-900">4</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 480.000</td>
                    </tr>
                    {{-- Karno --}}
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 font-medium text-gray-900">Karno</td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-gray-300">—</span></td>
                        <td class="px-4 py-3 text-center"><span class="text-emerald-600">✓</span></td>
                        <td class="px-4 py-3 text-center font-semibold text-gray-900">5</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">Rp 500.000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr class="bg-emerald-50/50 border-t-2 border-emerald-200">
                        <td class="px-4 py-3 font-bold text-gray-900" colspan="7">Grand Total</td>
                        <td class="px-4 py-3 text-center font-bold text-gray-900">20</td>
                        <td class="px-4 py-3 text-right font-bold text-emerald-700 text-base">Rp 2.080.000</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Export Buttons --}}
    <div class="flex items-center justify-end gap-3">
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
@endsection
