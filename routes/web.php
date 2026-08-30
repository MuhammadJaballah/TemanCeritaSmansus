<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\GuruBk\DashboardGuruBkController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruBkController;
use App\Http\Controllers\Admin\LaporanKonselingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'siswa') return redirect()->route('siswa.dashboard');
    if ($user->role === 'guru') return redirect()->route('guru.dashboard');
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [DashboardSiswaController::class, 'index'])->name('siswa.dashboard');
});

use App\Http\Controllers\GuruBk\JadwalController;

Route::middleware(['auth', 'verified', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [DashboardGuruBkController::class, 'index'])->name('guru.dashboard');
    Route::get('/guru/jadwal', [JadwalController::class, 'index'])->name('guru.jadwal.index');
    Route::post('/guru/jadwal', [JadwalController::class, 'store'])->name('guru.jadwal.store');
    Route::put('/guru/jadwal/{id}', [JadwalController::class, 'update'])->name('guru.jadwal.update');
    Route::delete('/guru/jadwal/{id}', [JadwalController::class, 'destroy'])->name('guru.jadwal.destroy');
    Route::put('/guru/jadwal/date/{date}', [JadwalController::class, 'updateDate'])->name('guru.jadwal.updateDate');
    Route::delete('/guru/jadwal/date/{date}', [JadwalController::class, 'destroyDate'])->name('guru.jadwal.destroyDate');

    // Pengajuan Konseling
    Route::get('/guru/pengajuan-konseling', [App\Http\Controllers\GuruBk\PengajuanKonselingController::class, 'index'])->name('guru.pengajuan.index');
    Route::patch('/guru/pengajuan-konseling/{id}/terima', [App\Http\Controllers\GuruBk\PengajuanKonselingController::class, 'terima'])->name('guru.pengajuan.terima');
    Route::delete('/guru/pengajuan-konseling/{id}/tolak', [App\Http\Controllers\GuruBk\PengajuanKonselingController::class, 'tolak'])->name('guru.pengajuan.tolak');

    // Hasil Konseling (dan Riwayat)
    Route::get('/guru/hasil-konseling', [App\Http\Controllers\GuruBk\HasilKonselingController::class, 'index'])->name('guru.hasil.index');
    Route::post('/guru/hasil-konseling', [App\Http\Controllers\GuruBk\HasilKonselingController::class, 'store'])->name('guru.hasil.store');
});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruBkController::class);
    Route::get('/laporan', [LaporanKonselingController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanKonselingController::class, 'export'])->name('laporan.export');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
