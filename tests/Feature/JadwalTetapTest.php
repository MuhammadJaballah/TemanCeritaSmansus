<?php

use App\Models\BookingKonseling;
use App\Models\Guru;
use App\Models\JadwalKonseling;
use App\Models\JadwalMingguan;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;

beforeEach(function () {
    $this->withoutVite();
    $this->travelTo(Carbon::parse('2026-11-02 07:00:00', 'Asia/Jakarta'));
    $guruUser = User::create(['name' => 'Guru', 'username' => 'guru-test', 'email' => 'guru@example.com', 'password' => 'password', 'role' => 'guru']);
    $this->guru = Guru::create(['user_id' => $guruUser->id, 'nama_lengkap' => 'Guru']);
    $this->guruUser = $guruUser;
    $siswaUser = User::create(['name' => 'Siswa', 'username' => 'siswa-test', 'email' => 'siswa@example.com', 'password' => 'password', 'role' => 'siswa']);
    $this->siswa = Siswa::create(['user_id' => $siswaUser->id, 'nama_lengkap' => 'Siswa']);
    $this->studentUser = $siswaUser;
    $this->payload = ['guru_id' => $this->guru->id, 'tanggal' => '2026-11-02', 'waktu' => '09:30', 'jenis_jadwal' => 'tetap', 'kategori_masalah' => 'Akademik', 'keluhan_awal' => 'Kesulitan belajar'];
});

test('guru menetapkan jadwal mingguan tanpa tumpang tindih', function () {
    $this->actingAs($this->guruUser)->post(route('guru.jadwal.mingguan.store'), ['hari' => 1, 'jam_mulai' => '09:30'])->assertSessionHasNoErrors();
    $this->assertDatabaseHas('jadwal_mingguans', ['guru_id' => $this->guru->id, 'hari' => 1]);
    $this->get(route('guru.jadwal.index'))->assertOk()->assertSee('Jadwal tetap mingguan')->assertSee('09:30');
    $this->post(route('guru.jadwal.mingguan.store'), ['hari' => 1, 'jam_mulai' => '10:00'])->assertSessionHasErrors('jam_mulai');
    $this->post(route('guru.jadwal.mingguan.store'), ['hari' => 6, 'jam_mulai' => '08:00'])->assertSessionHasErrors('hari');
    $this->post(route('guru.jadwal.mingguan.store'), ['hari' => 7, 'jam_mulai' => '08:00'])->assertSessionHasErrors('hari');
    $this->actingAs($this->studentUser)->post(route('guru.jadwal.mingguan.store'), ['hari' => 1, 'jam_mulai' => '11:00'])->assertForbidden();
});

test('penanda pengajuan baru hanya hilang untuk daftar yang dibuka guru terkait', function () {
    $other = User::create(['name' => 'Guru lain', 'username' => 'guru-lain-notif', 'email' => 'lain-notif@example.com', 'password' => 'password', 'role' => 'guru']);
    $otherGuru = Guru::create(['user_id' => $other->id, 'nama_lengkap' => 'Guru lain']);
    $makeBooking = function ($guru, $time) {
        $jadwal = JadwalKonseling::create(['guru_id' => $guru->id, 'tanggal' => '2026-11-03', 'jam_mulai' => $time, 'jam_selesai' => '11:45', 'status' => 'menunggu']);
        return BookingKonseling::create(['jadwal_id' => $jadwal->id, 'siswa_id' => $this->siswa->id, 'kategori_masalah' => 'Akademik', 'keluhan_awal' => 'Ingin berkonsultasi']);
    };
    $first = $makeBooking($this->guru, '08:00');
    $otherBooking = $makeBooking($otherGuru, '09:00');
    $badge = 'x-data="{ jumlah: 1 }"';

    $this->actingAs($this->guruUser)->get(route('guru.jadwal.index'))->assertOk()->assertSee($badge, false);
    $this->get(route('guru.pengajuan.index'))->assertOk()->assertDontSee($badge, false);
    $this->assertDatabaseHas('pengajuan_dilihat_guru', ['booking_id' => $first->id, 'guru_id' => $this->guru->id]);
    $this->assertDatabaseMissing('pengajuan_dilihat_guru', ['booking_id' => $otherBooking->id, 'guru_id' => $otherGuru->id]);
    $this->get(route('guru.jadwal.index'))->assertDontSee($badge, false);
    $makeBooking($this->guru, '10:00');
    $this->get(route('guru.jadwal.index'))->assertSee($badge, false);
    $this->actingAs($other)->get(route('guru.jadwal.index'))->assertSee($badge, false);
    $this->get(route('guru.pengajuan.jumlah-baru'))->assertOk()->assertJson(['jumlah' => 1]);
});

