<?php

use App\Models\BookingKonseling;
use App\Models\Guru;
use App\Models\JadwalKonseling;
use App\Models\Siswa;
use App\Models\User;

test('admin sees one row per student and the filtered session keeps its number from the full history', function () {
    $this->withoutVite();
    $makeUser = fn ($name, $role) => User::create([
        'name' => $name, 'username' => $name, 'email' => $name.'@example.com',
        'password' => 'password', 'role' => $role,
    ]);
    $admin = $makeUser('admin', 'admin');
    $guru = Guru::create(['user_id' => $makeUser('guru', 'guru')->id, 'nama_lengkap' => 'Guru Contoh']);
    $siswa = Siswa::create(['user_id' => $makeUser('siswa', 'siswa')->id, 'nama_lengkap' => 'Siswa Contoh', 'kelas' => 'X A']);

    foreach ([['2026-11-02', 'Akademik', 'Keluhan pertama'], ['2026-11-03', 'Sosial', 'Keluhan kedua']] as [$tanggal, $kategori, $keluhan]) {
        $jadwal = JadwalKonseling::create([
            'guru_id' => $guru->id, 'tanggal' => $tanggal, 'jam_mulai' => '08:00',
            'jam_selesai' => '08:45', 'status' => 'selesai',
        ]);
        BookingKonseling::create([
            'siswa_id' => $siswa->id, 'jadwal_id' => $jadwal->id,
            'kategori_masalah' => $kategori, 'keluhan_awal' => $keluhan,
        ]);
    }

    $response = $this->actingAs($admin)->get(route('admin.laporan.index', ['kategori' => 'Sosial']));
    $response->assertOk()->assertSee('Siswa Contoh')->assertSee('Guru Contoh')
        ->assertSee('Keluhan kedua')->assertDontSee('Keluhan pertama')
        ->assertSee('Sesi ke-2')->assertSee('2 sesi selesai secara keseluruhan');
    $response->assertSee('Status sesi terbaru')->assertSee('Tanggal terakhir konseling')
        ->assertSee('03 November 2026')->assertSee('aria-controls="detail-laporan-'.$siswa->id.'"', false)
        ->assertDontSee("open-modal', 'laporan-", false);

    $this->actingAs($siswa->user)->get(route('admin.laporan.index'))->assertForbidden();
});

