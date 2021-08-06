<template>
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="relative h-[470px] px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 xl:h-[600px]">
            <div class="flex justify-end">
                <div
                    v-if="eddm.missed_approach"
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
                    v-if="eddm.metar.wind_shear_runways"
                    class="rounded-md bg-red-50 py-4 px-6 ml-6"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="far fa-times-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Windshear on Runway {{ eddm.metar.wind_shear.join(' & ') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div
                    v-if="eddm.metar.wind_shear_all_runways"
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

            <div class="absolute top-0 right-0 bottom-0 left-0 flex flex-col items-center justify-evenly">
                <div
                    class="w-[850px] h-[120px] flex items-center justify-between border border-gray-300 rounded-lg"
                    :class="{ 'bg-red-200 border-red-300': eddm.closed_runways.includes('08L/26R') }"
                >
                    <div
                        class="relative px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': eddm.closed_runways.includes('08L/26R') === false && (eddm.atis.arrival_runway.includes('08L') || eddm.atis.depature_runway.includes('26R')) }"
                    >
                        <div
                            v-if="eddm.atis.arrival_runway.includes('08L') && eddm.closed_runways.includes('08L/26R') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="eddm.atis.depature_runway.includes('08L') && eddm.closed_runways.includes('08L/26R') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!eddm.metar.is_variable"
                            class="absolute top-[-70px] left-[20px] flex items-center text-gray-400 font-medium"
                        >
                            <span class="ml-1">
                                {{ eddm.wind_components['08L'] }}
                            </span>
                        </div>
                        <span class="w-12">08L</span>
                    </div>

                    <template v-if="eddm.closed_runways.includes('08L/26R')">
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
                    <template v-else-if="!eddm.metar.is_variable && eddm.metar.mean_direction">
                        <div class="transform rotate-40 text-center text-blue-300">
                            <i 
                                class="fad fa-3x fa-location-circle"
                                :style="windArrow08L26R"
                            >
                            </i>
                        </div>
                    </template>
                    <template v-else-if="eddm.metar.is_variable">
                        <div class="relative flex items-center justify-center text-blue-300">
                            <template v-if="eddm.metar.mean_speed >= 4">
                                <i class="fad fa-3x fa-exclamation-circle"></i>
                            </template>
                            <template v-else>
                                <i class="fad fa-3x fa-circle"></i>
                            </template>
                        </div>
                    </template>

                    <div
                        class="relative px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': eddm.closed_runways.includes('08L/26R') === false && (eddm.atis.arrival_runway.includes('26R') || eddm.atis.depature_runway.includes('26R')) }"
                    >
                        <div
                            v-if="eddm.atis.arrival_runway.includes('26R') && eddm.closed_runways.includes('08L/26R') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="eddm.atis.depature_runway.includes('26R') && eddm.closed_runways.includes('08L/26R') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%);"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!eddm.metar.is_variable"
                            class="absolute top-[-70px] right-[20px] flex items-center text-gray-400 font-medium"
                        >
                            <span class="ml-1">
                                {{ eddm.wind_components['26R'] }}
                            </span>
                        </div>
                        <span class="w-12">26R</span>
                    </div>
                </div>
                <div
                    class="w-[850px] h-[120px] flex items-center justify-between border border-gray-300 rounded-lg"
                    :class="{ 'bg-red-200 border-red-300': eddm.closed_runways.includes('08R/26L') }"
                >

                    <div
                        class="relative px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': eddm.closed_runways.includes('08R/26L') === false && (eddm.atis.arrival_runway.includes('08R') || eddm.atis.depature_runway.includes('08R')) }"
                    >
                        <div
                            v-if="eddm.atis.arrival_runway.includes('08R') && eddm.closed_runways.includes('08R/26L') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="eddm.atis.depature_runway.includes('08R') && eddm.closed_runways.includes('08R/26L') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%) rotate(180deg);"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!eddm.metar.is_variable"
                            class="absolute top-[-70px] left-[20px] flex items-center text-gray-400 font-medium"
                        >
                            <span class="ml-1">
                                {{ eddm.wind_components['08R'] }}
                            </span>
                        </div>
                        <span class="w-12">08R</span>
                    </div>

                    <template v-if="eddm.closed_runways.includes('08R/26L')">
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
                    <template v-else-if="!eddm.metar.is_variable && eddm.metar.mean_direction">
                        <div class="transform rotate-40 text-center text-blue-300">
                            <i 
                                class="fad fa-3x fa-location-circle"
                                :style="windArrow08R26L"
                            >
                            </i>
                        </div>
                    </template>
                    <template v-else-if="eddm.metar.is_variable">
                        <div class="relative flex items-center justify-center text-blue-300">
                            <template v-if="eddm.metar.mean_speed >= 4">
                                <i class="fad fa-3x fa-exclamation-circle"></i>
                            </template>
                            <template v-else>
                                <i class="fad fa-3x fa-circle"></i>
                            </template>
                        </div>
                    </template>

                    <div
                        class="relative px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': eddm.closed_runways.includes('08R/26L') === false && (eddm.atis.arrival_runway.includes('26L') || eddm.atis.depature_runway.includes('26L')) }"
                    >
                        <div
                            v-if="eddm.atis.arrival_runway.includes('26L') && eddm.closed_runways.includes('08R/26L') === false"
                            class="absolute h-6 w-6"
                            style="bottom: -40px; right: 50%; transform: translateX(50%);"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="eddm.atis.depature_runway.includes('26L') && eddm.closed_runways.includes('08R/26L') === false"
                            class="absolute h-6 w-6"
                            style="top: -40px; right: 50%; transform: translateX(50%)"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!eddm.metar.is_variable"
                            class="absolute top-[-70px] right-[20px] flex items-center text-gray-400 font-medium"
                        >
                            <span class="ml-1">
                                {{ eddm.wind_components['26L'] }}
                            </span>
                        </div>
                        <span class="w-12">26L</span>
                    </div>
                </div>
            </div>
        </div>
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
            eddm: computed(() => store.getters.eddm),
            windArrow08L26R: computed(() => {
                return {
                    transform: `rotate(${store.getters.eddm.metar.mean_direction - -105}deg)`
                }
            }),
            windArrow08R26L: computed(() => {
                return {
                    transform: `rotate(${store.getters.eddm.metar.mean_direction - -105}deg)`
                }
            }),
        }
    },
}
</script>