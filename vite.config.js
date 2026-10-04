import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/login.css',
                'resources/css/admin.css',
                'resources/css/kasir.css',
                'resources/css/pos.css',
                'resources/css/user.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});