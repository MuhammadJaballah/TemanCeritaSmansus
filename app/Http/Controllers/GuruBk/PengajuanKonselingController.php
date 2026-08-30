<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\BookingKonseling;
use App\Models\JadwalKonseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanKonselingController extends Controller
{
    /**
     * Display a listing of the counseling requests.
     */
    public function index()
    {
        $guruId = Auth::user()->guru->id;

        // Ambil semua booking yang jadwalnya milik guru yang sedang login dan berstatus 'menunggu'
        $pengajuans = BookingKonseling::with(['siswa', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId)
                      ->where('status', 'menunggu');
            })
            ->latest()
            ->get();

        return view('GuruBk.PengajuanKonseling.Index', compact('pengajuans'));
    }

    /**
     * Terima pengajuan konseling.
     */
    public function terima(Request $request, $id)
    {
        $booking = BookingKonseling::findOrFail($id);
        
        // Pastikan jadwal ini milik guru yang sedang login
        if ($booking->jadwal->guru_id !== Auth::user()->guru->id) {
            abort(403, 'Unauthorized action.');
        }

        // Ubah status jadwal menjadi disetujui
        $booking->jadwal->update([
            'status' => 'disetujui'
        ]);

        return redirect()->route('guru.pengajuan.index')
            ->with('success', 'Pengajuan konseling berhasil diterima.');
    }

    /**
     * Tolak/Batalkan pengajuan konseling.
     */
    public function tolak(Request $request, $id)
    {
        $booking = BookingKonseling::findOrFail($id);
        
        // Pastikan jadwal ini milik guru yang sedang login
        if ($booking->jadwal->guru_id !== Auth::user()->guru->id) {
            abort(403, 'Unauthorized action.');
        }

        $jadwal = $booking->jadwal;

        // Hapus data booking (karena ditolak)
        $booking->delete();

        // Kembalikan status jadwal menjadi tersedia agar siswa lain bisa memesan
        $jadwal->update([
            'status' => 'tersedia'
        ]);

        return redirect()->route('guru.pengajuan.index')
            ->with('success', 'Pengajuan konseling berhasil ditolak dan dibatalkan.');
    }
}
