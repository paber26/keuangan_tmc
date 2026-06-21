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
            font-size: 16pt;
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
            font-size: 7.5pt;
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
        <div style="padding-left: 80px; padding-right: 80px;">
            <h1 class="kop-title">PT . TRI MUSTIKA COCOMINAESA ( TMC )</h1>
            <p class="kop-address">Jl. Raya A.K.D Km. 90 Kec. Amurang Barat Kab. Minahasa Selatan</p>
        </div>
    </div>

    <div class="judul-laporan">
        <h2>LAPORAN PEKERJAAN MINGGUAN DI KEBUN {{ $selectedLokasi }}</h2>
        <p style="margin: 0;"><b>Periode:</b> {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->format('d M Y') }}</p>
        <p style="margin: 0;"><b>Lokasi:</b> {{ $penggajian->lokasi_kebun }}</p>
    </div>

    <!-- HARIAN -->
    <div class="section-title">HARIAN</div>
    <table>
        <thead>
            <tr>
                <th rowspan="2" style="width: 20px;">NO.</th>
                <th rowspan="2" style="width: 110px;">NAMA</th>
                <th colspan="{{ count($period) }}">PERIODE</th>
                <th rowspan="2" style="width: 35px;">HARI<br>KERJA</th>
                <th rowspan="2" style="width: 65px;">UPAH<br>PER HARI</th>
                <th rowspan="2" style="width: 80px;">TOTAL UPAH</th>
            </tr>
            <tr>
                @foreach($period as $date)
                    <th>{{ $date->format('j') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($dataHarian as $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-left uppercase">{{ $data->nama_karyawan }}</td>
                    @foreach($period as $date)
                        <td class="text-center">
                            @if(isset($data->rincian_harian[$date->format('Y-m-d')]))
                                V
                            @endif
                        </td>
                    @endforeach
                    <td class="text-center">{{ $data->jumlah_hari_kerja }}</td>
                    <td class="text-left">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($penggajian->tarif_harian, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                    <td class="text-left bg-gray">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($data->total_upah, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="{{ count($period) + 5 }}">Belum ada data harian.</td>
                </tr>
            @endforelse
            
            @if(count($dataHarian) > 0)
            <tr class="totals-row">
                <td colspan="{{ count($period) + 2 }}" style="text-align: right;">TOTAL UPAH HARIAN</td>
                <td colspan="2" style="text-align: left;">
                    <div class="currency">
                        <span class="curr-sym">Rp</span>
                        <span class="curr-val">{{ number_format($penggajian->total_upah_harian, 0, ',', '.') }}</span>
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
                <th rowspan="2" style="width: 20px;">NO.</th>
                <th rowspan="2" style="width: 110px;">NAMA</th>
                <th colspan="{{ count($period) }}">PERIODE</th>
                <th rowspan="2" style="width: 45px;">JUMLAH<br>BUTIR</th>
                <th rowspan="2" style="width: 65px;">UPAH<br>PER BUTIR</th>
                <th rowspan="2" style="width: 80px;">TOTAL UPAH</th>
            </tr>
            <tr>
                @foreach($period as $date)
                    <th>{{ $date->format('j') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse($dataKupas as $data)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-left uppercase">{{ $data->nama_karyawan }}</td>
                    @foreach($period as $date)
                        @php
                            $d = $date->format('Y-m-d');
                            $vol = isset($data->rincian_harian[$d]) ? $data->rincian_harian[$d] : null;
                        @endphp
                        <td class="text-center">{{ $vol ? number_format($vol, 0, ',', '.') : '' }}</td>
                    @endforeach
                    <td class="text-center">{{ number_format($data->jumlah_volume, 0, ',', '.') }}</td>
                    <td class="text-left">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($penggajian->tarif_kupas, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                    <td class="text-left bg-gray">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($data->total_upah, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="{{ count($period) + 5 }}">Belum ada data kupas kelapa.</td>
                </tr>
            @endforelse
            
            @if(count($dataKupas) > 0)
            <tr class="totals-row">
                <td colspan="{{ count($period) + 2 }}" style="text-align: right;">TOTAL UPAH KUPAS</td>
                <td colspan="2" style="text-align: left;">
                    <div class="currency">
                        <span class="curr-sym">Rp</span>
                        <span class="curr-val">{{ number_format($penggajian->total_upah_kupas, 0, ',', '.') }}</span>
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
                    <th colspan="2">AKUMULASI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">Upah Harian</td>
                    <td style="text-align: left;">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($penggajian->total_upah_harian, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">Upah Kupas Kelapa</td>
                    <td style="text-align: left;">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($penggajian->total_upah_kupas, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
                <tr class="totals-row">
                    <td style="text-align: right;">TOTAL KESELURUHAN</td>
                    <td style="text-align: left; background-color: #f3f4f6;">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($penggajian->total_keseluruhan, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>
</html>
