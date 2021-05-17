import { createWebHistory, createRouter } from 'vue-router'
import List from '@/views/List.vue'
import Loww from '@/views/Loww.vue'

const routes = [
    {
        path: '/',
        name: 'List',
        component: List,
    },
    {
        path: '/loww',
        name: 'Loww',
        component: Loww,
    },
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})