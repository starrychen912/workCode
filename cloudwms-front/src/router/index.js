
import { createRouter, createWebHashHistory ,createWebHistory} from 'vue-router'
import routes from './routes.js'
import {stringifyQuery,parseQuery} from '@/utils/query.js'
// import { stringifyQuery ,parseQuery} from 'vue-router';
const router = createRouter({
    history: createWebHistory(),
    routes:routes,
    // stringifyQuery,
    // parseQuery
})

export default router