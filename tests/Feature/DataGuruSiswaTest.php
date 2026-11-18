<?php

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;

test('halaman data guru dan siswa menampilkan data dan formulir secara aman untuk admin', function () {
    $this->withoutVite();
    $makeUser = fn ($name, $role, $email) => User::create([
        'name' => $name, 'username' => str_replace('@', '-', $email), 'email' => $email,
        'password' => 'password', 'role' => $role,
    ]);
    $admin = $makeUser('Admin', 'admin', 'admin-directory@example.com');
    $teacherUser = $makeUser('Guru', 'guru', 'guru-directory@example.com');
    $teacher = Guru::create(['user_id' => $teacherUser->id, 'nama_lengkap' => 'Ibu Guru', 'bidang_keahlian' => 'Karier khusus']);
    $studentUser = $makeUser('Siswa', 'siswa', 'siswa-directory@example.com');
    $student = Siswa::create(['user_id' => $studentUser->id, 'nama_lengkap' => "Dina O'Neil", 'nisn' => '123456', 'kelas' => 'XI IPA 2']);

    $this->actingAs($admin)->get(route('admin.guru.index'))->assertOk()
        ->assertSee('Ibu Guru')->assertSee('Karier khusus')->assertSee('data-bidang="Karier khusus"', false)
        ->assertSee('Cari nama guru BK');
    $this->get(route('admin.siswa.index'))->assertOk()->assertSee('Dina O&#039;Neil', false)
        ->assertSee('data-nama="Dina O&#039;Neil"', false)->assertSee('XI IPA 2')->assertSee('123456')
        ->assertSee('Cari nama atau NISN siswa');

    $this->put(route('admin.guru.update', $teacher->id), [
        'nama_lengkap' => 'Ibu Guru', 'email' => $teacherUser->email, 'nip' => '', 'bidang_keahlian' => 'Psikologi anak',
    ])->assertSessionHasNoErrors();
    $this->put(route('admin.siswa.update', $student->id), [
        'nama_lengkap' => "Dina O'Neil", 'email' => $studentUser->email, 'nisn' => '123456', 'kelas' => 'XI IPA 3',
    ])->assertSessionHasNoErrors();
    expect($teacher->fresh()->bidang_keahlian)->toBe('Psikologi anak')->and($student->fresh()->kelas)->toBe('XI IPA 3');
    $this->actingAs($studentUser)->get(route('admin.guru.index'))->assertForbidden();
    $this->get(route('admin.siswa.index'))->assertForbidden();
});
