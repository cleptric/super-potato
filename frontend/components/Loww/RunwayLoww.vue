<template>
    <div class="max-w-7xl mx-auto py-3 px-8">
        <div class="relative h-[500px] max-h-[500px] min-h-[200px] p-3 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-600 rounded-md overflow-hidden resize-y">
            <div class="flex justify-end">

                <MissedApproachBanner
                    :airport="loww"
                    class="mr-3"
                />

                <WindShearBanner
                    :airport="loww"
                />

            </div>

            <div class="absolute top-0 right-0 bottom-0 left-0 flex items-center justify-center">
                <div
                    class="w-[500px] h-[100px] flex items-center justify-between border border-gray-300 dark:border-zinc-400 rounded-md"
                    :class="{ 'bg-red-200 border-red-300': loww.closed_runways.includes('11/29') }"
                >

                    <div
                        class="relative h-full flex items-center p-4 text-center text-xl font-black"
                        :class="{ 'rounded-l-md bg-blue-200 dark:bg-blue-500': loww.closed_runways.includes('11/29') === false && (loww.atis.arrival_runway.includes('29') || loww.atis.depature_runway.includes('29')) }"
                    >
                        <div
                            v-if="loww.atis.arrival_runway.includes('29') && loww.closed_runways.includes('11/29') === false"
                            class="absolute left-[-40px] h-6 w-6 rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>
                        <div
                            v-if="loww.atis.depature_runway.includes('29') && loww.closed_runways.includes('11/29') === false"
                            class="absolute left-[90px] h-6 w-6 rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!loww.metar.is_variable"
                            class="absolute top-[-40px] left-[20px] flex items-center text-lg text-gray-400 dark:text-zinc-300 font-medium"
                        >
                            <span class="ml-1">
                                {{ loww.wind_components['29'] }}
                            </span>
                        </div>
                        <span class="-rotate-90">29</span>
                    </div>

                    <template v-if="loww.closed_runways.includes('11/29')">
                        <div class="text-center">
                            <i class="far fa-2x fa-times text-red-800"></i>
                        </div>
                        <div class="text-center">
                            <i class="far fa-2x fa-times text-red-800"></i>
                        </div>
                        <div class="text-center">
                            <i class="far fa-2x fa-times text-red-800"></i>
                        </div>
                        <div class="text-center">
                            <i class="far fa-2x fa-times text-red-800"></i>
                        </div>
                    </template>
                    <template v-else>
                        <div
                            v-if="loww.metar.rvr['34'] !== undefined"
                            class="text-center text-xl font-bold"
                        >
                            {{ loww.metar.rvr['34'] }}
                        </div>

                        <template v-if="!loww.metar.is_variable && loww.metar.mean_direction">
                            <div class="flex items-center rotate-[-40deg] text-center text-blue-300 dark:text-blue-500">
                                <i 
                                    class="fad fa-2x fa-location-circle"
                                    :style="windArrow1129"
                                >
                                </i>
                            </div>
                        </template>
                        <template v-else-if="loww.metar.is_variable">
                            <div class="relative flex items-center justify-center text-blue-300 dark:text-blue-500">
                                <template v-if="loww.metar.mean_speed >= 4">
                                    <i class="fad fa-2x fa-exclamation-circle"></i>
                                </template>
                                <template v-else>
                                    <i class="fad fa-2x fa-circle"></i>
                                </template>
                            </div>
                        </template>

                        <div
                            v-if="loww.metar.rvr['16'] !== undefined"
                            class="text-center text-lg font-bold"
                        >
                            {{ loww.metar.rvr['16'] }}
                        </div>
                    </template>

                    <div
                        class="relative h-full flex items-center p-4 text-center text-xl font-black"
                        :class="{ 'rounded-r-md bg-blue-200 dark:bg-blue-500': loww.closed_runways.includes('11/29') === false && (loww.atis.arrival_runway.includes('11') || loww.atis.depature_runway.includes('11')) }"
                    >
                        <div
                            v-if="loww.atis.arrival_runway.includes('11') && loww.closed_runways.includes('11/29') === false"
                            class="absolute right-[-40px] h-6 w-6 -rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>
                        <div
                            v-if="loww.atis.depature_runway.includes('11') && loww.closed_runways.includes('11/29') === false"
                            class="absolute left-[-40px] h-6 w-6 -rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!loww.metar.is_variable"
                            class="absolute top-[-40px] right-[20px] flex items-center text-gray-400 dark:text-zinc-300 text-lg font-medium"
                        >
                            <span class="ml-1">
                                {{ loww.wind_components['11'] }}
                            </span>
                        </div>
                        <span class="-rotate-90">11</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import MissedApproachBanner from '@/components/Runways/MissedApproachBanner.vue'
import WindShearBanner from '@/components/Runways/WindShearBanner.vue'

export default {
    name: 'Runway',
    components: {
        MissedApproachBanner,
        WindShearBanner,
    },
    setup () {
        const store = useStore()

        return {
            loww: computed(() => store.getters.loww),
            windArrow1129: computed(() => {
                return {
                    transform: `rotate(${store.getters.loww.metar.mean_direction - 15}deg)`
                }
            }),
        }
    },
}
</script>