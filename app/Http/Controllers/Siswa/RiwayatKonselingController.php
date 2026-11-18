<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingKonseling;

class RiwayatKonselingController extends Controller
{
    public function index()
    {
        $siswaId = auth()->user()->siswa->id;

        $riwayat = BookingKonseling::with(['jadwal.guru'])
            ->where('siswa_id', $siswaId)
            ->whereHas('jadwal', function ($query) {
                $query->where('status', 'selesai');
            })
            // Urutkan berdasarkan tanggal terbaru ke terlama
            ->get()
            ->sortByDesc(function ($booking) {
                return $booking->jadwal->tanggal . ' ' . $booking->jadwal->jam_mulai;
            });

        return view('Siswa.RiwayatKonseling.Index', compact('riwayat'));
    }
}
