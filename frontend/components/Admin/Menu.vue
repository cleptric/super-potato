<template>
    <header class="bg-white dark:bg-black">
        <div class="max-w-7xl mx-auto py-3 px-8">
            <div class="flex items-baseline">
                <div class="flex items-baseline space-x-3">
                    <router-link
                        to="/admin/overview"
                        class="relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Admin/Overview' }"
                    >
                        Overview
                    </router-link>
                    <router-link
                        to="/admin/users"
                        class="relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Admin/Users' }"
                    >
                        Users
                    </router-link>
                    <router-link
                        to="/admin/airports"
                        class="relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Admin/Airports' }"
                    >
                        Airports
                    </router-link>
                </div>
                <div class="flex items-baseline ml-12 space-x-3">
                    <router-link
                        to="/admin/organisations"
                        class="relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Admin/Organisations' }"
                    >
                        Organisations
                    </router-link>
                    <router-link
                        to="/admin/configuration"
                        class="relative border border-gray-300 dark:border-zinc-600 text-center text-gray-800 dark:text-zinc-100 hover:bg-gray-100 dark:hover:bg-zinc-700 px-3.5 py-2 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-300 dark:bg-zinc-600': this.$route.name === 'Admin/Configuration' }"
                    >
                        Configuration
                    </router-link>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: 'Menu',
}
</script>