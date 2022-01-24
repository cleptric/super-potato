<template>
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-900">
                Dashboard
            </h1>
        </div>
    </header>
    <main>

        <div class="max-w-7xl mx-auto py-7 sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Notify
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Airport
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ATIS
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Runway
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Transition Level
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            QNH
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Wind
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Conditions
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(airport, icao) in airports"
                                        :key="icao"
                                        :class="counter % 2 == 0 ? 'bg-gray-100' : 'bg-white'"
                                        class="cursor-pointer hover:bg-gray-200"
                                        @click="$router.push(`/${icao}`)"
                                    >
                                        <td
                                            class="px-6"
                                            @click.stop
                                        >
                                            <button
                                                class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                :class="{ 'bg-blue-600': notifications[icao], 'bg-gray-300': !notifications[icao] }"
                                                @click.stop="toggleNotification(icao)"
                                            >
                                                <span
                                                    class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"
                                                    :class="{ 'translate-x-5': notifications[icao], 'translate-x-0': !notifications[icao] }"
                                                >
                                                </span>
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ airport.atis.airport_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ airport.atis.atis_letter }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <template v-if="airport.atis.depature_runway.length && airport.atis.arrival_runway.length">
                                                DEP {{ airport.atis.depature_runway.join(' & ') }}
                                                <span>&nbsp;|&nbsp;</span>
                                                ARR {{ airport.atis.arrival_runway.join(' & ') }}
                                            </template>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <template v-if="airport.atis.transition_level">
                                                FL {{ airport.atis.transition_level }}
                                            </template>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ airport.metar.qnh_value }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <template v-if="airport.metar.mean_speed && airport.metar.mean_direction || airport.metar.is_variable && airport.metar.mean_speed">
                                                <template v-if="airport.metar.is_variable">
                                                    VRB {{ airport.metar.mean_speed }}kts
                                                </template>
                                                <template v-else>
                                                    {{ airport.metar.mean_direction.toString().padStart(3, '0') }}° / {{ airport.metar.mean_speed }}kts
                                                </template>
                                            </template>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ airport.metar.condition }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            <template v-if="airport.missed_approach">
                                                <i class="far fa-plane-departure text-yellow-400"></i>
                                            </template>
                                            <template v-if="airport.closed_runways.length">
                                                <i class="far fa-times mr-1 text-red-800 ml-2"></i>
                                            </template>
                                        </td>
                                        <template>
                                            {{ counter++ }}
                                        </template>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="logs.length"
            class="max-w-7xl mx-auto py-7 sm:px-6 lg:px-8"
        >
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Time
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(log, index) in logs"
                                        :key="index"
                                        :class="index % 2 == 0 ? 'bg-white' : 'bg-gray-100'"
                                    >
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ log.user }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ log.action }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
            counter: 1,
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
