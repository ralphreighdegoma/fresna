import { defineConfig } from 'vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', `resources/css/filament/app/theme.css`],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
    server: {
        proxy: {
            '/resources/css': {
                target: 'http://13.239.24.219/',
                changeOrigin: true,
                secure: false,
            },
        },
    },
})