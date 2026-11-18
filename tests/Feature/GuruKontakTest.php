<?php

use App\Models\Guru;
use App\Models\User;

test('admin dapat mengelola alamat dan nomor hp guru', function () {
    $this->withoutVite();
    $admin = User::create(['name' => 'Admin', 'username' => 'kontak-admin', 'email' => 'kontak-admin@example.com', 'password' => 'password', 'role' => 'admin']);
    $this->actingAs($admin)->post(route('admin.guru.store'), [
        'nama_lengkap' => 'Guru Kontak', 'email' => 'guru-kontak@example.com', 'password' => 'password',
        'nip' => '', 'bidang_keahlian' => 'Karier', 'alamat' => 'Jalan Mawar 1', 'no_hp' => '081234567890',
    ])->assertSessionHasNoErrors();
    $guru = Guru::where('nama_lengkap', 'Guru Kontak')->firstOrFail();
    expect($guru->alamat)->toBe('Jalan Mawar 1')->and($guru->no_hp)->toBe('081234567890');
    $this->get(route('admin.guru.index'))->assertOk()->assertSee('Jalan Mawar 1')->assertSee('081234567890')->assertSee('data-no-hp="081234567890"', false);
    $this->put(route('admin.guru.update', $guru->id), [
        'nama_lengkap' => 'Guru Kontak', 'email' => 'guru-kontak@example.com', 'nip' => '',
        'bidang_keahlian' => 'Karier', 'alamat' => 'Jalan Melati 2', 'no_hp' => '+62 812 111',
    ])->assertSessionHasNoErrors();
    expect($guru->fresh()->alamat)->toBe('Jalan Melati 2')->and($guru->fresh()->no_hp)->toBe('+62 812 111');
    $this->put(route('admin.guru.update', $guru->id), [
        'nama_lengkap' => 'Guru Kontak', 'email' => 'guru-kontak@example.com', 'nip' => '',
        'bidang_keahlian' => 'Karier', 'no_hp' => str_repeat('1', 31),
    ])->assertSessionHasErrors('no_hp');
    expect($guru->fresh()->no_hp)->toBe('+62 812 111');
});

test('guru dapat mengubah kontak sendiri dan nama profil tersinkron', function () {
    $this->withoutVite();
    $user = User::create(['name' => 'Guru Awal', 'username' => 'kontak-guru', 'email' => 'kontak-guru@example.com', 'password' => 'password', 'role' => 'guru']);
    $guru = Guru::create(['user_id' => $user->id, 'nama_lengkap' => 'Guru Awal', 'alamat' => 'Alamat lama', 'no_hp' => '08111']);
    $this->actingAs($user)->get(route('profile.edit'))->assertOk()->assertSee('Alamat lama')->assertSee('08111');
    $this->patch(route('profile.update'), [
        'name' => 'Guru Baru', 'email' => $user->email, 'alamat' => 'Alamat baru', 'no_hp' => '08222',
    ])->assertSessionHasNoErrors();
    expect($guru->fresh()->nama_lengkap)->toBe('Guru Baru')->and($guru->fresh()->alamat)->toBe('Alamat baru')->and($guru->fresh()->no_hp)->toBe('08222');
    $this->patch(route('profile.update'), ['name' => 'Guru Baru', 'email' => $user->email])->assertSessionHasNoErrors();
    expect($guru->fresh()->alamat)->toBe('Alamat baru')->and($guru->fresh()->no_hp)->toBe('08222');
    $this->patch(route('profile.update'), ['name' => 'Guru Baru', 'email' => $user->email, 'alamat' => '', 'no_hp' => ''])->assertSessionHasNoErrors();
    expect($guru->fresh()->alamat)->toBeNull()->and($guru->fresh()->no_hp)->toBeNull();
});

test('akun siswa tidak mendapat kolom kontak guru', function () {
    $this->withoutVite();
    $student = User::factory()->create(['role' => 'siswa']);
    $this->actingAs($student)->get(route('profile.edit'))->assertOk()->assertDontSee('No. HP (Opsional)');
    $this->patch(route('profile.update'), ['name' => $student->name, 'email' => $student->email, 'alamat' => 'Diabaikan', 'no_hp' => '123'])->assertSessionHasNoErrors();
    expect($student->fresh()->guru)->toBeNull();
});
