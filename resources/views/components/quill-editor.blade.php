@props([
    'name' => 'description',
    'value' => '',
    'placeholder' => 'Введите описание...',
    'height' => '300px'
])

<div 
    x-data="{ 
        init() {
            // Проверяем, не инициализирован ли уже редактор
            if (this.$refs.editor.querySelector('.ql-editor')) {
                return;
            }

            const editor = new Quill(this.$refs.editor, {
                theme: 'snow',
                placeholder: '{{ $placeholder }}',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });

            if (@js($value)) {
                editor.root.innerHTML = @js($value);
            }

            editor.on('text-change', () => {
                this.$refs.input.value = editor.root.innerHTML;
            });
        }
    }" 
    x-init="init()"
    class="quill-container"
>
    <input type="hidden" name="{{ $name }}" x-ref="input">
    <div x-ref="editor" class="editor-container" style="min-height: {{ $height }};"></div>
</div>

@once
@push('styles')
<style>
    .quill-container {
        width: 100%;
    }
    .editor-container {
        border-radius: 0.375rem;
    }
    .ql-toolbar {
        background-color: #f3f4f6;
        border-radius: 0.375rem 0.375rem 0 0 !important;
    }
    .ql-container {
        border-radius: 0 0 0.375rem 0.375rem !important;
        background-color: white;
    }
</style>
@endpush
@endonce
