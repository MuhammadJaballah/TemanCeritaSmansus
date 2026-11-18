<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookingKonseling;

class FeedbackController extends Controller
{
    public function index()
    {
        $siswaId = auth()->user()->siswa->id;

        // Ambil booking yang sudah selesai tapi belum diberi feedback
        $unratedBookings = BookingKonseling::with('jadwal.guru')
            ->where('siswa_id', $siswaId)
            ->whereNull('rating')
            ->whereHas('jadwal', function ($q) {
                $q->where('status', 'selesai');
            })
            ->get();

        // Ambil histori feedback (yang sudah dirating)
        $feedbackHistory = BookingKonseling::with('jadwal.guru')
            ->where('siswa_id', $siswaId)
            ->whereNotNull('rating')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('Siswa.Feedback.Index', compact('unratedBookings', 'feedbackHistory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:booking_konselings,id',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|min:5'
        ]);

        $booking = BookingKonseling::where('siswa_id', auth()->user()->siswa->id)
            ->whereNull('rating') // Pastikan belum pernah dirating
            ->findOrFail($request->booking_id);

        $booking->update([
            'rating' => $request->rating,
            'ulasan' => $request->ulasan
        ]);

        return back()->with('success', 'Terima kasih! Feedback Anda telah berhasil dikirim.');
    }
}
