<template>
    <div class="max-w-7xl mx-auto px-8">
        <dl class="grid grid-cols-4 gap-3">

            <div class="p-2 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-600 rounded-md">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    Runway Closed
                </dt>
                <dd class="mt-2">
                    <template v-if="closedRunwaysDisabled">
                        <span class="relative z-0 inline-flex rounded-md">
                            <span
                                class="relative inline-flex items-center pointer-events-none px-3 py-1.5 rounded-md border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-sm font-medium text-gray-700 dark:text-zinc-100 opacity-50"
                            >
                                In progress...
                            </span>
                        </span>
                    </template>
                    <template v-else>
                        <span
                            class="relative z-0 inline-flex rounded-md"
                        >
                            <button
                                v-for="(runway, index) in airport.runways"
                                :key="index"
                                @click="triggerRunwayClosed(runway)"
                                class="relative inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-900 text-sm font-medium text-gray-700 dark:text-zinc-100 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
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

            <div class="p-2 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-600 rounded-md">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    Missed Approach
                </dt>
                <dd class="mt-2">
                    <template v-if="missedApporachDisabled">
                        <span
                            class="button button-secondary pointer-events-none opacity-50"
                        >
                            In progress...
                        </span>
                    </template>
                    <template v-else>
                        <button
                            v-if="airport.missed_approach"
                            @click="triggerMissedApproach"
                            class="button button-secondary"
                        >
                            Remove Notification
                        </button>
                        <button
                            v-else
                            @click="triggerMissedApproach"
                            class="button button-secondary"
                        >
                            Trigger Notification
                        </button>
                    </template>
                </dd>
            </div>

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