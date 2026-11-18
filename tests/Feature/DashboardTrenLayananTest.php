<?php

use App\Models\BookingKonseling;
use App\Models\Guru;
use App\Models\JadwalKonseling;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;

test('tren admin menghitung sesi selesai per bulan selama enam bulan terakhir', function () {
    $this->withoutVite();
    $this->travelTo(Carbon::parse('2026-05-14 10:00:00', 'Asia/Jakarta'));

    $createUser = fn ($name, $role) => User::create([
        'name' => $name,
        'username' => $name,
        'email' => $name.'@example.test',
        'password' => 'password',
        'role' => $role,
    ]);
    $admin = $createUser('admin-tren', 'admin');
    $guru = Guru::create(['user_id' => $createUser('guru-tren', 'guru')->id, 'nama_lengkap' => 'Guru Tren']);
    $siswaUser = $createUser('siswa-tren', 'siswa');
    $siswa = Siswa::create(['user_id' => $siswaUser->id, 'nama_lengkap' => 'Siswa Tren']);

    foreach ([
        ['2025-11-30', 'selesai'], // Sebelum awal rentang.
        ['2025-12-01', 'selesai'],
        ['2025-12-31', 'selesai'],
        ['2026-01-10', 'menunggu'],
        ['2026-02-10', 'disetujui'],
        ['2026-03-15', 'selesai'],
        ['2026-05-14', 'selesai'],
        ['2026-06-01', 'selesai'], // Setelah akhir rentang.
    ] as [$date, $status]) {
        $jadwal = JadwalKonseling::create([
            'guru_id' => $guru->id,
            'tanggal' => $date,
            'jam_mulai' => '08:00',
            'jam_selesai' => '08:45',
            'status' => $status,
        ]);
        BookingKonseling::create([
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $siswa->id,
            'kategori_masalah' => 'Akademik',
            'keluhan_awal' => 'Data pengujian',
        ]);
    }

    $expected = [
        ['label' => 'Des 2025', 'jumlah' => 2],
        ['label' => 'Jan 2026', 'jumlah' => 0],
        ['label' => 'Feb 2026', 'jumlah' => 0],
        ['label' => 'Mar 2026', 'jumlah' => 1],
        ['label' => 'Apr 2026', 'jumlah' => 0],
        ['label' => 'Mei 2026', 'jumlah' => 1],
    ];

    $this->actingAs($admin)->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Tren Layanan Konseling')
        ->assertSee('Des 2025: 2 sesi selesai')
        ->assertSee('Jan 2026: 0 sesi selesai')
        ->assertViewHas('trenLayanan', $expected);

    $this->actingAs($siswaUser)->get(route('admin.dashboard'))->assertForbidden();
});

test('grafik menampilkan keadaan kosong saat belum ada sesi selesai', function () {
    $this->withoutVite();
    $admin = User::create([
        'name' => 'Admin kosong',
        'username' => 'admin-kosong',
        'email' => 'admin-kosong@example.test',
        'password' => 'password',
        'role' => 'admin',
    ]);

    $this->actingAs($admin)->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('Belum ada sesi konseling selesai dalam 6 bulan terakhir.')
        ->assertViewHas('trenLayanan', fn ($tren) => count($tren) === 6 && collect($tren)->sum('jumlah') === 0);
});
