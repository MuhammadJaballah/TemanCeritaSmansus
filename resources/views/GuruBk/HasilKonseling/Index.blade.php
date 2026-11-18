<x-guru-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Hasil Konseling') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Atur jadwal, pantau pengajuan, dan dokumentasikan hasil konseling.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="p-2 bg-gray-50 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6 space-y-6">
        <div class="flex justify-end">
            <a href="{{ route('guru.hasil.export') }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                Unduh Data Konseling (CSV)
            </a>
        </div>
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- TOP SECTION: Input & Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- FORM INPUT HASIL (Kiri) -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-[0_2px_15px_-3px_rgba(6,81,237,0.05)] border border-blue-50 p-6 sm:p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Input Hasil Konseling</h3>
                <p class="text-gray-500 text-sm mb-6">Lengkapi dokumentasi paska-sesi untuk memantau perkembangan siswa.</p>

                <form action="{{ route('guru.hasil.store') }}" method="POST">
                    @csrf
                    
                    <!-- Pilih Jadwal -->
                    <div class="mb-5">
                        <label for="booking_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Sesi Konseling <span class="text-red-500">*</span></label>
                        <div>
                            <select name="booking_id" id="booking_id" required class="block w-full rounded-xl border-gray-200 bg-gray-50 text-sm text-gray-700">
                                <option value="" disabled selected>Pilih sesi konseling</option>
                                @foreach($menungguInput as $booking)
                                    <option value="{{ $booking->id }}">
                                        {{ $booking->siswa->nama_lengkap }} · {{ \Carbon\Carbon::parse($booking->jadwal->tanggal)->locale('id')->translatedFormat('d M Y') }} · {{ \Carbon\Carbon::parse($booking->jadwal->jam_mulai)->format('H:i') }} WIB
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @if($menungguInput->isEmpty())<p class="mt-2 text-xs text-gray-500">Belum ada sesi yang menunggu catatan hasil.</p>@endif
                    </div>

                    <!-- Kategori Masalah (Pills) -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Masalah <span class="text-gray-400 font-normal text-xs">(Pilih satu yang relevan)</span></label>
                        <div class="flex flex-wrap gap-3">
                            @foreach(['Akademik', 'Karier', 'Sosial', 'Pribadi'] as $kategori)
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="kategori_masalah" value="{{ $kategori }}" class="peer sr-only" required>
                                    <div class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-600 text-sm font-medium transition-all peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 hover:bg-gray-50">
                                        {{ $kategori }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Catatan Hasil -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label for="catatan_hasil" class="block text-sm font-medium text-gray-700">Catatan Hasil Pertemuan <span class="text-red-500">*</span></label>
                            <span class="text-xs text-gray-400">Bersifat rahasia</span>
                        </div>
                        <textarea name="catatan_hasil" id="catatan_hasil" rows="6" required class="block w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50 p-4" placeholder="Tuliskan ringkasan hasil konseling, observasi perilaku, dan kesimpulan dari sesi hari ini..."></textarea>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                        <button type="reset" class="text-gray-500 hover:text-gray-700 font-medium text-sm transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-[#0057FF] hover:bg-blue-700 text-white text-sm font-semibold rounded-xl flex items-center gap-2 transition-all shadow-md shadow-blue-500/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Hasil Konseling
                        </button>
                    </div>
                </form>
            </div>

            <!-- RIGHT SIDEBAR (Panduan & Statistik) -->
            <div class="space-y-6">
                <!-- Panduan Catatan -->
                <div class="bg-white rounded-3xl shadow-[0_2px_15px_-3px_rgba(6,81,237,0.05)] border border-blue-50 p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-full -mr-12 -mt-12 opacity-50"></div>
                    
                    <div class="flex items-center gap-3 mb-6 relative">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Panduan Catatan</h3>
                    </div>

                    <div class="relative">
                        <!-- Line connecting steps -->
                        <div class="absolute left-3 top-2 bottom-2 w-0.5 bg-blue-100 -ml-[0.5px]"></div>
                        
                        <div class="space-y-6 relative">
                            <!-- Step 1 -->
                            <div class="flex gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-400 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 z-10 shadow-sm shadow-blue-200">1</div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1">Ringkas dan objektif</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed">Gunakan bahasa yang jelas, faktual, tidak menghakimi, dan fokus pada kebutuhan serta perkembangan siswa.</p>
                                </div>
                            </div>
                            
                            <!-- Step 2 -->
                            <div class="flex gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-400 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 z-10 shadow-sm shadow-blue-200">2</div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1">Tambahkan tindak lanjut</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed">Catat langkah konkrit lanjutan, tugas untuk siswa, atau rekomendasi jadwal pertemuan berikutnya (gabungkan di textarea).</p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-400 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 z-10 shadow-sm shadow-blue-200">3</div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900 mb-1">Jaga privasi</h4>
                                    <p class="text-xs text-gray-500 leading-relaxed">Informasi konseling bersifat sangat sensitif. Jaga kerahasiaan dan sistem hanya dapat diakses pihak berwenang.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="bg-[#EAEFFD] rounded-3xl p-6 sm:p-8">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">STATISTIK MINGGU INI</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-2xl p-4 text-center shadow-sm">
                            <div class="text-3xl font-bold text-blue-600 mb-1">{{ $sesiSelesaiMingguIni }}</div>
                            <div class="text-xs text-gray-500">Sesi Selesai</div>
                        </div>
                        <div class="bg-white rounded-2xl p-4 text-center shadow-sm">
                            <div class="text-3xl font-bold text-red-500 mb-1">{{ $jumlahMenungguInput }}</div>
                            <div class="text-xs text-gray-500">Menunggu Input</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BOTTOM SECTION: Riwayat Konseling -->
        <div class="bg-white rounded-3xl shadow-[0_2px_15px_-3px_rgba(6,81,237,0.05)] border border-blue-50 p-6 sm:p-8 overflow-hidden">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Riwayat Konseling</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">SISWA</th>
                            <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">KATEGORI</th>
                            <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">CATATAN RINGKAS</th>
                            <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">RATING</th>
                            <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($riwayat as $item)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-4 px-4">
                                    <div class="font-bold text-gray-900">{{ $item->siswa->nama_lengkap }}</div>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">{{ $item->kategori_masalah ?? '-' }}</td>
                                <td class="py-4 px-4 text-sm text-gray-600 max-w-xs">
                                    <p class="truncate">{{ $item->catatan_hasil ?? '-' }}</p>
                                </td>
                                <td class="py-4 px-4 text-gray-400">
                                    @if($item->rating)
                                        <div class="flex text-gray-800">
                                            @for($i=1; $i<=5; $i++)
                                                @if($i <= $item->rating)
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                @endif
                                            @endfor
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <span class="inline-flex items-center justify-center px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">
                                        Selesai
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">
                                    Belum ada riwayat konseling yang selesai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-guru-layout>
