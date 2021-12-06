<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="my-3 grid grid-cols-1 gap-3">
            <div class="p-4 bg-white border border-gray-200 rounded-md overflow-hidden">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    TAF
                </dt>
                <dd class="mt-1 text-xl font-semibold text-gray-900">
                    <template v-if="airport.taf">
                        {{ airport.taf }}
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
        </dl>
    </div>
</template>

<script>
export default {
    name: 'RawTaf',
    props: {
        airport: Object
    },
}
</script>