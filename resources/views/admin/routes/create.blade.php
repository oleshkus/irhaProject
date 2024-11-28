<x-app-layout>
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
                                        <input type="checkbox" name="attractions[]" value="{{ $attraction->id }}"
                                               class="mt-1 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                               {{ in_array($attraction->id, old('attractions', [])) ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <div class="font-medium">{{ $attraction->name }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($attraction->description, 100) }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('attractions')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <x-custom.buttons.button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600">
                                Добавить
                            </x-custom.buttons.button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
