import {defineConfig} from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "tailwindcss";
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    base: "/Mars",
    envDir: "../../",
    plugins: [
        laravel({
            input: [
                "/resources/css/app.css",
                "/resources/js/app.js",
            ],
            buildDirectory: "Mars",
            publicDirectory: "./../../public"
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        {
            name: "blade",
            handleHotUpdate({file, server}) {
                if (file.endsWith(".blade.php")) {
                    server.ws.send({
                        type: "full-reload",
                        path: "*",
                    });
                }
            },
        },
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            vue: 'vue/dist/vue.esm-bundler.js',

        }
    },
    css: {
        postcss: {
            plugins: [
                tailwindcss({
                    config: 'tailwind.config.js'
                }),
            ],
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        }
    }
});