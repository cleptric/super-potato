<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    ATIS Information
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ loww.atis.atis_letter }}
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Transition Level
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    FL {{ loww.atis.transition_level }}
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    QNH
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    {{ loww.metar.qnh_value }}
                    <span class="text-lg font-medium text-gray-500">
                        {{ loww.metar.qnh_unit }}
                    </span>
                </dd>
            </div>

            <div class="px-4 py-5 bg-white shadow rounded-lg overflow-hidden sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Source
                </dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    VATSIM ATIS
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