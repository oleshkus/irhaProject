@extends('layouts.app')

@section('content')
    <x-custom.header />

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
                            <x-custom.forms.label for="images">Изображения</x-custom.forms.label>
                            <x-custom.forms.file-upload name="images[]" id="images" multiple accept="image/*" />
                            <p class="mt-1 text-sm text-gray-500">
                                Поддерживаются форматы: JPG, PNG, GIF. Максимальный размер: 2MB.
                            </p>
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.attractions.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                Отмена
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Создать
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
