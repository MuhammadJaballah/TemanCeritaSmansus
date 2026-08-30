<x-guru-layout headerTitle="Ketersediaan Jadwal" headerSubtitle="Atur jadwal, pantau pengajuan, dan dokumentasikan hasil konseling.">
    
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             x-transition class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="text-sm font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6">
        
        <!-- Slot Tersedia -->
        <x-card class="p-6 md:p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Slot Tersedia</h3>
                
                <!-- Button Trigger Modal -->
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-jadwal')" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Jadwal
                </button>
            </div>
            
            @if($groupedJadwals->isEmpty())
                <div class="text-center py-12 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p>Belum ada jadwal yang ditambahkan.</p>
                    <p class="text-sm mt-1">Silakan tambahkan jadwal melalui tombol di atas.</p>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    
                    <!-- Kiri: Tanggal (Col 1) -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Pilih Tanggal
                        </h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach($groupedJadwals as $date => $jadwals)
                                @php
                                    $carbonDate = \Carbon\Carbon::parse($date);
                                    // Format singkat, misal: Sen, 31 Agt
                                    $formattedDate = $carbonDate->translatedFormat('D, d M');
                                    $isActive = $date === $activeDate;
                                @endphp
                                
                                <div class="relative group" x-data="{ menuOpen: false }">
                                    <a href="{{ route('guru.jadwal.index', ['date' => $date]) }}" 
                                       class="flex items-center justify-between py-2.5 px-4 rounded-xl border text-sm font-bold transition-colors {{ $isActive ? 'border-blue-600 bg-blue-50 text-blue-700 shadow-sm' : 'border-gray-200 text-gray-700 bg-white hover:border-blue-300 hover:text-blue-600' }}">
                                        <span>{{ $formattedDate }}</span>
                                        <button @click.prevent="menuOpen = !menuOpen" @click.away="menuOpen = false" 
                                                class="ml-2 p-1 rounded-full hover:bg-black/5 transition-colors {{ $isActive ? 'text-blue-600' : 'text-gray-400' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"></path></svg>
                                        </button>
                                    </a>

                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="menuOpen" x-transition.opacity class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-36 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-30" style="display: none;">
                                        <button @click="menuOpen = false; $dispatch('open-edit-date-modal', { date: '{{ $date }}' })" 
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            Edit Tanggal
                                        </button>
                                        
                                        <form action="{{ route('guru.jadwal.destroyDate', $date) }}" method="POST" class="block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus semua jadwal pada tanggal ini?')" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kanan: Jam (Col 2) -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jam Tersedia
                        </h4>
                        
                        @if($activeDate && isset($groupedJadwals[$activeDate]))
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                                @foreach($groupedJadwals[$activeDate] as $jadwal)
                                    @php
                                        $time = \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i');
                                        $isAvailable = strtolower($jadwal->status) === 'tersedia';
                                    @endphp
                                    <div class="flex items-center justify-center py-2.5 rounded-xl border text-sm font-bold transition-colors {{ $isAvailable ? 'border-gray-200 text-gray-700 bg-white hover:border-blue-300 hover:text-blue-600 cursor-pointer' : 'border-transparent bg-gray-100 text-gray-400 cursor-not-allowed' }}">
                                        {{ $time }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </x-card>
    </div>

    <!-- Modal Tambah Jadwal -->
    <x-modal name="add-jadwal" :show="$errors->any()" maxWidth="md">
        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Tambah Ketersediaan Jadwal</h3>
            
            <form action="{{ route('guru.jadwal.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="tanggal" class="block text-sm font-bold text-gray-800 mb-2">Tanggal</label>
                    <div class="relative">
                        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                            class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    @error('tanggal')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-bold text-gray-800 mb-2">Jam Mulai</label>
                        <div class="relative">
                            <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" required
                                class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        @error('jam_mulai')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-sm font-bold text-gray-800 mb-2">Jam Selesai</label>
                        <div class="relative">
                            <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '09:00') }}" required
                                class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        @error('jam_selesai')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="ruang" class="block text-sm font-bold text-gray-800 mb-2">Ruang</label>
                    <div class="relative">
                        <select id="ruang" name="ruang" class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none transition-colors">
                            <option value="Ruang BK">Ruang BK</option>
                            <option value="Online (Zoom/Meet)">Online (Zoom/Meet)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal Edit Tanggal -->
    <x-modal name="edit-date" maxWidth="sm">
        <div class="p-6" x-data="{ date: '' }"
        @open-edit-date-modal.window="
            date = $event.detail.date;
            $dispatch('open-modal', 'edit-date');
        ">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Ubah Tanggal Jadwal</h3>
            
            <form x-bind:action="'/guru/jadwal/date/' + date" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label for="edit_tanggal_input" class="block text-sm font-bold text-gray-800 mb-2">Pindahkan jadwal ke tanggal baru</label>
                    <div class="relative">
                        <input type="date" id="edit_tanggal_input" name="tanggal" x-model="date" required
                            class="w-full pl-4 pr-10 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Semua jam pada tanggal ini akan dipindahkan ke tanggal yang baru Anda pilih.</p>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-semibold text-sm rounded-xl hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-all">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

</x-guru-layout>
