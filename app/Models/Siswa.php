<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = ['user_id', 'nisn', 'nama_lengkap', 'kelas', 'alamat', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingKonselings()
    {
        return $this->hasMany(BookingKonseling::class);
    }

    public function prediksiJurusans()
    {
        return $this->hasMany(PrediksiJurusan::class);
    }
}
