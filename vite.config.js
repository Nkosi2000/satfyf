import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                // Body/UI typeface — matches the rounded, friendly sans used
                // for body copy on the brand cover photo (replaces Zalando
                // Sans, which the cover photo doesn't use at all).
                bunny('Fredoka', {
                    weights: [400, 500, 600, 700],
                }),
                // Display typeface — the tall, condensed, pointed-apex caps
                // font used for "SOUTH AFRICAN TOBACCO-FREE YOUTH FORUM" on
                // the cover photo and in the logo wordmark itself. Only
                // ships weight 400 (it's a single-weight display face).
                bunny('Bebas Neue', {
                    weights: [400],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
