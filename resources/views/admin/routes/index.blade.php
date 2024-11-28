<x-app-layout>
    <x-custom.header />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Маршруты</h2>
                        <x-custom.buttons.button href="{{ route('admin.routes.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600">
                            Добавить
                        </x-custom.buttons.button>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <x-custom.tables.table>
                            <x-slot name="header">
                                <x-custom.tables.header-cell>ID</x-custom.tables.header-cell>
                                <x-custom.tables.header-cell>Название</x-custom.tables.header-cell>
                                <x-custom.tables.header-cell>Описание</x-custom.tables.header-cell>
                                <x-custom.tables.header-cell>Достопримечательности</x-custom.tables.header-cell>
                                <x-custom.tables.header-cell>Действия</x-custom.tables.header-cell>
                            </x-slot>

                            @foreach($routes as $route)
                                <tr>
                                    <x-custom.tables.cell>{{ $route->id }}</x-custom.tables.cell>
                                    <x-custom.tables.cell>{{ $route->name }}</x-custom.tables.cell>
                                    <x-custom.tables.cell>{{ Str::limit($route->description, 100) }}</x-custom.tables.cell>
                                    <x-custom.tables.cell>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($route->attractions as $attraction)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $attraction->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </x-custom.tables.cell>
                                    <x-custom.tables.cell>
                                        <div class="flex space-x-2">
                                            <x-custom.buttons.button href="{{ route('admin.routes.edit', $route) }}" class="bg-gradient-to-r from-yellow-400 to-yellow-500">
                                                Изменить
                                            </x-custom.buttons.button>
                                            
                                            <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-custom.buttons.button type="submit" class="bg-gradient-to-r from-red-500 to-red-600" 
                                                    onclick="return confirm('Вы уверены?')">
                                                    Удалить
                                                </x-custom.buttons.button>
                                            </form>
                                        </div>
                                    </x-custom.tables.cell>
                                </tr>
                            @endforeach
                        </x-custom.tables.table>
                    </div>

                    <div class="mt-4">
                        {{ $routes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
