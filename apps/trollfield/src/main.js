import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router/index'


//import 'aframe/dist/aframe-master.js';

import 'aframe-extras/dist/aframe-extras.min.js';
import 'aframe-environment-component/dist/aframe-environment-component.min.js';

import '@/aframe/cursor-component.js';

const app = createApp(App)

app.use(createPinia())

app.use(router)

app.mount('#trollfield-app')
