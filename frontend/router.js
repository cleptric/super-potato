import { nextTick } from 'vue'
import { createWebHistory, createRouter } from 'vue-router'
import List from '@/views/List.vue'
import Eddm from '@/views/Eddm.vue'
import Admin from '@/views/Admin.vue'
import Settings from '@/views/Settings.vue'


const routes = [
    {
        path: '/',
        name: 'List',
        component: List,
        meta: { title: 'Dashboard' }
    },
    {
        path: '/eddm',
        name: 'Eddm',
        component: Eddm,
        meta: { title: 'EDDM' }
    },
    {
        path: '/admin',
        name: 'Admin',
        component: Admin,
        meta: { title: 'Admin Dashboard' }
    },
    {
        path: '/settings',
        name: 'Settings',
        component: Settings,
        meta: { title: 'Settings' }
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