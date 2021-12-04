<template>
    <div class="max-w-7xl mx-auto py-3 sm:px-6 lg:px-8">
        <div class="relative h-[470px] px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6 xl:h-[600px]">
            <div class="flex justify-end">
                <div
                    v-if="eetn.missed_approach"
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
                    v-if="eetn.metar.wind_shear_runways"
                    class="rounded-md bg-red-50 py-4 px-6 ml-6"
                >
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="far fa-times-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Windshear on Runway {{ eetn.metar.wind_shear_runways.join(' & ') }}
                            </h3>
                        </div>
                    </div>
                </div>

                <div
                    v-if="eetn.metar.wind_shear_all_runways"
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
                    :class="{ 'bg-red-200 border-red-300': eetn.closed_runways.includes('08/26') }"
                >

                    <div
                        class="relative h-full flex items-center px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': eetn.closed_runways.includes('08/26') === false && (eetn.atis.arrival_runway.includes('08') || eetn.atis.depature_runway.includes('08')) }"
                    >
                        <div
                            v-if="eetn.atis.arrival_runway.includes('08') && eetn.closed_runways.includes('08/26') === false"
                            class="absolute left-[-40px] h-6 w-6 transform rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="eetn.atis.depature_runway.includes('08') && eetn.closed_runways.includes('08/26') === false"
                            class="absolute left-[90px] h-6 w-6 transform rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!eetn.metar.is_variable"
                            class="absolute top-[-50px] left-[20px] flex items-center text-gray-400 font-medium"
                        >
                            <span class="ml-1">
                                {{ eetn.wind_components['08'] }}
                            </span>
                        </div>
                        <span class="w-12">08</span>
                    </div>

                    <template v-if="eetn.closed_runways.includes('08/26')">
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
                            v-if="eetn.metar.rvr['08'] !== undefined"
                            class="text-center text-xl font-bold"
                        >
                            {{ eetn.metar.rvr['08'] }}
                        </div>

                        <template v-if="!eetn.metar.is_variable && eetn.metar.mean_direction">
                            <div class="transform rotate-40 text-center text-blue-300">
                                <i 
                                    class="fad fa-3x fa-location-circle"
                                    :style="windArrow"
                                >
                                </i>
                            </div>
                        </template>
                        <template v-else-if="eetn.metar.is_variable">
                            <div class="relative flex items-center justify-center text-blue-300">
                                <template v-if="eetn.metar.mean_speed >= 4">
                                    <i class="fad fa-3x fa-exclamation-circle"></i>
                                </template>
                                <template v-else>
                                    <i class="fad fa-3x fa-circle"></i>
                                </template>
                            </div>
                        </template>

                        <div
                            v-if="eetn.metar.rvr['26'] !== undefined"
                            class="text-center text-xl font-bold"
                        >
                            {{ eetn.metar.rvr['26'] }}
                        </div>
                    </template>

                    <div
                        class="relative h-full flex items-center px-4 py-5 text-center text-2xl font-black"
                        :class="{ 'rounded-lg bg-blue-200': eetn.closed_runways.includes('08/26') === false && (eetn.atis.arrival_runway.includes('26') || eetn.atis.depature_runway.includes('26')) }"
                    >

                        <div
                            v-if="eetn.atis.arrival_runway.includes('26') && eetn.closed_runways.includes('08/26') === false"
                            class="absolute right-[-40px] h-6 w-6 transform -rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-to-top"></i>
                        </div>
                        <div
                            v-if="eetn.atis.depature_runway.includes('26') && eetn.closed_runways.includes('08/26') === false"
                            class="absolute left-[-40px] h-6 w-6 transform -rotate-90"
                        >
                            <i class="far fa-lg fa-arrow-up"></i>
                        </div>

                        <div
                            v-if="!eetn.metar.is_variable"
                            class="absolute top-[-50px] right-[20px] flex items-center text-gray-400 font-medium"
                        >
                            <span class="ml-1">
                                {{ eetn.wind_components['26'] }}
                            </span>
                        </div>
                        <span class="w-12">26</span>
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
            eetn: computed(() => store.getters.eetn),
            windArrow: computed(() => {
                return {
                    transform: `rotate(${store.getters.eetn.metar.mean_direction - -105}deg)`
                }
            }),
        }
    },
}
</script>