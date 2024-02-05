import './bootstrap';
import { createApp } from 'vue';


const app = createApp({});

import App from './components/App.vue';
app.component('app', App);

import router from "./router"
app.use(router);

app.mount('#app');
