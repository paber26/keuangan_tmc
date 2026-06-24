@extends('layouts.app')
@section('page-title', 'Detail Bukti Bank Kebun')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <a href="{{ route('bukti-bank-kebun.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Detail Bukti Bank Kebun</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('bukti-bank-kebun.print', $bukti_bank_kebun->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print PDF (A5)
            </a>
            <a href="{{ route('bukti-bank-kebun.edit', $bukti_bank_kebun->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 hover:text-emerald-600 text-gray-700 text-sm font-semibold rounded-xl shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>
    </div>

    @php
        $total = $bukti_bank_kebun->grand_total;

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
                            Bukti Pengeluaran Bank Kebun
                        </td>
                        <td style="width: 25%; padding: 5px;">
                            <table style="width: 100%; font-weight: bold; font-size: 12px; border: none;">
                                <tr>
                                    <td style="width: 30px; border: none; padding: 2px;">No</td>
                                    <td style="border: none; padding: 2px;">: {{ $bukti_bank_kebun->no_bukti }}</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 2px;">Tgl</td>
                                    <td style="border: none; padding: 2px;">: {{ \Carbon\Carbon::parse($bukti_bank_kebun->tanggal)->translatedFormat('d F Y') }}</td>
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
                        <td style="font-weight: bold; text-decoration: underline;">{{ strtoupper($bukti_bank_kebun->judul_pengajuan) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    @if($bukti_bank_kebun->keterangan)
                    <tr>
                        <td></td>
                        <td style="font-weight: bold;">{{ $bukti_bank_kebun->keterangan }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif

                    @foreach($bukti_bank_kebun->items as $item)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td style="padding-left: 5px;">- {{ $item->nama_barang }} @if($item->qty > 1) ({{ $item->qty }}x) @endif</td>
                            <td>
                                <span class="flex-rp">Rp</span>
                                <span class="flex-nominal">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                <div style="clear: both;"></div>
                            </td>
                            <td></td>
                        </tr>
                    @endforeach

                    @php 
                        $itemsCount = 1 + ($bukti_bank_kebun->keterangan ? 1 : 0) + count($bukti_bank_kebun->items);
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
                    <!-- Footer: Terbilang + Diajukan + Dibuat -->
                    <tr>
                        <td colspan="4" style="padding: 0; border-bottom: 2px solid black;">
                            <table style="width: 100%; border-collapse: collapse; border: none;">
                                <tr>
                                    <td style="width: 60%; padding: 5px 10px; border-right: 2px solid black; vertical-align: top;">
                                        <table style="width: 100%; border: none;">
                                            <tr>
                                                <td style="width: 25%; border: none; font-weight: bold; font-size: 14px; font-style: italic; vertical-align: top;">
                                                    Terbilang
                                                </td>
                                                <td style="width: 75%; border: none;">
                                                    <div style="background-color: #d3d3d3; padding: 6px 10px; font-weight: bold; font-style: italic; font-size: 11px; min-height: 15px;">
                                                        {{ trim(ucwords(terbilangShow($total))) }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 20%; text-align: center; vertical-align: top; padding: 5px; border-right: 2px solid black;">
                                        <div style="font-size: 9px; font-weight: bold; text-align: center;">
                                            DIAJUKAN OLEH
                                        </div>
                                        <br><br><br>
                                        <strong>Aldo</strong><br><span style="font-size: 9px;">Plantation Operations/ Spv</span>
                                    </td>
                                    <td style="width: 20%; text-align: center; vertical-align: top; padding: 5px;">
                                        <div style="font-size: 9px; font-weight: bold; text-align: center;">
                                            DIBUAT OLEH :
                                        </div>
                                        <br><br><br>
                                        <strong>Prisillia</strong><br><span style="font-size: 9px;">Admin Kebun</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Signature Table -->
                <table class="sign-table">
                    <tr>
                        <td style="width: 20%;" class="header-cell">DIPERIKSA OLEH :</td>
                        <td style="width: 20%;" class="header-cell">DIKETAHUI OLEH :</td>
                        <td style="width: 20%;" class="header-cell">DISETUJUI OLEH</td>
                        <td style="width: 20%;" class="header-cell">DIBAYAR OLEH :</td>
                        <td style="width: 20%;" class="header-cell">DIBUKUKAN OLEH</td>
                    </tr>
                    <tr>
                        <td style="height: 60px; vertical-align: bottom;">
                            <strong>Hendry</strong><br><span style="font-size: 9px;">Finance Supervisor</span>
                        </td>
                        <td style="vertical-align: bottom;">
                            <strong>David</strong><br><span style="font-size: 9px;">F&A Manager</span>
                        </td>
                        <td style="vertical-align: bottom;">
                            <strong>Willy</strong><br><span style="font-size: 9px;">F&A Audit Director</span>
                        </td>
                        <td style="vertical-align: bottom;">
                            <strong>Prisillia</strong><br><span style="font-size: 9px;">Admin Kebun</span>
                        </td>
                        <td style="vertical-align: bottom;">
                            <strong>Edmon</strong><br><span style="font-size: 9px;">Spv / Accounting</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
