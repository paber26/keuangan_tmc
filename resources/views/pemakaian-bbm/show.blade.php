@extends('layouts.app')
@section('page-title', 'Detail Laporan Pemakaian BBM')

@section('content')
<div class="w-full pb-10">
    <div class="mb-8">
        <a href="{{ route('pemakaian-bbm.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Detail Laporan Pemakaian BBM</h2>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg shadow-sm transition-all print:hidden">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden print:shadow-none print:border-none">
        <div class="p-6 md:p-8 border-b border-gray-100 print:border-b-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Lokasi Kebun</p>
                    <p class="text-base font-semibold text-emerald-600">{{ $pemakaian_bbm->kebun ? $pemakaian_bbm->kebun->lokasi : '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Nama Pengambil (Karyawan)</p>
                    <p class="text-base font-semibold text-emerald-600">{{ $pemakaian_bbm->karyawan ? $pemakaian_bbm->karyawan->nama : '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Tanggal Laporan</p>
                    <p class="text-base font-semibold text-gray-800">{{ \Carbon\Carbon::parse($pemakaian_bbm->tanggal)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Judul Laporan</p>
                    <p class="text-base font-semibold text-gray-800">{{ $pemakaian_bbm->judul_laporan }}</p>
                </div>
                @if($pemakaian_bbm->keterangan)
                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500 mb-1">Keterangan Tambahan</p>
                    <p class="text-base text-gray-800">{{ $pemakaian_bbm->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="p-6 md:p-8">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Rincian Pemakaian</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-y border-gray-200">
                            <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">No</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe BBM</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan Pemakaian</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">Liter</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">Harga / Liter</th>
                            <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($pemakaian_bbm->items as $index => $item)
                        <tr>
                            <td class="py-4 px-4 text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                            <td class="py-4 px-4 text-sm font-medium text-gray-800">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                            <td class="py-4 px-4 text-sm font-medium text-gray-800">{{ $item->tipe_bbm }}</td>
                            <td class="py-4 px-4 text-sm font-medium text-gray-800">{{ $item->keterangan_pemakaian }}</td>
                            <td class="py-4 px-4 text-sm text-gray-600 text-right">{{ number_format($item->jumlah_liter, 2, ',', '.') }} L</td>
                            <td class="py-4 px-4 text-sm text-gray-600 text-right">Rp {{ number_format($item->harga_per_liter, 0, ',', '.') }}</td>
                            <td class="py-4 px-4 text-sm font-semibold text-gray-800 text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 border-t-2 border-gray-200">
                            <td colspan="6" class="py-4 px-4 text-sm font-bold text-gray-800 uppercase text-right tracking-wider">Total</td>
                            <td class="py-4 px-4 text-right text-lg font-bold text-emerald-600">
                                Rp {{ number_format($pemakaian_bbm->grand_total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
