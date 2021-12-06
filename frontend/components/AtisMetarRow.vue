<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <dl class="mt-3 grid grid-cols-6 rounded-md bg-white overflow-hidden border border-gray-200 divide-y divide-gray-200 divide-y-0 md:divide-x">
            <div class="p-3 text-center">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    ATIS Information
                </dt>
                <dd class="mt-1 text-xl font-semibold text-gray-900 truncate">
                    <template v-if="airport.atis.atis_letter">
                        {{ airport.atis.atis_letter }}
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-3 text-center">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Transition Level
                </dt>
                <dd class="mt-1 text-xl font-semibold text-gray-900 truncate">
                    <template v-if="airport.atis.transition_level">
                        {{ airport.atis.transition_level }}
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-3 text-center">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    QNH
                </dt>
                <dd class="mt-1 text-xl font-semibold text-gray-900 truncate">
                    <div class="flex items-center justify-center">
                        <div class="mr-1">
                            {{ airport.metar.qnh_value }}
                            <span class="text-lg font-medium text-gray-500">
                                {{ airport.metar.qnh_unit }}
                            </span>
                        </div>
                        <template v-if="airport.metar.qnh_trend && airport.metar.qnh_trend === 'up'">
                            <i class="fas fa-arrow-alt-up fa-sm text-green-300"></i>
                        </template>
                        <template v-else-if="airport.metar.qnh_trend && airport.metar.qnh_trend === 'down'">
                            <i class="fas fa-arrow-alt-down fa-sm text-red-300"></i>
                        </template>
                        <template v-else>
                            <i class="fas fa-circle fa-xs text-xs text-blue-300"></i>
                        </template>
                    </div>
                </dd>
            </div>
            <div class="p-3 text-center">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Wind
                </dt>
                <dd class="mt-1 text-xl font-semibold text-gray-900 truncate">
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
            <div class="p-3 text-center">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Maximum
                </dt>
                <dd class="mt-1 text-xl font-semibold text-gray-900 truncate">
                    <template v-if="airport.metar.speed_variations">
                        {{ airport.metar.speed_variations }}kts
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
            <div class="p-3 text-center">
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Conditions
                </dt>
                <dd class="mt-1 text-xl font-semibold text-gray-900 truncate">
                    <template v-if="airport.metar.conditions">
                        {{ airport.metar.conditions }}
                    </template>
                    <template v-else>
                        ---
                    </template>
                </dd>
            </div>
        </dl>
        <!-- <dl class="mt-3 grid grid-cols-6 gap-3">
            <template v-if="!airport.atis.outdated">
                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        ATIS Information
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                        {{ airport.atis.atis_letter }}
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        ATIS Information
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        No data
                    </dd>
                </div>
            </template>

            <template v-if="!airport.atis.outdated">
                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Transition Level
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 truncate xl:text-xl">
                        {{ airport.atis.transition_level }}
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        Transition Level
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        No data
                    </dd>
                </div>
            </template>

            <template v-if="airport.metar.qnh_value && airport.metar.qnh_unit">
                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        QNH
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                        {{ airport.metar.qnh_value }}
                        <span class="text-lg font-medium text-gray-500">
                            {{ airport.metar.qnh_unit }}
                        </span>
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        QNH
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        No data
                    </dd>
                </div>
            </template>

            <template v-if="airport.metar.mean_speed && airport.metar.mean_direction || airport.metar.is_variable && airport.metar.mean_speed">
                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Wind
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                        <template v-if="airport.metar.is_variable">
                            VRB {{ airport.metar.mean_speed }}kts
                        </template>
                        <template v-else>
                            {{ airport.metar.mean_direction.toString().padStart(3, '0') }}° / {{ airport.metar.mean_speed }}kts
                        </template>
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        Wind
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        No data
                    </dd>
                </div>
            </template>

            <div
                v-if="airport.metar.speed_variations"
                class="p-3 bg-white shadow rounded-lg overflow-hidden"
            >
                <dt class="text-sm font-medium text-gray-500 truncate">
                    Maximum
                </dt>
                <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                    {{ airport.metar.speed_variations }}kts
                </dd>
            </div>

            <template v-if="airport.metar.condition">
                <div class="p-3 bg-white shadow rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Conditions
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 xl:text-xl">
                        {{ airport.metar.condition }}
                    </dd>
                </div>
            </template>
            <template v-else>
                <div class="p-3 bg-gray-100 rounded-lg overflow-hidden">
                    <dt class="text-sm font-medium text-gray-400 truncate">
                        Conditions
                    </dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-500 xl:text-xl">
                        No data
                    </dd>
                </div>
            </template>

        </dl> -->
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