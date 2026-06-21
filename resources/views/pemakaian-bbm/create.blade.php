@extends('layouts.app')
@section('page-title', 'Buat Laporan Pemakaian BBM')

@section('content')
<div class="w-full pb-10">
    <div class="mb-8">
        <a href="{{ route('pemakaian-bbm.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Buat Laporan Pemakaian BBM</h2>
    </div>

    <form action="{{ route('pemakaian-bbm.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden transition-colors duration-300" id="form-pemakaian">
        @csrf
        
        <div class="p-6 md:p-8 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Laporan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kategori Laporan <span class="text-red-500">*</span></label>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <label class="flex-1 flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-xl hover:bg-emerald-50 hover:border-emerald-200 transition-colors">
                            <input type="radio" name="kategori" value="Kebun" required class="text-emerald-600 focus:ring-emerald-500 w-5 h-5">
                            <span class="font-bold text-gray-700">BBM Kebun</span>
                        </label>
                        <label class="flex-1 flex items-center gap-3 cursor-pointer p-4 border border-gray-200 rounded-xl hover:bg-blue-50 hover:border-blue-200 transition-colors">
                            <input type="radio" name="kategori" value="Sopir" required class="text-blue-600 focus:ring-blue-500 w-5 h-5">
                            <span class="font-bold text-gray-700">BBM Sopir</span>
                        </label>
                    </div>
                </div>

                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 hidden" id="dynamic-form-fields">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Lokasi Kebun <span class="text-red-500">*</span></label>
                        <select name="kebun_id" required class="searchable-select w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all bg-white">
                            <option value="" disabled selected>-- Pilih Lokasi --</option>
                            @foreach($kebun as $k)
                                <option value="{{ $k->id }}">{{ $k->lokasi }}</option>
                            @endforeach
                        </select>
                    </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengambil (Karyawan) <span class="text-red-500">*</span></label>
                    <select name="karyawan_id" required class="searchable-select w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all bg-white">
                        <option value="" disabled selected>-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Laporan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Laporan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_laporan" placeholder="Contoh: Laporan BBM Pick Up & Genset (Minggu 1)" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Tambahan (Opsional)</label>
                        <textarea name="keterangan" rows="2" placeholder="Tuliskan catatan tambahan di sini..."
                                  class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-gray-50/50 hidden" id="detail-section">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Detail Pemakaian</h3>
                <button type="button" id="btn-add-item" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 hover:text-emerald-600 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Baris
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead>
                        <tr class="bg-gray-100 border-y border-gray-200">
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[50px]">No</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[150px]">Tanggal</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[150px]">Tipe BBM</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider min-w-[200px]">Keterangan Kebutuhan</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[120px]">Liter</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[180px]">Harga Per Liter (Rp)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[200px] text-right">Total Harga (Rp)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[60px] text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="items-container" class="divide-y divide-gray-100 bg-white">
                        <tr class="item-row">
                            <td class="py-3 px-4 text-sm text-gray-500 text-center row-number">1</td>
                            <td class="py-3 px-4">
                                <input type="date" name="tanggal_pemakaian[]" required value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm">
                            </td>
                            <td class="py-3 px-4">
                                <select name="tipe_bbm[]" required class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm tipe-bbm-select">
                                    <option value="Solar">Solar</option>
                                    <option value="Pertalite">Pertalite</option>
                                </select>
                            </td>
                            <td class="py-3 px-4">
                                <input type="text" name="keterangan_pemakaian[]" required placeholder="Cth: Pick Up Grand Max" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" step="0.01" name="jumlah_liter[]" required min="0.01" placeholder="0.00" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-qty">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="harga_per_liter[]" required min="0" placeholder="0" value="16000" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-harga">
                            </td>
                            <td class="py-3 px-4 text-right">
                                <span class="text-sm font-semibold text-gray-800 row-total">0</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <button type="button" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded transition-colors btn-remove-item" title="Hapus Baris" disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 border-t border-gray-200">
                            <td colspan="6" class="py-4 px-4 text-sm font-bold text-gray-800 uppercase text-right tracking-wider">Total</td>
                            <td class="py-4 px-4 text-right">
                                <span class="text-lg font-bold text-emerald-600" id="grand-total">0</span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 bg-white flex justify-end transition-colors duration-300 hidden" id="form-footer">
            <button type="submit" id="btn-submit" class="px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Simpan Laporan
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 0.5rem !important;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #374151 !important;
        line-height: 40px !important;
        padding-left: 1rem !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.25rem !important;
    }
    .select2-container--default .select2-selection--single:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2) !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.searchable-select').select2({
            width: '100%'
        });

        // Dynamic Colors Script
        const radios = document.querySelectorAll('input[name="kategori"]');
        const form = document.getElementById('form-pemakaian');
        const footer = document.getElementById('form-footer');
        const btnSubmit = document.getElementById('btn-submit');
        const detailSection = document.getElementById('detail-section');
        const grandTotal = document.getElementById('grand-total');
        const dynamicFormFields = document.getElementById('dynamic-form-fields');

        radios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                // Show hidden fields when a category is selected
                dynamicFormFields.classList.remove('hidden');
                detailSection.classList.remove('hidden');
                footer.classList.remove('hidden');

                if(e.target.value === 'Kebun') {
                    form.className = "bg-emerald-50 rounded-xl shadow-lg border-2 border-emerald-400 overflow-hidden transition-colors duration-300";
                    footer.className = "p-6 border-t border-emerald-200 bg-emerald-100 flex justify-end transition-colors duration-300";
                    btnSubmit.className = "px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500";
                    detailSection.className = "p-6 md:p-8 bg-emerald-50/50 transition-colors duration-300";
                    grandTotal.className = "text-lg font-bold text-emerald-600";
                } else if(e.target.value === 'Sopir') {
                    form.className = "bg-blue-50 rounded-xl shadow-lg border-2 border-blue-400 overflow-hidden transition-colors duration-300";
                    footer.className = "p-6 border-t border-blue-200 bg-blue-100 flex justify-end transition-colors duration-300";
                    btnSubmit.className = "px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-blue-500";
                    detailSection.className = "p-6 md:p-8 bg-blue-50/50 transition-colors duration-300";
                    grandTotal.className = "text-lg font-bold text-blue-600";
                }
            });
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('items-container');
    const btnAdd = document.getElementById('btn-add-item');
    const grandTotalEl = document.getElementById('grand-total');

    const formatRp = (number) => {
        return new Intl.NumberFormat('id-ID').format(number);
    };

    const calculateTotals = () => {
        let grandTotal = 0;
        const rows = container.querySelectorAll('.item-row');
        
        rows.forEach((row, index) => {
            row.querySelector('.row-number').textContent = index + 1;
            
            const removeBtn = row.querySelector('.btn-remove-item');
            if (rows.length === 1) {
                removeBtn.disabled = true;
                removeBtn.classList.remove('hover:text-red-500', 'hover:bg-red-50');
            } else {
                removeBtn.disabled = false;
                removeBtn.classList.add('hover:text-red-500', 'hover:bg-red-50');
            }

            const qty = parseFloat(row.querySelector('.input-qty').value) || 0;
            const harga = parseFloat(row.querySelector('.input-harga').value) || 0;
            const total = qty * harga;
            
            row.querySelector('.row-total').textContent = formatRp(total);
            grandTotal += total;
        });

        grandTotalEl.textContent = 'Rp ' + formatRp(grandTotal);
    };

    btnAdd.addEventListener('click', () => {
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelector('input[name="tanggal_pemakaian[]"]').value = '{{ date('Y-m-d') }}';
        newRow.querySelector('select[name="tipe_bbm[]"]').value = 'Solar';
        newRow.querySelector('input[name="keterangan_pemakaian[]"]').value = '';
        newRow.querySelector('input[name="jumlah_liter[]"]').value = '';
        newRow.querySelector('input[name="harga_per_liter[]"]').value = '16000';
        newRow.querySelector('.row-total').textContent = '0';
        
        container.appendChild(newRow);
        calculateTotals();
    });

    container.addEventListener('input', (e) => {
        if (e.target.classList.contains('input-qty') || e.target.classList.contains('input-harga')) {
            calculateTotals();
        }
    });

    container.addEventListener('change', (e) => {
        if (e.target.classList.contains('tipe-bbm-select')) {
            const row = e.target.closest('.item-row');
            const hargaInput = row.querySelector('.input-harga');
            if (e.target.value === 'Solar') {
                hargaInput.value = '16000';
            } else if (e.target.value === 'Pertalite') {
                hargaInput.value = '13000';
            }
            calculateTotals();
        }
    });

    container.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-remove-item');
        if (btn && !btn.disabled) {
            btn.closest('.item-row').remove();
            calculateTotals();
        }
    });

    calculateTotals();
});
</script>
@endpush
