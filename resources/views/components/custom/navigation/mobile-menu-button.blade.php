@props(['isOpen'])

<button @click="isOpen = !isOpen" 
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-blue-700 focus:outline-none']) }}
        :class="{ 'bg-blue-700': isOpen }">
    <svg class="h-6 w-6" :class="{ 'hidden': isOpen, 'block': !isOpen }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    <svg class="h-6 w-6" :class="{ 'block': isOpen, 'hidden': !isOpen }" stroke="currentColor" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
    </svg>
</button>
