<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Siswa\StoreBookingKonselingRequest;
use App\Models\BookingKonseling;
use App\Models\Guru;
use App\Models\JadwalKonseling;
use App\Models\JadwalMingguan;
use App\Services\JadwalTetap;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingKonselingController extends Controller
{
    public function create(JadwalTetap $jadwalTetap)
    {
        $gurus = Guru::with('user')->get();
        $fixedData = [];
        foreach (JadwalMingguan::whereBetween('hari', [1, 5])->orderBy('jam_mulai')->get() as $slot) {
            $fixedData[$slot->guru_id][$slot->hari][] = substr($slot->jam_mulai, 0, 5);
        }
        $bookedData = [];
        foreach ($jadwalTetap->jadwalTerisi()->whereDate('tanggal', '>=', now(JadwalTetap::TIMEZONE)->toDateString())->get() as $jadwal) {
            $bookedData[$jadwal->guru_id][$jadwal->tanggal][] = [substr($jadwal->jam_mulai, 0, 5), substr($jadwal->jam_selesai, 0, 5)];
        }
        $tanggalPilihan = [];
        $hariIni = now(JadwalTetap::TIMEZONE)->startOfDay();
        for ($i = 0; $i < 28; $i++) {
            $tanggal = $hariIni->copy()->addDays($i)->locale('id');
            $tanggalPilihan[] = [
                'tanggal' => $tanggal->toDateString(),
                'label' => $tanggal->translatedFormat('l, d F Y'),
            ];
        }
        return view('Siswa.BookingKonseling.Create', compact('gurus', 'bookedData', 'fixedData', 'tanggalPilihan'));
    }

    public function store(StoreBookingKonselingRequest $request, JadwalTetap $jadwalTetap)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $jadwalTetap, $request) {
            // Serialize bookings for each teacher, including overlaps with different start times.
            Guru::whereKey($data['guru_id'])->lockForUpdate()->firstOrFail();

            if ($jadwalTetap->sudahLewat($data['tanggal'], $data['waktu'])) {
                throw ValidationException::withMessages(['waktu' => 'Waktu konseling sudah lewat.']);
            }

            $hari = Carbon::parse($data['tanggal'], JadwalTetap::TIMEZONE)->isoWeekday();
            $matching = $hari <= 5 && JadwalMingguan::where('guru_id', $data['guru_id'])->where('hari', $hari)->get()
                ->contains(fn ($slot) => substr($slot->jam_mulai, 0, 5) === $data['waktu']);
            if ($data['jenis_jadwal'] === 'tetap' && !$matching) {
                throw ValidationException::withMessages(['waktu' => 'Waktu tersebut bukan jadwal tetap guru.']);
            }
            if ($data['jenis_jadwal'] === 'permintaan' && $matching) {
                throw ValidationException::withMessages(['waktu' => 'Waktu tersebut termasuk jadwal tetap. Silakan pilih jenis jadwal tetap.']);
            }

            $busy = $jadwalTetap->jadwalTerisi()
                ->where('guru_id', $data['guru_id'])->whereDate('tanggal', $data['tanggal'])->get();
            if ($jadwalTetap->bentrok($busy, $data['waktu'])) {
                throw ValidationException::withMessages(['waktu' => 'Waktu tersebut bentrok dengan jadwal konseling lain.']);
            }

            // Reuse an old free slot if it exists; no historical booking is removed.
            $jadwal = JadwalKonseling::where('guru_id', $data['guru_id'])
                ->whereDate('tanggal', $data['tanggal'])
                ->where('status', 'tersedia')->doesntHave('bookingKonselings')->get()
                ->first(fn ($slot) => substr($slot->jam_mulai, 0, 5) === $data['waktu']);
            $attributes = ['jam_selesai' => $jadwalTetap->selesai($data['waktu']), 'status' => 'menunggu'];
            if ($jadwal) {
                $jadwal->update($attributes);
            } else {
                $jadwal = JadwalKonseling::create($attributes + [
                    'guru_id' => $data['guru_id'], 'tanggal' => $data['tanggal'], 'jam_mulai' => $data['waktu'],
                ]);
            }

            BookingKonseling::create([
                'jadwal_id' => $jadwal->id,
                'siswa_id' => $request->user()->siswa->id,
                'keluhan_awal' => $data['keluhan_awal'],
                'kategori_masalah' => $data['kategori_masalah'],
                'jenis_jadwal' => $data['jenis_jadwal'],
            ]);
        }, 3);

        return redirect()->route('siswa.dashboard')->with('success', 'Berhasil melakukan booking konseling! Menunggu konfirmasi dari Guru BK.');
    }
}
