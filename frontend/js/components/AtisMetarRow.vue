<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-3 grid grid-cols-6 gap-3">
            <template v-if="!airport.atis.outdated">
                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        ATIS Information
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                        {{ airport.atis.atis_letter }}
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        ATIS Information
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        Data unavailable
                    </dd>
                </div>
            </template>

            <template v-if="!airport.atis.outdated">
                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Transition Level
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                        {{ airport.atis.transition_level }}
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        Transition Level
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        Data unavailable
                    </dd>
                </div>
            </template>

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
            <div
                v-if="airport.metar.speed_variations"
                class="p-3 bg-white shadow rounded-lg overflow-hidden"
            >
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Maximum
                </dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                    {{ airport.metar.speed_variations }}kts
                </dd>
            </div>
            <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Conditions
                </dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                    {{ airport.metar.condition }}
                </dd>
            </div>
        </dl>
    </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'AtisMetarRow',
    props: {
        airport: Object
    },
}
</script>