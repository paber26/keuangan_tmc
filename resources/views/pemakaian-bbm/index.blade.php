@extends('layouts.app')
@section('page-title', 'Data Pemakaian BBM')

@section('content')
<div class="w-full pb-10">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Data Pemakaian BBM</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola pencatatan histori pemakaian BBM harian.</p>
        </div>
        <div class="flex gap-2 items-center">
            <form action="{{ route('pemakaian-bbm.index') }}" method="GET" class="flex gap-2">
                <select name="kategori" onchange="this.form.submit()" class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                    <option value="">Semua Kategori</option>
                    <option value="Kebun" {{ request('kategori') == 'Kebun' ? 'selected' : '' }}>Kebun</option>
                    <option value="Sopir" {{ request('kategori') == 'Sopir' ? 'selected' : '' }}>Sopir</option>
                </select>
            </form>
            <a href="{{ route('pemakaian-bbm.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Laporan
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi Kebun</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Karyawan</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul Laporan</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total Liter</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Total (Rp)</th>
                        <th class="py-4 px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pemakaian as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 text-sm text-gray-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            @if($item->kategori == 'Kebun')
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">Kebun</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">Sopir</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm font-semibold text-emerald-600">
                            {{ $item->kebun ? $item->kebun->lokasi : '-' }}
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-800">{{ $item->karyawan ? $item->karyawan->nama : '-' }}</td>
                        <td class="py-4 px-6">
                            <p class="text-sm font-medium text-gray-800">{{ $item->judul_laporan }}</p>
                            @if($item->keterangan)
                            <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $item->keterangan }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-800 text-right whitespace-nowrap">
                            @php
                                $totalSolar = $item->items->where('tipe_bbm', 'Solar')->sum('jumlah_liter');
                                $totalPertalite = $item->items->where('tipe_bbm', 'Pertalite')->sum('jumlah_liter');
                            @endphp
                            @if($totalSolar > 0)
                                <div><span class="font-medium text-gray-500">Solar:</span> {{ $totalSolar }} L</div>
                            @endif
                            @if($totalPertalite > 0)
                                <div><span class="font-medium text-gray-500">Pertalite:</span> {{ $totalPertalite }} L</div>
                            @endif
                            @if($totalSolar == 0 && $totalPertalite == 0)
                                -
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm font-bold text-gray-800 text-right whitespace-nowrap">Rp {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                        <td class="py-4 px-6 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('pemakaian-bbm.show', $item->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('pemakaian-bbm.edit', $item->id) }}" class="p-1.5 text-amber-600 hover:bg-amber-50 rounded transition-colors" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('pemakaian-bbm.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirmMath(event);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-sm text-gray-500">
                            Belum ada laporan pemakaian BBM.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmMath(event) {
    event.preventDefault();
    const form = event.target;
    const num1 = Math.floor(Math.random() * 10) + 1;
    const num2 = Math.floor(Math.random() * 10) + 1;
    
    Swal.fire({
        title: 'Konfirmasi Penghapusan',
        html: `Anda akan menghapus data ini secara permanen.<br><br>Untuk memvalidasi, ketikkan hasil dari: <b>${num1} + ${num2}</b>`,
        icon: 'warning',
        input: 'number',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus Data',
        cancelButtonText: 'Batal',
        preConfirm: (answer) => {
            if (!answer || parseInt(answer) !== (num1 + num2)) {
                Swal.showValidationMessage('Jawaban salah! Penghapusan dibatalkan.');
                return false;
            }
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script>
@endsection
