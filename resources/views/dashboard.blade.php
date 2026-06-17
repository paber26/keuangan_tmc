@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan keuangan perkebunan Anda')

@section('content')
<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pemasukan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 45.800.000</h3>
            </div>
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-emerald-500 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                +12.5%
            </span>
            <span class="text-gray-400 ml-2">vs bulan lalu</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 28.350.000</h3>
            </div>
            <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center text-rose-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm">
            <span class="text-rose-500 font-medium flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                -3.2%
            </span>
            <span class="text-gray-400 ml-2">vs bulan lalu</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Saldo Bulan Ini</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">Rp 17.450.000</h3>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 stat-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-medium text-gray-500">Gaji Belum Dibayar</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">5 <span class="text-lg text-gray-500 font-normal">orang</span></h3>
            </div>
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
        </div>
        <div class="mt-4">
            <a href="#" class="text-sm text-amber-600 font-medium hover:text-amber-700">Lihat detail &rarr;</a>
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
        <h3 class="text-lg font-bold text-gray-800 mb-4">Komposisi Pengeluaran</h3>
        <div id="expenseChart" class="w-full h-72 flex justify-center items-center"></div>
    </div>
</div>

<!-- Tables -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Panen Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Panen Terbaru</h3>
            <a href="#" class="text-sm text-emerald-600 font-medium hover:text-emerald-700">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Kebun</th>
                        <th class="px-6 py-3">Komoditas</th>
                        <th class="px-6 py-3 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 whitespace-nowrap">17 Jun 2026</td>
                        <td class="px-6 py-3 text-gray-800 font-medium">Kebun Raya Utama</td>
                        <td class="px-6 py-3">Kelapa Butiran</td>
                        <td class="px-6 py-3 text-right font-medium text-emerald-600">1.250 btr</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 whitespace-nowrap">16 Jun 2026</td>
                        <td class="px-6 py-3 text-gray-800 font-medium">Kebun Pantai Selatan</td>
                        <td class="px-6 py-3">Kopra</td>
                        <td class="px-6 py-3 text-right font-medium text-emerald-600">450 kg</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 whitespace-nowrap">15 Jun 2026</td>
                        <td class="px-6 py-3 text-gray-800 font-medium">Kebun Bukit Indah</td>
                        <td class="px-6 py-3">Kelapa Butiran</td>
                        <td class="px-6 py-3 text-right font-medium text-emerald-600">800 btr</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Upah Belum Dibayar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-lg font-bold text-gray-800">Upah Belum Dibayar</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Tipe</th>
                        <th class="px-6 py-3 text-right">Total Upah</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium text-gray-800">Ahmad Sutoyo</td>
                        <td class="px-6 py-3"><span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">Borongan</span></td>
                        <td class="px-6 py-3 text-right font-medium">Rp 450.000</td>
                        <td class="px-6 py-3 text-center"><button class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded-lg">Bayar</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium text-gray-800">Budi Santoso</td>
                        <td class="px-6 py-3"><span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs">Harian</span></td>
                        <td class="px-6 py-3 text-right font-medium">Rp 300.000</td>
                        <td class="px-6 py-3 text-center"><button class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded-lg">Bayar</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 font-medium text-gray-800">Candra Wijaya</td>
                        <td class="px-6 py-3"><span class="bg-amber-100 text-amber-700 px-2 py-1 rounded text-xs">Harian</span></td>
                        <td class="px-6 py-3 text-right font-medium">Rp 150.000</td>
                        <td class="px-6 py-3 text-center"><button class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded-lg">Bayar</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Rekap Minggu Ini -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Rekap Aktivitas Minggu Ini</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-100">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Hadir Karyawan</p>
                <p class="text-xl font-bold text-gray-800">45 <span class="text-sm font-normal text-gray-500">hari kerja</span></p>
            </div>
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-blue-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-100">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Kupas Kelapa</p>
                <p class="text-xl font-bold text-gray-800">3.250 <span class="text-sm font-normal text-gray-500">butir</span></p>
            </div>
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-purple-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
        </div>
        <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-between border border-gray-100">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Panen Kelapa</p>
                <p class="text-xl font-bold text-gray-800">1.800 <span class="text-sm font-normal text-gray-500">butir</span></p>
            </div>
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-emerald-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Area Chart
        var harvestOptions = {
            series: [{
                name: 'Panen (butir)',
                data: [8500, 9200, 10500, 11000, 9800, 12500]
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
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
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
        var expenseOptions = {
            series: [12000000, 5500000, 4800000, 6050000],
            labels: ['Gaji Tetap', 'Upah Harian', 'Upah Borongan', 'Operasional'],
            chart: {
                type: 'donut',
                height: 280,
                fontFamily: 'Inter, sans-serif',
            },
            colors: ['#3b82f6', '#f59e0b', '#8b5cf6', '#64748b'],
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
                        return "Rp " + val.toLocaleString('id-ID');
                    }
                }
            }
        };
        var expenseChart = new ApexCharts(document.querySelector("#expenseChart"), expenseOptions);
        expenseChart.render();
    });
</script>
@endpush
