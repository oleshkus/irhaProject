<x-custom.header></x-custom.header>

<x-default-layout>
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <a href="{{ route('routes.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Маршруты</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">{{ $route->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Main Content -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Header -->
                <div class="relative h-96">
                    @if($route->image)
                        <div class="absolute inset-0">
                            <img src="{{ asset('storage/' . $route->image) }}" alt="{{ $route->name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-40"></div>
                        </div>
                    @endif
                    <div class="relative h-full flex items-end">
                        <div class="p-8">
                            <div class="flex items-center">
                                <h1 class="text-4xl font-bold text-white">{{ $route->name }}</h1>
                                <span class="ml-4 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $route->difficulty === 'easy' ? 'bg-green-100 text-green-800' : ($route->difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $route->difficulty }}
                                </span>
                            </div>
                            <div class="mt-4 flex items-center space-x-6 text-white">
                                <div class="flex items-center">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="ml-2">{{ $route->duration }} часов</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="ml-2">{{ $route->distance }} км</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-8 py-6">
                    <!-- Description -->
                    <div class="prose max-w-none">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Описание маршрута</h2>
                        {!! $route->description !!}
                    </div>

                    <!-- Attractions -->
                    @if($route->attractions && $route->attractions->count() > 0)
                        <div class="mt-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">Достопримечательности на маршруте</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($route->attractions as $attraction)
                                    <div class="relative rounded-lg overflow-hidden">
                                        @if($attraction->images->count() > 0)
                                            <img src="{{ Storage::url($attraction->images->first()->path) }}" alt="{{ $attraction->name }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent"></div>
                                        <div class="absolute bottom-0 left-0 p-4">
                                            <h3 class="text-lg font-medium text-white">{{ $attraction->name }}</h3>
                                        </div>
                                        <a href="{{ route('attractions.show', $attraction) }}" class="absolute inset-0" aria-label="View {{ $attraction->name }}"></a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Map -->
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Карта маршрута</h2>
                        <div class="h-96 bg-gray-200 rounded-lg">
                            <!-- Here you can add your map implementation -->
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route('routes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Назад к списку
                        </a>
                        
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <div class="flex space-x-4">
                                    <a href="{{ route('admin.routes.edit', $route) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Редактировать
                                    </a>
                                    <form action="{{ route('admin.routes.destroy', $route) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Вы уверены?')">
                                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-default-layout>