import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    base: '/build/',
    build: {
        sourcemap: true,
        minify: 'esbuild',
        manifest: true,
        rollupOptions: {
            // overwrite default .html entry
            input: {
                'main': './frontend/js/main.js',
            },
        },
        outDir: './webroot/js/',
        assetsInlineLimit: 0,
    },
    resolve: {
        alias: {
            '~': '/node_modules/',
            '@': path.resolve(__dirname, './frontend/js/'),
        },
        extensions: ['.js', '.json']
    },
})