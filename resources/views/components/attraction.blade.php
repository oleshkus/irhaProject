@props(['attractions' => \App\Models\Attraction::latest()->take(3)->get()])

<div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
    @foreach($attractions as $attraction)
        <div class="relative group">
            <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                @if($attraction->images->count() > 0)
                    <img src="{{ Storage::url($attraction->images->first()->path) }}" 
                         alt="{{ $attraction->name }}" 
                         class="w-full h-full object-center object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="mt-4 space-y-2">
                <h3 class="text-sm font-medium text-gray-900">
                    <a href="{{ route('attractions.show', $attraction) }}">
                        <span class="absolute inset-0"></span>
                        {{ $attraction->name }}
                    </a>
                </h3>
                <p class="text-sm text-gray-500">{{ strip_tags(Str::limit($attraction->description, 100)) }}</p>
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div class="flex flex-col">
                        <span>{{ $attraction->formatted_address['location'] }}</span>
                        <span>{{ $attraction->formatted_address['street'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if($attractions->isEmpty())
    <div class="text-center py-12">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Добавить достопримечательность
                    </a>
                </div>
            @endif
        @endauth
    </div>
@endif
