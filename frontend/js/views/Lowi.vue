<template>
    <header class="hidden bg-white shadow-sm xl:block">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                {{ lowi.atis.airport_name }}
            </h1>
        </div>
    </header>

    <main>
        <AtisMetarRow
            :airport="lowi"
        />

        <RunwayLowi />

        <ActionsLowi />

        <RawMetar
            :airport="lowi"
        />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import RunwayLowi from '@/components/Lowi/RunwayLowi.vue'
import ActionsLowi from '@/components/Lowi/ActionsLowi.vue'
import RawMetar from '@/components/RawMetar.vue'

export default {
    name: 'Lowi',
    components: {
        AtisMetarRow,
        RunwayLowi,
        ActionsLowi,
        RawMetar,
    },
    setup () {
        const store = useStore()

        return {
            lowi: computed(() => store.getters.lowi),
        }
    },
}
</script>