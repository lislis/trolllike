import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router/index'
import PageTransition from 'vue3-page-transition'
import { TroisJSVuePlugin } from 'troisjs';

//import './assets/main.css'

const app = createApp(App)

app.use(createPinia())

app.use(router)

app.mount('#trollfield-app')

app.use(PageTransition)

app.use(TroisJSVuePlugin)
