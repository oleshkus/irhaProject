@props(['items'])

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

        @foreach($items as $item)
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                    </svg>
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ $item['name'] }}</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
