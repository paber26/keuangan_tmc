<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // 1. Total Pekerja Aktif
        $totalPekerjaAktif = Karyawan::count();

        // 2. Kehadiran Hari Ini
        $kehadiranHariIni = Absensi::whereDate('tanggal', $today)->count();

        // 3. Pohon Dipanjat (Bulan Ini)
        $pohonBulanIni = Absensi::where('jabatan', 'Pemanjat Kelapa')
            ->whereMonth('tanggal', $thisMonth)
            ->whereYear('tanggal', $thisYear)
            ->sum('volume');

        // 4. Kelapa Dikupas (Bulan Ini)
        $kupasBulanIni = Absensi::where('jabatan', 'Kupas Kelapa')
            ->whereMonth('tanggal', $thisMonth)
            ->whereYear('tanggal', $thisYear)
            ->sum('volume');

        // Tren Panen (6 Bulan Terakhir)
        $trenPanen = [];
        $trenBulanLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $sum = Absensi::where('jabatan', 'Pemanjat Kelapa')
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('volume');
            $trenPanen[] = $sum;
            $trenBulanLabels[] = $month->translatedFormat('M y');
        }

        // Komposisi Pekerja
        $komposisi = Absensi::select('jabatan', DB::raw('count(*) as total'))
            ->whereMonth('tanggal', $thisMonth)
            ->whereYear('tanggal', $thisYear)
            ->groupBy('jabatan')
            ->get();
            
        $komposisiLabels = $komposisi->pluck('jabatan')->toArray();
        $komposisiData = $komposisi->pluck('total')->toArray();

        // Aktivitas Terbaru
        $aktivitasTerbaru = Absensi::with('karyawan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPekerjaAktif',
            'kehadiranHariIni',
            'pohonBulanIni',
            'kupasBulanIni',
            'trenPanen',
            'trenBulanLabels',
            'komposisiLabels',
            'komposisiData',
            'aktivitasTerbaru'
        ));
    }
}
