<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Kebun;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $kebuns = Kebun::where('status', 'Aktif')->get();
        
        $selectedKebunId = $request->get('kebun_id', $kebuns->first()?->id);
        
        // Default to current week (Monday to Saturday) if no date provided
        $now = Carbon::now();
        $startDate = $request->get('start_date', $now->startOfWeek()->format('Y-m-d'));
        $endDate = $request->get('end_date', $now->endOfWeek()->subDay()->format('Y-m-d')); // Mon to Sat

        $karyawans = collect();
        $period = [];
        $absensiData = [];

        $allKaryawans = collect();

        if ($selectedKebunId && $startDate && $endDate) {
            // Get all active workers to populate the "Tambah Pekerja" dropdown (including Borongan like Kupas Kelapa, etc)
            $allKaryawans = Karyawan::where('status', 'Aktif')->get();

            // Create date period
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $period = CarbonPeriod::create($start, $end);

            // Fetch existing attendance records
            $absensis = Absensi::with('karyawan')->where('kebun_id', $selectedKebunId)
                ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->get();

            // Group the absences by karyawan_id AND jabatan so we can construct the view data
            $absensiData = [];
            $uniquePairs = [];
            
            foreach ($absensis as $absensi) {
                // If it's old data and has no jabatan, fallback to the master data or 'Tidak Diketahui'
                $jabatan = $absensi->jabatan ?: ($absensi->karyawan->jabatan ?? 'Tidak Diketahui');
                
                $absensiData[$absensi->karyawan_id][$jabatan][$absensi->tanggal] = $absensi->status;
                
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
            'kebuns', 
            'selectedKebunId', 
            'startDate', 
            'endDate', 
            'karyawans', 
            'allKaryawans',
            'period', 
            'absensiData'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kebun_id' => 'required|exists:kebuns,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Clear existing 'Hadir' and set to 'Alpha' or delete existing to refresh
        // But since we want to keep dummy rows, we first update all existing for the registered karyawans
        Absensi::where('kebun_id', $request->kebun_id)
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->update(['status' => 'Alpha']);

        // Expected absensi input: absensi[karyawan_id][jabatan_pekerjaan][date_string] = "on"
        $absensiInput = $request->input('absensi', []);

        foreach ($absensiInput as $karyawanId => $jabatanData) {
            foreach ($jabatanData as $jabatanPekerjaan => $dates) {
                foreach ($dates as $date => $val) {
                    if ($val === 'on') {
                        Absensi::updateOrCreate([
                            'kebun_id' => $request->kebun_id,
                            'karyawan_id' => $karyawanId,
                            'jabatan' => $jabatanPekerjaan,
                            'tanggal' => $date,
                        ], [
                            'status' => 'Hadir'
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
            'kebun_id' => 'required|exists:kebuns,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'karyawan_id' => 'required|exists:karyawans,id',
            'jabatan_pekerjaan' => 'required|string|max:255',
        ]);

        // Create a dummy entry for the first day of the period to register them
        // We use status 'Alpha' or a special status so they appear in the sheet but not checked
        Absensi::firstOrCreate([
            'kebun_id' => $request->kebun_id,
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
        $kebunId = $request->input('kebun_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $karyawanId = $request->input('karyawan_id');

        if (!$kebunId || !$startDate || !$endDate || !$karyawanId) {
            return redirect()->back()->with('error', 'Data tidak lengkap!');
        }

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        Absensi::where('karyawan_id', $karyawanId)
            ->where('kebun_id', $kebunId)
            ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->delete();

        return redirect()->back()->with('success', 'Karyawan berhasil dihapus dari lembar absensi!');
    }
}
