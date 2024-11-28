<!-- resources/views/components/custom/file-upload.blade.php -->
<div x-data="fileUploadComponent()" class="border-2 border-dashed border-gray-300 p-4 rounded-lg" @dragover.prevent @drop.prevent="handleDrop($event)">
    <input type="file" name="{{ $attributes->get('name') }}" id="{{ $attributes->get('id') }}" multiple @change="handleFiles($event)" class="hidden" x-ref="fileInput">
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
                    <button @click="removeFile(file)" class="text-red-500 hover:text-red-700">&times;</button>
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
                console.log('Files added:', files); // Debug: log files added
                console.log('Input files:', this.$refs.fileInput.files); // Debug: log input files
                files.forEach(file => {
                    this.addFile(file);
                });
            },
            handleDrop(event) {
                const files = Array.from(event.dataTransfer.files);
                console.log('Files dropped:', files); // Debug: log files dropped
                files.forEach(file => {
                    this.addFile(file);
                });
            },
            addFile(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    file.preview = e.target.result;
                    this.files.push(file);
                    console.log('File added:', file); // Debug: log file added
                };
                reader.readAsDataURL(file);
            },
            removeFile(file) {
                this.files = this.files.filter(f => f !== file);
                console.log('File removed:', file); // Debug: log file removed
            }
        };
    }
</script>
