<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice - {{ $pengajuan->judul_pengajuan }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    </style>
</head>
<body class="bg-white p-8 max-w-4xl mx-auto" onload="window.print()">

    <div class="border border-gray-100 rounded-xl">
        <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start gap-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('logo.jpg') }}" alt="TMC Logo" class="w-16 h-16 object-contain rounded bg-white p-1 border border-gray-100 shadow-sm">
                <div>
                    <h3 class="text-xl font-bold text-emerald-800 mb-1">Perkebunan TMC</h3>
                    <p class="text-sm text-gray-500">Form Pengajuan Barang & Keperluan</p>
                </div>
            </div>
            <div class="md:ml-auto">
                <table class="text-sm text-left">
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Tanggal</td>
                        <td class="text-gray-500 pr-2 pb-1">:</td>
                        <td class="font-medium text-gray-800 pb-1">{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4 pb-1">Keperluan</td>
                        <td class="text-gray-500 pr-2 pb-1">:</td>
                        <td class="font-medium text-gray-800 pb-1">{{ $pengajuan->judul_pengajuan }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-500 pr-4">Status</td>
                        <td class="text-gray-500 pr-2">:</td>
                        <td class="font-medium text-gray-800">
                            <span class="{{ $pengajuan->status == 'Disetujui' ? 'text-emerald-600' : ($pengajuan->status == 'Ditolak' ? 'text-red-600' : 'text-amber-600') }}">
                                {{ $pengajuan->status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        @if($pengajuan->keterangan)
        <div class="px-8 py-4 bg-gray-50/50 border-b border-gray-100">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1">Catatan Tambahan</p>
            <p class="text-sm text-gray-700">{{ $pengajuan->keterangan }}</p>
        </div>
        @endif

        <div class="p-8">
            <div class="overflow-x-auto border border-gray-800">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#3B6653] text-white">
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[50px] text-center">No</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800">Nama Barang / Deskripsi</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[120px] text-center">Jumlah (Qty)</th>
                            <th class="py-2.5 px-4 text-sm font-semibold border-r border-gray-800 w-[180px] text-center">Harga Satuan (Rp)</th>
                            <th class="py-2.5 px-4 text-sm font-semibold w-[200px] text-center">Total Harga (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800 bg-white">
                        @php $totalQty = 0; @endphp
                        @foreach($pengajuan->items as $index => $item)
                        @php $totalQty += $item->qty; @endphp
                        <tr>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-center border-r border-gray-800">{{ $index + 1 }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 border-r border-gray-800">{{ $item->nama_barang }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-center border-r border-gray-800">{{ number_format($item->qty, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-right border-r border-gray-800">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="py-2.5 px-4 text-sm text-gray-800 text-right">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-50 border-t border-gray-800">
                            <td colspan="2" class="py-3 px-4 text-sm font-bold text-gray-800 uppercase border-r border-gray-800">GRAND TOTAL</td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-center border-r border-gray-800">{{ number_format($totalQty, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 border-r border-gray-800"></td>
                            <td class="py-3 px-4 text-sm font-bold text-gray-800 text-right">{{ number_format($pengajuan->grand_total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
