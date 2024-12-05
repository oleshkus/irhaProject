@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-custom.breadcrumbs 
                        title="Создание достопримечательности"
                        :backRoute="route('admin.attractions.index')" 
                    />
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <form action="{{ route('admin.attractions.store') }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="p-8">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Название -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Название</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           required 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                           value="{{ old('name') }}">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <hr>

                                <!-- Описание -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                                    <x-quill-editor id="description" name="description" :value="old('description')" />
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <hr>

                                <!-- Загрузка изображений -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Изображения</label>
                                    <x-custom.forms.file-upload name="images[]" multiple accept="image/*" />
                                    <p class="mt-1 text-sm text-gray-500">
                                        Поддерживаются форматы: JPG, PNG, GIF. Максимальный размер: 2MB.
                                    </p>
                                    @error('images')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @error('images.*')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <hr>

                                <!-- Координаты и адрес -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-4">Расположение на карте</label>
                                    <div id="map" class="h-96 w-full rounded-lg border border-gray-300 mb-4"></div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                        <div>
                                            <label for="latitude" class="block text-sm font-medium text-gray-700">Широта</label>
                                            <input type="text" 
                                                   name="latitude" 
                                                   id="latitude" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                   value="{{ old('latitude', 53.6834) }}"
                                                   readonly>
                                        </div>
                                        <div>
                                            <label for="longitude" class="block text-sm font-medium text-gray-700">Долгота</label>
                                            <input type="text" 
                                                   name="longitude" 
                                                   id="longitude" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                   value="{{ old('longitude', 23.8342) }}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                        <div>
                                            <label for="country" class="block text-sm font-medium text-gray-700">Страна</label>
                                            <input type="text" 
                                                   name="country" 
                                                   id="country" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                   value="{{ old('country', 'Беларусь') }}"
                                                   readonly>
                                        </div>
                                        <div>
                                            <label for="city" class="block text-sm font-medium text-gray-700">Город</label>
                                            <input type="text" 
                                                   name="city" 
                                                   id="city" 
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                                   value="{{ old('city', 'Гродно') }}"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="street" class="block text-sm font-medium text-gray-700">Улица</label>
                                        <input type="text" 
                                               name="street" 
                                               id="street" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                               value="{{ old('street') }}"
                                               readonly>
                                    </div>

                                    <div class="mt-4">
                                        <label for="address" class="block text-sm font-medium text-gray-700">Полный адрес</label>
                                        <input type="text" 
                                               name="address" 
                                               id="address" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                               value="{{ old('address') }}"
                                               readonly>
                                    </div>
                                </div>

                                <!-- Кнопки -->
                                <div class="flex justify-end space-x-4 pt-4">
                                    <a href="{{ route('admin.attractions.index') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Отмена
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Создать
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const map = L.map('map').setView([53.6834, 23.8342], 13);
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                let marker = L.marker([53.6834, 23.8342], {
                    draggable: true
                }).addTo(map);

                const geocoder = L.Control.geocoder({
                    defaultMarkGeocode: false,
                    placeholder: 'Поиск адреса...',
                    geocoder: L.Control.Geocoder.nominatim({
                        geocodingQueryParams: {
                            countrycodes: 'by',
                            'accept-language': 'ru'
                        }
                    })
                }).addTo(map);

                function updateFields(latlng) {
                    document.getElementById('latitude').value = latlng.lat.toFixed(6);
                    document.getElementById('longitude').value = latlng.lng.toFixed(6);

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latlng.lat}&lon=${latlng.lng}&accept-language=ru`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.address) {
                                document.getElementById('country').value = data.address.country || '';
                                document.getElementById('city').value = data.address.city || data.address.town || '';
                                document.getElementById('street').value = data.address.road || '';
                                document.getElementById('address').value = data.display_name || '';
                            }
                        });
                }

                marker.on('dragend', function(e) {
                    updateFields(marker.getLatLng());
                });

                map.on('click', function(e) {
                    marker.setLatLng(e.latlng);
                    updateFields(e.latlng);
                });

                geocoder.on('markgeocode', function(e) {
                    const latlng = e.geocode.center;
                    marker.setLatLng(latlng);
                    map.setView(latlng, 16);
                    updateFields(latlng);
                });
            });
        </script>
    @endpush
@endsection
