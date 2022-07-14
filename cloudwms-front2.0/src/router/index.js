
import { createRouter, createWebHashHistory ,createWebHistory} from 'vue-router'
import {constantRoutes} from './routes.js'
import {stringifyQuery,parseQuery} from '@/utils/query.js'
// import { stringifyQuery ,parseQuery} from 'vue-router';
const router = createRouter({
    history: createWebHistory(),
    routes:constantRoutes,
    scrollBehavior: () => ({ y: 0 }),
    // stringifyQuery,
    // parseQuery
})

export default router