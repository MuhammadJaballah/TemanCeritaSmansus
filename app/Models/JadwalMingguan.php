<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalMingguan extends Model
{
    protected $fillable = ['guru_id', 'hari', 'jam_mulai'];
}
