<template>

    <div
        v-if="airport.missed_approach"
        class="rounded-md bg-yellow-50 py-2 px-3"
    >
        <div class="flex items-center">
            <div class="shrink-0">
                <i class="far fa-md fa-plane-departure text-yellow-400"></i>
            </div>
            <div class="ml-2">
                <h3 class="text-sm font-medium text-yellow-800">
                    Missed Approach
                </h3>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: 'MissedApproachBanner',
    props: {
        airport: Object
    },
}
</script>