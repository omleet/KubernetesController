import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

    ],
    /* Para aceder pelo telemovel ao site */
    /* 
     server: {
        host: '0.0.0.0', // Accept connections from the network
        port: 5173,
        hmr: {
          host: '192.168.1.154', // <-- Your laptop's IP address
        },
      },
      */
});
