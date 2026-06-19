@extends('layouts.app')
@section('title', 'Edit Pengajuan Barang')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="mb-8">
        <a href="{{ route('pengajuan.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Pengajuan Barang</h2>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-center gap-3 text-red-800 mb-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-medium">Terdapat kesalahan pada input Anda:</span>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700 ml-8">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('pengajuan.update', $pengajuan->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="form-pengajuan">
        @csrf
        @method('PUT')
        
        <div class="p-6 md:p-8 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Nota</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ $pengajuan->tanggal }}" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul / Keperluan <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_pengajuan" value="{{ $pengajuan->judul_pengajuan }}" placeholder="Contoh: Belanja Bulanan Basecamp" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Tambahan (Opsional)</label>
                    <textarea name="keterangan" rows="2" placeholder="Tuliskan catatan tambahan di sini..."
                              class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">{{ $pengajuan->keterangan }}</textarea>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-gray-50/50">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-800">Daftar Barang</h3>
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
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider min-w-[250px]">Nama Barang / Deskripsi</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[120px]">Jumlah (Qty)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[180px]">Harga Satuan (Rp)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[200px] text-right">Total Harga (Rp)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[60px] text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="items-container" class="divide-y divide-gray-100 bg-white">
                        @foreach($pengajuan->items as $index => $item)
                        <tr class="item-row">
                            <td class="py-3 px-4 text-sm text-gray-500 text-center row-number">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                <input type="text" name="nama_barang[]" value="{{ $item->nama_barang }}" required placeholder="Nama barang" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="qty[]" value="{{ $item->qty }}" required min="1" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-qty">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="harga_satuan[]" value="{{ $item->harga_satuan }}" required min="0" placeholder="0" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-harga">
                            </td>
                            <td class="py-3 px-4 text-right">
                                <span class="text-sm font-semibold text-gray-800 row-total">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <button type="button" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded transition-colors btn-remove-item" title="Hapus Baris" {{ count($pengajuan->items) == 1 ? 'disabled' : '' }}>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-100 border-t border-gray-200">
                            <td colspan="4" class="py-4 px-4 text-sm font-bold text-gray-800 uppercase text-right tracking-wider">Grand Total</td>
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
                Perbarui Pengajuan Barang
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('items-container');
    const btnAdd = document.getElementById('btn-add-item');
    const grandTotalEl = document.getElementById('grand-total');

    // Format Rupiah
    const formatRp = (number) => {
        return new Intl.NumberFormat('id-ID').format(number);
    };

    // Calculate totals
    const calculateTotals = () => {
        let grandTotal = 0;
        const rows = container.querySelectorAll('.item-row');
        
        rows.forEach((row, index) => {
            // Update row number
            row.querySelector('.row-number').textContent = index + 1;
            
            // Enable/disable remove button (keep at least 1)
            const removeBtn = row.querySelector('.btn-remove-item');
            if (rows.length === 1) {
                removeBtn.disabled = true;
                removeBtn.classList.remove('hover:text-red-500', 'hover:bg-red-50');
            } else {
                removeBtn.disabled = false;
                removeBtn.classList.add('hover:text-red-500', 'hover:bg-red-50');
            }

            // Calculate row total
            const qty = parseFloat(row.querySelector('.input-qty').value) || 0;
            const harga = parseFloat(row.querySelector('.input-harga').value) || 0;
            const total = qty * harga;
            
            row.querySelector('.row-total').textContent = formatRp(total);
            grandTotal += total;
        });

        grandTotalEl.textContent = 'Rp ' + formatRp(grandTotal);
    };

    // Add new row
    btnAdd.addEventListener('click', () => {
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        // Reset values
        newRow.querySelector('input[name="nama_barang[]"]').value = '';
        newRow.querySelector('input[name="qty[]"]').value = '1';
        newRow.querySelector('input[name="harga_satuan[]"]').value = '';
        newRow.querySelector('.row-total').textContent = '0';
        
        container.appendChild(newRow);
        calculateTotals();
    });

    // Handle inputs and removes
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

    // Initial calculation
    calculateTotals();
});
</script>
@endpush
