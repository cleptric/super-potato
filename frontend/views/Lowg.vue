<template>
    <header class="hidden bg-white shadow-sm xl:block">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                {{ lowg.atis.airport_name }}
            </h1>
        </div>
    </header>

    <main>
        <AtisMetarRow
            :airport="lowg"
        />

        <RunwayLowg />

        <Actions
            :airport="lowg"
        />

        <RawMetar
            :airport="lowg"
        />

        <RawTaf
            :airport="lowg"
        />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import RunwayLowg from '@/components/Lowg/RunwayLowg.vue'
import Actions from '@/components/Actions.vue'
import RawMetar from '@/components/RawMetar.vue'
import RawTaf from '@/components/RawTaf.vue'

export default {
    name: 'Lowg',
    components: {
        AtisMetarRow,
        RunwayLowg,
        Actions,
        RawMetar,
        RawTaf,
    },
    setup () {
        const store = useStore()

        return {
            lowg: computed(() => store.getters.lowg),
        }
    },
}
</script>