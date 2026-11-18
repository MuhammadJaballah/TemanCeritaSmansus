@php
    $defaultJalur = old('jalur');
    if (!$defaultJalur) {
        if ($prediksiTerbaru && strtolower($prediksiTerbaru->jalur ?? '') === 'ips') {
            $defaultJalur = 'ips';
        } elseif ($siswa && stripos($siswa->kelas ?? '', 'ips') !== false) {
            $defaultJalur = 'ips';
        } else {
            $defaultJalur = 'ipa';
        }
    }

    $allLabels = array_merge($mipaFeatures, $ipsFeatures);

    // Siapkan data awal untuk panel Hasil Rekomendasi
    $initialHasil = null;
    if ($prediksiTerbaru) {
        $detailList = $prediksiTerbaru->hasil_detail;
        if (empty($detailList) || !is_array($detailList)) {
            $parts = array_filter(array_map('trim', explode(',', $prediksiTerbaru->rekomendasi ?? '')));
            $detailList = [];
            foreach ($parts as $idx => $part) {
                $detailList[] = [
                    'rank' => $idx + 1,
                    'category' => $part,
                    'confidence_percentage' => max(70, 92 - ($idx * 6)),
                    'popular_majors_sample' => [$part],
                ];
            }
        }
        $nilaiArr = is_array($prediksiTerbaru->input_nilai) ? $prediksiTerbaru->input_nilai : [];
        $avgScore = count($nilaiArr) > 0 ? round(array_sum($nilaiArr) / count($nilaiArr), 2) : 0;

        $initialHasil = [
            'id' => $prediksiTerbaru->id,
            'jalur' => $prediksiTerbaru->jalur ?: (array_key_exists('fisika', $nilaiArr) ? 'MIPA' : 'IPS'),
            'tanggal' => $prediksiTerbaru->created_at ? $prediksiTerbaru->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-',
            'rata_rata' => $avgScore,
            'rekomendasi_ringkas' => $prediksiTerbaru->rekomendasi,
            'recommendations' => $detailList,
            'input_nilai' => $nilaiArr,
        ];
    }
@endphp

