<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KebunController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\KupasController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group protected routes
Route::middleware('admin.login')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data
    Route::resource('kebun', KebunController::class);
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('pengajuan', PengajuanController::class);
    Route::patch('pengajuan/{pengajuan}/status', [PengajuanController::class, 'updateStatus'])->name('pengajuan.update-status');
    Route::get('pengajuan/{pengajuan}/print', [PengajuanController::class, 'print'])->name('pengajuan.print');
    Route::get('pengajuan/{pengajuan}/excel', [PengajuanController::class, 'exportExcel'])->name('pengajuan.excel');
    Route::get('/komoditas', function() { return view('komoditas.index'); })->name('komoditas.index');
    Route::get('/tarif-kupas', function() { return view('tarif-kupas.index'); })->name('tarif-kupas.index');

    // Pencatatan Harian
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::post('/absensi/add', [AbsensiController::class, 'addKaryawan'])->name('absensi.add');
    Route::post('/absensi/remove', [AbsensiController::class, 'removeKaryawan'])->name('absensi.remove');
    Route::get('/panen', [PanenController::class, 'index'])->name('panen.index');
    Route::get('/kupas', [KupasController::class, 'index'])->name('kupas.index');

    // Manajemen BBM
    Route::resource('pemakaian-bbm', \App\Http\Controllers\PemakaianBBMController::class);
    Route::resource('pengajuan-bbm', \App\Http\Controllers\PengajuanBBMController::class);
    Route::get('pengajuan-bbm/{pengajuan_bbm}/print', [\App\Http\Controllers\PengajuanBBMController::class, 'print'])->name('pengajuan-bbm.print');
    Route::patch('pengajuan-bbm/{pengajuan_bbm}/status', [\App\Http\Controllers\PengajuanBBMController::class, 'updateStatus'])->name('pengajuan-bbm.update-status');

    // Penggajian
    Route::get('/penggajian/gaji-bulanan', function() { return view('gaji.index'); })->name('gaji.index');
    Route::get('/penggajian/upah-harian', function() { return view('upah-harian.index'); })->name('upah-harian.index');
    Route::get('/penggajian/upah-borongan', function() { return view('upah-borongan.index'); })->name('upah-borongan.index');

    // Keuangan & Laporan
    Route::get('/transaksi', function() { return view('transaksi.index'); })->name('transaksi.index');
    Route::get('/laporan/rekap-mingguan', [LaporanController::class, 'index'])->name('laporan.rekap-mingguan');
    Route::get('/laporan/rekap-mingguan/word', [LaporanController::class, 'exportWord'])->name('laporan.rekap-mingguan.word');
    Route::get('/laporan/rekap-mingguan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.rekap-mingguan.pdf');
    Route::get('/laporan/rekap-mingguan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.rekap-mingguan.excel');
});
