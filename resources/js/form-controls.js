import TomSelect from 'tom-select';
import flatpickr from 'flatpickr';
import { Indonesian } from 'flatpickr/dist/esm/l10n/id.js';

// Enhance the existing form fields so their names, validation and server-side values stay intact.
export function enhanceFormControls(Alpine, root = document) {
    root.querySelectorAll('select:not([multiple])').forEach((field) => {
        if (field.tomselect) return;
        const layout = [...field.classList].filter((name) => /^(?:[a-z]+:)?(?:w-|min-w-|max-w-)/.test(name));
        // Preserve layout utilities while keeping form styling on the visible control only.
        const margin = [...field.classList].filter((name) => /^(?:[a-z]+:)?m[trblxy]?-/.test(name));
        const component = new TomSelect(field, {
            allowEmptyOption: true,
            maxOptions: null,
            controlInput: field.options.length > 8 ? '<input autocomplete="off" />' : null,
            copyClassesToDropdown: false,
            render: { no_results: () => '<div class="no-results">Tidak ada pilihan yang cocok.</div>' },
        });
        component.wrapper.className = ['ts-wrapper', 'single', 'app-select', ...layout, ...margin].join(' ');
        component.refreshState();
        component.inputState();
        const model = field.getAttribute('x-model');
        if (model) {
            Alpine.effect(() => {
                const value = Alpine.evaluate(field, model);
                const next = value == null ? '' : String(value);
                if (String(component.getValue()) !== next) component.setValue(next, true);
            });
        }
        field.form?.addEventListener('reset', () => setTimeout(() => component.sync(), 0));
    });

    root.querySelectorAll('input[type="date"], input[type="time"]').forEach((field) => {
        if (field._flatpickr) return;
        const isTime = field.type === 'time';
        const format = isTime ? 'H:i' : 'Y-m-d';
        field.classList.add('app-picker', isTime ? 'app-picker-time' : 'app-picker-date');
        const options = {
            locale: Indonesian,
            disableMobile: true,
            allowInput: false,
            dateFormat: format,
            ariaDateFormat: 'j F Y',
            ...(isTime ? { enableTime: true, noCalendar: true, time_24hr: true, minuteIncrement: 1 } : {}),
            onReady: (_, __, instance) => {
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'app-picker-clear';
                button.textContent = 'Hapus pilihan';
                button.addEventListener('click', () => { instance.clear(); instance.close(); });
                instance.calendarContainer.appendChild(button);
            },
        };
        if (isTime && field.min) options.minTime = field.min;
        if (isTime && field.max) options.maxTime = field.max;
        if (!isTime && field.min) options.minDate = field.min;
        if (!isTime && field.max) options.maxDate = field.max;
        const picker = flatpickr(field, options);
        const model = field.getAttribute('x-model');
        if (model) {
            Alpine.effect(() => {
                const value = Alpine.evaluate(field, model) || '';
                const current = picker.selectedDates[0] ? picker.formatDate(picker.selectedDates[0], format) : '';
                if (value !== current) picker.setDate(value || [], false, format);
            });
        }
        field.form?.addEventListener('reset', () => setTimeout(() => picker.setDate(field.value || [], false, format), 0));
    });
}
