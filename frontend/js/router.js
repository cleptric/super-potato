import { createWebHistory, createRouter } from 'vue-router'
import List from '@/views/List.vue'
import Settings from '@/views/Settings.vue'
import Loww from '@/views/Loww.vue'
import Lowi from '@/views/Lowi.vue'
import Lows from '@/views/Lows.vue'
import Lowg from '@/views/Lowg.vue'
import Lowk from '@/views/Lowk.vue'
import Lowl from '@/views/Lowl.vue'


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
    {
        path: '/lowi',
        name: 'Lowi',
        component: Lowi,
    },
    {
        path: '/lows',
        name: 'Lows',
        component: Lows,
    },
    {
        path: '/lowg',
        name: 'Lowg',
        component: Lowg,
    },
    {
        path: '/lowk',
        name: 'Lowk',
        component: Lowk,
    },
    {
        path: '/lowl',
        name: 'Lowl',
        component: Lowl,
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