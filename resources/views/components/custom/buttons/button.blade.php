<!-- resources/views/components/button.blade.php -->
@props([
    'type' => 'button',
    'href' => null
])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md transition-colors duration-150 ease-in-out']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white font-bold rounded-md transition-colors duration-150 ease-in-out']) }}>
        {{ $slot }}
    </button>
@endif
