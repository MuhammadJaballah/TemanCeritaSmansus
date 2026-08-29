<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrediksiJurusan extends Model
{
    protected $fillable = ['siswa_id', 'input_nilai', 'rekomendasi'];

    protected $casts = [
        'input_nilai' => 'array',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
