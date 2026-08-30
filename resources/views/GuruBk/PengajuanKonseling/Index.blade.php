<x-guru-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Pengajuan Konseling') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Atur jadwal, pantau pengajuan, dan dokumentasikan hasil konseling.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 bg-gray-50 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
                <button class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-medium rounded-lg flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Aksi Cepat
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Pengajuan Konseling Siswa</h3>
                <a href="{{ route('guru.pengajuan.index') }}" class="text-sm font-semibold text-blue-600 flex items-center gap-1 hover:text-blue-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Refresh
                </a>
            </div>

            @if($pengajuans->isEmpty())
                <div class="text-center py-16 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada pengajuan konseling</h3>
                    <p class="text-gray-500 mt-1">Saat ini tidak ada siswa yang mengajukan jadwal konseling.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pengajuans as $pengajuan)
                        @php
                            $kategori = strtolower($pengajuan->kategori_masalah);
                            if(str_contains($kategori, 'akademik')) {
                                $badgeClass = 'bg-orange-100 text-orange-600';
                            } elseif (str_contains($kategori, 'sosial')) {
                                $badgeClass = 'bg-red-100 text-red-600';
                            } elseif (str_contains($kategori, 'karir') || str_contains($kategori, 'karier')) {
                                $badgeClass = 'bg-blue-100 text-blue-600';
                            } else {
                                $badgeClass = 'bg-gray-100 text-gray-600';
                            }
                        @endphp
                        
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] hover:shadow-[0_8px_20px_-6px_rgba(6,81,237,0.15)] transition-all p-6 flex flex-col h-full">
                            
                            <!-- Header Card: Badge -->
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full {{ $badgeClass }}">
                                    {{ $pengajuan->kategori_masalah }}
                                </span>
                            </div>

                            <!-- Body Card: Informasi Siswa -->
                            <div class="mb-4">
                                <h4 class="text-lg font-bold text-gray-900">{{ $pengajuan->siswa->nama_lengkap }}</h4>
                                <p class="text-sm font-medium text-gray-500 mt-0.5">{{ $pengajuan->siswa->kelas }}</p>
                            </div>

                            <!-- Waktu Jadwal yang diajukan -->
                            <div class="mb-4 py-2 border-y border-dashed border-gray-100">
                                <div class="flex items-center text-xs text-gray-600">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($pengajuan->jadwal->tanggal)->translatedFormat('d F Y') }}
                                </div>
                                <div class="flex items-center text-xs text-gray-600 mt-1">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ \Carbon\Carbon::parse($pengajuan->jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($pengajuan->jadwal->jam_selesai)->format('H:i') }} WIB
                                </div>
                            </div>

                            <!-- Keluhan / Topik -->
                            <div class="mb-6 flex-grow">
                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                                    {{ $pengajuan->keluhan_awal }}
                                </p>
                            </div>

                            <!-- Aksi -->
                            <div class="grid grid-cols-2 gap-3 mt-auto">
                                <form action="{{ route('guru.pengajuan.terima', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full py-2.5 bg-green-50 hover:bg-green-100 text-green-600 text-sm font-bold rounded-xl transition-colors">
                                        Terima
                                    </button>
                                </form>

                                <form action="{{ route('guru.pengajuan.tolak', $pengajuan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan konseling ini?')" class="w-full py-2.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-bold rounded-xl transition-colors">
                                        Batalkan
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-guru-layout>
