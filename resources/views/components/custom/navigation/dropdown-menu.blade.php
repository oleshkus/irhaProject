@props(['align' => 'right'])

<div x-show="open"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="transform opacity-0 scale-95"
     x-transition:enter-end="transform opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-75"
     x-transition:leave-start="transform opacity-100 scale-100"
     x-transition:leave-end="transform opacity-0 scale-95"
     class="absolute z-50 mt-2 {{ $align === 'right' ? 'right-0' : 'left-0' }} w-48 rounded-md shadow-lg py-1 bg-white"
     @click.away="open = false">
    {{ $slot }}
</div>
