import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import { JSDOM } from 'jsdom';

test('pilihan waktu cepat dan isian manual menghasilkan waktu jadwal yang valid', async () => {
    let component = await readFile(new URL('../resources/views/components/waktu-jadwal.blade.php', import.meta.url), 'utf8');
    component = component.replace(/^@props\([^\n]*\)\s*/, '')
        .replaceAll('{{ $value }}', '')
        .replaceAll('{{ $name }}', 'jam_mulai')
        .replace(/<noscript>[\s\S]*?<\/noscript>/, '')
        .replace(/@foreach\(\['08','09','10','13'\] as \$jam\)(.*?)@endforeach/s, (_, button) =>
            ['08', '09', '10', '13'].map(hour => button.replaceAll('{{ $jam }}', hour).replaceAll('{{ (int) $jam }}', String(Number(hour)))).join(''));
    const dom = new JSDOM(`<form id="form">${component}</form>`, { url: 'http://localhost/', runScripts: 'outside-only' });
    for (const key of ['window', 'document', 'navigator', 'HTMLElement', 'Element', 'Node', 'ShadowRoot', 'MutationObserver', 'CustomEvent', 'Event']) {
        Object.defineProperty(globalThis, key, { value: dom.window[key], configurable: true, writable: true });
    }
    const alpineModule = (await import('alpinejs')).default;
    const Alpine = alpineModule.default ?? alpineModule;
    Alpine.start();
    const tick = () => new Promise(resolve => setTimeout(resolve, 20));
    await tick();
    const form = document.querySelector('#form');
    assert.equal(form.checkValidity(), false);
    [...form.querySelectorAll('button')].find(button => button.textContent.trim() === '09:00').click();
    await tick();
    assert.equal(new dom.window.FormData(form).get('jam_mulai'), '09:00');
    assert.equal(form.checkValidity(), true, [...form.elements].filter(element => !element.checkValidity()).map(element => `${element.outerHTML}: ${element.validationMessage}`).join('\n'));
    const hour = document.querySelector('#waktu-jadwal-jam');
    const minute = document.querySelector('#waktu-jadwal-menit');
    hour.value = '23'; hour.dispatchEvent(new Event('input', { bubbles: true }));
    minute.value = '15'; minute.dispatchEvent(new Event('input', { bubbles: true }));
    await tick();
    assert.equal(form.checkValidity(), false);
    minute.value = '07'; minute.dispatchEvent(new Event('input', { bubbles: true }));
    await tick();
    assert.equal(new dom.window.FormData(form).get('jam_mulai'), '23:07');
    assert.equal(form.checkValidity(), true);
    dom.window.close();
});
