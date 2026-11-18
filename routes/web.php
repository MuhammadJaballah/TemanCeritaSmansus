<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\GuruBk\DashboardGuruBkController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruBkController;
use App\Http\Controllers\Admin\LaporanKonselingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruBk\JadwalController;
use App\Http\Controllers\GuruBk\PengajuanKonselingController;
use App\Http\Controllers\GuruBk\HasilKonselingController;
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'siswa') return redirect()->route('siswa.dashboard');
    if ($user->role === 'guru') return redirect()->route('guru.dashboard');
    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\Siswa\BookingKonselingController;
use App\Http\Controllers\Siswa\RekomendasiJurusanController;

Route::middleware(['auth', 'verified', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('dashboard');
        
        // Booking Konseling
        Route::get('/booking-konseling', [BookingKonselingController::class, 'create'])->name('booking.create');
        Route::post('/booking-konseling', [BookingKonselingController::class, 'store'])->name('booking.store');

        // Jadwal Saya
        Route::get('/jadwal-saya', [App\Http\Controllers\Siswa\JadwalSayaController::class, 'index'])->name('jadwal.index');
        Route::delete('/jadwal-saya/{id}', [App\Http\Controllers\Siswa\JadwalSayaController::class, 'destroy'])->name('jadwal.destroy');

        // Riwayat Konseling
        Route::get('/riwayat-konseling', [App\Http\Controllers\Siswa\RiwayatKonselingController::class, 'index'])->name('riwayat.index');

        // Feedback
        Route::get('/feedback', [App\Http\Controllers\Siswa\FeedbackController::class, 'index'])->name('feedback.index');
        Route::post('/feedback', [App\Http\Controllers\Siswa\FeedbackController::class, 'store'])->name('feedback.store');

        // Rekomendasi Jurusan
        Route::get('/rekomendasi-jurusan', [RekomendasiJurusanController::class, 'index'])->name('rekomendasi.index');
        Route::post('/rekomendasi-jurusan', [RekomendasiJurusanController::class, 'store'])->name('rekomendasi.store');
    });



Route::middleware(['auth', 'verified', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [DashboardGuruBkController::class, 'index'])->name('dashboard');
        
        // Jadwal Konseling
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal/mingguan', [JadwalController::class, 'store'])->name('jadwal.mingguan.store');
        Route::delete('/jadwal/mingguan/{id}', [JadwalController::class, 'destroy'])->name('jadwal.mingguan.destroy');

        // Pengajuan Konseling (Custom Actions)
        Route::get('/pengajuan-konseling/jumlah-baru', [PengajuanKonselingController::class, 'jumlahBaru'])->name('pengajuan.jumlah-baru');
        Route::get('/pengajuan-konseling', [PengajuanKonselingController::class, 'index'])->name('pengajuan.index');
        Route::patch('/pengajuan-konseling/{id}/terima', [PengajuanKonselingController::class, 'terima'])->name('pengajuan.terima');
        Route::delete('/pengajuan-konseling/{id}/tolak', [PengajuanKonselingController::class, 'tolak'])->name('pengajuan.tolak');

        // Hasil Konseling (dan Riwayat)
        Route::get('/hasil-konseling/export', [HasilKonselingController::class, 'export'])->name('hasil.export');
        Route::resource('hasil-konseling', HasilKonselingController::class)->only(['index', 'store'])->names('hasil');
    });

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    Route::get('/siswa/template-import', [SiswaController::class, 'templateImport'])->name('siswa.template-import');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
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
