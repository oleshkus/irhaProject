<!-- resources/views/components/custom/file-upload.blade.php -->
<div x-data="fileUploadComponent()" class="border-2 border-dashed border-gray-300 p-4 rounded-lg" @dragover.prevent @drop.prevent="handleDrop($event)">
    <input 
        type="file" 
        {{ $attributes->merge(['class' => 'hidden']) }}
        @change="handleFiles($event)" 
        x-ref="fileInput"
    >
    <div @click="$refs.fileInput.click()" class="cursor-pointer text-center">
        <p class="text-gray-500">Перетащите файлы сюда или нажмите для выбора</p>
    </div>
    <template x-if="files.length > 0">
        <div class="mt-4">
            <template x-for="file in files" :key="file.name">
                <div class="flex items-center justify-between p-2 bg-gray-100 rounded-lg mb-2">
                    <div class="flex items-center">
                        <template x-if="file.type.startsWith('image/')">
                            <img :src="file.preview" alt="" class="w-10 h-10 object-cover rounded mr-2">
                        </template>
                        <span class="text-gray-700" x-text="file.name"></span>
                    </div>
                    <button @click="removeFile(file)" type="button" class="text-red-500 hover:text-red-700">&times;</button>
                </div>
            </template>
        </div>
    </template>
</div>

<script>
    function fileUploadComponent() {
        return {
            files: [],
            handleFiles(event) {
                const files = Array.from(event.target.files);
                files.forEach(file => {
                    this.addFile(file);
                });
            },
            handleDrop(event) {
                const files = Array.from(event.dataTransfer.files);
                files.forEach(file => {
                    this.addFile(file);
                });
            },
            addFile(file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        file.preview = e.target.result;
                        this.files.push(file);
                    };
                    reader.readAsDataURL(file);
                } else {
                    this.files.push(file);
                }
            },
            removeFile(file) {
                const index = this.files.indexOf(file);
                if (index > -1) {
                    this.files.splice(index, 1);
                }
                
                // Clear the file input if all files are removed
                if (this.files.length === 0) {
                    this.$refs.fileInput.value = '';
                }
            }
        }
    }
</script>
