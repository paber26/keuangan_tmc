<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td colspan="2" rowspan="3" style="text-align: center; vertical-align: middle; height: 60px;">
                    <!-- Logo will be injected by WithDrawings at A1 -->
                </td>
                <td colspan="10" style="font-weight: bold; font-size: 16px; font-family: 'Times New Roman', serif;">PT . TRI MUSTIKA COCOMINAESA ( TMC )</td>
            </tr>
            <tr>
                <td colspan="10" style="font-weight: bold; font-size: 11px; font-family: 'Times New Roman', serif;">Jl. Raya A.K.D Km. 90 Kec. Amurang Barat Kab. Minahasa Selatan</td>
            </tr>
            <tr>
                <td colspan="10"></td>
            </tr>
            <tr>
                <td colspan="12"></td>
            </tr>
            <tr>
                <td colspan="12" style="font-weight: bold; font-size: 12px; text-transform: uppercase;">LAPORAN PEKERJAAN MINGGUAN DI KEBUN {{ $selectedLokasi }}</td>
            </tr>
            <tr>
                <td colspan="12" style="font-weight: bold; font-size: 11px; text-transform: uppercase;">PERIODE {{ \Carbon\Carbon::parse($startDate)->isoFormat('D') }}-{{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y') }}</td>
            </tr>
            <tr>
                <td colspan="12"></td>
            </tr>

            <!-- HARIAN -->
            @if(count($dataHarian) > 0)
            <tr>
                <td colspan="{{ count($period) + 5 }}" style="font-weight: bold; text-transform: uppercase;">HARIAN</td>
            </tr>
            <tr>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">NO.</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">NAMA</th>
                <th colspan="{{ count($period) }}" style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">PERIODE</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">HARI KERJA</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">UPAH PER HARI</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">TOTAL UPAH</th>
            </tr>
            <tr>
                @foreach($period as $date)
                    <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">{{ $date->format('j') }}</th>
                @endforeach
            </tr>
            @php $no = 1; $grandTotalHari = 0; @endphp
            @foreach($dataHarian as $karyawanId => $data)
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
                    <td style="border: 1px solid #000; text-transform: uppercase;">{{ $data['nama'] }}</td>
                    @foreach($period as $date)
                        <td style="border: 1px solid #000; text-align: center;">
                            @if(isset($data['hari'][$date->format('Y-m-d')]))
                                V
                            @endif
                        </td>
                    @endforeach
                    <td style="border: 1px solid #000; text-align: center;">{{ $data['total_hari'] }}</td>
                    <td style="border: 1px solid #000; text-align: right;">{{ $tarifHarian }}</td>
                    <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f3f4f6;">{{ $data['total_upah'] }}</td>
                </tr>
                @php $grandTotalHari += $data['total_hari']; @endphp
            @endforeach
            <tr>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; text-transform: uppercase;">JUMLAH</td>
                @foreach($period as $date)
                    <td style="border: 1px solid #000; background-color: #f3f4f6;"></td>
                @endforeach
                <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $grandTotalHari }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $tarifHarian }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right; background-color: #f3f4f6;">{{ $totalUpahHarian }}</td>
            </tr>
            <tr>
                <td colspan="12"></td>
            </tr>
            @endif

            <!-- KUPAS KELAPA -->
            @if(isset($dataKupas) && count($dataKupas) > 0)
            <tr>
                <td colspan="{{ count($period) + 5 }}" style="font-weight: bold; text-transform: uppercase;">KUPAS KELAPA</td>
            </tr>
            <tr>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">NO.</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">NAMA</th>
                <th colspan="{{ count($period) }}" style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">PERIODE</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">JUMLAH BUTIR</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">UPAH PER BUTIR</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">TOTAL UPAH</th>
            </tr>
            <tr>
                @foreach($period as $date)
                    <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">{{ $date->format('j') }}</th>
                @endforeach
            </tr>
            @php $no = 1; $grandTotalButir = 0; $sumPerHari = []; @endphp
            @foreach($period as $date) @php $sumPerHari[$date->format('Y-m-d')] = 0; @endphp @endforeach

            @foreach($dataKupas as $karyawanId => $data)
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
                    <td style="border: 1px solid #000; text-transform: uppercase;">{{ $data['nama'] }}</td>
                    @foreach($period as $date)
                        @php
                            $d = $date->format('Y-m-d');
                            $vol = isset($data['hari'][$d]) ? $data['hari'][$d] : '';
                            if ($vol) { $sumPerHari[$d] += $vol; }
                        @endphp
                        <td style="border: 1px solid #000; text-align: center;">{{ $vol ? $vol : '' }}</td>
                    @endforeach
                    <td style="border: 1px solid #000; text-align: center;">{{ $data['total_butir'] }}</td>
                    <td style="border: 1px solid #000; text-align: right;">{{ $tarifKupas }}</td>
                    <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f3f4f6;">{{ $data['total_upah'] }}</td>
                </tr>
                @php $grandTotalButir += $data['total_butir']; @endphp
            @endforeach
            <tr>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; text-transform: uppercase;">JUMLAH</td>
                @foreach($period as $date)
                    @php $d = $date->format('Y-m-d'); @endphp
                    <td style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">{{ $sumPerHari[$d] > 0 ? $sumPerHari[$d] : '0' }}</td>
                @endforeach
                <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $grandTotalButir }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $tarifKupas }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right; background-color: #f3f4f6;">{{ $totalUpahKupas }}</td>
            </tr>
            <tr>
                <td colspan="12"></td>
            </tr>
            @endif

            <!-- AKUMULASI -->
            <tr>
                <td colspan="3" style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">AKUMULASI</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">NO</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">KETERANGAN</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">TOTAL</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center;">1</td>
                <td style="border: 1px solid #000;">HARIAN</td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold;">{{ $totalUpahHarian }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center;">2</td>
                <td style="border: 1px solid #000;">KUPAS KELAPA</td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold;">{{ $totalUpahKupas }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f3f4f6;">{{ $totalUpahHarian + $totalUpahKupas }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
