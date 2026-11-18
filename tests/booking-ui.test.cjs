const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');

test('form shows free recurring appointments and validates both choices', () => {
    const blade = fs.readFileSync(path.join(__dirname, '../resources/views/Siswa/BookingKonseling/Create.blade.php'), 'utf8');
    const script = blade.match(/<script>([\s\S]*?)<\/script>/)[1];
    let createForm;
    const document = { addEventListener: (_, callback) => callback() };
    const Alpine = { data: (_, factory) => { createForm = factory; } };
    vm.runInNewContext(script, { document, Alpine, Date, Intl });

    const date = '2099-01-05';
    const weekday = new Date(date + 'T12:00:00+07:00').getUTCDay() || 7;
    const schedule = { 1: { [weekday]: ['09:00', '10:00'] } };
    const busy = { 1: { [date]: [['09:15', '10:00']] } };
    const dates = [{ tanggal: date, label: 'Tanggal uji' }, { tanggal: '2099-01-06', label: 'Hari lain' }];
    const form = createForm(schedule, busy, dates, { guruLama: '1', jenisLama: 'tetap', tanggalLama: '', waktuLama: '' });

    assert.deepEqual(Array.from(form.jamTersedia(date)), ['10:00']);
    assert.equal(form.tanggalTersedia().length, 1);
    form.pilih(date, '10:00');
    assert.equal(form.bisaKirim(), true);
    form.jenis = 'permintaan';
    assert.equal(form.bisaKirim(), false); // Fixed times cannot be submitted as custom.
    form.waktu = '11:00';
    assert.equal(form.bisaKirim(), true);
    form.waktu = '09:30';
    assert.equal(form.bisaKirim(), false); // Overlaps an occupied session.
    form.gantiGuru();
    assert.equal(form.tanggal, '');
    assert.equal(form.waktu, '');
});
