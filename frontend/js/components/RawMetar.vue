<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-5 grid grid-cols-1 gap-5">
            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    METAR
                </dt>
                <dd class="mt-1 text-2xl font-semibold text-gray-900">
                    {{ loww.metar.raw_metar }}
                </dd>
            </div>
        </dl>
    </div>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
    name: 'RawMetar',
    setup () {
        const store = useStore()

        return {
            loww: computed(() => store.getters.loww),
        }
    },
}
</script>