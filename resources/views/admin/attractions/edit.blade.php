@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-800">
                            Редактирование достопримечательности
                        </h2>
                        <a href="{{ route('admin.attractions.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Назад к списку
                        </a>
                    </div>

                    <form action="{{ route('admin.attractions.update', $attraction) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Левая колонка -->
                            <div class="space-y-6">
                                <!-- Название -->
                                <div>
                                    <x-custom.forms.label for="name" class="text-gray-700 font-medium">Название</x-custom.forms.label>
                                    <x-custom.forms.input 
                                        type="text" 
                                        name="name" 
                                        id="name" 
                                        :value="old('name', $attraction->name)"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Введите название достопримечательности"
                                    />
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Адрес -->
                                <div>
                                    <x-custom.forms.label for="address" class="text-gray-700 font-medium">Адрес</x-custom.forms.label>
                                    <x-custom.forms.input 
                                        type="text" 
                                        name="address" 
                                        id="address" 
                                        :value="old('address', $attraction->address)"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Укажите адрес"
                                    />
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Изображения -->
                                <div>
                                    <x-custom.forms.label class="text-gray-700 font-medium mb-2">Текущие изображения</x-custom.forms.label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                        @foreach($attraction->images as $image)
                                            <div class="relative group" data-image-id="{{ $image->id }}">
                                                <img src="{{ Storage::url($image->path) }}" 
                                                     alt="Изображение {{ $loop->iteration }}"
                                                     class="w-full h-32 object-cover rounded-lg">
                                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                                    <button type="button" 
                                                            onclick="deleteImage({{ $image->id }})"
                                                            class="text-white hover:text-red-500 transition-colors duration-200">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-4">
                                        <x-custom.forms.label for="images" class="text-gray-700 font-medium">Добавить новые изображения</x-custom.forms.label>
                                        <input type="file" 
                                               name="images[]" 
                                               id="images" 
                                               multiple 
                                               accept="image/*"
                                               class="mt-1 block w-full text-sm text-gray-500
                                                      file:mr-4 file:py-2 file:px-4
                                                      file:rounded-md file:border-0
                                                      file:text-sm file:font-semibold
                                                      file:bg-blue-50 file:text-blue-700
                                                      hover:file:bg-blue-100">
                                        @error('images.*')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Правая колонка -->
                            <div class="space-y-6">
                                <!-- Описание -->
                                <div>
                                    <x-custom.forms.label for="description" class="text-gray-700 font-medium">Описание</x-custom.forms.label>
                                    <x-quill-editor 
                                        name="description" 
                                        :value="old('description', $attraction->description)" 
                                        placeholder="Расскажите подробнее о достопримечательности..."
                                        class="mt-1"
                                        height="400px"
                                    />
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Координаты -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-custom.forms.label for="latitude" class="text-gray-700 font-medium">Широта</x-custom.forms.label>
                                        <x-custom.forms.input 
                                            type="text" 
                                            name="latitude" 
                                            id="latitude" 
                                            :value="old('latitude', $attraction->latitude)"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Например: 55.7558"
                                        />
                                        @error('latitude')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <x-custom.forms.label for="longitude" class="text-gray-700 font-medium">Долгота</x-custom.forms.label>
                                        <x-custom.forms.input 
                                            type="text" 
                                            name="longitude" 
                                            id="longitude" 
                                            :value="old('longitude', $attraction->longitude)"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Например: 37.6173"
                                        />
                                        @error('longitude')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Кнопки управления -->
                        <div class="flex justify-end space-x-4 mt-8">
                            <button type="button" 
                                    onclick="window.location.href='{{ route('admin.attractions.index') }}'"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                Отмена
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function deleteImage(imageId) {
            if (confirm('Вы уверены, что хотите удалить это изображение?')) {
                fetch(`{{ route('admin.attractions.deleteImage', '') }}/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Ошибка сети');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Находим и удаляем элемент изображения из DOM
                        const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
                        if (imageElement) {
                            imageElement.remove();
                        }
                    } else {
                        throw new Error('Ошибка при удалении');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка при удалении изображения: ' + error.message);
                });
            }
        }
    </script>
    @endpush
@endsection