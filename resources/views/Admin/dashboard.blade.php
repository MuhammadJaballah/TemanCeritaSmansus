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
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Tren Layanan Konseling</h3>
                <button class="px-4 py-1.5 bg-blue-50 text-blue-600 font-medium text-sm rounded-full">Refresh</button>
            </div>
            <div class="w-full h-72 border-l border-b border-gray-200 relative flex items-end opacity-70">
                <!-- Placeholder for Line Chart -->
                <div class="absolute inset-0 flex flex-col justify-between pt-2 pb-6 px-1">
                    <div class="w-full h-px bg-gray-100"></div>
                    <div class="w-full h-px bg-gray-100"></div>
                    <div class="w-full h-px bg-gray-100"></div>
                    <div class="w-full h-px bg-gray-100"></div>
                    <div class="w-full h-px bg-gray-100"></div>
                </div>
                <div class="w-full h-48 bg-gradient-to-t from-blue-100 to-transparent relative z-10" style="clip-path: polygon(0 80%, 20% 60%, 40% 40%, 60% 50%, 80% 20%, 100% 10%, 100% 100%, 0 100%); border-top: 2px solid #2563eb;"></div>
                
                <div class="absolute bottom-0 w-full flex justify-between text-xs text-gray-400 mt-2 px-2 pb-1">
                    <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
                </div>
            </div>
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