test('jadwal tetap akhir pekan lama tidak ditawarkan tetapi permintaan khusus masih diperbolehkan', function () {
    JadwalMingguan::create(['guru_id' => $this->guru->id, 'hari' => 6, 'jam_mulai' => '09:30']);
    $this->actingAs($this->studentUser)->get(route('siswa.booking.create'))->assertOk()
        ->assertViewHas('fixedData', fn ($data) => !isset($data[$this->guru->id][6]));
    $sabtu = array_merge($this->payload, ['tanggal' => '2026-11-07']);
    $this->post(route('siswa.booking.store'), $sabtu)->assertSessionHasErrors('waktu');
    $this->post(route('siswa.booking.store'), array_merge($sabtu, ['jenis_jadwal' => 'permintaan']))->assertSessionHasNoErrors();
    $this->actingAs($this->guruUser)->get(route('guru.jadwal.index'))->assertOk()->assertSee('Tidak aktif')->assertSee('jadwal-hari-6');
});

test('jadwal dikelompokkan per hari dan menghapus satu jam menjaga jam dan pengajuan lain', function () {
    $slot1 = JadwalMingguan::create(['guru_id' => $this->guru->id, 'hari' => 1, 'jam_mulai' => '08:00']);
    $slot2 = JadwalMingguan::create(['guru_id' => $this->guru->id, 'hari' => 1, 'jam_mulai' => '09:30']);
    $slot3 = JadwalMingguan::create(['guru_id' => $this->guru->id, 'hari' => 2, 'jam_mulai' => '08:00']);
    $jadwal = JadwalKonseling::create(['guru_id' => $this->guru->id, 'tanggal' => '2026-11-02', 'jam_mulai' => '08:00', 'jam_selesai' => '08:45', 'status' => 'disetujui']);
    $booking = BookingKonseling::create(['jadwal_id' => $jadwal->id, 'siswa_id' => $this->siswa->id, 'kategori_masalah' => 'Akademik', 'keluhan_awal' => 'Contoh']);

    $response = $this->actingAs($this->guruUser)->get(route('guru.jadwal.index'));
    $response->assertOk()->assertSee('jadwal-hari-1')->assertSee('jadwal-hari-2')->assertSee('2 sesi')
        ->assertSee('Hapus jadwal Senin pukul 08:00')->assertSee(route('guru.jadwal.mingguan.destroy', $slot1->id))
        ->assertSee('Hapus jadwal ini?')->assertSee('Ya, hapus jadwal')->assertSee('role="alertdialog"', false);
    $this->delete(route('guru.jadwal.mingguan.destroy', $slot1->id))->assertSessionHasNoErrors();
    $this->assertDatabaseMissing('jadwal_mingguans', ['id' => $slot1->id]);
    $this->assertDatabaseHas('jadwal_mingguans', ['id' => $slot2->id]);
    $this->assertDatabaseHas('jadwal_mingguans', ['id' => $slot3->id]);
    $this->assertDatabaseHas('booking_konselings', ['id' => $booking->id]);
    expect($jadwal->fresh()->status)->toBe('disetujui');
});

