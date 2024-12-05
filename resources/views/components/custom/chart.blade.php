@props(['id', 'title', 'type' => 'line'])

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $title }}</h3>
        <div class="mt-4">
            <canvas id="{{ $id }}" class="w-full"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
