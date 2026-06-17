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

        if ($selectedKebunId && $startDate && $endDate) {
            // Get all Harian workers for this kebun. Note: The database doesn't strictly link Karyawan to Kebun ID yet, 
            // but we can just pull all 'Harian' workers or filter by Lokasi if needed. For now, pull all 'Harian' workers.
            // If Lokasi strictly matches Kebun nama, we can filter by that.
            $selectedKebun = Kebun::find($selectedKebunId);
            $karyawans = Karyawan::where('tipe_gaji', 'Harian')
                ->where('status', 'Aktif')
                // ->where('lokasi', $selectedKebun->nama) // Optional: filter by location
                ->get();

            // Create date period
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            $period = CarbonPeriod::create($start, $end);

            // Fetch existing attendance records
            $records = Absensi::where('kebun_id', $selectedKebunId)
                ->whereBetween('tanggal', [$start->format('Y-m-d'), $end->format('Y-m-d')])
                ->get();

            // Structure data for easy view access: $absensiData[karyawan_id][tanggal_string] = status
            foreach ($records as $record) {
                $absensiData[$record->karyawan_id][$record->tanggal] = $record->status;
            }
        }

        return view('absensi.index', compact(
            'kebuns', 
            'selectedKebunId', 
            'startDate', 
            'endDate', 
            'karyawans', 
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
}
