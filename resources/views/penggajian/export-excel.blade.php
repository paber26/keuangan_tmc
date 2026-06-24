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
            @php
                $dataHarian = $dataHarian->map(function($item) {
                    if (empty($item->jabatan)) {
                        $item->jabatan = $item->karyawan->jabatans->first()->nama ?? 'TIDAK DIKETAHUI';
                    }
                    return $item;
                });
                $groupedHarian = $dataHarian->groupBy('jabatan');
            @endphp
            
            @if(count($dataHarian) > 0)
                @foreach($groupedHarian as $jabatan => $items)
                <tr>
                    <td colspan="{{ count($period) + 5 }}" style="font-weight: bold; text-transform: uppercase;">HARIAN - {{ strtoupper($jabatan ?: 'TIDAK DIKETAHUI') }}</td>
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
                @php $no = 1; $subTotalHari = 0; $subTotalUpah = 0; @endphp
                @foreach($items as $data)
                    <tr>
                        <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
                        <td style="border: 1px solid #000; text-transform: uppercase;">{{ $data->nama_karyawan }}</td>
                        @foreach($period as $date)
                            <td style="border: 1px solid #000; text-align: center;">
                                @if(isset($data->rincian_harian[$date->format('Y-m-d')]))
                                    V
                                @endif
                            </td>
                        @endforeach
                        <td style="border: 1px solid #000; text-align: center;">{{ $data->jumlah_hari_kerja }}</td>
                        <td style="border: 1px solid #000; text-align: right;">{{ strtolower($jabatan) === 'memaras mesin' ? ($penggajian->tarif_memaras ?? 250000) : $penggajian->tarif_harian }}</td>
                        <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f3f4f6;">{{ $data->total_upah }}</td>
                    </tr>
                    @php 
                        $subTotalHari += $data->jumlah_hari_kerja;
                        $subTotalUpah += $data->total_upah;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; text-transform: uppercase;">JUMLAH</td>
                    @foreach($period as $date)
                        <td style="border: 1px solid #000; background-color: #f3f4f6;"></td>
                    @endforeach
                    <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $subTotalHari }}</td>
                    <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ strtolower($jabatan) === 'memaras mesin' ? ($penggajian->tarif_memaras ?? 250000) : $penggajian->tarif_harian }}</td>
                    <td style="border: 1px solid #000; font-weight: bold; text-align: right; background-color: #f3f4f6;">{{ $subTotalUpah }}</td>
                </tr>
                <tr>
                    <td colspan="12"></td>
                </tr>
                @endforeach
            @endif

            <!-- BORONGAN -->
            @php
                $dataBorongan = $dataBorongan->map(function($item) {
                    if (empty($item->jabatan)) {
                        $item->jabatan = $item->karyawan->jabatans->first()->nama ?? 'TIDAK DIKETAHUI';
                    }
                    return $item;
                });
                $groupedBorongan = collect($dataBorongan)->groupBy('jabatan');
                $totalUpahBorongan = collect($dataBorongan)->sum('total_upah');
            @endphp
            
            @foreach($groupedBorongan as $jabatan => $items)
            @php
                $isKupas = $jabatan === 'Kupas Kelapa';
                $isPemanjat = $jabatan === 'Pemanjat Kelapa';
                $isPemetik = $jabatan === 'Pemetik Cengkeh';
                
                $volLabel = $isKupas ? 'BUTIR' : ($isPemanjat ? 'POHON' : ($isPemetik ? 'KG' : 'VOLUME'));
                $tarifLabel = $isKupas ? 'PER BUTIR' : ($isPemanjat ? 'PER POHON' : ($isPemetik ? 'PER KG' : 'PER VOLUME'));
                $tarifVal = $isKupas ? $penggajian->tarif_kupas : ($isPemanjat ? $penggajian->tarif_pemanjat : ($isPemetik ? $penggajian->tarif_pemetik : 0));
            @endphp
            <tr>
                <td colspan="{{ count($period) + 5 }}" style="font-weight: bold; text-transform: uppercase;">BORONGAN - {{ strtoupper($jabatan) }}</td>
            </tr>
            <tr>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">NO.</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">NAMA</th>
                <th colspan="{{ count($period) }}" style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">PERIODE</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">JUMLAH {{ $volLabel }}</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">UPAH {{ $tarifLabel }}</th>
                <th rowspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; vertical-align: middle; background-color: #FFE600;">TOTAL UPAH</th>
            </tr>
            <tr>
                @foreach($period as $date)
                    <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #FFE600;">{{ $date->format('j') }}</th>
                @endforeach
            </tr>
            @php $no = 1; $grandTotalVol = 0; $sumPerHari = []; $totalUpahGroup = 0; @endphp
            @foreach($period as $date) @php $sumPerHari[$date->format('Y-m-d')] = 0; @endphp @endforeach

            @foreach($items as $data)
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $no++ }}</td>
                    <td style="border: 1px solid #000; text-transform: uppercase;">{{ $data->nama_karyawan }}</td>
                    @foreach($period as $date)
                        @php
                            $d = $date->format('Y-m-d');
                            $vol = isset($data->rincian_harian[$d]) ? $data->rincian_harian[$d] : null;
                            if ($vol) { $sumPerHari[$d] += $vol; }
                        @endphp
                        <td style="border: 1px solid #000; text-align: center;">{{ $vol ? $vol : '' }}</td>
                    @endforeach
                    <td style="border: 1px solid #000; text-align: center;">{{ $data->jumlah_volume }}</td>
                    <td style="border: 1px solid #000; text-align: right;">{{ $tarifVal }}</td>
                    <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f3f4f6;">{{ $data->total_upah }}</td>
                </tr>
                @php 
                    $grandTotalVol += $data->jumlah_volume;
                    $totalUpahGroup += $data->total_upah; 
                @endphp
            @endforeach
            <tr>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: center; text-transform: uppercase;">JUMLAH</td>
                @foreach($period as $date)
                    @php $d = $date->format('Y-m-d'); @endphp
                    <td style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">{{ $sumPerHari[$d] > 0 ? $sumPerHari[$d] : '0' }}</td>
                @endforeach
                <td style="border: 1px solid #000; font-weight: bold; text-align: center;">{{ $grandTotalVol }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right;">{{ $tarifVal }}</td>
                <td style="border: 1px solid #000; font-weight: bold; text-align: right; background-color: #f3f4f6;">{{ $totalUpahGroup }}</td>
            </tr>
            <tr>
                <td colspan="12"></td>
            </tr>
            @endforeach

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
                <td style="border: 1px solid #000; text-align: right; font-weight: bold;">{{ collect($dataHarian)->sum('total_upah') }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; text-align: center;">2</td>
                <td style="border: 1px solid #000;">BORONGAN</td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold;">{{ $totalUpahBorongan ?? 0 }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f3f4f6;">{{ $penggajian->total_keseluruhan }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
