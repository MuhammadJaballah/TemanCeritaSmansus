<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\BookingKonseling;
use App\Models\JadwalKonseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;

class PengajuanKonselingController extends Controller
{
    public function jumlahBaru()
    {
        return response()->json(['jumlah' => BookingKonseling::baruUntukGuru(Auth::user()->guru->id)->count()]);
    }

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

        // Tandai hanya pengajuan yang benar-benar masuk ke daftar ini.
        $dilihat = $pengajuans->map(fn ($pengajuan) => [
            'booking_id' => $pengajuan->id, 'guru_id' => $guruId, 'dilihat_at' => now(),
        ])->all();
        if ($dilihat) {
            DB::table('pengajuan_dilihat_guru')->insertOrIgnore($dilihat);
        }

        return view('GuruBk.PengajuanKonseling.Index', compact('pengajuans'));
    }

    /**
     * Terima pengajuan konseling.
     */
    public function terima(Request $request, $id)
    {
        DB::transaction(function () use ($id) {
            $guruId = Auth::user()->guru->id;
            Guru::whereKey($guruId)->lockForUpdate()->firstOrFail();
            $booking = BookingKonseling::with('jadwal')->findOrFail($id);
            abort_unless($booking->jadwal->guru_id === $guruId, 403);
            abort_unless($booking->jadwal->status === 'menunggu', 422, 'Pengajuan sudah diproses.');
            $booking->jadwal->update(['status' => 'disetujui']);
        });

        return redirect()->route('guru.pengajuan.index')
            ->with('success', 'Pengajuan konseling berhasil diterima.');
    }

    /**
     * Tolak/Batalkan pengajuan konseling.
     */
    public function tolak(Request $request, $id)
    {
        $data = $request->validate(['alasan_penolakan' => 'required|string|max:2000']);
        DB::transaction(function () use ($id, $data) {
            $guruId = Auth::user()->guru->id;
            Guru::whereKey($guruId)->lockForUpdate()->firstOrFail();
            $booking = BookingKonseling::with('jadwal')->findOrFail($id);
            abort_unless($booking->jadwal->guru_id === $guruId, 403);
            abort_unless($booking->jadwal->status === 'menunggu', 422, 'Pengajuan sudah diproses.');
            $booking->update(['alasan_penolakan' => $data['alasan_penolakan']]);
            $booking->jadwal->update(['status' => 'ditolak']);
        });

        return redirect()->route('guru.pengajuan.index')
            ->with('success', 'Pengajuan ditolak dan alasan disampaikan kepada siswa.');
    }
}
