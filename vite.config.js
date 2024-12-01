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
        // Enable CSS minification
        cssMinify: true,
        // Optimize bundle size
        rollupOptions: {
            output: {
                manualChunks: {
                    // Group vendor files
                    vendor: ['alpinejs'],
                    // Group map-related files
                    maps: ['leaflet', 'leaflet-control-geocoder'],
                },
                // Asset naming for better caching
                assetFileNames: (assetInfo) => {
                    let extType = assetInfo.name.split('.')[1];
                    if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
                        extType = 'img';
                    }
                    return `assets/${extType}/[name]-[hash][extname]`;
                },
            }
        },
        // Enable build cache
        cache: true,
        // Optimize chunks
        chunkSizeWarningLimit: 1000,
    },
    optimizeDeps: {
        include: ['alpinejs', 'leaflet', 'leaflet-control-geocoder']
    }
});
