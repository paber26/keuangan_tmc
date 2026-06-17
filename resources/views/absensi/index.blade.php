@extends('layouts.app')

@section('title', 'Laporan Pekerjaan Mingguan (Absensi)')
@section('page-title', 'Absensi Harian')
@section('page-subtitle', 'Laporan Kehadiran Karyawan Harian')

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

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="text-xs text-gray-700 uppercase bg-yellow-100 border-b-2 border-yellow-300">
                        <tr>
                            <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-center w-12">NO.</th>
                            <th rowspan="2" class="px-4 py-3 border border-yellow-300 w-64">NAMA</th>
                            <th colspan="{{ count($period) }}" class="px-4 py-2 border border-yellow-300 text-center bg-yellow-200">PERIODE</th>
                            <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-center">HARI<br>KERJA</th>
                            <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-right w-32">UPAH<br>PER HARI</th>
                            <th rowspan="2" class="px-4 py-3 border border-yellow-300 text-right w-36">TOTAL UPAH</th>
                        </tr>
                        <tr>
                            @foreach($period as $date)
                            <th class="px-2 py-2 border border-yellow-300 text-center min-w-[40px]">{{ $date->format('d') }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($karyawans as $index => $karyawan)
                        <tr class="hover:bg-gray-50 transition-colors group">
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
                                           name="absensi[{{ $karyawan->id }}][{{ $dateStr }}]" 
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
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-100">
                        <tr>
                            <td colspan="2" class="px-4 py-4 border border-gray-300 text-center font-bold text-lg uppercase tracking-wider">JUMLAH</td>
                            <td colspan="{{ count($period) }}" class="border border-gray-300"></td>
                            <td class="px-4 py-4 border border-gray-300 text-center font-bold text-lg" id="grand_total_hari">0</td>
                            <td class="border border-gray-300"></td>
                            <td class="px-4 py-4 border border-gray-300 text-right font-bold text-lg text-emerald-800" id="grand_total_upah">Rp 0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>
    @else
        <div class="bg-white p-10 rounded-xl shadow-sm border border-gray-100 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak ada Karyawan Harian</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">Tidak ditemukan karyawan dengan tipe gaji "Harian" untuk kebun ini. Silakan tambahkan data karyawan terlebih dahulu.</p>
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
        const rows = document.querySelectorAll('tbody tr');
        let grandTotalHari = 0;
        let grandTotalUpah = 0;

        rows.forEach(row => {
            const checkboxes = row.querySelectorAll('.attendance-cb:checked');
            const hariKerja = checkboxes.length;
            const upahInput = row.querySelector('.upah-input');
            const upahPerHari = parseInt(upahInput.value) || 0;
            const totalUpah = hariKerja * upahPerHari;
            const karyawanId = upahInput.dataset.karyawan;

            // Update row UI
            document.getElementById(`hari_kerja_${karyawanId}`).textContent = hariKerja;
            document.getElementById(`total_upah_${karyawanId}`).textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalUpah);

            grandTotalHari += hariKerja;
            grandTotalUpah += totalUpah;
        });

        // Update footer UI
        const grandHariEl = document.getElementById('grand_total_hari');
        if(grandHariEl) grandHariEl.textContent = grandTotalHari;
        
        const grandUpahEl = document.getElementById('grand_total_upah');
        if(grandUpahEl) grandUpahEl.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(grandTotalUpah);
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
