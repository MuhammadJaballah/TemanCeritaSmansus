<x-siswa-layout headerTitle="Booking Konseling" headerSubtitle="Pilih jadwal yang nyaman untuk bercerita bersama guru BK.">
    <div class="mx-auto max-w-5xl" data-jadwal="{{ json_encode($fixedData) }}" data-terisi="{{ json_encode($bookedData) }}" data-tanggal="{{ json_encode($tanggalPilihan) }}"
         data-guru-lama="{{ old('guru_id', '') }}" data-jenis-lama="{{ old('jenis_jadwal', 'tetap') }}" data-tanggal-lama="{{ old('tanggal', '') }}" data-waktu-lama="{{ old('waktu', '') }}"
         x-data="bookingForm(JSON.parse($el.dataset.jadwal), JSON.parse($el.dataset.terisi), JSON.parse($el.dataset.tanggal), $el.dataset)">
        <div class="mb-6 rounded-3xl border border-blue-100 bg-blue-50 px-6 py-5 sm:px-8">
            <p class="text-xs font-bold uppercase tracking-wider text-blue-600">Ruang untuk bercerita</p>
            <h2 class="mt-2 text-xl font-bold text-slate-900 sm:text-2xl">Ajukan konseling dengan guru BK</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">Pilih jadwal yang tersedia atau usulkan waktu lain. Setiap sesi berlangsung 45 menit dan menunggu persetujuan guru.</p>
        </div>

        @if($errors->any())
            <div role="alert" class="mb-5 rounded-2xl border border-red-100 bg-red-50 p-4 text-sm text-red-700"><p class="font-semibold">Pengajuan belum dapat dikirim</p><ul class="mt-2 list-disc space-y-1 pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form method="POST" action="{{ route('siswa.booking.store') }}" class="space-y-5">
            @csrf
            <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-700">1</span><div><h3 class="font-bold text-slate-900">Pilih guru BK</h3><p class="mt-1 text-sm text-slate-500">Pilih guru yang ingin kamu ajak berdiskusi.</p></div></div>
                <label for="guru" class="mt-5 block text-sm font-semibold text-slate-700">Guru BK</label>
                <select id="guru" name="guru_id" x-model="guru" @change="gantiGuru()" required class="mt-2 w-full rounded-xl border-slate-200 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"><option value="">Pilih guru BK</option>@foreach($gurus as $guru)<option value="{{ $guru->id }}">{{ $guru->nama_lengkap }} — {{ $guru->bidang_keahlian ?: 'Bidang belum diisi' }}</option>@endforeach</select>
            </section>

            <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-700">2</span><div><h3 class="font-bold text-slate-900">Tentukan waktu konseling</h3><p class="mt-1 text-sm text-slate-500">Pilih cara yang paling sesuai untukmu.</p></div></div>
                <fieldset class="mt-5 grid gap-3 sm:grid-cols-2">
                    <legend class="sr-only">Jenis jadwal</legend>
                    <label class="flex cursor-pointer gap-3 rounded-2xl border p-4 transition" :class="jenis === 'tetap' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-200 hover:border-blue-300'">
                        <input type="radio" name="jenis_jadwal" value="tetap" x-model="jenis" @change="gantiJenis()" class="mt-1 text-blue-600 focus:ring-blue-500"><span><span class="block text-sm font-bold text-slate-900">Pilih jadwal tersedia</span><span class="mt-1 block text-xs leading-5 text-slate-500">Lihat waktu yang sudah ditetapkan guru.</span></span>
                    </label>
                    <label class="flex cursor-pointer gap-3 rounded-2xl border p-4 transition" :class="jenis === 'permintaan' ? 'border-blue-500 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-200 hover:border-blue-300'">
                        <input type="radio" name="jenis_jadwal" value="permintaan" x-model="jenis" @change="gantiJenis()" class="mt-1 text-blue-600 focus:ring-blue-500"><span><span class="block text-sm font-bold text-slate-900">Ajukan waktu lain</span><span class="mt-1 block text-xs leading-5 text-slate-500">Usulkan tanggal dan jam di luar jadwal guru.</span></span>
                    </label>
                </fieldset>

                <div x-show="jenis === 'tetap'" x-cloak class="mt-6">
                    <div x-show="!guru" class="rounded-2xl bg-slate-50 p-5 text-sm text-slate-500">Pilih guru BK terlebih dahulu untuk melihat jadwal yang tersedia.</div>
                    <div x-show="guru" x-cloak>
                        <div class="flex flex-wrap items-end justify-between gap-2"><div><h4 class="text-sm font-bold text-slate-800">Jadwal tersedia</h4><p class="mt-1 text-xs text-slate-500">Waktu berikut tersedia dalam 4 minggu ke depan. Semua jam dalam WIB.</p></div></div>
                        <div x-show="tanggalTersedia().length === 0" class="mt-4 rounded-2xl bg-slate-50 p-5 text-sm leading-6 text-slate-600">Belum ada jadwal tersedia dalam 4 minggu ke depan. Coba pilih tanggal lain di bawah atau ajukan waktu di luar jadwal.</div>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <template x-for="hari in tanggalTersedia()" :key="hari.tanggal">
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <p class="text-sm font-semibold text-slate-800" x-text="hari.label"></p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <template x-for="jam in jamTersedia(hari.tanggal)" :key="jam">
                                            <button type="button" @click="pilih(hari.tanggal, jam)" :aria-pressed="(tanggal === hari.tanggal && waktu === jam).toString()" :class="tanggal === hari.tanggal && waktu === jam ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-200 bg-white text-slate-700 hover:border-blue-400 hover:text-blue-700'" class="rounded-xl border px-4 py-2 text-sm font-semibold transition" x-text="jam"></button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="mt-5 border-t border-slate-100 pt-5">
                            <label for="tanggal-tetap" class="block text-sm font-semibold text-slate-700">Cari di tanggal lain</label>
                            <input id="tanggal-tetap" type="date" x-model="tanggalLain" @change="tanggal = ''; waktu = ''" :disabled="jenis !== 'tetap'" min="{{ now(\App\Services\JadwalTetap::TIMEZONE)->toDateString() }}" class="mt-2 w-full rounded-xl border-slate-200 py-3 text-sm focus:border-blue-500 focus:ring-blue-500 sm:max-w-xs">
                            <p x-show="tanggalLain && jamTersedia(tanggalLain).length === 0" class="mt-2 text-sm text-slate-500">Tidak ada jadwal tersedia pada tanggal ini.</p>
                            <div x-show="tanggalLain && jamTersedia(tanggalLain).length > 0" class="mt-3 flex flex-wrap gap-2"><template x-for="jam in jamTersedia(tanggalLain)" :key="jam"><button type="button" @click="pilih(tanggalLain, jam, true)" :aria-pressed="(tanggal === tanggalLain && waktu === jam).toString()" :class="tanggal === tanggalLain && waktu === jam ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-200 text-slate-700 hover:border-blue-400'" class="rounded-xl border px-4 py-2 text-sm font-semibold" x-text="jam"></button></template></div>
                        </div>
                    </div>
                </div>

                <div x-show="jenis === 'permintaan'" x-cloak class="mt-6 rounded-2xl bg-slate-50 p-5">
                    <h4 class="text-sm font-bold text-slate-800">Ajukan waktu di luar jadwal</h4><p class="mt-1 text-sm text-slate-500">Tentukan waktu yang kamu inginkan. Guru akan meninjau permintaanmu.</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <label for="tanggal-permintaan" class="text-sm font-semibold text-slate-700">Tanggal yang diajukan<input id="tanggal-permintaan" type="date" x-model="tanggal" :disabled="jenis !== 'permintaan'" :required="jenis === 'permintaan'" min="{{ now(\App\Services\JadwalTetap::TIMEZONE)->toDateString() }}" class="mt-2 w-full rounded-xl border-slate-200 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"></label>
                        <label for="waktu-permintaan" class="text-sm font-semibold text-slate-700">Jam yang diajukan (WIB)<input id="waktu-permintaan" type="time" x-model="waktu" :disabled="jenis !== 'permintaan'" :required="jenis === 'permintaan'" max="23:14" class="mt-2 w-full rounded-xl border-slate-200 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"></label>
                    </div>
                    <p x-show="guru && tanggal && waktu && termasukJadwalTetap(tanggal, waktu)" class="mt-3 text-sm text-amber-700">Waktu ini termasuk jadwal tetap. Pilih menu “Pilih jadwal tersedia” untuk mengajukannya.</p>
                    <p x-show="guru && tanggal && waktu && !termasukJadwalTetap(tanggal, waktu) && terhalang(tanggal, waktu)" class="mt-3 text-sm text-amber-700">Waktu ini sudah lewat atau bertabrakan dengan jadwal lain. Coba waktu lain.</p>
                </div>
                <div x-show="guru && tanggal && waktu" x-cloak class="mt-5 rounded-xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-800"><span class="font-semibold">Waktu yang dipilih:</span> <span x-text="formatTanggal(tanggal)"></span> · <span x-text="waktu"></span> WIB</div>
                <input type="hidden" name="tanggal" :value="tanggal"><input type="hidden" name="waktu" :value="waktu">
            </section>

            <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                <div class="flex gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-sm font-bold text-blue-700">3</span><div><h3 class="font-bold text-slate-900">Ceritakan kebutuhanmu</h3><p class="mt-1 text-sm text-slate-500">Informasi ini membantu guru memahami topik yang ingin dibahas.</p></div></div>
                <label for="kategori" class="mt-5 block text-sm font-semibold text-slate-700">Topik konseling</label><select id="kategori" name="kategori_masalah" required class="mt-2 w-full rounded-xl border-slate-200 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"><option value="">Pilih topik</option>@foreach(['Akademik', 'Karier', 'Sosial', 'Pribadi'] as $kategori)<option value="{{ $kategori }}" @selected(old('kategori_masalah') === $kategori)>{{ $kategori }}</option>@endforeach</select>
                <label for="keluhan" class="mt-5 block text-sm font-semibold text-slate-700">Keluhan awal</label><textarea id="keluhan" name="keluhan_awal" rows="4" required class="mt-2 w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ceritakan secara singkat hal yang ingin dibahas.">{{ old('keluhan_awal') }}</textarea>
                <p class="mt-2 text-xs leading-5 text-slate-500">Keluhan dapat diakses oleh kamu, guru BK terkait, dan admin sekolah yang berwenang.</p>
                <button type="submit" :disabled="!bisaKirim()" class="mt-6 w-full rounded-xl bg-blue-600 px-5 py-3 font-bold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-slate-300">Kirim pengajuan</button>
                <p x-show="!guru || !tanggal || !waktu" class="mt-2 text-center text-xs text-slate-500">Pilih guru dan waktu konseling untuk melanjutkan.</p>
            </section>
        </form>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bookingForm', (jadwal, terisi, daftarTanggal, lama) => ({
                guru: lama.guruLama, jenis: lama.jenisLama, tanggal: lama.tanggalLama, waktu: lama.waktuLama,
                tanggalLain: lama.jenisLama === 'tetap' ? lama.tanggalLama : '',
                gantiGuru() { this.tanggal = ''; this.waktu = ''; this.tanggalLain = ''; },
                gantiJenis() { this.tanggal = ''; this.waktu = ''; this.tanggalLain = ''; },
                pilih(tanggal, jam, dariTanggalLain = false) { this.tanggal = tanggal; this.waktu = jam; if (!dariTanggalLain) this.tanggalLain = ''; },
                jadwalHari(tanggal) {
                    if (!this.guru || !tanggal) return [];
                    const hari = new Date(tanggal + 'T12:00:00+07:00').getUTCDay() || 7;
                    return jadwal[this.guru]?.[hari] || [];
                },
                terhalang(tanggal, jam) {
                    if (!tanggal || !jam || Date.parse(`${tanggal}T${jam}:00+07:00`) <= Date.now()) return true;
                    const menit = value => Number(value.slice(0, 2)) * 60 + Number(value.slice(3, 5));
                    const mulai = menit(jam);
                    return (terisi[this.guru]?.[tanggal] || []).some(([awal, akhir]) => menit(awal) < mulai + 45 && menit(akhir) > mulai);
                },
                jamTersedia(tanggal) { return this.jadwalHari(tanggal).filter(jam => !this.terhalang(tanggal, jam)); },
                tanggalTersedia() { return daftarTanggal.filter(hari => this.jamTersedia(hari.tanggal).length > 0); },
                termasukJadwalTetap(tanggal, jam) { return this.jadwalHari(tanggal).includes(jam); },
                bisaKirim() {
                    if (!this.guru || !this.tanggal || !this.waktu || this.terhalang(this.tanggal, this.waktu)) return false;
                    return this.jenis === 'tetap' ? this.termasukJadwalTetap(this.tanggal, this.waktu) : !this.termasukJadwalTetap(this.tanggal, this.waktu);
                },
                formatTanggal(tanggal) {
                    return new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(new Date(tanggal + 'T12:00:00+07:00'));
                }
            }));
        });
    </script>
</x-siswa-layout>
