@extends('layouts.app')
@section('page-title', 'Edit Pengajuan BBM')

@section('content')
<div class="w-full pb-10">
    <div class="mb-8">
        <a href="{{ route('pengajuan-bbm.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Pengajuan BBM</h2>
    </div>

    <form action="{{ route('pengajuan-bbm.update', $pengajuan_bbm->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="form-pengajuan">
        @csrf
        @method('PUT')
        
        <div class="p-6 md:p-8 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Pengajuan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Lokasi Kebun <span class="text-red-500">*</span></label>
                    <select name="kebun_id" required class="searchable-select w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all bg-white">
                        <option value="" disabled>-- Pilih Lokasi --</option>
                        @foreach($kebun as $k)
                            <option value="{{ $k->id }}" {{ $pengajuan_bbm->kebun_id == $k->id ? 'selected' : '' }}>{{ $k->lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemohon (Karyawan) <span class="text-red-500">*</span></label>
                    <select name="karyawan_id" required class="searchable-select w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all bg-white">
                        <option value="" disabled>-- Pilih Karyawan --</option>
                        @foreach($karyawan as $k)
                            <option value="{{ $k->id }}" {{ $pengajuan_bbm->karyawan_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ $pengajuan_bbm->tanggal }}" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengajuan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_pengajuan" value="{{ $pengajuan_bbm->judul_pengajuan }}" placeholder="Contoh: Pengajuan Operasional Basecamp" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Tambahan (Opsional)</label>
                    <textarea name="keterangan" rows="2" placeholder="Tuliskan catatan tambahan di sini..."
                              class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">{{ $pengajuan_bbm->keterangan }}</textarea>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-gray-50/50">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Detail Kebutuhan BBM</h3>
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
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[200px] text-right">Total Biaya (Rp)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[60px] text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="items-container" class="divide-y divide-gray-100 bg-white">
                        @foreach($pengajuan_bbm->items as $index => $item)
                        <tr class="item-row">
                            <td class="py-3 px-4 text-sm text-gray-500 text-center row-number">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                <input type="date" name="tanggal_pengajuan[]" required value="{{ $item->tanggal }}" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm">
                            </td>
                            <td class="py-3 px-4">
                                <select name="tipe_bbm[]" required class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm">
                                    <option value="Solar" {{ $item->tipe_bbm == 'Solar' ? 'selected' : '' }}>Solar</option>
                                    <option value="Pertalite" {{ $item->tipe_bbm == 'Pertalite' ? 'selected' : '' }}>Pertalite</option>
                                </select>
                            </td>
                            <td class="py-3 px-4">
                                <input type="text" name="keterangan_pengajuan[]" value="{{ $item->keterangan_pengajuan }}" required placeholder="Cth: Solar Genset" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" step="0.01" name="jumlah_liter[]" value="{{ $item->jumlah_liter }}" required min="0.01" placeholder="0.00" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-qty">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="harga_per_liter[]" value="{{ round($item->harga_per_liter) }}" required min="0" placeholder="0" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-harga">
                            </td>
                            <td class="py-3 px-4 text-right">
                                <span class="text-sm font-semibold text-gray-800 row-total">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <button type="button" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded transition-colors btn-remove-item" title="Hapus Baris" {{ count($pengajuan_bbm->items) == 1 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
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

        <div class="p-6 border-t border-gray-100 bg-white flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Perbarui Pengajuan
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
        
        newRow.querySelector('input[name="tanggal_pengajuan[]"]').value = '{{ date('Y-m-d') }}';
        newRow.querySelector('select[name="tipe_bbm[]"]').value = 'Solar';
        newRow.querySelector('input[name="keterangan_pengajuan[]"]').value = '';
        newRow.querySelector('input[name="jumlah_liter[]"]').value = '';
        newRow.querySelector('input[name="harga_per_liter[]"]').value = '';
        newRow.querySelector('.row-total').textContent = '0';
        
        container.appendChild(newRow);
        calculateTotals();
    });

    container.addEventListener('input', (e) => {
        if (e.target.classList.contains('input-qty') || e.target.classList.contains('input-harga')) {
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
