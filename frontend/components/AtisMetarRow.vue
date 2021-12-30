<template>
    <div class="max-w-7xl mx-auto px-8">
        <dl class="mt-3 grid grid-cols-7 rounded-md bg-white dark:bg-zinc-900 overflow-hidden border border-gray-200 dark:border-zinc-600 divide-x divide-gray-200 dark:divide-zinc-600">
            <div class="p-2 text-center">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    QNH
                </dt>
                <dd class="mt-1 text-lg font-semibold truncate">
                    <div class="flex items-center justify-center">
                        <div class="mr-1">
                            {{ airport.metar.qnh_value }}
                            <span class="text-lg font-medium text-gray-500 dark:text-zinc-300">
                                {{ airport.metar.qnh_unit }}
                            </span>
                        </div>
                        <template v-if="airport.metar.qnh_trend && airport.metar.qnh_trend === 'up'">
                            <i class="fas fa-arrow-alt-up fa-sm text-green-300"></i>
                        </template>
                        <template v-else-if="airport.metar.qnh_trend && airport.metar.qnh_trend === 'down'">
                            <i class="fas fa-arrow-alt-down fa-sm text-red-300"></i>
                        </template>
                    </div>
                </dd>
            </div>
            <div class="p-2 text-center">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    Wind
                </dt>
                <dd class="mt-1 text-lg font-semibold truncate">
                    <template v-if="airport.metar.is_variable && airport.metar.mean_speed">
                        VRB {{ airport.metar.mean_speed }}kts
                    </template>
                    <template v-else-if="airport.metar.mean_direction && airport.metar.mean_speed">
                        {{ airport.metar.mean_direction.toString().padStart(3, '0') }}° / {{ airport.metar.mean_speed }}kts
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-2 text-center">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    Maximum
                </dt>
                <dd class="mt-1 text-lg font-semibold truncate">
                    <template v-if="airport.metar.speed_variations">
                        {{ airport.metar.speed_variations }}kts
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-2 text-center">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    Temperature
                </dt>
                <dd class="mt-1 text-lg font-semibold truncate">
                    <template v-if="airport.metar.temperature  !== null && airport.metar.dew_point !== null">
                        {{ airport.metar.temperature }} / {{ airport.metar.temperature }}
                        <template v-if="airport.metar.temperature <= 10">
                            <i class="far fa-sm fa-snowflakes text-blue-300"></i>
                        </template>
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-2 text-center">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    ATIS Information
                </dt>
                <dd class="mt-1 text-lg font-semibold truncate">
                    <template v-if="airport.atis.atis_letter">
                        {{ airport.atis.atis_letter }}
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-2 text-center">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    Transition Level
                </dt>
                <dd class="mt-1 text-lg font-semibold truncate">
                    <template v-if="airport.atis.transition_level">
                        {{ airport.atis.transition_level }}
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-2 text-center">
                <dt class="text-xs font-medium text-gray-500 dark:text-zinc-300">
                    Conditions
                </dt>
                <dd class="mt-1 text-lg font-semibold truncate">
                    <template v-if="airport.metar.conditions">
                        {{ airport.metar.conditions }}
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
    name: 'AtisMetarRow',
    props: {
        airport: Object
    },
}
</script>