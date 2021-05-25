<template>
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold text-gray-900">
                Airports
            </h1>
        </div>
    </header>
    <main>
        <div
            v-for="(airport, airportName) in airports"
            :key="airportName"
            class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8"
        >
            <div class="px-4 py-4 sm:px-0">
                <div>
                    <h3 class="flex items-center text-lg leading-6 font-medium text-gray-900">
                        <span class="text-gray-700 mr-2">
                            {{ airport.atis.airport_name }}
                        </span>
                        <template v-if="!airport.atis.outdated">
                            <span class="text-gray-500 mr-2">ATIS Information</span>
                            <span class="font-bold mr-2">
                                {{ airport.atis.atis_letter }}
                            </span>
                            <span class="text-gray-500 mr-2">at time</span>
                            <span class="font-bold mr-2">
                                {{ airport.atis.time }}
                            </span>
                        </template>
                    </h3>
                    <dl class="mt-3 grid grid-cols-5 gap-3">
                        <template v-if="!airport.atis.outdated">
                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Depature Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">
                                    {{ airport.atis.depature_runway.join(' & ') }}
                                </dd>
                            </div>
                        </template>
                        <template v-else>
                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Depature Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-500">
                                    Data unavailable
                                </dd>
                            </div>
                        </template>

                        <template v-if="!airport.atis.outdated">
                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Arrival Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">
                                    {{ airport.atis.arrival_runway.join(' & ') }}
                                </dd>
                            </div>
                        </template>
                        <template v-else>
                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Arrival Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-500">
                                    Data unavailable
                                </dd>
                            </div>
                        </template>

                        <template v-if="!airport.atis.outdated">
                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Transition Level
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">
                                    {{ airport.atis.transition_level }}
                                </dd>
                            </div>
                        </template>
                        <template v-else>
                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Transition Level
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-500">
                                    Data unavailable
                                </dd>
                            </div>
                        </template>

                        <template v-if="airport.metar.qnh_value && airport.metar.qnh_unit">
                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    QNH
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                                    {{ airport.metar.qnh_value }}
                                    <span class="text-lg font-medium text-gray-500">
                                        {{ airport.metar.qnh_unit }}
                                    </span>
                                </dd>
                            </div>
                        </template>
                        <template v-else>
                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    QNH
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                                    Data unavailable
                                </dd>
                            </div>
                        </template>

                        <template v-if="airport.metar.mean_speed && airport.metar.mean_direction">
                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Wind
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                                    <template v-if="airport.metar.is_variable">
                                        VRB {{ airport.metar.mean_speed }}kts
                                    </template>
                                    <template v-else>
                                        {{ airport.metar.mean_direction }}° / {{ airport.metar.mean_speed }}kts
                                    </template>
                                </dd>
                            </div>
                        </template>
                        <template v-else>
                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Wind
                                </dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                                    Data unavailable
                                </dd>
                            </div>
                        </template>

                    </dl>
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
        }
    },
}
</script>
