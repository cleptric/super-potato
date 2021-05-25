<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="my-3 grid grid-cols-1 gap-3">
            <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    METAR
                </dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                    {{ airport.metar.raw_metar }}
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
    props: {
        airport: Object
    },
}
</script>