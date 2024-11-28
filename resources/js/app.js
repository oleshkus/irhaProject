import './bootstrap';

import Alpine from 'alpinejs';
import 'quill/dist/quill.snow.css';
import Quill from 'quill';

window.Quill = Quill; // Делает Quill доступным глобально
window.Alpine = Alpine;

Alpine.start();
