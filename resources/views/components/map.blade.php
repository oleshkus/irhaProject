<div x-data="mapComponent()" x-init="initMap()">
    <div id="map" class="w-full h-96 rounded-lg shadow-md"></div>
    <div class="mt-2 text-sm text-gray-500" x-show="error" x-text="error"></div>
</div>

<script>
    function mapComponent() {
        return {
            map: null,
            marker: null,
            error: '',
            geocoder: null,

            async initMap() {
                try {
                    // Initialize map
                    this.map = L.map('map').setView([51.505, -0.09], 13);

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

                    // Initialize marker
                    this.marker = L.marker([51.505, -0.09]).addTo(this.map);

                    // Try to get user location
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                const userLocation = [position.coords.latitude, position.coords.longitude];
                                this.map.setView(userLocation, 13);
                                this.marker.setLatLng(userLocation);
                                this.updateLocationFields(userLocation[0], userLocation[1]);
                            },
                            () => {
                                this.error = "Не удалось получить ваше местоположение.";
                            }
                        );
                    }

                    // Add geocoder control
                    this.geocoder = L.Control.geocoder({
                        defaultMarkGeocode: false
                    }).on('markgeocode', (e) => {
                        const center = e.geocode.center;
                        this.map.setView(center, 16);
                        this.marker.setLatLng(center);
                        this.updateLocationFields(center.lat, center.lng);
                    }).addTo(this.map);

                    // Handle map clicks
                    this.map.on('click', async (e) => {
                        this.marker.setLatLng(e.latlng);
                        await this.updateLocationFields(e.latlng.lat, e.latlng.lng);
                    });

                } catch (error) {
                    console.error('Error initializing map:', error);
                    this.error = "Произошла ошибка при инициализации карты.";
                }
            },

            async updateLocationFields(lat, lng) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const data = await response.json();
                    
                    // Update form fields
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    document.getElementById('address').value = data.display_name;
                    document.getElementById('country').value = data.address.country || '';
                    document.getElementById('city').value = data.address.city || data.address.town || data.address.village || '';
                    document.getElementById('street').value = data.address.road || '';
                    
                    this.error = ''; // Clear any previous errors
                } catch (error) {
                    console.error('Error updating location fields:', error);
                    this.error = "Не удалось получить информацию об адресе.";
                }
            }
        }
    }
</script>
