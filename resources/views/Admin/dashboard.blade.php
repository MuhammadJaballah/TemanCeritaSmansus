<x-admin-layout>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Siswa Aktif" 
            value="{{ $siswaAktif }}" 
            subtitle="Terdaftar di sistem" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
        />
        <x-stat-card 
            title="Guru BK" 
            value="{{ $guruBk }}" 
            subtitle="Konselor aktif" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>'
        />
        <x-stat-card 
            title="Sesi Selesai" 
            value="{{ $sesiSelesai }}" 
            subtitle="Tahun ajaran ini" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
        />
        <x-stat-card 
            title="Rating Layanan" 
            value="{{ number_format($ratingLayanan, 1) }}" 
            subtitle="Rata-rata kepuasan" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'
        />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Section -->
        <x-card class="lg:col-span-2">
            <div class="flex flex-wrap justify-between items-start gap-3 mb-5">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Tren Layanan Konseling</h3>
                    <p class="mt-1 text-sm text-gray-500">Jumlah sesi selesai berdasarkan tanggal konseling selama 6 bulan terakhir.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-1.5 bg-blue-50 text-blue-600 font-medium text-sm rounded-full hover:bg-blue-100">Perbarui</a>
            </div>
            @php
                $nilaiMaksimum = max(1, collect($trenLayanan)->max('jumlah'));
                $titikTren = collect($trenLayanan)->values()->map(fn ($bulan, $index) => [
                    'x' => 50 + $index * 100,
                    'y' => 150 - (120 * $bulan['jumlah'] / $nilaiMaksimum),
                    'label' => $bulan['label'],
                    'jumlah' => $bulan['jumlah'],
                ]);
                $garisTren = $titikTren->map(fn ($titik) => $titik['x'] . ',' . $titik['y'])->implode(' ');
            @endphp
            <figure aria-label="Grafik jumlah sesi konseling selesai per bulan">
                <svg viewBox="0 0 600 170" preserveAspectRatio="none" class="w-full h-48 sm:h-56" role="img" aria-label="Tren sesi konseling selesai; jumlah tiap bulan tercantum di bawah grafik">
                    <line x1="0" y1="30" x2="600" y2="30" stroke="#e2e8f0" stroke-dasharray="4 6" />
                    <line x1="0" y1="90" x2="600" y2="90" stroke="#e2e8f0" stroke-dasharray="4 6" />
                    <line x1="0" y1="150" x2="600" y2="150" stroke="#cbd5e1" />
                    <polyline points="{{ $garisTren }}" fill="none" stroke="#2563eb" stroke-width="3" stroke-linejoin="round" stroke-linecap="round" vector-effect="non-scaling-stroke" />
                    @foreach($titikTren as $titik)
                        <circle cx="{{ $titik['x'] }}" cy="{{ $titik['y'] }}" r="4" fill="#2563eb" stroke="white" stroke-width="2" vector-effect="non-scaling-stroke"><title>{{ $titik['label'] }}: {{ $titik['jumlah'] }} sesi selesai</title></circle>
                    @endforeach
                </svg>
                <figcaption class="grid grid-cols-6 gap-1 text-center">
                    @foreach($trenLayanan as $bulan)
                        <div><span class="block text-xs text-gray-500">{{ $bulan['label'] }}</span><span class="mt-1 block text-sm font-bold text-blue-700">{{ $bulan['jumlah'] }} <span class="font-normal text-gray-500">sesi</span></span></div>
                    @endforeach
                </figcaption>
                @if(collect($trenLayanan)->sum('jumlah') === 0)
                    <p class="mt-4 text-center text-sm text-gray-500">Belum ada sesi konseling selesai dalam 6 bulan terakhir.</p>
                @endif
            </figure>
        </x-card>

        <!-- Recent Activity Section -->
        <x-card>
            <h3 class="text-lg font-bold text-gray-900 mb-6">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @forelse($aktivitasTerbaru as $index => $aktivitas)
                <div class="flex items-start gap-4 border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 font-bold flex items-center justify-center shrink-0 text-sm">{{ $index + 1 }}</div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">Konseling Selesai</h4>
                        <p class="text-xs text-gray-500 mt-1">Sesi <b>{{ $aktivitas->siswa->nama_lengkap }}</b> bersama {{ $aktivitas->jadwal->guru->nama_lengkap }} telah diselesaikan.</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-500 text-sm">
                    Belum ada aktivitas terbaru.
                </div>
                @endforelse
            </div>
        </x-card>
    </div>
</x-admin-layout>
