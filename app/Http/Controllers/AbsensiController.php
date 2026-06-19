<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Kebun;
use App\Models\Jabatan;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $lokasiList = Kebun::select('lokasi')->distinct()->whereNotNull('lokasi')->pluck('lokasi');
        $masterJabatans = Jabatan::orderBy('nama')->get();
        
        $selectedLokasi = $request->get('lokasi', $lokasiList->first());
        
        // Weekly mechanism (Monday to Saturday)
        if ($request->has('week') && preg_match('/^(\d{4})-W(\d{2})$/', $request->get('week'), $matches)) {
            $year = $matches[1];
            $week = $matches[2];
            $now = Carbon::now()->setISODate($year, $week);
            $startDate = $now->startOfWeek()->format('Y-m-d');
            $endDate = $now->endOfWeek()->subDay()->format('Y-m-d'); // Monday to Saturday
            $selectedWeek = $request->get('week');
        } else {
            $now = Carbon::now();
            $startDate = $now->startOfWeek()->format('Y-m-d');
            $endDate = $now->endOfWeek()->subDay()->format('Y-m-d'); // Monday to Saturday
            $selectedWeek = $now->format('Y-\WW'); // e.g., 2026-W25
        }
        $karyawans = collect();
        $period = [];
        $absensiData = [];

        $allKaryawans = collect();

        if ($selectedLokasi && $startDate && $endDate) {
            // Get all active workers to populate the "Tambah Pekerja" dropdown (including Borongan like Kupas Kelapa, etc)
            $allKaryawans = Karyawan::where('status', 'Aktif')->get();

            // Create date period
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $period = CarbonPeriod::create($start, $end);

            // Fetch existing attendance records by lokasi
            $absensis = Absensi::with('karyawan')->where('lokasi', $selectedLokasi)
                ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->get();

            // Group the absences by karyawan_id AND jabatan so we can construct the view data
            $absensiData = [];
            $uniquePairs = [];
            
            foreach ($absensis as $absensi) {
                // If it's old data and has no jabatan, fallback to the master data or 'Tidak Diketahui'
                $jabatan = $absensi->jabatan ?: ($absensi->karyawan->jabatans->first()->nama ?? 'Tidak Diketahui');
                
                $absensiData[$absensi->karyawan_id][$jabatan][$absensi->tanggal] = $absensi;
                
                $pairKey = $absensi->karyawan_id . '-' . $jabatan;
                if (!isset($uniquePairs[$pairKey])) {
                    $uniquePairs[$pairKey] = [
                        'karyawan_id' => $absensi->karyawan_id,
                        'jabatan' => $jabatan
                    ];
                }
            }

            // Fetch the karyawans we need
            $karyawanIds = collect($uniquePairs)->pluck('karyawan_id')->unique();
            $karyawansList = Karyawan::whereIn('id', $karyawanIds)->get()->keyBy('id');
            
            $karyawans = collect();
            foreach ($uniquePairs as $pair) {
                $k = $karyawansList->get($pair['karyawan_id']);
                if ($k) {
                    $row = clone $k;
                    $row->jabatan_pekerjaan = $pair['jabatan'];
                    $karyawans->push($row);
                }
            }
        }

        return view('absensi.index', compact(
            'lokasiList',
            'selectedLokasi',
            'startDate',
            'endDate',
            'selectedWeek',
            'karyawans',
            'allKaryawans',
            'period',
            'absensiData',
            'masterJabatans'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Clear existing 'Hadir' and set to 'Alpha' or delete existing to refresh
        // But since we want to keep dummy rows, we first update all existing for the registered karyawans
        Absensi::where('lokasi', $request->lokasi)
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->update(['status' => 'Alpha']);

        // Expected absensi input: absensi[karyawan_id][jabatan_pekerjaan][date_string] = "on"
        $absensiInput = $request->input('absensi', []);

        foreach ($absensiInput as $karyawanId => $jabatanData) {
            foreach ($jabatanData as $jabatanPekerjaan => $dates) {
                foreach ($dates as $date => $val) {
                    if ($val === 'on' || (is_numeric($val) && $val > 0)) {
                        Absensi::updateOrCreate([
                            'lokasi' => $request->lokasi,
                            'karyawan_id' => $karyawanId,
                            'jabatan' => $jabatanPekerjaan,
                            'tanggal' => $date,
                        ], [
                            'status' => 'Hadir',
                            'volume' => is_numeric($val) ? $val : null
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Data absensi berhasil disimpan!');
    }

    public function addKaryawan(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'karyawan_id' => 'required|exists:karyawans,id',
            'jabatan_pekerjaan' => 'required|string|max:255',
        ]);

        // Create a dummy entry for the first day of the period to register them
        // We use status 'Alpha' or a special status so they appear in the sheet but not checked
        Absensi::firstOrCreate([
            'lokasi' => $request->lokasi,
            'karyawan_id' => $request->karyawan_id,
            'jabatan' => $request->jabatan_pekerjaan,
            'tanggal' => $request->start_date,
        ], [
            'status' => 'Alpha'
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan ke lembar absensi!');
    }

    public function removeKaryawan(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'karyawan_id' => 'required|exists:karyawans,id',
            'jabatan_pekerjaan' => 'required|string'
        ]);

        Absensi::where('lokasi', $request->lokasi)
            ->where('karyawan_id', $request->karyawan_id)
            ->where('jabatan', $request->jabatan_pekerjaan)
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->delete();

        return redirect()->back()->with('success', 'Karyawan berhasil dihapus dari lembar absensi!');
    }
}
