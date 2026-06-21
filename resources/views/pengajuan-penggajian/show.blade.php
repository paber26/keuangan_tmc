@extends('layouts.app')
@section('page-title', 'Detail Pengajuan Dana (Upah)')

@section('content')
<div class="max-w-5xl mx-auto pb-10">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('pengajuan-penggajian.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar
            </a>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight flex items-center gap-3">
                Pengajuan Dana #{{ $pengajuan_penggajian->no_dokumen ?: $pengajuan_penggajian->id }}
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    {{ $pengajuan_penggajian->status === 'Menunggu' ? 'bg-amber-100 text-amber-700' : ($pengajuan_penggajian->status === 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                    {{ $pengajuan_penggajian->status }}
                </span>
            </h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pengajuan-penggajian.print', $pengajuan_penggajian->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-gray-800 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-gray-900 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print PDF
            </a>
            @if($pengajuan_penggajian->status === 'Menunggu')
            <a href="{{ route('pengajuan-penggajian.edit', $pengajuan_penggajian->id) }}" class="inline-flex items-center gap-2 bg-amber-500 text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-amber-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            @endif
        </div>
    </div>

    @if($pengajuan_penggajian->status === 'Menunggu')
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-lg font-bold text-gray-800">Ubah Status</h3>
            <p class="text-sm text-gray-500">Pilih status pengajuan ini (Hanya bisa dilakukan jika masih 'Menunggu').</p>
        </div>
        <form action="{{ route('pengajuan-penggajian.update-status', $pengajuan_penggajian->id) }}" method="POST" class="flex gap-2">
            @csrf
            @method('PATCH')
            <button type="submit" name="status" value="Disetujui" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm" onclick="return confirm('Setujui pengajuan ini?')">Setujui</button>
            <button type="submit" name="status" value="Ditolak" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm" onclick="return confirm('Tolak pengajuan ini?')">Tolak</button>
        </form>
    </div>
    @endif

    <!-- Paper Container -->
    <div class="w-full bg-white p-8 md:p-12 shadow-xl rounded-sm">
        <div class="w-full text-black" style="font-family: 'Arial', sans-serif; font-size: 11px;">
            <style>
                .wrapper-show { width: 100%; border: 2px solid #000; }
                .wrapper-show table { width: 100%; border-collapse: collapse; }
                .wrapper-show td, .wrapper-show th { border: 2px solid #000; padding: 3px; }
                .wrapper-show .no-border { border: none !important; }
                .wrapper-show .text-center { text-align: center; }
                .wrapper-show .text-left { text-align: left; }
                .wrapper-show .text-right { text-align: right; }
                .wrapper-show .font-bold { font-weight: bold; }
                .wrapper-show .uppercase { text-transform: uppercase; }
                
                .wrapper-show .header-table { width: 100%; border-collapse: collapse; border-bottom: 2px solid #000; }
                .wrapper-show .header-table td { border: none; vertical-align: top; padding: 10px; }
                .wrapper-show .logo-cell { width: 25%; text-align: center; }
                .wrapper-show .title-cell { width: 45%; text-align: center; vertical-align: middle; padding-top: 35px; }
                .wrapper-show .doc-info-cell { width: 30%; padding: 0; }
                
                .wrapper-show .doc-info-table { width: 100%; border-collapse: collapse; border: 2px solid #000; font-size: 9px; font-weight: bold; }
                .wrapper-show .doc-info-table td { border: 2px solid #000; padding: 4px; }
                
                .wrapper-show .company-name { font-size: 14px; font-weight: bold; margin: 0 0 4px 0; }
                .wrapper-show .company-address { font-size: 10px; margin: 0; line-height: 1.4; }
                .wrapper-show .form-title { font-size: 16px; font-weight: bold; text-align: center; padding: 8px; text-decoration: underline; margin-top: 5px; margin-bottom: 10px; }
                
                .wrapper-show .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
                .wrapper-show .info-table td { border: none; padding: 3px 5px; font-size: 11px; }
                .wrapper-show .info-label { width: 200px; }
                
                .wrapper-show .items-table { width: 100%; border-collapse: collapse; }
                .wrapper-show .items-table th, .wrapper-show .items-table td { border: 2px solid #000; padding: 5px; }
                .wrapper-show .items-table th { text-align: center; font-weight: bold; }
                .wrapper-show .items-table td { vertical-align: top; }
                
                .wrapper-show .sign-table { width: 100%; border-collapse: collapse; text-align: center; font-size: 11px; margin-top: 0; }
                .wrapper-show .sign-table td { border: 2px solid #000; width: 25%; padding: 5px; }
                .wrapper-show .sign-table .names td { border-top: none; padding-top: 50px; padding-bottom: 5px; font-weight: bold; }
                .wrapper-show .sign-line { border-bottom: 1px solid #000; display: block; margin: 0 auto 2px auto; width: 80%; }
                
                .wrapper-show .rp { float: left; }
                .wrapper-show .nominal { float: right; }
                .wrapper-show .members-text { font-weight: bold; font-size: 10px; margin-top: 5px; }
            </style>
            
            <div class="wrapper-show">
                <table class="header-table">
                    <tr>
                        <td class="logo-cell">
                            @if(file_exists(public_path('logo.jpg')))
                                <img src="{{ asset('logo.jpg') }}" alt="Logo" style="height: 70px;">
                            @else
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
                                    <td>No. Dokumen</td>
                                    <td>: {{ $pengajuan_penggajian->no_dokumen ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Disahkan Tgl</td>
                                    <td>: {{ $pengajuan_penggajian->disahkan_tgl ? \Carbon\Carbon::parse($pengajuan_penggajian->disahkan_tgl)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Berlaku Tgl</td>
                                    <td>: {{ $pengajuan_penggajian->berlaku_tgl ? \Carbon\Carbon::parse($pengajuan_penggajian->berlaku_tgl)->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Revisi</td>
                                    <td>: {{ $pengajuan_penggajian->revisi ?? '0' }}</td>
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
                        <td class="info-label font-bold">Departemen</td>
                        <td class="font-bold">: PERKEBUNAN</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Pengajuan Untuk Kebutuhan</td>
                        <td class="font-bold">: {{ $pengajuan_penggajian->kebun ? $pengajuan_penggajian->kebun->lokasi : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold">Perihal</td>
                        <td class="font-bold">: {{ $pengajuan_penggajian->perihal ?? 'Kebutuhan Biaya Upah' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="font-bold">: {{ $tanggal_indo }}</td>
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
                            <td class="uppercase font-bold">{{ $item->uraian }}</td>
                            <td class="text-center uppercase font-bold">{{ $item->banyak_unit ? (float) $item->banyak_unit : '' }}</td>
                            <td class="text-right uppercase font-bold">{{ $item->harga_satuan ? number_format($item->harga_satuan, 0, ',', '.') : '' }}</td>
                            <td>
                                <span class="rp font-bold">Rp</span>
                                <span class="nominal font-bold">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                <div style="clear: both;"></div>
                            </td>
                            <td class="uppercase font-bold" style="border-right: none;">{{ $item->keterangan }}</td>
                        </tr>
                        @endforeach
                        
                        @php
                            $totalExtraLines = 0;
                            foreach($pengajuan_penggajian->items as $item) {
                                // Keterangan column is ~20% width. At 11px font, ~17 chars per line.
                                $len = strlen($item->keterangan);
                                $lines = ceil($len / 17);
                                if ($lines > 1) {
                                    $totalExtraLines += ($lines - 1);
                                }
                                
                                // Uraian column might also wrap (~25% width, ~22 chars per line)
                                $lenUraian = strlen($item->uraian);
                                $linesUraian = ceil($lenUraian / 22);
                                if ($linesUraian > 1 && $linesUraian > $lines) {
                                    $totalExtraLines += ($linesUraian - max(1, $lines));
                                }
                            }
                            $targetRows = 20 - $totalExtraLines;
                            if ($targetRows < count($pengajuan_penggajian->items)) {
                                $targetRows = count($pengajuan_penggajian->items);
                            }
                        @endphp
                        
                        @for($i = count($pengajuan_penggajian->items) + 1; $i <= $targetRows; $i++)
                        <tr>
                            <td class="text-center font-bold" style="border-left: none; height: 20px;">{{ $i }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="border-right: none;"></td>
                        </tr>
                        @endfor
                        
                        <tr>
                            <td colspan="4" class="text-right font-bold" style="border-left: none; padding-right: 10px;">GRAND TOTAL</td>
                            <td>
                                <span class="rp font-bold">Rp</span>
                                <span class="nominal font-bold">{{ number_format($pengajuan_penggajian->grand_total, 0, ',', '.') }}</span>
                                <div style="clear: both;"></div>
                            </td>
                            <td style="border-right: none;"></td>
                        </tr>
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
        </div>
    </div>
</div>
@endsection
