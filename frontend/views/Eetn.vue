<template>
    <header class="hidden bg-white shadow-sm xl:block">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                {{ eetn.atis.airport_name }}
            </h1>
        </div>
    </header>

    <main>
        <AtisMetarRow
            :airport="eetn"
        />

        <RunwayEetn />

        <Actions
            :airport="eetn"
        />

        <RawMetar
            :airport="eetn"
        />

        <RawTaf
            :airport="eetn"
        />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import RunwayEetn from '@/components/Eetn/RunwayEetn.vue'
import Actions from '@/components/Actions.vue'
import RawMetar from '@/components/RawMetar.vue'
import RawTaf from '@/components/RawTaf.vue'

export default {
    name: 'Eetn',
    components: {
        AtisMetarRow,
        RunwayEetn,
        Actions,
        RawMetar,
        RawTaf,
    },
    setup () {
        const store = useStore()

        return {
            eetn: computed(() => store.getters.eetn),
        }
    },
}
</script>