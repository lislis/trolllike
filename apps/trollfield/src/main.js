import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router/index'
import PageTransition from 'vue3-page-transition'

import 'aframe/dist/aframe-master.js';
import 'aframe-extras/dist/aframe-extras.min.js';
import 'aframe-environment-component/dist/aframe-environment-component.min.js';

//import '@/vendor/joystick.js';

//import "nipplejs/dist/nipplejs.js";

//import 'fast-2d-poisson-disk-sampling/src/fast-poisson-disk-sampling.js';

//import "https://cdn.jsdelivr.net/gh/kchapelier/fast-2d-poisson-disk-sampling@1.0.3/build/fast-poisson-disk-sampling.min.js";


//import { TroisJSVuePlugin } from 'troisjs';

//import './assets/main.css'

const app = createApp(App)

app.use(createPinia())

app.use(router)

app.mount('#trollfield-app')

app.use(PageTransition)

//app.use(TroisJSVuePlugin)
