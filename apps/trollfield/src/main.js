import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router/index'
import PageTransition from 'vue3-page-transition'

import 'aframe/dist/aframe-master.js';
import 'aframe-extras/dist/aframe-extras.min.js';
import 'aframe-environment-component/dist/aframe-environment-component.min.js';


//import 'fast-2d-poisson-disk-sampling/src/fast-poisson-disk-sampling.js';

const app = createApp(App)

app.use(createPinia())

app.use(router)

app.mount('#trollfield-app')

app.use(PageTransition)

//app.use(TroisJSVuePlugin)
