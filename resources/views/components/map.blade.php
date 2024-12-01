<div id="map"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([51.505, -0.09], 13);

        var baseMaps = {
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
            }),
        };

        var savedMapStyle = localStorage.getItem('mapStyle') || "CartoDB Positron";
        baseMaps[savedMapStyle].addTo(map);

        var layerControl = L.control.layers(baseMaps).addTo(map);
        map.on('baselayerchange', function(e) {
            localStorage.setItem('mapStyle', e.name);
        });

        var marker = L.marker([51.505, -0.09]).addTo(map);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLocation = [position.coords.latitude, position.coords.longitude];
                map.setView(userLocation, 13);
                marker.setLatLng(userLocation);
            }, function() {
                console.error("Geolocation failed or is not supported.");
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
        }

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('latitude').value = e.latlng.lat;
                    document.getElementById('longitude').value = e.latlng.lng;
                    document.getElementById('address').value = data.display_name;
                    document.getElementById('country').value = data.address.country;
                    document.getElementById('city').value = data.address.city || data.address.town || data.address.village;
                    document.getElementById('street').value = data.address.road || '';
                });
        });

        var geocoder = L.Control.geocoder({
            defaultMarkGeocode: false
        }).on('markgeocode', function(e) {
            map.setView(e.geocode.center, 16);
            marker.setLatLng(e.geocode.center);
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${e.geocode.center.lat}&lon=${e.geocode.center.lng}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('latitude').value = e.geocode.center.lat;
                    document.getElementById('longitude').value = e.geocode.center.lng;
                    document.getElementById('address').value = data.display_name;
                    document.getElementById('country').value = data.address.country;
                    document.getElementById('city').value = data.address.city || data.address.town || data.address.village;
                    document.getElementById('street').value = data.address.road || '';
                });
        }).addTo(map);
    });
</script>
