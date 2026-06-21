@extends('layouts.app')

@section('title', 'Laporan Penggajian Mingguan')
@section('page-title', 'Laporan Penggajian Mingguan')
@section('page-subtitle', 'Pencatatan dan laporan penggajian harian dan borongan')

@section('content')
<div class="space-y-6">

    {{-- Filter Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden no-print">
        <form method="GET" action="{{ route('penggajian.index') }}" class="px-6 py-4">
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
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Tampilkan
                    </button>
                    <button type="submit" formtarget="_blank" formaction="{{ route('penggajian.print') }}" class="ml-2 inline-flex items-center gap-2 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Print Laporan
                    </button>
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
                    @php $no = 1; $grandTotalHari = 0; @endphp
                    @forelse($dataHarian as $karyawanId => $data)
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
                        @php $grandTotalHari += $data['total_hari']; @endphp
                    @empty
                        <tr>
                            <td class="border border-black p-2" colspan="{{ count($period) + 5 }}">Belum ada data harian.</td>
                        </tr>
                    @endforelse
                    
                    {{-- Footer Harian --}}
                    @if(count($dataHarian) > 0)
                    <tr>
                        <td class="border border-black p-1 text-center uppercase" colspan="2">JUMLAH</td>
                        @foreach($period as $date)
                            <td class="border border-black p-1 bg-gray-100"></td>
                        @endforeach
                        <td class="border border-black p-1">{{ $grandTotalHari }}</td>
                        <td class="border border-black p-1 text-left">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($tarifHarian, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="border border-black p-1 text-left bg-gray-100">
                            <div class="flex justify-between">
                                <span>Rp</span>
                                <span>{{ number_format($totalUpahHarian, 0, ',', '.') }}</span>
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
                                <td class="border border-black p-1 relative">{{ $vol }}</td>
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
