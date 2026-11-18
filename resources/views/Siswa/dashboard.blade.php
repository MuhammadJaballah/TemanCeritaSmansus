<x-siswa-layout headerTitle="Beranda" headerSubtitle="Booking konseling, lihat riwayat, dan cek rekomendasi jurusan.">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Jadwal Mendatang" 
            value="{{ $jadwalMendatangCount }}" 
            subtitle="Telah Disetujui" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
        />
        <x-stat-card 
            title="Sesi Berlangsung" 
            value="{{ $sesiMenungguCount }}" 
            subtitle="Menunggu konfirmasi" 
            iconBg="bg-purple-50"
            iconColor="text-purple-600"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>'
        />
        <x-stat-card 
            title="Riwayat" 
            value="{{ $riwayatCount }}" 
            subtitle="Pernah dilakukan" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        />
        @php
            $topRec = null;
            if (!empty($prediksiTerbaru) && !empty($prediksiTerbaru->hasil_detail) && is_array($prediksiTerbaru->hasil_detail)) {
                $topRec = $prediksiTerbaru->hasil_detail[0] ?? null;
            }
            $kecocokanValue = $topRec && isset($topRec['confidence_percentage'])
                ? round($topRec['confidence_percentage']) . '%'
                : ($prediksiTerbaru ? 'Tersedia' : '-');
            $topMajorTitle = $topRec['category'] ?? ($prediksiTerbaru->rekomendasi ?? 'Belum Cek Prediksi');
            $topMajorTrack = $prediksiTerbaru->jalur ?? 'MIPA / IPS';
        @endphp
        <x-stat-card 
            title="Kecocokan" 
            value="{{ $kecocokanValue }}" 
            subtitle="Rekomendasi terbaik" 
            iconBg="bg-green-50"
            iconColor="text-green-600"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>'
        />
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Jadwal Mendatang -->
        <x-card class="lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-gray-900">Jadwal Mendatang</h3>
                <a href="{{ route('siswa.jadwal.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua</a>
            </div>
            
            <div class="space-y-4">
                @if($jadwalMendatang->isEmpty())
                    <div class="text-center py-6">
                        <p class="text-sm text-gray-500">Belum ada jadwal mendatang.</p>
                        <a href="{{ route('siswa.booking.create') }}" class="mt-2 inline-block text-sm font-semibold text-blue-600 hover:text-blue-700">Buat Jadwal Baru &rarr;</a>
                    </div>
                @else
                    @foreach($jadwalMendatang as $booking)
                        @php
                            $tanggal = \Carbon\Carbon::parse($booking->jadwal->tanggal);
                            $isMenunggu = $booking->jadwal->status === 'menunggu';
                        @endphp
                        <div class="flex items-center gap-6 border {{ $isMenunggu ? 'border-orange-100 bg-orange-50/20' : 'border-gray-100' }} rounded-xl p-5 shadow-sm relative overflow-hidden group hover:border-blue-200 transition-colors">
                            @if($isMenunggu)
                                <div class="absolute top-0 right-0 bg-orange-100 text-orange-600 text-[10px] font-bold px-3 py-1 rounded-bl-xl">Menunggu</div>
                            @endif
                            <div class="w-14 h-14 {{ $isMenunggu ? 'bg-orange-50 text-orange-600 border-orange-100' : 'bg-blue-50 text-blue-700 border-blue-100' }} font-bold rounded-full flex flex-col items-center justify-center shrink-0 border">
                                <span class="text-lg leading-none mb-0.5">{{ $tanggal->format('d') }}</span>
                                <span class="text-[10px] leading-none uppercase">{{ $tanggal->translatedFormat('M') }}</span>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-900 mb-1">{{ $booking->kategori_masalah }}</h4>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 flex-wrap">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $booking->jadwal->guru->nama_lengkap }}
                                    </span>
                                    <span class="text-gray-300">&bull;</span> 
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jadwal->jam_selesai)->format('H:i') }} WIB
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </x-card>

        <!-- Right Column Group -->
        <div class="space-y-6">
            <!-- Riwayat Terakhir -->
            <x-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Terakhir</h3>
                    <a href="{{ route('siswa.riwayat.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Semua</a>
                </div>
                
                <div class="space-y-5">
                    @if($riwayatTerakhir->isEmpty())
                        <p class="text-sm text-gray-500 text-center py-4">Belum ada riwayat konseling.</p>
                    @else
                        @foreach($riwayatTerakhir as $riwayat)
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 mt-2 rounded-full bg-green-500 shrink-0"></div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $riwayat->kategori_masalah }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 mb-2">{{ \Carbon\Carbon::parse($riwayat->jadwal->tanggal)->translatedFormat('l, d M Y') }}</p>
                                    @if($riwayat->rating)
                                        <div class="flex text-yellow-400">
                                            @for($i = 0; $i < $riwayat->rating; $i++)
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                            @endfor
                                        </div>
                                    @else
                                        <a href="{{ route('siswa.feedback.index') }}" class="text-[10px] bg-yellow-50 text-yellow-700 px-2 py-1 rounded font-bold uppercase tracking-wider inline-block">Beri Rating</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </x-card>

            <!-- Rekomendasi Jurusan (Dummy) -->
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-6 shadow-md text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10"></div>
                <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white opacity-10"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg">Rekomendasi Jurusan</h3>
                    </div>
                    
                    <p class="text-blue-100 text-sm mb-6 leading-relaxed">Berdasarkan hasil asesmen dan nilai rapormu, jurusan yang paling sesuai adalah:</p>
                    
                    <div class="bg-white/10 rounded-2xl p-4 backdrop-blur-md border border-white/20 mb-4">
                        <h4 class="font-bold text-xl text-white mb-1">{{ $topMajorTitle }}</h4>
                        <p class="text-blue-100 text-xs">
                            @if($topRec && isset($topRec['confidence_percentage']))
                                Kecocokan {{ number_format((float) $topRec['confidence_percentage'], 1) }}% &bull; {{ $topMajorTrack }}
                            @elseif($prediksiTerbaru)
                                Hasil tersimpan &bull; {{ $topMajorTrack }}
                            @else
                                Masukkan nilai rapor untuk melihat analisis jurusan
                            @endif
                        </p>
                    </div>

                    <a href="{{ route('siswa.rekomendasi.index') }}" class="inline-flex items-center justify-center w-full py-2.5 bg-white text-blue-700 font-bold text-sm rounded-xl hover:bg-blue-50 transition-colors">
                        Lihat Detail Analisis
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-siswa-layout>
