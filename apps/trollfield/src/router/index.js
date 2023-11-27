import { createRouter, createWebHashHistory } from 'vue-router';

import Home from '@/views/Home.vue';
import Single from '@/views/Single.vue';
import SinglePage from '@/views/SinglePage.vue';

const routes = [
    { path: '/', component: Home },
    { path: '/page/:id', component: SinglePage },
    { path: '/:slug', component: Single },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes, // short for `routes: routes`
});

window.vueRouter = router;

export default router;
