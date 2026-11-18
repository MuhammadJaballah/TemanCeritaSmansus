<?php

use App\Models\BookingKonseling;
use App\Models\Guru;
use App\Models\JadwalKonseling;
use App\Models\Siswa;
use App\Models\User;

test('guru exports only their own counseling data', function () {
    $makeUser = fn ($name, $role) => User::create([
        'name' => $name,
        'username' => $name,
        'email' => $name.'@example.com',
        'password' => 'password',
        'role' => $role,
    ]);

    $firstUser = $makeUser('guru1', 'guru');
    $secondUser = $makeUser('guru2', 'guru');
    $firstGuru = Guru::create(['user_id' => $firstUser->id, 'nama_lengkap' => 'Guru Pertama']);
    $secondGuru = Guru::create(['user_id' => $secondUser->id, 'nama_lengkap' => 'Guru Kedua']);
    $firstStudent = Siswa::create(['user_id' => $makeUser('siswa1', 'siswa')->id, 'nama_lengkap' => 'Siswa Pertama']);
    $secondStudent = Siswa::create(['user_id' => $makeUser('siswa2', 'siswa')->id, 'nama_lengkap' => 'Siswa Kedua']);

    foreach ([[$firstGuru, $firstStudent], [$secondGuru, $secondStudent]] as [$guru, $student]) {
        $jadwal = JadwalKonseling::create([
            'guru_id' => $guru->id,
            'tanggal' => '2026-11-10',
            'jam_mulai' => '08:00',
            'jam_selesai' => '08:45',
            'status' => 'selesai',
        ]);
        BookingKonseling::create([
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $student->id,
            'kategori_masalah' => 'Akademik',
            'keluhan_awal' => '=contoh',
        ]);
    }

    $response = $this->actingAs($firstUser)->get(route('guru.hasil.export'));
    $response->assertOk();
    $csv = $response->streamedContent();
    expect($csv)->toContain('Siswa Pertama')->not->toContain('Siswa Kedua')
        ->toContain("'=contoh");

    $this->actingAs($firstStudent->user)->get(route('guru.hasil.export'))->assertForbidden();
});
