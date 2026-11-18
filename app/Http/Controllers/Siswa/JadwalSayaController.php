<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingKonseling;
use Carbon\Carbon;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;

class JadwalSayaController extends Controller
{
    public function index()
    {
        $siswaId = auth()->user()->siswa->id;

        $bookings = BookingKonseling::with(['jadwal.guru'])
            ->where('siswa_id', $siswaId)
            ->whereHas('jadwal', function ($query) {
                // Jangan tampilkan yang batal atau tersedia (kosong)
                $query->whereIn('status', ['menunggu', 'disetujui', 'selesai', 'ditolak']);
            })
            // Urutkan berdasarkan tanggal terdekat
            ->get()
            ->sortBy(function ($booking) {
                return $booking->jadwal->tanggal . ' ' . $booking->jadwal->jam_mulai;
            });

        return view('Siswa.JadwalSaya.Index', compact('bookings'));
    }

    public function destroy($id)
    {
        $siswaId = auth()->user()->siswa->id;
        DB::transaction(function () use ($id, $siswaId) {
            $booking = BookingKonseling::where('siswa_id', $siswaId)->with('jadwal')->findOrFail($id);
            Guru::whereKey($booking->jadwal->guru_id)->lockForUpdate()->firstOrFail();
            $booking->refresh();
            $jadwal = $booking->jadwal()->firstOrFail();
            abort_unless($jadwal->status === 'menunggu', 422, 'Hanya pengajuan yang menunggu yang dapat dibatalkan.');
            $booking->delete();
            $jadwal->update(['status' => 'tersedia']);
        });

        return back()->with('success', 'Jadwal berhasil dibatalkan.');
    }
}
