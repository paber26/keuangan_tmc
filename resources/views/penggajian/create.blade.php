@extends('layouts.app')

@section('title', 'Laporan Penggajian Mingguan')
@section('page-title', 'Laporan Penggajian Mingguan')
@section('page-subtitle', 'Pencatatan dan laporan penggajian harian dan borongan')

@section('content')
<div class="space-y-6">

    {{-- Filter Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <form method="GET" action="{{ route('penggajian.create') }}" class="p-6">
            <div class="flex flex-wrap items-end gap-4">
                <div class="min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kebun</label>
                    <select name="lokasi" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        @foreach($lokasiList as $lokasi)
                            <option value="{{ $lokasi }}" {{ $selectedLokasi == $lokasi ? 'selected' : '' }}>
                                {{ $lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarif Harian (Rp)</label>
                    <input type="number" name="tarif_harian" value="{{ $tarifHarian }}" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tarif Kupas/Butir (Rp)</label>
                    <input type="number" name="tarif_kupas" value="{{ $tarifKupas }}" class="w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <button type="submit" class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Hitung
                    </button>
                    <a href="{{ route('penggajian.create') }}" class="flex-none inline-flex justify-center items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-colors" title="Reset">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            </div>
        </form>
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
                <h2 class="text-lg font-bold uppercase">LAPORAN PEKERJAAN MINGGUAN DI KEBUN {{ $selectedLokasi }}</h2>
                <h3 class="text-md font-bold uppercase">PERIODE {{ \Carbon\Carbon::parse($startDate)->isoFormat('D') }}-{{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y') }}</h3>
            </div>

            {{-- Tabel HARIAN --}}
            @php
                $groupedHarian = collect($dataHarian)->groupBy('jabatan');
            @endphp
            
            @if(count($dataHarian) > 0)
                @foreach($groupedHarian as $jabatan => $items)
                <div class="mb-2 font-bold text-sm {{ $loop->first ? '' : 'mt-6' }}">HARIAN - {{ strtoupper($jabatan) }}</div>
                <table class="w-full border-collapse border border-black mb-4 text-xs text-center font-bold">
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
                        @php $no = 1; $subTotalHari = 0; $subTotalUpah = 0; @endphp
                        @foreach($items as $data)
                            <tr>
                                <td class="border border-black p-1">{{ $no++ }}</td>
                                <td class="border border-black p-1 text-left uppercase">{{ $data['nama'] }}</td>
                                @foreach($period as $date)
                                    <td class="border border-black p-1 relative">
                                        @if(isset($data['hari'][$date->format('Y-m-d')]))
                                            V
                                        @endif
                                    </td>
                                @endforeach
                                <td class="border border-black p-1">{{ $data['total_hari'] }}</td>
                                <td class="border border-black p-1 text-left">
                                    <div class="flex justify-between">
                                        <span>Rp</span>
                                        <span>{{ number_format($tarifHarian, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                                <td class="border border-black p-1 text-left bg-gray-100">
                                    <div class="flex justify-between">
                                        <span>Rp</span>
                                        <span>{{ number_format($data['total_upah'], 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                            @php 
                                $subTotalHari += $data['total_hari'];
                                $subTotalUpah += $data['total_upah'];
                            @endphp
                        @endforeach
                        
                        <tr>
                            <td class="border border-black p-1 text-center uppercase" colspan="{{ count($period) + 2 }}">JUMLAH</td>
                            <td class="border border-black p-1">{{ $subTotalHari }}</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($tarifHarian, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="border border-black p-1 text-left bg-gray-100">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($subTotalUpah, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                @endforeach
                
                <table class="w-full border-collapse border border-black mb-8 text-xs text-center font-bold">
                    <tr>
                        <td class="border border-black p-1 text-right uppercase font-bold pr-4" colspan="{{ count($period) + 4 }}">TOTAL UPAH HARIAN</td>
                        <td class="border border-black p-1 text-left font-bold text-emerald-600 bg-emerald-50">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($totalUpahHarian, 0, ',', '.') }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
            @else
                <div class="mb-2 font-bold text-sm">HARIAN</div>
                <table class="w-full border-collapse border border-black mb-8 text-xs text-center font-bold">
                    <tr><td class="border border-black p-2 text-center" colspan="{{ count($period) + 5 }}">Belum ada data harian.</td></tr>
                </table>
            @endif

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
                    @php $no = 1; $grandTotalButir = 0; $sumPerHari = []; @endphp
                    @foreach($period as $date) @php $sumPerHari[$date->format('Y-m-d')] = 0; @endphp @endforeach

                    @forelse($dataKupas as $karyawanId => $data)
                        <tr>
                            <td class="border border-black p-1">{{ $no++ }}</td>
                            <td class="border border-black p-1 text-left uppercase">{{ $data['nama'] }}</td>
                            @foreach($period as $date)
                                @php
                                    $d = $date->format('Y-m-d');
                                    $vol = isset($data['hari'][$d]) ? $data['hari'][$d] : '';
                                    if ($vol) { $sumPerHari[$d] += $vol; }
                                @endphp
                                <td class="border border-black p-1 relative">{{ $vol ? number_format($vol, 0, ',', '.') : '' }}</td>
                            @endforeach
                            <td class="border border-black p-1">{{ number_format($data['total_butir'], 0, ',', '.') }}</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($tarifKupas, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="border border-black p-1 text-left bg-gray-100">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($data['total_upah'], 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                        @php $grandTotalButir += $data['total_butir']; @endphp
                    @empty
                        <tr>
                            <td class="border border-black p-2" colspan="{{ count($period) + 5 }}">Belum ada data kupas kelapa.</td>
                        </tr>
                    @endforelse
                    
                    {{-- Footer Kupas --}}
                    @if(count($dataKupas) > 0)
                    <tr>
                        <td class="border border-black p-1 text-left uppercase" colspan="2">JUMLAH</td>
                        @foreach($period as $date)
                            @php $d = $date->format('Y-m-d'); @endphp
                            <td class="border border-black p-1 bg-gray-100">{{ $sumPerHari[$d] > 0 ? number_format($sumPerHari[$d], 0, ',', '.') : '0' }}</td>
                        @endforeach
                        <td class="border border-black p-1">{{ number_format($grandTotalButir, 0, ',', '.') }}</td>
                        <td class="border border-black p-1 text-left">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($tarifKupas, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="border border-black p-1 text-left bg-gray-100">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($totalUpahKupas, 0, ',', '.') }}</span>
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
                                    <span>{{ number_format($totalUpahHarian, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-black p-1 text-center">2</td>
                            <td class="border border-black p-1">KUPAS KELAPA</td>
                            <td class="border border-black p-1 text-left">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($totalUpahKupas, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="border border-black p-1 border-t-2" colspan="2"></td>
                            <td class="border border-black p-1 border-t-2 text-left bg-gray-100">
                                <div class="flex justify-between">
                                    <span>Rp</span>
                                    <span>{{ number_format($totalUpahHarian + $totalUpahKupas, 0, ',', '.') }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>

        @if(!empty($dataHarian) || !empty($dataKupas))
            <div class="mt-8 flex justify-end pb-8">
                <form action="{{ route('penggajian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tanggal_mulai" value="{{ $startDate }}">
                    <input type="hidden" name="tanggal_akhir" value="{{ $endDate }}">
                    <input type="hidden" name="lokasi_kebun" value="{{ $selectedLokasi }}">
                    <input type="hidden" name="tarif_harian" value="{{ $tarifHarian }}">
                    <input type="hidden" name="tarif_kupas" value="{{ $tarifKupas }}">
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all focus:ring-4 focus:ring-blue-100 text-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Simpan Penggajian
                    </button>
                </form>
            </div>
        @endif
        
        {{-- Dokumentasi Pekerjaan --}}
        @if(isset($dokumentasi) && count($dokumentasi) > 0)
        <div class="mt-8 border-t border-gray-200 pt-8 no-print">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Dokumentasi Pekerjaan Terkait
            </h3>
            @foreach($dokumentasi as $dateStr => $docsForDate)
            <div class="mb-8">
                <h4 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">{{ \Carbon\Carbon::parse($dateStr)->translatedFormat('l, d F Y') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($docsForDate as $doc)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="aspect-video bg-gray-100 relative overflow-hidden">
                            @if($doc->images->count() > 0)
                                <img src="{{ Storage::url($doc->images->first()->image_path) }}" alt="Thumbnail" class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300" onclick="zoomImage('{{ Storage::url($doc->images->first()->image_path) }}', '{{ addslashes($doc->judul) }}')">
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
                                <div class="text-xs font-semibold text-emerald-600">{{ \Carbon\Carbon::parse($doc->tanggal)->format('H:i') }} WIB</div>
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
            @endforeach
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

@push('scripts')
<script>
function zoomImage(url, title) {
    Swal.fire({
        imageUrl: url,
        imageAlt: title,
        showConfirmButton: false,
        showCloseButton: true,
        width: 'auto',
        padding: '1em',
        backdrop: `rgba(0,0,0,0.8)`
    });
}
</script>
@endpush

@endsection
