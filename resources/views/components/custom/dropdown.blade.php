<!-- resources/views/components/dropdown.blade.php -->
<div x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open">{{ $trigger }}</button>
    <div x-show="open" class="mt-2 bg-white rounded-md shadow-lg">
        {{ $slot }}
    </div>
</div>
