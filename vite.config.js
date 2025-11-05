import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: 
            [
                'resources/css/app.css',
                'resources/css/components/buttons.css',
                'resources/css/modules/auth.css',
                'resources/css/modules/welcome.css',
                'resources/css/sweetalert2-custom.css',
                'resources/js/app.js',
                'resources/js/components/welcome.js',
                'resources/js/components/searchFilter.js',
                'resources/js/components/sweetalert2-utils.js',
                'resources/js/utils/action-handler.js'
            ],
            refresh: true,
        }),
    ],
});
