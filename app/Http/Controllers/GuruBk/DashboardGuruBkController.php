<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardGuruBkController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru->id;
        
        // 1. Jadwal Hari Ini
        $jadwalHariIni = \App\Models\JadwalKonseling::where('guru_id', $guruId)
            ->whereDate('tanggal', \Carbon\Carbon::today())
            ->count();

        // 2. Pengajuan Baru (menunggu)
        $pengajuanBaru = \App\Models\BookingKonseling::whereHas('jadwal', function($q) use ($guruId) {
            $q->where('guru_id', $guruId)->where('status', 'menunggu');
        })->count();

        // 3. Selesai Bulan Ini
        $selesaiBulanIni = \App\Models\BookingKonseling::whereHas('jadwal', function($q) use ($guruId) {
            $q->where('guru_id', $guruId)->where('status', 'selesai');
        })->whereMonth('created_at', \Carbon\Carbon::now()->month)->count();

        // 4. Rating
        $rating = \App\Models\BookingKonseling::whereHas('jadwal', function($q) use ($guruId) {
            $q->where('guru_id', $guruId);
        })->avg('rating') ?? 0;

        // 5. Jadwal Terdekat (disetujui, belum selesai)
        $jadwalTerdekat = \App\Models\BookingKonseling::with(['siswa', 'jadwal'])
            ->whereHas('jadwal', function($q) use ($guruId) {
                $q->where('guru_id', $guruId)->where('status', 'disetujui')
                  ->where('tanggal', '>=', \Carbon\Carbon::today());
            })
            ->join('jadwal_konselings', 'booking_konselings.jadwal_id', '=', 'jadwal_konselings.id')
            ->orderBy('jadwal_konselings.tanggal', 'asc')
            ->orderBy('jadwal_konselings.jam_mulai', 'asc')
            ->take(3)
            ->get();

        // 6. Distribusi Kategori
        $kategoriStats = \App\Models\BookingKonseling::select('kategori_masalah', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->whereHas('jadwal', function($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->groupBy('kategori_masalah')
            ->get();

        // Format chart data
        $akademik = $kategoriStats->where('kategori_masalah', 'Akademik')->first()->total ?? 0;
        $karier = $kategoriStats->where('kategori_masalah', 'Karier')->first()->total ?? 0;
        $sosial = $kategoriStats->where('kategori_masalah', 'Sosial')->first()->total ?? 0;
        $pribadi = $kategoriStats->where('kategori_masalah', 'Pribadi')->first()->total ?? 0;

        $totalKategori = $akademik + $karier + $sosial + $pribadi;

        return view('GuruBk.dashboard', compact(
            'jadwalHariIni', 'pengajuanBaru', 'selesaiBulanIni', 'rating', 'jadwalTerdekat',
            'akademik', 'karier', 'sosial', 'pribadi', 'totalKategori'
        ));
    }
}
