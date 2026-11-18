<x-guru-layout headerTitle="Jadwal Konseling" headerSubtitle="Atur jadwal tetap dan lihat pengajuan konseling.">
    <div class="space-y-6">
        @if(session('success'))<div class="rounded-xl bg-green-50 p-4 text-green-700">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="rounded-xl bg-red-50 p-4 text-red-700"><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        <section x-data="{ hapusUrl: '', hapusLabel: '' }" class="rounded-3xl bg-white border border-gray-100 p-6 shadow-sm">
            <h2 class="text-lg font-bold">Jadwal tetap mingguan</h2>
            <p class="mt-1 text-sm text-gray-500">Tambahkan jadwal Senin–Jumat. Setiap sesi berlangsung 45 menit dan berulang setiap minggu dalam WIB.</p>
            <form method="POST" action="{{ route('guru.jadwal.mingguan.store') }}" class="mt-6 rounded-2xl border border-slate-100 bg-slate-50/60 p-5 sm:p-6">
                @csrf
                <fieldset>
                    <legend class="text-sm font-semibold text-slate-800">Pilih hari</legend>
                    <p class="mt-1 text-xs text-slate-500">Pilih satu hari untuk jadwal yang berulang setiap minggu.</p>
                    <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-3 xl:grid-cols-5">
                        @foreach([1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat'] as $angka => $hari)
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-300 focus-within:ring-2 focus-within:ring-blue-400 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:text-blue-700">
                                <input type="radio" name="hari" value="{{ $angka }}" @checked(old('hari') == $angka) required class="border-slate-300 text-blue-600 focus:ring-blue-500">{{ $hari }}
                            </label>
                        @endforeach
                    </div>
                </fieldset>
                <div class="mt-6 border-t border-slate-200 pt-5">
                    <x-waktu-jadwal :value="old('jam_mulai', '')" />
                </div>
                <div class="mt-5 flex justify-end"><button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>Tambah jadwal</button></div>
            </form>
            @php($namaHari = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'])
            <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
                @forelse($mingguan->groupBy('hari') as $hari => $daftarJam)
                    <article aria-labelledby="jadwal-hari-{{ $hari }}" class="rounded-2xl border border-slate-200 bg-slate-50/50 p-5">
                        <div class="flex items-center justify-between gap-3">
                            <h3 id="jadwal-hari-{{ $hari }}" class="text-sm font-bold text-slate-900">{{ $namaHari[$hari] }}</h3>
                            <span class="rounded-full bg-white px-2.5 py-1 text-xs font-medium text-slate-500">{{ $hari > 5 ? 'Tidak aktif' : $daftarJam->count().' sesi' }}</span>
                        </div>
                        @if($hari > 5)<p class="mt-2 text-xs text-amber-700">Jadwal akhir pekan lama tidak ditawarkan kepada siswa dan dapat dihapus.</p>@endif
                        <div class="mt-4 flex flex-wrap gap-x-4 gap-y-4">
                            @foreach($daftarJam as $slot)
                                @php($mulai = substr($slot->jam_mulai, 0, 5))
                                @php($selesai = app(\App\Services\JadwalTetap::class)->selesai($mulai))
                                <div class="relative flex h-12 w-40 items-center justify-center rounded-xl border border-blue-100 bg-white px-3 text-xs font-semibold text-slate-700 shadow-sm">
                                    <span class="whitespace-nowrap">{{ $mulai }} – {{ $selesai }} <span class="font-normal text-slate-400">WIB</span></span>
                                    <button type="button" data-url="{{ route('guru.jadwal.mingguan.destroy', $slot->id) }}" data-label="{{ $namaHari[$hari] }}, {{ $mulai }}–{{ $selesai }} WIB" @click="hapusUrl = $el.dataset.url; hapusLabel = $el.dataset.label; $dispatch('open-modal', 'konfirmasi-hapus-jadwal')" aria-label="Hapus jadwal {{ $namaHari[$hari] }} pukul {{ $mulai }}" title="Hapus jadwal {{ $namaHari[$hari] }} pukul {{ $mulai }}" class="absolute -right-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full border border-red-100 bg-white text-red-500 shadow-sm transition hover:bg-red-50 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-6 text-sm text-slate-500 lg:col-span-2">Belum ada jadwal tetap. Siswa tetap dapat mengajukan waktu lain.</div>
                @endforelse
            </div>
            <x-modal name="konfirmasi-hapus-jadwal" maxWidth="md" focusable>
                <div role="alertdialog" aria-modal="true" aria-labelledby="judul-hapus-jadwal" aria-describedby="pesan-hapus-jadwal" class="bg-white p-6 sm:p-7">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-600" aria-hidden="true"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.9 2.9 17a2 2 0 001.8 3h14.6a2 2 0 001.8-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg></div>
                    <h3 id="judul-hapus-jadwal" class="mt-4 text-lg font-bold text-slate-900">Hapus jadwal ini?</h3>
                    <p id="pesan-hapus-jadwal" class="mt-2 text-sm leading-6 text-slate-600">Jadwal <span class="font-semibold text-slate-800" x-text="hapusLabel"></span> tidak akan lagi tersedia setiap minggu. Pengajuan siswa yang sudah ada tetap tersimpan.</p>
                    <div class="mt-6 flex flex-wrap justify-end gap-3">
                        <button type="button" x-on:click="$dispatch('close')" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Batal</button>
                        <form method="POST" :action="hapusUrl">@csrf @method('DELETE')<button type="submit" class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700">Ya, hapus jadwal</button></form>
                    </div>
                </div>
            </x-modal>
        </section>
        <section class="rounded-3xl bg-white border border-gray-100 p-6 shadow-sm">
            <h2 class="text-lg font-bold">Pengajuan dan jadwal mendatang</h2>
            @forelse($jadwals as $jadwal)
                <div class="mt-3 flex justify-between gap-3 rounded-xl border border-gray-100 p-4 text-sm"><div><p class="font-semibold">{{ \Carbon\Carbon::parse($jadwal->tanggal)->locale('id')->translatedFormat('l, d F Y') }} · {{ substr($jadwal->jam_mulai, 0, 5) }} – {{ substr($jadwal->jam_selesai, 0, 5) }} WIB</p><p class="text-gray-500">{{ $jadwal->bookingKonselings->first()?->siswa?->nama_lengkap ?? 'Tidak ada data siswa' }}</p></div><span class="text-blue-700">{{ ucfirst($jadwal->status) }}</span></div>
            @empty<p class="mt-4 text-sm text-gray-500">Belum ada jadwal konseling mendatang.</p>@endforelse
        </section>
    </div>
</x-guru-layout>
