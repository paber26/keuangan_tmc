@extends('layouts.app')
@section('page-title', 'Detail Pengajuan Dana (Upah)')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('pengajuan-penggajian.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight flex items-center gap-3">
                Pengajuan Dana #{{ $pengajuan_penggajian->no_dokumen ?: $pengajuan_penggajian->id }}
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    {{ $pengajuan_penggajian->status === 'Menunggu' ? 'bg-amber-100 text-amber-700' : ($pengajuan_penggajian->status === 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                    {{ $pengajuan_penggajian->status }}
                </span>
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pengajuan-penggajian.print', $pengajuan_penggajian->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-gray-800 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-gray-900 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print PDF
            </a>
            @if($pengajuan_penggajian->status === 'Menunggu')
            <a href="{{ route('pengajuan-penggajian.edit', $pengajuan_penggajian->id) }}" class="inline-flex items-center gap-2 bg-amber-500 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-amber-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            @endif
        </div>
    </div>

    @if($pengajuan_penggajian->status === 'Menunggu')
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Ubah Status</h3>
            <p class="text-sm text-gray-500">Pilih status pengajuan ini (Hanya bisa dilakukan jika masih 'Menunggu').</p>
        </div>
        <form action="{{ route('pengajuan-penggajian.update-status', $pengajuan_penggajian->id) }}" method="POST" class="flex gap-2">
            @csrf
            @method('PATCH')
            <button type="submit" name="status" value="Disetujui" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm" onclick="return confirm('Setujui pengajuan ini?')">Setujui</button>
            <button type="submit" name="status" value="Ditolak" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm" onclick="return confirm('Tolak pengajuan ini?')">Tolak</button>
        </form>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 md:p-8 border-b border-gray-100 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Tanggal</p>
                <p class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($pengajuan_penggajian->tanggal)->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">No. Dokumen</p>
                <p class="text-gray-900 font-semibold">{{ $pengajuan_penggajian->no_dokumen ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Departemen</p>
                <p class="text-gray-900 font-semibold">PERKEBUNAN</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kebun / Kebutuhan</p>
                <p class="text-gray-900 font-semibold">{{ $pengajuan_penggajian->kebun->lokasi ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Perihal</p>
                <p class="text-gray-900 font-semibold">{{ $pengajuan_penggajian->perihal }}</p>
            </div>
        </div>

        <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Rincian</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="py-3 px-4 font-semibold text-gray-700 w-[50px] text-center">No</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Uraian</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Banyak Unit</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Harga Satuan</th>
                            <th class="py-3 px-4 font-semibold text-gray-700 text-right">Total Harga</th>
                            <th class="py-3 px-4 font-semibold text-gray-700">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($pengajuan_penggajian->items as $index => $item)
                        <tr>
                            <td class="py-3 px-4 text-center text-gray-500">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-medium text-gray-900 whitespace-pre-wrap">{{ $item->uraian }}</td>
                            <td class="py-3 px-4">{{ $item->banyak_unit ? (float) $item->banyak_unit : '-' }}</td>
                            <td class="py-3 px-4">{{ $item->harga_satuan ? 'Rp ' . number_format($item->harga_satuan, 0, ',', '.') : '-' }}</td>
                            <td class="py-3 px-4 text-right font-medium text-gray-900">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-gray-500">{{ $item->keterangan ?: '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50">
                            <td colspan="4" class="py-4 px-4 text-right font-bold text-gray-800 uppercase tracking-wider">Grand Total</td>
                            <td class="py-4 px-4 text-right font-bold text-emerald-600 text-lg">Rp {{ number_format($pengajuan_penggajian->grand_total, 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
