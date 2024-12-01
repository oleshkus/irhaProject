import './bootstrap';
import Alpine from 'alpinejs';
import { initMap, initSinglePointMap } from './map';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Делаем Quill доступным глобально
window.Quill = Quill;

// Инициализация Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Инициализация карт
window.initMap = initMap;
window.initSinglePointMap = initSinglePointMap;