test('laporan dibagi per siswa dan pagination mempertahankan filter', function () {
    $this->withoutVite();
    $admin = User::create(['name' => 'Admin', 'username' => 'admin-pages', 'email' => 'admin-pages@example.com', 'password' => 'password', 'role' => 'admin']);
    $teacher = User::create(['name' => 'Guru', 'username' => 'guru-pages', 'email' => 'guru-pages@example.com', 'password' => 'password', 'role' => 'guru']);
    $guru = Guru::create(['user_id' => $teacher->id, 'nama_lengkap' => 'Guru']);
    foreach (range(1, 11) as $i) {
        $nama = sprintf('Siswa %02d', $i);
        $user = User::create(['name' => $nama, 'username' => 'pagination'.$i, 'email' => 'pagination'.$i.'@example.com', 'password' => 'password', 'role' => 'siswa']);
        $siswa = Siswa::create(['user_id' => $user->id, 'nama_lengkap' => $nama]);
        foreach (['2026-01-05', '2026-01-06'] as $date) {
            $jadwal = JadwalKonseling::create(['guru_id' => $guru->id, 'tanggal' => $date, 'jam_mulai' => '08:00', 'jam_selesai' => '08:45', 'status' => $date === '2026-01-05' ? 'selesai' : 'menunggu']);
            BookingKonseling::create(['jadwal_id' => $jadwal->id, 'siswa_id' => $siswa->id, 'kategori_masalah' => 'Akademik', 'keluhan_awal' => 'Keluhan '.$nama]);
        }
    }
    $first = $this->actingAs($admin)->get(route('admin.laporan.index', ['kategori' => 'Akademik']));
    $first->assertOk()->assertSee('Siswa 01')->assertSee('Siswa 10')->assertDontSee('Siswa 11')
        ->assertSee('Menunggu')->assertSee('05 Januari 2026')->assertSee('kategori=Akademik', false);
    $second = $this->get(route('admin.laporan.index', ['kategori' => 'Akademik', 'page' => 2]));
    $second->assertOk()->assertSee('Siswa 11')->assertDontSee('Siswa 10')->assertSee('Keluhan Siswa 11');
    $this->get(route('admin.laporan.index', ['kategori' => 'Sosial']))->assertOk()->assertSee('Tidak ada data laporan konseling');

    $this->get(route('admin.laporan.index', ['search' => 'Siswa 01', 'per_page' => 25, 'kategori' => 'Akademik']))
        ->assertOk()->assertSee('Siswa 01')->assertDontSee('Siswa 02')->assertSee('value="25" selected', false)
        ->assertViewHas('siswaPage', fn ($page) => $page->total() === 1 && $page->perPage() === 25);
    $this->get(route('admin.laporan.index', ['search' => 'Siswa', 'per_page' => 25]))
        ->assertOk()->assertSee('Siswa 11')->assertViewHas('siswaPage', fn ($page) => $page->total() === 11 && $page->perPage() === 25);
    $this->get(route('admin.laporan.index', ['search' => 'Siswa', 'per_page' => 10]))
        ->assertOk()->assertSee('search=Siswa', false)->assertSee('per_page=10', false)->assertDontSee('Siswa 11');
    $this->get(route('admin.laporan.index', ['search' => 'tidak ditemukan']))
        ->assertOk()->assertSee('Tidak ada data laporan konseling');
    $this->get(route('admin.laporan.index', ['per_page' => 1000]))->assertSessionHasErrors('per_page');

    $export = $this->get(route('admin.laporan.export', ['search' => 'Siswa 01']));
    $export->assertOk();
    expect($export->streamedContent())->toContain('Siswa 01')->toContain('Keluhan Awal')->toContain('Keluhan Siswa 01')->not->toContain('Siswa 02');
});

test('ekspor csv menyimpan keluhan dengan aman termasuk koma dan baris baru', function () {
    $admin = User::create(['name' => 'Admin', 'username' => 'admin-csv', 'email' => 'admin-csv@example.com', 'password' => 'password', 'role' => 'admin']);
    $teacher = User::create(['name' => 'Guru', 'username' => 'guru-csv', 'email' => 'guru-csv@example.com', 'password' => 'password', 'role' => 'guru']);
    $guru = Guru::create(['user_id' => $teacher->id, 'nama_lengkap' => 'Guru']);
    $user = User::create(['name' => 'Siswa', 'username' => 'siswa-csv', 'email' => 'siswa-csv@example.com', 'password' => 'password', 'role' => 'siswa']);
    $siswa = Siswa::create(['user_id' => $user->id, 'nama_lengkap' => 'Siswa']);
    $jadwal = JadwalKonseling::create(['guru_id' => $guru->id, 'tanggal' => '2026-01-05', 'jam_mulai' => '08:00', 'jam_selesai' => '08:45', 'status' => 'selesai']);
    BookingKonseling::create(['jadwal_id' => $jadwal->id, 'siswa_id' => $siswa->id, 'kategori_masalah' => 'Akademik', 'keluhan_awal' => "=contoh, catatan\nbaris kedua"]);

    $response = $this->actingAs($admin)->get(route('admin.laporan.export', ['kategori' => 'Akademik']));
    $response->assertOk();
    $stream = fopen('php://temp', 'w+');
    fwrite($stream, $response->streamedContent());
    rewind($stream);
    $header = fgetcsv($stream, escape: '');
    $row = fgetcsv($stream, escape: '');
    fclose($stream);
    expect($header[4])->toBe('Keluhan Awal')->and($row[4])->toBe("'=contoh, catatan\nbaris kedua");
    $this->actingAs($user)->get(route('admin.laporan.export'))->assertForbidden();
});
