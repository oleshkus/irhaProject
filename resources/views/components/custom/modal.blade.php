<!-- resources/views/components/modal.blade.php -->
<div x-data="{ open: false }">
    <button @click="open = true">{{ $trigger }}</button>
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
        <div {{ $attributes->merge(['class' => 'bg-white p-6 rounded-lg shadow-lg']) }}>
            <button @click="open = false" class="absolute top-0 right-0 m-4">X</button>
            {{ $slot }}
        </div>
    </div>
</div>
