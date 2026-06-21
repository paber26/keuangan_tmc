<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penggajian - {{ $penggajian->lokasi_kebun }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10pt; 
            margin: 0;
            padding: 0;
            background: #f0f0f0;
        }
        .page-container {
            background: #fff;
            max-width: 210mm;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        @media print {
            body { background: #fff; }
            .page-container { margin: 0; padding: 0; box-shadow: none; max-width: none; }
            @page { size: A4 portrait; margin: 10mm; }
            .no-print { display: none !important; }
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

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #000; color: #fff; border: none; border-radius: 5px;">Print Laporan (Ctrl+P)</button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; background: #666; color: #fff; border: none; border-radius: 5px; margin-left: 10px;">Tutup</button>
    </div>

<div class="page-container">

    <div class="kop-surat">
        <img src="{{ asset('logo.jpg') }}" class="logo" alt="Logo">
        <div style="padding-left: 80px; padding-right: 80px;">
            <h1 class="kop-title">PT . TRI MUSTIKA COCOMINAESA ( TMC )</h1>
            <p class="kop-address">Jl. Raya A.K.D Km. 90 Kec. Amurang Barat Kab. Minahasa Selatan</p>
        </div>
    </div>

    <div class="judul-laporan">
            <h2 style="font-size: 14px; margin: 0; padding: 0;">LAPORAN PEKERJAAN MINGGUAN DI KEBUN {{ $penggajian->lokasi_kebun }}</h2>
            <p style="margin: 0;"><b>Periode:</b> {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->format('d M Y') }}</p>
        <p style="margin: 0;"><b>Lokasi:</b> {{ $penggajian->lokasi_kebun }}</p>
    </div>

    <!-- HARIAN -->
    @php
        $groupedHarian = $dataHarian->groupBy('jabatan');
    @endphp
    
    @if(count($dataHarian) > 0)
        @foreach($groupedHarian as $jabatan => $items)
        <div class="section-title" style="{{ $loop->first ? '' : 'margin-top: 20px;' }}">HARIAN - {{ strtoupper($jabatan ?: 'TIDAK DIKETAHUI') }}</div>
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
                @php $no = 1; $subTotalHari = 0; $subTotalUpah = 0; @endphp
                @foreach($items as $data)
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
                    @php 
                        $subTotalHari += $data->jumlah_hari_kerja;
                        $subTotalUpah += $data->total_upah;
                    @endphp
                @endforeach
                <tr>
                    <td class="text-center uppercase" colspan="{{ count($period) + 2 }}" style="font-weight: bold;">JUMLAH</td>
                    <td class="text-center" style="font-weight: bold;">{{ $subTotalHari }}</td>
                    <td class="text-left" style="font-weight: bold;">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($penggajian->tarif_harian, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                    <td class="text-left bg-gray" style="font-weight: bold;">
                        <div class="currency">
                            <span class="curr-sym">Rp</span>
                            <span class="curr-val">{{ number_format($subTotalUpah, 0, ',', '.') }}</span>
                            <div class="clear"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        @endforeach
        
        <table style="margin-top: -1px;">
            <tr class="totals-row">
                <td colspan="{{ count($period) + 4 }}" style="text-align: right; padding-right: 10px;">TOTAL UPAH HARIAN</td>
                <td colspan="1" style="text-align: left; background-color: #f3f4f6;">
                    <div class="currency">
                        <span class="curr-sym">Rp</span>
                        <span class="curr-val">{{ number_format($penggajian->total_upah_harian, 0, ',', '.') }}</span>
                        <div class="clear"></div>
                    </div>
                </td>
            </tr>
        </table>
    @else
        <div class="section-title">HARIAN</div>
        <table>
            <tr>
                <td class="text-center" colspan="{{ count($period) + 4 }}">Belum ada data harian.</td>
            </tr>
        </table>
    @endif

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
                <td colspan="{{ count($period) + 4 }}" style="text-align: right; padding-right: 10px;">TOTAL UPAH KUPAS</td>
                <td colspan="1" style="text-align: left; background-color: #f3f4f6;">
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

    @if(isset($dokumentasi) && count($dokumentasi) > 0)
    <div class="page-break"></div>
    <div class="kop-surat">
        <img src="{{ asset('logo.jpg') }}" class="logo" alt="Logo">
        <div style="padding-left: 80px; padding-right: 80px;">
            <h1 class="kop-title">PT . TRI MUSTIKA COCOMINAESA ( TMC )</h1>
            <p class="kop-address">Jl. Raya A.K.D Km. 90 Kec. Amurang Barat Kab. Minahasa Selatan</p>
        </div>
    </div>

    @foreach($period as $date)
        @php
            $dateStr = $date->format('Y-m-d');
            $docsForDate = isset($dokumentasi[$dateStr]) ? $dokumentasi[$dateStr] : collect();
            
            // Get people who worked Harian on this date
            $harianNames = [];
            foreach($dataHarian as $harian) {
                if(isset($harian->rincian_harian[$dateStr])) {
                    $nameParts = explode(' ', trim($harian->nama_karyawan));
                    $harianNames[] = $nameParts[0]; // Get first name
                }
            }
        @endphp

        @if($docsForDate->count() > 0)
            <div style="margin-top: 20px;">
                <h3 style="font-size: 14pt; margin-bottom: 10px;">{{ $date->format('j-n-y') }}</h3>
                @if(count($harianNames) > 0)
                    <p style="font-size: 12pt; font-weight: bold; text-transform: uppercase; margin-bottom: 10px;">HARIAN ( {{ implode(', ', $harianNames) }} )</p>
                @endif
                
                <div style="width: 100%;">
                    <table style="width: 100%; border: none; margin: 0; padding: 0;">
                        <tr>
                    @php $imgCount = 0; @endphp
                    @foreach($docsForDate as $doc)
                        @foreach($doc->images as $img)
                            @if($imgCount > 0 && $imgCount % 2 == 0)
                                </tr><tr>
                            @endif
                            <td style="border: none; padding: 5px; width: 50%; vertical-align: top; text-align: center;">
                                <img src="{{ Storage::url($img->image_path) }}" style="width: 95%; height: auto; border-radius: 4px; border: 1px solid #ddd;">
                            </td>
                            @php $imgCount++; @endphp
                        @endforeach
                    @endforeach
                        </tr>
                    </table>
                </div>
            </div>
        @endif
    @endforeach
    @endif

</div>

<script>
    window.onload = function() {
        // Otomatis print saat halaman selesai dimuat
        setTimeout(function() {
            window.print();
        }, 500);
    }
</script>
</body>
</html>
