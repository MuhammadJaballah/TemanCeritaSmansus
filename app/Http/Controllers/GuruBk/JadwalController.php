<?php

namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\JadwalKonseling;
use App\Http\Requests\GuruBk\StoreJadwalRequest;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $guruId = auth()->user()->guru->id;
        
        // Ambil semua jadwal untuk guru ini, urutkan berdasarkan tanggal & jam
        $jadwals = JadwalKonseling::where('guru_id', $guruId)
            ->where('tanggal', '>=', date('Y-m-d'))
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // Kelompokkan berdasarkan tanggal
        $groupedJadwals = $jadwals->groupBy('tanggal');
        
        // Tanggal yang sedang aktif (bisa dari request atau tanggal terdekat yang ada jadwalnya)
        $activeDate = $request->query('date');
        if (!$activeDate && $groupedJadwals->count() > 0) {
            $activeDate = $groupedJadwals->keys()->first();
        }

        return view('GuruBk.KetersediaanJadwal.Index', compact('groupedJadwals', 'activeDate'));
    }

    public function store(StoreJadwalRequest $request)
    {
        $validated = $request->validated();
        
        JadwalKonseling::create([
            'guru_id' => auth()->user()->guru->id,
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'status' => 'tersedia'
        ]);

        // Setelah sukses simpan, redirect kembali ke halaman index dengan tab tanggal tersebut aktif
        return redirect()->route('guru.jadwal.index', ['date' => $validated['tanggal']])
            ->with('success', 'Ketersediaan jadwal berhasil ditambahkan.');
    }
    public function update(StoreJadwalRequest $request, $id)
    {
        $jadwal = JadwalKonseling::where('guru_id', auth()->user()->guru->id)->findOrFail($id);
        $validated = $request->validated();

        $jadwal->update([
            'tanggal' => $validated['tanggal'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
        ]);

        return redirect()->route('guru.jadwal.index', ['date' => $validated['tanggal']])
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKonseling::where('guru_id', auth()->user()->guru->id)->findOrFail($id);
        $date = $jadwal->tanggal;
        $jadwal->delete();

        return redirect()->route('guru.jadwal.index', ['date' => $date])
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    public function updateDate(Request $request, $date)
    {
        $request->validate(['tanggal' => 'required|date']);
        
        JadwalKonseling::where('guru_id', auth()->user()->guru->id)
            ->where('tanggal', $date)
            ->update(['tanggal' => $request->tanggal]);

        return redirect()->route('guru.jadwal.index', ['date' => $request->tanggal])
            ->with('success', 'Tanggal jadwal berhasil diperbarui.');
    }

    public function destroyDate($date)
    {
        JadwalKonseling::where('guru_id', auth()->user()->guru->id)
            ->where('tanggal', $date)
            ->delete();

        return redirect()->route('guru.jadwal.index')
            ->with('success', 'Semua jadwal pada tanggal tersebut berhasil dihapus.');
    }
}
