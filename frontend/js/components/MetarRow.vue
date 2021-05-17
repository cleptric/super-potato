<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-4">
            <div class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute text-center bg-blue-200 rounded-md p-3">
                        <i class="far fa-lg fa-windsock w-6 text-blue-500"></i>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Wind
                    </p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ loww.metar.mean_direction }}° / {{ loww.metar.mean_speed }}kts
                    </p>
                </dd>
            </div>
            <div
                v-if="loww.metar.speed_variations"
                class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden"
            >
                <dt>
                    <div class="absolute text-center bg-blue-200 rounded-md p-3">
                        <i class="far fa-lg fa-wind-warning w-6 text-blue-500"></i>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Maximum
                    </p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ loww.metar.speed_variations }}kts
                    </p>
                </dd>
            </div>
            <div
                v-if="loww.metar.direction_variations.from && loww.metar.direction_variations.to"
                class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden"
            >
                <dt>
                    <div class="absolute text-center bg-blue-200 rounded-md p-3">
                        <i class="far fa-lg fa-wind w-6 text-blue-500"></i>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Variable Wind
                    </p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ loww.metar.direction_variations.from }} / {{ loww.metar.direction_variations.to }}
                    </p>
                </dd>
            </div>
            <div class="relative bg-white pt-5 px-4 pb-5 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
                <dt>
                    <div class="absolute text-center bg-blue-200 rounded-md p-3">
                        <i class="far fa-lg fa-clouds w-6 text-blue-500"></i>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">
                        Conditions
                    </p>
                </dt>
                <dd class="ml-16 flex items-baseline">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ loww.metar.condition }}
                    </p>
                </dd>
            </div>
        </dl>
    </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'AtisRow',
    setup () {
        const store = useStore()

        return {
            loww: computed(() => store.getters.loww),
        }
    },
}
</script>