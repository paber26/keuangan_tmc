@extends('layouts.app')
@section('page-title', 'Edit Bukti Kas Kebun')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="mb-8">
        <a href="{{ route('bukti-kas-kebun.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-emerald-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Edit Bukti Pengeluaran Kas Kebun</h2>
    </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-red-800">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <p class="font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('bukti-kas-kebun.update', $bukti_kas_kebun->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Terkait Form Pengajuan Dana <span class="text-red-500">*</span></label>
                        <select name="pengajuan_penggajian_id" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                            <option value="">-- Pilih Form Pengajuan Dana --</option>
                            <!-- Selalu tampilkan yang current terlebih dahulu -->
                            <option value="{{ $bukti_kas_kebun->pengajuan_penggajian_id }}" selected>
                                #{{ $bukti_kas_kebun->pengajuan_penggajian->no_dokumen ?: $bukti_kas_kebun->pengajuan_penggajian->id }} - {{ $bukti_kas_kebun->pengajuan_penggajian->perihal }} (Rp {{ number_format($bukti_kas_kebun->pengajuan_penggajian->grand_total, 0, ',', '.') }})
                            </option>
                            @foreach($pengajuans as $p)
                                @if($p->id != $bukti_kas_kebun->pengajuan_penggajian_id && !$p->bukti_kas_kebun)
                                    <option value="{{ $p->id }}">
                                        #{{ $p->no_dokumen ?: $p->id }} - {{ $p->perihal }} (Rp {{ number_format($p->grand_total, 0, ',', '.') }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Bukti Kas <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($bukti_kas_kebun->tanggal)->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Bukti Kas (Opsional)</label>
                        <input type="text" name="no_bukti" value="{{ old('no_bukti', $bukti_kas_kebun->no_bukti) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none transition-all">
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl shadow-sm transition-all focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
