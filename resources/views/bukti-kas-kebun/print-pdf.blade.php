<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengeluaran Kas Kebun - {{ $bukti_kas_kebun->no_bukti ?: $bukti_kas_kebun->id }}</title>
    <style>
        @page { size: A5 landscape; margin: 10px 20px 10px 10px; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #000; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        
        /* Rotated text */
        .rotated-text {
            -webkit-transform: rotate(-90deg);
            transform: rotate(-90deg);
            font-size: 16px;
            font-weight: bold;
            font-style: italic;
            letter-spacing: 2px;
            white-space: nowrap;
            width: 300px;
            text-align: center;
            position: absolute;
            top: 250px;
            left: -130px;
        }

        .main-box {
            border: 2px solid #000;
            width: 100%;
        }

        /* Header table */
        .header-table td {
            border-bottom: 2px solid black;
            border-right: 2px solid black;
        }
        .header-table td:last-child {
            border-right: none;
        }

        /* Sub header */
        .sub-header-table td {
            border-bottom: 2px solid black;
            border-right: 2px solid black;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 11px;
        }
        .sub-header-table td:last-child {
            border-right: none;
        }

        /* Items table */
        .items-table th, .items-table td {
            border-bottom: 1px solid black;
            border-right: 2px solid black;
        }
        .items-table td:last-child, .items-table th:last-child {
            border-right: none;
        }
        .items-table th {
            border-bottom: 2px solid black;
            padding: 4px;
            text-align: center;
            font-weight: bold;
            font-style: italic;
        }
        .items-table td {
            padding: 3px 5px;
        }

        /* Signature block */
        .sign-table td {
            border-right: 2px solid black;
            padding: 2px;
            text-align: center;
        }
        .sign-table td:last-child {
            border-right: none;
        }
        .sign-table .header-cell {
            border-bottom: 2px solid black;
            font-weight: bold;
            font-size: 10px;
            padding: 3px;
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
        
        if (!$penggajian) {
            foreach($pengajuan->items as $item) {
                if (preg_match('/PER (.*?) S\/D (.*?)$/i', $item->uraian, $matches)) {
                    try {
                        $start = \Carbon\Carbon::parse($matches[1])->format('Y-m-d');
                        $end = \Carbon\Carbon::parse($matches[2])->format('Y-m-d');
                        $found = \App\Models\Penggajian::where('tanggal_mulai', $start)
                            ->where('tanggal_akhir', $end)
                            ->first();
                        if ($found) {
                            $penggajian = $found;
                            break;
                        }
                    } catch(\Exception $e) {}
                }
            }
        }
        
        $grouped = [];
        $total = 0;
        
        if ($penggajian && $penggajian->details) {
            foreach($penggajian->details as $detail) {
                // Determine Tipe Gaji
                $tipePekerjaan = $detail->tipe_pekerjaan ?: 'Lain-lain';

                // Determine Jabatan Name exactly like in the modal description
                $jabatanName = $detail->jabatan;
                if (!$jabatanName || strtolower($jabatanName) === 'harian' || strtolower($jabatanName) === 'borongan') {
                    $relJabatan = $detail->karyawan->jabatans->first()->nama ?? null;
                    if ($relJabatan) {
                        $jabatanName = $relJabatan;
                    } else {
                        $jabatanName = $detail->tipe_pekerjaan ?: 'Lain-lain';
                    }
                }
                
                // If it still resolves to just 'Harian', format it as 'Harian Kumpul' to be more descriptive per user request
                if (strtolower($jabatanName) === 'harian') {
                    $jabatanName = 'Harian Kumpul';
                }
                
                if(!isset($grouped[$tipePekerjaan])) {
                    $grouped[$tipePekerjaan] = [];
                }
                if(!isset($grouped[$tipePekerjaan][$jabatanName])) {
                    $grouped[$tipePekerjaan][$jabatanName] = 0;
                }
                $grouped[$tipePekerjaan][$jabatanName] += $detail->total_upah;
                $total += $detail->total_upah;
            }
        } else {
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
            <td style="width: 30px; vertical-align: middle; padding: 0;">
                <div style="position: relative; width: 30px; height: 100%;">
                    <div class="rotated-text">
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
                            <td style="width: 60%;">
                                Perkiraan No <span style="margin-left: 5px; font-weight: normal; letter-spacing: 2px;">: ...........................................................</span>
                            </td>
                            <td style="width: 40%; vertical-align: top;">
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

                        @foreach($grouped as $tipe => $items)
                            @if(is_array($items))
                                <tr>
                                    <td></td>
                                    <td style="font-weight: bold;">UPAH {{ strtoupper($tipe) }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach($items as $jabatan => $jumlah)
                                <tr>
                                    <td></td>
                                    <td style="padding-left: 15px;">- {{ strtoupper($jabatan) }}</td>
                                    <td>
                                        <span class="flex-rp">Rp</span>
                                        <span class="flex-nominal">{{ number_format($jumlah, 0, ',', '.') }}</span>
                                    </td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td></td>
                                    <td>{{ strtoupper($tipe) }}</td>
                                    <td>
                                        <span class="flex-rp">Rp</span>
                                        <span class="flex-nominal">{{ number_format($items, 0, ',', '.') }}</span>
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
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

                        <!-- Footer: Jumlah Total -->
                        <tr>
                            <td colspan="2" style="border-right: 2px solid black; border-bottom: 2px solid black;"></td>
                            <td style="text-align: center; font-weight: bold; font-size: 14px; font-style: italic; border-right: 2px solid black; border-bottom: 2px solid black; padding: 5px 10px;">
                                J u m l a h
                            </td>
                            <td style="text-align: right; padding: 5px; border-bottom: 2px solid black; font-weight: bold; font-size: 14px;">
                                <span class="flex-rp">Rp</span>
                                <span class="flex-nominal">{{ number_format($total, 0, ',', '.') }}</span>
                                <div style="clear: both;"></div>
                            </td>
                        </tr>
                        <!-- Footer: Terbilang + Dibukukan Oleh + Diterima Oleh (sejajar) -->
                        <tr>
                            <td colspan="4" style="padding: 0; border-bottom: 2px solid black;">
                                <table style="width: 100%; border-collapse: collapse; border: none;">
                                    <tr>
                                        <td style="width: 50%; padding: 5px 10px; border-right: 2px solid black; vertical-align: top;">
                                            <table style="width: 100%; border: none;">
                                                <tr>
                                                    <td style="width: 25%; border: none; font-weight: bold; font-size: 14px; font-style: italic; vertical-align: top;">
                                                        Terbilang
                                                    </td>
                                                    <td style="width: 75%; border: none;">
                                                        <div style="background-color: #d3d3d3; padding: 6px 10px; font-weight: bold; font-style: italic; font-size: 11px; min-height: 15px;">
                                                            {{ trim(ucwords(terbilang($total))) }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td style="width: 25%; text-align: center; vertical-align: top; padding: 5px; border-right: 2px solid black;">
                                            <div style="font-size: 9px; font-weight: bold; text-align: center;">
                                                Dibukukan Oleh
                                            </div>
                                            <br><br><br><br>
                                            <strong>Edmon</strong><br><span style="font-size: 9px;">SPV Accounting</span>
                                        </td>
                                        <td style="width: 25%; text-align: center; vertical-align: top; padding: 5px;">
                                            <div style="font-size: 9px; font-weight: bold; text-align: center;">
                                                Diterima Oleh
                                            </div>
                                            <br><br><br><br><br>
                                            <strong>......</strong>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <!-- Signature Table directly below -->
                    <table class="sign-table">
                        <tr>
                            <td style="width: 17%;" class="header-cell">DIAJUKAN OLEH :</td>
                            <td style="width: 17%;" class="header-cell">DIPERIKSA OLEH :</td>
                            <td style="width: 32%;" class="header-cell" colspan="2">DIKETAHUI OLEH :</td>
                            <td style="width: 17%;" class="header-cell">DISETUJUI OLEH :</td>
                            <td style="width: 17%;" class="header-cell">DIBAYAR OLEH :</td>
                        </tr>
                        <tr>
                            <td style="height: 80px; vertical-align: bottom;">
                                <strong>Aldo</strong><br><span style="font-size: 9px;">Spv. Ops Kebun</span>
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
