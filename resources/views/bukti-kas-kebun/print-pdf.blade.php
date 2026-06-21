<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengeluaran Kas Kebun - {{ $bukti_kas_kebun->no_bukti ?: $bukti_kas_kebun->id }}</title>
    <style>
        @page { size: A5 landscape; margin: 15px; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #000; margin: 0; padding: 10px; }
        .wrapper { width: 100%; border: 2px solid #000; padding: 10px; box-sizing: border-box; }
        
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 10px; }
        
        .header-table { width: 100%; }
        .header-table td { vertical-align: top; }
        .company-name { font-weight: bold; font-size: 14px; text-decoration: underline; margin-bottom: 5px; }
        .doc-title { font-size: 16px; font-weight: bold; text-align: center; text-decoration: underline; margin-top: 15px; margin-bottom: 5px; }
        
        .doc-info-box { border: 2px solid #000; padding: 5px; font-weight: bold; width: 200px; float: right; margin-top: -40px;}
        .doc-info-box table { width: 100%; font-size: 11px;}
        .doc-info-box td { padding: 2px; }
        
        .info-row { margin-bottom: 5px; }
        .info-row span.label { display: inline-block; width: 120px; font-weight: bold; }
        
        .total-box { margin-top: 10px; margin-bottom: 15px; font-weight: bold; font-size: 12px; border-bottom: 1px dashed #000; padding-bottom: 5px;}
        .total-box span.label { display: inline-block; width: 120px; }
        
        .keterangan-title { font-weight: bold; margin-bottom: 5px; }
        
        .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .detail-table th, .detail-table td { border: 1px solid #000; padding: 4px 6px; }
        .detail-table th { text-align: center; font-weight: bold; background-color: #f5f5f5; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .sign-area { margin-top: 20px; width: 100%; }
        .sign-table { width: 100%; border-collapse: collapse; text-align: center; font-size: 10px; }
        .sign-table td { border: 2px solid #000; padding: 3px; vertical-align: top; }
        .sign-table .header-cell { padding: 5px; font-weight: bold; border-bottom: 2px solid #000; }
        .sign-table .role-cell { padding: 3px; font-style: italic; }
        .sign-table .name-cell { height: 60px; vertical-align: bottom; padding-bottom: 5px; font-weight: bold; }
        .sign-line { border-bottom: 1px solid #000; display: inline-block; width: 80%; margin-top: 40px;}
        
        .clear { clear: both; }
        .terbilang-box { border: 1px solid #000; padding: 5px; font-style: italic; margin-bottom: 15px; font-weight: bold;}
    </style>
</head>
<body>

    @php
        $pengajuan = $bukti_kas_kebun->pengajuan_penggajian;
        $penggajian = $pengajuan->penggajian;
        
        $grouped = [];
        $total = 0;
        
        if ($penggajian && $penggajian->details) {
            foreach($penggajian->details as $detail) {
                // Get Jabatan names
                $jabatans = $detail->karyawan->jabatans->pluck('nama_jabatan')->implode(', ');
                $jabatanName = $jabatans ?: 'Lain-lain';
                
                if(!isset($grouped[$jabatanName])) {
                    $grouped[$jabatanName] = 0;
                }
                $grouped[$jabatanName] += $detail->total_upah;
                $total += $detail->total_upah;
            }
        } else {
            // Fallback to pengajuan items if no penggajian details
            foreach($pengajuan->items as $item) {
                if(!isset($grouped[$item->uraian])) {
                    $grouped[$item->uraian] = 0;
                }
                $grouped[$item->uraian] += $item->total_harga;
                $total += $item->total_harga;
            }
        }
        
        // Function for terbilang
        function penyebut($nilai) {
            $nilai = abs($nilai);
            $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                $temp = penyebut($nilai - 10). " belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
            }     
            return $temp;
        }
        function terbilang($nilai) {
            if($nilai<0) {
                $hasil = "minus ". trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }           
            return $hasil . " rupiah";
        }
    @endphp

    <div class="wrapper">
        <div class="company-name">PT. TRI MUSTIKA COCOMINAESA</div>
        
        <div class="doc-title">BUKTI PENGELUARAN KAS KEBUN</div>
        
        <div class="doc-info-box">
            <table>
                <tr>
                    <td width="30%">Tgl</td>
                    <td width="5%">:</td>
                    <td>{{ \Carbon\Carbon::parse($bukti_kas_kebun->tanggal)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr>
                    <td>No</td>
                    <td>:</td>
                    <td>{{ $bukti_kas_kebun->no_bukti ?: '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>

        <div class="info-row" style="margin-top: 10px;">
            <span class="label">Dibayarkan kepada</span> : <strong>MANDOR / PENERIMA KUASA</strong>
        </div>
        <div class="info-row">
            <span class="label">Bagian / Lokasi</span> : {{ $pengajuan->kebun->lokasi }}
        </div>
        <div class="info-row">
            <span class="label">Alamat</span> : KEBUN
        </div>

        <div class="total-box">
            <span class="label">Jumlah</span> : Rp. {{ number_format($total, 0, ',', '.') }}
        </div>
        
        <div class="terbilang-box">
            Terbilang: # {{ ucwords(terbilang($total)) }} #
        </div>

        <div class="keterangan-title">
            Keterangan: {{ $pengajuan->perihal }} 
            @if($penggajian)
            (Laporan Tgl {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->format('d/m/Y') }})
            @endif
        </div>

        <table class="detail-table">
            <thead>
                <tr>
                    <th width="10%">NO</th>
                    <th width="40%">TIPE UPAH (JABATAN)</th>
                    <th width="20%">JUMLAH (Rp)</th>
                    <th width="30%">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($grouped as $tipe => $jumlah)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $tipe }}</td>
                    <td class="text-right">{{ number_format($jumlah, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-right" style="font-weight:bold;">TOTAL</td>
                    <td class="text-right" style="font-weight:bold;">{{ number_format($total, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="sign-area">
            <table class="sign-table">
                <tr>
                    <td width="16.6%" class="header-cell">Dibuat Oleh:</td>
                    <td width="16.6%" class="header-cell">Diperiksa Oleh:</td>
                    <td width="33.2%" colspan="2" class="header-cell">DISETUJUI OLEH:</td>
                    <td width="16.6%" class="header-cell">Mengetahui,</td>
                    <td width="16.6%" class="header-cell">Penerima,</td>
                </tr>
                <tr>
                    <td class="role-cell">ADM KEBUN / MANDOR</td>
                    <td class="role-cell">KTU / KASIR</td>
                    <td class="role-cell" width="16.6%">ASISTEN / MGR. KEBUN</td>
                    <td class="role-cell" width="16.6%">GM / MILL MGR</td>
                    <td class="role-cell">FINANCIAL CONTROLLER</td>
                    <td class="role-cell"></td>
                </tr>
                <tr>
                    <td class="name-cell"><span class="sign-line"></span></td>
                    <td class="name-cell"><span class="sign-line"></span></td>
                    <td class="name-cell"><span class="sign-line"></span></td>
                    <td class="name-cell"><span class="sign-line"></span></td>
                    <td class="name-cell"><span class="sign-line"></span></td>
                    <td class="name-cell"><span class="sign-line"></span></td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>
