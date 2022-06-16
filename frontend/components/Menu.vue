<template>
    <nav class="bg-gray-200 dark:bg-zinc-800">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex items-center justify-between h-12 xl:h-16">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <a href="/" class="flex items-center text-2xl font-extrabold">
                            Super <img class="h-7 w-7 ml-1" :src="logoUrl">
                        </a>
                    </div>
                    <div>
                        <div class="ml-6 flex items-baseline space-x-3">
                            <router-link
                                to="/"
                                class="relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                                :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'List' }"
                            >
                                Dashboard <span class="absolute top-0 right-1.5 text-[0.5rem]">1</span>
                            </router-link>
                            <router-link
                                to="/loww"
                                class="relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                                :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Loww' }"
                            >
                                <Notification :airport="loww" />
                                LOWW <span class="absolute top-0 right-1.5 text-[0.5rem]">2</span>
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <router-link
                        v-if="user.role === 'admin'"
                        to="/admin"
                        class="flex items-center relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Admin' }"
                    >
                        <i class="fa-solid fa-screwdriver-wrench text-xs mr-2"></i>
                        Admin
                    </router-link>
                    <router-link
                        to="/settings"
                        class="flex items-center relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Settings' }"
                    >
                        <i class="fa-solid fa-sliders text-xs mr-2"></i>
                        Settings
                    </router-link>
                    <a
                        href="/logout"
                        class="flex items-center relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                    >
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs mr-2"></i>
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import Notification from './Notification.vue'

export default {
    name: 'Menu',
    components: {
        Notification,
    },
    setup () {
        const store = useStore()

        return {
            logoUrl: '/img/potato.png',
            user: computed(() => store.getters.user),
            loww: computed(() => store.getters.loww),
        }
    },
    created() {
        document.addEventListener('keyup', (e) => {
            if (e.key === '1') {
                this.$router.push('/')
            }
            if (e.key === '2') {
                this.$router.push('/loww')
            }
        })
    },
}
</script>