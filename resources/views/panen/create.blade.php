@extends('layouts.app')

@section('title', 'Tambah Panen')
@section('page-title', 'Tambah Data Panen')
@section('page-subtitle', 'Input hasil panen baru')

@section('page-actions')
<a href="{{ route('panen.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Kembali
</a>
@endsection

@section('content')
<div x-data="panenForm()" class="max-w-3xl">

    <form class="space-y-6">

        {{-- Main Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-base font-semibold text-gray-800">Informasi Panen</h3>
                <p class="text-sm text-gray-400 mt-0.5">Lengkapi data hasil panen di bawah ini</p>
            </div>

            <div class="p-6 space-y-5">

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <input type="date" value="2026-06-17" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    </div>
                </div>

                {{-- Kebun & Blok - 2 columns --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kebun <span class="text-red-400">*</span></label>
                        <select x-model="kebun" @change="updateBlok()" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition-colors">
                            <option value="">Pilih Kebun</option>
                            <option value="sawit">Kebun Sawit Lestari</option>
                            <option value="kelapa">Kebun Kelapa Makmur</option>
                            <option value="karet">Kebun Karet Sejahtera</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Blok <span class="text-red-400">*</span></label>
                        <select class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition-colors">
                            <option value="">Pilih Blok</option>
                            <template x-for="blok in blokOptions" :key="blok.value">
                                <option :value="blok.value" x-text="blok.label"></option>
                            </template>
                        </select>
                    </div>
                </div>

                {{-- Komoditas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Komoditas <span class="text-red-400">*</span></label>
                    <select x-model="komoditas" @change="updateSatuan()" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition-colors">
                        <option value="">Pilih Komoditas</option>
                        <option value="sawit">Kelapa Sawit</option>
                        <option value="kelapa">Kelapa</option>
                        <option value="karet">Karet</option>
                    </select>
                </div>

                {{-- Jumlah & Harga Satuan - 2 columns --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah <span class="text-red-400">*</span></label>
                        <div class="flex">
                            <input type="number" x-model.number="jumlah" @input="calculateTotal()" placeholder="0" min="0"
                                   class="flex-1 px-4 py-2.5 border border-gray-200 rounded-l-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <span class="inline-flex items-center px-4 py-2.5 bg-gray-100 border border-l-0 border-gray-200 rounded-r-lg text-sm font-medium text-gray-500" x-text="satuan">butir</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Harga Satuan <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-sm font-medium">Rp</span>
                            </div>
                            <input type="number" x-model.number="hargaSatuan" @input="calculateTotal()" placeholder="0" min="0"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        </div>
                    </div>
                </div>

                {{-- Total Nilai (auto-calculated) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Total Nilai</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 text-sm font-medium">Rp</span>
                        </div>
                        <input type="text" :value="totalFormatted" readonly
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm bg-gray-50 text-gray-700 font-semibold cursor-not-allowed">
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Dihitung otomatis dari Jumlah × Harga Satuan</p>
                </div>

                {{-- Catatan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan</label>
                    <textarea rows="3" placeholder="Tambahkan catatan jika diperlukan..." class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors resize-none"></textarea>
                </div>

            </div>
        </div>

        {{-- Photo Upload Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-base font-semibold text-gray-800">Foto Bukti Panen</h3>
                <p class="text-sm text-gray-400 mt-0.5">Upload foto sebagai dokumentasi hasil panen</p>
            </div>

            <div class="p-6 space-y-4">
                {{-- Drop Zone --}}
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition-all cursor-pointer group"
                     @dragover.prevent="isDragging = true" @dragleave="isDragging = false" @drop.prevent="isDragging = false"
                     :class="isDragging ? 'border-emerald-500 bg-emerald-50/50' : 'border-gray-300'">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-emerald-100 transition-colors">
                            <svg class="w-7 h-7 text-gray-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Upload foto dari WhatsApp di sini</p>
                        <p class="text-xs text-gray-400 mb-3">Seret & lepas file, atau klik untuk memilih</p>
                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            Pilih File
                        </button>
                        <p class="text-[11px] text-gray-300 mt-3">JPG, PNG atau WebP. Maksimal 5MB per file.</p>
                    </div>
                    <input type="file" class="hidden" multiple accept="image/*">
                </div>

                {{-- Dummy Thumbnail Previews --}}
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-2.5">File yang sudah dipilih (2)</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        {{-- Thumbnail 1 --}}
                        <div class="relative group rounded-xl overflow-hidden border border-gray-200 aspect-square bg-gradient-to-br from-emerald-100 to-emerald-200">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-emerald-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-[10px] text-emerald-500 mt-1 font-medium">panen_blokA1.jpg</p>
                                </div>
                            </div>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                <button type="button" class="hidden group-hover:flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full shadow-lg hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-2">
                                <p class="text-white text-[10px] truncate">1.2 MB</p>
                            </div>
                        </div>

                        {{-- Thumbnail 2 --}}
                        <div class="relative group rounded-xl overflow-hidden border border-gray-200 aspect-square bg-gradient-to-br from-amber-100 to-amber-200">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-amber-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-[10px] text-amber-500 mt-1 font-medium">hasil_panen_02.jpg</p>
                                </div>
                            </div>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                                <button type="button" class="hidden group-hover:flex items-center justify-center w-8 h-8 bg-red-500 text-white rounded-full shadow-lg hover:bg-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-2">
                                <p class="text-white text-[10px] truncate">2.4 MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('panen.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-8 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Data Panen
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
function panenForm() {
    return {
        kebun: '',
        komoditas: '',
        jumlah: null,
        hargaSatuan: null,
        total: 0,
        satuan: 'butir',
        isDragging: false,
        blokOptions: [],

        get totalFormatted() {
            if (!this.total) return '0';
            return new Intl.NumberFormat('id-ID').format(this.total);
        },

        calculateTotal() {
            this.total = (this.jumlah || 0) * (this.hargaSatuan || 0);
        },

        updateSatuan() {
            const map = { sawit: 'butir', kelapa: 'butir', karet: 'kg' };
            this.satuan = map[this.komoditas] || 'butir';
        },

        updateBlok() {
            const bloks = {
                sawit: [
                    { value: 'a1', label: 'Blok A1' },
                    { value: 'a2', label: 'Blok A2' },
                    { value: 'a3', label: 'Blok A3' },
                ],
                kelapa: [
                    { value: 'b1', label: 'Blok B1' },
                    { value: 'b2', label: 'Blok B2' },
                ],
                karet: [
                    { value: 'c1', label: 'Blok C1' },
                    { value: 'c2', label: 'Blok C2' },
                ],
            };
            this.blokOptions = bloks[this.kebun] || [];
        },
    }
}
</script>
@endpush
