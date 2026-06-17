@extends('layouts.app')

@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')
@section('page-subtitle', 'Tambah data karyawan baru')

@section('page-actions')
    <a href="#"
       class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl transition shadow-sm border border-gray-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3"/>
        </svg>
        Kembali
    </a>
@endsection

@section('content')
    <div class="max-w-4xl" x-data="{ tipe: '' }">
        <form action="#" method="POST">
            @csrf
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                {{-- Form Header --}}
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-800">Informasi Karyawan</h3>
                    <p class="mt-1 text-sm text-gray-500">Lengkapi data karyawan yang akan ditambahkan ke sistem.</p>
                </div>

                {{-- Form Fields --}}
                <div class="p-6 space-y-6">
                    {{-- Row 1: Nama & No HP --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama" placeholder="Contoh: Ahmad Sudirman"
                                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"
                                   required/>
                        </div>
                        <div>
                            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-1.5">
                                No HP <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="no_hp" name="no_hp" placeholder="Contoh: 0812-3456-7890"
                                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"
                                   required/>
                        </div>
                    </div>

                    {{-- Row 2: Tipe & Kebun --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tipe" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Tipe Karyawan <span class="text-red-500">*</span>
                            </label>
                            <select id="tipe" name="tipe" x-model="tipe"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition bg-white"
                                    required>
                                <option value="">Pilih Tipe</option>
                                <option value="tetap">Tetap</option>
                                <option value="harian">Harian</option>
                                <option value="borongan">Borongan</option>
                            </select>
                        </div>
                        <div>
                            <label for="kebun" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Kebun <span class="text-red-500">*</span>
                            </label>
                            <select id="kebun" name="kebun_id"
                                    class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition bg-white"
                                    required>
                                <option value="">Pilih Kebun</option>
                                <option value="1">Kebun Raya Utama</option>
                                <option value="2">Kebun Pantai Selatan</option>
                                <option value="3">Kebun Bukit Indah</option>
                                <option value="4">Kebun Sungai Baru</option>
                            </select>
                        </div>
                    </div>

                    {{-- Conditional: Gaji Pokok (Tetap) --}}
                    <div x-show="tipe === 'tetap'" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="gaji_pokok" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Gaji Pokok <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-gray-400">Rp</span>
                                <input type="text" id="gaji_pokok" name="gaji_pokok" placeholder="2.500.000"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"/>
                            </div>
                            <p class="mt-1.5 text-xs text-gray-400">Gaji pokok bulanan untuk karyawan tetap</p>
                        </div>
                    </div>

                    {{-- Conditional: Upah Per Hari (Harian) --}}
                    <div x-show="tipe === 'harian'" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="upah_harian" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Upah Per Hari <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-sm text-gray-400">Rp</span>
                                <input type="text" id="upah_harian" name="upah_harian" placeholder="120.000"
                                       class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"/>
                            </div>
                            <p class="mt-1.5 text-xs text-gray-400">Upah yang diterima per hari kerja</p>
                        </div>
                    </div>

                    {{-- Conditional: Info Borongan --}}
                    <div x-show="tipe === 'borongan'" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="flex items-start gap-3 p-4 bg-purple-50 border border-purple-100 rounded-xl">
                            <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-purple-800">Karyawan Borongan</p>
                                <p class="text-sm text-purple-600 mt-0.5">Upah akan dihitung berdasarkan tarif kupas yang berlaku dan jumlah hasil kerja.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Tanggal Masuk --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Tanggal Masuk <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                                   class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:border-emerald-500 transition"
                                   required/>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 rounded-b-xl flex items-center justify-end gap-3">
                    <a href="#"
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition shadow-sm inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
