<x-dashboard>
    <x-slot name="roleTitle">Siswa</x-slot>
    <x-slot name="userInitials">AS</x-slot>
    
    <x-slot name="sidebar">
        <x-sidebar-link href="#" :active="true" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>'>
            Beranda
        </x-sidebar-link>
        <x-sidebar-link href="#" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'>
            Booking Konseling
        </x-sidebar-link>
        <x-sidebar-link href="#" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>'>
            Jadwal Saya
        </x-sidebar-link>
        <x-sidebar-link href="#" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'>
            Riwayat Konseling
        </x-sidebar-link>
        <x-sidebar-link href="#" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'>
            Feedback
        </x-sidebar-link>
        <x-sidebar-link href="#" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>'>
            Rekomendasi Jurusan
        </x-sidebar-link>
        <x-sidebar-link href="#" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>'>
            Profil
        </x-sidebar-link>
    </x-slot>

    <x-slot name="headerTitle">Beranda</x-slot>
    <x-slot name="headerSubtitle">Booking konseling, lihat riwayat, dan cek rekomendasi jurusan.</x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-stat-card 
            title="Jadwal Mendatang" 
            value="2" 
            subtitle="Booking aktif" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'
        />
        <x-stat-card 
            title="Sesi Berlangsung" 
            value="1" 
            subtitle="Menunggu konseling" 
            iconBg="bg-purple-50"
            iconColor="text-purple-600"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>'
        />
        <x-stat-card 
            title="Riwayat" 
            value="5" 
            subtitle="Pernah dilakukan" 
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        />
        <x-stat-card 
            title="Kecocokan" 
            value="92%" 
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
            <h3 class="text-lg font-bold text-gray-900 mb-6">Jadwal Mendatang</h3>
            <div class="space-y-4 mb-6">
                <!-- Jadwal 1 -->
                <div class="flex items-center gap-6 border border-gray-100 rounded-xl p-5 shadow-sm">
                    <div class="w-14 h-14 bg-blue-50 text-blue-700 font-bold rounded-full flex flex-col items-center justify-center shrink-0 border border-blue-100">
                        <span class="text-lg leading-none mb-0.5">22</span>
                        <span class="text-[10px] leading-none uppercase">MEI</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Konseling Akademik</h4>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Nurhafiza Supriati, S.Pd &nbsp;&bull;&nbsp; 
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            10:00 - 10:45 WIB &nbsp;&bull;&nbsp; 
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ruang BK
                        </p>
                    </div>
                </div>
                <!-- Jadwal 2 -->
                <div class="flex items-center gap-6 border border-gray-100 rounded-xl p-5 shadow-sm">
                    <div class="w-14 h-14 bg-blue-50 text-blue-700 font-bold rounded-full flex flex-col items-center justify-center shrink-0 border border-blue-100">
                        <span class="text-lg leading-none mb-0.5">28</span>
                        <span class="text-[10px] leading-none uppercase">MEI</span>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Konseling Karier</h4>
                        <p class="text-xs text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Endang Sulistyowati, S.Psi &nbsp;&bull;&nbsp; 
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            13:00 - 13:45 WIB &nbsp;&bull;&nbsp; 
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Ruang BK
                        </p>
                    </div>
                </div>
            </div>
            <button class="px-6 py-2.5 bg-blue-600 text-white font-medium text-sm rounded-full shadow-sm hover:bg-blue-700 transition">Booking Jadwal Baru</button>
        </x-card>

        <!-- Rekomendasi Jurusan -->
        <x-card>
            <h3 class="text-lg font-bold text-gray-900 mb-6">Rekomendasi Untukmu</h3>
            <div class="space-y-4 mb-6">
                <!-- Rank 1 -->
                <div class="flex items-center justify-between border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Teknik Informatika</h4>
                            <p class="text-[10px] text-gray-500">Kecocokan nilai & potensi</p>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-green-500">92%</div>
                </div>
                <!-- Rank 2 -->
                <div class="flex items-center justify-between border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-700 text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Sistem Informasi</h4>
                            <p class="text-[10px] text-gray-500">Kecocokan nilai & potensi</p>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-green-500">88%</div>
                </div>
                <!-- Rank 3 -->
                <div class="flex items-center justify-between border border-gray-100 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Manajemen</h4>
                            <p class="text-[10px] text-gray-500">Kecocokan nilai & potensi</p>
                        </div>
                    </div>
                    <div class="text-lg font-bold text-orange-500">78%</div>
                </div>
            </div>
            <button class="w-full py-2.5 bg-white border border-gray-200 text-blue-600 font-medium text-sm rounded-full shadow-sm hover:bg-gray-50 transition">Lihat Detail Rekomendasi</button>
        </x-card>
    </div>
</x-dashboard>
