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
        <x-sidebar-link href="{{ route('siswa.riwayat.index') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'>
            Riwayat Konseling
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.feedback.index') }}" :active="true" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>'>
            Feedback
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('siswa.rekomendasi.index') }}" :active="request()->routeIs('siswa.rekomendasi.*')" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>'>
            Rekomendasi Jurusan
        </x-sidebar-link>
        <x-sidebar-link href="{{ route('profile.edit') }}" icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>'>
            Profil
        </x-sidebar-link>
    </x-slot>

    <x-slot name="headerTitle">Feedback</x-slot>
    <x-slot name="headerSubtitle">Booking konseling, lihat riwayat, dan cek rekomendasi jurusan.</x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-100 text-green-700 p-4 rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-100 text-red-700 p-4 rounded-2xl">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Form Panel -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100 h-full">
                <h3 class="text-xl font-bold text-gray-900 mb-1">Feedback Layanan BK</h3>
                <p class="text-sm text-gray-500 mb-8 border-b border-gray-100 pb-4">Berikan penilaian agar layanan BK semakin baik.</p>

                @if($unratedBookings->isEmpty())
                    <div class="flex flex-col items-center justify-center text-center py-10">
                        <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900">Belum Ada Sesi Baru</h4>
                        <p class="text-sm text-gray-500 mt-1">Anda sudah memberikan feedback pada semua sesi konseling yang telah selesai.</p>
                    </div>
                @else
                    <form action="{{ route('siswa.feedback.store') }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                        @csrf
                        
                        <!-- Pilihan Sesi Konseling -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-800 mb-3">Sesi Konseling</label>
                            <select name="booking_id" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50/50 appearance-none cursor-pointer" required>
                                <option value="" disabled selected>-- Pilih Topik Sesi yang Selesai --</option>
                                @foreach($unratedBookings as $booking)
                                    <option value="{{ $booking->id }}">
                                        {{ \Illuminate\Support\Str::limit($booking->keluhan_awal, 50) }} 
                                        ({{ \Carbon\Carbon::parse($booking->jadwal->tanggal)->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Rating Bintang -->
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-800 mb-3">Rating</label>
                            <input type="hidden" name="rating" x-model="rating" required>
                            <div class="flex items-center gap-2">
                                <template x-for="i in 5">
                                    <svg class="w-8 h-8 cursor-pointer transition-colors" 
                                         :class="(hoverRating >= i || rating >= i) ? 'text-yellow-400' : 'text-gray-300'"
                                         @mouseenter="hoverRating = i"
                                         @mouseleave="hoverRating = 0"
                                         @click="rating = i"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                        </div>

                        <!-- Ulasan -->
                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-800 mb-3">Ulasan</label>
                            <textarea name="ulasan" rows="4" class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm bg-gray-50/50" placeholder="Tuliskan kesan atau saran kamu setelah mengikuti konseling..." required></textarea>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-full shadow-md shadow-blue-500/20 transition-all text-sm">
                            Kirim Feedback
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Info Panel -->
        <div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 h-full">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Kenapa feedback penting?</h3>
                
                <div class="space-y-4">
                    <!-- Point 1 -->
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 mb-1">Meningkatkan kualitas</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Guru BK dapat mengevaluasi pendekatan layanan.</p>
                        </div>
                    </div>
                    
                    <!-- Point 2 -->
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 mb-1">Membuat siswa nyaman</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Saran siswa membantu sistem terasa lebih ramah.</p>
                        </div>
                    </div>
                    
                    <!-- Point 3 -->
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900 mb-1">Data evaluasi sekolah</h4>
                            <p class="text-xs text-gray-500 leading-relaxed">Admin dapat melihat tingkat kepuasan layanan BK.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback History Table -->
    <div x-data="{ activeFeedback: null }" @keydown.escape.window="activeFeedback = null" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-900 mb-6">Riwayat Feedback Anda</h3>
        
        @if($feedbackHistory->isEmpty())
            <div class="text-center py-8">
                <p class="text-sm text-gray-500">Belum ada riwayat feedback.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="pb-3 font-semibold text-gray-500">Konselor & Tanggal</th>
                            <th class="pb-3 font-semibold text-gray-500">Rating</th>
                            <th class="pb-3 font-semibold text-gray-500 text-right">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($feedbackHistory as $history)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 align-top">
                                    <span class="font-bold text-gray-900 block">{{ $history->jadwal->guru->nama_lengkap }}</span>
                                    <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($history->jadwal->tanggal)->format('d M Y') }}</span>
                                </td>
                                <td class="py-4 align-top">
                                    <div class="flex text-yellow-400" aria-label="{{ $history->rating }} dari 5 bintang">
                                        @for($i = 0; $i < $history->rating; $i++)
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-4 align-top text-right">
                                    <button type="button" @click="activeFeedback = {{ $history->id }}; $nextTick(() => document.getElementById('feedback-dialog-{{ $history->id }}').focus())" class="font-semibold text-blue-600 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded">
                                        Lihat detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach($feedbackHistory as $history)
                <div x-show="activeFeedback === {{ $history->id }}" x-cloak class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4" role="dialog" aria-modal="true" aria-labelledby="feedback-title-{{ $history->id }}" @click.self="activeFeedback = null">
                    <div class="fixed inset-0 bg-slate-900/50" @click="activeFeedback = null" aria-hidden="true"></div>
                    <div id="feedback-dialog-{{ $history->id }}" tabindex="-1" class="relative w-full max-w-lg max-h-[90vh] overflow-y-auto rounded-3xl bg-white p-6 shadow-xl sm:p-8 focus:outline-none">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h4 id="feedback-title-{{ $history->id }}" class="text-xl font-bold text-gray-900">Detail Feedback</h4>
                                <p class="mt-1 text-sm text-gray-500">{{ $history->jadwal->guru->nama_lengkap }} &bull; {{ \Carbon\Carbon::parse($history->jadwal->tanggal)->translatedFormat('d F Y') }}</p>
                            </div>
                            <button type="button" @click="activeFeedback = null" class="rounded-full bg-gray-50 p-2 text-gray-500 hover:bg-gray-100" aria-label="Tutup detail feedback">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <dl class="mt-6 space-y-5 text-sm">
                            <div><dt class="font-semibold text-gray-500">Kategori</dt><dd class="mt-1 text-gray-900">{{ $history->kategori_masalah }}</dd></div>
                            <div><dt class="font-semibold text-gray-500">Keluhan awal</dt><dd class="mt-1 whitespace-pre-wrap break-words rounded-xl bg-gray-50 p-4 text-gray-700">{{ $history->keluhan_awal }}</dd></div>
                            <div><dt class="font-semibold text-gray-500">Rating</dt><dd class="mt-1 font-semibold text-amber-600">{{ $history->rating }} dari 5 bintang</dd></div>
                            <div><dt class="font-semibold text-gray-500">Ulasan Anda</dt><dd class="mt-1 whitespace-pre-wrap break-words rounded-xl bg-blue-50 p-4 text-gray-700">{{ $history->ulasan }}</dd></div>
                        </dl>
                        <div class="mt-6 text-right"><button type="button" @click="activeFeedback = null" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Tutup</button></div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</x-dashboard>
