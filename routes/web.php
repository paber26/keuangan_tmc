<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (DUMMY UI MODE)
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/login', function() { return view('auth.login'); })->name('login');
Route::post('/login', function() { return redirect()->route('dashboard')->with('success', 'Berhasil login!'); });
Route::post('/logout', function() { return redirect()->route('login'); })->name('logout');

// Dashboard
Route::get('/', function() { return view('dashboard'); })->name('dashboard');

use App\Http\Controllers\KebunController;
use App\Http\Controllers\KaryawanController;

// Master Data
Route::resource('kebun', KebunController::class);
Route::resource('karyawan', KaryawanController::class);
Route::get('/komoditas', function() { return view('dashboard'); })->name('komoditas.index'); // Placeholder
Route::get('/tarif-kupas', function() { return view('dashboard'); })->name('tarif-kupas.index'); // Placeholder

// Pencatatan Harian
Route::get('/absensi', function() { return view('absensi.index'); })->name('absensi.index');
Route::get('/panen', function() { return view('dashboard'); })->name('panen.index'); // Placeholder

// Penggajian
Route::get('/penggajian/gaji-bulanan', function() { return view('dashboard'); })->name('gaji.index'); // Placeholder
Route::get('/penggajian/upah-harian', function() { return view('dashboard'); })->name('upah-harian.index'); // Placeholder
Route::get('/penggajian/upah-borongan', function() { return view('upah-borongan.index'); })->name('upah-borongan.index');

use App\Http\Controllers\LaporanController;

// Keuangan & Laporan
Route::get('/transaksi', function() { return view('dashboard'); })->name('transaksi.index'); // Placeholder
Route::get('/laporan/rekap-mingguan', [LaporanController::class, 'index'])->name('laporan.rekap-mingguan');
Route::get('/laporan/rekap-mingguan/word', [LaporanController::class, 'exportWord'])->name('laporan.rekap-mingguan.word');
