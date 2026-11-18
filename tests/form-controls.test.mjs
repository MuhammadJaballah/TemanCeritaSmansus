import { test } from 'node:test';
import assert from 'node:assert/strict';
import { JSDOM } from 'jsdom';

test('komponen pilihan dan kalender menjaga nilai formulir dan sinkron dengan Alpine', async () => {
    const dom = new JSDOM(`<!doctype html><html><body>
        <div x-data="{ pilihan: 'a', tanggal: '', waktu: '', nonaktif: false, berubah: 0 }">
            <form id="form">
                <label for="pilihan">Pilihan</label>
                <select id="pilihan" name="pilihan" required x-model="pilihan" @change="berubah++"><option value="">Pilih</option><option value="a">Satu</option><option value="b">Dua</option></select>
                <select id="wajib" name="wajib" required><option value="" disabled selected>Pilih sesi</option><option value="1">Sesi pertama</option></select>
                <input id="tanggal" type="date" name="tanggal" min="2026-11-01" x-model="tanggal">
                <input id="waktu" type="time" name="waktu" max="23:14" x-model="waktu" :disabled="nonaktif">
            </form>
        </div>
    </body></html>`, { url: 'http://localhost/' });
    for (const key of ['window', 'document', 'navigator', 'HTMLElement', 'HTMLInputElement', 'HTMLSelectElement', 'Element', 'Node', 'NodeList', 'HTMLCollection', 'ShadowRoot', 'MutationObserver', 'CustomEvent', 'Event', 'getComputedStyle']) {
        Object.defineProperty(globalThis, key, { value: dom.window[key], configurable: true, writable: true });
    }
    globalThis.requestAnimationFrame = (fn) => setTimeout(fn, 0);
    const alpineModule = (await import('alpinejs')).default;
    const Alpine = alpineModule.default ?? alpineModule;
    const { enhanceFormControls } = await import('../resources/js/form-controls.js');
    window.Alpine = Alpine;
    Alpine.start();
    enhanceFormControls(Alpine);
    const tick = () => new Promise(resolve => setTimeout(resolve, 20));
    await tick();

    const select = document.querySelector('#pilihan');
    const date = document.querySelector('#tanggal');
    const time = document.querySelector('#waktu');
    const state = Alpine.$data(select);
    assert.ok(select.tomselect);
    assert.ok(date._flatpickr);
    assert.ok(time._flatpickr);
    const wajib = document.querySelector('#wajib');
    assert.equal(wajib.value, '');
    assert.equal(document.querySelector('#form').checkValidity(), false);
    wajib.tomselect.setValue('1');
    assert.equal(document.querySelector('#form').checkValidity(), true);
    assert.equal(select.tomselect.getValue(), 'a');
    select.tomselect.setValue('b');
    await tick();
    assert.equal(state.pilihan, 'b');
    assert.equal(state.berubah, 1);
    assert.equal(new dom.window.FormData(document.querySelector('#form')).get('pilihan'), 'b');
    state.pilihan = 'a';
    await tick();
    assert.equal(select.tomselect.getValue(), 'a');

    date._flatpickr.setDate('2026-11-05', true);
    time._flatpickr.setDate('10:30', true);
    await tick();
    assert.equal(state.tanggal, '2026-11-05');
    assert.equal(state.waktu, '10:30');
    date._flatpickr.calendarContainer.querySelector('.app-picker-clear').click();
    await tick();
    assert.equal(state.tanggal, '');
    state.waktu = '';
    state.nonaktif = true;
    await tick();
    assert.equal(date.value, '');
    assert.equal(time.value, '');
    assert.equal(time.disabled, true);
    assert.equal(date._flatpickr.config.minDate.getDate(), 1);
    assert.equal(time._flatpickr.config.maxTime.getMinutes(), 14);
    dom.window.close();
});
