<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingKonseling extends Model
{
    protected $fillable = ['jadwal_id', 'siswa_id', 'keluhan_awal', 'kategori_masalah', 'catatan_hasil', 'rating', 'ulasan'];

    public function jadwal()
    {
        return $this->belongsTo(JadwalKonseling::class, 'jadwal_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
