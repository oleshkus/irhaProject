@props(['title', 'backRoute', 'backText' => 'Назад'])

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold text-gray-800">
        {{ $title }}
    </h2>
    <a href="{{ $backRoute }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        {{ $backText }}
    </a>
</div>
