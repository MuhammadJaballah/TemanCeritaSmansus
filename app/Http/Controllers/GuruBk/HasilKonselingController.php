<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\BookingKonseling;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GuruBk\StoreHasilKonselingRequest;

class HasilKonselingController extends Controller
{
    public function export()
    {
        $guruId = Auth::user()->guru->id;
        $bookings = BookingKonseling::with(['siswa', 'jadwal'])
            ->whereHas('jadwal', fn ($query) => $query->where('guru_id', $guruId))
            ->latest()
            ->get();

        return response()->streamDownload(function () use ($bookings) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM helps spreadsheet applications display Indonesian text correctly.
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['Siswa', 'Kelas', 'Tanggal', 'Jam Mulai', 'Jam Selesai', 'Status', 'Kategori', 'Keluhan Awal', 'Catatan Hasil', 'Rating', 'Ulasan']);

            foreach ($bookings as $booking) {
                $fields = [
                    $booking->siswa->nama_lengkap ?? '',
                    $booking->siswa->kelas ?? '',
                    $booking->jadwal->tanggal,
                    $booking->jadwal->jam_mulai,
                    $booking->jadwal->jam_selesai,
                    $booking->jadwal->status,
                    $booking->kategori_masalah,
                    $booking->keluhan_awal,
                    $booking->catatan_hasil,
                    $booking->rating,
                    $booking->ulasan,
                ];

                // Prevent text from being interpreted as a spreadsheet formula.
                fputcsv($file, array_map(function ($value) {
                    $value = (string) ($value ?? '');
                    return preg_match('/^[\s]*[=+@\-]/u', $value) ? "'".$value : $value;
                }, $fields));
            }

            fclose($file);
        }, 'data_konseling_'.now()->format('Y-m-d').'.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

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
