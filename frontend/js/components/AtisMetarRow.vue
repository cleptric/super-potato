<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-6">
            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    ATIS Information
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ loww.atis.atis_letter }}
                </dd>
            </div>

            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Transition Level
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    FL {{ loww.atis.transition_level }}
                </dd>
            </div>

            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    QNH
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ loww.metar.qnh_value }}
                    <span class="text-lg font-medium text-gray-500">
                        {{ loww.metar.qnh_unit }}
                    </span>
                </dd>
            </div>
            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Wind
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ loww.metar.mean_direction }}° / {{ loww.metar.mean_speed }}kts
                </dd>
            </div>
            <div
                v-if="loww.metar.speed_variations"
                class="p-4 bg-white shadow rounded-lg overflow-hidden"
            >
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Maximum
                </dt>
                <dd class="flex items-center mt-1 text-2xl font-semibold text-gray-900">
                    {{ loww.metar.speed_variations }}kts
                </dd>
            </div>
            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Conditions
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ loww.metar.condition }}
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
    setup () {
        const store = useStore()

        return {
            loww: computed(() => store.getters.loww),
        }
    },
}
</script>