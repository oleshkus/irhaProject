<div class="fixed top-4 right-4 bg-green-500 text-white py-2 px-4 rounded shadow-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
    {{ $slot }}
</div>
