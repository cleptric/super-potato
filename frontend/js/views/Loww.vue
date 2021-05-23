<template>
    <header class="hidden bg-white shadow-sm xl:block">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <h1 class="text-lg leading-6 font-semibold text-gray-900">
                {{ loww.atis.airport_name }}
            </h1>
        </div>
    </header>

    <main>
        <AtisMetarRow />

        <Runway />

        <Actions />
        <RawMetar />
    </main>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'

import AtisMetarRow from '@/components/AtisMetarRow.vue'
import Runway from '@/components/Runway.vue'
import Actions from '@/components/Actions.vue'
import RawMetar from '@/components/RawMetar.vue'

export default {
    name: 'Loww',
    components: {
        AtisMetarRow,
        Runway,
        Actions,
        RawMetar,
    },
    setup () {
        const store = useStore()

        return {
            loww: computed(() => store.getters.loww),
        }
    },
}
</script>