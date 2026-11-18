<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $fillable = ['user_id', 'nip', 'nama_lengkap', 'bidang_keahlian', 'alamat', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwalKonselings()
    {
        return $this->hasMany(JadwalKonseling::class);
    }
}
