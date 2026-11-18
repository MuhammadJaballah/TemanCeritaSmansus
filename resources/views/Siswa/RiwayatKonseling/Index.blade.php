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
        <x-sidebar-link href="{{ route('siswa.jadwal.index') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>'>
            Jadwal Saya
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.riwayat.index') }}" :active="true" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'>
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

    <x-slot name="headerTitle">Riwayat Konseling</x-slot>
    <x-slot name="headerSubtitle">Lihat rekam jejak konseling yang telah Anda selesaikan sebelumnya.</x-slot>

    <div x-data="riwayatKonseling()" @keydown.escape.window="modalOpen = false" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 min-h-[500px]">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Konseling Saya</h3>

        @if($riwayat->isEmpty())
            <div class="flex flex-col items-center justify-center h-64 text-center">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900">Belum Ada Riwayat</h4>
                <p class="text-sm text-gray-500 mt-1 mb-6">Anda belum memiliki riwayat konseling yang telah selesai.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($riwayat as $item)
                    @php
                        $tanggal = \Carbon\Carbon::parse($item->jadwal->tanggal);
                        $dayNumber = $tanggal->format('d');
                        $monthName = $tanggal->translatedFormat('M');
                    @endphp
                    <!-- Card Riwayat -->
                    <button type="button" @click="openModal({{ json_encode([
                            'kategori' => $item->kategori_masalah,
                            'tanggal' => $tanggal->translatedFormat('l, d F Y'),
                            'waktu' => \Carbon\Carbon::parse($item->jadwal->jam_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($item->jadwal->jam_selesai)->format('H:i') . ' WIB',
                            'konselor' => $item->jadwal->guru->nama_lengkap,
                            'keluhan_awal' => $item->keluhan_awal,
                            'catatan_hasil' => $item->catatan_hasil ?? 'Tidak ada catatan khusus dari konselor.',
                        ]) }})" 
                         class="group flex w-full flex-col sm:flex-row items-center text-left border border-gray-200 rounded-2xl p-4 hover:border-blue-300 hover:shadow-md hover:bg-blue-50/30 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer">
                        
                        <!-- Kolom Tanggal -->
                        <div class="flex flex-col items-center justify-center w-full sm:w-24 sm:border-r border-gray-200 shrink-0 mb-4 sm:mb-0">
                            <span class="text-3xl font-black text-blue-600 leading-none">{{ $dayNumber }}</span>
                            <span class="text-sm font-bold text-blue-800 uppercase tracking-wider">{{ $monthName }}</span>
                        </div>
                        
                        <!-- Kolom Informasi -->
                        <div class="sm:pl-6 flex-grow text-center sm:text-left">
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-700 transition-colors">Sesi {{ $item->kategori_masalah }} selesai</h4>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-1">
                                {{ $item->jadwal->guru->nama_lengkap }} &bull; Lihat detail sesi
                            </p>
                        </div>

                        <!-- Icon Arrow -->
                        <div class="shrink-0 text-gray-300 group-hover:text-blue-500 transition-colors hidden sm:block">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif

        <!-- Modal Detail -->
        <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity" 
                     @click="modalOpen = false"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-8">
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900" id="modal-title">
                                    Detail Konseling
                                </h3>
                                <p class="text-sm text-gray-500 mt-1" x-text="'Sesi ' + selectedItem.kategori"></p>
                            </div>
                            <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-500 bg-gray-50 hover:bg-gray-100 p-2 rounded-full transition-colors">
                                <span class="sr-only">Close</span>
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Info Bar -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-3 border-y border-gray-100 text-sm">
                                <div class="flex items-center gap-2 text-gray-700">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span x-text="selectedItem.tanggal + ' (' + selectedItem.waktu + ')'"></span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-700">
                                    <div class="w-6 h-6 bg-blue-100 text-blue-700 font-bold text-[10px] rounded-full flex items-center justify-center shrink-0">
                                        <span x-text="selectedItem.konselor.substring(0, 1)"></span>
                                    </div>
                                    <span x-text="selectedItem.konselor"></span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div>
                                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Keluhan Awal (Dari Anda)</h4>
                                <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 leading-relaxed border border-gray-100">
                                    <p class="whitespace-pre-wrap break-words" x-text="selectedItem.keluhan_awal"></p>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Catatan Hasil & Evaluasi (Konselor)
                                </h4>
                                <div class="bg-blue-50/50 rounded-xl p-4 text-sm text-gray-800 leading-relaxed border border-blue-100">
                                    <p class="whitespace-pre-wrap break-words" x-text="selectedItem.catatan_hasil"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer Actions -->
                    <div class="bg-gray-50 px-4 py-4 sm:px-8 sm:flex sm:flex-row-reverse border-t border-gray-200">
                        <button type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors" @click="modalOpen = false">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('riwayatKonseling', () => ({
                modalOpen: false,
                selectedItem: {
                    kategori: '',
                    tanggal: '',
                    waktu: '',
                    konselor: '',
                    keluhan_awal: '',
                    catatan_hasil: ''
                },
                openModal(item) {
                    this.selectedItem = item;
                    this.modalOpen = true;
                }
            }))
        })
    </script>
</x-dashboard>
