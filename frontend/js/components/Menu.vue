<template>
    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <router-link to="/" class="h-8 w-8 text-white text-2xl font-extrabold">Super 🥔</router-link>
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
                <div class="ml-auto flex items-center">
                    <a href="/logout" class="px-3 py-2 rounded-md text-sm text-gray-300 font-medium hover:bg-gray-700 hover:text-white">Sign out</a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Menu',
}
</script>