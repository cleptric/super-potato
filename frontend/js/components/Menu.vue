<template>
    <header class="bg-gray-700 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center py-2 px-4 sm:px-6 lg:px-8">
            <h2 class="text-sm font-medium text-gray-400  mr-8">
                Servus, {{ user.name }} ({{ user.vatsim_id }})
            </h2>
            <div class="flex items-center text-sm font-medium text-gray-400">
                Live Updates
                <i
                    class="fas fa-circle text-xs ml-3"
                    :class="{ 'text-green-400': websocket, 'text-red-400': !websocket }"
                ></i>
            </div>
            <div
                class="ml-auto px-2 rounded-md text-sm font-medium text-gray-400 bg-gray-600 hover:bg-gray-800 hover:text-white"
                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Settings' }"
            >
                <router-link
                    to="/settings"
                    class="flex items-center"
                >
                    <i class="far fa-cog text-xs text-gray-300 mr-1"></i> Settings
                </router-link>
            </div>
            <div class="ml-2 px-2 rounded-md text-sm font-medium text-gray-400 bg-gray-600 hover:bg-gray-800 hover:text-white">
                <a href="/logout" class="flex items-center">
                    <i class="far fa-sign-out text-xs text-gray-300 mr-1"></i> Sign out
                </a>
            </div>
        </div>
    </header>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex items-center justify-between h-12 xl:h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center text-white text-2xl font-extrabold">
                            Super <img class="h-7 w-7 ml-2" :src="logoUrl">
                        </a>
                    </div>
                    <div>
                        <div class="ml-10 flex items-baseline space-x-4">
                            <router-link
                                to="/"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'List' }"
                            >
                                Dashboard <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">1</span>
                            </router-link>
                            <router-link
                                to="/loww"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Loww' }"
                            >
                                <Notification :airport="loww" />
                                LOWW <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">2</span>
                            </router-link>
                            <router-link
                                to="/lowi"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Lowi' }"
                            >
                                <Notification :airport="lowi" />
                                LOWI <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">3</span>
                            </router-link>
                            <router-link
                                to="/lows"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Lows' }"
                            >
                                <Notification :airport="lows" />
                                LOWS <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">4</span>
                            </router-link>
                            <router-link
                                to="/lowg"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Lowg' }"
                            >
                                <Notification :airport="lowg" />
                                LOWG <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">5</span>
                            </router-link>
                            <router-link
                                to="/lowk"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Lowk' }"
                            >
                                <Notification :airport="lowk" />
                                LOWK <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">6</span>
                            </router-link>
                            <router-link
                                to="/lowl"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Lowl' }"
                            >
                                <Notification :airport="lowl" />
                                LOWL <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">7</span>
                            </router-link>
                            <router-link
                                to="/eddm"
                                class="relative text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 !text-white': this.$route.name === 'Eddm' }"
                            >
                                <Notification :airport="eddm" />
                                EDDM <span class="absolute top-0 right-1 text-[0.5rem] text-gray-500">8</span>
                            </router-link>
                        </div>
                    </div>
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
            websocket: computed(() => store.getters.websocket),
            loww: computed(() => store.getters.loww),
            lowi: computed(() => store.getters.lowi),
            lows: computed(() => store.getters.lows),
            lowg: computed(() => store.getters.lowg),
            lowk: computed(() => store.getters.lowk),
            lowl: computed(() => store.getters.lowl),
            eddm: computed(() => store.getters.eddm),
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
            if (e.key === '3') {
                this.$router.push('/lowi')
            }
            if (e.key === '4') {
                this.$router.push('/lows')
            }
            if (e.key === '5') {
                this.$router.push('/lowg')
            }
            if (e.key === '6') {
                this.$router.push('/lowk')
            }
            if (e.key === '7') {
                this.$router.push('/lowl')
            }
            if (e.key === '8') {
                this.$router.push('/eddm')
            }
        })
    },
}
</script>