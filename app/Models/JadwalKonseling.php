<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKonseling extends Model
{
    protected $fillable = ['guru_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'status'];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function bookingKonselings()
    {
        return $this->hasMany(BookingKonseling::class, 'jadwal_id');
    }
}
