<?php

namespace App\Services;

use App\Models\JadwalKonseling;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class JadwalTetap
{
    public const TIMEZONE = 'Asia/Jakarta';
    public const DURASI_MENIT = 45;
    public const JAM = ['08:00', '08:45', '09:30', '10:00', '10:45', '11:30', '13:00', '13:45', '14:30'];

    /** The same 14 school days are shown to teachers and students. */
    public function tanggalTersedia(): array
    {
        $dates = [];
        $date = Carbon::now(self::TIMEZONE)->startOfDay();
        while (count($dates) < 14) {
            if ($date->isWeekday()) {
                $dates[] = [
                    'date' => $date->toDateString(),
                    'dayName' => $date->copy()->locale('id')->translatedFormat('D'),
                    'dayNumber' => $date->format('d'),
                    'fullFormat' => $date->copy()->locale('id')->translatedFormat('l, d F Y'),
                ];
            }
            $date->addDay();
        }
        return $dates;
    }

    public function sudahLewat(string $tanggal, string $waktu): bool
    {
        return Carbon::createFromFormat('!Y-m-d H:i', "$tanggal $waktu", self::TIMEZONE)
            ->lessThanOrEqualTo(Carbon::now(self::TIMEZONE));
    }

    public function selesai(string $waktu): string
    {
        return Carbon::createFromFormat('!H:i', $waktu, self::TIMEZONE)
            ->addMinutes(self::DURASI_MENIT)->format('H:i');
    }

    /** Busy legacy bookings also block intersecting fixed slots. */
    public function bentrok(Collection $jadwals, string $waktu): bool
    {
        $start = substr($waktu, 0, 5);
        $end = $this->selesai($start);
        return $jadwals->contains(fn (JadwalKonseling $jadwal) =>
            substr($jadwal->jam_mulai, 0, 5) < $end && substr($jadwal->jam_selesai, 0, 5) > $start
        );
    }

    public function jadwalTerisi()
    {
        return JadwalKonseling::query()->whereIn('status', ['menunggu', 'disetujui', 'selesai']);
    }
}
