import { createWebHistory, createRouter } from 'vue-router'
import List from '@/views/List.vue'
import Loww from '@/views/Loww.vue'
import Admin from '@/views/Admin.vue'
import Settings from '@/views/Settings.vue'

import Overview from '@/views/Admin/Overview.vue'
import Organisations from '@/views/Admin/Organisations.vue'
import Users from '@/views/Admin/Users.vue'
import Airports from '@/views/Admin/Airports.vue'
import Configuration from '@/views/Admin/Configuration.vue'

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
        path: '/admin',
        name: 'Admin',
        component: Admin,
        children: [
            {
                path: 'overview',
                name: 'Admin/Overview',
                component: Overview,
                meta: { title: 'Admin - Overview' },
            },
            {
                path: 'users',
                name: 'Admin/Users',
                component: Users,
                meta: { title: 'Admin - Users' },
            },
            {
                path: 'airports',
                name: 'Admin/Airports',
                component: Airports,
                meta: { title: 'Admin - Airports' },
            },
            {
                path: 'organisations',
                name: 'Admin/Organisations',
                component: Organisations,
                meta: { title: 'Admin - Organisations' },
            },
            {
                path: 'configuration',
                name: 'Admin/Configuration',
                component: Configuration,
                meta: { title: 'Admin - Configuration' },
            },
        ],
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