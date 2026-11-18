<x-dashboard>
    <x-slot name="roleTitle">Siswa</x-slot>
    <x-slot name="userInitials">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</x-slot>
    
    <x-slot name="sidebar">
        <x-sidebar-link href="{{ route('siswa.dashboard') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>'>
            Beranda
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.booking.create') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'>
            Booking Konseling
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.jadwal.index') }}" :active="true" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>'>
            Jadwal Saya
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.riwayat.index') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'>
            Riwayat Konseling
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.feedback.index') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'>
            Feedback
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.rekomendasi.index') }}" :active="request()->routeIs('siswa.rekomendasi.*')" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>'>
            Rekomendasi Jurusan
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('profile.edit') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>'>
            Profil
        </x-sidebar-link>
    </x-slot>

    <x-slot name="headerTitle">Jadwal Saya</x-slot>
    <x-slot name="headerSubtitle">Pantau status pengajuan konseling dan riwayat jadwal Anda.</x-slot>

    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 min-h-[500px]">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Jadwal Saya</h3>

        @if(session('success'))
            <div class="mb-6 bg-green-50 text-green-700 p-4 rounded-xl text-sm border border-green-100 flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="flex flex-col items-center justify-center h-64 text-center">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900">Belum Ada Jadwal</h4>
                <p class="text-sm text-gray-500 mt-1 mb-6">Anda belum memiliki jadwal konseling aktif.</p>
                <a href="{{ route('siswa.booking.create') }}" class="px-6 py-2.5 bg-blue-600 text-white font-medium text-sm rounded-full shadow-sm hover:bg-blue-700 transition">
                    Booking Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($bookings as $booking)
                    @php
                        $status = $booking->jadwal->status;
                        
                        // Menentukan properti berdasarkan status
                        $badgeText = '';
                        $badgeClass = '';
                        $btnText = '';
                        $btnClass = '';
                        $actionForm = null;

                        if ($status === 'menunggu') {
                            $badgeText = 'DIPESAN';
                            $badgeClass = 'bg-orange-100 text-orange-700';
                            $btnText = 'Batalkan';
                            $btnClass = 'bg-red-50 text-red-600 hover:bg-red-100 border-red-100';
                            $actionForm = true;
                        } elseif ($status === 'disetujui') {
                            $badgeText = 'TERJADWAL';
                            $badgeClass = 'bg-blue-100 text-blue-700';
                            $btnText = 'Menunggu Pelaksanaan';
                            $btnClass = 'bg-blue-50 text-blue-600 border-blue-100 pointer-events-none opacity-80';
                        } elseif ($status === 'selesai') {
                            $badgeText = 'SELESAI';
                            $badgeClass = 'bg-green-100 text-green-700';
                            $btnText = 'Lihat Catatan (Selesai)';
                            $btnClass = 'bg-green-50 text-green-700 hover:bg-green-100 border-green-100';
                        } elseif ($status === 'ditolak') {
                            $badgeText = 'DITOLAK';
                            $badgeClass = 'bg-red-100 text-red-700';
                            $btnText = 'Pengajuan ditolak';
                            $btnClass = 'bg-red-50 text-red-600 border-red-100';
                        }
                        
                        // Format Waktu
                        $waktuFormat = \Carbon\Carbon::parse($booking->jadwal->tanggal)->translatedFormat('l, d F Y') . ' &bull; ' . \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') . ' WIB';
                    @endphp

                    <div class="border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow bg-white flex flex-col">
                        <!-- Badge -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                                {{ $badgeText }}
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $booking->kategori_masalah }}</h4>
                        @if($status === 'ditolak')
                            <div class="mb-4 rounded-xl bg-red-50 p-3 text-sm text-red-800"><strong>Pesan guru BK:</strong><p class="mt-1 whitespace-pre-line break-words">{{ $booking->alasan_penolakan }}</p><a href="{{ route('siswa.booking.create') }}" class="mt-2 inline-block font-semibold underline">Ajukan jadwal lain</a></div>
                        @endif
                        <div class="text-xs text-gray-500 flex items-center gap-2 mb-6">
                            <svg class="w-4 h-4 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            {!! $waktuFormat !!}
                        </div>
                        
                        <!-- Spacer to push button to bottom -->
                        <div class="flex-grow"></div>

                        <!-- Konselor Info (opsional tambahan) -->
                        <div class="mb-4 flex items-center gap-2">
                            <div class="w-6 h-6 bg-slate-100 rounded-full flex items-center justify-center text-[10px] font-bold text-slate-600">
                                {{ strtoupper(substr($booking->jadwal->guru->nama_lengkap, 0, 1)) }}
                            </div>
                            <span class="text-xs text-gray-500 truncate">{{ $booking->jadwal->guru->nama_lengkap }}</span>
                        </div>

                        <!-- Button -->
                        @if($actionForm)
                            <form action="{{ route('siswa.jadwal.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan jadwal ini?');" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full py-2.5 rounded-xl border text-sm font-semibold transition-colors {{ $btnClass }}">
                                    {{ $btnText }}
                                </button>
                            </form>
                        @elseif($status === 'selesai')
                            <button type="button" x-on:click="$dispatch('open-modal', 'catatan-konseling-{{ $booking->id }}')" class="w-full py-2.5 rounded-xl border text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 {{ $btnClass }}">
                                {{ $btnText }}
                            </button>
                            <x-modal name="catatan-konseling-{{ $booking->id }}" maxWidth="lg" focusable>
                                <div class="bg-white p-6 sm:p-8">
                                    <div class="flex items-start justify-between gap-4">
                                        <div><h3 class="text-xl font-bold text-gray-900">Catatan Konseling</h3><p class="mt-1 text-sm text-gray-500">Sesi {{ $booking->kategori_masalah }}</p></div>
                                        <button type="button" x-on:click="$dispatch('close')" aria-label="Tutup catatan" class="rounded-full bg-gray-50 p-2 text-gray-500 hover:bg-gray-100"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                                    </div>
                                    <dl class="mt-6 space-y-5 text-sm">
                                        <div class="grid gap-4 border-y border-gray-100 py-4 sm:grid-cols-2">
                                            <div><dt class="font-semibold text-gray-500">Guru BK</dt><dd class="mt-1 text-gray-900">{{ $booking->jadwal->guru->nama_lengkap }}</dd></div>
                                            <div><dt class="font-semibold text-gray-500">Tanggal dan waktu</dt><dd class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($booking->jadwal->tanggal)->locale('id')->translatedFormat('d F Y') }}, {{ substr($booking->jadwal->jam_mulai, 0, 5) }}–{{ substr($booking->jadwal->jam_selesai, 0, 5) }} WIB</dd></div>
                                        </div>
                                        <div><dt class="font-semibold text-gray-500">Keluhan awal</dt><dd class="mt-2 whitespace-pre-wrap break-words rounded-xl bg-gray-50 p-4 text-gray-700">{{ $booking->keluhan_awal }}</dd></div>
                                        <div><dt class="font-semibold text-blue-700">Catatan hasil dari guru BK</dt><dd class="mt-2 whitespace-pre-wrap break-words rounded-xl bg-blue-50 p-4 text-gray-700">{{ $booking->catatan_hasil ?: 'Belum ada catatan hasil dari guru BK.' }}</dd></div>
                                    </dl>
                                    <div class="mt-6 flex justify-end"><button type="button" x-on:click="$dispatch('close')" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Tutup</button></div>
                                </div>
                            </x-modal>
                        @else
                            <button type="button" disabled class="w-full py-2.5 rounded-xl border text-sm font-semibold {{ $btnClass }}">
                                {{ $btnText }}
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-dashboard>
