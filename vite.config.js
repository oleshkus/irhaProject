import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Включаем минификацию CSS
        cssMinify: true,
        // Оптимизируем размер бандла
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['alpinejs']
                }
            }
        },
        // Включаем кэширование
        cache: true,
        // Оптимизируем чанки
        chunkSizeWarningLimit: 1000,
    },
    optimizeDeps: {
        include: ['alpinejs']
    }
});
