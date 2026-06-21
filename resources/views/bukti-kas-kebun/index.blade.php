@extends('layouts.app')
@section('page-title', 'Data Bukti Pengeluaran Kas Kebun')

@section('content')
<div class="max-w-7xl mx-auto pb-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Bukti Pengeluaran Kas Kebun</h1>
            <p class="text-sm text-gray-500 mt-2">Kelola data bukti pengeluaran kas kebun A5</p>
        </div>
        <a href="{{ route('bukti-kas-kebun.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-sm hover:shadow-md transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Bukti Kas
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-emerald-800">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-red-800">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider w-[60px]">No</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Bukti</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">No Bukti</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Terkait Pengajuan Dana</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right w-[200px]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($bukti_kas_kebuns as $index => $bukti)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-sm font-medium">
                                {{ \Carbon\Carbon::parse($bukti->tanggal)->format('d M Y') }}
                            </span>
                        </td>
                        <td class="py-4 px-6 font-medium text-gray-900">{{ $bukti->no_bukti ?: '-' }}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-800">
                            #{{ $bukti->pengajuan_penggajian->no_dokumen ?: $bukti->pengajuan_penggajian->id }}
                            <div class="text-xs text-gray-500 font-normal mt-0.5">{{ $bukti->pengajuan_penggajian->perihal }}</div>
                        </td>
                        <td class="py-4 px-6 font-bold text-emerald-600">Rp {{ number_format($bukti->pengajuan_penggajian->grand_total, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-right space-x-2">
                            <a href="{{ route('bukti-kas-kebun.show', $bukti->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-md transition-colors" title="Lihat & Print">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                            <a href="{{ route('bukti-kas-kebun.edit', $bukti->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-md transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('bukti-kas-kebun.destroy', $bukti->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bukti kas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-md transition-colors" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm font-medium">Belum ada data bukti pengeluaran kas kebun.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
