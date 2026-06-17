@extends('layouts.app')

@section('title', 'Laporan Pekerjaan Mingguan (Absensi)')
@section('page-title', 'Absensi Harian')
@section('page-subtitle', 'Laporan Kehadiran Karyawan (Harian & Borongan)')

@section('content')
<div class="space-y-6">

    <!-- Filter Bar -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('absensi.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pilih Kebun</label>
                <select name="kebun_id" class="w-64 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                    @foreach($kebuns as $kebun)
                        <option value="{{ $kebun->id }}" {{ $selectedKebunId == $kebun->id ? 'selected' : '' }}>{{ $kebun->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-40 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-40 px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
            </div>
            <button type="submit" class="px-6 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg transition shadow-sm">
                Tampilkan
            </button>
        </form>
    </div>

    @if(count($karyawans) > 0)
    <!-- Attendance Table Form -->
    <form action="{{ route('absensi.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kebun_id" value="{{ $selectedKebunId }}">
        <input type="hidden" name="start_date" value="{{ $startDate }}">
        <input type="hidden" name="end_date" value="{{ $endDate }}">

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-emerald-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-emerald-800 text-lg">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h3>
                    <p class="text-sm text-emerald-600">Centang kotak untuk menandai kehadiran karyawan (Hadir).</p>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg transition shadow-md flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Absensi
                </button>
            </div>

            @php
                $groupedKaryawans = $karyawans->groupBy(function($item) {
                    return $item->jabatan ?: 'Tanpa Jabatan';
                });
            @endphp

            <div class="p-5">
                @foreach($groupedKaryawans as $jabatan => $group)
                <div class="mb-8 last:mb-0">
                    <h4 class="font-bold text-emerald-800 text-base mb-3 border-b border-emerald-100 pb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Status: {{ $jabatan }}
                    </h4>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-sm text-left border-collapse" data-group="{{ Str::slug($jabatan) }}">
                            <thead class="text-xs text-gray-700 uppercase bg-yellow-100 border-b-2 border-yellow-300">
                                <tr>
                                    <th rowspan="2" class="px-4 py-3 border border-yellow-300 w-12 text-center">NO.</th>
                                    <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-left min-w-[150px]">NAMA</th>
                                    <th colspan="{{ count($period) }}" class="px-4 py-2 border border-yellow-300 text-center text-xs tracking-wider">PERIODE</th>
                                    <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-center">HARI<br>KERJA</th>
                                    <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-right w-32">UPAH<br>PER HARI</th>
                                    <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-right w-36">TOTAL UPAH</th>
                                    <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-center w-12"><span class="sr-only">AKSI</span></th>
                                </tr>
                                <tr>
                                    @foreach($period as $date)
                                    <th class="px-2 py-2 border border-yellow-300 text-center min-w-[40px]">{{ $date->format('d') }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($group as $index => $karyawan)
                                <tr class="hover:bg-gray-50 transition-colors group main-table-row" data-jabatan="{{ $jabatan }}">
                                    <td class="px-4 py-3 border border-gray-200 text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 border border-gray-200 font-bold text-gray-800">
                                        {{ $karyawan->nama }}
                                        <input type="hidden" name="karyawan_ids[]" value="{{ $karyawan->id }}">
                                    </td>
                                    
                                    @foreach($period as $date)
                                        @php
                                            $dateStr = $date->format('Y-m-d');
                                            $status = $absensiData[$karyawan->id][$dateStr] ?? 'Alpha';
                                            $isChecked = $status === 'Hadir';
                                        @endphp
                                        <td class="px-2 py-3 border border-gray-200 text-center align-middle hover:bg-emerald-50 cursor-pointer" onclick="toggleCheckbox(this)">
                                            <input type="checkbox" 
                                                class="w-5 h-5 text-emerald-600 rounded border-gray-300 focus:ring-emerald-500 cursor-pointer attendance-cb pointer-events-none" 
                                                name="absensi[{{ $karyawan->id }}][{{ $jabatan }}][{{ $dateStr }}]" 
                                                data-karyawan="{{ $karyawan->id }}"
                                                {{ $isChecked ? 'checked' : '' }}>
                                        </td>
                                    @endforeach

                                    <td class="px-4 py-3 border border-gray-200 text-center font-bold bg-gray-50" id="hari_kerja_{{ $karyawan->id }}">0</td>
                                    <td class="px-4 py-3 border border-gray-200 text-right">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-500 text-xs">Rp</span>
                                            <input type="number" 
                                                class="w-24 text-right bg-transparent border-0 focus:ring-0 p-0 text-sm font-medium upah-input" 
                                                data-karyawan="{{ $karyawan->id }}" 
                                                value="125000">
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-right font-bold text-emerald-700 bg-emerald-50" id="total_upah_{{ $karyawan->id }}">
                                        Rp 0
                                    </td>
                                    <td class="px-4 py-3 border border-gray-200 text-center">
                                        <button type="button" onclick="document.getElementById('remove_form_{{ $karyawan->id }}_{{ Str::slug($jabatan) }}').submit();" class="text-red-400 hover:text-red-600 transition" title="Hapus dari lembar ini">
                                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-100">
                                <tr>
                                    <td colspan="2" class="px-4 py-4 border border-gray-300 text-center font-bold uppercase tracking-wider text-gray-600 text-xs">SUBTOTAL</td>
                                    <td colspan="{{ count($period) }}" class="border border-gray-300"></td>
                                    <td class="px-4 py-4 border border-gray-300 text-center font-bold text-base subtotal-hari" id="subtotal_hari_{{ Str::slug($jabatan) }}">0</td>
                                    <td class="border border-gray-300"></td>
                                    <td class="px-4 py-4 border border-gray-300 text-right font-bold text-base text-emerald-800 subtotal-upah" id="subtotal_upah_{{ Str::slug($jabatan) }}">Rp 0</td>
                                    <td class="border border-gray-300 bg-white"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </form>
    
    <!-- Rekapitulasi per Status -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mt-6">
        <h4 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Rekapitulasi per Status / Jabatan
        </h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 py-3 border border-gray-200 w-12 text-center">NO.</th>
                        <th class="px-4 py-3 border border-gray-200">STATUS / JABATAN</th>
                        <th class="px-4 py-3 border border-gray-200 text-center">JUMLAH PEKERJA</th>
                        <th class="px-4 py-3 border border-gray-200 text-center">TOTAL HARI (HOK)</th>
                        <th class="px-4 py-3 border border-gray-200 text-right">TOTAL UPAH</th>
                    </tr>
                </thead>
                <tbody id="summary_table_body" class="divide-y divide-gray-200">
                    <!-- Javascript will populate this -->
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="2" class="px-4 py-3 border border-gray-200 text-center font-bold text-gray-700">GRAND TOTAL</td>
                        <td class="px-4 py-3 border border-gray-200 text-center font-bold" id="summary_grand_pekerja">0</td>
                        <td class="px-4 py-3 border border-gray-200 text-center font-bold text-emerald-700" id="summary_grand_hari">0</td>
                        <td class="px-4 py-3 border border-gray-200 text-right font-bold text-emerald-700" id="summary_grand_upah">Rp 0</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Hidden Forms for Removing -->
    @foreach($karyawans as $karyawan)
        <form id="remove_form_{{ $karyawan->id }}_{{ Str::slug($karyawan->jabatan_pekerjaan) }}" action="{{ route('absensi.remove') }}" method="POST" class="hidden">
            @csrf
            <input type="hidden" name="kebun_id" value="{{ $selectedKebunId }}">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
            <input type="hidden" name="jabatan_pekerjaan" value="{{ $karyawan->jabatan_pekerjaan }}">
        </form>
    @endforeach

    @else
        <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Lembar Absensi Kosong</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">Belum ada karyawan yang dimasukkan ke lembar absensi untuk periode ini. Silakan tambahkan pekerja di bawah.</p>
        </div>
    @endif

    <!-- Add Karyawan Form -->
    @if(isset($allKaryawans) && $allKaryawans->count() > 0 && isset($selectedKebunId))
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 mt-6 shadow-sm">
        <h4 class="font-bold text-gray-700 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Tambah Pekerja ke Lembar Ini
        </h4>
        <form action="{{ route('absensi.add') }}" method="POST" class="flex gap-4 items-center">
            @csrf
            <input type="hidden" name="kebun_id" value="{{ $selectedKebunId }}">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            
            <select name="karyawan_id" class="w-64 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 shadow-sm" required>
                <option value="">-- Pilih Pekerja --</option>
                @foreach($allKaryawans as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>

            <select name="jabatan_pekerjaan" class="w-56 px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 shadow-sm" required>
                <option value="">-- Sebagai (Peran) --</option>
                <option value="Harian Kumpul">Harian Kumpul</option>
                <option value="Kupas Kelapa">Kupas Kelapa</option>
                <option value="Momaras Mesin">Momaras Mesin</option>
                <option value="Pemanjat Kelapa">Pemanjat Kelapa</option>
                <option value="Lainnya">Lainnya...</option>
            </select>

            <button type="submit" class="px-6 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium rounded-lg shadow-sm transition">
                Tambahkan
            </button>
        </form>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function toggleCheckbox(cell) {
        const cb = cell.querySelector('input[type="checkbox"]');
        cb.checked = !cb.checked;
        calculateTotals();
    }

    function calculateTotals() {
        const rows = document.querySelectorAll('tbody tr.main-table-row');
        let summaryData = {};
        let grandTotalHari = 0;
        let grandTotalUpah = 0;
        let grandTotalPekerja = 0;

        rows.forEach(row => {
            const jabatan = row.dataset.jabatan || 'Tidak Diketahui';
            const checkboxes = row.querySelectorAll('.attendance-cb:checked');
            const hariKerja = checkboxes.length;
            const upahInput = row.querySelector('.upah-input');
            const upahPerHari = parseInt(upahInput.value) || 0;
            const totalUpah = hariKerja * upahPerHari;
            const karyawanId = upahInput.dataset.karyawan;

            // Initialize summary for this jabatan if not exists
            if (!summaryData[jabatan]) {
                summaryData[jabatan] = { pekerja: 0, hari: 0, upah: 0, slug: row.closest('table').dataset.group };
            }
            summaryData[jabatan].pekerja += 1;
            summaryData[jabatan].hari += hariKerja;
            summaryData[jabatan].upah += totalUpah;

            // Update row UI
            document.getElementById(`hari_kerja_${karyawanId}`).textContent = hariKerja;
            document.getElementById(`total_upah_${karyawanId}`).textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalUpah);

            grandTotalHari += hariKerja;
            grandTotalUpah += totalUpah;
            grandTotalPekerja += 1;
        });

        // Update subtotals for each table
        for (const [jabatan, data] of Object.entries(summaryData)) {
            const slug = data.slug;
            const subHariEl = document.getElementById(`subtotal_hari_${slug}`);
            if (subHariEl) subHariEl.textContent = data.hari;
            
            const subUpahEl = document.getElementById(`subtotal_upah_${slug}`);
            if (subUpahEl) subUpahEl.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.upah);
        }

        // Update footer UI
        const grandHariEl = document.getElementById('grand_total_hari');
        if(grandHariEl) grandHariEl.textContent = grandTotalHari;
        
        const grandUpahEl = document.getElementById('grand_total_upah');
        if(grandUpahEl) grandUpahEl.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(grandTotalUpah);

        // Update Summary Table UI
        const summaryBody = document.getElementById('summary_table_body');
        if(summaryBody) {
            summaryBody.innerHTML = '';
            let index = 1;
            for (const [jabatan, data] of Object.entries(summaryData)) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-4 py-3 border border-gray-200 text-center">${index++}</td>
                    <td class="px-4 py-3 border border-gray-200 font-semibold text-gray-700">${jabatan}</td>
                    <td class="px-4 py-3 border border-gray-200 text-center">${data.pekerja} Orang</td>
                    <td class="px-4 py-3 border border-gray-200 text-center font-semibold text-emerald-600">${data.hari}</td>
                    <td class="px-4 py-3 border border-gray-200 text-right font-semibold text-emerald-700">${new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(data.upah)}</td>
                `;
                summaryBody.appendChild(tr);
            }

            // Update summary grand totals
            document.getElementById('summary_grand_pekerja').textContent = grandTotalPekerja + ' Orang';
            document.getElementById('summary_grand_hari').textContent = grandTotalHari;
            document.getElementById('summary_grand_upah').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(grandTotalUpah);
        }
    }

    // Calculate on load
    document.addEventListener('DOMContentLoaded', () => {
        calculateTotals();

        // Listen for manual upah changes
        document.querySelectorAll('.upah-input').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
    });
</script>
@endpush
@endsection
