<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengeluaran Kas Kebun - {{ $bukti_kas_kebun->no_bukti ?: $bukti_kas_kebun->id }}</title>
    <style>
        @page { size: A5 landscape; margin: 15px 25px 15px 15px; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #000; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        
        /* Rotated text */
        .rotated-text {
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
            font-size: 18px;
            font-weight: bold;
            font-style: italic;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .main-box {
            border: 2px solid black;
        }

        .header-table td {
            border-bottom: 2px solid black;
            border-right: 2px solid black;
        }
        .header-table td:last-child {
            border-right: none;
        }

        .sub-header-table td {
            border-bottom: 2px solid black;
            border-right: 2px solid black;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 12px;
        }
        .sub-header-table td:last-child {
            border-right: none;
        }

        .items-table td {
            border-bottom: 1px solid black;
            border-right: 2px solid black;
            padding: 4px 6px;
        }
        .items-table td:last-child {
            border-right: none;
        }
        .items-table th {
            border-bottom: 2px solid black;
            border-right: 2px solid black;
            background-color: #e5e5e5;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            font-style: italic;
        }
        .items-table th:last-child {
            border-right: none;
        }

        .footer-table td {
            border-bottom: 2px solid black;
            border-right: 2px solid black;
        }
        .footer-table td:last-child {
            border-right: none;
        }

        .sign-table td {
            border-right: 2px solid black;
            padding: 4px;
            text-align: center;
        }
        .sign-table td:last-child {
            border-right: none;
        }
        .sign-table .header-cell {
            border-bottom: 2px solid black;
            font-weight: bold;
            font-size: 10px;
        }

        .flex-rp {
            display: inline-block;
            float: left;
        }
        .flex-nominal {
            display: inline-block;
            float: right;
        }
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
            $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
            $temp = "";
            if ($nilai < 12) {
                $temp = " ". $huruf[$nilai];
            } else if ($nilai <20) {
                $temp = penyebut($nilai - 10). " Belas";
            } else if ($nilai < 100) {
                $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
            } else if ($nilai < 200) {
                $temp = " Seratus" . penyebut($nilai - 100);
            } else if ($nilai < 1000) {
                $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
            } else if ($nilai < 2000) {
                $temp = " Seribu" . penyebut($nilai - 1000);
            } else if ($nilai < 1000000) {
                $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
            } else if ($nilai < 1000000000) {
                $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
            } else if ($nilai < 1000000000000) {
                $temp = penyebut($nilai/1000000000) . " Milyar" . penyebut(fmod($nilai,1000000000));
            } else if ($nilai < 1000000000000000) {
                $temp = penyebut($nilai/1000000000000) . " Trilyun" . penyebut(fmod($nilai,1000000000000));
            }     
            return $temp;
        }
        function terbilang($nilai) {
            if($nilai<0) {
                $hasil = "Minus ". trim(penyebut($nilai));
            } else {
                $hasil = trim(penyebut($nilai));
            }           
            return $hasil . " Rupiah";
        }
    @endphp

    <table style="border: none;">
        <tr>
            <!-- Rotated Text Area -->
            <td style="width: 20px; vertical-align: middle; padding: 0;">
                <div style="position: relative; width: 20px;">
                    <div class="rotated-text" style="position: absolute; top: 200px; left: -140px;">
                        HANYA UNTUK INTERN
                    </div>
                </div>
            </td>
            
            <!-- Main Content Area -->
            <td style="padding: 0; vertical-align: top;">
                <div class="main-box">
                    
                    <!-- Header -->
                    <table class="header-table">
                        <tr>
                            <td style="width: 35%; padding: 5px;">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td style="width: 40px; border: none; padding: 0;">
                                            @if(file_exists(public_path('logo.jpg')))
                                                <img src="{{ public_path('logo.jpg') }}" alt="Logo" style="height: 35px;">
                                            @else
                                                <div style="width: 40px; height: 35px; border: 1px solid red;"></div>
                                            @endif
                                        </td>
                                        <td style="border: none; padding-left: 10px; font-weight: bold; font-size: 10px; vertical-align: middle;">
                                            PT. TRI MUSTIKA COCOMINAESA
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 40%; text-align: center; font-weight: bold; font-size: 18px;">
                                Bukti Pengeluaran Kas Kebun
                            </td>
                            <td style="width: 25%; padding: 5px;">
                                <table style="width: 100%; font-weight: bold; font-size: 12px; border: none;">
                                    <tr>
                                        <td style="width: 30px; border: none; padding: 2px;">No</td>
                                        <td style="border: none; padding: 2px;">: {{ $bukti_kas_kebun->no_bukti }}</td>
                                    </tr>
                                    <tr>
                                        <td style="border: none; padding: 2px;">Tgl</td>
                                        <td style="border: none; padding: 2px;">: {{ \Carbon\Carbon::parse($bukti_kas_kebun->tanggal)->translatedFormat('d F Y') }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Sub Header -->
                    <table class="sub-header-table">
                        <tr>
                            <td style="width: 60%; padding-top: 10px; padding-bottom: 10px;">
                                <div>Perkiraan No :</div>
                                <div style="margin-top: 5px; letter-spacing: 2px;">.......................................................................</div>
                            </td>
                            <td style="width: 40%; vertical-align: top; padding-top: 10px;">
                                Lampiran <span style="margin-left: 5px;">:</span>
                            </td>
                        </tr>
                    </table>

                    <!-- Items Table -->
                    <table class="items-table">
                        <tr>
                            <th style="width: 5%;">No<br>Urut</th>
                            <th style="width: 50%;">Keterangan</th>
                            <th style="width: 20%;">Sub Total</th>
                            <th style="width: 25%; font-size: 14px;">JUMLAH</th>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td style="font-weight: bold;">BEBAN UPAH KEBUN {{ strtoupper($pengajuan->kebun->lokasi) }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            @if($penggajian)
                            <td style="font-weight: bold;">PERIODE : {{ \Carbon\Carbon::parse($penggajian->tanggal_mulai)->format('d') }}-{{ \Carbon\Carbon::parse($penggajian->tanggal_akhir)->translatedFormat('d F Y') }}</td>
                            @else
                            <td style="font-weight: bold;">PERIODE : {{ \Carbon\Carbon::parse($pengajuan->tanggal)->translatedFormat('F Y') }}</td>
                            @endif
                            <td></td>
                            <td></td>
                        </tr>

                        @foreach($grouped as $tipe => $jumlah)
                        <tr>
                            <td></td>
                            <td>{{ strtoupper($tipe) }}</td>
                            <td>
                                <span class="flex-rp">Rp</span>
                                <span class="flex-nominal">{{ number_format($jumlah, 0, ',', '.') }}</span>
                            </td>
                            <td></td>
                        </tr>
                        @endforeach

                        @php 
                            $itemsCount = count($grouped) + 2; 
                            $emptyRows = 6 - $itemsCount;
                        @endphp
                        @for($i=0; $i<$emptyRows; $i++)
                        <tr>
                            <td>&nbsp;</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endfor

                        <!-- Footer integrated into Items Table -->
                        <tr>
                            <td colspan="3" style="padding: 10px; border-right: 2px solid black;">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td style="width: 20%; border: none; font-weight: bold; font-size: 16px; font-style: italic; vertical-align: middle;">
                                            Terbilang
                                        </td>
                                        <td style="width: 80%; border: none;">
                                            <div style="background-color: #f0f0f0; padding: 10px 10px; font-weight: bold; font-style: italic; font-size: 13px; min-height: 20px;">
                                                {{ trim(ucwords(terbilang($total))) }}
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="text-align: center; vertical-align: top; padding: 10px 5px; border-bottom: 2px solid black;">
                                <div style="font-weight: bold; font-size: 14px; text-align: right; margin-bottom: 5px;">
                                    <span class="flex-rp">Rp</span>
                                    <span class="flex-nominal">{{ number_format($total, 0, ',', '.') }}</span>
                                    <div style="clear: both;"></div>
                                </div>
                                <div style="font-weight: bold; margin-bottom: 40px; text-align: center;">Dibukukan Oleh</div>
                                <div style="font-size: 11px; font-weight: bold; text-decoration: underline; text-align: center;">Edmon</div>
                                <div style="font-size: 10px; text-align: center; margin-top: 2px;">SPV Accounting</div>
                            </td>
                        </tr>
                    </table>

                    <!-- Signatures Table -->
                    <table class="sign-table">
                        <tr>
                            <td style="width: 17%;" class="header-cell">DIAJUKAN OLEH :</td>
                            <td style="width: 17%;" class="header-cell">DIPERIKSA OLEH :</td>
                            <td style="width: 32%;" class="header-cell" colspan="2">DIKETAHUI OLEH :</td>
                            <td style="width: 17%;" class="header-cell">DISETUJUI OLEH :</td>
                            <td style="width: 17%;" class="header-cell">DIBAYAR OLEH :</td>
                        </tr>
                        <tr>
                            <td style="height: 60px; vertical-align: bottom;">
                                <strong>Aldo</strong><br><span style="font-size: 9px;">Spv.Op Kebun</span>
                            </td>
                            <td style="vertical-align: bottom;">
                                <strong>Hendry</strong><br><span style="font-size: 9px;">Spv.Finance</span>
                            </td>
                            <td style="width: 16%; border-right: 1px solid black; vertical-align: bottom;">
                                <strong>David</strong><br><span style="font-size: 9px;">Manager F&A</span>
                            </td>
                            <td style="width: 16%; vertical-align: bottom;">
                                <strong>Stanly</strong><br><span style="font-size: 9px;">PIC Perkebunan</span>
                            </td>
                            <td style="vertical-align: bottom;">
                                <strong>Willy</strong><br><span style="font-size: 9px;">Dir. F&A Audit</span>
                            </td>
                            <td style="vertical-align: bottom;">
                                <strong>Prisillia</strong><br><span style="font-size: 9px;">Admin Kebun</span>
                            </td>
                        </tr>
                    </table>

                </div>
            </td>
        </tr>
    </table>

</body>
</html>
