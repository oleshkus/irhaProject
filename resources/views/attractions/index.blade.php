@extends('layouts.app')
@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="max-w-7xl mx-auto">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Достопримечательности</h2>
                        <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                            <div class="mt-2 flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Все места
                            </div>
                        </div>
                    </div>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <div class="mt-4 flex md:mt-0 md:ml-4">
                                <a href="{{ route('admin.attractions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-6a2 2 0 00-2 2z" />
                                    </svg>
                                    Добавить
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white shadow rounded-lg mt-8 p-6">
                <form method="GET" action="{{ route('attractions.index') }}" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Поиск</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Применить
                        </button>
                    </div>
                </form>
            </div>

            <!-- Attractions Grid -->
            <div class="mt-8 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($attractions as $attraction)
                    <div class="flex flex-col rounded-lg shadow-lg overflow-hidden bg-white">
                        <div class="flex-shrink-0">
                            @if($attraction->images->count() > 0)
                                <img class="h-48 w-full object-cover" src="{{ Storage::url($attraction->images->first()->path) }}" alt="{{ $attraction->name }}">
                            @else
                                <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 p-6 flex flex-col justify-between">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    {{ $attraction->name }}
                                </h3>
                                <p class="mt-3 text-base text-gray-500">
                                    {{ Str::limit(strip_tags($attraction->description), 150) }}
                                </p>
                            </div>
                            <div class="mt-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-2 flex-1">
                                        <p class="text-sm text-gray-700">
                                            Беларусь, {{ $attraction->city }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $attraction->street }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('attractions.show', $attraction) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Подробнее
                                        <svg class="ml-2 -mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Нет достопримечательностей</h3>
                        <p class="mt-1 text-sm text-gray-500">Начните добавлять достопримечательности прямо сейчас.</p>
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <div class="mt-6">
                                    <a href="{{ route('admin.attractions.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-6a2 2 0 00-2 2z" />
                                        </svg>
                                        Добавить достопримечательность
                                    </a>
                                </div>
                            @endif
                        @endauth
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($attractions->hasPages())
                <div class="mt-8">
                    {{ $attractions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
