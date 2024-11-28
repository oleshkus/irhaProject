@props([
    'name' => 'description',
    'value' => '',
    'placeholder' => 'Введите описание...',
    'height' => '300px',
    'id' => null
])

@php
    $uniqueId = $id ?? 'quill-' . uniqid();
@endphp

<div x-data="quillEditor('{{ $uniqueId }}', '{{ $name }}', '{{ $placeholder }}', '{{ $height }}')" 
     x-init="initQuill()"
     wire:ignore
     class="quill-container">
    <input type="hidden" name="{{ $name }}" x-ref="quillInput">
    <div x-ref="quillEditor" id="{{ $uniqueId }}" class="quill-editor"></div>
</div>

@once
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quillEditor', (uniqueId, name, placeholder, height) => ({
            quill: null,
            initQuill() {
                if (document.querySelector(`#${uniqueId}.ql-container`)) return;

                this.quill = new Quill(`#${uniqueId}`, {
                    theme: 'snow',
                    placeholder: placeholder,
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            [{ 'align': [] }],
                            ['link', 'image'],
                            ['clean']
                        ]
                    },
                    height: height
                });

                this.quill.on('text-change', () => {
                    this.$refs.quillInput.value = this.quill.root.innerHTML;
                });

                // Set initial value if provided
                @if($value)
                    this.quill.root.innerHTML = `{!! str_replace('`', '\`', $value) !!}`;
                @endif
            }
        }));
    });
</script>
@endpush

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .quill-container {
        position: relative;
        width: 100%;
    }
    .quill-editor {
        min-height: {{ $height }};
        background-color: #f9fafb;
        border-radius: 0.375rem;
        border: 1px solid #d1d5db;
    }
    .quill-editor .ql-toolbar {
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
        background-color: #f3f4f6;
    }
    .quill-editor .ql-container {
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    .quill-editor .ql-editor {
        min-height: calc({{ $height }} - 50px);
        font-size: 0.875rem;
        line-height: 1.5;
    }
</style>
@endpush
@endonce
