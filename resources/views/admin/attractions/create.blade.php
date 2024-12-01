<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Создание достопримечательности
                        </h2>
                        <a href="{{ route('admin.attractions.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Назад к списку
                        </a>
                    </div>

                    <form action="{{ route('admin.attractions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-custom.forms.label for="name" class="text-gray-700 font-medium">Название</x-custom.forms.label>
                            <x-custom.forms.input 
                                type="text" 
                                name="name" 
                                id="name" 
                                :value="old('name')"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Введите название достопримечательности"
                            />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-custom.forms.label for="description" class="text-gray-700 font-medium">Описание</x-custom.forms.label>
                            <x-quill-editor 
                                name="description" 
                                :value="old('description')" 
                                placeholder="Введите описание..."
                                height="400px"
                            />
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-custom.forms.label for="map">Карта</x-custom.forms.label>
                            <x-map />
                        </div>

                        <div>
                            <x-custom.forms.label for="address">Адрес</x-custom.forms.label>
                            <x-custom.forms.input type="text" id="address" name="address" :value="old('address')" />
                        </div>

                        <div>
                            <x-custom.forms.label for="country">Страна</x-custom.forms.label>
                            <x-custom.forms.input type="text" id="country" name="country" :value="old('country')" />
                        </div>

                        <div>
                            <x-custom.forms.label for="city">Город</x-custom.forms.label>
                            <x-custom.forms.input type="text" id="city" name="city" :value="old('city')" />
                        </div>

                        <div>
                            <x-custom.forms.label for="street">Улица</x-custom.forms.label>
                            <x-custom.forms.input type="text" id="street" name="street" :value="old('street')" />
                        </div>

                        <div>
                            <x-custom.forms.label for="latitude">Широта</x-custom.forms.label>
                            <x-custom.forms.input type="text" id="latitude" name="latitude" :value="old('latitude')" readonly="readonly" />
                        </div>

                        <div>
                            <x-custom.forms.label for="longitude">Долгота</x-custom.forms.label>
                            <x-custom.forms.input type="text" id="longitude" name="longitude" :value="old('longitude')" readonly="readonly" />
                        </div>

                        <div>
                            <x-custom.forms.label for="images" class="text-gray-700 font-medium">Изображения</x-custom.forms.label>
                            <input
                                type="file"
                                name="images[]"
                                id="images"
                                multiple
                                class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100"
                            />
                            @error('images')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.attractions.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                Отмена
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                Создать достопримечательность
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var latitudeField = document.getElementById('latitude');
        var longitudeField = document.getElementById('longitude');

        var latitude = parseFloat(latitudeField.value) || 51.505;
        var longitude = parseFloat(longitudeField.value) || -0.09;

        var map = L.map('map').setView([latitude, longitude], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([latitude, longitude]).addTo(map);

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            latitudeField.value = e.latlng.lat;
            longitudeField.value = e.latlng.lng;
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();
            // Add your form submission logic here
        });
    });
</script>
