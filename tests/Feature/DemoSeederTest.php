<?php

use App\Models\BookingKonseling;
use App\Models\JadwalKonseling;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DemoSeeder;
use Illuminate\Support\Facades\Hash;

test('demo seeder creates usable examples and repeated runs preserve existing changes', function () {
    $this->withoutVite();
    $this->travelTo(Carbon::parse('2026-11-05 09:00:00', 'Asia/Jakarta'));
    $this->seed(DemoSeeder::class);

    expect(User::count())->toBe(5)
        ->and(JadwalKonseling::count())->toBe(4)
        ->and(BookingKonseling::count())->toBe(4);
    foreach (['demo.admin', 'demo.guru1', 'demo.guru2', 'demo.siswa1', 'demo.siswa2'] as $name) {
        $user = User::where('email', $name.'@temancerita.invalid')->firstOrFail();
        expect(Hash::check(DemoSeeder::PASSWORD, $user->password))->toBeTrue();
    }
    $this->assertDatabaseHas('jadwal_konselings', ['status' => 'menunggu']);
    $this->assertDatabaseHas('jadwal_konselings', ['status' => 'disetujui']);
    $this->assertDatabaseHas('booking_konselings', ['rating' => null]);
    $this->assertDatabaseHas('booking_konselings', ['rating' => 5]);

    $pending = JadwalKonseling::where('status', 'menunggu')->firstOrFail();
    $pending->update(['status' => 'disetujui']);
    $this->travel(10)->days();
    $this->seed(DemoSeeder::class);
    expect(User::count())->toBe(5)
        ->and(JadwalKonseling::count())->toBe(4)
        ->and(BookingKonseling::count())->toBe(4)
        ->and($pending->fresh()->status)->toBe('disetujui');
});

test('demo seeder refuses an identity collision without modifying existing users', function () {
    User::create([
        'name' => 'Existing User', 'username' => 'someone',
        'email' => 'demo.guru1@temancerita.invalid', 'role' => 'siswa', 'password' => 'other-password',
    ]);
    try {
        $this->seed(DemoSeeder::class);
        $this->fail('Expected a conflict to abort the seeder.');
    } catch (RuntimeException $exception) {
        expect($exception->getMessage())->toContain('sudah digunakan');
    }
    expect(User::count())->toBe(1)->and(JadwalKonseling::count())->toBe(0);
    $user = User::firstOrFail();
    expect($user->name)->toBe('Existing User')->and(Hash::check('other-password', $user->password))->toBeTrue();
});

test('each demo account can sign in to its role dashboard', function () {
    $this->seed(DemoSeeder::class);
    foreach ([
        'demo.admin' => 'admin.dashboard',
        'demo.guru1' => 'guru.dashboard',
        'demo.guru2' => 'guru.dashboard',
        'demo.siswa1' => 'siswa.dashboard',
        'demo.siswa2' => 'siswa.dashboard',
    ] as $name => $dashboard) {
        $this->post('/login', ['email' => $name.'@temancerita.invalid', 'password' => DemoSeeder::PASSWORD])
            ->assertSessionHasNoErrors()->assertRedirect(route($dashboard, absolute: false));
        $this->post('/logout')->assertRedirect('/');
    }
});
