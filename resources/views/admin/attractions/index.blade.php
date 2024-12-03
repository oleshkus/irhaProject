@extends('layouts.app')

@section('content')
    <x-custom.header />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-semibold">Достопримечательности</h2>
                        <x-custom.buttons.button href="{{ route('admin.attractions.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600">
                            Добавить
                        </x-custom.buttons.button>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">ID</th>
                                    <th scope="col" class="py-3 px-6">Название</th>
                                    <th scope="col" class="py-3 px-6">Описание</th>
                                    <th scope="col" class="py-3 px-6">Адрес</th>
                                    <th scope="col" class="py-3 px-6">Изображение</th>
                                    <th scope="col" class="py-3 px-6">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attractions as $attraction)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $attraction->id }}
                                        </td>
                                        <td class="py-4 px-6 font-medium text-gray-900">
                                            {{ $attraction->name }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="max-w-xs overflow-hidden">
                                                {{ Str::limit($attraction->description, 100) }}
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="text-sm">
                                                <p class="text-gray-900">Беларусь, {{ $attraction->city }}</p>
                                                <p class="text-gray-500">{{ $attraction->street }}</p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if($attraction->images->count() > 0)
                                                <img src="{{ Storage::url($attraction->images->first()->path) }}" 
                                                     alt="{{ $attraction->name }}" 
                                                     class="h-16 w-16 object-cover rounded-lg">
                                            @else
                                                <span class="text-gray-400">Нет изображения</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.attractions.edit', $attraction) }}" 
                                                   class="font-medium text-blue-600 hover:text-blue-900">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.attractions.destroy', $attraction) }}" 
                                                      method="POST" 
                                                      class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="font-medium text-red-600 hover:text-red-900"
                                                            onclick="return confirm('Вы уверены, что хотите удалить эту достопримечательность?')">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $attractions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
