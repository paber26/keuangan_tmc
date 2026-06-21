@extends('layouts.app')
@section('page-title', 'Buat Form Pengajuan Dana (Upah)')

@section('content')
<div class="max-w-6xl mx-auto pb-10">
    <div class="mb-8">
        <a href="{{ route('pengajuan-penggajian.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Buat Pengajuan Dana</h2>
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

    <form action="{{ route('pengajuan-penggajian.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="form-pengajuan">
        @csrf
        
        <div class="p-6 md:p-8 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Dokumen</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="lg:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">No. Dokumen</label>
                    <input type="text" name="no_dokumen" value="{{ old('no_dokumen', '077/TMC-PERKEBUNAN/VI/'.date('Y')) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Departemen</label>
                    <input type="text" value="PERKEBUNAN" readonly class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 outline-none">
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pengajuan Untuk Kebutuhan (Kebun) <span class="text-red-500">*</span></label>
                    <select name="kebun_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                        <option value="">-- Pilih Kebun --</option>
                        @foreach($kebuns as $kebun)
                            <option value="{{ $kebun->id }}" {{ old('kebun_id') == $kebun->id ? 'selected' : '' }}>{{ $kebun->lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Perihal <span class="text-red-500">*</span></label>
                    <input type="text" name="perihal" value="{{ old('perihal', 'Kebutuhan Biaya Upah') }}" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Disahkan Tgl</label>
                    <input type="date" name="disahkan_tgl" value="{{ old('disahkan_tgl', date('Y-m-d')) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berlaku Tgl</label>
                    <input type="date" name="berlaku_tgl" value="{{ old('berlaku_tgl', date('Y-m-d')) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Revisi</label>
                    <input type="text" name="revisi" value="{{ old('revisi', '0') }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-gray-50/50">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-800">Daftar Rincian</h3>
                <div class="flex gap-2">
                    <button type="button" onclick="openModalPenggajian()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-200 hover:border-blue-500 hover:text-blue-600 text-blue-700 text-sm font-medium rounded-lg shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Ambil Data Laporan Penggajian
                    </button>
                    <button type="button" id="btn-add-item" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 hover:text-emerald-600 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Baris
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]">
                    <thead>
                        <tr class="bg-gray-100 border-y border-gray-200">
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[50px]">No</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider min-w-[200px]">Uraian</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[120px]">Banyak Unit</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[150px]">Harga Satuan (Rp)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[180px] text-right">Total Harga (Rp) <span class="text-red-500">*</span></th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider min-w-[200px]">Keterangan</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[60px] text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="items-container" class="divide-y divide-gray-100 bg-white">
                        <tr class="item-row">
                            <td class="py-3 px-4 text-sm text-gray-500 text-center row-number">1</td>
                            <td class="py-3 px-4">
                                <textarea name="uraian[]" required placeholder="Contoh: UPAH PEKERJA PER 8-13 JUNI 2026" rows="2" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm"></textarea>
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="banyak_unit[]" min="0" step="any" placeholder="-" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-qty">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="harga_satuan[]" min="0" step="any" placeholder="-" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-harga">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="total_harga[]" required min="0" step="any" placeholder="0" class="w-full px-3 py-2 text-right font-medium rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm input-total">
                            </td>
                            <td class="py-3 px-4">
                                <textarea name="keterangan[]" placeholder="Catatan tambahan" rows="2" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm"></textarea>
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
                            <td colspan="4" class="py-4 px-4 text-sm font-bold text-gray-800 uppercase text-right tracking-wider">Grand Total</td>
                            <td class="py-4 px-4 text-right">
                                <span class="text-lg font-bold text-emerald-600" id="grand-total">0</span>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 bg-white flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Simpan Form Pengajuan
            </button>
        </div>
    </form>
</div>

<!-- Modal Ambil Data Penggajian -->
<div id="modalPenggajian" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900" id="modal-title">Pilih Data Laporan Penggajian</h3>
                <button type="button" onclick="closeModalPenggajian()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="overflow-x-auto max-h-[60vh] border border-gray-200 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 sticky top-0 shadow-sm">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center border-b border-gray-200">
                                <input type="checkbox" id="check-all-penggajian" class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                            </th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Periode Tanggal</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Lokasi Kebun</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Keterangan</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase text-right border-b border-gray-200">Total Upah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($penggajians as $laporan)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-4 text-center">
                                <input type="checkbox" class="check-penggajian w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500" 
                                       data-tanggal-mulai="{{ \Carbon\Carbon::parse($laporan->tanggal_mulai)->format('d M Y') }}"
                                       data-tanggal-akhir="{{ \Carbon\Carbon::parse($laporan->tanggal_akhir)->format('d M Y') }}"
                                       data-total="{{ $laporan->total_keseluruhan }}"
                                       data-keterangan="{{ $laporan->keterangan }}">
                            </td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($laporan->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporan->tanggal_akhir)->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-sm font-semibold text-emerald-600">{{ $laporan->lokasi_kebun }}</td>
                            <td class="py-3 px-4 text-sm text-gray-600">{{ $laporan->keterangan ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-right">Rp {{ number_format($laporan->total_keseluruhan, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-sm text-gray-500">Tidak ada data laporan penggajian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="button" onclick="tambahkanDataPenggajian()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:w-auto sm:text-sm transition-all">
                    Tambahkan Terpilih (<span id="count-selected-penggajian">0</span>)
                </button>
                <button type="button" onclick="closeModalPenggajian()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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

            const totalInput = row.querySelector('.input-total');
            const total = parseFloat(totalInput.value) || 0;
            grandTotal += total;
        });

        grandTotalEl.textContent = 'Rp ' + formatRp(grandTotal);
    };

    btnAdd.addEventListener('click', () => {
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelector('textarea[name="uraian[]"]').value = '';
        newRow.querySelector('input[name="banyak_unit[]"]').value = '';
        newRow.querySelector('input[name="harga_satuan[]"]').value = '';
        newRow.querySelector('input[name="total_harga[]"]').value = '';
        newRow.querySelector('textarea[name="keterangan[]"]').value = '';
        
        container.appendChild(newRow);
        calculateTotals();
    });

    // Auto calculate total_harga if unit and harga_satuan are filled
    container.addEventListener('input', (e) => {
        const row = e.target.closest('.item-row');
        if (e.target.classList.contains('input-qty') || e.target.classList.contains('input-harga')) {
            const qty = parseFloat(row.querySelector('.input-qty').value) || 0;
            const harga = parseFloat(row.querySelector('.input-harga').value) || 0;
            
            if (qty > 0 && harga > 0) {
                row.querySelector('.input-total').value = qty * harga;
            }
        }
        
        if (e.target.classList.contains('input-qty') || e.target.classList.contains('input-harga') || e.target.classList.contains('input-total')) {
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

// Modal Logic
function openModalPenggajian() {
    document.getElementById('modalPenggajian').classList.remove('hidden');
    updateCountSelectedPenggajian();
}

function closeModalPenggajian() {
    document.getElementById('modalPenggajian').classList.add('hidden');
}

function updateCountSelectedPenggajian() {
    const count = document.querySelectorAll('.check-penggajian:checked').length;
    document.getElementById('count-selected-penggajian').textContent = count;
}

document.getElementById('check-all-penggajian').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.check-penggajian');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateCountSelectedPenggajian();
});

document.querySelectorAll('.check-penggajian').forEach(cb => {
    cb.addEventListener('change', updateCountSelectedPenggajian);
});

function tambahkanDataPenggajian() {
    const checkboxes = document.querySelectorAll('.check-penggajian:checked');
    if (checkboxes.length === 0) {
        alert('Pilih minimal 1 data laporan penggajian!');
        return;
    }

    const container = document.getElementById('items-container');
    const firstRow = container.querySelector('.item-row');
    
    let lastAddedInput = null;

    checkboxes.forEach(cb => {
        const newRow = firstRow.cloneNode(true);
        
        const tanggalMulai = cb.getAttribute('data-tanggal-mulai');
        const tanggalAkhir = cb.getAttribute('data-tanggal-akhir');
        const total = Math.round(parseFloat(cb.getAttribute('data-total')) || 0);
        let keterangan = cb.getAttribute('data-keterangan') || '';
        
        if (keterangan === '-' || keterangan === 'null') keterangan = '';

        newRow.querySelector('textarea[name="uraian[]"]').value = `UPAH PEKERJA PER ${tanggalMulai} S/D ${tanggalAkhir}`.toUpperCase();
        newRow.querySelector('input[name="banyak_unit[]"]').value = '';
        newRow.querySelector('input[name="harga_satuan[]"]').value = '';
        newRow.querySelector('input[name="total_harga[]"]').value = total;
        newRow.querySelector('textarea[name="keterangan[]"]').value = keterangan;
        
        container.appendChild(newRow);
        lastAddedInput = newRow.querySelector('input[name="total_harga[]"]');
        cb.checked = false;
    });

    const firstUraian = firstRow.querySelector('textarea[name="uraian[]"]').value;
    const firstTotal = firstRow.querySelector('input[name="total_harga[]"]').value;
    if (!firstUraian && (!firstTotal || firstTotal == 0)) {
        firstRow.remove();
    }

    document.getElementById('check-all-penggajian').checked = false;
    updateCountSelectedPenggajian();
    closeModalPenggajian();
    
    if (lastAddedInput) {
        lastAddedInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
}
</script>
@endpush
