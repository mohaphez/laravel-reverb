/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import.meta.glob([
    '../assets/**',
]);

import "./bootstrap.js";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import { createApp } from "vue";

// import Swiper bundle with all modules installed
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

window.Swiper = Swiper;
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    wssPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


// Vue components
const app = createApp({});

const files = import.meta.globEager('../components/*.vue');
for (const path in files) {
    const name = path.split('/').pop().split('.')[0].toLowerCase() + '-component';
    app.component(name, files[path].default);
}

app.mount("#app");