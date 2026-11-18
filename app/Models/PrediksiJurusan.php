<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrediksiJurusan extends Model
{
    protected $fillable = ['siswa_id', 'jalur', 'input_nilai', 'rekomendasi', 'hasil_detail'];

    protected $casts = [
        'input_nilai' => 'array',
        'hasil_detail' => 'array',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
