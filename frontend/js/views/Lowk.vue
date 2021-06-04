<template>
    <header class="hidden bg-white shadow-sm xl:block">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                {{ lowk.atis.airport_name }}
            </h1>
        </div>
    </header>

    <main>
        <AtisMetarRow
            :airport="lowk"
        />

        <RunwayLowk />

        <Actions
            :airport="lowk"
        />

        <RawMetar
            :airport="lowk"
        />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import RunwayLowk from '@/components/Lowk/RunwayLowk.vue'
import Actions from '@/components/Actions.vue'
import RawMetar from '@/components/RawMetar.vue'

export default {
    name: 'Lowk',
    components: {
        AtisMetarRow,
        RunwayLowk,
        Actions,
        RawMetar,
    },
    setup () {
        const store = useStore()

        return {
            lowk: computed(() => store.getters.lowk),
        }
    },
}
</script>