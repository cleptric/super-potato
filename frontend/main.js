import { createApp } from 'vue'
import { store } from '@/store'
import { router } from '@/router'

import { api } from '@/api'

import App from '@/App.vue'

import './main.css'

(async () => {
    api.init()
    await store.dispatch('loadData')
    await store.dispatch('loadSettings')
    await store.dispatch('loadNotifications')

    const app = createApp(App)
    app.use(store)
    app.use(router)
    app.mount('#app')
})()

// Dark mode setup
if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark')
    localStorage.theme = 'dark'
} else {
    document.documentElement.classList.remove('dark')
    localStorage.theme = 'light'
}