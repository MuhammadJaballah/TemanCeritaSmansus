@props(['headerTitle' => 'Dashboard', 'headerSubtitle' => 'Atur jadwal, pantau pengajuan, dan dokumentasikan hasil konseling.'])

<x-dashboard>
    <x-slot name="roleTitle">Guru BK</x-slot>
    <x-slot name="userInitials">{{ substr(auth()->user()->name, 0, 2) }}</x-slot>
    
    <x-slot name="sidebar">
        <x-sidebar-link href="{{ route('guru.dashboard') }}" :active="request()->routeIs('guru.dashboard')" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>'>
            Dashboard
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('guru.jadwal.index') }}" :active="request()->routeIs('guru.jadwal.*')" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>'>
            Ketersediaan Jadwal
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('guru.pengajuan.index') }}" :active="request()->routeIs('guru.pengajuan.*')" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'>
            Pengajuan Konseling
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('guru.hasil.index') }}" :active="request()->routeIs('guru.hasil.*')" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>'>
            Hasil Konseling
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('profile.edit') }}" :active="request()->routeIs('profile.edit')" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>'>
            Profil
        </x-sidebar-link>
    </x-slot>

    <x-slot name="headerTitle">{{ $headerTitle }}</x-slot>
    <x-slot name="headerSubtitle">{{ $headerSubtitle }}</x-slot>

    {{ $slot }}
</x-dashboard>
