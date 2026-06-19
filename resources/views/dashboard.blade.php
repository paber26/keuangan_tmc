@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan operasional perkebunan Anda')

@section('content')
<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Karyawan Aktif</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPekerjaAktif }} <span class="text-lg text-gray-500 font-normal">orang</span></h3>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Kehadiran Hari Ini</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $kehadiranHariIni }} <span class="text-lg text-gray-500 font-normal">orang</span></h3>
            </div>
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Pohon Dipanjat (Bln Ini)</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($pohonBulanIni, 0, ',', '.') }} <span class="text-lg text-gray-500 font-normal">pohon</span></h3>
            </div>
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Kelapa Dikupas (Bln Ini)</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($kupasBulanIni, 0, ',', '.') }} <span class="text-lg text-gray-500 font-normal">butir</span></h3>
            </div>
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center text-purple-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tren Panen 6 Bulan Terakhir</h3>
        <div id="harvestChart" class="w-full h-72"></div>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Komposisi Pekerja (Bulan Ini)</h3>
        <div id="jobChart" class="w-full h-72 flex justify-center items-center"></div>
    </div>
</div>

<!-- Tables -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
        <a href="{{ route('absensi.index') }}" class="text-sm text-emerald-600 font-medium hover:text-emerald-700">Lihat semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Nama Karyawan</th>
                    <th class="px-6 py-3">Jabatan</th>
                    <th class="px-6 py-3">Lokasi/Kebun</th>
                    <th class="px-6 py-3 text-right">Volume</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($aktivitasTerbaru as $aktivitas)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($aktivitas->tanggal)->format('d M Y') }}</td>
                    <td class="px-6 py-3 text-gray-800 font-medium">{{ $aktivitas->karyawan->nama ?? 'N/A' }}</td>
                    <td class="px-6 py-3">
                        <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded text-xs">{{ $aktivitas->jabatan }}</span>
                    </td>
                    <td class="px-6 py-3">{{ $aktivitas->lokasi ?? '-' }}</td>
                    <td class="px-6 py-3 text-right font-medium text-emerald-600">{{ number_format($aktivitas->volume, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Area Chart
        var harvestOptions = {
            series: [{
                name: 'Panen (pohon)',
                data: @json($trenPanen)
            }],
            chart: {
                height: 280,
                type: 'area',
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
            },
            colors: ['#10b981'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.05,
                    stops: [0, 100]
                }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: @json($trenBulanLabels),
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                labels: { formatter: function (val) { return val.toLocaleString('id-ID'); } }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
            }
        };
        var harvestChart = new ApexCharts(document.querySelector("#harvestChart"), harvestOptions);
        harvestChart.render();

        // Donut Chart
        var jobOptions = {
            series: @json($komposisiData),
            labels: @json($komposisiLabels),
            chart: {
                type: 'donut',
                height: 280,
                fontFamily: 'Inter, sans-serif',
            },
            colors: ['#3b82f6', '#f59e0b', '#8b5cf6', '#64748b', '#10b981', '#ec4899'],
            plotOptions: {
                pie: {
                    donut: { size: '65%' }
                }
            },
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                markers: { radius: 12 }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toLocaleString('id-ID') + " absensi";
                    }
                }
            }
        };
        var jobChart = new ApexCharts(document.querySelector("#jobChart"), jobOptions);
        jobChart.render();
    });
</script>
@endpush
