@extends('layouts.app')
@section('page-title', 'Buat Pengajuan BBM')

@section('content')
<div class="w-full pb-10">
    <div class="mb-8">
        <a href="{{ route('pengajuan-bbm.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Buat Pengajuan BBM</h2>
    </div>

    <form action="{{ route('pengajuan-bbm.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="form-pengajuan">
        @csrf
        
        <div class="p-6 md:p-8 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Pengajuan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Departemen <span class="text-red-500">*</span></label>
                    <input type="text" name="departemen" value="PERKEBUNAN" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pengajuan Untuk Kebutuhan (Lokasi Kebun) <span class="text-red-500">*</span></label>
                    <select name="kebun_id" required class="searchable-select w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all bg-white">
                        <option value="" disabled selected>-- Pilih Lokasi --</option>
                        @foreach($kebun as $k)
                            <option value="{{ $k->id }}">{{ $k->lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Perihal <span class="text-red-500">*</span></label>
                    <input type="text" name="perihal" value="Kebutuhan Biaya BBM" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengajuan <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Pengajuan (Opsional)</label>
                    <input type="text" name="judul_pengajuan" placeholder="Contoh: Pengajuan Operasional Basecamp"
                           class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 bg-gray-50/50">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                <h3 class="text-lg font-bold text-gray-800">Detail Kebutuhan BBM</h3>
                <div class="flex gap-2">
                    <button type="button" onclick="openModalPemakaian()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 border border-blue-200 hover:border-blue-500 hover:text-blue-600 text-blue-700 text-sm font-medium rounded-lg shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Ambil Data Pemakaian
                    </button>
                    <button type="button" id="btn-add-item" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 hover:text-emerald-600 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Baris
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-gray-100 border-y border-gray-200">
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[50px]">No.</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[150px]">Tipe BBM</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[120px]">Liter</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[150px]">Harga/Liter</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[180px]">Total Harga (Rp)</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider min-w-[200px]">Keterangan</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider w-[60px] text-center"></th>
                        </tr>
                    </thead>
                    <tbody id="items-container" class="divide-y divide-gray-100 bg-white">
                        <tr class="item-row">
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-center row-number">1</td>
                            <td class="py-3 px-4">
                                <select name="tipe_bbm[]" required class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm font-bold input-tipe-bbm">
                                    <option value="Solar">Solar</option>
                                    <option value="Pertalite">Pertalite</option>
                                </select>
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="jumlah_liter[]" required min="0" step="0.01" placeholder="0" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm font-bold input-liter">
                            </td>
                            <td class="py-3 px-4">
                                <input type="number" name="harga_per_liter[]" required min="0" value="16000" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm font-bold input-harga-liter">
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1 bg-gray-50 px-3 py-2 rounded border border-gray-100">
                                    <span class="text-sm font-bold text-gray-500">Rp</span>
                                    <input type="text" readonly class="w-full bg-transparent border-none p-0 focus:ring-0 text-emerald-700 outline-none text-sm font-bold input-total-harga-display" value="0">
                                    <input type="hidden" name="total_harga[]" class="input-total-harga" value="0">
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <input type="text" name="keterangan_pengajuan[]" placeholder="Cth: UNTUK OPERASIONAL" class="w-full px-3 py-2 rounded border border-gray-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none text-sm font-bold uppercase">
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
                            <td colspan="2" class="py-4 px-4 text-sm font-bold text-gray-800 uppercase text-right tracking-wider">TOTAL PENGAJUAN DANA</td>
                            <td class="py-4 px-4 text-left">
                                <span class="text-lg font-bold text-emerald-600" id="grand-total">Rp 0</span>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 bg-white flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Simpan Pengajuan
            </button>
        </div>
    </form>
</div>

<!-- Modal Ambil Data Pemakaian -->
<div id="modalPemakaian" class="fixed inset-0 z-50 hidden bg-gray-900/50 backdrop-blur-sm overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full sm:p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900" id="modal-title">Pilih Data Pemakaian BBM</h3>
                <button type="button" onclick="closeModalPemakaian()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>
            
            <div class="overflow-x-auto max-h-[60vh] border border-gray-200 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 sticky top-0 shadow-sm">
                        <tr>
                            <th class="py-3 px-4 w-10 text-center border-b border-gray-200">
                                <input type="checkbox" id="check-all-pemakaian" class="w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500">
                            </th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Tanggal</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Kategori</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Lokasi Kebun</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Karyawan</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">Judul Laporan</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase text-right border-b border-gray-200">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pemakaian_laporans as $laporan)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-3 px-4 text-center">
                                <input type="checkbox" class="check-pemakaian w-4 h-4 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500" 
                                       data-items='{{ json_encode($laporan->items) }}'>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-800">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $laporan->kategori == 'Kebun' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $laporan->kategori }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm font-semibold text-emerald-600">{{ $laporan->kebun ? $laporan->kebun->lokasi : '-' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-800">{{ $laporan->karyawan ? $laporan->karyawan->nama : '-' }}</td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800">{{ $laporan->judul_laporan ?? 'Pemakaian BBM' }}</td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-right">Rp {{ number_format($laporan->grand_total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-sm text-gray-500">Tidak ada data rekap pemakaian BBM terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="button" onclick="tambahkanDataTerpilih()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:w-auto sm:text-sm transition-all">
                    Tambahkan Terpilih (<span id="count-selected">0</span>)
                </button>
                <button type="button" onclick="closeModalPemakaian()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm transition-all">
                    Batal
                </button>
            </div>
        </div>
    </div>
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

            const liter = parseFloat(row.querySelector('.input-liter').value) || 0;
            const hargaLiter = parseFloat(row.querySelector('.input-harga-liter').value) || 0;
            const total = Math.round(liter * hargaLiter);
            
            row.querySelector('.input-total-harga-display').value = formatRp(total);
            row.querySelector('.input-total-harga').value = total;
            grandTotal += total;
        });

        grandTotalEl.textContent = 'Rp ' + formatRp(grandTotal);
    };

    btnAdd.addEventListener('click', () => {
        const firstRow = container.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelector('input[name="jumlah_liter[]"]').value = '';
        newRow.querySelector('.input-total-harga-display').value = '0';
        newRow.querySelector('.input-total-harga').value = '0';
        newRow.querySelector('input[name="keterangan_pengajuan[]"]').value = '';
        
        container.appendChild(newRow);
        calculateTotals();
    });

    container.addEventListener('input', (e) => {
        if (e.target.classList.contains('input-liter') || e.target.classList.contains('input-harga-liter')) {
            calculateTotals();
        }
    });

    container.addEventListener('change', (e) => {
        if (e.target.classList.contains('input-tipe-bbm')) {
            const row = e.target.closest('.item-row');
            const hargaInput = row.querySelector('.input-harga-liter');
            if (e.target.value === 'Solar') {
                hargaInput.value = 16000;
            } else if (e.target.value === 'Pertalite') {
                hargaInput.value = 13000;
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

// Modal Logic
function openModalPemakaian() {
    document.getElementById('modalPemakaian').classList.remove('hidden');
    updateCountSelected();
}

function closeModalPemakaian() {
    document.getElementById('modalPemakaian').classList.add('hidden');
}

function updateCountSelected() {
    const count = document.querySelectorAll('.check-pemakaian:checked').length;
    document.getElementById('count-selected').textContent = count;
}

document.getElementById('check-all-pemakaian').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.check-pemakaian');
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateCountSelected();
});

document.querySelectorAll('.check-pemakaian').forEach(cb => {
    cb.addEventListener('change', updateCountSelected);
});

function tambahkanDataTerpilih() {
    const checkboxes = document.querySelectorAll('.check-pemakaian:checked');
    if (checkboxes.length === 0) {
        alert('Pilih minimal 1 data pemakaian!');
        return;
    }

    const container = document.getElementById('items-container');
    const firstRow = container.querySelector('.item-row');
    
    let lastAddedInput = null;
    let aggregatedData = {};

    checkboxes.forEach(cb => {
        try {
            const items = JSON.parse(cb.dataset.items);
            items.forEach(item => {
                const tipe = String(item.tipe_bbm).toUpperCase();
                if (!aggregatedData[tipe]) {
                    aggregatedData[tipe] = { liter: 0, harga: 0, keterangan: [] };
                }
                
                aggregatedData[tipe].liter += parseFloat(item.jumlah_liter);
                aggregatedData[tipe].harga += Math.round(item.jumlah_liter * item.harga_per_liter);
                
                let ket = (item.keterangan_pemakaian || '').toUpperCase();
                if (ket && !aggregatedData[tipe].keterangan.includes(ket)) {
                    aggregatedData[tipe].keterangan.push(ket);
                }
            });
        } catch(e) {
            console.error('Error parsing items', e);
        }
        cb.checked = false;
    });

    Object.keys(aggregatedData).forEach(tipe => {
        const data = aggregatedData[tipe];
        const newRow = firstRow.cloneNode(true);
        
        // Tipe BBM
        const tipeSelect = newRow.querySelector('select[name="tipe_bbm[]"]');
        if (tipe.toLowerCase() === 'solar' || tipe.toLowerCase() === 'pertalite') {
            tipeSelect.value = tipe.charAt(0).toUpperCase() + tipe.slice(1).toLowerCase();
        } else {
            tipeSelect.value = 'Solar'; // Fallback
        }

        // Liter
        const literInput = newRow.querySelector('input[name="jumlah_liter[]"]');
        literInput.value = data.liter;

        // Harga
        const hargaLiterInput = newRow.querySelector('input[name="harga_per_liter[]"]');
        hargaLiterInput.value = tipeSelect.value === 'Pertalite' ? 13000 : 16000;
        
        // Keterangan
        let gabunganKeterangan = data.keterangan.join(', ');
        if (gabunganKeterangan.length > 250) {
            gabunganKeterangan = gabunganKeterangan.substring(0, 247) + '...';
        }
        newRow.querySelector('input[name="keterangan_pengajuan[]"]').value = gabunganKeterangan;
        
        container.appendChild(newRow);
        lastAddedInput = literInput; // Used to trigger recalculation
    });

    if (Object.keys(aggregatedData).length > 0) {
        const firstLiter = firstRow.querySelector('input[name="jumlah_liter[]"]').value;
        if (!firstLiter) {
            firstRow.remove();
        }
    }

    document.getElementById('check-all-pemakaian').checked = false;
    updateCountSelected();
    closeModalPemakaian();
    
    if (lastAddedInput) {
        lastAddedInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
}
</script>
@endpush
