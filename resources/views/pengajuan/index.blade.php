@extends('layouts.app')
@section('title', 'Daftar Pengajuan Barang')

@section('content')
<div class="max-w-7xl mx-auto pb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Pengajuan Barang</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola daftar invoice pengajuan barang harian Anda.</p>
        </div>
        <a href="{{ route('pengajuan.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengajuan Baru
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Pengajuan</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Grand Total</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pengajuans as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 text-sm text-gray-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="py-4 px-6">
                            <p class="text-sm font-medium text-gray-800">{{ $item->judul_pengajuan }}</p>
                            @if($item->keterangan)
                            <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $item->keterangan }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $item->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-800' : ($item->status == 'Ditolak' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm font-semibold text-gray-800 text-right whitespace-nowrap">
                            Rp {{ number_format($item->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                @if($item->status == 'Menunggu')
                                <a href="{{ route('pengajuan.edit', $item->id) }}" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Pengajuan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('pengajuan.approve', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Setujui pengajuan ini?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-1.5 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Setujui">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                @endif
                                <a href="{{ route('pengajuan.show', $item->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Invoice">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <form action="{{ route('pengajuan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-sm text-gray-500">
                            Belum ada data pengajuan barang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
