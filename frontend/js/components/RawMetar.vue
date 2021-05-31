<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="my-3 grid grid-cols-1 gap-3">
            <template v-if="airport.metar.raw_metar">
                <div class="p-4 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        METAR
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                        {{ airport.metar.raw_metar }}
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        METAR
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        Data unavailable
                    </dd>
                </div>
            </template>
        </dl>
    </div>
</template>

<script>
export default {
    name: 'RawMetar',
    props: {
        airport: Object
    },
}
</script>