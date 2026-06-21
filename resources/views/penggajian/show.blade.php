@extends('layouts.app')

@section('title', 'Laporan Penggajian Mingguan')
@section('page-title', 'Laporan Penggajian Mingguan')
@section('page-subtitle', 'Pencatatan dan laporan penggajian harian dan borongan')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Penggajian</h1>
            <p class="mt-2 text-sm text-gray-500">
                Periode: {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->format('d M Y') }}
                &bull; Lokasi: {{ $penggajian->lokasi_kebun }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('penggajian.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('penggajian.print', $penggajian->id) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print PDF
            </a>
        </div>
    </div>

    {{-- Report Display Area --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 overflow-x-auto">
        <div id="printable-area" class="min-w-[900px] text-black">
            
            {{-- Kop Surat --}}
            <div class="flex items-center border-b-2 border-black pb-4 mb-4">
                <div class="w-24 h-24 mr-6">
                    <img src="{{ asset('logo.jpg') }}" alt="TMC Logo" class="w-full h-full object-contain">
                </div>
                <div class="flex-1 text-center">
                    <h1 class="text-3xl font-extrabold tracking-wide mb-1" style="font-family: 'Times New Roman', serif;">PT . TRI MUSTIKA COCOMINAESA ( TMC )</h1>
                    <p class="text-lg font-bold" style="font-family: 'Times New Roman', serif;">Jl. Raya A.K.D Km. 90 Kec. Amurang Barat Kab. Minahasa Selatan</p>
                </div>
                <div class="w-24 h-24 ml-6"></div> {{-- Spacer --}}
            </div>

            {{-- Judul Laporan --}}
            <div class="mb-4">
                <h2 class="text-lg font-bold uppercase">LAPORAN PEKERJAAN MINGGUAN DI KEBUN {{ $penggajian->lokasi_kebun }}</h2>
                <h3 class="text-md font-bold uppercase">PERIODE {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->isoFormat('D') }}-{{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->isoFormat('D MMMM Y') }}</h3>
            </div>

            {{-- Tabel HARIAN --}}
            <div class="mb-2 font-bold text-sm">HARIAN</div>
            <table class="w-full border-collapse border border-black mb-8 text-xs text-center font-bold">
                <thead class="bg-[#FFE600]">
                    <tr>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 30px;">NO.</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 180px;">NAMA</th>
                        <th class="border border-black p-1" colspan="{{ count($period) }}">PERIODE</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 50px;">HARI<br>KERJA</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 90px;">UPAH<br>PER HARI</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 100px;">TOTAL UPAH</th>
                    </tr>
                    <tr>
                        @foreach($period as $date)
                            <th class="border border-black p-1">{{ $date->format('j') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($dataHarian as $data)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-black p-1">{{ $no++ }}</td>
                            <td class="border border-black p-1 text-left uppercase">{{ $data->nama_karyawan }}</td>
                            @foreach($period as $date)
                                <td class="border border-black p-1 relative">
                                    @if(isset($data->rincian_harian[$date->format('Y-m-d')]))
                                        V
                                    @endif
                                </td>
                            @endforeach
                            <td class="border border-black p-1">{{ $data->jumlah_hari_kerja }}</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($penggajian->tarif_harian, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="border border-black p-1 text-left bg-gray-100">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($data->total_upah, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border border-black p-2" colspan="{{ count($period) + 5 }}">Belum ada data harian.</td>
                        </tr>
                    @endforelse
                    
                    {{-- Footer Harian --}}
                    @if(count($dataHarian) > 0)
                    <tr class="bg-gray-50 font-bold border-t-2 border-gray-200">
                        <td colspan="{{ count($period) + 2 }}" class="border border-black p-1 text-right">TOTAL UPAH HARIAN</td>
                        <td colspan="2" class="border border-black p-1 text-left text-emerald-600">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($penggajian->total_upah_harian, 0, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

            {{-- Tabel KUPAS KELAPA --}}
            <div class="mb-2 font-bold text-sm">KUPAS KELAPA</div>
            <table class="w-full border-collapse border border-black mb-8 text-xs text-center font-bold">
                <thead class="bg-[#FFE600]">
                    <tr>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 30px;">NO.</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 180px;">NAMA</th>
                        <th class="border border-black p-1" colspan="{{ count($period) }}">PERIODE</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 70px;">JUMLAH<br>BUTIR</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 90px;">UPAH<br>PER BUTIR</th>
                        <th class="border border-black p-1 align-middle" rowspan="2" style="width: 100px;">TOTAL UPAH</th>
                    </tr>
                    <tr>
                        @foreach($period as $date)
                            <th class="border border-black p-1">{{ $date->format('j') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($dataKupas as $data)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-black p-1">{{ $no++ }}</td>
                            <td class="border border-black p-1 text-left uppercase">{{ $data->nama_karyawan }}</td>
                            @foreach($period as $date)
                                @php
                                    $d = $date->format('Y-m-d');
                                    $vol = isset($data->rincian_harian[$d]) ? $data->rincian_harian[$d] : null;
                                @endphp
                                <td class="border border-black p-1 relative">{{ $vol ? number_format($vol, 0, ',', '.') : '' }}</td>
                            @endforeach
                            <td class="border border-black p-1">{{ number_format($data->jumlah_volume, 0, ',', '.') }}</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($penggajian->tarif_kupas, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="border border-black p-1 text-left bg-gray-100">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($data->total_upah, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border border-black p-2" colspan="{{ count($period) + 5 }}">Belum ada data kupas kelapa.</td>
                        </tr>
                    @endforelse
                    
                    {{-- Footer Kupas --}}
                    @if(count($dataKupas) > 0)
                    <tr class="bg-gray-50 font-bold border-t-2 border-gray-200">
                        <td colspan="{{ count($period) + 2 }}" class="border border-black p-1 text-right">TOTAL UPAH KUPAS</td>
                        <td colspan="2" class="border border-black p-1 text-left text-blue-600">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($penggajian->total_upah_kupas, 0, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>

            {{-- Tabel AKUMULASI --}}
            <div class="w-full md:w-1/2 mt-8">
                <table class="w-full border-collapse border border-black text-xs font-bold">
                    <thead class="bg-[#FFE600] text-center">
                        <tr>
                            <th class="border border-black p-1" colspan="3">AKUMULASI</th>
                        </tr>
                        <tr>
                            <th class="border border-black p-1 w-10">NO</th>
                            <th class="border border-black p-1">KETERANGAN</th>
                            <th class="border border-black p-1 w-40">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-black p-1 text-center">1</td>
                            <td class="border border-black p-1">HARIAN</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($penggajian->total_upah_harian, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-black p-1 text-center">2</td>
                            <td class="border border-black p-1">KUPAS KELAPA</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($penggajian->total_upah_kupas, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr class="bg-gray-800 text-white font-bold">
                            <td class="border border-black p-1" colspan="2">TOTAL KESELURUHAN</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($penggajian->total_keseluruhan, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>

        {{-- Dokumentasi Pekerjaan --}}
        @if(isset($dokumentasi) && count($dokumentasi) > 0)
        <div class="mt-12 border-t border-gray-200 pt-8 no-print">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Dokumentasi Pekerjaan Terkait
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($dokumentasi as $doc)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="aspect-video bg-gray-100 relative overflow-hidden">
                        @if($doc->images->count() > 0)
                            <img src="{{ Storage::url($doc->images->first()->image_path) }}" alt="Thumbnail" class="w-full h-full object-cover">
                            @if($doc->images->count() > 1)
                            <div class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-md backdrop-blur-sm">
                                +{{ $doc->images->count() - 1 }} Foto
                            </div>
                            @endif
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-1">
                            <div class="text-xs font-semibold text-emerald-600">{{ \Carbon\Carbon::parse($doc->tanggal)->format('d M Y') }}</div>
                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">{{ $doc->kebun->lokasi ?? '-' }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1">{{ $doc->judul }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $doc->keterangan ?: 'Tidak ada keterangan' }}</p>
                        <a href="{{ route('dokumentasi.index') }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-700">Lihat Detail &rarr;</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</div>

@push('styles')
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
        }
        .no-print {
            display: none !important;
        }
        /* Make sure backgrounds print */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
@endpush

@endsection
