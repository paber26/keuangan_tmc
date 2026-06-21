<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penggajian - {{ $selectedLokasi }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10pt; 
            margin: 0;
            padding: 0;
        }
        
        /* Kop Surat */
        .kop-surat {
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 15px;
            text-align: center;
            position: relative;
        }
        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }
        .kop-title {
            font-family: 'Times New Roman', serif;
            font-size: 18pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }
        .kop-address {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
        }
        
        /* Judul */
        .judul-laporan {
            margin-bottom: 15px;
        }
        .judul-laporan h2 {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 3px 0;
        }
        .judul-laporan h3 {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }
        
        /* Tables */
        .section-title {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
            margin-top: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-weight: bold;
            font-size: 9pt;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
        }
        th {
            background-color: #FFE600;
            text-align: center;
            vertical-align: middle;
        }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .uppercase { text-transform: uppercase; }
        .bg-gray { background-color: #f3f4f6; }
        
        .currency {
            position: relative;
            width: 100%;
        }
        .curr-sym { float: left; }
        .curr-val { float: right; }
        .clear { clear: both; }
        
        .akumulasi-container {
            width: 50%;
            margin-top: 20px;
        }
        
        /* Page break rule if needed */
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <!-- Assuming logo.jpg is in public path. DomPDF requires absolute local path usually, but asset() might work depending on setup -->
        <img src="{{ public_path('logo.jpg') }}" class="logo" alt="Logo">
        <div style="padding-left: 90px; padding-right: 90px;">
            <h1 class="kop-title">PT . TRI MUSTIKA COCOMINAESA ( TMC )</h1>
            <p class="kop-address">Jl. Raya A.K.D Km. 90 Kec. Amurang Barat Kab. Minahasa Selatan</p>
        </div>
    </div>

    <div class="judul-laporan">
        <h2>LAPORAN PEKERJAAN MINGGUAN DI KEBUN {{ $selectedLokasi }}</h2>
        <h3>PERIODE {{ \Carbon\Carbon::parse($startDate)->isoFormat('D') }}-{{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y') }}</h3>
    </div>

    <!-- HARIAN -->
    <div class="section-title">HARIAN</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 25px;">NO.</th>
                <th rowspan="2" style="width: 130px;">NAMA</th>
                <th colspan="{{ count($period) }}">PERIODE</th>
                <th rowspan="2" style="width: 40px;">HARI<br>KERJA</th>
                <th rowspan="2" style="width: 80px;">UPAH<br>PER HARI</th>
                <th rowspan="2" style="width: 90px;">TOTAL UPAH</th>
            </tr>
            <tr>
                @foreach($period as $date)
                    <th>{{ $date->format('j') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $grandTotalHari = 0; @endphp
            @forelse($dataHarian as $karyawanId => $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-left uppercase">{{ $data['nama'] }}</td>
                    @foreach($period as $date)
                        <td class="text-center">
                            @if(isset($data['hari'][$date->format('Y-m-d')]))
                                V
                            @endif
                        </td>
                    @endforeach
                    <td class="text-center">{{ $data['total_hari'] }}</td>
                    <td class="text-left">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($tarifHarian, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                    <td class="text-left bg-gray">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($data['total_upah'], 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                @php $grandTotalHari += $data['total_hari']; @endphp
            @empty
                <tr>
                    <td class="text-center" colspan="{{ count($period) + 5 }}">Belum ada data harian.</td>
                </tr>
            @endforelse
            
            @if(count($dataHarian) > 0)
            <tr>
                <td class="text-center uppercase" colspan="2">JUMLAH</td>
                @foreach($period as $date)
                    <td class="bg-gray"></td>
                @endforeach
                <td class="text-center">{{ $grandTotalHari }}</td>
                <td class="text-left">
                    <div class="currency">
                        <span class="curr-sym">Rp</span>
                        <span class="curr-val">{{ number_format($tarifHarian, 0, ',', '.') }}</span>
                        <div class="clear"></div>
                    </div>
                </td>
                <td class="text-left bg-gray">
                    <div class="currency">
                        <span class="curr-sym">Rp</span>
                        <span class="curr-val">{{ number_format($totalUpahHarian, 0, ',', '.') }}</span>
                        <div class="clear"></div>
                    </div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- KUPAS KELAPA -->
    <div class="section-title">KUPAS KELAPA</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 25px;">NO.</th>
                <th rowspan="2" style="width: 130px;">NAMA</th>
                <th colspan="{{ count($period) }}">PERIODE</th>
                <th rowspan="2" style="width: 60px;">JUMLAH<br>BUTIR</th>
                <th rowspan="2" style="width: 80px;">UPAH<br>PER BUTIR</th>
                <th rowspan="2" style="width: 90px;">TOTAL UPAH</th>
            </tr>
            <tr>
                @foreach($period as $date)
                    <th>{{ $date->format('j') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $grandTotalButir = 0; $sumPerHari = []; @endphp
            @foreach($period as $date) @php $sumPerHari[$date->format('Y-m-d')] = 0; @endphp @endforeach

            @forelse($dataKupas as $karyawanId => $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-left uppercase">{{ $data['nama'] }}</td>
                    @foreach($period as $date)
                        @php
                            $d = $date->format('Y-m-d');
                            $vol = isset($data['hari'][$d]) ? $data['hari'][$d] : '';
                            if ($vol) { $sumPerHari[$d] += $vol; }
                        @endphp
                        <td class="text-center">{{ $vol }}</td>
                    @endforeach
                    <td class="text-center">{{ number_format($data['total_butir'], 0, ',', '.') }}</td>
                    <td class="text-left">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($tarifKupas, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                    <td class="text-left bg-gray">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($data['total_upah'], 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                @php $grandTotalButir += $data['total_butir']; @endphp
            @empty
                <tr>
                    <td class="text-center" colspan="{{ count($period) + 5 }}">Belum ada data kupas kelapa.</td>
                </tr>
            @endforelse
            
            @if(count($dataKupas) > 0)
            <tr>
                <td class="text-left uppercase" colspan="2">JUMLAH</td>
                @foreach($period as $date)
                    @php $d = $date->format('Y-m-d'); @endphp
                    <td class="text-center bg-gray">{{ $sumPerHari[$d] > 0 ? number_format($sumPerHari[$d], 0, ',', '.') : '0' }}</td>
                @endforeach
                <td class="text-center">{{ number_format($grandTotalButir, 0, ',', '.') }}</td>
                <td class="text-left">
                    <div class="currency">
                        <span class="curr-sym">Rp</span>
                        <span class="curr-val">{{ number_format($tarifKupas, 0, ',', '.') }}</span>
                        <div class="clear"></div>
                    </div>
                </td>
                <td class="text-left bg-gray">
                    <div class="currency">
                        <span class="curr-sym">Rp</span>
                        <span class="curr-val">{{ number_format($totalUpahKupas, 0, ',', '.') }}</span>
                        <div class="clear"></div>
                    </div>
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <!-- AKUMULASI -->
    <div class="akumulasi-container">
        <table>
            <thead>
                <tr>
                    <th colspan="3">AKUMULASI</th>
                </tr>
                <tr>
                    <th style="width: 30px;">NO</th>
                    <th>KETERANGAN</th>
                    <th style="width: 120px;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-left">HARIAN</td>
                    <td class="text-left">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($totalUpahHarian, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td class="text-left">KUPAS KELAPA</td>
                    <td class="text-left">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($totalUpahKupas, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top: 2px solid black;"></td>
                    <td class="text-left bg-gray" style="border-top: 2px solid black;">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($totalUpahHarian + $totalUpahKupas, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
