import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-control-geocoder';
import 'leaflet-control-geocoder/dist/Control.Geocoder.css';

// Инициализация карты для отображения одной точки
export function initSinglePointMap(containerId, latitude, longitude, name) {
    const map = L.map(containerId).setView([latitude, longitude], 13);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
    }).addTo(map);

    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup(name);

    // Add geocoder
    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const bbox = e.geocode.bbox;
        const poly = L.polygon([
            bbox.getSouthEast(),
            bbox.getNorthEast(),
            bbox.getNorthWest(),
            bbox.getSouthWest()
        ]).addTo(map);
        map.fitBounds(poly.getBounds());
    })
    .addTo(map);

    // Fix display issues
    setTimeout(() => map.invalidateSize(), 100);

    return map;
}

// Инициализация карты с расширенным функционалом
export function initMap(containerId, latitude, longitude, name) {
    const map = L.map(containerId).setView([latitude, longitude], 13);
    
    const baseMaps = {
        "CartoDB Positron": L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }),
        "CartoDB Dark Matter": L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }),
        "OpenStreetMap Standard": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        })
    };

    // Use saved map style or default
    const savedMapStyle = localStorage.getItem('mapStyle') || "CartoDB Positron";
    baseMaps[savedMapStyle].addTo(map);

    // Add layer control
    L.control.layers(baseMaps).addTo(map);

    // Add geocoder
    L.Control.geocoder({
        defaultMarkGeocode: false
    })
    .on('markgeocode', function(e) {
        const bbox = e.geocode.bbox;
        const poly = L.polygon([
            bbox.getSouthEast(),
            bbox.getNorthEast(),
            bbox.getNorthWest(),
            bbox.getSouthWest()
        ]).addTo(map);
        map.fitBounds(poly.getBounds());
    })
    .addTo(map);

    // Save selected map style
    map.on('baselayerchange', (e) => {
        localStorage.setItem('mapStyle', e.name);
    });

    // Add marker if coordinates are provided
    if (latitude && longitude) {
        L.marker([latitude, longitude])
            .addTo(map)
            .bindPopup(name);
    }

    // Add route button
    const routeControl = L.control({position: 'bottomright'});
    routeControl.onAdd = function() {
        const div = L.DomUtil.create('div', 'leaflet-control');
        div.innerHTML = `
            <a href="https://www.google.com/maps/dir/?api=1&destination=${latitude},${longitude}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                Построить маршрут
            </a>
        `;
        return div;
    };
    routeControl.addTo(map);

    // Fix display issues
    setTimeout(() => map.invalidateSize(), 100);

    return map;
}
