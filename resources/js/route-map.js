// Здесь будет новая реализация карты

class RouteMap {
    constructor() {
        this.map = null;
        this.markers = [];
        this.routeLayer = null;
    }

    init() {
        this.map = L.map('map').setView([55.7558, 37.6173], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: ' OpenStreetMap contributors'
        }).addTo(this.map);

        this.addMarkers();
        this.buildRoute();
    }

    addMarkers() {
        this.markers = attractions.map((attraction, index) => {
            const icon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div class="marker-pin"><div>${index + 1}</div></div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });

            const marker = L.marker([attraction.lat, attraction.lng], { icon })
                .bindPopup(`<b>${attraction.name}</b><br>${attraction.address}`);

            marker.addTo(this.map);
            return marker;
        });

        if (this.markers.length > 0) {
            const bounds = L.latLngBounds(this.markers.map(marker => marker.getLatLng()));
            this.map.fitBounds(bounds, { padding: [50, 50] });
        }
    }

    async buildRoute() {
        if (this.markers.length < 2) return;
        if (this.routeLayer) {
            this.map.removeLayer(this.routeLayer);
        }

        const coordinates = this.markers.map(marker => marker.getLatLng());
        const waypoints = coordinates.map(coord => `${coord.lng},${coord.lat}`).join(';');
        
        try {
            const response = await fetch(`https://router.project-osrm.org/route/v1/driving/${waypoints}?overview=full&geometries=geojson`);
            const data = await response.json();

            if (data.code === 'Ok' && data.routes && data.routes[0]) {
                const routeCoordinates = data.routes[0].geometry.coordinates;
                const latLngs = routeCoordinates.map(coord => [coord[1], coord[0]]);

                this.routeLayer = L.polyline(latLngs, {
                    color: '#0ea5e9',
                    weight: 4,
                    opacity: 0.7
                }).addTo(this.map);
            }
        } catch (error) {
            console.error('Error building route:', error);
            // Fallback: draw direct lines between points
            this.routeLayer = L.polyline(coordinates, {
                color: '#0ea5e9',
                weight: 4,
                opacity: 0.7,
                dashArray: '10, 10'
            }).addTo(this.map);
        }
    }

    async buildRouteFromCurrentLocation() {
        if (!navigator.geolocation) {
            alert('Геолокация не поддерживается вашим браузером');
            return;
        }

        navigator.geolocation.getCurrentPosition(async (position) => {
            const currentLocation = L.latLng(position.coords.latitude, position.coords.longitude);
            
            if (this.routeLayer) {
                this.map.removeLayer(this.routeLayer);
            }

            // Add current location marker
            const currentLocationMarker = L.marker(currentLocation, {
                icon: L.divIcon({
                    className: 'custom-div-icon',
                    html: '<div class="marker-pin"><div>S</div></div>',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30]
                })
            }).addTo(this.map);

            // Build route from current location through all attractions
            const coordinates = [currentLocation, ...this.markers.map(marker => marker.getLatLng())];
            const waypoints = coordinates.map(coord => `${coord.lng},${coord.lat}`).join(';');

            try {
                const response = await fetch(`https://router.project-osrm.org/route/v1/driving/${waypoints}?overview=full&geometries=geojson`);
                const data = await response.json();

                if (data.code === 'Ok' && data.routes && data.routes[0]) {
                    const routeCoordinates = data.routes[0].geometry.coordinates;
                    const latLngs = routeCoordinates.map(coord => [coord[1], coord[0]]);

                    this.routeLayer = L.polyline(latLngs, {
                        color: '#0ea5e9',
                        weight: 4,
                        opacity: 0.7
                    }).addTo(this.map);

                    // Fit bounds to include current location and all attractions
                    const bounds = L.latLngBounds([currentLocation, ...this.markers.map(marker => marker.getLatLng())]);
                    this.map.fitBounds(bounds, { padding: [50, 50] });
                }
            } catch (error) {
                console.error('Error building route from current location:', error);
                // Fallback: draw direct lines
                this.routeLayer = L.polyline(coordinates, {
                    color: '#0ea5e9',
                    weight: 4,
                    opacity: 0.7,
                    dashArray: '10, 10'
                }).addTo(this.map);
            }
        }, (error) => {
            console.error('Error getting current location:', error);
            alert('Не удалось получить ваше текущее местоположение');
        }, {
            enableHighAccuracy: true,
            timeout: 5000,
            maximumAge: 0
        });
    }
}

// Initialize the map
const routeMap = new RouteMap();
window.addEventListener('load', () => routeMap.init());
