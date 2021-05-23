<template>
    <header class="bg-gray-700 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center py-2 px-4 sm:px-6 lg:px-8">
            <h2 class="text-sm font-medium text-gray-400  mr-8">
                Servus, {{ user.name }} ({{ user.vatsim_id }})
            </h2>
            <!-- <div class="text-sm font-medium text-gray-400 mr-8">
                Online as <strong class="text-gray-300">LOWW_APP</strong>
            </div> -->
            <div class="flex items-center text-sm font-medium text-gray-400">
                Websocket
                <i
                    class="fas fa-circle text-xs ml-3"
                    :class="{ 'text-green-300': websocket, 'text-red-300': !websocket }"
                ></i>
            </div>
            <!-- <div class="ml-auto mr-2 px-2 rounded-md text-sm font-medium text-gray-400 bg-gray-600 hover:bg-gray-800 hover:text-white">
                <a href="/settings" class="flex items-center">
                    <i class="far fa-cog text-xs text-gray-300 mr-1"></i> Settings
                </a>
            </div> -->
            <div class="ml-auto px-2 rounded-md text-sm font-medium text-gray-400 bg-gray-600 hover:bg-gray-800 hover:text-white">
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
                        <router-link to="/" class="flex items-center text-white text-2xl font-extrabold">
                            Super <img class="h-7 w-7 ml-2" :src="logoUrl">
                        </router-link>
                    </div>
                    <div>
                        <div class="ml-10 flex items-baseline space-x-4">
                            <router-link
                                to="/"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 text-white': this.$route.name === 'List' }"
                            >
                                Dashboard
                            </router-link>
                            <router-link
                                to="/loww"
                                class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                :class="{ 'bg-gray-900 text-white': this.$route.name === 'Loww' }"
                            >
                                LOWW
                            </router-link>
                            <a href="#" class="pointer-events-none text-gray-600 px-3 py-2 rounded-md text-sm font-medium">LOWI</a>
                            <a href="#" class="pointer-events-none text-gray-600 px-3 py-2 rounded-md text-sm font-medium">LOWS</a>
                            <a href="#" class="pointer-events-none text-gray-600 px-3 py-2 rounded-md text-sm font-medium">LOWG</a>
                            <a href="#" class="pointer-events-none text-gray-600 px-3 py-2 rounded-md text-sm font-medium">LOWK</a>
                            <a href="#" class="pointer-events-none text-gray-600 px-3 py-2 rounded-md text-sm font-medium">LOWL</a>
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

export default {
    name: 'Menu',
    setup () {
        const store = useStore()

        return {
            logoUrl: '/img/potato.png',
            user: computed(() => store.getters.user),
            websocket: computed(() => store.getters.websocket),
        }
    },
}
</script>