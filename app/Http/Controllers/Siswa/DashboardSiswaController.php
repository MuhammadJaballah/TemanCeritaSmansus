<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingKonseling;
use App\Models\PrediksiJurusan;
use Carbon\Carbon;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $siswaId = auth()->user()->siswa->id;

        // Jadwal Mendatang (Disetujui)
        $jadwalMendatangCount = BookingKonseling::where('siswa_id', $siswaId)
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'disetujui');
            })->count();

        // Sesi Berlangsung (Menunggu)
        $sesiMenungguCount = BookingKonseling::where('siswa_id', $siswaId)
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'menunggu');
            })->count();

        // Riwayat (Selesai)
        $riwayatCount = BookingKonseling::where('siswa_id', $siswaId)
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'selesai');
            })->count();

        // Data Jadwal Mendatang (Disetujui/Menunggu)
        $jadwalMendatang = BookingKonseling::with('jadwal.guru')
            ->where('siswa_id', $siswaId)
            ->whereHas('jadwal', function ($q) {
                $q->whereIn('status', ['menunggu', 'disetujui'])
                  ->where('tanggal', '>=', Carbon::today());
            })
            ->get()
            ->sortBy(function ($booking) {
                return $booking->jadwal->tanggal . ' ' . $booking->jadwal->jam_mulai;
            })
            ->take(3); // Tampilkan 3 jadwal terdekat

        // Data Riwayat Terakhir (Selesai)
        $riwayatTerakhir = BookingKonseling::with('jadwal.guru')
            ->where('siswa_id', $siswaId)
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'selesai');
            })
            ->orderBy('created_at', 'desc')
            ->take(3) // Tampilkan 3 riwayat terbaru
            ->get();

        // Prediksi Jurusan Terbaru
        $prediksiTerbaru = PrediksiJurusan::where('siswa_id', $siswaId)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        return view('Siswa.dashboard', compact(
            'jadwalMendatangCount',
            'sesiMenungguCount',
            'riwayatCount',
            'jadwalMendatang',
            'riwayatTerakhir',
            'prediksiTerbaru'
        ));
    }
}
