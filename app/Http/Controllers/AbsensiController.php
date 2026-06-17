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
            $records = Absensi::where('kebun_id', $selectedKebunId)
                ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->get();

            // Structure data for easy view access and figure out which Karyawans are assigned
            $assignedKaryawanIds = [];
            foreach ($records as $record) {
                $absensiData[$record->karyawan_id][$record->tanggal] = $record->status;
                if (!in_array($record->karyawan_id, $assignedKaryawanIds)) {
                    $assignedKaryawanIds[] = $record->karyawan_id;
                }
            }

            // Only show karyawans that have an absensi record in this period
            $karyawans = $allKaryawans->whereIn('id', $assignedKaryawanIds)->values();
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
        $kebunId = $request->input('kebun_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $absensiInput = $request->input('absensi', []); // Array of [karyawan_id][tanggal] = 'on'

        if (!$kebunId || !$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Data tidak lengkap!');
        }

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $period = CarbonPeriod::create($start, $end);

        // Fetch all karyawans listed in the form
        $karyawanIds = $request->input('karyawan_ids', []);

        foreach ($karyawanIds as $karyawanId) {
            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');
                $isChecked = isset($absensiInput[$karyawanId][$dateStr]);
                
                $status = $isChecked ? 'Hadir' : 'Alpha';

                // We update or create the record
                Absensi::updateOrCreate(
                    [
                        'karyawan_id' => $karyawanId,
                        'kebun_id' => $kebunId,
                        'tanggal' => $dateStr,
                    ],
                    [
                        'status' => $status
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Data absensi berhasil disimpan!');
    }

    public function addKaryawan(Request $request)
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
        $period = CarbonPeriod::create($start, $end);

        // Add 'Alpha' records for this employee for the whole period to register them in the sheet
        foreach ($period as $date) {
            Absensi::firstOrCreate([
                'karyawan_id' => $karyawanId,
                'kebun_id' => $kebunId,
                'tanggal' => $date->format('Y-m-d'),
            ], [
                'status' => 'Alpha'
            ]);
        }

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
