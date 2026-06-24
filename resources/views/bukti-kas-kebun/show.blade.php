@extends('layouts.app')
@section('page-title', 'Detail Bukti Kas Kebun')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <a href="{{ route('bukti-kas-kebun.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Detail Bukti Kas Kebun</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('bukti-kas-kebun.print', $bukti_kas_kebun->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print PDF (A5)
            </a>
            <a href="{{ route('bukti-kas-kebun.edit', $bukti_kas_kebun->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 hover:text-emerald-600 text-gray-700 text-sm font-semibold rounded-xl shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>
    </div>

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
                $tipePekerjaan = $detail->tipe_pekerjaan ?: 'Lain-lain';
                $jabatanName = $detail->jabatan;
                if (!$jabatanName || strtolower($jabatanName) === 'harian' || strtolower($jabatanName) === 'borongan') {
                    $relJabatan = $detail->karyawan->jabatans->first()->nama ?? null;
                    if ($relJabatan) {
                        $jabatanName = $relJabatan;
                    } else {
                        $jabatanName = $detail->tipe_pekerjaan ?: 'Lain-lain';
                    }
                }
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

        // Terbilang function
        if (!function_exists('penyebutShow')) {
            function penyebutShow($nilai) {
                $nilai = abs($nilai);
                $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                $temp = "";
                if ($nilai < 12) { $temp = " ". $huruf[$nilai]; }
                else if ($nilai < 20) { $temp = penyebutShow($nilai - 10). " Belas"; }
                else if ($nilai < 100) { $temp = penyebutShow($nilai/10)." Puluh". penyebutShow($nilai % 10); }
                else if ($nilai < 200) { $temp = " Seratus" . penyebutShow($nilai - 100); }
                else if ($nilai < 1000) { $temp = penyebutShow($nilai/100) . " Ratus" . penyebutShow($nilai % 100); }
                else if ($nilai < 2000) { $temp = " Seribu" . penyebutShow($nilai - 1000); }
                else if ($nilai < 1000000) { $temp = penyebutShow($nilai/1000) . " Ribu" . penyebutShow($nilai % 1000); }
                else if ($nilai < 1000000000) { $temp = penyebutShow($nilai/1000000) . " Juta" . penyebutShow($nilai % 1000000); }
                else if ($nilai < 1000000000000) { $temp = penyebutShow($nilai/1000000000) . " Milyar" . penyebutShow(fmod($nilai,1000000000)); }
                else if ($nilai < 1000000000000000) { $temp = penyebutShow($nilai/1000000000000) . " Trilyun" . penyebutShow(fmod($nilai,1000000000000)); }
                return $temp;
            }
            function terbilangShow($nilai) {
                if($nilai < 0) { $hasil = "Minus ". trim(penyebutShow($nilai)); }
                else { $hasil = trim(penyebutShow($nilai)); }
                return $hasil . " Rupiah";
            }
        }
    @endphp

    <!-- Paper Container -->
    <div class="w-full bg-white p-6 md:p-10 shadow-xl rounded-sm">
        <div class="w-full text-black" style="font-family: 'Arial', sans-serif; font-size: 11px;">
            <style>
                .wrapper-bkk { width: 100%; border: 2px solid #000; }
                .wrapper-bkk table { width: 100%; border-collapse: collapse; }
                .wrapper-bkk td, .wrapper-bkk th { padding: 3px; }

                .wrapper-bkk .header-table td { border-bottom: 2px solid black; border-right: 2px solid black; }
                .wrapper-bkk .header-table td:last-child { border-right: none; }

                .wrapper-bkk .sub-header-table td { border-bottom: 2px solid black; border-right: 2px solid black; padding: 4px 8px; font-weight: bold; font-size: 11px; }
                .wrapper-bkk .sub-header-table td:last-child { border-right: none; }

                .wrapper-bkk .items-table th, .wrapper-bkk .items-table td { border-bottom: 1px solid black; border-right: 2px solid black; }
                .wrapper-bkk .items-table td:last-child, .wrapper-bkk .items-table th:last-child { border-right: none; }
                .wrapper-bkk .items-table th { border-bottom: 2px solid black; padding: 4px; text-align: center; font-weight: bold; font-style: italic; }
                .wrapper-bkk .items-table td { padding: 3px 5px; }

                .wrapper-bkk .sign-table td { border-right: 2px solid black; padding: 2px; text-align: center; }
                .wrapper-bkk .sign-table td:last-child { border-right: none; }
                .wrapper-bkk .sign-table .header-cell { border-bottom: 2px solid black; font-weight: bold; font-size: 10px; padding: 3px; }

                .wrapper-bkk .flex-rp { display: inline-block; float: left; }
                .wrapper-bkk .flex-nominal { display: inline-block; float: right; }
            </style>

            <div class="wrapper-bkk">
                <!-- Header -->
                <table class="header-table">
                    <tr>
                        <td style="width: 35%; padding: 5px;">
                            <table style="width: 100%; border: none;">
                                <tr>
                                    <td style="width: 40px; border: none; padding: 0;">
                                        @if(file_exists(public_path('logo.jpg')))
                                            <img src="{{ asset('logo.jpg') }}" alt="Logo" style="height: 35px;">
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
                                    <div style="clear: both;"></div>
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
                                    <div style="clear: both;"></div>
                                </td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach

                    @php 
                        $itemsCount = 0;
                        foreach($grouped as $tipe => $items) {
                            $itemsCount++;
                            if(is_array($items)) {
                                $itemsCount += count($items);
                            }
                        }
                        $itemsCount += 2; // header rows
                        $emptyRows = max(0, 6 - $itemsCount);
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
                                                    <div style="background-color: #d3d3d3; border: 1px solid #000; padding: 6px 10px; font-weight: bold; font-style: italic; font-size: 11px; min-height: 15px;">
                                                        {{ trim(ucwords(terbilangShow($total))) }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 25%; text-align: center; vertical-align: top; padding: 5px; border-right: 2px solid black;">
                                        <div style="font-size: 9px; font-weight: bold; text-align: center;">
                                            Dibukukan Oleh
                                        </div>
                                        <br><br>
                                        <strong>Edmon</strong><br><span style="font-size: 9px;">SPV Accounting</span>
                                    </td>
                                    <td style="width: 25%; text-align: center; vertical-align: top; padding: 5px;">
                                        <div style="font-size: 9px; font-weight: bold; text-align: center;">
                                            Diterima Oleh
                                        </div>
                                        <br><br>
                                        <strong>......</strong>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Signature Table -->
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
        </div>
    </div>

</div>
@endsection
