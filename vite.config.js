import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/sidebar.css', 
                'resources/css/home.css', 
                'resources/css/dashboard.css', 
                'resources/css/navbar.css', 
                'resources/js/app.js',
                'resources/js/todoUpdater.js'
            ],
            refresh: true,
        }),
    ],
});
