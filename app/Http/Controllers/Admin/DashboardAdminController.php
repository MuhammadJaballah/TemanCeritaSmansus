<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $siswaAktif = \App\Models\Siswa::count();
        $guruBk = \App\Models\Guru::count();
        $sesiSelesai = \App\Models\JadwalKonseling::where('status', 'selesai')->count();
        
        $ratingLayanan = \App\Models\BookingKonseling::whereNotNull('rating')->avg('rating') ?? 0;

        // Aktivitas terbaru: 3 sesi konseling terakhir yang selesai
        $aktivitasTerbaru = \App\Models\BookingKonseling::with(['siswa', 'jadwal.guru'])
            ->whereHas('jadwal', function($q) {
                $q->where('status', 'selesai');
            })
            ->latest('updated_at')
            ->take(3)
            ->get();

        return view('Admin.dashboard', compact('siswaAktif', 'guruBk', 'sesiSelesai', 'ratingLayanan', 'aktivitasTerbaru'));
    }
}
