@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-custom.nav-breadcrumbs :items="[
            ['name' => 'Маршруты', 'url' => route('routes.index')],
            ['name' => $route->name]
        ]" />
        
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <!-- Header with Image -->
            <div class="relative h-96">
                @if($route->images->count() > 0)
                    <img src="{{ Storage::url($route->images->first()->path) }}" alt="{{ $route->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <svg class="h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <h1 class="text-4xl font-bold text-white mb-2">{{ $route->name }}</h1>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <!-- Description -->
                <div class="prose prose-lg max-w-none mb-12">
                    {!! $route->description !!}
                </div>

                <!-- Attractions -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Достопримечательности на маршруте</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($route->getOrderedAttractions() as $index => $attraction)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow border border-gray-100">
                                <div class="aspect-w-16 aspect-h-9">
                                    @if($attraction->images->count() > 0)
                                        <img src="{{ Storage::url($attraction->images->first()->path) }}" 
                                             alt="{{ $attraction->name }}" 
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                            <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-medium">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-medium text-gray-900 truncate">{{ $attraction->name }}</h3>
                                            <p class="mt-1 text-sm text-gray-500">{{ $attraction->address }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-4 flex justify-end">
                                        <a href="{{ route('attractions.show', $attraction) }}" 
                                           class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                                            Подробнее
                                            <svg class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection