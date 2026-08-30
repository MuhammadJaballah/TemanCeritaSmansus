<x-guru-layout headerTitle="Dashboard" headerSubtitle="Atur jadwal, pantau pengajuan, dan dokumentasikan hasil konseling.">

    <!-- Stats Grid -->
    <div class="grid grid-cols-1  md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Jadwal Hari Ini" 
            value="{{ $jadwalHariIni }}" 
            subtitle="Slot konseling" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
        />
        <x-stat-card 
            title="Pengajuan Baru" 
            value="{{ $pengajuanBaru }}" 
            subtitle="Menunggu konfirmasi" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>'
        />
        <x-stat-card 
            title="Selesai" 
            value="{{ $selesaiBulanIni }}" 
            subtitle="Bulan ini" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        />
        <x-stat-card 
            title="Rating" 
            value="{{ number_format($rating, 1) }}" 
            subtitle="Dari siswa" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'
        />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Jadwal Terdekat -->
        <x-card class="lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Jadwal Terdekat</h3>
                <a href="{{ route('guru.jadwal.index') }}" class="text-blue-600 font-semibold text-sm hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-4">
                @forelse($jadwalTerdekat as $booking)
                <div class="flex items-center gap-4 border border-gray-200 rounded-xl p-4 shadow-sm hover:border-blue-300 transition">
                    <div class="w-16 h-10 bg-blue-100 text-blue-700 font-bold rounded-lg flex items-center justify-center shrink-0">
                        {{ \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') }}
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900">{{ $booking->siswa->nama_lengkap }}</h4>
                        <p class="text-xs text-gray-500 mt-1">Topik: {{ $booking->kategori_masalah }} &bull; {{ \Carbon\Carbon::parse($booking->jadwal->tanggal)->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-500 text-sm">
                    Tidak ada jadwal terdekat.
                </div>
                @endforelse
            </div>
        </x-card>

        <!-- Distribusi Kategori -->
        <x-card>
            <h3 class="text-lg font-bold text-gray-900 mb-6">Distribusi Kategori</h3>
            <div class="flex flex-col items-center justify-center h-64">
                <!-- Simple CSS Donut Chart (Fallback) -->
                @php
                    $pAkademik = $totalKategori > 0 ? ($akademik / $totalKategori) * 100 : 0;
                    $pKarier = $totalKategori > 0 ? ($karier / $totalKategori) * 100 : 0;
                    $pSosial = $totalKategori > 0 ? ($sosial / $totalKategori) * 100 : 0;
                    $pPribadi = $totalKategori > 0 ? ($pribadi / $totalKategori) * 100 : 0;
                    
                    // Creates a simple conic gradient for the donut chart
                    $gradient = "conic-gradient(
                        #2563eb 0% {$pAkademik}%, 
                        #f43f5e {$pAkademik}% " . ($pAkademik + $pKarier) . "%, 
                        #fb923c " . ($pAkademik + $pKarier) . "% " . ($pAkademik + $pKarier + $pSosial) . "%, 
                        #facc15 " . ($pAkademik + $pKarier + $pSosial) . "% 100%
                    )";
                @endphp

                <div class="w-40 h-40 rounded-full mb-8 relative flex items-center justify-center" style="background: {{ $gradient }}">
                    <!-- Inner circle for donut -->
                    <div class="w-32 h-32 bg-white rounded-full flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-gray-800">{{ $totalKategori }}</span>
                        <span class="text-[10px] font-medium text-gray-500 uppercase tracking-wider">Total</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-x-8 gap-y-3 text-xs font-medium text-gray-600">
                    <div class="flex items-center gap-2 justify-between w-full">
                        <div class="flex items-center gap-2"><span class="w-3 h-1 rounded bg-blue-600"></span> Akademik</div>
                        <span class="font-bold text-gray-800">{{ $akademik }}</span>
                    </div>
                    <div class="flex items-center gap-2 justify-between w-full">
                        <div class="flex items-center gap-2"><span class="w-3 h-1 rounded bg-rose-500"></span> Karier</div>
                        <span class="font-bold text-gray-800">{{ $karier }}</span>
                    </div>
                    <div class="flex items-center gap-2 justify-between w-full">
                        <div class="flex items-center gap-2"><span class="w-3 h-1 rounded bg-orange-400"></span> Sosial</div>
                        <span class="font-bold text-gray-800">{{ $sosial }}</span>
                    </div>
                    <div class="flex items-center gap-2 justify-between w-full">
                        <div class="flex items-center gap-2"><span class="w-3 h-1 rounded bg-yellow-400"></span> Pribadi</div>
                        <span class="font-bold text-gray-800">{{ $pribadi }}</span>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</x-guru-layout>
