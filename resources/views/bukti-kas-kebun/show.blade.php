@extends('layouts.app')
@section('page-title', 'Detail Bukti Kas Kebun')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <a href="{{ route('bukti-kas-kebun.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Bukti Pengeluaran Kas Kebun</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('bukti-kas-kebun.print', $bukti_kas_kebun->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print PDF (A5)
            </a>
            <a href="{{ route('bukti-kas-kebun.edit', $bukti_kas_kebun->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 hover:text-emerald-600 text-gray-700 text-sm font-semibold rounded-xl shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>
    </div>

    <!-- Informasi Utama -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 md:p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Bukti Kas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Tanggal Bukti</span>
                    <span class="block text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($bukti_kas_kebun->tanggal)->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">No. Bukti</span>
                    <span class="block text-base font-semibold text-gray-900">{{ $bukti_kas_kebun->no_bukti ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Status Pengajuan</span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 text-sm font-medium border border-emerald-200">
                        {{ $bukti_kas_kebun->pengajuan_penggajian->status }}
                    </span>
                </div>
                <div class="lg:col-span-3">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Terkait Form Pengajuan Dana</span>
                    <div class="flex items-center justify-between p-4 mt-1 bg-gray-50 rounded-lg border border-gray-200">
                        <div>
                            <div class="font-bold text-gray-800">#{{ $bukti_kas_kebun->pengajuan_penggajian->no_dokumen ?: $bukti_kas_kebun->pengajuan_penggajian->id }}</div>
                            <div class="text-sm text-gray-600 mt-1">{{ $bukti_kas_kebun->pengajuan_penggajian->perihal }}</div>
                        </div>
                        <a href="{{ route('pengajuan-penggajian.show', $bukti_kas_kebun->pengajuan_penggajian->id) }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 underline">Lihat Pengajuan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rincian Pengeluaran -->
    @php
        $pengajuan = $bukti_kas_kebun->pengajuan_penggajian;
        $penggajian = $pengajuan->penggajian;
        
        if (!$penggajian) {
            foreach($pengajuan->items as $item) {
                if (preg_match('/PER (.*?) S\/D (.*?)$/i', $item->uraian, $matches)) {
                    try {
                        $start = \Carbon\Carbon::parse($matches[1])->format('Y-m-d');
                        $end = \Carbon\Carbon::parse($matches[2])->format('Y-m-d');
                        $found = \App\Models\Penggajian::where('tanggal_mulai', $start)
                            ->where('tanggal_akhir', $end)
                            ->first();
                        if ($found) {
                            $penggajian = $found;
                            break;
                        }
                    } catch(\Exception $e) {}
                }
            }
        }
        
        $grouped = [];
        $total = 0;
        
        if ($penggajian && $penggajian->details) {
            foreach($penggajian->details as $detail) {
                // Determine Jabatan Name exactly like in the modal description
                $jabatanName = $detail->jabatan;
                if (!$jabatanName || strtolower($jabatanName) === 'harian' || strtolower($jabatanName) === 'borongan') {
                    $relJabatan = $detail->karyawan->jabatans->first()->nama ?? null;
                    if ($relJabatan) {
                        $jabatanName = $relJabatan;
                    } else {
                        $jabatanName = $detail->tipe_pekerjaan ?: 'Lain-lain';
                    }
                }
                
                // If it still resolves to just 'Harian', format it as 'Harian Kumpul' to be more descriptive per user request
                if (strtolower($jabatanName) === 'harian') {
                    $jabatanName = 'Harian Kumpul';
                }
                
                if(!isset($grouped[$jabatanName])) {
                    $grouped[$jabatanName] = 0;
                }
                $grouped[$jabatanName] += $detail->total_upah;
                $total += $detail->total_upah;
            }
        } else {
            foreach($pengajuan->items as $item) {
                if(!isset($grouped[$item->uraian])) {
                    $grouped[$item->uraian] = 0;
                }
                $grouped[$item->uraian] += $item->total_harga;
                $total += $item->total_harga;
            }
        }
    @endphp

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 md:p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Rincian Pengeluaran</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-sm border-b border-gray-200">
                            <th class="px-4 py-3 font-semibold">No Urut</th>
                            <th class="px-4 py-3 font-semibold">Keterangan</th>
                            <th class="px-4 py-3 font-semibold text-right">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-b border-gray-100">
                            <td class="px-4 py-3"></td>
                            <td class="px-4 py-3 font-bold text-gray-800">BEBAN UPAH KEBUN {{ strtoupper($pengajuan->kebun->lokasi) }}</td>
                            <td class="px-4 py-3"></td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="px-4 py-3"></td>
                            @if($penggajian)
                            <td class="px-4 py-3 font-bold text-gray-800">PERIODE : {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->format('d') }}-{{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->translatedFormat('d F Y') }}</td>
                            @else
                            <td class="px-4 py-3 font-bold text-gray-800">PERIODE : {{ \Carbon\Carbon::parse($pengajuan->tanggal)->translatedFormat('F Y') }}</td>
                            @endif
                            <td class="px-4 py-3"></td>
                        </tr>
                        @foreach($grouped as $tipe => $jumlah)
                        <tr class="border-b border-gray-100">
                            <td class="px-4 py-3"></td>
                            <td class="px-4 py-3 text-gray-700">{{ strtoupper($tipe) }}</td>
                            <td class="px-4 py-3 text-right font-medium text-gray-900">Rp {{ number_format($jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="2" class="px-4 py-4 text-right font-bold text-gray-800">JUMLAH</td>
                            <td class="px-4 py-4 text-right font-bold text-emerald-600 text-lg">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
