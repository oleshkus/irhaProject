<x-custom.header></x-custom.header>

<x-default-layout>
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <a href="{{ route('attractions.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Достопримечательности</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">{{ $attraction->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Header -->
                <div class="relative h-96">
                    @if($attraction->images->count() > 0)
                        <div class="absolute inset-0">
                            <img src="{{ Storage::url($attraction->images->first()->path) }}" alt="{{ $attraction->name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-40"></div>
                        </div>
                    @endif
                    <div class="relative h-full flex items-end">
                        <div class="p-8">
                            <h1 class="text-4xl font-bold text-white">{{ $attraction->name }}</h1>
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <span class="text-gray-600 mr-2">Местоположение:</span>
                                    <span class="text-gray-900">{{ $attraction->location }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-8 py-6">
                    <!-- Description -->
                    <div class="prose max-w-none">
                        {!! $attraction->description !!}
                    </div>

                    <!-- Gallery -->
                    @if($attraction->images->count() > 1)
                        <div class="mt-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Галерея</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($attraction->images->skip(1) as $image)
                                    <div class="relative aspect-w-3 aspect-h-2">
                                        <img src="{{ Storage::url($image->path) }}" alt="{{ $attraction->name }}" class="object-cover rounded-lg">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Map -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Расположение</h2>
                        <div id="attraction-map" style="height: 400px;"></div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var map = L.map('attraction-map', {
                                    center: [{{ $attraction->latitude }}, {{ $attraction->longitude }}],
                                    zoom: 18,
                                    maxZoom: 19
                                });

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
                                }).addTo(map);

                                L.marker([{{ $attraction->latitude }}, {{ $attraction->longitude }}]).addTo(map);
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>