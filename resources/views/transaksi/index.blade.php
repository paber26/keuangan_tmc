@extends('layouts.app')

@section('title', 'Buku Kas')
@section('page-title', 'Buku Kas')
@section('page-subtitle', 'Catatan transaksi keuangan')

@section('page-actions')
    <button onclick="openModalTambah()" 
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/20 transition-all duration-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Transaksi
    </button>
@endsection

@section('content')
<div>
    {{-- Filter Bar --}}
    <form method="GET" action="{{ route('transaksi.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kebun</label>
                <select name="kebun_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option value="">Semua Kebun</option>
                    @foreach($kebuns as $k)
                        <option value="{{ $k->id }}" {{ $kebun_id == $k->id ? 'selected' : '' }}>{{ $k->virtual_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[130px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Bulan</label>
                <select name="bulan" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[100px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Tahun</label>
                <select name="tahun" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    @for($y = \Carbon\Carbon::now()->year - 2; $y <= \Carbon\Carbon::now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="min-w-[160px]">
                <label class="block text-xs font-semibold text-gray-500 mb-1.5">Kategori</label>
                <select name="kategori" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                    <option value="Semua" {{ $kategori == 'Semua' ? 'selected' : '' }}>Semua Kategori</option>
                    <option value="Penjualan Panen" {{ $kategori == 'Penjualan Panen' ? 'selected' : '' }}>Penjualan Panen</option>
                    <option value="Upah Harian" {{ $kategori == 'Upah Harian' ? 'selected' : '' }}>Upah Harian</option>
                    <option value="Upah Borongan" {{ $kategori == 'Upah Borongan' ? 'selected' : '' }}>Upah Borongan</option>
                    <option value="Gaji" {{ $kategori == 'Gaji' ? 'selected' : '' }}>Gaji</option>
                    <option value="Operasional" {{ $kategori == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                    <option value="Lainnya" {{ $kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
        </div>
    </form>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
        {{-- Total Masuk --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Masuk</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($total_masuk, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $count_masuk }} transaksi pemasukan</p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                </div>
            </div>
        </div>

        {{-- Total Keluar --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Keluar</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">Rp {{ number_format($total_keluar, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $count_keluar }} transaksi pengeluaran</p>
                </div>
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                </div>
            </div>
        </div>

        {{-- Saldo --}}
        <div class="stat-card bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Saldo</p>
                    <p class="text-2xl font-bold {{ $saldo >= 0 ? 'text-blue-600' : 'text-red-600' }} mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-1">Bulan {{ \Carbon\Carbon::create()->month($bulan)->year($tahun)->translatedFormat('F Y') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-gray-800">Daftar Transaksi</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }} — {{ $kebun_id ? ($kebuns->firstWhere('id', $kebun_id)->virtual_lokasi ?? 'Semua Kebun') : 'Semua Kebun' }}</p>
            </div>
            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full font-medium">{{ $transaksis->total() }} transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori & Kebun</th>
                        <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Masuk</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keluar</th>
                        <th class="text-right px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-gray-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                        <td class="px-5 py-3.5">
                            @php
                                $color = match($t->kategori) {
                                    'Penjualan Panen' => 'bg-emerald-50 text-emerald-700',
                                    'Upah Harian' => 'bg-orange-50 text-orange-700',
                                    'Upah Borongan' => 'bg-purple-50 text-purple-700',
                                    'Gaji' => 'bg-blue-50 text-blue-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                {{ $t->kategori }}
                            </span>
                            @if($t->kebun)
                            <div class="text-[11px] text-gray-400 mt-1">{{ $t->kebun->virtual_lokasi }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-700 max-w-xs truncate" title="{{ $t->keterangan }}">
                            {{ $t->keterangan ?: '-' }}
                        </td>
                        
                        @if($t->tipe == 'Pemasukan')
                            <td class="px-5 py-3.5 text-right font-semibold text-emerald-600 whitespace-nowrap">+ Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                        @else
                            <td class="px-5 py-3.5 text-right text-gray-300">—</td>
                            <td class="px-5 py-3.5 text-right font-semibold text-red-500 whitespace-nowrap">- Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                        @endif

                        <td class="px-5 py-3.5 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" onclick="openModalEdit({{ json_encode($t) }})" class="text-amber-600 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 p-1.5 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">Belum ada transaksi pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($transaksis->count() > 0)
                <tfoot>
                    <tr class="bg-gray-50/80 border-t-2 border-gray-200">
                        <td colspan="3" class="px-5 py-3.5 text-sm font-bold text-gray-700">TOTAL HALAMAN INI</td>
                        <td class="px-5 py-3.5 text-right font-bold text-emerald-600 whitespace-nowrap">+ Rp {{ number_format($transaksis->where('tipe', 'Pemasukan')->sum('jumlah'), 0, ',', '.') }}</td>
                        <td class="px-5 py-3.5 text-right font-bold text-red-500 whitespace-nowrap">- Rp {{ number_format($transaksis->where('tipe', 'Pengeluaran')->sum('jumlah'), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $transaksis->withQueryString()->links() }}
        </div>
    </div>

    {{-- Export Buttons (Unchanged visual, just UI for now or you can wire it up later) --}}
    <div class="flex items-center justify-end gap-3 mt-6">
        <button class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm opacity-50 cursor-not-allowed" title="Segera hadir">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Word
        </button>
        <button class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-sm opacity-50 cursor-not-allowed" title="Segera hadir">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export PDF
        </button>
    </div>

    {{-- Add/Edit Transaction Modal --}}
    <div id="modalTransaksi" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 z-10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-800" id="modalTitle">Tambah Transaksi</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form id="transaksiForm" method="POST" action="{{ route('transaksi.store') }}" class="space-y-4">
                @csrf
                <div id="methodContainer"></div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe</label>
                        <select name="tipe" id="tipe" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                            <option value="Pengeluaran">Pengeluaran</option>
                            <option value="Pemasukan">Pemasukan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kategori</label>
                        <select name="kategori" id="modalKategori" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                            <option value="Penjualan Panen">Penjualan Panen</option>
                            <option value="Upah Harian">Upah Harian</option>
                            <option value="Upah Borongan">Upah Borongan</option>
                            <option value="Gaji">Gaji</option>
                            <option value="Operasional" selected>Operasional</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kebun (Opsional)</label>
                    <select name="kebun_id" id="kebun_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500">
                        <option value="">-- Tidak ada kebun spesifik --</option>
                        @foreach($kebuns as $k)
                            <option value="{{ $k->id }}">{{ $k->virtual_lokasi }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah (Rp)</label>
                    <input type="text" name="jumlah" id="jumlah" required placeholder="0" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500" oninput="formatRupiah(this)">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3" placeholder="Deskripsi transaksi..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500 resize-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" id="btnSubmit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-200">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModalTambah() {
        document.getElementById('modalTitle').innerText = 'Tambah Transaksi';
        document.getElementById('transaksiForm').action = "{{ route('transaksi.store') }}";
        document.getElementById('methodContainer').innerHTML = ''; 
        document.getElementById('btnSubmit').innerText = 'Simpan Transaksi';
        
        // Reset form
        document.getElementById('tanggal').value = "{{ date('Y-m-d') }}";
        document.getElementById('tipe').value = "Pengeluaran";
        document.getElementById('modalKategori').value = "Operasional";
        document.getElementById('kebun_id').value = "";
        document.getElementById('jumlah').value = "";
        document.getElementById('keterangan').value = "";

        document.getElementById('modalTransaksi').classList.remove('hidden');
    }

    function openModalEdit(transaksi) {
        document.getElementById('modalTitle').innerText = 'Edit Transaksi';
        document.getElementById('transaksiForm').action = "/transaksi/" + transaksi.id;
        document.getElementById('methodContainer').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('btnSubmit').innerText = 'Perbarui Transaksi';
        
        // Fill form
        document.getElementById('tanggal').value = transaksi.tanggal;
        document.getElementById('tipe').value = transaksi.tipe;
        document.getElementById('modalKategori').value = transaksi.kategori;
        document.getElementById('kebun_id').value = transaksi.kebun_id || "";
        document.getElementById('jumlah').value = formatRupiahString(transaksi.jumlah.toString());
        document.getElementById('keterangan').value = transaksi.keterangan || "";

        document.getElementById('modalTransaksi').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalTransaksi').classList.add('hidden');
    }

    function formatRupiah(el) {
        el.value = formatRupiahString(el.value);
    }

    function formatRupiahString(angka) {
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa  = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        return rupiah;
    }
</script>
@endsection
