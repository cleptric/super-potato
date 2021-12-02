<template>
    <header class="hidden bg-white shadow-sm xl:block">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                {{ eddm.atis.airport_name }}
            </h1>
        </div>
    </header>

    <main>
        <AtisMetarRow
            :airport="eddm"
        />

        <RunwayEddm />

        <Actions
            :airport="eddm"
        />

        <RawMetar
            :airport="eddm"
        />

        <RawTaf
            :airport="eddm"
        />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import RunwayEddm from '@/components/Eddm/RunwayEddm.vue'
import Actions from '@/components/Actions.vue'
import RawMetar from '@/components/RawMetar.vue'
import RawTaf from '@/components/RawTaf.vue'

export default {
    name: 'Loww',
    components: {
        AtisMetarRow,
        RunwayEddm,
        Actions,
        RawMetar,
        RawTaf,
    },
    setup () {
        const store = useStore()

        return {
            eddm: computed(() => store.getters.eddm),
        }
    },
}
</script>