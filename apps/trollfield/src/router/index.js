import { createRouter, createWebHashHistory } from 'vue-router';

import Home from '@/views/Home.vue';
import Single from '@/views/Single.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/:slug', component: Single },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes, // short for `routes: routes`
});

export default router;
