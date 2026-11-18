<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingKonseling extends Model
{
    protected $fillable = ['jadwal_id', 'siswa_id', 'keluhan_awal', 'kategori_masalah', 'catatan_hasil', 'rating', 'ulasan', 'jenis_jadwal', 'alasan_penolakan'];

    public function scopeBaruUntukGuru($query, $guruId)
    {
        return $query->whereNotExists(fn ($seen) => $seen->selectRaw('1')->from('pengajuan_dilihat_guru')
                ->whereColumn('pengajuan_dilihat_guru.booking_id', 'booking_konselings.id')
                ->where('pengajuan_dilihat_guru.guru_id', $guruId))
            ->whereHas('jadwal', fn ($jadwal) => $jadwal->where('guru_id', $guruId)->where('status', 'menunggu'));
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalKonseling::class, 'jadwal_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
