document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('input[name="images[]"]');
    const preview = document.getElementById('image-preview');

    if (input && preview) {
        input.addEventListener('change', function() {
            preview.innerHTML = ''; // Очищаем предыдущие превью

            Array.from(this.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                const div = document.createElement('div');
                div.className = 'relative group';

                reader.onload = function(e) {
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="preview" class="w-full h-48 object-cover rounded-lg">
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                            <button type="button" class="text-white hover:text-red-500" onclick="this.closest('.relative').remove()">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    `;
                    preview.appendChild(div);
                };

                reader.readAsDataURL(file);
            });
        });

        // Drag and drop functionality
        const dropZone = input.closest('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-blue-500', 'bg-blue-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            input.files = files;
            
            // Trigger change event to show preview
            input.dispatchEvent(new Event('change'));
        }
    }
});
