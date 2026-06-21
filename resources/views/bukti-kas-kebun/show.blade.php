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

</div>
@endsection
