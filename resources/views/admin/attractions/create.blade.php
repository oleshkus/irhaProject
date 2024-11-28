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
                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Введите описание достопримечательности">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                    
                        </div>

                        <div>
                            <x-custom.forms.label for="address" class="text-gray-700 font-medium">Адрес</x-custom.forms.label>
                            <x-custom.forms.input 
                                type="text" 
                                name="address" 
                                id="address" 
                                :value="old('address')"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Введите адрес"
                            />
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-custom.forms.label for="country" class="text-gray-700 font-medium">Страна</x-custom.forms.label>
                                <x-custom.forms.input 
                                    type="text" 
                                    name="country" 
                                    id="country" 
                                    :value="old('country')"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Введите страну"
                                />
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-custom.forms.label for="city" class="text-gray-700 font-medium">Город</x-custom.forms.label>
                                <x-custom.forms.input 
                                    type="text" 
                                    name="city" 
                                    id="city" 
                                    :value="old('city')"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Введите город"
                                />
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-custom.forms.label for="street" class="text-gray-700 font-medium">Улица</x-custom.forms.label>
                                <x-custom.forms.input 
                                    type="text" 
                                    name="street" 
                                    id="street" 
                                    :value="old('street')"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Введите улицу"
                                />
                                @error('street')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-custom.forms.label for="latitude" class="text-gray-700 font-medium">Широта</x-custom.forms.label>
                                <x-custom.forms.input 
                                    type="number" 
                                    name="latitude" 
                                    id="latitude" 
                                    :value="old('latitude')"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Введите широту"
                                    step="any"
                                />
                                @error('latitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-custom.forms.label for="longitude" class="text-gray-700 font-medium">Долгота</x-custom.forms.label>
                                <x-custom.forms.input 
                                    type="number" 
                                    name="longitude" 
                                    id="longitude" 
                                    :value="old('longitude')"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Введите долготу"
                                    step="any"
                                />
                                @error('longitude')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
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
