import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // Import the v4 plugin

export default defineConfig({
    plugins: [
        tailwindcss(), // This replaces the need for postcss
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});