test('siswa dapat memesan jadwal mingguan dan waktu di luar jadwal', function () {
    JadwalMingguan::create(['guru_id' => $this->guru->id, 'hari' => 1, 'jam_mulai' => '09:30']);
    $this->actingAs($this->studentUser)->get(route('siswa.booking.create'))->assertOk()->assertSee('Ajukan waktu di luar jadwal')->assertViewHas('fixedData', fn ($data) => $data[$this->guru->id][1] === ['09:30']);
    $this->actingAs($this->studentUser)->post(route('siswa.booking.store'), $this->payload)->assertSessionHasNoErrors();
    $this->post(route('siswa.booking.store'), array_merge($this->payload, ['waktu' => '10:00', 'jenis_jadwal' => 'permintaan']))->assertSessionHasErrors('waktu');
    $this->post(route('siswa.booking.store'), array_merge($this->payload, ['waktu' => '11:00', 'jenis_jadwal' => 'permintaan']))->assertSessionHasNoErrors();
    $this->assertDatabaseHas('booking_konselings', ['jenis_jadwal' => 'permintaan', 'siswa_id' => $this->siswa->id]);
    expect(JadwalKonseling::where('status', 'menunggu')->count())->toBe(2);
    $this->post(route('siswa.booking.store'), array_merge($this->payload, ['tanggal' => '2026-11-03']))->assertSessionHasErrors('waktu');
});

test('penolakan memerlukan alasan dan tetap terlihat oleh siswa tanpa menghalangi jadwal', function () {
    $this->actingAs($this->studentUser)->post(route('siswa.booking.store'), array_merge($this->payload, ['jenis_jadwal' => 'permintaan']))->assertSessionHasNoErrors();
    $booking = BookingKonseling::firstOrFail();
    $this->actingAs($this->guruUser)->get(route('guru.pengajuan.index'))->assertOk()
        ->assertSee('tolak-pengajuan-'.$booking->id)->assertSee('Tolak pengajuan konseling')
        ->assertSee('Alasan atau usulan waktu lain')->assertDontSee('Tolak dan beri alasan');
    $this->from(route('guru.pengajuan.index'))->delete(route('guru.pengajuan.tolak', $booking->id), ['pengajuan_id' => $booking->id])->assertSessionHasErrors('alasan_penolakan');
    $this->get(route('guru.pengajuan.index'))->assertOk()->assertSee('show: true', false)->assertSee('required');
    $this->delete(route('guru.pengajuan.tolak', $booking->id), ['alasan_penolakan' => 'Silakan hari Selasa pukul 10.00.'])->assertSessionHasNoErrors();
    expect($booking->fresh()->jadwal->status)->toBe('ditolak');
    $this->actingAs($this->studentUser)->get(route('siswa.jadwal.index'))->assertOk()->assertSee('Silakan hari Selasa pukul 10.00.');
    $this->post(route('siswa.booking.store'), array_merge($this->payload, ['jenis_jadwal' => 'permintaan']))->assertSessionHasNoErrors();
    expect(BookingKonseling::count())->toBe(2);
});

test('guru lain tidak dapat memproses pengajuan dan persetujuan hanya sekali', function () {
    $this->actingAs($this->studentUser)->post(route('siswa.booking.store'), array_merge($this->payload, ['jenis_jadwal' => 'permintaan']))->assertSessionHasNoErrors();
    $booking = BookingKonseling::firstOrFail();
    $other = User::create(['name' => 'Guru lain', 'username' => 'other-guru', 'email' => 'other@example.com', 'password' => 'password', 'role' => 'guru']);
    Guru::create(['user_id' => $other->id, 'nama_lengkap' => 'Guru lain']);
    $this->actingAs($other)->patch(route('guru.pengajuan.terima', $booking->id))->assertForbidden();
    $this->actingAs($this->guruUser)->patch(route('guru.pengajuan.terima', $booking->id))->assertSessionHasNoErrors();
    $this->patch(route('guru.pengajuan.terima', $booking->id))->assertStatus(422);
    expect($booking->fresh()->jadwal->status)->toBe('disetujui');
});
