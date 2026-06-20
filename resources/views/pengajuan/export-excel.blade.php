<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td colspan="5" style="font-weight: bold; font-size: 16px;">PT. TRI MUSTIKA COCOMINAESA</td>
            </tr>
            <tr>
                <td colspan="5">Form Pengajuan Barang &amp; Keperluan</td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="2">Tanggal</td>
                <td colspan="3">: {{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td colspan="2">Keperluan</td>
                <td colspan="3">: {{ $pengajuan->judul_pengajuan }}</td>
            </tr>
            <tr>
                <td colspan="2">Status</td>
                <td colspan="3">: {{ $pengajuan->status }}</td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            @if($pengajuan->keterangan)
            <tr>
                <td colspan="5" style="font-weight: bold;">Catatan Tambahan:</td>
            </tr>
            <tr>
                <td colspan="5">{{ $pengajuan->keterangan }}</td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>
            @endif
            
            <tr>
                <th style="font-weight: bold; background-color: #3B6653; color: #ffffff; text-align: center; border: 1px solid #000000;">No</th>
                <th style="font-weight: bold; background-color: #3B6653; color: #ffffff; text-align: center; border: 1px solid #000000;">Nama Barang / Deskripsi</th>
                <th style="font-weight: bold; background-color: #3B6653; color: #ffffff; text-align: center; border: 1px solid #000000;">Jumlah (Qty)</th>
                <th style="font-weight: bold; background-color: #3B6653; color: #ffffff; text-align: center; border: 1px solid #000000;">Harga Satuan (Rp)</th>
                <th style="font-weight: bold; background-color: #3B6653; color: #ffffff; text-align: center; border: 1px solid #000000;">Total Harga (Rp)</th>
            </tr>
            @php $totalQty = 0; @endphp
            @foreach($pengajuan->items as $index => $item)
            @php $totalQty += $item->qty; @endphp
            <tr>
                <td style="text-align: center; border: 1px solid #000000;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000000;">{{ $item->nama_barang }}</td>
                <td style="text-align: center; border: 1px solid #000000;">{{ $item->qty }}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{ $item->harga_satuan }}</td>
                <td style="text-align: right; border: 1px solid #000000;">{{ $item->total_harga }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold; border: 1px solid #000000;">TOTAL</td>
                <td style="text-align: center; font-weight: bold; border: 1px solid #000000;">{{ $totalQty }}</td>
                <td style="border: 1px solid #000000;"></td>
                <td style="text-align: right; font-weight: bold; border: 1px solid #000000;">{{ $pengajuan->grand_total }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
