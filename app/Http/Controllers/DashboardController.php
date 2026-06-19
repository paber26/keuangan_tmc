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

        // 2. Pohon Dipanjat (Bulan Ini)
        $pohonBulanIni = Absensi::where('jabatan', 'Pemanjat Kelapa')
            ->whereMonth('tanggal', $thisMonth)
            ->whereYear('tanggal', $thisYear)
            ->sum('volume');

        // 4. Kelapa Dikupas (Bulan Ini)
        $kupasBulanIni = Absensi::where('jabatan', 'Kupas Kelapa')
            ->whereMonth('tanggal', $thisMonth)
            ->whereYear('tanggal', $thisYear)
            ->sum('volume');

        // Tren Panen & Kupas (6 Bulan Terakhir)
        $trenPanen = [];
        $trenKupas = [];
        $trenBulanLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $sumPanen = Absensi::where('jabatan', 'Pemanjat Kelapa')
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('volume');
            $sumKupas = Absensi::where('jabatan', 'Kupas Kelapa')
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->sum('volume');
                
            $trenPanen[] = $sumPanen;
            $trenKupas[] = $sumKupas;
            $trenBulanLabels[] = $month->translatedFormat('M y');
        }

        // Aktivitas Terbaru
        $aktivitasTerbaru = Absensi::with('karyawan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPekerjaAktif',
            'pohonBulanIni',
            'kupasBulanIni',
            'trenPanen',
            'trenKupas',
            'trenBulanLabels',
            'aktivitasTerbaru'
        ));
    }
}
