@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        .route-map {
            height: 400px;
            width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        }
        .leaflet-routing-container {
            display: none;
        }
    </style>
@endpush

<div x-data="routeMapComponent()" x-init="initRouteMap()">
    <div id="route-map" class="route-map"></div>
</div>

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://router.project-osrm.org/route/v1/driving/"></script>
    <script>
        function routeMapComponent() {
            return {
                map: null,
                markers: [],
                routingControl: null,
                routeLayer: null,
                tempLine: null,
                currentRoute: null,

                initRouteMap() {
                    // Initialize map centered on Grodno
                    this.map = L.map('route-map').setView([53.6834, 23.8342], 12);

                    // Setup tile layers
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

                    // Load saved map style or default
                    const savedMapStyle = localStorage.getItem('mapStyle') || "CartoDB Positron";
                    baseMaps[savedMapStyle].addTo(this.map);

                    // Add layer control
                    const layerControl = L.control.layers(baseMaps).addTo(this.map);
                    this.map.on('baselayerchange', (e) => {
                        localStorage.setItem('mapStyle', e.name);
                    });

                    // Initialize route layer
                    this.routeLayer = L.layerGroup().addTo(this.map);

                    // Make updateRouteMap available globally
                    window.updateRouteMap = this.updateRoute.bind(this);

                    // Initialize route for existing attractions
                    this.updateRoute();

                    // Add event listener for attraction changes
                    const observer = new MutationObserver(() => this.updateRoute());
                    observer.observe(document.getElementById('selected-attractions'), {
                        childList: true,
                        subtree: true,
                        attributes: true
                    });
                },

                async updateRoute() {
                    // Clear existing markers and route
                    this.markers.forEach(marker => this.map.removeLayer(marker));
                    this.markers = [];
                    
                    if (this.routingControl) {
                        this.map.removeControl(this.routingControl);
                        this.routingControl = null;
                    }
                    
                    if (this.tempLine) {
                        this.map.removeLayer(this.tempLine);
                        this.tempLine = null;
                    }

                    if (this.currentRoute) {
                        this.map.removeLayer(this.currentRoute);
                        this.currentRoute = null;
                    }
                    
                    if (this.routeLayer) {
                        this.routeLayer.clearLayers();
                    }

                    // Get all selected attractions
                    const attractions = Array.from(document.querySelectorAll('#selected-attractions [data-id]'));
                    if (attractions.length === 0) return;

                    // Create markers and collect waypoints
                    const waypoints = attractions.map(attraction => {
                        const lat = parseFloat(attraction.dataset.lat);
                        const lng = parseFloat(attraction.dataset.lng);
                        const name = attraction.querySelector('.text-gray-900').textContent;

                        console.log('Adding marker at:', lat, lng, name);

                        // Add marker
                        const marker = L.marker([lat, lng], {
                            title: name
                        }).bindPopup(name).addTo(this.map);
                        this.markers.push(marker);

                        return L.latLng(lat, lng);
                    });

                    // Fit map to show all points
                    if (waypoints.length > 0) {
                        const bounds = L.latLngBounds(waypoints);
                        this.map.fitBounds(bounds, { padding: [50, 50] });
                    }

                    // Only create route if we have 2 or more points
                    if (waypoints.length >= 2) {
                        console.log('Creating route between points:', waypoints);

                        try {
                            // Create temporary straight line
                            this.tempLine = L.polyline(waypoints, {
                                color: '#3B82F6',
                                weight: 3,
                                opacity: 0.5,
                                dashArray: '10, 10'
                            }).addTo(this.map);

                            // Create OSRM URL
                            const coordinates = waypoints.map(wp => `${wp.lng},${wp.lat}`).join(';');
                            const url = `https://router.project-osrm.org/route/v1/driving/${coordinates}?overview=full&geometries=polyline`;

                            // Fetch route from OSRM
                            const response = await fetch(url);
                            const data = await response.json();

                            if (data.code === 'Ok' && data.routes && data.routes.length > 0) {
                                // Decode the polyline
                                const route = data.routes[0];
                                const coordinates = this.decodePolyline(route.geometry);

                                // Remove temporary line
                                if (this.tempLine) {
                                    this.map.removeLayer(this.tempLine);
                                    this.tempLine = null;
                                }

                                // Remove previous route if exists
                                if (this.currentRoute) {
                                    this.map.removeLayer(this.currentRoute);
                                }

                                // Create the route line
                                this.currentRoute = L.polyline(coordinates, {
                                    color: '#3B82F6',
                                    weight: 6,
                                    opacity: 0.8
                                }).addTo(this.map);
                            }

                        } catch (error) {
                            console.error('Error creating route:', error);
                        }
                    }
                },

                // Polyline decoder
                decodePolyline(str, precision = 5) {
                    let index = 0,
                        lat = 0,
                        lng = 0,
                        coordinates = [],
                        shift = 0,
                        result = 0,
                        byte = null,
                        latitude_change,
                        longitude_change,
                        factor = Math.pow(10, precision);

                    // Coordinates have variable length when encoded, so just keep
                    // track of whether we've hit the end of the string. In each
                    // loop iteration, a single coordinate is decoded.
                    while (index < str.length) {
                        // Reset shift, result, and byte
                        byte = null;
                        shift = 0;
                        result = 0;

                        do {
                            byte = str.charCodeAt(index++) - 63;
                            result |= (byte & 0x1f) << shift;
                            shift += 5;
                        } while (byte >= 0x20);

                        latitude_change = ((result & 1) ? ~(result >> 1) : (result >> 1));

                        shift = result = 0;

                        do {
                            byte = str.charCodeAt(index++) - 63;
                            result |= (byte & 0x1f) << shift;
                            shift += 5;
                        } while (byte >= 0x20);

                        longitude_change = ((result & 1) ? ~(result >> 1) : (result >> 1));

                        lat += latitude_change;
                        lng += longitude_change;

                        coordinates.push([lat / factor, lng / factor]);
                    }

                    return coordinates;
                }
            }
        }
    </script>
@endpush
