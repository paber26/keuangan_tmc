@extends('layouts.app')
@section('title', 'Detail Pengajuan Barang')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <a href="{{ route('pengajuan.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Invoice Pengajuan</h2>
            <p class="text-sm text-gray-500 mt-1">Ref: INV-{{ str_pad($pengajuan->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" id="printable-area">
        <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between gap-6">
            <div>
                <h3 class="text-xl font-bold text-emerald-800 mb-1">TMC Finance</h3>
                <p class="text-sm text-gray-500">Form Pengajuan Barang & Keperluan</p>
            </div>
            <div class="text-left md:text-right">
                <table class="text-sm">
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Tanggal</td>
                        <td class="font-medium text-gray-800 pb-1">: {{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Keperluan</td>
                        <td class="font-medium text-gray-800 pb-1">: {{ $pengajuan->judul_pengajuan }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4">Status</td>
                        <td class="font-medium text-gray-800">: 
                            <span class="{{ $pengajuan->status == 'Disetujui' ? 'text-emerald-600' : ($pengajuan->status == 'Ditolak' ? 'text-red-600' : 'text-amber-600') }}">
                                {{ $pengajuan->status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        @if($pengajuan->keterangan)
        <div class="px-8 py-4 bg-gray-50/50 border-b border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Catatan Tambahan</p>
            <p class="text-sm text-gray-700">{{ $pengajuan->keterangan }}</p>
        </div>
        @endif

        <div class="p-8">
            <div class="overflow-x-auto border border-gray-800">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#3B6653] text-white">
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[50px] text-center">No</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800">Nama Barang / Deskripsi</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[120px] text-center">Jumlah (Qty)</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[180px] text-center">Harga Satuan (Rp)</th>
                            <th class="py-2.5 px-4 text-sm font-semibold w-[200px] text-center">Total Harga (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 bg-white">
                        @php $totalQty = 0; @endphp
                        @foreach($pengajuan->items as $index => $item)
                        @php $totalQty += $item->qty; @endphp
                        <tr>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-center border-r border-gray-800">{{ $index + 1 }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 border-r border-gray-800">{{ $item->nama_barang }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-center border-r border-gray-800">{{ number_format($item->qty, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-right border-r border-gray-800">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-right">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 border-t border-gray-800">
                            <td colspan="2" class="py-3 px-4 text-sm font-bold text-gray-800 uppercase border-r border-gray-800">GRAND TOTAL</td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-center border-r border-gray-800">{{ number_format($totalQty, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 border-r border-gray-800"></td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-right">{{ number_format($pengajuan->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printable-area, #printable-area * {
        visibility: visible;
    }
    #printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        border: none;
        box-shadow: none;
    }
}
</style>
@endsection
