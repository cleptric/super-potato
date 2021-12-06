import { createWebHistory, createRouter } from 'vue-router'
import List from '@/views/List.vue'
import Settings from '@/views/Settings.vue'
import Loww from '@/views/Loww.vue'


const routes = [
    {
        path: '/',
        name: 'List',
        component: List,
        meta: { title: 'Dashboard' }
    },
    {
        path: '/loww',
        name: 'Loww',
        component: Loww,
        meta: { title: 'LOWW' }
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

const defaultTitle = 'Super Potato'
router.afterEach((to, from, next) => {
   document.title = to.meta.title || defaultTitle
})