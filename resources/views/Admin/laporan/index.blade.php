<x-admin-layout headerTitle="Laporan Konseling" headerSubtitle="Lihat riwayat konseling berdasarkan siswa.">
    <div class="space-y-5">
        <section class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm sm:p-7">
            <div class="flex flex-col gap-5 border-b border-slate-100 pb-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <div class="hidden h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 sm:flex" aria-hidden="true"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12h6m-6 4h6M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg></div>
                    <div><h2 class="text-xl font-bold tracking-tight text-slate-900">Laporan Konseling</h2><p class="mt-1 text-sm leading-6 text-slate-500">Temukan riwayat dan pantau perkembangan layanan konseling siswa.</p></div>
                </div>
                <a href="{{ route('admin.laporan.export', request()->only(['start_date', 'end_date', 'kategori', 'search'])) }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m-4-4 4 4 4-4M5 17v2a2 2 0 002 2h10a2 2 0 002-2v-2"/></svg>Unduh CSV</a>
            </div>

            <form method="GET" action="{{ route('admin.laporan.index') }}" class="mt-6">
                <div class="mb-4"><h3 class="text-sm font-bold text-slate-800">Filter laporan</h3><p class="mt-1 text-xs text-slate-500">Hasil diperbarui otomatis saat pencarian atau filter diubah.</p></div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-12 xl:items-end">
                    <label class="block text-sm font-medium text-slate-700 xl:col-span-4">Cari nama siswa<span class="relative mt-1.5 block"><svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.4-4.4M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z"/></svg><input type="search" name="search" value="{{ $search }}" maxlength="255" placeholder="Cari nama siswa..." x-data x-init="if (sessionStorage.getItem('laporan-focus-search')) { sessionStorage.removeItem('laporan-focus-search'); $nextTick(() => { $el.focus(); $el.setSelectionRange($el.value.length, $el.value.length) }) }" @input.debounce.700ms="sessionStorage.setItem('laporan-focus-search', '1'); $el.form.requestSubmit()" class="w-full rounded-xl border-slate-200 bg-white py-2.5 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500"></span></label>
                    <label class="block text-sm font-medium text-slate-700 xl:col-span-2">Tanggal mulai<input type="date" name="start_date" value="{{ request('start_date') }}" x-data @change="$el.form.requestSubmit()" class="mt-1.5 w-full rounded-xl border-slate-200 bg-white py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"></label>
                    <label class="block text-sm font-medium text-slate-700 xl:col-span-2">Tanggal akhir<input type="date" name="end_date" value="{{ request('end_date') }}" x-data @change="$el.form.requestSubmit()" class="mt-1.5 w-full rounded-xl border-slate-200 bg-white py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"></label>
                    <label class="block text-sm font-medium text-slate-700 xl:col-span-2">Kategori<select name="kategori" x-data @change="$el.form.requestSubmit()" class="mt-1.5 w-full rounded-xl border-slate-200 bg-white py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"><option value="">Semua Kategori</option>@foreach($categories as $cat)<option value="{{ $cat }}" @selected(request('kategori') == $cat)>{{ $cat }}</option>@endforeach</select></label>
                    <label class="block text-sm font-medium text-slate-700 xl:col-span-2">Tampilkan<select name="per_page" x-data @change="$el.form.requestSubmit()" class="mt-1.5 w-full rounded-xl border-slate-200 bg-white py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">@foreach([10, 25, 50, 100] as $jumlah)<option value="{{ $jumlah }}" @selected($perPage === $jumlah)>{{ $jumlah }} siswa</option>@endforeach</select></label>
                    <noscript><button type="submit" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white">Filter</button></noscript>
                </div>
                @if($search !== '' || request()->filled('start_date') || request()->filled('end_date') || request()->filled('kategori'))<div class="mt-3 text-right"><a href="{{ route('admin.laporan.index', ['per_page' => $perPage]) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Reset filter</a></div>@endif
            </form>
        </section>

        <section class="overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <div><h3 class="text-base font-bold text-slate-900">Daftar siswa</h3><p class="mt-1 text-sm text-slate-500">Tekan nama siswa untuk membuka detail konseling.</p></div>
                <span class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">{{ $siswaPage->total() }} siswa ditemukan</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[680px] text-left border-collapse">
                    <thead><tr class="border-b border-slate-100 bg-slate-50/80 text-xs font-bold text-slate-500 uppercase tracking-wider"><th class="px-5 py-4 sm:pl-7">Siswa</th><th class="px-4 py-4">Kelas</th><th class="px-4 py-4">Status sesi terbaru</th><th class="px-4 py-4 sm:pr-7">Tanggal terakhir konseling</th></tr></thead>
                        @forelse($siswaPage as $siswa)
                            @php
                                $siswaId = $siswa->id;
                                $sesi = $laporans[$siswaId];
                                $urutTerbaru = $sesi->sortByDesc(fn ($item) => ($item->jadwal->tanggal ?? '') . ' ' . ($item->jadwal->jam_mulai ?? '') . ' ' . str_pad((string) $item->id, 20, '0', STR_PAD_LEFT));
                                $sesiTerbaru = $urutTerbaru->first();
                                $selesaiTerakhir = $urutTerbaru->first(fn ($item) => $item->jadwal && $item->jadwal->status === 'selesai');
                                $status = $sesiTerbaru->jadwal->status ?? '-';
                                $statusClass = match ($status) { 'selesai' => 'bg-green-100 text-green-700', 'disetujui' => 'bg-blue-100 text-blue-700', 'menunggu' => 'bg-amber-100 text-amber-700', 'ditolak' => 'bg-red-100 text-red-700', default => 'bg-gray-100 text-gray-600' };
                            @endphp
                            <tbody x-data="{ terbuka: false }" class="border-b border-slate-100 last:border-0">
                            <tr class="transition-colors hover:bg-slate-50/70" :class="terbuka ? 'bg-blue-50/30' : ''">
                                <td class="px-5 py-4 text-sm font-bold sm:pl-7"><button type="button" @click="terbuka = !terbuka" :aria-expanded="terbuka.toString()" aria-controls="detail-laporan-{{ $siswaId }}" class="group inline-flex items-center gap-3 rounded-lg text-left text-slate-800 transition hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500 transition group-hover:bg-blue-100 group-hover:text-blue-700" :class="terbuka ? 'bg-blue-100 text-blue-700' : ''"><svg class="h-4 w-4 transition-transform" :class="terbuka ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span><span>{{ $siswa->nama_lengkap }}</span></button></td>
                                <td class="px-4 py-4 text-sm text-slate-600">{{ $siswa->kelas ?? '-' }}</td>
                                <td class="px-4 py-4"><span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold {{ $statusClass }}"><span class="h-1.5 w-1.5 rounded-full bg-current" aria-hidden="true"></span>{{ ucfirst($status) }}</span></td>
                                <td class="px-4 py-4 text-sm text-slate-600 sm:pr-7">{{ $selesaiTerakhir ? \Carbon\Carbon::parse($selesaiTerakhir->jadwal->tanggal)->locale('id')->translatedFormat('d F Y') : 'Belum ada sesi selesai' }}</td>
                            </tr>
                            <tr id="detail-laporan-{{ $siswaId }}" x-show="terbuka" x-cloak>
                                <td colspan="4" class="px-5 pb-5 sm:px-7"><div class="rounded-2xl border border-blue-100 bg-blue-50/30 p-4 sm:p-5">
                                    <div class="mb-4 flex flex-wrap items-center justify-between gap-2"><div><h4 class="text-sm font-bold text-slate-900">Riwayat konseling</h4><p class="mt-1 text-xs text-slate-500">Detail sesi yang sesuai dengan filter.</p></div><p class="rounded-full bg-white px-3 py-1.5 text-xs font-semibold text-blue-700">{{ $semuaSesi[$siswaId]->filter(fn ($item) => $item->jadwal && $item->jadwal->status === 'selesai')->count() }} sesi selesai secara keseluruhan</p></div>
                                    <div class="space-y-3">
                                        @foreach($urutTerbaru as $laporan)
                                            <article class="rounded-xl border border-slate-100 bg-white p-4 text-sm shadow-sm">
                                                <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3"><h4 class="font-bold text-slate-900">Sesi ke-{{ $nomorSesi[$laporan->id] }} · {{ $laporan->kategori_masalah }}</h4><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ ucfirst($laporan->jadwal->status ?? '-') }}</span></div>
                                                <dl class="mt-3 grid gap-4 sm:grid-cols-2 text-slate-600">
                                                    <div><dt class="text-xs font-semibold text-slate-400">Guru BK</dt><dd class="mt-1">{{ $laporan->jadwal->guru->nama_lengkap ?? '-' }}</dd></div>
                                                    <div><dt class="text-xs font-semibold text-slate-400">Tanggal dan waktu</dt><dd class="mt-1">{{ $laporan->jadwal ? \Carbon\Carbon::parse($laporan->jadwal->tanggal)->locale('id')->translatedFormat('d F Y') . ', ' . substr($laporan->jadwal->jam_mulai, 0, 5) . '–' . substr($laporan->jadwal->jam_selesai, 0, 5) : '-' }}</dd></div>
                                                    <div class="sm:col-span-2"><dt class="text-xs font-semibold text-slate-400">Keluhan awal</dt><dd class="mt-1 whitespace-pre-line break-words leading-relaxed">{{ $laporan->keluhan_awal }}</dd></div>
                                                </dl>
                                            </article>
                                        @endforeach
                                    </div>
                                </div></td>
                            </tr>
                            </tbody>
                        @empty
                            <tbody><tr><td colspan="4" class="px-6 py-14 text-center"><div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-slate-400"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12h6m-6 4h6M7 3h7l5 5v11a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg></div><p class="mt-4 text-sm font-semibold text-slate-700">Tidak ada data laporan konseling yang ditemukan.</p><p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci atau filter yang dipilih.</p></td></tr></tbody>
                        @endforelse
                </table>
            </div>
            <div class="border-t border-slate-100 px-5 py-4 sm:px-7">
                <p class="text-xs leading-5 text-slate-500">Status dan tanggal mengikuti filter. Status menunjukkan sesi terbaru; tanggal menunjukkan sesi terakhir yang selesai. Jumlah dan nomor sesi pada detail dihitung dari seluruh riwayat siswa.</p>
                @if($siswaPage->hasPages())<div class="mt-5">{{ $siswaPage->links() }}</div>@endif
            </div>
        </section>
    </div>
</x-admin-layout>
