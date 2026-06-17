@extends('layouts.app')

@section('title', 'Absensi Harian')
@section('page-title', 'Absensi Harian')
@section('page-subtitle', 'Pencatatan kehadiran karyawan')

@section('content')
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
                <option>Semua Kebun</option>
                <option>Kebun Raya Utama</option>
                <option>Kebun Pantai Selatan</option>
            </select>
        </div>
        <button class="px-6 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition shadow-sm w-full md:w-auto">
            Tampilkan
        </button>
    </div>
</div>

<!-- Input Attendance Card -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-emerald-50/50">
        <h3 class="text-lg font-bold text-gray-800">Form Input Absensi</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-4">Nama Karyawan</th>
                    <th class="px-6 py-4">Tipe</th>
                    <th class="px-6 py-4">Status Kehadiran</th>
                    <th class="px-6 py-4">Jam Masuk</th>
                    <th class="px-6 py-4">Jam Keluar</th>
                    <th class="px-6 py-4">Catatan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-800">Budi Santoso</td>
                    <td class="px-6 py-4"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Tetap</span></td>
                    <td class="px-6 py-4">
                        <select class="px-3 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium focus:outline-none">
                            <option value="hadir" selected>Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </td>
                    <td class="px-6 py-4"><input type="time" value="07:00" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-24"></td>
                    <td class="px-6 py-4"><input type="time" value="16:00" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-24"></td>
                    <td class="px-6 py-4"><input type="text" placeholder="Catatan..." class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-full"></td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-800">Candra Wijaya</td>
                    <td class="px-6 py-4"><span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs">Harian</span></td>
                    <td class="px-6 py-4">
                        <select class="px-3 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium focus:outline-none">
                            <option value="hadir" selected>Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </td>
                    <td class="px-6 py-4"><input type="time" value="07:15" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-24"></td>
                    <td class="px-6 py-4"><input type="time" value="16:00" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-24"></td>
                    <td class="px-6 py-4"><input type="text" placeholder="Catatan..." class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-full"></td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-bold text-gray-800">Dedi Kusuma</td>
                    <td class="px-6 py-4"><span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">Borongan</span></td>
                    <td class="px-6 py-4">
                        <select class="px-3 py-1.5 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg text-sm font-medium focus:outline-none">
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit" selected>Sakit</option>
                            <option value="alpha">Alpha</option>
                        </select>
                    </td>
                    <td class="px-6 py-4"><input type="time" disabled class="px-3 py-1.5 bg-gray-100 border border-gray-200 rounded-lg text-sm w-24 text-gray-400"></td>
                    <td class="px-6 py-4"><input type="time" disabled class="px-3 py-1.5 bg-gray-100 border border-gray-200 rounded-lg text-sm w-24 text-gray-400"></td>
                    <td class="px-6 py-4"><input type="text" value="Surat dokter terlampir" class="px-3 py-1.5 border border-gray-200 rounded-lg text-sm w-full"></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Summary & Submit -->
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex gap-4 text-sm font-medium">
            <span class="text-emerald-600 bg-emerald-100 px-3 py-1 rounded-full">Hadir: 2</span>
            <span class="text-blue-600 bg-blue-100 px-3 py-1 rounded-full">Izin: 0</span>
            <span class="text-yellow-600 bg-yellow-100 px-3 py-1 rounded-full">Sakit: 1</span>
            <span class="text-red-600 bg-red-100 px-3 py-1 rounded-full">Alpha: 0</span>
        </div>
        <button class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition shadow-sm shadow-emerald-500/30 w-full md:w-auto">
            Simpan Absensi
        </button>
    </div>
</div>
@endsection
