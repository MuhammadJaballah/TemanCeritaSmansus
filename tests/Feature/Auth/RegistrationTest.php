<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('siswa.dashboard'));
    $this->assertDatabaseHas('users', ['email' => 'test@example.com', 'role' => 'siswa']);
    $this->assertDatabaseHas('siswas', ['nama_lengkap' => 'Test User']);
});

test('public registration cannot create privileged accounts', function (string $role) {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => $role,
    ]);

    $response->assertSessionHasErrors('role');
    $this->assertGuest();
    $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
})->with(['guru', 'admin']);
