<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Form Pengajuan Dana - {{ $pengajuan_kas_gantung->id }}</title>
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
        .header-table td { border: none; vertical-align: middle; padding: 5px; }
        .logo-cell { width: 15%; text-align: center; border-right: 2px solid #000 !important; }
        .title-cell { width: 85%; text-align: center; padding-right: 15%; }
        .company-name { font-size: 16px; font-weight: bold; margin: 0 0 2px 0; }
        .company-address { font-size: 9px; font-weight: bold; margin: 0; }
        .form-title { font-size: 14px; font-weight: bold; text-align: center; padding: 5px; border-bottom: 2px solid #000; }
        
        .info-table { width: 100%; border-collapse: collapse; border-bottom: 2px solid #000; }
        .info-table td { border: none; padding: 2px 5px; font-weight: bold; font-size: 11px; }
        .info-label { width: 250px; }
        
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th, .items-table td { border: 2px solid #000; padding: 4px; }
        .items-table th { text-align: center; font-weight: bold; }
        
        .sign-table { width: 100%; border-collapse: collapse; text-align: center; font-weight: bold; font-size: 11px; }
        .sign-table td { border: 2px solid #000; border-bottom: none; width: 20%; padding: 4px; }
        .sign-table .names td { border-top: none; padding-top: 40px; padding-bottom: 5px; }
        .sign-line { border-bottom: 2px solid #000; display: inline-block; width: 80%; }
        
        .rp { float: left; }
        .nominal { float: right; }
    </style>
</head>
<body>

    <div class="wrapper">
        <table class="header-table">
            <tr>
                <td class="logo-cell">
                    @if(file_exists(public_path('logo.jpg')))
                        <img src="{{ public_path('logo.jpg') }}" alt="Logo" style="width: 50px;">
                    @endif
                </td>
                <td class="title-cell">
                    <div class="company-name">PT. TRI MUSTIKA COCOMINAESA</div>
                    <div class="company-address">Jl. Raya A.K.D. Km. 90, Teep Kec. Amurang Barat Kab. Minahasa Selatan, Sulawesi Utara 95955, Indonesia</div>
                </td>
            </tr>
        </table>
        
        <div class="form-title">Form Pengajuan Dana</div>
        
        @php
            $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            $tgl = \Carbon\Carbon::parse($pengajuan_kas_gantung->tanggal);
            $nama_hari = $hari[$tgl->dayOfWeek];
            $nama_bulan = $bulan[$tgl->month];
            $tanggal_indo = $nama_hari . ', ' . $tgl->day . ' ' . $nama_bulan . ' ' . $tgl->year;
        @endphp
        
        <table class="info-table">
            <tr>
                <td class="info-label">Departemen</td>
                <td>: {{ strtoupper($pengajuan_kas_gantung->departemen ?? 'PERKEBUNAN') }}</td>
            </tr>
            <tr>
                <td>Pengajuan Untuk Kebutuhan</td>
                <td>: {{ strtoupper($pengajuan_kas_gantung->pengajuan_kebutuhan ?? '-') }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td>: {{ $pengajuan_kas_gantung->judul_pengajuan ?? 'Pengajuan Kas Gantung' }}</td>
            </tr>
            <tr>
                <td>Tanggal Pengajuan</td>
                <td>: {{ $tanggal_indo }}</td>
            </tr>
        </table>
        
        <table class="items-table" style="border-left: none; border-right: none; border-bottom: none;">
            <thead>
                <tr>
                    <th style="width: 5%; border-left: none;">NO.</th>
                    <th style="width: 35%;">URAIAN</th>
                    <th style="width: 25%;">TOTAL HARGA</th>
                    <th style="width: 35%; border-right: none;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengajuan_kas_gantung->items as $index => $item)
                <tr>
                    <td class="text-center font-bold" style="border-left: none;">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ strtoupper($item->nama_barang) }}</td>
                    <td class="font-bold">
                        <span class="rp">Rp</span>
                        <span class="nominal">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                        <div style="clear: both;"></div>
                    </td>
                    <td class="font-bold" style="border-right: none;">{{ strtoupper($item->keterangan_pengajuan) }}</td>
                </tr>
                @endforeach
                
                @for($i = count($pengajuan_kas_gantung->items) + 1; $i <= 5; $i++)
                <tr>
                    <td class="text-center font-bold" style="border-left: none; height: 15px;">{{ $i }}</td>
                    <td></td>
                    <td></td>
                    <td style="border-right: none;"></td>
                </tr>
                @endfor
                
                <tr>
                    <td colspan="2" class="text-center font-bold" style="border-left: none;">TOTAL PENGAJUAN DANA</td>
                    <td class="font-bold">
                        <span class="rp">Rp</span>
                        <span class="nominal">{{ number_format($pengajuan_kas_gantung->grand_total, 0, ',', '.') }}</span>
                        <div style="clear: both;"></div>
                    </td>
                    <td style="border-right: none;"></td>
                </tr>
            </tbody>
        </table>
        
        <table class="sign-table" style="border-left: none; border-right: none; border-bottom: none;">
            <tr>
                <td style="border-left: none;">Dibuat Oleh</td>
                <td>Diketahui Oleh</td>
                <td>Disetujui Oleh</td>
                <td>Dibayar Oleh</td>
                <td style="border-right: none;">Diterima Oleh</td>
            </tr>
            <tr class="names">
                <td style="border-left: none;"><span class="sign-line">ALDO</span></td>
                <td><span class="sign-line">DAVID</span></td>
                <td><span class="sign-line">STANLY</span></td>
                <td><span class="sign-line">PRISILLIA</span></td>
                <td style="border-right: none;"><span class="sign-line">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
            </tr>
        </table>
    </div>



</body>
</html>
