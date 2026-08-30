<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin
        User::create([
            'name' => 'Admin Sekolah',
            'username' => 'admin',
            'email' => 'admin@smansus.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // 2. Guru BK
        $guruUser1 = User::create([
            'name' => 'Budi Santoso, S.Psi',
            'username' => 'budi_bk',
            'email' => 'budi.bk@smansus.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru'
        ]);
        $guru1 = Guru::create([
            'user_id' => $guruUser1->id,
            'nip' => '198505122010011001',
            'nama_lengkap' => 'Budi Santoso, S.Psi'
        ]);

        $guruUser2 = User::create([
            'name' => 'Siti Aminah, M.Pd',
            'username' => 'siti_bk',
            'email' => 'siti.bk@smansus.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru'
        ]);
        $guru2 = Guru::create([
            'user_id' => $guruUser2->id,
            'nip' => '199008242015042001',
            'nama_lengkap' => 'Siti Aminah, M.Pd'
        ]);

        // 3. Siswa
        $siswaUser1 = User::create([
            'name' => 'Andi Wijaya',
            'username' => 'andi_w',
            'email' => 'andi@siswa.smansus.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);
        $siswa1 = Siswa::create([
            'user_id' => $siswaUser1->id,
            'nisn' => '0051234567',
            'nama_lengkap' => 'Andi Wijaya',
            'kelas' => 'XII IPA 1'
        ]);

        $siswaUser2 = User::create([
            'name' => 'Rina Melati',
            'username' => 'rina_m',
            'email' => 'rina@siswa.smansus.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);
        $siswa2 = Siswa::create([
            'user_id' => $siswaUser2->id,
            'nisn' => '0069876543',
            'nama_lengkap' => 'Rina Melati',
            'kelas' => 'XII IPS 2'
        ]);

        // 4. Jadwal Konseling
        $jadwal1 = DB::table('jadwal_konselings')->insertGetId([
            'guru_id' => $guru1->id,
            'tanggal' => Carbon::tomorrow()->toDateString(),
            'jam_mulai' => '09:00:00',
            'jam_selesai' => '10:00:00',
            'status' => 'disetujui',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $jadwal2 = DB::table('jadwal_konselings')->insertGetId([
            'guru_id' => $guru1->id,
            'tanggal' => Carbon::yesterday()->toDateString(),
            'jam_mulai' => '10:30:00',
            'jam_selesai' => '11:30:00',
            'status' => 'selesai',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $jadwal3 = DB::table('jadwal_konselings')->insertGetId([
            'guru_id' => $guru1->id,
            'tanggal' => Carbon::tomorrow()->addDay()->toDateString(),
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '14:00:00',
            'status' => 'menunggu',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $jadwal4 = DB::table('jadwal_konselings')->insertGetId([
            'guru_id' => $guru2->id,
            'tanggal' => Carbon::tomorrow()->addDay()->toDateString(),
            'jam_mulai' => '13:00:00',
            'jam_selesai' => '14:00:00',
            'status' => 'tersedia',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 5. Booking Konseling
        DB::table('booking_konselings')->insert([
            'jadwal_id' => $jadwal1,
            'siswa_id' => $siswa1->id,
            'keluhan_awal' => 'Saya merasa kesulitan memahami materi matematika dan mengatur waktu belajar.',
            'kategori_masalah' => 'Akademik',
            'catatan_hasil' => null,
            'rating' => null,
            'ulasan' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('booking_konselings')->insert([
            'jadwal_id' => $jadwal2,
            'siswa_id' => $siswa2->id,
            'keluhan_awal' => 'Ingin berkonsultasi tentang komunikasi dengan teman sebaya yang akhir-akhir ini kurang baik.',
            'kategori_masalah' => 'Sosial',
            'catatan_hasil' => 'Perlu monitoring lanjutan minggu depan. Siswa diberikan saran untuk lebih terbuka.',
            'rating' => 5,
            'ulasan' => 'Konseling sangat membantu!',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Create a 3rd dummy student for the Karier card
        $siswaUser3 = User::create([
            'name' => 'Rafi Ramadhan',
            'username' => 'rafi_r',
            'email' => 'rafi@siswa.smansus.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);
        $siswa3 = Siswa::create([
            'user_id' => $siswaUser3->id,
            'nisn' => '0071112223',
            'nama_lengkap' => 'Rafi Ramadhan',
            'kelas' => 'XII IPA 3'
        ]);

        DB::table('booking_konselings')->insert([
            'jadwal_id' => $jadwal3,
            'siswa_id' => $siswa3->id,
            'keluhan_awal' => 'Saya ingin diskusi mengenai pilihan jurusan kuliah dan prospek karir ke depan.',
            'kategori_masalah' => 'Karier',
            'catatan_hasil' => null,
            'rating' => null,
            'ulasan' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 6. Prediksi Jurusan (Machine Learning mock data)
        DB::table('prediksi_jurusans')->insert([
            'siswa_id' => $siswa1->id,
            'input_nilai' => json_encode([
                'matematika' => 85,
                'bahasa_indonesia' => 88,
                'bahasa_inggris' => 90,
                'fisika' => 82,
                'kimia' => 80,
                'biologi' => 78
            ]),
            'rekomendasi' => 'Teknik Informatika, Sistem Informasi',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        DB::table('prediksi_jurusans')->insert([
            'siswa_id' => $siswa2->id,
            'input_nilai' => json_encode([
                'matematika' => 75,
                'bahasa_indonesia' => 92,
                'bahasa_inggris' => 88,
                'ekonomi' => 90,
                'sosiologi' => 85,
                'geografi' => 80
            ]),
            'rekomendasi' => 'Manajemen, Akuntansi, Ilmu Komunikasi',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
