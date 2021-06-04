<template>
    <header class="hidden bg-white shadow-sm xl:block">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                {{ lowl.atis.airport_name }}
            </h1>
        </div>
    </header>

    <main>
        <AtisMetarRow
            :airport="lowl"
        />

        <RunwayLowl />

        <Actions
            :airport="lowl"
        />

        <RawMetar
            :airport="lowl"
        />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import RunwayLowl from '@/components/Lowl/RunwayLowl.vue'
import Actions from '@/components/Actions.vue'
import RawMetar from '@/components/RawMetar.vue'

export default {
    name: 'Lowl',
    components: {
        AtisMetarRow,
        RunwayLowl,
        Actions,
        RawMetar,
    },
    setup () {
        const store = useStore()

        return {
            lowl: computed(() => store.getters.lowl),
        }
    },
}
</script>