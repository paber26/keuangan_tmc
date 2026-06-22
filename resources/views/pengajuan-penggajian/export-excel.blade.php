<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
@php
    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tgl = \Carbon\Carbon::parse($pengajuan_penggajian->tanggal);
    $nama_hari = $hari[$tgl->dayOfWeek];
    $nama_bulan = $bulan[$tgl->month];
    $tanggal_indo = $nama_hari . ', ' . $tgl->day . ' ' . $nama_bulan . ' ' . $tgl->year;
    
    $lokasiFull = $pengajuan_penggajian->kebun->lokasi ?? '-';
    if ($lokasiFull === 'TOMBATU') {
        if (stripos($pengajuan_penggajian->perihal, 'Winor') !== false) {
            $lokasiFull = 'TOMBATU - Winor';
        } elseif (stripos($pengajuan_penggajian->perihal, 'Tinembelan') !== false) {
            $lokasiFull = 'TOMBATU - Tinembelan';
        }
    } elseif ($lokasiFull === 'RANOKETANG TUA') {
        $lokasiFull = 'RANOKETANG TUA - Katuwisan';
    }
@endphp
<table>
    <tbody>
        <tr>
            <td colspan="2" rowspan="4" style="text-align: center; vertical-align: middle; height: 60px;">
                <!-- Logo will be injected by WithDrawings at A1 -->
            </td>
            <td colspan="2" style="font-weight: bold; font-size: 14px; text-align: center;">PT. TRI MUSTIKA COCOMINAESA</td>
            <td style="border: 1px solid #000; font-weight: bold;">No. Dokumen</td>
            <td style="border: 1px solid #000; font-weight: bold;">: {{ $pengajuan_penggajian->no_dokumen ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="3" style="text-align: center; vertical-align: top; font-size: 10px;">
                Jl. Raya A.K.D. Km. 90, Teep Kec. Amurang Barat Kab. Minahasa Selatan, Sulawesi Utara 95924, Indonesia
            </td>
            <td style="border: 1px solid #000; font-weight: bold;">Disahkan Tgl</td>
            <td style="border: 1px solid #000; font-weight: bold;">: {{ $pengajuan_penggajian->disahkan_tgl ? \Carbon\Carbon::parse($pengajuan_penggajian->disahkan_tgl)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; font-weight: bold;">Berlaku Tgl</td>
            <td style="border: 1px solid #000; font-weight: bold;">: {{ $pengajuan_penggajian->berlaku_tgl ? \Carbon\Carbon::parse($pengajuan_penggajian->berlaku_tgl)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #000; font-weight: bold;">Revisi</td>
            <td style="border: 1px solid #000; font-weight: bold;">: {{ $pengajuan_penggajian->revisi ?? '0' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 10px;">Members Of RAI</td>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; font-weight: bold; font-size: 16px; text-decoration: underline;">Form Pengajuan Dana</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Departemen</td>
            <td colspan="4" style="font-weight: bold;">: PERKEBUNAN</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Pengajuan Untuk Kebutuhan</td>
            <td colspan="4" style="font-weight: bold;">: {{ $lokasiFull }}</td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight: bold;">Perihal</td>
            <td colspan="4" style="font-weight: bold;">: {{ $pengajuan_penggajian->perihal ?? 'Kebutuhan Biaya Upah' }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="4" style="font-weight: bold;">: {{ $tanggal_indo }}</td>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        
        <tr>
            <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">NO.</th>
            <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">URAIAN</th>
            <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">BANYAK UNIT</th>
            <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">HARGA SATUAN</th>
            <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">TOTAL HARGA</th>
            <th style="border: 1px solid #000; font-weight: bold; text-align: center; background-color: #f3f4f6;">KETERANGAN</th>
        </tr>
        
        @foreach($pengajuan_penggajian->items as $index => $item)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $index + 1 }}</td>
            <td style="border: 1px solid #000; text-transform: uppercase;">{{ $item->uraian }}</td>
            <td style="border: 1px solid #000; text-align: center;">{{ $item->banyak_unit ? (float) $item->banyak_unit : '' }}</td>
            <td style="border: 1px solid #000; text-align: right;">{{ $item->harga_satuan ? $item->harga_satuan : '' }}</td>
            <td style="border: 1px solid #000; text-align: right; font-weight: bold;">{{ $item->total_harga }}</td>
            <td style="border: 1px solid #000; text-transform: uppercase;">{{ $item->keterangan }}</td>
        </tr>
        @endforeach
        
        @for($i = count($pengajuan_penggajian->items) + 1; $i <= count($pengajuan_penggajian->items) + 5; $i++)
        <tr>
            <td style="border: 1px solid #000; text-align: center;">{{ $i }}</td>
            <td style="border: 1px solid #000;"></td>
            <td style="border: 1px solid #000;"></td>
            <td style="border: 1px solid #000;"></td>
            <td style="border: 1px solid #000;"></td>
            <td style="border: 1px solid #000;"></td>
        </tr>
        @endfor
        
        <tr>
            <td colspan="6"></td>
        </tr>
        
        <tr>
            <td colspan="1" style="border: 1px solid #000; text-align: center;">Diajukan Oleh:</td>
            <td colspan="2" style="border: 1px solid #000; text-align: center;">Diperiksa Oleh:</td>
            <td colspan="2" style="border: 1px solid #000; text-align: center;">Diketahui Oleh:</td>
            <td colspan="1" style="border: 1px solid #000; text-align: center;">Disetujui Oleh:</td>
        </tr>
        <tr>
            <td colspan="1" style="border: 1px solid #000; text-align: center; vertical-align: bottom; height: 60px;">
                <br><br><br><b>Aldo Halada</b><br>SPV Ops Perkebunan
            </td>
            <td colspan="2" style="border: 1px solid #000; text-align: center; vertical-align: bottom; height: 60px;">
                <br><br><br><b>Henry Harinda</b><br>SPV Finance
            </td>
            <td colspan="2" style="border: 1px solid #000; text-align: center; vertical-align: bottom; height: 60px;">
                <br><br><br><b>David Limpele</b><br>Manager F&amp;A
            </td>
            <td colspan="1" style="border: 1px solid #000; text-align: center; vertical-align: bottom; height: 60px;">
                <br><br><br><b>Stanly Ransang</b><br>PIC Perkebunan
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
