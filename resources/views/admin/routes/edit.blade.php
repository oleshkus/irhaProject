@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-custom.breadcrumbs 
                        title="Редактирование маршрута"
                        :backRoute="route('admin.routes.index')" 
                    />
                    
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <form action="{{ route('admin.routes.update', $route) }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="p-8">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-6">
                                <!-- Название маршрута -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Название маршрута</label>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           required 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                           value="{{ old('name', $route->name) }}">
                                </div>
                                <hr>
                                <!-- Описание маршрута -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Описание маршрута</label>
                                    <x-quill-editor id="description" name="description" :value="old('description', $route->description)" />
                                </div>
                                <hr>
                                <!-- Загрузка изображений -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Изображения маршрута</label>
                                    <x-custom.forms.file-upload name="images[]" multiple />
                                    <p class="mt-1 text-sm text-gray-500">
                                        Поддерживаются форматы: JPG, PNG, GIF. Максимальный размер: 2MB.
                                    </p>
                                </div>
                                <hr>
                                <!-- Поиск достопримечательностей -->
                                <div>
                                    <label for="searchAttractions" class="block text-sm font-medium text-gray-700">Поиск достопримечательностей</label>
                                    <input type="text" 
                                           id="searchAttractions" 
                                           placeholder="Введите название или адрес" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <!-- Список достопримечательностей -->
                                <div>
                                    <div class="overflow-x-auto ring-1 ring-gray-300 rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Название</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Адрес</th>
                                                    <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Действия</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                @foreach($attractions as $attraction)
                                                <tr>
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                                        {{ $attraction->name }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                        {{ $attraction->address }}
                                                    </td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                                        <button type="button" 
                                                                onclick="addAttraction({ 
                                                                    id: {{ $attraction->id }}, 
                                                                    name: '{{ $attraction->name }}', 
                                                                    address: '{{ $attraction->address }}' 
                                                                })" 
                                                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                            Добавить
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Список выбранных достопримечательностей -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Выбранные достопримечательности</h3>
                                    <div id="selected-attractions" class="space-y-3">
                                        @foreach($route->attractions as $attraction)
                                            <div class="flex items-center justify-between p-4 bg-white shadow rounded-lg border border-gray-200" data-id="{{ $attraction->id }}">
                                                <div class="flex items-center flex-1">
                                                    <div class="handle cursor-move mr-4">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900">{{ $attraction->name }}</p>
                                                        <p class="text-sm text-gray-500">{{ $attraction->address }}</p>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="attractions[]" value="{{ $attraction->id }}">
                                                <button type="button" 
                                                        onclick="this.closest('[data-id]').remove()" 
                                                        class="ml-4 text-gray-400 hover:text-red-500 focus:outline-none">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="pt-5">
                                    <div class="flex justify-end">
                                        <a href="{{ route('admin.routes.index') }}" 
                                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Отмена
                                        </a>
                                        <button type="submit" 
                                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Сохранить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectedAttractions = document.getElementById('selected-attractions');
            new Sortable(selectedAttractions, {
                animation: 150,
                handle: '.handle',
                onEnd: updateOrder
            });

            document.getElementById('searchAttractions').addEventListener('input', searchAttractions);
        });

        function searchAttractions() {
            const searchText = document.getElementById('searchAttractions').value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('td:first-child').textContent.toLowerCase();
                const address = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                
                if (name.includes(searchText) || address.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function addAttraction(attraction) {
            const container = document.getElementById('selected-attractions');
            const existingItem = container.querySelector(`[data-id="${attraction.id}"]`);
            
            if (existingItem) {
                alert('Эта достопримечательность уже добавлена в маршрут');
                return;
            }

            const item = document.createElement('div');
            item.className = 'flex items-center justify-between p-4 bg-white shadow rounded-lg border border-gray-200';
            item.dataset.id = attraction.id;
            
            item.innerHTML = `
                <div class="flex items-center flex-1">
                    <div class="handle cursor-move mr-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">${attraction.name}</p>
                        <p class="text-sm text-gray-500">${attraction.address}</p>
                    </div>
                </div>
                <input type="hidden" name="attractions[]" value="${attraction.id}">
                <button type="button" 
                        onclick="this.closest('[data-id]').remove()" 
                        class="ml-4 text-gray-400 hover:text-red-500 focus:outline-none">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            `;

            container.appendChild(item);
            updateOrder();
        }

        function updateOrder() {
            const attractions = document.querySelectorAll('#selected-attractions [data-id]');
            attractions.forEach((attraction, index) => {
                const hiddenInput = attraction.querySelector('input[name="attractions[]"]');
                hiddenInput.setAttribute('name', `attractions[${index}]`);
            });
        }
    </script>
@endsection
