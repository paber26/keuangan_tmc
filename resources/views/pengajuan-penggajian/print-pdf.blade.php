<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pengajuan Dana - {{ $pengajuan_penggajian->no_dokumen ?: $pengajuan_penggajian->id }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #000; margin: 0; padding: 10px; }
        .wrapper { width: 100%; border: 2px solid #000; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 2px solid #000; padding: 3px; }
        .no-border { border: none !important; }
        .border-b { border-bottom: 2px solid #000; }
        .border-r { border-right: 2px solid #000; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        
        .header-table { width: 100%; border-collapse: collapse; border-bottom: 2px solid #000; }
        .header-table td { border: none; vertical-align: top; padding: 10px; }
        .logo-cell { width: 20%; text-align: center; }
        .title-cell { width: 40%; text-align: center; vertical-align: middle; padding-top: 35px; }
        .doc-info-cell { width: 40%; padding: 0; }
        
        .doc-info-table { width: 100%; border-collapse: collapse; border: 2px solid #000; font-size: 9px; font-weight: bold; }
        .doc-info-table td { border: 2px solid #000; padding: 4px; }
        .doc-info-label { width: 30%; white-space: nowrap; }
        .doc-info-value { width: 70%; white-space: nowrap; }
        
        .company-name { font-size: 14px; font-weight: bold; margin: 0 0 4px 0; }
        .company-address { font-size: 10px; margin: 0; line-height: 1.4; }
        .form-title { font-size: 16px; font-weight: bold; text-align: center; padding: 8px; text-decoration: underline; margin-top: 5px; margin-bottom: 10px; }
        
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { border: none; padding: 3px 5px; font-size: 11px; }
        .info-label { width: 200px; }
        
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th, .items-table td { border: 2px solid #000; padding: 5px; }
        .items-table th { text-align: center; font-weight: bold; }
        .items-table td { vertical-align: top; }
        
        .sign-table { width: 100%; border-collapse: collapse; text-align: center; font-size: 11px; margin-top: 0; }
        .sign-table td { border: 2px solid #000; width: 25%; padding: 5px; }
        .sign-table .names td { border-top: none; padding-top: 50px; padding-bottom: 5px; font-weight: bold; }
        .sign-line { border-bottom: 1px solid #000; display: block; margin: 0 auto 2px auto; width: 80%; }
        
        .rp { float: left; }
        .nominal { float: right; }
        
        .members-text { font-weight: bold; font-size: 10px; margin-top: 5px; }
    </style>
</head>
<body>

    <div class="wrapper">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    @if(file_exists(public_path('logo.jpg')))
                        <img src="{{ public_path('logo.jpg') }}" alt="Logo" style="height: 70px;">
                    @else
                        <!-- Placeholder if no logo -->
                        <div style="height: 70px; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; font-size: 20px; font-weight: bold; color: #cc0000;">
                            TMC Logo
                        </div>
                    @endif
                    <div class="members-text">Members Of RAI</div>
                </td>
                <td class="title-cell">
                    <div class="company-name">PT. TRI MUSTIKA COCOMINAESA</div>
                    <div class="company-address">Jl. Raya A.K.D. Km. 90, Teep Kec. Amurang Barat Kab. Minahasa Selatan,<br>Sulawesi Utara 95924, Indonesia</div>
                </td>
                <td class="doc-info-cell">
                    <table class="doc-info-table">
                        <tr>
                            <td class="doc-info-label">No. Dokumen</td>
                            <td class="doc-info-value">: {{ $pengajuan_penggajian->no_dokumen ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="doc-info-label">Disahkan Tgl</td>
                            <td class="doc-info-value">: {{ $pengajuan_penggajian->disahkan_tgl ? \Carbon\Carbon::parse($pengajuan_penggajian->disahkan_tgl)->translatedFormat('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="doc-info-label">Berlaku Tgl</td>
                            <td class="doc-info-value">: {{ $pengajuan_penggajian->berlaku_tgl ? \Carbon\Carbon::parse($pengajuan_penggajian->berlaku_tgl)->translatedFormat('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="doc-info-label">Revisi</td>
                            <td class="doc-info-value">: {{ $pengajuan_penggajian->revisi ?? '0' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <div class="form-title">Form Pengajuan Dana</div>
        
        @php
            $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $tgl = \Carbon\Carbon::parse($pengajuan_penggajian->tanggal);
            $nama_hari = $hari[$tgl->dayOfWeek];
            $nama_bulan = $bulan[$tgl->month];
            $tanggal_indo = $nama_hari . ', ' . $tgl->day . ' ' . $nama_bulan . ' ' . $tgl->year;
        @endphp
        
        <table class="info-table">
            <tr>
                <td class="info-label">Departemen</td>
                <td>: PERKEBUNAN</td>
            </tr>
            <tr>
                <td>Pengajuan Untuk Kebutuhan</td>
                <td>: {{ $pengajuan_penggajian->kebun ? $pengajuan_penggajian->kebun->lokasi : '-' }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: {{ $pengajuan_penggajian->perihal ?? 'Kebutuhan Biaya Upah' }}</td>
            </tr>
            <tr>
                <td></td>
                <td>: {{ $tanggal_indo }}</td>
            </tr>
        </table>
        
        <table class="items-table" style="border-left: none; border-right: none; border-bottom: none;">
            <thead>
                <tr>
                    <th style="width: 5%; border-left: none;">NO.</th>
                    <th style="width: 25%;">URAIAN</th>
                    <th style="width: 15%;">BANYAK UNIT</th>
                    <th style="width: 15%;">HARGA SATUAN</th>
                    <th style="width: 20%;">TOTAL HARGA</th>
                    <th style="width: 20%; border-right: none;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuan_penggajian->items as $index => $item)
                <tr>
                    <td class="text-center font-bold" style="border-left: none;">{{ $index + 1 }}</td>
                    <td class="uppercase">{{ $item->uraian }}</td>
                    <td class="text-center uppercase">{{ $item->banyak_unit ? (float) $item->banyak_unit : '' }}</td>
                    <td class="text-right uppercase">{{ $item->harga_satuan ? number_format($item->harga_satuan, 0, ',', '.') : '' }}</td>
                    <td>
                        <span class="rp font-bold">Rp</span>
                        <span class="nominal font-bold">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        <div style="clear: both;"></div>
                    </td>
                    <td class="uppercase" style="border-right: none;">{{ $item->keterangan }}</td>
                </tr>
                @endforeach
                
                {{-- Always fill empty rows up to 20, let table height stretch them if needed --}}
                @for($i = count($pengajuan_penggajian->items) + 1; $i <= 20; $i++)
                <tr>
                    <td class="text-center font-bold" style="border-left: none; padding: 0;">{{ $i }}</td>
                    <td style="padding: 0;"></td>
                    <td style="padding: 0;"></td>
                    <td style="padding: 0;"></td>
                    <td style="padding: 0;"></td>
                    <td style="border-right: none; padding: 0;"></td>
                </tr>
                @endfor
            </tbody>
        </table>
        
        <table class="sign-table" style="border-left: none; border-right: none; border-bottom: none;">
            <tr>
                <td style="border-left: none;">Diajukan Oleh:</td>
                <td>Diperiksa Oleh:</td>
                <td>Diketahui Oleh:</td>
                <td style="border-right: none;">Disetujui Oleh:</td>
            </tr>
            <tr class="names">
                <td style="border-left: none;">
                    <span class="sign-line">Aldo</span>
                    <span style="font-weight: normal;">SPV Ops Perkebunan</span>
                </td>
                <td>
                    <span class="sign-line">Henry Harinda</span>
                    <span style="font-weight: normal;">SPV Finance</span>
                </td>
                <td>
                    <span class="sign-line">David Limpele</span>
                    <span style="font-weight: normal;">Manager F&A</span>
                </td>
                <td style="border-right: none;">
                    <span class="sign-line">Stanly Ransang</span>
                    <span style="font-weight: normal;">PIC Perkebunan</span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
