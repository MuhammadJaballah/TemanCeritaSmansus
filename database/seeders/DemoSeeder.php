<?php

namespace Database\Seeders;

use App\Models\BookingKonseling;
use App\Models\Guru;
use App\Models\JadwalKonseling;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

/** Adds isolated examples without modifying existing accounts or sessions. */
class DemoSeeder extends Seeder
{
    public const PASSWORD = 'DemoCerita123!';

    public function run(): void
    {
        DB::transaction(function () {
            $accounts = [
                'admin' => ['Demo Admin', 'demo_admin_tc', 'demo.admin@temancerita.invalid', 'admin'],
                'guru1' => ['Demo Guru Psikologi', 'demo_guru1_tc', 'demo.guru1@temancerita.invalid', 'guru'],
                'guru2' => ['Demo Guru Karier', 'demo_guru2_tc', 'demo.guru2@temancerita.invalid', 'guru'],
                'siswa1' => ['Demo Siswa Andi', 'demo_siswa1_tc', 'demo.siswa1@temancerita.invalid', 'siswa'],
                'siswa2' => ['Demo Siswa Rina', 'demo_siswa2_tc', 'demo.siswa2@temancerita.invalid', 'siswa'],
            ];

            $users = [];
            foreach ($accounts as $key => [$name, $username, $email, $role]) {
                $matches = User::where('email', $email)->orWhere('username', $username)->lockForUpdate()->get();
                if ($matches->isNotEmpty()) {
                    $existing = $matches->first();
                    if ($matches->count() !== 1 || $existing->name !== $name || $existing->email !== $email ||
                        $existing->username !== $username || $existing->role !== $role || !Hash::check(self::PASSWORD, $existing->password)) {
                        throw new RuntimeException("Akun $email atau username $username sudah digunakan; data demo tidak ditambahkan.");
                    }
                    if (($role === 'guru' && (!$existing->guru || $existing->guru->nama_lengkap !== $name)) ||
                        ($role === 'siswa' && (!$existing->siswa || $existing->siswa->nama_lengkap !== $name))) {
                        throw new RuntimeException("Profil akun $email tidak cocok dengan data demo; data tidak diubah.");
                    }
                    $users[$key] = $existing;
                    continue;
                }

                $users[$key] = User::create(compact('name', 'username', 'email', 'role') + ['password' => self::PASSWORD]);
                if ($role === 'guru') {
                    Guru::create([
                        'user_id' => $users[$key]->id,
                        'nama_lengkap' => $name,
                        'bidang_keahlian' => $key === 'guru1' ? 'Psikologi anak dan masalah pribadi' : 'Jurusan, karier, dan prestasi',
                    ]);
                } elseif ($role === 'siswa') {
                    Siswa::create([
                        'user_id' => $users[$key]->id,
                        'nama_lengkap' => $name,
                        'kelas' => $key === 'siswa1' ? 'XI IPA 1' : 'XII IPS 2',
                    ]);
                }
            }

            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $examples = [
                ['001', 'siswa1', 'guru1', $today->copy()->subWeekdays(3), '08:00', 'selesai', 'Akademik', 'Kesulitan mengatur waktu belajar.', 'Menyusun rencana belajar mingguan.', null, null],
                ['002', 'siswa1', 'guru1', $today->copy()->subWeekday(), '10:45', 'selesai', 'Pribadi', 'Ingin mengelola rasa cemas saat ujian.', 'Membahas cara menenangkan diri sebelum ujian.', 5, 'Terima kasih, saya merasa lebih tenang.'],
                ['003', 'siswa1', 'guru1', $today->copy()->addWeekday(), '13:00', 'menunggu', 'Sosial', 'Ingin bercerita tentang pertemanan.', null, null, null],
                ['004', 'siswa2', 'guru2', $today->copy()->addWeekdays(2), '14:30', 'disetujui', 'Karier', 'Ingin berdiskusi tentang pilihan jurusan kuliah.', null, null, null],
            ];

            foreach ($examples as [$id, $studentKey, $teacherKey, $date, $start, $status, $category, $complaint, $result, $rating, $review]) {
                $siswa = $users[$studentKey]->siswa;
                $guru = $users[$teacherKey]->guru;
                $marker = "[DATA DEMO $id]";
                if (BookingKonseling::where('siswa_id', $siswa->id)->where('keluhan_awal', 'like', $marker.'%')->exists()) {
                    continue;
                }

                $end = Carbon::createFromFormat('H:i', $start)->addMinutes(45)->format('H:i');
                // Never reuse or modify an existing slot, even an empty one.
                $direction = $status === 'selesai' ? -1 : 1;
                for ($attempt = 0; $attempt < 365; $attempt++) {
                    $overlap = JadwalKonseling::where('guru_id', $guru->id)
                        ->whereDate('tanggal', $date->toDateString())
                        ->where('jam_mulai', '<', $end)->where('jam_selesai', '>', $start)->exists();
                    if (!$overlap) {
                        break;
                    }
                    $date = $direction < 0 ? $date->subWeekday() : $date->addWeekday();
                }
                if ($overlap) {
                    throw new RuntimeException('Tidak ada jadwal kosong untuk data demo.');
                }

                $jadwal = JadwalKonseling::create([
                    'guru_id' => $guru->id, 'tanggal' => $date->toDateString(),
                    'jam_mulai' => $start, 'jam_selesai' => $end, 'status' => $status,
                ]);
                BookingKonseling::create([
                    'jadwal_id' => $jadwal->id, 'siswa_id' => $siswa->id,
                    'kategori_masalah' => $category, 'keluhan_awal' => "$marker $complaint",
                    'catatan_hasil' => $result, 'rating' => $rating, 'ulasan' => $review,
                ]);
            }
        });
    }
}
