@props(['type' => 'success', 'message', 'description' => null])

@php
    $colors = [
        'success' => 'green',
        'info' => 'blue',
        'warning' => 'yellow',
        'error' => 'red'
    ];
    $color = $colors[$type] ?? 'blue';
@endphp

<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-init="setTimeout(() => show = false, 3000)"
     class="fixed right-4 top-4 z-50">
    <div class="bg-white border-l-4 border-{{ $color }}-500 p-4 rounded-lg shadow-lg flex items-center">
        <div class="mr-4 text-{{ $color }}-500">
            @if($type === 'success')
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            @else
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            @endif
        </div>
        <div>
            <p class="text-gray-800 font-semibold">{{ $message }}</p>
            @if($description)
                <p class="text-gray-600 text-sm">{{ $description }}</p>
            @endif
        </div>
    </div>
</div>
