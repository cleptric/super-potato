<template>
    <main>
        <AtisMetarRow
            :airport="loww"
        />

        <RunwayLoww />

        <Actions
            :airport="loww"
        />

        <RawMetar
            :airport="loww"
        />

        <RawTaf
            :airport="loww"
        />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import RunwayLoww from '@/components/Loww/RunwayLoww.vue'
import Actions from '@/components/Actions.vue'
import RawMetar from '@/components/RawMetar.vue'
import RawTaf from '@/components/RawTaf.vue'

export default {
    name: 'Loww',
    components: {
        AtisMetarRow,
        RunwayLoww,
        Actions,
        RawMetar,
        RawTaf,
    },
    setup () {
        const store = useStore()

        return {
            loww: computed(() => store.getters.loww),
        }
    },
}
</script>