<template>
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <template v-if="!lowi.atis.outdated">
            <div class="relative h-[470px] px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 xl:h-[600px]">
                <div class="flex justify-end">
                    <div
                        v-if="lowi.missed_approach"
                        class="rounded-md bg-yellow-50 py-4 px-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="far fa-plane-departure text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Missed Approach
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="lowi.metar.wind_shear_runways"
                        class="rounded-md bg-red-50 py-4 px-6 ml-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="far fa-times-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Windshear on Runway {{ lowi.metar.wind_shear.join(' & ') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="lowi.metar.wind_shear_all_runways"
                        class="rounded-md bg-red-50 py-4 px-6 ml-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="far fa-times-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Windshear on all Runways
                                </h3>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="absolute top-0 right-0 bottom-0 left-0 flex items-center justify-center">
                    <div
                        class="w-[850px] h-[120px] flex items-center justify-between border border-gray-300 rounded-lg"
                        :class="{ 'bg-red-200 border-red-300': lowi.closed_runways.includes('08/26') }"
                    >

                        <div
                            class="relative h-full flex items-center px-4 py-5 text-center text-2xl font-black"
                            :class="{ 'rounded-lg bg-blue-200': lowi.closed_runways.includes('08/26') === false && (lowi.atis.arrival_runway.includes('08') || lowi.atis.depature_runway.includes('08')) }"
                        >
                            <div
                                v-if="lowi.atis.arrival_runway.includes('08') && lowi.closed_runways.includes('08/26') === false"
                                class="absolute left-[-40px] h-6 w-6 transform rotate-90"
                            >
                                <i class="far fa-lg fa-arrow-to-top"></i>
                            </div>
                            <div
                                v-if="lowi.atis.depature_runway.includes('08') && lowi.closed_runways.includes('08/26') === false"
                                class="absolute left-[80px] h-6 w-6 transform rotate-90"
                            >
                                <i class="far fa-lg fa-arrow-up"></i>
                            </div>

                            <div
                                v-if="!lowi.metar.is_variable"
                                class="absolute top-[-50px] left-[20px] flex items-center text-gray-400 font-medium"
                            >
                                <span class="ml-1">
                                    {{ windComponent(lowi.wind_components[8]) }}
                                </span>
                            </div>
                            <span class="transform -rotate-90">08</span>
                        </div>

                        <template v-if="lowi.closed_runways.includes('08/26')">
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
                        <template v-else-if="!lowi.metar.is_variable">
                            <div class="flex items-center transform rotate-40 text-center text-blue-300">
                                <i 
                                    class="fad fa-3x fa-location-circle"
                                    :style="windArrow0826"
                                >
                                </i>
                            </div>
                        </template>

                        <div
                            class="relative h-full flex items-center px-4 py-5 text-center text-2xl font-black"
                            :class="{ 'rounded-lg bg-blue-200': lowi.closed_runways.includes('08/26') === false && (lowi.atis.arrival_runway.includes('26') || lowi.atis.depature_runway.includes('26')) }"
                        >
                            <div
                                v-if="lowi.atis.arrival_runway.includes('26') && lowi.closed_runways.includes('08/26') === false"
                                class="absolute right-[-40px] h-6 w-6 transform -rotate-90"
                            >
                                <i class="far fa-lg fa-arrow-to-top"></i>
                            </div>
                            <div
                                v-if="lowi.atis.depature_runway.includes('26') && lowi.closed_runways.includes('08/26') === false"
                                class="absolute left-[-40px] h-6 w-6 transform -rotate-90"
                            >
                                <i class="far fa-lg fa-arrow-up"></i>
                            </div>

                            <div
                                v-if="!lowi.metar.is_variable"
                                class="absolute top-[-50px] right-[20px] flex items-center text-gray-400 font-medium"
                            >
                                <span class="ml-1">
                                    {{ windComponent(lowi.wind_components[26]) }}
                                </span>
                            </div>
                            <span class="transform -rotate-90">26</span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="relative flex items-start justify-center h-[470px] px-4 py-5 bg-gray-100 rounded-lg overflow-hidden sm:p-6 xl:h-[600px]">
                <h2 class="z-10 bg-gray-200 mt-8 py-4 px-8 rounded-lg text-lg font-semibold text-gray-500 xl:text-xl">
                    Data unavailable
                </h2>
                <div class="absolute top-0 right-0 bottom-0 left-0 flex items-center justify-center">
                    <div
                        class="w-[850px] h-[120px] flex items-center justify-between border border-gray-200 rounded-lg"
                        :class="{ 'bg-red-200 border-red-300': lowi.closed_runways.includes('08/26') }"
                    >
                        <div class="relative h-full flex items-center px-4 py-5 text-center text-2xl font-black text-gray-400">
                            <span class="transform -rotate-90">08</span>
                        </div>

                        <div class="relative h-full flex items-center px-4 py-5 text-center text-2xl font-black text-gray-400">
                            <span class="transform -rotate-90">26</span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'Runway',
    setup () {
        const store = useStore()

        return {
            lowi: computed(() => store.getters.lowi),
            windArrow0826: computed(() => {
                return {
                    transform: `rotate(${store.getters.lowi.metar.mean_direction - -105}deg)`
                }
            }),
        }
    },
    methods: {
        windComponent(winds) {
            let headTailWind = null
            if (winds.head_tail_wind > 0) {
                headTailWind = `H${Math.abs(winds.head_tail_wind)}`
            } else {
                headTailWind = `T${Math.abs(winds.head_tail_wind)}`
            }

            return `X${winds.cross_wind}/${headTailWind}`;
        },
    }
}
</script>