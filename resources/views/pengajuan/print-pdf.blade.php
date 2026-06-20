<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Print Invoice - {{ $pengajuan->judul_pengajuan }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header-table { width: 100%; border-bottom: 1px solid #ccc; padding-bottom: 10px; margin-bottom: 20px; }
        .header-table td { vertical-align: middle; }
        .logo { width: 60px; height: auto; }
        .company-name { font-size: 18px; font-weight: bold; color: #065f46; margin: 0 0 5px 0; padding: 0; }
        .doc-title { font-size: 12px; color: #666; margin: 0; padding: 0; }
        
        .info-table { width: auto; font-size: 12px; }
        .info-table td { padding: 2px 5px 2px 0; }
        .status-badge { font-weight: bold; }
        .status-disetujui { color: #059669; }
        .status-ditolak { color: #dc2626; }
        .status-menunggu { color: #d97706; }

        .catatan { background-color: #f9fafb; padding: 10px; margin-bottom: 20px; border-bottom: 1px solid #eee; }
        .catatan-title { font-size: 10px; font-weight: bold; color: #666; text-transform: uppercase; margin-bottom: 5px; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .items-table th, .items-table td { border: 1px solid #333; padding: 8px; text-align: left; }
        .items-table th { background-color: #3B6653; color: white; text-align: center; font-weight: bold; }
        
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .font-bold { font-weight: bold; }
        .bg-light { background-color: #f9fafb; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="80px">
                @if(file_exists(public_path('logo.jpg')))
                    <img src="{{ public_path('logo.jpg') }}" alt="Logo" class="logo">
                @endif
            </td>
            <td>
                <h3 class="company-name">PT. TRI MUSTIKA COCOMINAESA</h3>
                <p class="doc-title">Form Pengajuan Barang & Keperluan</p>
            </td>
            <td align="right">
                <table class="info-table" align="right">
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>Keperluan</td>
                        <td>:</td>
                        <td>{{ $pengajuan->judul_pengajuan }}</td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

    @if($pengajuan->keterangan)
    <div class="catatan">
        <div class="catatan-title">Catatan Tambahan</div>
        <div>{{ $pengajuan->keterangan }}</div>
    </div>
    @endif

    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="35%">Nama Barang / Deskripsi</th>
                <th width="15%">Jumlah (Qty)</th>
                <th width="20%">Harga Satuan (Rp)</th>
                <th width="25%">Total Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalQty = 0; @endphp
            @foreach($pengajuan->items as $index => $item)
            @php $totalQty += $item->qty; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td class="text-center">{{ number_format($item->qty, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-light">
                <td colspan="2" class="text-right font-bold">TOTAL</td>
                <td class="text-center font-bold">{{ number_format($totalQty, 0, ',', '.') }}</td>
                <td></td>
                <td class="text-right font-bold">{{ number_format($pengajuan->grand_total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
