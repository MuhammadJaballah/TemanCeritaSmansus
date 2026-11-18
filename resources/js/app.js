import './bootstrap';

import Alpine from 'alpinejs';
import { enhanceFormControls } from './form-controls';
import 'tom-select/dist/css/tom-select.css';
import 'flatpickr/dist/flatpickr.css';
import '../css/form-controls.css';

window.Alpine = Alpine;

Alpine.start();
enhanceFormControls(Alpine);
