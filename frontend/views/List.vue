<template>
    <main class="space-y-3">
        <div class="max-w-7xl mx-auto px-8">
            <ul class="mt-3">
                <li
                    v-for="(airport, icao) in airports"
                    :key="icao"
                    class="bg-white dark:bg-zinc-900 overflow-hidden rounded-md border border-gray-200 dark:border-zinc-600"
                >
                    <div class="p-3">
                        <div class="flex items-center mb-3">
                            <button
                                class="relative inline-flex shrink-0 h-4 w-7 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3"
                                :class="{ 'bg-blue-700': notifications[icao], 'bg-gray-300': !notifications[icao] }"
                                @click="toggleNotification(icao)"
                            >
                                <span
                                    class="pointer-events-none inline-block h-3 w-3 rounded-full bg-white shadow ring-0 transition ease-in-out duration-200"
                                    :class="{ 'translate-x-3': notifications[icao], 'translate-x-0': !notifications[icao] }"
                                >
                                </span>
                            </button>
                            <div class="text-xl font-semibold text-gray-700 dark:text-zinc-100">
                                {{ airport.name }}
                            </div>
                            <div class="ml-3">
                                <a  v-if="airport.charts_link"
                                    target="_blank"
                                    rel="noopener"
                                    :href="airport.charts_link"
                                    class="text-sm font-medium text-blue-700 underline"
                                >
                                    Charts
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="flex items-center mr-6">
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">QNH</span>
                                <span class="font-bold">{{ airport.metar.qnh_value }}</span>
                                <template v-if="airport.metar.qnh_trend && airport.metar.qnh_trend === 'up'">
                                    <i class="fas fa-xs fa-arrow-alt-up text-green-300 ml-0.5"></i>
                                </template>
                                <template v-else-if="airport.metar.qnh_trend && airport.metar.qnh_trend === 'down'">
                                    <i class="fas fa-xs fa-arrow-alt-down text-red-300 ml-0.5"></i>
                                </template>
                            </div>
                            <div
                                v-if="airport.metar.mean_speed && airport.metar.mean_direction || airport.metar.is_variable && airport.metar.mean_speed"
                                class="flex items-center mr-6"
                            >
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">Wind</span>
                                <template v-if="airport.metar.is_variable">
                                    <span class="font-bold">
                                        VRB {{ airport.metar.mean_speed }}kts
                                    </span>
                                </template>
                                <template v-else>
                                    <span class="font-bold">
                                        {{ airport.metar.mean_direction.toString().padStart(3, '0') }}° / {{ airport.metar.mean_speed }}kts
                                    </span>
                                </template>
                            </div>
                            <div
                                v-if="airport.metar.speed_variations"
                                class="flex items-center mr-6"
                            >
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">Maximum</span>
                                <span class="font-bold">{{ airport.metar.speed_variations }}kts</span>
                            </div>
                            <div
                                v-if="airport.metar.temperature  !== null && airport.metar.dew_point !== null"
                                class="flex items-center mr-6"
                            >
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">Temperature</span>
                                <span class="font-bold">{{ airport.metar.temperature }} / {{ airport.metar.temperature }}</span>
                                <template v-if="airport.metar.temperature <= 10">
                                    <i class="far fa-xs fa-snowflakes text-blue-300 ml-0.5"></i>
                                </template>
                            </div>
                            <div class="flex items-center mr-6">
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">ATIS</span>
                                <span class="font-bold">{{ airport.atis.atis_letter }}</span>
                            </div>
                            <div class="flex items-center mr-6">
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">TRL</span>
                                <span class="font-bold">{{ airport.atis.transition_level }}</span>
                            </div>
                            <div class="flex items-center mr-6">
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">Conditions</span>
                                <span class="font-bold">{{ airport.metar.conditions }}</span>
                            </div>
                            <div
                                v-if="airport.atis.depature_runway.length && airport.atis.arrival_runway.length"
                                class="flex items-center mr-6"
                            >
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">DEP</span>
                                <span class="font-bold">{{ airport.atis.depature_runway.join(' & ') }}</span>
                                <span class="text-sm font-medium text-gray-300 dark:text-zinc-600 mx-0.5">&nbsp;|&nbsp;</span>
                                <span class="text-sm font-medium text-gray-500 dark:text-zinc-300 mr-1.5">ARR</span>
                                <span class="font-bold">{{ airport.atis.arrival_runway.join(' & ') }}</span>
                            </div>
                            <!-- <div class="flex items-center mr-6">
                                <template v-if="airport.missed_approach">
                                    <i class="far fa-plane-departure text-yellow-400"></i>
                                </template>
                                <template v-if="airport.closed_runways.length">
                                    <i class="far fa-times mr-1 text-red-800 ml-2"></i>
                                </template>
                            </div> -->
                        </div>
                        <div class="flex items-center">
                            <code class="text-xs text-gray-500 dark:text-zinc-500">{{ airport.metar.raw_metar }}</code>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div
            v-if="logs.length"
            class="max-w-7xl mx-auto px-8"
        >
            <div class="flex flex-col">
                <div class="-my-2 -mx-8 overflow-x-auto">
                    <div class="py-2 px-8 align-middle inline-block min-w-full">
                        <div class="border border-gray-200 dark:border-zinc-600 overflow-hidden rounded-md">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody>
                                    <tr
                                        v-for="(log, index) in logs"
                                        :key="index"
                                        :class="index % 2 == 0 ? 'bg-white dark:bg-zinc-900' : 'bg-gray-100 dark:bg-zinc-800'"
                                    >
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            {{ log.user }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-zinc-300">
                                            {{ log.action }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-zinc-300">
                                            {{ log.time }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'List',
    setup () {
        const store = useStore()

        return {
            airports: computed(() => store.getters.airports),
            notifications: computed(() => store.getters.notifications),
            logs: computed(() => store.getters.logs),
        }
    },
    methods: {
        async toggleNotification(icao) {
            this.$store.dispatch('toggleNotification', icao)
            try {
                this.$store.dispatch('saveNotifications')
            } catch (error) {
            }
        },
    },
}
</script>
