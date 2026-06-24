@extends('layouts.app')
@section('title', 'Bukti Bank Kebun')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Daftar Bukti Bank Kebun</h2>
        <p class="text-gray-500 text-sm mt-1">Kelola data bukti pengeluaran bank kebun.</p>
    </div>
    <a href="{{ route('bukti-bank-kebun.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-sm transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Buat Baru
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">No Bukti</th>
                    <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul / Keperluan</th>
                    <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Grand Total</th>
                    <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($bukti_bank_kebuns as $index => $bukti)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-3 px-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $bukti->no_bukti ?? '-' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($bukti->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ $bukti->judul_pengajuan }}</td>
                    <td class="py-3 px-4 text-sm font-semibold text-emerald-600 text-right">Rp {{ number_format($bukti->grand_total, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('bukti-bank-kebun.show', $bukti->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('bukti-bank-kebun.print', $bukti->id) }}" target="_blank" class="p-1.5 text-gray-600 hover:bg-gray-100 rounded transition-colors" title="Print PDF">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            </a>
                            <a href="{{ route('bukti-bank-kebun.edit', $bukti->id) }}" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('bukti-bank-kebun.destroy', $bukti->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-red-500 hover:bg-red-50 rounded transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        Belum ada data Bukti Bank Kebun.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
