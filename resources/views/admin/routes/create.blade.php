@extends('layouts.app')

@section('content')
    <x-custom.header />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Добавить маршрут</h2>
                        <x-custom.buttons.button href="{{ route('admin.routes.index') }}" class="bg-gray-500 hover:bg-gray-600">
                            Назад к списку
                        </x-custom.buttons.button>
                    </div>

                    <form action="{{ route('admin.routes.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-custom.forms.label for="name">Название маршрута</x-custom.forms.label>
                            <x-custom.forms.input type="text" id="name" name="name" :value="old('name')" required />
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-custom.forms.label for="description">Описание маршрута</x-custom.forms.label>
                            <x-quill-editor 
                                name="description" 
                                :value="old('description')" 
                                placeholder="Расскажите подробнее о маршруте..."
                                height="400px"
                            />
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-custom.forms.label for="attractions">Достопримечательности</x-custom.forms.label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($attractions as $attraction)
                                    <label class="flex items-start p-4 border rounded-lg hover:bg-gray-50">
                                        <input type="checkbox" name="attractions[]" value="{{ $attraction->id }}" class="form-checkbox h-5 w-5 text-blue-600" {{ in_array($attraction->id, old('attractions', [])) ? 'checked' : '' }}>
                                        <span class="ml-3 text-sm text-gray-700">{{ $attraction->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('attractions')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.routes.index') }}"
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
