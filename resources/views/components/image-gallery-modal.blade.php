@props(['images', 'alt'])

@if($images->count() > 1)
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Галерея</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($images->skip(1) as $image)
                <div class="relative aspect-w-3 aspect-h-2 cursor-pointer" onclick="openImageModal('{{ Storage::url($image->path) }}')">
                    <img src="{{ Storage::url($image->path) }}" alt="{{ $alt }}" class="object-cover rounded-lg hover:opacity-90 transition-opacity">
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Modal для просмотра фотографий -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-75 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="max-w-7xl max-h-[90vh] relative" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt="" class="max-h-[90vh] max-w-full object-contain rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function openImageModal(imageUrl) {
        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
    }
</script>
@endpush
