import { createWebHistory, createRouter } from 'vue-router'
import List from '@/views/List.vue'
import Eddm from '@/views/Eddm.vue'
import Settings from '@/views/Settings.vue'


const routes = [
    {
        path: '/',
        name: 'List',
        component: List,
    },
    {
        path: '/eddm',
        name: 'Eddm',
        component: Eddm,
    },
    {
        path: '/settings',
        name: 'Settings',
        component: Settings,
    },
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})