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
                <template v-if="!airport.atis.outdated">
                    <div>
                        <h3 class="flex items-center text-lg leading-6 font-medium text-gray-900">
                            <span class="text-gray-700 mr-2">
                                {{ airport.atis.airport_name }}
                            </span>
                            <span class="text-gray-500 mr-2">ATIS Information</span>
                            <span class="font-bold mr-2">
                                {{ airport.atis.atis_letter }}
                            </span>
                            <span class="text-gray-500 mr-2">at time</span>
                            <span class="font-bold mr-2">
                                {{ airport.atis.time }}
                            </span>
                        </h3>
                        <dl class="mt-3 grid grid-cols-3 gap-3">
                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Depature Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">
                                    {{ airport.atis.depature_runway.join(' & ') }}
                                </dd>
                            </div>

                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Arrival Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">
                                    {{ airport.atis.arrival_runway.join(' & ') }}
                                </dd>
                            </div>

                            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Transition Level
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-900">
                                    {{ airport.atis.transition_level }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </template>
                <template v-else>
                    <div>
                        <h3 class="flex items-center text-lg leading-6 font-medium text-gray-900">
                            <span class="text-gray-700 mr-2">
                                {{ airport.atis.airport_name }}
                            </span>
                        </h3>
                        <dl class="mt-3 grid grid-cols-3 gap-3">
                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Depature Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-500">
                                    Data unavailable
                                </dd>
                            </div>

                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Arrival Runway
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-500">
                                    Data unavailable
                                </dd>
                            </div>

                            <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                                <dt class="text-sm font-medium text-gray-400 truncate">
                                    Transition Level
                                </dt>
                                <dd class="mt-1 text-xl font-semibold text-gray-500">
                                    Data unavailable
                                </dd>
                            </div>
                        </dl>
                    </div>
                </template>
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
