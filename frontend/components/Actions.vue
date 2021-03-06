<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="grid grid-cols-3 gap-3">

            <template v-if="user.can_trigger_actions">
                <div
                    v-if="airport.visual_depature_directions.length"
                    class="p-3 bg-white shadow rounded-lg overflow-hidden"
                >
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Visual Depatures
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        <span
                            class="relative z-0 inline-flex shadow-sm rounded-md"
                        >
                            <button
                                v-for="(depature, index) in airport.visual_depature_directions"
                                :key="index"
                                @click="triggerVisualDepature(depature)"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white capitalize text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                :class="{
                                    '!border-blue-300 bg-blue-200 text-blue-700 hover:!bg-blue-100': airport.visual_depature.includes(depature),
                                    '-ml-px ': index !== 0,
                                    'rounded-l-md': index === 0,
                                    'rounded-r-md': index === airport.visual_depature_directions.length - 1
                                }"
                            >
                                {{ depature }}
                            </button>
                        </span>
                    </dd>
                </div>

                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Runway Closed
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        <template v-if="closedRunwaysDisabled">
                            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                <span
                                    class="relative inline-flex items-center pointer-events-none px-4 py-2 rounded-md bg-gray-100 border border-gray-100 bg-white text-sm font-medium text-gray-400"
                                >
                                    In progress...
                                </span>
                            </span>
                        </template>
                        <template v-else>
                            <span
                                class="relative z-0 inline-flex shadow-sm rounded-md"
                            >
                                <button
                                    v-for="(runway, index) in airport.runways"
                                    :key="index"
                                    @click="triggerRunwayClosed(runway)"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                                    :class="{
                                        'border-red-300 bg-red-200 text-red-800 hover:bg-red-100 focus:ring-red-500 focus:border-red-500': airport.closed_runways.includes(runway),
                                        '-ml-px ': index !== 0,
                                        'rounded-l-md': index === 0,
                                        'rounded-r-md': index === airport.runways.length - 1
                                    }"
                                >
                                    {{ runway }}
                                </button>
                            </span>
                        </template>
                    </dd>
                </div>

                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Missed Approach
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        <template v-if="missedApporachDisabled">
                            <span
                                class="inline-flex items-center px-4 py-2 pointer-events-none border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-300"
                            >
                                In progress...
                            </span>
                        </template>
                        <template v-else>
                            <button
                                v-if="airport.missed_approach"
                                @click="triggerMissedApproach"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Remove Notification
                            </button>
                            <button
                                v-else
                                @click="triggerMissedApproach"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Trigger Notification
                            </button>
                        </template>
                    </dd>
                </div>
            </template>
            <template v-else>
                <div
                    v-if="airport.visual_depature_directions.length"
                    class="p-3 bg-gray-100 rounded-lg overflow-hidden"
                >
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Visual Depatures
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        Could not find VATSIM session
                    </dd>
                </div>

                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Runway Closed
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        Could not find VATSIM session
                    </dd>
                </div>

                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Missed Approach
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        Could not find VATSIM session
                    </dd>
                </div>
            </template>

        </dl>
    </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { api } from '@/api'

export default {
    name: 'Actions',
    props: {
        airport: Object,
    },
    setup (props) {
        const store = useStore()

        return {
            user: computed(() => store.getters.user),
            missedApporachDisabled: computed(() => {
                let timestamp = Math.round((new Date()).getTime() / 1000)
                return timestamp < props.airport.missed_approach_timeout
            }),
            closedRunwaysDisabled: computed(() => {
                let timestamp = Math.round((new Date()).getTime() / 1000)
                return timestamp < props.airport.closed_runways_timeout
            }),
        }
    },
    data() {
        return {
            missedApporachInterval: null,
            closedRunwaysInterval: null,
        }
    },
    watch: {
        missedApporachDisabled() {
            this.startMissedApproachTimer()
        },
        closedRunwaysDisabled() {
            this.startClosedRunwaysTimer()
        }
    },
    mounted() {
        if (this.missedApporachDisabled) {
            this.startMissedApproachTimer()
        }
        if (this.closedRunwaysDisabled) {
            this.startClosedRunwaysTimer()
        }
    },
    methods: {
        async triggerMissedApproach() {
            try {
                await api.post('data/update-missed-approach', {
                    airport: this.airport.icao,
                })
            } catch (error) {

            }
            this.startMissedApproachTimer()
        },
        async triggerRunwayClosed(runways) {
            try {
                await api.post('data/update-runway-closed', {
                    airport: this.airport.icao,
                    runways: runways,
                })
            } catch (error) {

            }
            this.startClosedRunwaysTimer()
        },
        triggerVisualDepature(direction) {
            api.post('data/update-visual-depature', {
                airport: this.airport.icao,
                direction: direction,
            })
        },
        startMissedApproachTimer() {
            if (this.missedApporachInterval === null && this.missedApporachDisabled) {
                this.missedApporachInterval = setInterval(() => {
                    let timer = this.airport.missed_approach_timeout - Math.round((new Date()).getTime() / 1000)
                    if (timer <= 0) {
                        clearInterval(this.missedApporachInterval)
                        this.missedApporachInterval = null
                        this.$store.dispatch('loadData')

                        return
                    }
                }, 1000)
            }
        },
        startClosedRunwaysTimer() {
            if (this.closedRunwaysInterval === null && this.closedRunwaysDisabled) {
                this.closedRunwaysInterval = setInterval(() => {
                    let timer = this.airport.closed_runways_timeout - Math.round((new Date()).getTime() / 1000)
                    if (timer <= 0) {
                        clearInterval(this.closedRunwaysInterval)
                        this.closedRunwaysInterval = null
                        this.$store.dispatch('loadData')

                        return
                    }
                }, 1000)
            }
        },
    }
}
</script>