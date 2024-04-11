import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/less/styles.less', 'resources/js/scripts.js'],
            refresh: true,
        }),
    ],
});
