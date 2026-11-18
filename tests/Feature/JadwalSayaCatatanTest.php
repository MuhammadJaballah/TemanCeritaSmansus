<?php

use App\Models\BookingKonseling;
use App\Models\Guru;
use App\Models\JadwalKonseling;
use App\Models\Siswa;
use App\Models\User;

test('siswa dapat membuka catatan sesi selesai miliknya saja', function () {
    $this->withoutVite();
    $makeUser = fn ($name, $role) => User::create([
        'name' => $name, 'username' => $name, 'email' => $name.'@example.com',
        'password' => 'password', 'role' => $role,
    ]);
    $guru = Guru::create(['user_id' => $makeUser('guru-catatan', 'guru')->id, 'nama_lengkap' => 'Guru BK']);
    $user = $makeUser('siswa-catatan', 'siswa');
    $siswa = Siswa::create(['user_id' => $user->id, 'nama_lengkap' => 'Siswa']);
    $other = Siswa::create(['user_id' => $makeUser('siswa-lain', 'siswa')->id, 'nama_lengkap' => 'Siswa Lain']);
    $makeBooking = function ($student, $status, $result) use ($guru) {
        $jadwal = JadwalKonseling::create(['guru_id' => $guru->id, 'tanggal' => '2026-11-02', 'jam_mulai' => '09:00', 'jam_selesai' => '09:45', 'status' => $status]);
        return BookingKonseling::create(['jadwal_id' => $jadwal->id, 'siswa_id' => $student->id, 'kategori_masalah' => 'Akademik', 'keluhan_awal' => 'Kesulitan belajar', 'catatan_hasil' => $result]);
    };
    $booking = $makeBooking($siswa, 'selesai', 'Catatan <khusus> siswa');
    $tanpaCatatan = $makeBooking($siswa, 'selesai', null);
    $pending = $makeBooking($siswa, 'menunggu', 'Catatan sesi belum selesai');
    $makeBooking($other, 'selesai', 'Catatan pribadi siswa lain');

    $this->actingAs($user)->get(route('siswa.jadwal.index'))
        ->assertOk()
        ->assertSee('catatan-konseling-'.$booking->id)
        ->assertSee('catatan-konseling-'.$tanpaCatatan->id)
        ->assertSee('Catatan &lt;khusus&gt; siswa', false)
        ->assertSee('Belum ada catatan hasil dari guru BK.')
        ->assertDontSee('catatan-konseling-'.$pending->id)
        ->assertDontSee('Catatan sesi belum selesai')
        ->assertDontSee('Catatan pribadi siswa lain');
});
