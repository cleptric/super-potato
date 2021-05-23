<template>
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <template v-if="!loww.atis.outdated">
            <div class="relative h-[470px] px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 xl:h-[600px]">
                <div class="flex justify-end">
                    <div
                        v-if="loww.missed_approach"
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
                        v-if="loww.metar.wind_shear_runways"
                        class="rounded-md bg-red-50 py-4 px-6 ml-6"
                    >
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="far fa-times-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Windshear on Runway {{ loww.metar.wind_shear.join(' & ') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div
                        v-if="loww.metar.wind_shear_all_runways"
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

                <div
                    class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-300 rounded-lg transform -rotate-40" style="left: 220px; top: 40px;"
                    :class="{ 'bg-red-200 border-red-300': loww.closed_runways.includes('16/34') }"
                >
                    <div
                        v-if="loww.visual_depature.includes('west')"
                        class="absolute w-[155px] flex items-center text-md font-medium transform rotate-90" style="top: 50%; right: -110px; transform: translateY(50%) rotate(90deg);"
                    >
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                          <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                          </svg>
                          Visual Departure
                        </span>
                    </div>
                    <div
                        v-if="loww.visual_depature.includes('east')"
                        class="absolute w-[155px] flex items-center text-md font-medium transform rotate-90" style="top: 50%; right: 80px; transform: translateY(50%) rotate(90deg);"
                    >
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                          <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                          </svg>
                          Visual Departure
                        </span>
                    </div>

                    <div
                        class="relative x-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': loww.closed_runways.includes('16/34') === false && (loww.atis.arrival_runway.includes('34') || loww.atis.depature_runway.includes('34')) }"
                    >
                        <div
                            v-if="loww.atis.arrival_runway.includes('34') && loww.closed_runways.includes('16/34') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="loww.atis.depature_runway.includes('34') && loww.closed_runways.includes('16/34') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div class="absolute flex items-center text-gray-400 font-medium transform rotate-40" style="top: 40px; right: -100px;">
                            <span class="ml-1">
                                {{ windComponent(loww.wind_components[34]) }}
                            </span>
                        </div>
                        <!-- <div class="absolute flex items-center text-yellow-400 text-md font-medium transform rotate-40" style="top: 10px; left: -80px;">
                            <i class="far fa-location-circle" style="transform: rotate(45deg);"></i>
                            <span class="ml-1">12 C</span>
                        </div> -->
                        34
                    </div>

                    <template v-if="loww.closed_runways.includes('16/34')">
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
                        <div class="transform rotate-40 text-center text-blue-300">
                            <i 
                                class="fad fa-3x fa-location-circle"
                                :style="windArrow1634"
                            >
                            </i>
                        </div>
                    </template>

                    <div
                        class="relative px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': loww.closed_runways.includes('16/34') === false && (loww.atis.arrival_runway.includes('16') || loww.atis.depature_runway.includes('16')) }"
                    >
                        <div
                            v-if="loww.atis.arrival_runway.includes('16') && loww.closed_runways.includes('16/34') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="loww.atis.depature_runway.includes('16') && loww.closed_runways.includes('16/34') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%);"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div class="absolute flex items-center text-gray-400 font-medium transform rotate-40" style="top: 0px; left: -100px;">
                            <span class="ml-1">
                                {{ windComponent(loww.wind_components[16]) }}
                            </span>
                        </div>
                        16
                    </div>
                </div>
                <div
                    class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-300 rounded-lg transform -rotate-90" style="right: 300px; bottom: 0px;"
                    :class="{ 'bg-red-200 border-red-300': loww.closed_runways.includes('29/11') }"
                >
                    <div
                        v-if="loww.visual_depature.includes('south')"
                        class="absolute w-[155px] flex items-center text-md font-medium transform rotate-90" style="top: 50%; right: -110px; transform: translateY(50%) rotate(90deg);"
                    >
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                          <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                          </svg>
                          Visual Departure
                        </span>
                    </div>
                    <div
                        v-if="loww.visual_depature.includes('north')"
                        class="absolute w-[155px] flex items-center text-md font-medium transform rotate-90" style="top: 50%; right: 80px; transform: translateY(50%) rotate(90deg);"
                    >
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800">
                          <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                          </svg>
                          Visual Departure
                        </span>
                    </div>

                    <div
                        class="relative px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': loww.closed_runways.includes('29/11') === false && (loww.atis.arrival_runway.includes('29') || loww.atis.depature_runway.includes('29')) }"
                    >
                        <div
                            v-if="loww.atis.arrival_runway.includes('29') && loww.closed_runways.includes('29/11') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="loww.atis.depature_runway.includes('29') && loww.closed_runways.includes('29/11') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div class="absolute flex items-center text-gray-400 font-medium transform rotate-90" style="top: 30px; right: -70px;">
                            <span class="ml-1">
                                {{ windComponent(loww.wind_components[29]) }}
                            </span>
                        </div>
                        29
                    </div>

                    <template v-if="loww.closed_runways.includes('29/11')">
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
                        <div class="transform rotate-40 text-center text-blue-300">
                            <i 
                                class="fad fa-3x fa-location-circle"
                                :style="windArrow1129"
                            >
                            </i>
                        </div>
                    </template>

                    <div
                        class="relative px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': loww.closed_runways.includes('29/11') === false && (loww.atis.arrival_runway.includes('11') || loww.atis.depature_runway.includes('11')) }"
                    >
                        <div
                            v-if="loww.atis.arrival_runway.includes('11') && loww.closed_runways.includes('29/11') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="loww.atis.depature_runway.includes('11') && loww.closed_runways.includes('29/11') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%)"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div class="absolute flex items-center text-gray-400 font-medium transform rotate-90" style="top: 10px; right: -70px;">
                            <span class="ml-1">
                                {{ windComponent(loww.wind_components[11]) }}
                            </span>
                        </div>
                        11
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="relative flex items-start justify-center h-[470px] px-4 py-5 bg-gray-100 rounded-lg overflow-hidden sm:p-6 xl:h-[600px]">
                <h2 class="z-10 bg-gray-200 mt-8 py-4 px-8 rounded-lg text-lg font-semibold text-gray-500 xl:text-xl">
                    Data unavailable
                </h2>
                <div class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-200 rounded-lg transform -rotate-40" style="left: 220px; top: 40px;">

                    <div class="relative x-4 py-5 text-center text-2xl font-black text-gray-400">
                        34
                    </div>
                    <div class="relative px-4 py-5 text-center text-2xl font-black text-gray-400">
                        16
                    </div>
                </div>
                <div class="absolute w-[120px] h-[550px] flex flex-col justify-between border border-gray-200 rounded-lg transform -rotate-90" style="right: 300px; bottom: 0px;">
                    <div class="relative px-4 py-5 text-center text-2xl font-black text-gray-400">
                        29
                    </div>
                    <div class="relative px-4 py-5 text-center text-2xl font-black text-gray-400">
                        11
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
            loww: computed(() => store.getters.loww),
            windArrow1634: computed(() => {
                return {
                    transform: `rotate(${store.getters.loww.metar.mean_direction - 65}deg)`
                }
            }),
            windArrow1129: computed(() => {
                return {
                    transform: `rotate(${store.getters.loww.metar.mean_direction - 15}deg)`
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