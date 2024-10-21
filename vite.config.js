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
            target: 'http://3.107.167.23:9090',
            changeOrigin: true,
            secure: false,
          },
        },
      },

    server: { 
        https: false,
        host: true,
        port: 5173,
        hmr: {host: 'localhost', protocol: 'ws'},
    }, 
})