<x-siswa-layout headerTitle="Rekomendasi Jurusan" headerSubtitle="Booking konseling, lihat riwayat, dan cek rekomendasi jurusan.">

    <!-- Toast Notifications (Gaya Admin) -->
    <div class="fixed top-4 right-4 z-[60] flex flex-col gap-2">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition.duration.300ms class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-lg">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
                <button @click="show = false" class="text-green-500 hover:text-green-700 ml-4 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                 x-transition.duration.300ms class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-lg max-w-md">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
                <button @click="show = false" class="text-red-500 hover:text-red-700 ml-4 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                 x-transition.duration.300ms class="flex flex-col gap-1 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl shadow-lg max-w-md">
                <div class="flex items-center gap-3 justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-bold">Periksa Kembali Input Nilai</p>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <ul class="list-disc pl-9 text-xs mt-1 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="space-y-8"
         x-data="rekomendasiJurusanPage({
             defaultJalur: @js($defaultJalur),
             activeResult: @js($initialHasil),
             labels: @js($allLabels)
         })"
         @keydown.escape.window="detailModal = false">

        <!-- Bagian Atas: 2 Kolom (Input Nilai & Hasil Rekomendasi sesuai Gambar Referensi) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- Kolom Kiri: Card Input Nilai -->
            <x-card class="lg:col-span-5 !rounded-[28px] !p-6 sm:!p-8">
                <div class="flex items-start justify-between gap-3 mb-2">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Input Nilai Rata-rata</h3>
                        <p class="mt-1.5 text-sm text-gray-500 leading-relaxed">
                            Masukkan rata-rata nilai mata pelajaran sesuai jalur peminatan untuk simulasi rekomendasi jurusan.
                        </p>
                    </div>
                </div>

                <!-- Pilihan Jalur Endpoint: IPA vs IPS -->
                <div class="mt-5 mb-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-2.5">Pilih Jalur Peminatan (Endpoint ML)</label>
                    <div class="grid grid-cols-2 gap-2.5 p-1.5 bg-slate-100 rounded-2xl">
                        <button type="button"
                                @click="jalur = 'ipa'"
                                :class="jalur === 'ipa' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white/60'"
                                class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-sm font-bold transition-all">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <span>Jalur IPA (MIPA)</span>
                        </button>
                        <button type="button"
                                @click="jalur = 'ips'"
                                :class="jalur === 'ips' ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-white/60'"
                                class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-sm font-bold transition-all">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Jalur IPS</span>
                        </button>
                    </div>
                    <div class="mt-2.5 flex items-center justify-between text-xs text-gray-500 px-1">
                        <span x-show="jalur === 'ipa'">Endpoint: <code class="text-blue-600 font-semibold">/predict/ipa</code> (14 Mata Pelajaran)</span>
                        <span x-show="jalur === 'ips'" x-cloak>Endpoint: <code class="text-blue-600 font-semibold">/predict/ips</code> (14 Mata Pelajaran)</span>
                        <button type="button" @click="isiContohNilai()" class="text-blue-600 hover:text-blue-800 font-semibold underline">
                            Isi Contoh Nilai
                        </button>
                    </div>
                </div>

                <form action="{{ route('siswa.rekomendasi.store') }}" method="POST" @submit="sedangMemproses = true">
                    @csrf
                    <input type="hidden" name="jalur" :value="jalur">

                    <!-- Input Mata Pelajaran Jalur IPA (14 Fitur: 10 Mapel Umum + 4 Mapel Peminatan IPA) -->
                    <div x-show="jalur === 'ipa'" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($mipaFeatures as $key => $label)
                            <div>
                                <label for="ipa_{{ $key }}" class="block text-xs font-bold text-gray-800 mb-1.5">
                                    {{ $label }}
                                </label>
                                <input type="number"
                                       id="ipa_{{ $key }}"
                                       name="{{ $key }}"
                                       x-ref="ipa_{{ $key }}"
                                       :disabled="jalur !== 'ipa'"
                                       :required="jalur === 'ipa'"
                                       min="0" max="100" step="0.01"
                                       value="{{ old($key, $prediksiTerbaru && isset($prediksiTerbaru->input_nilai[$key]) ? $prediksiTerbaru->input_nilai[$key] : '') }}"
                                       placeholder="0 - 100"
                                       class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition">
                            </div>
                        @endforeach
                    </div>

                    <!-- Input Mata Pelajaran Jalur IPS (14 Fitur) -->
                    <div x-show="jalur === 'ips'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($ipsFeatures as $key => $label)
                            <div>
                                <label for="ips_{{ $key }}" class="block text-xs font-bold text-gray-800 mb-1.5">
                                    {{ $label }}
                                </label>
                                <input type="number"
                                       id="ips_{{ $key }}"
                                       name="{{ $key }}"
                                       x-ref="ips_{{ $key }}"
                                       :disabled="jalur !== 'ips'"
                                       :required="jalur === 'ips'"
                                       min="0" max="100" step="0.01"
                                       value="{{ old($key, $prediksiTerbaru && isset($prediksiTerbaru->input_nilai[$key]) ? $prediksiTerbaru->input_nilai[$key] : '') }}"
                                       placeholder="0 - 100"
                                       class="w-full px-3.5 py-2.5 bg-slate-50/70 border border-gray-200 rounded-2xl text-sm font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white focus:border-transparent transition">
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-7">
                        <button type="submit"
                                :disabled="sedangMemproses"
                                class="w-full py-3.5 px-6 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white font-bold text-sm rounded-2xl shadow-md shadow-blue-600/20 transition-all flex items-center justify-center gap-2">
                            <svg x-show="sedangMemproses" x-cloak class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="sedangMemproses ? 'Memproses Analisis ML...' : 'Proses Rekomendasi'">Proses Rekomendasi</span>
                        </button>
                    </div>
                </form>
            </x-card>

            <!-- Kolom Kanan: Card Hasil Rekomendasi (Sesuai Gambar Referensi) -->
            <x-card class="lg:col-span-7 !rounded-[28px] !p-6 sm:!p-8 flex flex-col justify-between min-h-[580px]">
                <div>
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Hasil Rekomendasi</h3>
                            <p class="text-xs text-gray-500 mt-1" x-show="activeResult">
                                Berdasarkan prediksi jalur <span class="font-bold text-blue-600" x-text="activeResult?.jalur"></span> &bull; <span x-text="activeResult?.tanggal"></span>
                            </p>
                        </div>
                        <template x-if="activeResult">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                Rata-rata Nilai: <span x-text="activeResult.rata_rata"></span>
                            </span>
                        </template>
                    </div>

                    <!-- Daftar Kartu Rekomendasi -->
                    <template x-if="activeResult && activeResult.recommendations && activeResult.recommendations.length > 0">
                        <div class="space-y-4">
                            <template x-for="(rec, index) in activeResult.recommendations" :key="index">
                                <div class="bg-slate-50/80 hover:bg-slate-100/70 border border-slate-100 rounded-2xl p-4 sm:p-5 transition-all">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <!-- Kiri: Ikon + Nama Kategori -->
                                        <div class="flex items-start sm:items-center gap-4 min-w-0">
                                            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100/80">
                                                <!-- Variasi Ikon Sesuai Urutan seperti Gambar Referensi -->
                                                <template x-if="index === 0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                </template>
                                                <template x-if="index === 1">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                                </template>
                                                <template x-if="index >= 2">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                </template>
                                            </div>
                                            <div class="min-w-0">
                                                <h4 class="text-base font-bold text-gray-900 truncate" x-text="rec.category"></h4>
                                                <p class="text-xs text-gray-500 mt-0.5">Kecocokan berdasarkan nilai &amp; potensi</p>
                                                <!-- Sampel Jurusan Populer dari Model ML -->
                                                <template x-if="rec.popular_majors_sample && rec.popular_majors_sample.length > 0">
                                                    <div class="flex flex-wrap gap-1.5 mt-2">
                                                        <template x-for="(major, mIdx) in rec.popular_majors_sample" :key="mIdx">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[11px] font-semibold bg-white text-slate-700 border border-slate-200 shadow-2xs" x-text="major"></span>
                                                        </template>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>

                                        <!-- Kanan: Progress Bar + Persentase -->
                                        <div class="flex items-center gap-3.5 shrink-0 sm:pl-2 self-end sm:self-center">
                                            <div class="w-24 sm:w-28 h-2.5 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full transition-all duration-700"
                                                     :class="barColorClass(rec.confidence_percentage, index)"
                                                     :style="'width: ' + Math.min(100, Math.max(8, rec.confidence_percentage)) + '%'"></div>
                                            </div>
                                            <span class="text-lg sm:text-xl font-extrabold min-w-[54px] text-right"
                                                  :class="textColorClass(rec.confidence_percentage, index)"
                                                  x-text="Math.round(rec.confidence_percentage) + '%'"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- State Kosong jika belum pernah prediksi -->
                    <template x-if="!activeResult || !activeResult.recommendations || activeResult.recommendations.length === 0">
                        <div class="py-12 text-center bg-slate-50/60 rounded-2xl border border-slate-100">
                            <div class="w-14 h-14 mx-auto rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            </div>
                            <h4 class="text-base font-bold text-gray-900">Belum Ada Hasil Prediksi</h4>
                            <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                                Pilih jalur peminatan (IPA atau IPS), isi nilai mata pelajaran di sebelah kiri, lalu klik <b>Proses Rekomendasi</b>.
                            </p>
                        </div>
                    </template>
                </div>

                <!-- Kotak Bawah Bergaris Putus-putus (Sesuai Gambar Referensi) -->
                <div class="mt-8 rounded-3xl border-2 border-dashed border-gray-200 bg-slate-50/40 p-6 sm:p-8 text-center flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3 shadow-2xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 max-w-xs leading-relaxed">
                        Klik proses rekomendasi untuk menjalankan animasi analisis lebih lanjut.
                    </p>
                    <template x-if="activeResult">
                        <button type="button"
                                @click="openDetailModal(activeResult)"
                                class="mt-3 inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-800">
                            <span>Lihat rincian nilai &amp; statistik lengkap</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </template>
                </div>
            </x-card>
        </div>

        <!-- Bagian Bawah: Tabel Riwayat Prediksi Jurusan (Gaya Halaman Admin) -->
        <x-card class="!rounded-[28px]">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Prediksi Rekomendasi Jurusan</h3>
                    <p class="text-sm text-gray-500">Daftar seluruh hasil simulasi dan prediksi rekomendasi jurusan yang tersimpan di database.</p>
                </div>
                <span class="inline-flex items-center rounded-full bg-blue-50 px-3.5 py-1.5 text-xs font-bold text-blue-700">
                    Total: {{ $riwayatPrediksi->count() }} Prediksi
                </span>
            </div>

            <!-- Filter & Pencarian seperti halaman Admin -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="search"
                           x-model="pencarian"
                           aria-label="Cari kategori atau jurusan rekomendasi"
                           placeholder="Cari kategori atau nama jurusan hasil prediksi..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <select x-model="filterJalur"
                        aria-label="Filter jalur peminatan"
                        class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[170px]">
                    <option value="">Semua Jalur</option>
                    <option value="MIPA">Jalur IPA (MIPA)</option>
                    <option value="IPS">Jalur IPS</option>
                </select>
            </div>

            <!-- Tabel Data Prediksi -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[820px] text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="p-4 rounded-tl-lg">No</th>
                            <th class="p-4">Tanggal Prediksi</th>
                            <th class="p-4">Jalur</th>
                            <th class="p-4">Rata-rata Nilai</th>
                            <th class="p-4">Rekomendasi Terbaik</th>
                            <th class="p-4">Sampel Jurusan Populer</th>
                            <th class="p-4 rounded-tr-lg text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody x-ref="barisPrediksi" class="divide-y divide-gray-100">
                        @forelse($riwayatPrediksi as $index => $item)
                            @php
                                $nilaiMap = is_array($item->input_nilai) ? $item->input_nilai : [];
                                $rataNilai = count($nilaiMap) > 0 ? round(array_sum($nilaiMap) / count($nilaiMap), 2) : 0;
                                $jalurItem = $item->jalur ?: (array_key_exists('fisika', $nilaiMap) ? 'MIPA' : 'IPS');

                                $detailItem = $item->hasil_detail;
                                if (empty($detailItem) || !is_array($detailItem)) {
                                    $parts = array_filter(array_map('trim', explode(',', $item->rekomendasi ?? '')));
                                    $detailItem = [];
                                    foreach ($parts as $idx => $part) {
                                        $detailItem[] = [
                                            'rank' => $idx + 1,
                                            'category' => $part,
                                            'confidence_percentage' => max(70, 92 - ($idx * 6)),
                                            'popular_majors_sample' => [$part],
                                        ];
                                    }
                                }

                                $top1 = $detailItem[0] ?? null;
                                $sampleMajors = $top1['popular_majors_sample'] ?? [];

                                $itemPayload = [
                                    'id' => $item->id,
                                    'jalur' => $jalurItem,
                                    'tanggal' => $item->created_at ? $item->created_at->translatedFormat('d F Y, H:i') . ' WIB' : '-',
                                    'rata_rata' => $rataNilai,
                                    'rekomendasi_ringkas' => $item->rekomendasi,
                                    'recommendations' => $detailItem,
                                    'input_nilai' => $nilaiMap,
                                ];
                            @endphp
                            <tr class="hover:bg-gray-50/70 transition"
                                data-rekomendasi="{{ strtolower($item->rekomendasi . ' ' . implode(' ', $sampleMajors)) }}"
                                data-jalur="{{ strtoupper($jalurItem) }}"
                                x-show="cocokBaris($el.dataset)">
                                <td class="p-4 text-sm font-semibold text-gray-500">{{ $index + 1 }}</td>
                                <td class="p-4">
                                    <span class="text-sm font-bold text-gray-900 block">
                                        {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $item->created_at ? $item->created_at->format('H:i') . ' WIB' : '' }}
                                    </span>
                                </td>
                                <td class="p-4 align-middle">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-bold rounded-lg {{ strtoupper($jalurItem) === 'MIPA' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ strtoupper($jalurItem) }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($rataNilai, 2) }}</span>
                                    <span class="text-xs text-gray-400 block">{{ count($nilaiMap) }} mapel</span>
                                </td>
                                <td class="p-4">
                                    @if($top1)
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-bold text-gray-900">{{ $top1['category'] ?? $item->rekomendasi }}</span>
                                            @if(isset($top1['confidence_percentage']))
                                                <span class="inline-flex px-2 py-0.5 text-[11px] font-bold bg-green-100 text-green-700 rounded-md">
                                                    {{ round($top1['confidence_percentage']) }}%
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">{{ $item->rekomendasi }}</p>
                                    @else
                                        <span class="text-sm font-semibold text-gray-800">{{ $item->rekomendasi }}</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if(!empty($sampleMajors))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($sampleMajors, 0, 3) as $sm)
                                                <span class="inline-flex px-2 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                                    {{ $sm }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-4 align-middle text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button"
                                                @click="tampilkanKePanel(@js($itemPayload))"
                                                class="rounded-lg bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-blue-50 hover:text-blue-700">
                                            Tampilkan
                                        </button>
                                        <button type="button"
                                                @click="openDetailModal(@js($itemPayload))"
                                                class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                            Detail Nilai
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-sm text-gray-500">
                                    Belum ada riwayat prediksi rekomendasi jurusan. Silakan masukkan nilai pada form di atas untuk memulai prediksi.
                                </td>
                            </tr>
                        @endforelse
                        <tr x-cloak x-show="(pencarian.trim() !== '' || filterJalur !== '') && !Array.from($refs.barisPrediksi.querySelectorAll('tr[data-rekomendasi]')).some(baris => cocokBaris(baris.dataset))">
                            <td colspan="7" class="p-6 text-center text-sm text-gray-500">
                                Tidak ada data prediksi yang cocok dengan filter pencarian.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card>

        <!-- Modal Detail Nilai & Rekomendasi (Gaya Modal Admin) -->
        <div x-show="detailModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4" x-cloak>
            <div role="dialog" aria-modal="true" aria-labelledby="judul-detail-prediksi"
                 @click.away="detailModal = false"
                 class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-3xl bg-white shadow-xl">
                <div class="flex items-start justify-between gap-4 border-b border-gray-100 px-6 py-5 bg-gray-50/70">
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 id="judul-detail-prediksi" class="text-lg font-bold text-gray-900">Detail Hasil Prediksi Jurusan</h3>
                            <span class="px-2.5 py-0.5 text-xs font-bold rounded-lg bg-blue-100 text-blue-700" x-text="selectedDetail?.jalur"></span>
                        </div>
                        <p class="mt-1 text-xs text-gray-500" x-text="selectedDetail?.tanggal"></p>
                    </div>
                    <button type="button" @click="detailModal = false" aria-label="Tutup" class="rounded-full p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Urutan Rekomendasi -->
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Hasil Perangkingan Model ML</h4>
                        <div class="space-y-2.5">
                            <template x-for="(rec, idx) in (selectedDetail?.recommendations || [])" :key="idx">
                                <div class="flex items-center justify-between p-3.5 rounded-2xl border border-gray-100 bg-slate-50/70">
                                    <div>
                                        <span class="text-xs font-bold text-blue-600" x-text="'Peringkat #' + (rec.rank || (idx + 1))"></span>
                                        <h5 class="text-sm font-bold text-gray-900" x-text="rec.category"></h5>
                                        <template x-if="rec.popular_majors_sample && rec.popular_majors_sample.length">
                                            <p class="text-xs text-gray-500 mt-0.5" x-text="'Contoh jurusan: ' + rec.popular_majors_sample.join(', ')"></p>
                                        </template>
                                    </div>
                                    <span class="text-base font-extrabold"
                                          :class="textColorClass(rec.confidence_percentage, idx)"
                                          x-text="rec.confidence_percentage + '%'"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Rincian Nilai Input -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500">Rincian Nilai Mata Pelajaran</h4>
                            <span class="text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg">
                                Rata-rata: <span x-text="selectedDetail?.rata_rata"></span>
                            </span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            <template x-for="[mapelKey, nilai] in Object.entries(selectedDetail?.input_nilai || {})" :key="mapelKey">
                                <div class="p-3 rounded-xl border border-gray-100 bg-gray-50/60 flex items-center justify-between">
                                    <span class="text-xs text-gray-600 font-medium truncate pr-2" x-text="formatMapelLabel(mapelKey)"></span>
                                    <span class="text-sm font-bold text-gray-900 shrink-0" x-text="nilai"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4">
                    <button type="button" @click="detailModal = false" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('rekomendasiJurusanPage', (config) => ({
                jalur: config.defaultJalur || 'ipa',
                activeResult: config.activeResult || null,
                labels: config.labels || {},
                sedangMemproses: false,
                pencarian: '',
                filterJalur: '',
                detailModal: false,
                selectedDetail: null,

                barColorClass(percentage, index) {
                    if (index === 0 || percentage >= 80) return 'bg-emerald-500';
                    if (index === 1 || percentage >= 60) return 'bg-emerald-500';
                    return 'bg-amber-600';
                },

                textColorClass(percentage, index) {
                    if (index === 0 || percentage >= 80) return 'text-emerald-600';
                    if (index === 1 || percentage >= 60) return 'text-emerald-600';
                    return 'text-amber-700';
                },

                formatMapelLabel(key) {
                    if (this.labels[key]) return this.labels[key];
                    return key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                },

                tampilkanKePanel(item) {
                    this.activeResult = item;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                openDetailModal(item) {
                    this.selectedDetail = item;
                    this.detailModal = true;
                },

                cocokBaris(dataset) {
                    const cari = this.pencarian.trim().toLowerCase();
                    const rek = (dataset.rekomendasi || '').toLowerCase();
                    const jlr = (dataset.jalur || '').toUpperCase();
                    const matchCari = !cari || rek.includes(cari);
                    const matchJalur = !this.filterJalur || jlr === this.filterJalur.toUpperCase();
                    return matchCari && matchJalur;
                },

                isiContohNilai() {
                    if (this.jalur === 'ipa') {
                        const contohIpa = {
                            agama: 90,
                            pkn: 88,
                            b_indo: 88,
                            mtk_umum: 89,
                            sejarah_indonesia: 85,
                            bahasa_inggris: 90,
                            seni_budaya: 87,
                            pjok: 86,
                            prakarya: 88,
                            bmr: 86,
                            matematika_peminatan: 91,
                            fisika: 88,
                            kimia: 86,
                            biologi: 84
                        };
                        Object.entries(contohIpa).forEach(([k, v]) => {
                            if (this.$refs['ipa_' + k]) this.$refs['ipa_' + k].value = v;
                        });
                    } else {
                        const contohIps = {
                            agama: 90,
                            pkn: 88,
                            b_indo: 91,
                            mtk_umum: 84,
                            sejarah_indonesia: 89,
                            bahasa_inggris: 90,
                            seni_budaya: 87,
                            pjok: 86,
                            prakarya: 88,
                            bmr: 87,
                            geografi: 89,
                            sejarah_peminatan: 90,
                            sosiologi: 92,
                            ekonomi: 91
                        };
                        Object.entries(contohIps).forEach(([k, v]) => {
                            if (this.$refs['ips_' + k]) this.$refs['ips_' + k].value = v;
                        });
                    }
                }
            }));
        });
    </script>
</x-siswa-layout>

