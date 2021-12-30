<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="my-3 grid grid-cols-1 gap-3">
            <div class="p-3 bg-white dark:bg-zinc-900 border border-gray-200 dark:border-zinc-600 rounded-md overflow-hidden">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300 truncate">
                    TAF
                </dt>
                <dd class="mt-1 text-md font-mono font-semibold">
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