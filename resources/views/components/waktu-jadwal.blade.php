@props(['name' => 'jam_mulai', 'value' => ''])

<div data-awal="{{ $value }}" x-data="{ jam: ($el.dataset.awal || '').split(':')[0] || '', menit: ($el.dataset.awal || '').split(':')[1] || '00', pilih(jam) { this.jam = jam; this.menit = '00'; } }" x-cloak>
    <fieldset>
        <legend class="text-sm font-semibold text-slate-800">Jam mulai <span class="font-normal text-slate-500">(WIB)</span></legend>
        <p id="petunjuk-waktu-jadwal" class="mt-1 text-xs leading-5 text-slate-500">Masukkan waktu dalam format 24 jam. Setiap sesi berlangsung 45 menit.</p>
        <div class="mt-3 flex w-fit items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-100">
            <label class="sr-only" for="waktu-jadwal-jam">Jam</label>
            <input id="waktu-jadwal-jam" type="number" inputmode="numeric" min="0" max="23" step="1" x-model="jam" required placeholder="08" aria-describedby="petunjuk-waktu-jadwal" class="w-16 rounded-lg border-0 bg-slate-50 px-2 py-2 text-center text-base font-semibold text-slate-800 focus:bg-blue-50 focus:ring-2 focus:ring-blue-400">
            <span class="text-lg font-bold text-slate-400" aria-hidden="true">:</span>
            <label class="sr-only" for="waktu-jadwal-menit">Menit</label>
            <input id="waktu-jadwal-menit" type="number" inputmode="numeric" min="0" :max="Number(jam) === 23 ? 14 : 59" step="1" x-model="menit" required placeholder="00" aria-describedby="petunjuk-waktu-jadwal" class="w-16 rounded-lg border-0 bg-slate-50 px-2 py-2 text-center text-base font-semibold text-slate-800 focus:bg-blue-50 focus:ring-2 focus:ring-blue-400">
            <span class="px-1 text-xs font-bold text-slate-400">WIB</span>
        </div>
        <input type="hidden" name="{{ $name }}" disabled :disabled="false" :value="jam === '' || menit === '' ? '' : String(jam).padStart(2, '0') + ':' + String(menit).padStart(2, '0')">
        <div class="mt-3 flex flex-wrap items-center gap-2"><span class="mr-1 text-xs font-medium text-slate-500">Pilihan cepat:</span>@foreach(['08','09','10','13'] as $jam)<button type="button" @click="pilih('{{ $jam }}')" :aria-pressed="(jam !== '' && Number(jam) === {{ (int) $jam }} && Number(menit) === 0).toString()" :class="jam !== '' && Number(jam) === {{ (int) $jam }} && Number(menit) === 0 ? 'border-blue-400 bg-blue-50 text-blue-700' : 'border-slate-200 bg-white text-slate-600 hover:border-blue-300'" class="rounded-lg border px-3 py-1.5 text-xs font-semibold transition">{{ $jam }}:00</button>@endforeach</div>
    </fieldset>
</div>
<noscript><label class="block text-sm font-semibold">Jam mulai (WIB)<input type="time" name="{{ $name }}" value="{{ $value }}" max="23:14" required class="mt-2 block rounded-xl border-slate-200 text-sm"></label></noscript>
