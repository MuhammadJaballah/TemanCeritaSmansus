<?php
namespace App\Http\Controllers\GuruBk;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\JadwalMingguan;
use App\Services\JadwalTetap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class JadwalController extends Controller
{
    public function index(Request $request, JadwalTetap $service)
    {
        $guruId = $request->user()->guru->id;
        $mingguan = JadwalMingguan::where('guru_id', $guruId)->orderBy('hari')->orderBy('jam_mulai')->get();
        $jadwals = $service->jadwalTerisi()->with('bookingKonselings.siswa')->where('guru_id', $guruId)
            ->whereDate('tanggal', '>=', now(JadwalTetap::TIMEZONE)->toDateString())->orderBy('tanggal')->orderBy('jam_mulai')->get();
        return view('GuruBk.KetersediaanJadwal.Index', compact('mingguan', 'jadwals'));
    }

    public function store(Request $request, JadwalTetap $service)
    {
        $data = $request->validate(['hari' => 'required|integer|between:1,5', 'jam_mulai' => 'required|date_format:H:i|before_or_equal:23:14']);
        DB::transaction(function () use ($request, $data, $service) {
            $guru = Guru::whereKey($request->user()->guru->id)->lockForUpdate()->firstOrFail();
            $existing = JadwalMingguan::where('guru_id', $guru->id)->where('hari', $data['hari'])->get();
            $start = $data['jam_mulai'];
            $end = $service->selesai($start);
            if ($existing->contains(fn ($slot) => substr($slot->jam_mulai, 0, 5) < $end && $service->selesai(substr($slot->jam_mulai, 0, 5)) > $start)) {
                throw ValidationException::withMessages(['jam_mulai' => 'Waktu ini bertabrakan dengan jadwal mingguan yang sudah ada.']);
            }
            JadwalMingguan::create(['guru_id' => $guru->id, 'hari' => $data['hari'], 'jam_mulai' => $start]);
        });
        return back()->with('success', 'Jadwal mingguan berhasil ditambahkan.');
    }

    public function destroy(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $guruId = $request->user()->guru->id;
            Guru::whereKey($guruId)->lockForUpdate()->firstOrFail();
            JadwalMingguan::where('guru_id', $guruId)->findOrFail($id)->delete();
        });
        return back()->with('success', 'Jadwal mingguan dihapus. Pengajuan yang sudah ada tetap tersimpan.');
    }
}
