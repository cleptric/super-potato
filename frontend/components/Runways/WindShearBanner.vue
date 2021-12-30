<template>

    <div
        v-if="airport.metar.wind_shear_runways"
        class="rounded-md bg-red-50 py-2 px-3"
    >
        <div class="flex items-center">
            <div class="shrink-0">
                <i class="far fa-md fa-times-circle text-red-400"></i>
            </div>
            <div class="ml-2">
                <h3 class="text-sm font-medium text-red-800">
                    Windshear Runway {{ airport.metar.wind_shear_runways.join(' & ') }}
                </h3>
            </div>
        </div>
    </div>

    <div
        v-if="airport.metar.wind_shear_all_runways"
        class="rounded-md bg-red-50 py-2 px-3"
    >
        <div class="flex items-center">
            <div class="shrink-0">
                <i class="far fa-md fa-times-circle text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                    Windshear all Runways
                </h3>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: 'WindShearBanner',
    props: {
        airport: Object
    },
}
</script>