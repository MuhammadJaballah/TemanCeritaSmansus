<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\BookingKonseling;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GuruBk\StoreHasilKonselingRequest;

class HasilKonselingController extends Controller
{
    public function index()
    {
        $guruId = Auth::user()->guru->id;

        // Jadwal yang menunggu diinput hasil (status: disetujui)
        $menungguInput = BookingKonseling::with(['siswa', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId)
                      ->where('status', 'disetujui');
            })
            ->latest()
            ->get();

        // Riwayat Konseling (status: selesai atau tersedia jika dibatalkan, namun kita fokus ke yg selesai)
        $riwayat = BookingKonseling::with(['siswa', 'jadwal'])
            ->whereHas('jadwal', function ($query) use ($guruId) {
                $query->where('guru_id', $guruId)
                      ->whereIn('status', ['selesai']);
            })
            ->latest()
            ->get();

        // Statistik
        // Sesi Selesai minggu ini
        $sesiSelesaiMingguIni = $riwayat->filter(function($booking) {
            return $booking->updated_at->isCurrentWeek();
        })->count();

        // Menunggu input
        $jumlahMenungguInput = $menungguInput->count();

        return view('GuruBk.HasilKonseling.Index', compact(
            'menungguInput',
            'riwayat',
            'sesiSelesaiMingguIni',
            'jumlahMenungguInput'
        ));
    }

    public function store(StoreHasilKonselingRequest $request)
    {
        $booking = BookingKonseling::findOrFail($request->booking_id);

        // Validasi otoritas
        if ($booking->jadwal->guru_id !== Auth::user()->guru->id) {
            abort(403, 'Unauthorized action.');
        }

        // Simpan Hasil
        $booking->update([
            'kategori_masalah' => $request->kategori_masalah,
            'catatan_hasil' => $request->catatan_hasil,
        ]);

        // Ubah status jadwal menjadi selesai
        $booking->jadwal->update([
            'status' => 'selesai'
        ]);

        return redirect()->route('guru.hasil.index')->with('success', 'Hasil konseling berhasil disimpan.');
    }
}
