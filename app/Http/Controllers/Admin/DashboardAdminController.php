<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKonseling;
use Carbon\CarbonImmutable;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $siswaAktif = \App\Models\Siswa::count();
        $guruBk = \App\Models\Guru::count();
        $sesiSelesai = \App\Models\JadwalKonseling::where('status', 'selesai')->count();
        
        $ratingLayanan = \App\Models\BookingKonseling::whereNotNull('rating')->avg('rating') ?? 0;

        // Count completed sessions by their scheduled date, including months with no sessions.
        $bulanIni = CarbonImmutable::now()->startOfMonth();
        $awalPeriode = $bulanIni->subMonths(5);
        $perTanggal = JadwalKonseling::query()
            ->where('status', 'selesai')
            ->where('tanggal', '>=', $awalPeriode->toDateString())
            ->where('tanggal', '<', $bulanIni->addMonth()->toDateString())
            ->selectRaw('tanggal, count(*) as total')
            ->groupBy('tanggal')
            ->get();
        $perBulan = [];
        foreach ($perTanggal as $baris) {
            $bulan = substr((string) $baris->tanggal, 0, 7);
            $perBulan[$bulan] = ($perBulan[$bulan] ?? 0) + (int) $baris->total;
        }
        $trenLayanan = [];
        for ($i = 0; $i < 6; $i++) {
            $bulan = $awalPeriode->addMonths($i);
            $trenLayanan[] = [
                'label' => $bulan->locale('id')->translatedFormat('M Y'),
                'jumlah' => $perBulan[$bulan->format('Y-m')] ?? 0,
            ];
        }

        // Aktivitas terbaru: 3 sesi konseling terakhir yang selesai
        $aktivitasTerbaru = \App\Models\BookingKonseling::with(['siswa', 'jadwal.guru'])
            ->whereHas('jadwal', function($q) {
                $q->where('status', 'selesai');
            })
            ->latest('updated_at')
            ->take(3)
            ->get();

        return view('Admin.dashboard', compact('siswaAktif', 'guruBk', 'sesiSelesai', 'ratingLayanan', 'aktivitasTerbaru', 'trenLayanan'));
    }
}
