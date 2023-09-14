import { createRouter, createWebHistory } from 'vue-router'

import dashboard from '../pages/dashboard.vue'
import users from '../pages/users.vue'

import notfound from '../pages/notfound.vue'

const routes = [
    {
        path: '/',
        component: dashboard
    },
    {
        path: '/users',
        component: users
    },
    {
        path: '/:pathMatch(.*)*',
        component: notfound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router