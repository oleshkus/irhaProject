@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <x-custom.nav-breadcrumbs :items="[
                ['name' => 'Достопримечательности', 'url' => route('attractions.index')],
                ['name' => $attraction->name]
            ]" />
            <!-- Main Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Header -->
                <div class="relative h-96">
                    @if($attraction->images->count() > 0)
                        <div class="absolute inset-0">
                            <img src="{{ Storage::url($attraction->images->first()->path) }}" alt="{{ $attraction->name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                        </div>
                    @endif
                    <div class="relative h-full flex items-end">
                        <div class="p-8">
                            <h1 class="text-4xl font-bold text-white">{{ $attraction->name }}</h1>
                            <div class="mt-4">
                                <div class="flex items-center text-white">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="font-medium">Местоположение:</span>
                                        <span class="text-sm opacity-70">{{ $attraction->address }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-8 py-6">
                    <!-- Description -->
                    <div class="mt-8 px-4 sm:px-6">
                        <div class="prose max-w-none">
                            {!! $attraction->description !!}
                        </div>
                    </div>

                    <!-- Gallery -->
                    @if($attraction->images->count() > 1)
                        <div class="mt-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Галерея</h2>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($attraction->images->skip(1) as $image)
                                    <div class="relative aspect-w-3 aspect-h-2 cursor-pointer" onclick="openImageModal('{{ Storage::url($image->path) }}')">
                                        <img src="{{ Storage::url($image->path) }}" alt="{{ $attraction->name }}" class="object-cover rounded-lg hover:opacity-90 transition-opacity">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Modal для просмотра фотографий -->
                    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4" onclick="closeImageModal()">
                        <div class="max-w-7xl max-h-[90vh] relative" onclick="event.stopPropagation()">
                            <img id="modalImage" src="" alt="" class="max-h-[90vh] max-w-full object-contain rounded-lg">
                            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Map -->
                    <div class="mt-8 relative z-0">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Расположение</h2>
                        <div id="attraction-map" class="relative" style="height: 400px;"></div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var map = L.map('attraction-map', {
                                    center: [{{ $attraction->latitude }}, {{ $attraction->longitude }}],
                                    zoom: 17,
                                    maxZoom: 22
                                });

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
                                }).addTo(map);

                                L.marker([{{ $attraction->latitude }}, {{ $attraction->longitude }}]).addTo(map);
                            });
                        </script>
                    </div>
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-2xl font-bold leading-6 text-gray-900">{{ $attraction->name }}</h3>
                        <div class="mt-4 flex items-center space-x-4">
                            <div class="flex items-center text-gray-700">
                                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">Беларусь, {{ $attraction->city }}</p>
                                    <p class="text-sm text-gray-500">{{ $attraction->street }}</p>
                                </div>
                            </div>
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $attraction->latitude }},{{ $attraction->longitude }}" 
                            target="_blank" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                Построить маршрут
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Закрытие по клавише Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection