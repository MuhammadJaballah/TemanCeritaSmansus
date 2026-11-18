@props(['headerTitle' => 'Dashboard', 'headerSubtitle' => 'Atur jadwal, pantau pengajuan, dan dokumentasikan hasil konseling.'])

@php
    $pengajuanBaru = \App\Models\BookingKonseling::baruUntukGuru(auth()->user()->guru?->id)->count();
@endphp

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
        <x-sidebar-link href="{{ route('guru.pengajuan.index') }}" :active="request()->routeIs('guru.pengajuan.*')" x-data="{ jumlah: {{ $pengajuanBaru }} }" x-init="setInterval(() => { if (!document.hidden) fetch('{{ route('guru.pengajuan.jumlah-baru') }}', { headers: { 'Accept': 'application/json' } }).then(response => response.ok ? response.json() : null).then(data => { if (data) jumlah = data.jumlah }).catch(() => {}) }, 30000)" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>'>
            <span class="min-w-0 flex-1">Pengajuan Konseling</span>
            <span x-cloak x-show="jumlah > 0" role="status" :aria-label="jumlah + ' pengajuan baru belum dibuka'" :title="jumlah + ' pengajuan baru belum dibuka'" class="relative ml-auto flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <svg aria-hidden="true" class="h-[18px] w-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.86 17.08a3 3 0 01-5.72 0M18 8a6 6 0 00-12 0c0 7-2.5 7-2.5 9h17c0-2-2.5-2-2.5-9z"/></svg>
                <span aria-hidden="true" x-text="jumlah > 99 ? '99+' : jumlah" class="absolute -right-2 -top-2 flex h-[18px] min-w-[18px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold leading-none text-white ring-2 ring-white"></span>
            </span>
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
